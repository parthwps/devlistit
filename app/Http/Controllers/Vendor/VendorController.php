<?php
namespace App\Http\Controllers\Vendor;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\MiscellaneousController;
use App\Models\BasicSettings\Basic;
use App\Models\BasicSettings\MailTemplate;
use App\Models\Car;
use App\Models\Language;
use App\Models\Membership;
use App\Models\Package;
use App\Models\SupportTicket;
use App\Models\Vendor;
use App\Models\VendorInfo;
use App\Models\CountryArea;
use App\Rules\MatchEmailRule;
use App\Rules\MatchOldPasswordRule;
use App\Models\Car\Wishlist;
use Carbon\Carbon;
use Config;
use DateTime;
use App\Models\Car\Category; 
use App\Models\SaveSearch;
use App\Models\BrowsingHistory;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use PHPMailer\PHPMailer\PHPMailer;
use Tco\TwocheckoutFacade;

class VendorController extends Controller
{
    //signup
    public function signup()
    {
        $misc = new MiscellaneousController();

        $language = $misc->getLanguage();

        $queryResult['seoInfo'] = $language->seoInfo()->select('meta_keywords_vendor_signup', 'meta_description_vendor_signup')->first();

        $queryResult['pageHeading'] = $misc->getPageHeading($language);

        $queryResult['recaptchaInfo'] = Basic::select('google_recaptcha_status')->first();

        $queryResult['bgImg'] = $misc->getBreadcrumb();

        return view('vendors.auth.register', $queryResult);
    }
    
    function recentlyViewed()
    {
        $misc = new MiscellaneousController();
        $bgImg = $misc->getBreadcrumb();
        $language = $misc->getLanguage();
        $information['language'] = $language;
        $information['pageHeading'] = $misc->getPageHeading($language);
        
        $queryResult['language'] = $language;
        $user_id = Auth::guard('vendor')->user()->id;
        $car_ids = BrowsingHistory::where('user_id' , $user_id)->orderBy('id', 'desc')->pluck('ad_id');
        
        if(count($car_ids) > 0 )
        {
          $wishlists = Car::whereIn('id' ,  $car_ids)->where('status' , 1)->paginate(15);  
          $information['cars'] = $wishlists;
        }
        else
        {
            $information['cars'] = null;
        }
        
        $information['bgImg'] = $bgImg;
        return view('vendors.recently-view', $information);
    }
    
     public function vatVerify($vatnumber)
    {
           
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.vatcheckapi.com/v2/check?vat_number='.$vatnumber.'&apikey='.env('VAT_API_KEY').'',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
            
            $response = json_decode($response , true);
            
            if(empty($response['registration_info']['is_registered']))
            {
                return false;
            }
            
            if($response['registration_info']['is_registered'] == false)
            {
                return false;
            }
        
            if($response['registration_info']['is_registered'] == true)
            {
                return true;
            }
            else
            {
               return false; 
            }
        }
    
    
    public function VerifyOtp(Request $request)
    {
        $misc = new MiscellaneousController();

        $language = $misc->getLanguage();

        $queryResult['seoInfo'] = $language->seoInfo()->select('meta_keywords_vendor_signup', 'meta_description_vendor_signup')->first();

        $queryResult['pageHeading'] = $misc->getPageHeading($language);

        $queryResult['bgImg'] = $misc->getBreadcrumb();
        return view('vendors.auth.otpverify', $queryResult);
    }
    
