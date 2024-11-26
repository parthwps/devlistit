<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\MiscellaneousController;
use App\Http\Helpers\BasicMailer;
use App\Models\BasicSettings\Basic;
use App\Models\BasicSettings\MailTemplate;
use App\Models\Car\Wishlist;
use App\Models\Vendor;
use App\Models\VendorInfo;
use App\Rules\MatchOldPasswordRule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Socialite\Facades\Socialite;
use App\Rules\MatchEmailRule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use PHPMailer\PHPMailer\PHPMailer;
use Str;
use App\Models\User;
use App\Models\SaveSearch;
use App\Models\Car;
use App\Models\BrowsingHistory;
use App\Models\CountryArea;

class UserController extends Controller
{
    public function __construct()
    {
        $bs = DB::table('basic_settings')
          ->select('facebook_app_id', 'facebook_app_secret', 'google_client_id', 'google_client_secret')
          ->first();
        
        Config::set('services.google.client_id', $bs->google_client_id);
        Config::set('services.google.client_secret', $bs->google_client_secret);
        Config::set('services.google.redirect', url('api/v1/auth/google/callback'));
    }
    
    function saveSearches(Request $request)
    {
        $rules = [
            'save_search_name' => 'required',
            'selectedAlertType' => 'required',
        ];
        
        // Custom validation messages
        $messages = [
            'save_search_name.required' => 'The save search name is required.',
            'selectedAlertType.email' => 'The selected alert type is required.',
        ];
        
        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);
        
        // If validation fails, return errors
        if ($validator->fails()) 
        {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }
        
        $params = request()->all();
        
        unset($params['save_search_name'], $params['selectedAlertType']);
        
        if (isset($params['brands'])) 
        {
            $params['brands[]'] = $params['brands'];
            
            unset($params['brands']);
        }
        
        if (isset($params['models'])) 
        {
            $params['models[]'] = $params['models'];
            
            unset($params['models']);
        }
        
        $url = url('/ads') . '?' . http_build_query($params);
        
        $save_search_name = $request->save_search_name;
        
        $selectedAlertType = $request->selectedAlertType;
        
        $check = SaveSearch::where('user_id' , request()->user()->id)->where('save_search_name' , $save_search_name)->first();
        
        if($check == false)
        {
            SaveSearch::create(['search_url' => $url , 'save_search_name' => $save_search_name , 'selectedAlertType' => $selectedAlertType , 'user_id' => request()->user()->id , 'last_save_date' => date('Y-m-d H:i:s')]);
        }
        
        if($check == true)
        {
            SaveSearch::where('id' , $check->id)->update(['search_url' => $url , 'selectedAlertType' => $selectedAlertType,'user_id' => request()->user()->id , 'last_save_date' => date('Y-m-d H:i:s')]);
        }
        