    public function SendCode(Request $request)
    {
       
                $code = mt_rand(100000,999999);

                $ch = curl_init();
                $url = "https://api.smsgatewayapi.com/v1/message/send";
                $client_id = "894736944329458124966"; // Your API client ID (required)
                $client_secret = "BNrJEwLLQ7I1Y5NHq7UC2"; // Your API client secret (required)
                if(!empty($request->country_code)) 
                {
                    $phoneNnumber = $request->country_code.$request->phone_number;
                } 
                else
                {
                    $phoneNnumber =$request->phone_number;   
                }
                
                $data = [
                    'message' => "Your ListIt verification code is  $code . Please do not provide this code to any other person requesting it.", //Message (required)
                    'to' => "$phoneNnumber", //Receiver (required)
                    'sender' => "ListIt" //Sender (required)
                ];
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_VERBOSE, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "X-Client-Id: $client_id",
                    "X-Client-Secret: $client_secret",
                    "Content-Type: application/json",
                ]);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	            $response = curl_exec($ch); 
                $data = json_decode($response, true);
                //print_r($response); exit;
                if(isset($data['messageid'])) {                
                $vendor  = Vendor::where('email', Session::get('vendorEmail'))->first();
                $in['phone'] = $phoneNnumber;
                $in['phone_verified'] = 0;
                $vendor->update($in);
                Session::put('verifycode', $code);
                return response()->json(['status' => 'success', 'data'=> $code , 'phone'=> $phoneNnumber], 200);
                } else{
                    return response()->json(['status' => 'error', 'data'=> $code, 'phone'=> $phoneNnumber], 200);
                }
    }

    public function VerifyCode(Request $request)
    {
        if(Session::get('verifycode') == $request->code) {
            if(session()->has('vendorEmail')) {
                $vendor  = Vendor::where('email', Session::get('vendorEmail'))->first();
            } else{
            $vendor  = Vendor::where('email', Auth::guard('vendor')->user()->email)->first();
            }
            $in['phone_verified'] = 1;
            $vendor->update($in);
            Session::forget('verifycode');
            if(isset($request->profileverify)) {
            Session::flash('success', 'Your phone number is verified now.');
            }else{
                Session::flash('success', 'Your new ListIt account is now active!'); 
            }
            return response()->json(['status' => 'success', 'data'=> $request->phone_number, "message"=>'Your new ListIt account is now active'], 200);
            return redirect()->route('index');
        } else {

            if(isset($request->profileverify)) {
                Session::flash('error', 'Unable to verify your phone this time, tray again later!.');
                }

            //Session::forget('verifycode');
            return response()->json(['status' => 'error', 'data'=> $request->phone_number, "message"=>'Unable to verify your account this time'], 200);
        }
    }
    public function create(Request $request)
    {
        //print_r($request->post()); exit;
        //echo "hello"; exit;
        $rules = [
        'username' => 'required',
        'email' => 'required|email|unique:vendors',
        'password' => 'required|min:6',
        'password_confirmation' => 'required|same:password',
        ];


        $str_arr = explode ("@", $request->email);
        $userName= $str_arr[0];

        // $info = Basic::select('google_recaptcha_status')->first();
        // if ($info->google_recaptcha_status == 1) {
        //     $rules['g-recaptcha-response'] = 'required|captcha';
        // }

        $messages = [];

        // if ($info->google_recaptcha_status == 1) {
        //     $messages['g-recaptcha-response.required'] = 'Please verify that you are not a robot.';
        //     $messages['g-recaptcha-response.captcha'] = 'Captcha error! try again later or contact site admin.';
        // }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        if ($request->username == 'admin') {
            Session::flash('username_error', 'You can not use admin as a username!');
            return redirect()->back();
        }

        $in = $request->all();
        $setting = DB::table('basic_settings')->where('uniqid', 12345)->select('vendor_email_verification', 'vendor_admin_approval')->first();

        if ($setting->vendor_email_verification == 1) {
            $headermail =   view('email.mailheader')->render();
            $footermail =  view('email.mailfooter')->render();                                       
            // first, get the mail template information from db
            $mailTemplate = MailTemplate::where('mail_type', 'verify_email')->first();

            $mailSubject = $mailTemplate->mail_subject;
            $mailBody = $mailTemplate->mail_body;

            // second, send a password reset link to user via email
            $info = DB::table('basic_settings')
                ->select('website_title', 'smtp_status', 'smtp_host', 'smtp_port', 'encryption', 'smtp_username', 'smtp_password', 'from_mail', 'from_name')
                ->first();

            $token =  $request->email;

            $link = '<center style="margin-top: 2rem;"><a href=' . url("customer/email/verify?token=" . $token) . ' style="background: #006dea;color: white;padding: 1rem;text-decoration: none;border-radius: 5px;">Click Here To Verify Listit Email</a></center> ';
            $mailBody = str_replace('{username}', $request->username, $mailBody);
            $mailBody = str_replace('{verification_link}', $link, $mailBody);
            $mailBody = str_replace('{website_title}', $info->website_title, $mailBody);

            $headermail .=$mailBody;
            $headermail .= $footermail;
            $data = [
                'subject' => $mailSubject,
                'to' => $request->email,
                'body' => $headermail,
            ];

            // if smtp status == 1, then set some value for PHPMailer
            if ($info->smtp_status == 1) {
                try {
                    $smtp = [
                        'transport' => 'smtp',
                        'host' => $info->smtp_host,
                        'port' => $info->smtp_port,
                        'encryption' => $info->encryption,
                        'username' => $info->smtp_username,
                        'password' => $info->smtp_password,
                        'timeout' => null,
                        'auth_mode' => null,
                    ];
                    Config::set('mail.mailers.smtp', $smtp);
                } catch (\Exception $e) {
                    Session::flash('error', $e->getMessage());
                    return back();
                }
            }

            // finally add other informations and send the mail
            try {
                Mail::send([], [], function (Message $message) use ($data, $info) {
                    $fromMail = $info->from_mail;
                    $fromName = $info->from_name;
                    $message->to($data['to'])
                        ->subject($data['subject'])
                        ->from($fromMail, $fromName)
                        ->html($data['body'], 'text/html');
                });
              //  efdm uzfl fenk czvd 
                Session::flash('success', 'A verification mail has been sent to your email address');
            } catch (\Exception $e) {
                //echo "<pre>";
               // print_r($e); exit;
                Session::flash('message', 'Mail could not be sent!');
                Session::flash('alert-type', 'error');
                return redirect()->back();
            }

            $in['status'] = 0;
        } else {
            //Session::flash('success', 'Sign up successfully completed.Please Login Now');
        }
        if ($setting->vendor_admin_approval == 1) {
            $in['status'] = 0;
        }

        if ($setting->vendor_admin_approval == 0 && $setting->vendor_email_verification == 0) {
            $in['status'] = 1;
        }

        $in['password'] = Hash::make($request->password);
       // $in['trader'] = $request->traderstatus;
       $in['phone'] = $request->phone;
         
       $in['username'] = $userName;
       if ($request->notification_allowed){
       $notification =1;
       }
       else {
       $notification =0;
       }
       $in['notification_allowed'] = $notification;
        //print_r($in); exit;
        $vendor = Vendor::create($in);
        Session::put('vendorEmail', $request->email);

        $misc = new MiscellaneousController();

        $language = $misc->getLanguage();
        

        $in['language_id'] = $language->id;
        $in['vendor_id'] = $vendor->id;
        $in['name'] = $request->username;
        
        VendorInfo::create($in);

        return redirect()->route('vendor.otpverify');
    }

    //login
    public function login(Request $request)
    {
        if(url()->previous() == route('vendor.login') )
        {
          Session::put('previousUrl', url('/')); 
        }
        else
        {
          Session::put('previousUrl', url()->previous()); 
        }
        
        $misc = new MiscellaneousController();
        
        $language = $misc->getLanguage();
        
        $queryResult['seoInfo'] = $language->seoInfo()->select('meta_keywords_vendor_login', 'meta_description_vendor_login')->first();
        
        $queryResult['pageHeading'] = $misc->getPageHeading($language);
        
        $queryResult['bgImg'] = $misc->getBreadcrumb();
        
        $queryResult['bs'] = Basic::query()->select('google_recaptcha_status', 'facebook_login_status', 'google_login_status')->first();
        
        return view('vendors.auth.login', $queryResult);
    }
    //wishlist
    
      public function mywishlist(Request $request)
      {
            $misc = new MiscellaneousController();
            $bgImg = $misc->getBreadcrumb();
            $language = $misc->getLanguage();
            $information['language'] = $language;
            $information['pageHeading'] = $misc->getPageHeading($language);
            
            $queryResult['language'] = $language;
            $user_id = Auth::guard('vendor')->user()->id;
            
            $query = Car::with('car_content')
            ->join('wishlists', 'wishlists.car_id', '=', 'cars.id')
            ->where('wishlists.user_id', $user_id)
            ->select(['cars.*', 'wishlists.id as wishlist_id', 'wishlists.car_id', 'wishlists.user_id']);
            
            // Check if category_id is present in the request and add the condition
            if (!empty($request->category_id) && $request->has('category_id')) {
            $category_id = $request->category_id;
            $query->whereHas('car_content', function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
            });
            }
            
            // Apply sorting based on filter_type
            if ($request->filter_type == 'recent') {
            $query->orderBy('cars.created_at', 'desc');
            } elseif ($request->filter_type == 'lowest_price') {
            $query->orderByRaw('COALESCE(NULLIF(cars.previous_price, 0), cars.price) ASC');
            } elseif ($request->filter_type == 'highest_price') {
            $query->orderByRaw('COALESCE(NULLIF(cars.previous_price, 0), cars.price) DESC');
            } else {
            // Default ordering if no filter_type is provided or matched
            $query->orderBy('cars.id', 'desc');
            }
            
            $wishlists = $query->get();
            
            $mainCategoryIds = collect($wishlists)->map(function($item) {
            return $item->car_content->main_category_id;
            })->unique();
            
            
            $categorries = Category::whereIn('parent_id', $mainCategoryIds)->get();
            
            if($categorries->count() > 0 )
            {
                $information['categories'] =  $categorries;
            }
            else
            {
               $information['categories'] = Category::where('parent_id', 24)->get(); 
            }
            
            $information['bgImg'] = $bgImg;
            $information['cars'] = $wishlists;
            return view('vendors.wishlist', $information);
      }

    //authenticate
    public function authentication(Request $request)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required'
        ];
        // $info = Basic::select('google_recaptcha_status')->first();
        // if ($info->google_recaptcha_status == 1) {
        //     $rules['g-recaptcha-response'] = 'required|captcha';
        // }
        
       
        $messages = [];

        // if ($info->google_recaptcha_status == 1) {
        //     $messages['g-recaptcha-response.required'] = 'Please verify that you are not a robot.';
        //     $messages['g-recaptcha-response.captcha'] = 'Captcha error! try again later or contact site admin.';
        // }

        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        

        if (Auth::guard('vendor')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) 
        {
            $authAdmin = Auth::guard('vendor')->user();
            //print_r($authAdmin); exit;

            $setting = DB::table('basic_settings')->where('uniqid', 12345)->select('vendor_email_verification', 'vendor_admin_approval')->first();
            
              if( $authAdmin->vendor_type == 'dealer' )
            {
                   Auth::guard('vendor')->logout(); 
                 
                   return redirect()->back()->with('error', 'Your account is not linked with any customer account');
            }
            
            if($authAdmin->status == 0)
            {
                Session::flash('error', 'Sorry, your account has been deactivated');
                
                Auth::guard('web')->logout();

                return redirect()->route('page.crash');
            }
            
            // check whether the admin's account is active or not
            if ($setting->vendor_email_verification == 1 && $authAdmin->email_verified_at == NULL && $authAdmin->status == 0) {
                Session::flash('error', 'Please verify your email address');

                // logout auth admin as condition not satisfied
                Auth::guard('vendor')->logout();

                return redirect()->back();
            } elseif ($setting->vendor_email_verification == 0 && $setting->vendor_admin_approval == 1) {
                Session::put('secret_login', 0);
                Session::put('vendor_login_type', $authAdmin->trader);
                Session::put('vendor_profcompleted', $authAdmin->profile_completed);
                Session::put('is_dealer', $authAdmin->is_dealer);
                session()->forget('dealer_loggedin');
               // return redirect()->route('vendor.dashboard');
                 return redirect()->intended();
            } else {
                Session::put('secret_login', 0);
                Session::put('vendor_login_type', $authAdmin->trader);
                Session::put('vendor_profcompleted', $authAdmin->profile_completed);
                Session::put('is_dealer', $authAdmin->is_dealer);
                session()->forget('dealer_loggedin');
                //return redirect()->route('vendor.dashboard');
                
                 $previousUrl = Session::pull('previousUrl', '/');
                 
                 if(!empty($previousUrl)  &&  $previousUrl != url('customer/login')  && $previousUrl != url('customer/signup') )
                 {
                   Session::forget('previousUrl');
                    return redirect()->intended($previousUrl);  
                 }
                    
                    
                return redirect()->route('index');
                // If the user is authenticated successfully
                    // Redirect the user to the stored URL or home page
                   
                /*  //return redirect()->intended();
                 if ($request->session()->has('url.intended') && $request->session()->get('url.intended') == route('vendor.login')) {
                    return redirect()->route('home');
                }
        
                return redirect()->intended($this->redirectPath()); */
            }
        } else {
            return redirect()->back()->with('error', 'Incorrect email or password');
        }
    }
    //confirm_email'
    public function confirm_email()
    {
        $email = request()->input('token');
        $user = Vendor::where('email', $email)->first();
        $user->email_verified_at = now();
        $setting = DB::table('basic_settings')->where('uniqid', 12345)->select('vendor_admin_approval')->first();
        if ($setting->vendor_admin_approval != 1) {
            $user->status = 1;
        }
        $user->save();
        Auth::guard('vendor')->login($user);
        return redirect()->route('vendor.dashboard');
    }
    public function logout(Request $request)
    {
        Auth::guard('vendor')->logout();
        Session::forget('secret_login');
        return redirect()->route('vendor.login');
    }

   

    public function dashboard()
    {
        $misc = new MiscellaneousController();
        $vendor_id = Auth::guard('vendor')->user()->id;
        $information['totalCars'] = Car::query()->where('vendor_id', $vendor_id)->count();
        $information['userinfo'] = VendorInfo::query()->where('vendor_id', $vendor_id)->first();

        $information['admin_setting'] = DB::table('basic_settings')->where('uniqid', 12345)->select('vendor_admin_approval', 'admin_approval_notice')->first();

        $support_status = DB::table('support_ticket_statuses')->first();
        if ($support_status->support_ticket_status == 'active') {
            $total_support_tickets = SupportTicket::where([['user_id', Auth::guard('vendor')->user()->id], ['user_type', 'vendor']])->get()->count();
            $information['total_support_tickets'] = $total_support_tickets;
        }
        $information['support_status'] = $support_status;
        $information['admin_setting'] = DB::table('basic_settings')->where('uniqid', 12345)->select('vendor_admin_approval', 'admin_approval_notice')->first();

        //total car posts
        $totalCars = DB::table('cars')
            ->select(DB::raw('month(created_at) as month'), DB::raw('count(id) as total'))
            ->groupBy('month')
            ->where('vendor_id', $vendor_id)
            ->whereYear('created_at', '=', date('Y'))
            ->get();
        //total car visitors
        $totalVisitors = DB::table('visitors')
            ->select(DB::raw('month(date) as month'), DB::raw('count(id) as total'))
            ->groupBy('month')
            ->where('vendor_id', $vendor_id)
            ->whereYear('date', '=', date('Y'))
            ->get();


        $months = [];
        $totalCarArr = [];
        $totalVisitorArr = [];


        //event icome calculation
        for ($i = 1; $i <= 12; $i++) {
            // get all 12 months name
            $monthNum = $i;
            $dateObj = DateTime::createFromFormat('!m', $monthNum);
            $monthName = $dateObj->format('M');
            array_push($months, $monthName);

            // get all 12 months's car posts
            $carFound = false;
            foreach ($totalCars as $totalCar) {
                if ($totalCar->month == $i) {
                    $carFound = true;
                    array_push($totalCarArr, $totalCar->total);
                    break;
                }
            }
            if ($carFound == false) {
                array_push($totalCarArr, 0);
            }

            // get all 12 months's visitors
            $visitorFound = false;
            foreach ($totalVisitors as $totalVisitor) {
                if ($totalVisitor->month == $i) {
                    $visitorFound = true;
                    array_push($totalVisitorArr, $totalVisitor->total);
                    break;
                }
            }
            if ($visitorFound == false) {
                array_push($totalVisitorArr, 0);
            }
        }

        $payment_logs = Membership::where('vendor_id', $vendor_id)->get()->count();

        //package start
        $nextPackageCount = Membership::query()->where([
            ['vendor_id', Auth::guard('vendor')->user()->id],
            ['expire_date', '>=', Carbon::now()->toDateString()]
        ])->whereYear('start_date', '<>', '9999')->where('status', '<>', 2)->count();
        //current package
        $information['current_membership'] = Membership::query()->where([
            ['vendor_id', Auth::guard('vendor')->user()->id],
            ['start_date', '<=', Carbon::now()->toDateString()],
            ['expire_date', '>=', Carbon::now()->toDateString()]
        ])->where('status', 1)->whereYear('start_date', '<>', '9999')->first();
        if ($information['current_membership'] != null) {
            $countCurrMem = Membership::query()->where([
                ['vendor_id', Auth::guard('vendor')->user()->id],
                ['start_date', '<=', Carbon::now()->toDateString()],
                ['expire_date', '>=', Carbon::now()->toDateString()]
            ])->where('status', 1)->whereYear('start_date', '<>', '9999')->count();
            if ($countCurrMem > 1) {
                $information['next_membership'] = Membership::query()->where([
                    ['vendor_id', Auth::guard('vendor')->user()->id],
                    ['start_date', '<=', Carbon::now()->toDateString()],
                    ['expire_date', '>=', Carbon::now()->toDateString()]
                ])->where('status', '<>', 2)->whereYear('start_date', '<>', '9999')->orderBy('id', 'DESC')->first();
            } else {
                $information['next_membership'] = Membership::query()->where([
                    ['vendor_id', Auth::guard('vendor')->user()->id],
                    ['start_date', '>', $information['current_membership']->expire_date]
                ])->whereYear('start_date', '<>', '9999')->where('status', '<>', 2)->first();
            }
            $information['next_package'] = $information['next_membership'] ? Package::query()->where('id', $information['next_membership']->package_id)->first() : null;
        } else {
            $information['next_package'] = null;
        }
        $information['current_package'] = $information['current_membership'] ? Package::query()->where('id', $information['current_membership']->package_id)->first() : null;
        $information['package_count'] = $nextPackageCount;
        //package start end

        $information['monthArr'] = $months;
        $information['totalCarsArr'] = $totalCarArr;
        $information['visitorArr'] = $totalVisitorArr;
        $information['payment_logs'] = $payment_logs;
        $information['bgImg'] = $misc->getBreadcrumb();

        return view('vendors.index', $information);
    }

    //change_password
    public function change_password()
    {
        $information = [];
        $misc = new MiscellaneousController();
        $information['bgImg'] = $misc->getBreadcrumb();
        return view('vendors.auth.change-password',$information);
    }

    //update_password
    public function updated_password(Request $request)
    {
        $rules = [
            'current_password' => [
                'required',
                new MatchOldPasswordRule('vendor')

            ],
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required'
        ];

        $messages = [
            'new_password.confirmed' => 'Password confirmation does not match.',
            'new_password_confirmation.required' => 'The confirm new password field is required.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        $vendor = Auth::guard('vendor')->user();

        $vendor->update([
            'password' => Hash::make($request->new_password)
        ]);

        Session::flash('success', 'Password updated successfully!');

        return response()->json(['status' => 'success'], 200);
    }

    // Verify phone number
    public function verifyPhone(Request $request)
    {
        $code = mt_rand(100000,999999);

        $ch = curl_init();
       $url = "https://api.smsgatewayapi.com/v1/message/send";
       $client_id = "894736944329458124966"; // Your API client ID (required)
       $client_secret = "BNrJEwLLQ7I1Y5NHq7UC2"; // Your API client secret (required)
       
        $phoneNnumber = str_replace('+' , '' , $request->code).$request->phone;   
      
       $data = [
           'message' => "Your ListIt verification code is  $code . Please do not provide this code to any other person requesting it.", //Message (required)
           'to' => "$phoneNnumber", //Receiver (required)
           'sender' => "ListIt" //Sender (required)
       ];
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_VERBOSE, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, [
           "X-Client-Id: $client_id",
           "X-Client-Secret: $client_secret",
           "Content-Type: application/json",
       ]);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
       $response = curl_exec($ch); 
       $data = json_decode($response, true);
       //print_r($response); exit;
       if(isset($data['messageid'])) {                
       $vendor  = Vendor::where('email', Auth::guard('vendor')->user()->email)->first();
       $in['phone'] = $request->phone;
       $in['country_code'] = $request->code;
       $in['phone_verified'] = 0;
       $vendor->update($in); 
       Session::put('verifycode', $code);
       return response()->json(['status' => 'success', 'data'=> $code , 'phone'=> $phoneNnumber], 200);
      } 
       else{
           return response()->json(['status' => 'error', 'data'=> $code, 'phone'=> $phoneNnumber], 200);
       }

    }
   
    
    
    //edit_profile
    public function edit_profile()
    {
        $information = [];
        $misc = new MiscellaneousController();

        $language = $misc->getLanguage();

        $information['language'] = $language;
        $information['languages'] = Language::get();

        $vendor_id = Auth::guard('vendor')->user()->id;
        $information['vendor'] = Vendor::with('vendor_info')->where('id', $vendor_id)->first();
        //print_r($information['vendor']);
        $information['bgImg'] = $misc->getBreadcrumb();
        $data = CountryArea::where('status', 1)->orderBy('name', 'asc')->get();
        
        $information['openingHour'] = DB::table('opening_hours')->where('vendor_id' , $vendor_id)->get()->keyBy('day_of_week')->toArray();
        
        $information['country_codes'] = DB::table('phone_country_codes')->get();
        
        $information['countryArea'] = $data;
        return view('vendors.auth.edit-profile', $information);
    }
    
    
    //update_profile
    public function update_profile(Request $request, Vendor $vendor)
    {
        $id = Auth::guard('vendor')->user()->id;
        
        $rules = [
            'phone' => 'required', 
            'c_code' => 'required', 
        ];

        if ($request->hasFile('photo')) {
            //$rules['photo'] = 'mimes:png,jpeg,jpg|dimensions:min_width=80,max_width=80,min_width=80,min_height=80';
            $rules['photo'] = 'mimes:png,jpeg,jpg';
        }

        $languages = Language::get();
        foreach ($languages as $language) {
           // $rules[$language->code . '_name'] = 'required';
            $rules[$language->code . '_city'] = 'required';
           // $rules[$language->code . '_address'] = 'required';
        }

        $messages = [];
        
        $messages['c_code.required'] = 'Country Code Requried';
        foreach ($languages as $language) {
            //$messages[$language->code . '_name.required'] = 'Name is required.';
            $messages[$language->code . '_city.required'] = 'City is required.';
           // $messages[$language->code . '_address.required'] = 'Address is required.';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()
            ], 400);
        }

        $in = $request->all();
        $vendor  = Vendor::where('id', $id)->first();
        
        
        if ($request->traderstatus == 1) 
        {    
            if(!empty($request['vat_number']))
            {
                if($vendor->vendor_info->vatVerified != 1) 
                {
                    if($this->vatVerify($request['vat_number'])== false)
                    {
                         Session::flash('success', 'Vat Number Not Verified.');
                         return Response::json(['status' => 'error'], 200);
                    }
                    
                }   
            }
        }
        
        $file = $request->file('photo');
        if ($file) {
            $extension = $file->getClientOriginalExtension();
            $directory = public_path('assets/admin/img/vendor-photo/');
            $fileName = uniqid() . '.' . $extension;
            @mkdir($directory, 0775, true);
            $file->move($directory, $fileName);

            @unlink(public_path('assets/admin/img/vendor-photo/') . $vendor->photo);
            $in['photo'] = $fileName;
        }
        
        
        
        $in['trader'] = $request->traderstatus;

        if ($request->show_email_addresss) {
            $in['show_email_addresss'] = 1;
        } else {
            $in['show_email_addresss'] = 0;
        }
        if ($request->show_phone_number) {
            $in['show_phone_number'] = 1;
        } else {
            $in['show_phone_number'] = 0;
        }
        if ($request->show_contact_form) {
            $in['show_contact_form'] = 1;
        } else {
            $in['show_contact_form'] = 0;
        }
        
        if ($request->phone) 
        {
            $in['phone'] = $request->phone;
        }
        
        if ($request->also_whatsapp == 'on') 
        {
            $in['also_whatsapp'] =1;
        }
        else
        {
            $in['also_whatsapp'] = 0; 
        }
        
        if ($request->c_code) 
        {
           $in['country_code'] = $request->c_code;
        }
        
        $in['notification_news_offer'] = request()->has('notification_news_offer') ? 1 : 0;
        $in['notification_saved_search'] = request()->has('notification_saved_search') ? 1 : 0;
        $in['notification_tips'] = request()->has('notification_tips') ? 1 : 0;
        $in['notification_recommendations'] = request()->has('notification_recommendations') ? 1 : 0;
        $in['notification_saved_ads'] = request()->has('notification_saved_ads') ? 1 : 0;

        $vendor->update($in);
        
        
        $languages = Language::get();
        $vendor_id = $vendor->id;
        foreach ($languages as $language) {
            $vendorInfo = VendorInfo::where('vendor_id', $vendor_id)->where('language_id', $language->id)->first();
            if ($vendorInfo == NULL) {
                $vendorInfo = new VendorInfo();
            }
            $vendorInfo->language_id = $language->id;
            $vendorInfo->vendor_id = $vendor_id;
            if(!empty($request['name'])) {
            $vendorInfo->name = $request['name'];
            }
            $vendorInfo->business_name = $request['business_name'];
            $vendorInfo->vat_number = $request['vat_number'];
            $vendorInfo->business_address = $request['business_address'];
            $vendorInfo->country = $request[$language->code . '_country'];
            $vendorInfo->city = $request[$language->code . '_city'];
            $vendorInfo->state = $request[$language->code . '_state'];
            $vendorInfo->zip_code = $request[$language->code . '_zip_code'];
            $vendorInfo->address = $request[$language->code . '_address'];
            $vendorInfo->details = $request[$language->code . '_details'];
            $vendorInfo->save();
        }



        Session::flash('success', 'Customer updated successfully!');

        return Response::json(['status' => 'success'], 200);
    }

    public function changeTheme(Request $request)
    {
        Session::put('vendor_theme_version', $request->vendor_theme_version);
        return redirect()->back();
    }
    //forget_passord
    public function forget_passord()
    {
        $misc = new MiscellaneousController();

        $language = $misc->getLanguage();

        $queryResult['seoInfo'] = $language->seoInfo()->select('meta_keywords_vendor_forget_password', 'meta_descriptions_vendor_forget_password')->first();

        $queryResult['pageHeading'] = $misc->getPageHeading($language);

        $queryResult['bgImg'] = $misc->getBreadcrumb();
        $queryResult['bs'] = Basic::query()->select('google_recaptcha_status', 'facebook_login_status', 'google_login_status')->first();
        return view('vendors.auth.forget-password', $queryResult);
    }
    //forget_mail
    public function forget_mail(Request $request)
    {
        $rules = [
            'email' => [
                'required',
                'email:rfc,dns',
                new MatchEmailRule('vendor')
            ]
        ];

        $info = Basic::select('google_recaptcha_status')->first();
        if ($info->google_recaptcha_status == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $messages = [];

        if ($info->google_recaptcha_status == 1) {
            $messages['g-recaptcha-response.required'] = 'Please verify that you are not a robot.';
            $messages['g-recaptcha-response.captcha'] = 'Captcha error! try again later or contact site admin.';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Vendor::where('email', $request->email)->first();

        // first, get the mail template information from db
        $mailTemplate = MailTemplate::where('mail_type', 'reset_password')->first();
        $mailSubject = $mailTemplate->mail_subject;
        $mailBody = $mailTemplate->mail_body;

        // second, send a password reset link to user via email
        $info = DB::table('basic_settings')
            ->select('website_title', 'smtp_status', 'smtp_host', 'smtp_port', 'encryption', 'smtp_username', 'smtp_password', 'from_mail', 'from_name')
            ->first();

        $name = $user->username;
        $token =  Str::random(32);
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
        ]);

        $link = '<center style="margin-top: 2rem;"><a href=' . url("customer/reset-password?token=" . $token) . ' style="background: #006dea;color: white;padding: 1rem;text-decoration: none;border-radius: 5px;">Reset Your Listit Password</a></center>';

        $mailBody = str_replace('{customer_name}', $name, $mailBody);
        $mailBody = str_replace('{password_reset_link}', $link, $mailBody);
        $mailBody = str_replace('{website_title}', $info->website_title, $mailBody);

        $data = [
            'to' => $request->email,
            'subject' => $mailSubject,
            'body' => $mailBody,
        ];

        // if smtp status == 1, then set some value for PHPMailer
        if ($info->smtp_status == 1) {
            try {
                $smtp = [
                    'transport' => 'smtp',
                    'host' => $info->smtp_host,
                    'port' => $info->smtp_port,
                    'encryption' => $info->encryption,
                    'username' => $info->smtp_username,
                    'password' => $info->smtp_password,
                    'timeout' => null,
                    'auth_mode' => null,
                ];
                Config::set('mail.mailers.smtp', $smtp);
            } catch (\Exception $e) {
                Session::flash('error', $e->getMessage());
                return back();
            }
        }

        // finally add other informations and send the mail
        try {
            Mail::send([], [], function (Message $message) use ($data, $info) {
                $fromMail = $info->from_mail;
                $fromName = $info->from_name;
                $message->to($data['to'])
                    ->subject($data['subject'])
                    ->from($fromMail, $fromName)
                    ->html($data['body'], 'text/html');
            });
            
            Session::flash('success', 'A mail has been sent to your email address');
            
            $email = $user->email;
            return view('vendors.auth.reset_password_custom', compact('email'));
        } 
        catch (\Exception $e) 
        {
            Session::flash('error', 'Mail could not be sent!');
        }

        // store user email in session to use it later
        $request->session()->put('userEmail', $user->email);
        return redirect()->back();
    }
    //reset_password
    public function reset_password()
    {
        $misc = new MiscellaneousController();

        $language = $misc->getLanguage();

        $queryResult['seoInfo'] = $language->seoInfo()->select('meta_keywords_vendor_forget_password', 'meta_descriptions_vendor_forget_password')->first();

        $queryResult['bgImg'] = $misc->getBreadcrumb();
        return view('vendors.auth.reset-password', $queryResult);
    }
    //update_password
    public function update_password(Request $request)
    {
        $rules = [
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required'
        ];

        $messages = [
            'new_password.confirmed' => 'Password confirmation failed.',
            'new_password_confirmation.required' => 'The confirm new password field is required.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $reset = DB::table('password_resets')->where('token', $request->token)->first();
        $email = $reset->email;

        $vendor = Vendor::where('email',  $email)->first();

        $vendor->update([
            'password' => Hash::make($request->new_password)
        ]);
        DB::table('password_resets')->where('token', $request->token)->delete();
        Session::flash('success', 'Reset Your Password Successfully Completed.Please Login Now');

        return redirect()->route('vendor.login');
    }
    public function payment_log(Request $request)
    {
       // $information = [];
       //echo Auth::guard('vendor')->user()->id;  exit;
        $misc = new MiscellaneousController();
        
        $search = $request->search;
        $data['memberships'] = Membership::query()->when($search, function ($query, $search) {
            return $query->where('transaction_id', 'like', '%' . $search . '%');
        })
            ->where('vendor_id', Auth::guard('vendor')->user()->id)
            ->orderBy('id', 'DESC')
            ->paginate(10);
            $data['bgImg'] = $misc->getBreadcrumb();
        return view('vendors.payment_log', $data);
    }
    
    public function saveSearch(Request $request)
    {
       $misc = new MiscellaneousController();
        $data['savesearchers'] = SaveSearch::where('user_id', Auth::guard('vendor')->user()->id)
            ->orderBy('id', 'DESC')
            ->paginate(10);
            
            $data['bgImg'] = $misc->getBreadcrumb();
        return view('vendors.savesearchers', $data);
    }
    
    public function deleteSaveSearch($id)
    {
        SaveSearch::where('id' , $id)->delete();
        Session::flash('success', 'Your search has been removed.');
        return redirect()->back();
    }
    
    public function transaction(Request $request)
    {
        $search = $request->search;
        $data['memberships'] = Membership::query()
            ->where('admin_id', Auth::guard('vendor')->user()->id)->orderBy('expire_date', 'DESC')->paginate(10);
        return view('admin.transaction.index', $data);
    }
}