        return response()->json(['success' => 'Alert Saved'], 200);
    
    }
    
    public function getUser(Request $request)
    {
        $user = $request->user();
        
        return response()->json([ 'user' => api_resource_user($user)], 200);
    }

      function saveSearchDelete(Request $request )
      {
        if (empty($request->id)) 
        {
            return response()->json(['error' => 'The ID is required.'], 400); 
        }
        
        $id = $request->id;
        
        SaveSearch::where('id' , $id)->delete();
        
        return response()->json(['success' => 'Your search has been removed.'], 200);
      }
      
      function saveSearch()
      {
          
           $userId = request()->user()->id;
          
           $saved_searches = SaveSearch::where('user_id', $userId )
            ->orderBy('id', 'DESC')
            ->paginate(10);
            
            $saved_searches->getCollection()->transform(function ($saveSearched) use ($userId) 
            {
                $cat = 'Yes, daily alert';
                
                 if($saveSearched->selectedAlertType == 0)
                 {
                   $cat =  'No Alerts';
                 }
                 elseif($saveSearched->selectedAlertType == 1)
                 {
                    $cat = 'Yes, instant alert';
                 }
            
                return [
                    'id' => $saveSearched->id,
                    'search_name' => $saveSearched->save_search_name,
                    'last_check_datetime' => date('F , d Y h:i:a' , strtotime($saveSearched->last_save_date)),
                    'alert_type' => $cat
                ];
            });
            
            if($saved_searches->count() == 0)
            {
                return response()->json(['data' => [] ], 200);
            }
            
            return response()->json(['data' => $saved_searches], 200);
      }
      
      function notificationPreferences(Request $request)
      {
          
        $vendor_id = request()->user()->id;
        
        $vendor  = Vendor::where( 'id', $vendor_id )->first();
        
        $in = $request->all();
        
        $in['notification_news_offer'] = $request['notification_news_offer'];
        $in['notification_saved_search'] = $request['notification_saved_search'];
        $in['notification_tips'] = $request['notification_tips'] ;
        $in['notification_recommendations'] = $request['notification_recommendations'];
        $in['notification_saved_ads'] = $request['notification_saved_ads'];
    
        $vendor->update($in);
        
        return response()->json(['success' => 'Setting updated successfully!'], 200);
        
      }
      
      
      public function profileUpdate(Request $request)
      {
        $rules = 
        [
            'city' => 'required',
            'country' => 'required',
        ];
        
        if ($request->hasFile('photo')) 
        {
            $rules['photo'] =  'mimetypes:image/png,image/jpeg,image/jpg';
        }
        
        if ($request->input('traderstatus') == 1) 
        {
            $rules['business_name'] = 'required|string|max:255';
            $rules['vat_number'] = 'required|string|max:50';
            $rules['business_address'] = 'required|string|max:500';
        }
    

        $messages = [
            'city.required' => 'The city field is required.',
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) 
        {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }
        
        $id = request()->user()->id;
       
        $in = $request->all();
        
        $vendor  = Vendor::where('id', $id)->first();
        
        $is_vat_varified = 0;
        
        if ($request->traderstatus == 1) 
        {    
            if(!empty($request['vat_number']))
            {
                if($vendor->vendor_info->vatVerified != 1) 
                {
                    if($this->vatVerify($request['vat_number'])== false)
                    {
                        return response()->json([
                            'error' => 'Vat Number Not Verified.'
                        ], 422);
                    }
                    else
                    {
                        $is_vat_varified = 1;   
                    }
                }   
            }
        }
        
        $file = $request->file('photo');
        
        if ($file) 
        {
            $extension = $file->getClientOriginalExtension();
            $directory = public_path('assets/admin/img/vendor-photo/');
            $fileName = uniqid() . '.' . $extension;
            @mkdir($directory, 0775, true);
            $file->move($directory, $fileName);

            @unlink(public_path('assets/admin/img/vendor-photo/') . $vendor->photo);
            $in['photo'] = $fileName;
        }
        
        $in['trader'] = $request->traderstatus;

        if ($request->show_email_addresss) 
        {
            $in['show_email_addresss'] = 1;
        } 
        else 
        {
            $in['show_email_addresss'] = 0;
        }
        
        if ($request->show_phone_number) 
        {
            $in['show_phone_number'] = 1;
        } 
        else 
        {
            $in['show_phone_number'] = 0;
        }
        
        if ($request->show_contact_form) 
        {
            $in['show_contact_form'] = 1;
        } 
        else 
        {
            $in['show_contact_form'] = 0;
        }
     
        $vendor->update($in);
        
        $vendor_id = $vendor->id;
        
        $vendorInfo = VendorInfo::where('vendor_id', $vendor_id)->first();
        
        if ($vendorInfo == NULL) 
        {
            $vendorInfo = new VendorInfo();
        }
        
        $vendorInfo->language_id = 20;
        
        $vendorInfo->vendor_id = $vendor_id;
        
        if(!empty($request['name'])) 
        {
            $vendorInfo->name = $request['name'];
        }
        
        $vendorInfo->business_name = $request['business_name'];
        
        $vendorInfo->vat_number = $request['vat_number'];
        
        if($is_vat_varified == 1)
        {
             $vendorInfo->vatVerified = $is_vat_varified;  
        }
        
        $vendorInfo->business_address = $request['business_address'];
        
        $vendorInfo->country = $request['country'];
        
        $vendorInfo->city = $request['city'];
        
        $vendorInfo->save();
        
        $user = Vendor::find($id);
        
        return response()->json(['success' => 'Customer updated successfully!' , 'user' => api_resource_user($user)], 200);

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
    
      
      public function countryCity()
      {
          $information['country'] = 'Isle of Man';
          
          $information['city'] = CountryArea::where('status' , 1)->get(['name' , 'slug']);
          
          return response()->json(['data' => $information ], 200);
      }
  
      public function recentViewAds()
    {
        $user_id = request()->user()->id;
    
        $car_ids = BrowsingHistory::where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->pluck('ad_id');

    if (count($car_ids) > 0) {
        // Get the paginated ads
        $ads = Car::whereIn('id', $car_ids)
            ->where('status', 1)
            ->paginate(15);

        // Transform the items in the paginated collection
        $ads->getCollection()->transform(function ($car) use ($user_id) {
            $featureImageUrl = $car->vendor
                ? ($car->vendor->vendor_type === 'normal'
                    ? asset('assets/admin/img/car-gallery/' . $car->feature_image)
                    : env('SUBDOMAIN_APP_URL') . 'assets/admin/img/car-gallery/' . $car->feature_image)
                : asset('assets/admin/img/default-photo.jpg');

            $vendorPhotoUrl = asset('assets/img/blank-user.jpg'); // Default to blank user image

            if (!empty($car->vendor->photo)) {
                $vendorPhotoUrl = $car->vendor->vendor_type === 'dealer'
                    ? env('SUBDOMAIN_APP_URL') . 'assets/admin/img/vendor-photo/' . $car->vendor->photo
                    : asset('assets/admin/img/vendor-photo/' . $car->vendor->photo);
            }

            $effectivePrice = $car->price;

            if ($car->previous_price && $car->previous_price < $car->price) {
                $effectivePrice = $car->previous_price;
            }

            $vendorType = $car->vendor
                ? ($car->vendor->vendor_type === 'dealer'
                    ? ($car->vendor->is_franchise_dealer ? 'Franchise Dealer' : 'Independent Dealer')
                    : 'Private Seller')
                : 'Private Seller';

            $checkWishList = checkWishList($car->id, $user_id);

            return [
                'id' => $car->id,
                'feature_image' => $featureImageUrl,
                'price' => symbolPrice($effectivePrice),
                'created_at' => calculate_datetime($car->created_at),
                'slug' => $car->car_content ? $car->car_content->slug : null,
                'title' => $car->car_content ? $car->car_content->title : null,
                'is_added_on_wishlist' => $checkWishList,
            ];
        });

        // Return paginated data with transformed items
        $information['data'] = $ads;
    } else {
        $information['data'] = null;
    }

    return response()->json($information, 200);
}

  
  
      public function settings()
    {
        try 
        {
          
        $baseUrl = url('assets/img') . '/';

        $bs = Basic::select(
            DB::raw("CONCAT('$baseUrl', logo) as logo"),
            'website_title',
            'email_address',
            'contact_number',
            'address',
            'primary_color',
            'whatsapp_status',
            'whatsapp_number',
            'whatsapp_header_title',
            'whatsapp_popup_message',
            'maintenance_status',
            'maintenance_msg',
            DB::raw("CONCAT('$baseUrl', footer_logo) as footer_logo"),
            'google_login_status',
            'timezone',
            'preloader_status',
            DB::raw("CONCAT('$baseUrl', preloader) as preloader")
        )->first();

        return response()->json(['settings' => $bs], 200);
    } 
    catch (\Exception $e) 
    {
        return response()->json(['error' => 'An error occurred while fetching settings.'], 500);
    }
}


public function login(Request $request)
{
    try 
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
        
        // Custom validation messages
        $messages = [
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 6 characters.',
        ];
        
        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);
        
        // If validation fails, return errors
        if ($validator->fails()) 
        {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');
        
        if (Auth::guard('vendor')->attempt($credentials)) 
        {
            $user = Auth::guard('vendor')->user();
            
            $token = $user->createToken('ListIt')->plainTextToken;

            return response()->json(['token' => $token, 'user' => api_resource_user($user) ], 200);
        }

        // Return unauthorized error if credentials are invalid
        return response()->json(['error' => 'Incorrect email or password'], 401);
    } 
    catch (\Throwable $e) 
    {
        
        // Return a JSON error response with exception details
        return response()->json([
            'error' => 'An error occurred during login. Please try again later.',
            'details' => $e->getMessage()
        ], 500);
    }
}

    public function logout(Request $request)
    {
        try 
        {
            $user = $request->user();
            
            $user->currentAccessToken()->delete();
        
            // Return success response
            return response()->json(['message' => 'Successfully logged out'], 200);
        } 
        catch (\Throwable $e) 
        {
            return response()->json([
                'error' => 'An error occurred during logout. Please try again later.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    
    
    public function redirectToGoogle(Request $request)
    {
        if($request->appUrl)
        {
           session(['appUrl' => $request->appUrl]);  
        }
        
        return Socialite::driver('google')
        ->stateless()
        ->redirect();
    }


    public function handleGoogleCallback(Request $request)
    {
        $appUrl = session('appUrl');
        
        DB::beginTransaction(); // Start transaction

        try 
        {
            
        $googleUser = Socialite::driver('google')->stateless()->user();
        
        $userInfo = $googleUser->user;

        $isUser = Vendor::query()->where('email', '=', $userInfo['email'])->first();

        if (!empty($isUser)) {
            // Check if the user is active
            if ($isUser->status == 1) {
                Auth::guard('vendor')->login($isUser);
                
                // Generate an API token for the user
                $token = $isUser->createToken('ListIt')->plainTextToken;

                DB::commit(); // Commit transaction
                
              if ($appUrl) 
                {
                    return redirect($appUrl.'?token='.$token);
                }
                
                return response()->json([
                    'message' => 'Login successful.',
                    'token' => $token,
                    'user' =>  api_resource_user($isUser)
                ], 200);
                
            } 
            else 
            {
                DB::commit(); // Commit transaction (though no changes were made)
                
                return response()->json([
                    'error' => 'Sorry, your account has been deactivated.'
                ], 403); // Forbidden status
            }
        } else {
            // Handle new user creation
            $avatar = $googleUser->getAvatar();
            $fileContents = file_get_contents($avatar);

            $avatarName = $googleUser->getId() . '.jpg';
            $path = public_path('assets/admin/img/vendor-photo/');
            file_put_contents($path . $avatarName, $fileContents);

            $user = new User();
            $user->name = $userInfo['given_name'] ?? $userInfo['name'];
            $user->image = $avatarName;
            $user->username = $userInfo['id'];
            $user->email = $userInfo['email'];
            $user->email_verified_at = now();
            $user->status = 1;
            $user->provider = 'google';
            $user->provider_id = $userInfo['id'];
            $user->save();
            
            $vendor = new Vendor();
            $vendor->username = $user->name.$user->id;
            $vendor->email = $userInfo['email'];
            $vendor->email_verified_at = now();
            $vendor->status = 1;
            $vendor->save();
            
            VendorInfo::create([
                'vendor_id' => $vendor->id,
                'language_id' => 20,
                'name' => $vendor->username
            ]);

            Auth::guard('vendor')->login($vendor);

            $token = $vendor->createToken('ListIt')->plainTextToken;

            DB::commit(); // Commit transaction
            
               
                if ($appUrl) 
                {
                    return redirect($appUrl.'?token='.$token);
                }
    
            return response()->json([
                'message' => 'Registration successful.',
                'token' => $token,
                'user' => api_resource_user($vendor) 
            ], 200);
            
        }
    } 
    catch (\Exception $e) 
    {
        DB::rollBack(); // Roll back transaction on error
        
        if ($appUrl) 
        {
            return redirect($appUrl.'?error='.$e->getMessage());
        }
                
        return response()->json([
            'error' => 'An error occurred during the Google login process. Please try again later.',
            'details' => $e->getMessage()
        ], 500);
    }
}

 

 
    
    //confirm_email'
   public function confirm_email()
{
    DB::beginTransaction(); // Start transaction

    try {
        $code = request()->input('token');
        
        $user = Vendor::where('verification_code', $code)->first();
    
        if (!$user) 
        {
            // If no user is found, return an error response
            return response()->json([
                'error' => 'Otp Not Matched With Our Records.'
            ], 404);
        }
        
        if ($user->vendor_type == 'dealer') 
        {
            return response()->json([
                'error' => 'We are tracking that your account is linked with a dealer account. Please visit the dealer portal for login.'
            ], 403);
        }
        
        // Update the user's email verification and status
        $user->email_verified_at = now();
        $user->status = 1;
        $user->verification_code = null;
        $user->save();

        Auth::guard('vendor')->login($user);

        // Generate an API token for the verified vendor
        $token = $user->createToken('ListIt')->plainTextToken;

        DB::commit(); // Commit transaction

        return response()->json([
            'message' => 'Verification successful.',
            'token' => $token,
            'user' => api_resource_user($user)
        ], 200);
    } catch (\Exception $e) {
        DB::rollBack(); // Roll back transaction on error

        // Return a JSON error response with exception details
        return response()->json([
            'error' => 'An error occurred during email verification. Please try again later.',
            'details' => $e->getMessage()
        ], 500);
    }
}

function resendCode(Request $request)
{
    $rules = [
            'email' => 'required|email',
        ];

        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422); // Unprocessable Entity
        }
        
        
        
        $in = $request->all();
        $headermail = view('email.mailheader')->render();
        $footermail = view('email.mailfooter')->render();
        $mailTemplate = MailTemplate::where('mail_type', 'verify_email')->first();
        $mailSubject = $mailTemplate->mail_subject;
        $mailBody = $mailTemplate->mail_body;

        $info = DB::table('basic_settings')
            ->select('website_title', 'smtp_status', 'smtp_host', 'smtp_port', 'encryption', 'smtp_username', 'smtp_password', 'from_mail', 'from_name')
            ->first();
            
        $code = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);

        
        $link = '<center style="margin-top: 2rem;">Your Listit Verification Code is<br> '.$code.'</center>';
        $mailBody = str_replace('{username}', $request->username, $mailBody);
        $mailBody = str_replace('{verification_link}', $link, $mailBody);
        $mailBody = str_replace('{website_title}', $info->website_title, $mailBody);

        $headermail .= $mailBody;
        $headermail .= $footermail;
        $data = [
            'subject' => $mailSubject,
            'to' => $request->email,
            'body' => $headermail,
        ];

        // Configure SMTP settings if enabled
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
                DB::rollBack(); // Roll back transaction on SMTP config error
                return response()->json([
                    'error' => 'SMTP configuration error: ' . $e->getMessage()
                ], 500); // Internal Server Error
            }
        }

        // Send verification email
        try {
            Mail::send([], [], function (Message $message) use ($data, $info) {
                $fromMail = $info->from_mail;
                $fromName = $info->from_name;
                $message->to($data['to'])
                    ->subject($data['subject'])
                    ->from($fromMail, $fromName)
                    ->html($data['body'], 'text/html');
            });
            
            $in['verification_code'] = $code;
            
            $vendor = Vendor::where('email' , $request->email)->update($in);
           
            DB::commit(); // Commit transaction

            return response()->json([
                'message' => 'A verification code has been sent to your email address',
            ], 200); // OK

        } catch (\Exception $e) {
            DB::rollBack(); // Roll back transaction on error
            return response()->json([
                'error' => 'Mail could not be sent: ' . $e->getMessage()
            ], 500); // Internal Server Error
        }
    
}


  public function signupSubmit(Request $request)
{
    DB::beginTransaction(); // Start transaction

    try {
        $rules = [
            'username' => 'required',
            'email' => 'required|email|unique:vendors',
            'password' => 'required|min:6',
        ];

        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422); // Unprocessable Entity
        }

        if ($request->username == 'admin') {
            return response()->json([
                'error' => 'You can not use admin as a username!'
            ], 400); // Bad Request
        }

        $in = $request->all();
        $headermail = view('email.mailheader')->render();
        $footermail = view('email.mailfooter')->render();
        $mailTemplate = MailTemplate::where('mail_type', 'verify_email')->first();
        $mailSubject = $mailTemplate->mail_subject;
        $mailBody = $mailTemplate->mail_body;

        $info = DB::table('basic_settings')
            ->select('website_title', 'smtp_status', 'smtp_host', 'smtp_port', 'encryption', 'smtp_username', 'smtp_password', 'from_mail', 'from_name')
            ->first();
            
            

        $code = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);

        
        $link = '<center style="margin-top: 2rem;">Your Listit Verification Code is<br> '.$code.'</center>';
        $mailBody = str_replace('{username}', $request->username, $mailBody);
        $mailBody = str_replace('{verification_link}', $link, $mailBody);
        $mailBody = str_replace('{website_title}', $info->website_title, $mailBody);

        $headermail .= $mailBody;
        $headermail .= $footermail;
        $data = [
            'subject' => $mailSubject,
            'to' => $request->email,
            'body' => $headermail,
        ];

        // Configure SMTP settings if enabled
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
                DB::rollBack(); // Roll back transaction on SMTP config error
                return response()->json([
                    'error' => 'SMTP configuration error: ' . $e->getMessage()
                ], 500); // Internal Server Error
            }
        }

        // Send verification email
        try {
            Mail::send([], [], function (Message $message) use ($data, $info) {
                $fromMail = $info->from_mail;
                $fromName = $info->from_name;
                $message->to($data['to'])
                    ->subject($data['subject'])
                    ->from($fromMail, $fromName)
                    ->html($data['body'], 'text/html');
            });
            
            
            // Proceed with vendor registration
            $in['verification_code'] = $code;
            $in['status'] = 0;
            $in['password'] = Hash::make($request->password);
            $in['phone'] = $request->phone;
            $in['username'] = $request->username;
            $in['notification_allowed'] = $request->notification_allowed ? 1 : 0;

            $vendor = Vendor::create($in);
            $language = (new MiscellaneousController())->getLanguage();

            $vendorInfoData = [
                'language_id' => $language->id,
                'vendor_id' => $vendor->id,
                'name' => $request->username
            ];

            VendorInfo::create($vendorInfoData);

            DB::commit(); // Commit transaction

            return response()->json([
                'message' => 'A verification code has been sent to your email address',
            ], 200); // OK

        } catch (\Exception $e) {
            DB::rollBack(); // Roll back transaction on error
            return response()->json([
                'error' => 'Mail could not be sent: ' . $e->getMessage()
            ], 500); // Internal Server Error
        }
    } catch (\Exception $e) {
        DB::rollBack(); // Roll back transaction on any outer errors
        return response()->json([
            'error' => 'An error occurred during registration. Please try again later.',
            'details' => $e->getMessage()
        ], 500); // Internal Server Error
    }
}



    public function forget_mail(Request $request)
{
    DB::beginTransaction(); // Start transaction

    try {
        $rules = [
            'email' => [
                'required',
                'email:rfc,dns',
                new MatchEmailRule('vendor')
            ]
        ];

        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422); // Unprocessable Entity
        }

        $user = Vendor::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'error' => 'User not found.'
            ], 404); // Not Found
        }

        // Get the mail template information from DB
        $mailTemplate = MailTemplate::where('mail_type', 'reset_password')->first();
        $mailSubject = $mailTemplate->mail_subject;
        $mailBody = $mailTemplate->mail_body;

        // Get basic settings
        $info = DB::table('basic_settings')
            ->select('website_title', 'smtp_status', 'smtp_host', 'smtp_port', 'encryption', 'smtp_username', 'smtp_password', 'from_mail', 'from_name')
            ->first();

        $name = $user->username;
        $token = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);

        // Insert into password_resets table
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
        ]);

        $link = '<center style="margin-top: 2rem;">Reset Otp For Listit Password <br> '.$token.'</center>';

        $mailBody = str_replace('{customer_name}', $name, $mailBody);
        $mailBody = str_replace('{password_reset_link}', $link, $mailBody);
        $mailBody = str_replace('{website_title}', $info->website_title, $mailBody);

        $data = [
            'to' => $request->email,
            'subject' => $mailSubject,
            'body' => $mailBody,
        ];

        // Configure SMTP settings if enabled
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
                DB::rollBack(); // Roll back transaction on SMTP config error
                return response()->json([
                    'error' => 'SMTP configuration error: ' . $e->getMessage()
                ], 500); // Internal Server Error
            }
        }

        // Send the mail
        try {
            Mail::send([], [], function (Message $message) use ($data, $info) {
                $fromMail = $info->from_mail;
                $fromName = $info->from_name;
                $message->to($data['to'])
                    ->subject($data['subject'])
                    ->from($fromMail, $fromName)
                    ->html($data['body'], 'text/html');
            });

            DB::commit(); // Commit transaction

            return response()->json([
                'message' => 'A otp has been sent to your email address'
            ], 200); // OK

        } catch (\Exception $e) {
            DB::rollBack(); // Roll back transaction on mail send error
            return response()->json([
                'error' => 'Mail could not be sent: ' . $e->getMessage()
            ], 500); // Internal Server Error
        }
    } catch (\Exception $e) {
        DB::rollBack(); // Roll back transaction on any outer errors
        return response()->json([
            'error' => 'An error occurred during password reset request. Please try again later.',
            'details' => $e->getMessage()
        ], 500); // Internal Server Error
    }
}

    //update_password
   public function updatePassword(Request $request)
{
    
    $token = $request->token;
        
        // Check if the token exists in the password_resets table
        $reset = DB::table('password_resets')->where('token', $token)->first();
        
        if ($reset === null) {
            DB::rollBack(); // Roll back transaction if token not found
            return response()->json([
                'error' => 'Token Expired Or Invalid'
            ], 404); // Not Found
        }
        
        
    DB::beginTransaction(); // Start transaction

    try {
        $rules = [
            'token' => 'required',
        ];
        
        $messages = [
            'token.required' => 'token must be  required.',
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            DB::rollBack(); // Roll back transaction if validation fails
            return response()->json([
                'error' => $validator->errors()
            ], 422); // Unprocessable Entity status
        }
        
        $reset = DB::table('password_resets')->where('token', $request->token)->first();
        
        if (!$reset) {
            DB::rollBack(); // Roll back transaction if token is invalid or expired
            return response()->json([
                'error' => 'Invalid or expired token.'
            ], 400); // Bad Request status
        }
        
        if(empty($request->new_password) && $reset == true)
        {
                return response()->json([
                'success' => 'Otp Verified'
            ], 200); 
        }
        
        $email = $reset->email;
        $vendor = Vendor::where('email', $email)->first();
        
        if (!$vendor) {
            DB::rollBack(); // Roll back transaction if vendor not found
            return response()->json([
                'error' => 'Vendor not found.'
            ], 404); // Not Found status
        }
        
        if(!empty($request->new_password))
        {
            // Update password
            $vendor->update([
                'password' => Hash::make($request->new_password)
            ]);
            
             // Delete password reset token
        DB::table('password_resets')->where('token', $request->token)->delete();
        
        }
        
       
        
        DB::commit(); // Commit transaction
        
        return response()->json([
            'success' => 'Reset Your Password Successfully Completed. Please Login Now'
        ], 200); // OK status

    } catch (\Exception $e) {
        DB::rollBack(); // Roll back transaction on error
        return response()->json([
            'error' => 'An error occurred while updating the password. Please try again later.',
            'details' => $e->getMessage()
        ], 500); // Internal Server Error status
    }
}

    
 

 


}
