<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Helpers\VendorPermissionHelper;
use App\Http\Requests\Car\CarStoreRequest;
use App\Http\Controllers\FrontEnd\MiscellaneousController;
use App\Models\Car;
use App\Models\EmailSubscriptionReport;
use App\Models\Car\CarContent;
use App\Models\Car\CarImage;
use App\Models\Car\CarModel;
use App\Models\Car\Brand;
use App\Models\BasicSettings\Basic;
use App\Models\Car\Wishlist;
use App\Models\Car\CarSpecification;
use App\Models\Car\CarSpecificationContent;
use App\Models\Language;
use App\Models\Car\Category;
use App\Models\Vendor;
use App\Models\VendorInfo;
use App\Models\SupportTicket;
use App\Models\Deposit;
use App\Models\Invoice;
use App\Models\CountryArea;
use App\Models\DraftAd;
use Auth;
use Config;
use App\Models\KeyFeature;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use PHPMailer\PHPMailer\PHPMailer;
use Purifier;
use App\Models\PrivatePackage;
use App\Models\EnquiryPreference;
use Carbon\Carbon;


class CarController extends Controller
{
        function priceAssist()
        {
            return view('vendors.car.price-assist');
        }
        
        function saveMoreCredits(Request $request)
        {
            $numberOfData = $request->numberOfData;
            $type = $request->type;
            $accountBalance = Auth::guard('vendor')->user()->amount;
            
            if($numberOfData <= 0)
            {
                return response()->json(['response' => 'error' , 'message' => 'Please add some quantity to buy.']);
            }
            
            if($type == 0)
            {
                $totalBumpWantToBuy = $numberOfData * getSetVal('per_bump_price');
                
                if($totalBumpWantToBuy > $accountBalance)
                {
                   return response()->json(['response' => 'error' , 'message' => 'Your account balance is not enough to buy these quantity. Please contact admin to add amount in your wallet.']); 
                }
                
                Vendor::where('id' , Auth::guard('vendor')->user()->id)->update(['bump' => (Auth::guard('vendor')->user()->bump + $numberOfData) , 'amount' => ( $accountBalance - $totalBumpWantToBuy ) ]);
                
                 Deposit::create(['amount' =>$totalBumpWantToBuy , 'deposit_type' => 'withdrawl' , 'vendor_id' => Auth::guard('vendor')->user()->id  , 'short_des' => 'Balance deduct for buying bump(s) credits.']);
            }
            else
            {
                $totalBumpWantToBuy = $numberOfData * getSetVal('per_ad_price');
                
                if($totalBumpWantToBuy > $accountBalance)
                {
                   return response()->json(['response' => 'error' , 'message' => 'Your account balance is not enough to buy these quantity. Please contact admin to add amount in your wallet.']); 
                }
                
                Vendor::where('id' , Auth::guard('vendor')->user()->id)->update(['no_of_ads' => (Auth::guard('vendor')->user()->no_of_ads + $numberOfData)  , 'amount' => ( $accountBalance - $totalBumpWantToBuy )  ]);
                
                Deposit::create(['amount' =>$totalBumpWantToBuy , 'deposit_type' => 'withdrawl' , 'vendor_id' => Auth::guard('vendor')->user()->id  , 'short_des' => 'Balance deduct for buying ad(s) credits.']);
            }
            
            return response()->json(['response' => 'success' , 'message' => 'Your Credit has been added successfully. You can check by visit my account section.']);
        }
        
        function imagerotate(Request $request)
        {
           DB::table('car_images')->where('id' , $request->fileid)->update(['rotation_point' => $request->rotationEvnt]);
           
           echo $request->fileid;
        }

        function getCarValuationData(Request $request)
        {
            $regisno = $request->regisno;

            $curl = curl_init();
            
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://uk1.ukvehicledata.co.uk/api/datapackage/ValuationData?v=2&api_nullitems=1&auth_apikey='.env('UKVEHICLEAPIKEY').'&key_VRM='.$regisno.'',
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
    
            $dataArray = array();
            
            if($response['Response']['StatusCode'] == 'Success')
            {
                $dataArray['VehicleDescription'] = $response['Response']['DataItems']['VehicleDescription'];
                $dataArray['Mileage'] = $response['Response']['DataItems']['Mileage'];
                $dataArray['PlateYear'] = $response['Response']['DataItems']['PlateYear'];
                $dataArray['OTR'] = $response['Response']['DataItems']['ValuationList']['OTR'];
                $dataArray['DealerForecourt'] = $response['Response']['DataItems']['ValuationList']['DealerForecourt'];
                $dataArray['TradeRetail'] = $response['Response']['DataItems']['ValuationList']['TradeRetail'];
                $dataArray['PrivateClean'] = $response['Response']['DataItems']['ValuationList']['PrivateClean'];
                $dataArray['PrivateAverage'] = $response['Response']['DataItems']['ValuationList']['PrivateAverage'];
                $dataArray['PartExchange'] = $response['Response']['DataItems']['ValuationList']['PartExchange'];
                $dataArray['Auction'] = $response['Response']['DataItems']['ValuationList']['Auction'];
                $dataArray['TradeAverage'] = $response['Response']['DataItems']['ValuationList']['TradeAverage'];
                $dataArray['TradePoor'] = $response['Response']['DataItems']['ValuationList']['TradePoor'];
            }

            if(count( $dataArray) > 0 )
            {
                echo json_encode(array('response' => 'yes' , 'output' =>  $dataArray));
                exit;
            }
    
            echo json_encode(array('response' => 'no' , 'output' =>  [] ));

        }

    //--- Change status -------
    
    public function adStatus(Request $request)
    {
        $car = Car::findOrFail($request->id);
        
        if($request->status == "withdraw")
        {
            $inuser['status'] = 2;
        }
        elseif($request->status == "relist")
        {
            $inuser['status'] = 1;
        }
        
        $car->update($inuser);
        
        Session::flash('success', 'Status updated successfully!');
        
        return redirect()->back();
    }
    
    public function BoostPackage(Request $request)
    {
        $data = Car::where('id', $request->ad_id)->first();
        $data->update(['package_id' => $request->package_id]);
        return redirect()->route('vendor.package.payment_method',$request->ad_id);
    }
    
    public function index(Request $request)
    {

        $information['langs'] = Language::all();
        $misc = new MiscellaneousController();
        $language = Language::where('code', $request->language)->firstOrFail();
        $information['language'] = $language;
        $language_id = $language->id;
        $information['bgImg'] = $misc->getBreadcrumb();

        if( $request->tab == 'withdrawn')
        {
            $status = 2;
        }
        elseif( $request->tab == 'draft')
        {
            $status = 0;
        }
        else
        {
            $status = 1;
        }
        
        if(Auth::guard('vendor')->user()->vendor_type == 'normal')
        {
            $information['cars']  = Car::where('vendor_id', Auth::guard('vendor')->user()->id)->with('car_content')
            ->orderBy('id', 'desc')
            ->get();   
        }
        else
        {
            $information['cars'] = Car::where('vendor_id', Auth::guard('vendor')->user()->id)->with([
            'car_content' => function ($q) use ($language_id) {
                $q->where('language_id', $language_id);
            },
        ])
        ->where('status', $status)
            ->orderBy('id', 'desc')
            ->get();
        }
        
          
            $information['totalPublish'] = Car::where('vendor_id', Auth::guard('vendor')->user()->id)->with([
                'car_content' => function ($q) use ($language_id) {
                    $q->where('language_id', $language_id);
                },
            ])
            ->where('status', 1)->count();

            $information['totalWithDrawn'] = Car::where('vendor_id', Auth::guard('vendor')->user()->id)->with([
                'car_content' => function ($q) use ($language_id) {
                    $q->where('language_id', $language_id);
                },
            ])
            ->where('status', 2)->count();
            $information['totalDraft']  = Car::where('vendor_id', Auth::guard('vendor')->user()->id)->with([
                'car_content' => function ($q) use ($language_id) {
                    $q->where('language_id', $language_id);
                },
            ])
            ->where('status', 0)->count();


            $car_ids = Car::where('vendor_id', Auth::guard('vendor')->user()->id)->with([
                'car_content' => function ($q) use ($language_id) {
                    $q->where('language_id', $language_id);
                },
            ])
            ->where('status', $status)->pluck('id');
        
            $information['impressions'] = DB::table('ad_impressions')->whereIn('ad_id' , $car_ids)->sum('impressions');
            $information['visitors'] = DB::table('visitors')->whereIn('car_id' , $car_ids)->count();
            $information['saves'] = Wishlist::whereIn('car_id' , $car_ids)->count(); 
            $information['leads'] = SupportTicket::where('admin_id', Auth::guard('vendor')->user()->id)->where('user_type', 'vendor')->count();
            
            if(Auth::guard('vendor')->user()->vendor_type == 'dealer')
            {
               return view('vendors.car.index', $information); 
            }
            
            return view('vendors.car.index_2', $information);
    }
    
    
     public function indexAjax(Request $request)
    {
       if($request->status=="all"){
        $cars  = Car::where('vendor_id', Auth::guard('vendor')->user()->id)->with('car_content')
            ->orderBy('id', 'desc')
            ->get();
       } else {
        $cars  = Car::where('vendor_id', Auth::guard('vendor')->user()->id)->where('status', $request->status)->with('car_content')
        ->orderBy('id', 'desc')
        ->get();
       }
       $html = view('vendors.car.indexajax', compact('cars'))->render();
    
        return response()->json(['code' => 200, 'data' =>$html]); 
        return view('vendors.car.index_2', $information);
    }
    
    public function indexSaveAdsAjax(Request $request)
    {
       if($request->status=="all"){
        $cars  = Car::select('cars.*', 'wishlists.*')
      ->join('wishlists', function ($join) {
          $join->on(['wishlists.car_id' => 'cars.id']);
      })->where('wishlists.user_id', '=', Auth::guard('vendor')->user()->id)->orderBy('cars.id', 'desc')->get();
        
       } else {
        $cars  = Car::select('cars.*', 'wishlists.*')
      ->join('wishlists', function ($join) {
          $join->on(['wishlists.car_id' => 'cars.id']);
      })->where('wishlists.user_id', '=', Auth::guard('vendor')->user()->id)->where('status', $request->status)->orderBy('cars.id', 'desc')->get();
        
        
       }
       $html = view('vendors.car.indexajaxsaveads', compact('cars'))->render();
    
        return response()->json(['code' => 200, 'data' =>$html]); 
        return view('vendors.car.index_2', $information);
    }
    

    function printCarStock()
    {
        $language = Language::where('code', 'en')->first();
        $language_id = $language->id;

        $cars = Car::where('vendor_id', Auth::guard('vendor')->user()->id)->with([
            'car_content' => function ($q) use ($language_id) {
                $q->where('language_id', $language_id);
            },
        ])
        ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();

        $data = [
            'cars' => $cars,
            'photo' => asset('assets/admin/img/vendor-photo/'.Auth::guard('vendor')->user()->photo),
        ];

        return view('vendors.car.get-dealer-stock', compact('data'))->render();
    }

    static function getAdStats($car_id)
    {
        
        $information['impressions'] = DB::table('ad_impressions')->where('ad_id' , $car_id)->sum('impressions');
        $information['visitors'] = DB::table('visitors')->where('car_id' , $car_id)->count();
        $information['leads'] = SupportTicket::where('admin_id', Auth::guard('vendor')->user()->id)->where('ad_id' , $car_id)->where('user_type', 'vendor')->count();
        $information['phone_no_revel'] = DB::table('cars')->where('id' , $car_id)->sum('phone_no_revel');

        return  $information;
    }

    function addBump(Request $request)
    {
        
        $setting = Basic::latest('id')->first();
        
        if(Auth::guard('vendor')->user()->bump == 0)
        {
            $validMembership = Auth::guard('vendor')->user()->memberships()
            ->where('expire_date', '>', Carbon::now())
            ->first();
            
            if($validMembership == false)
            {
               $invoice  = Invoice::create([
                     'vendor_id' => Auth::guard('vendor')->user()->id,
                    ]);
            
                DB::table('deposits')->insert([
                    'amount' => $setting->per_bump_price,
                    'invoice_id' => $invoice->id,
                    'vendor_id' => Auth::guard('vendor')->user()->id,
                    'short_des' => 'ad bump'
                ]); 
            }
            
            if($validMembership == true)
            {
                DB::table('deposits')->insert([
                    'amount' => $setting->per_bump_price,
                    'invoice_id' => $validMembership->invoice_id,
                    'vendor_id' => Auth::guard('vendor')->user()->id,
                    'short_des' => 'ad bump',
                    'created_at' => now()
                ]); 
            }
        }
            
        $car_id = $request->car;

        $car = Car::find($car_id);
        
        if(!empty($car->bump_date))
        {
            $startDate = Carbon::parse($car->created_at);
            
            $endDate = Carbon::parse(date('Y-m-d'));
            
            $diffInDays = $endDate->diffInDays($startDate);
            
             if($diffInDays < 5 )
             {
                 Session::flash('error', 'Bump ad is not available until the last bump request has been made at least 5 days ago.');
                 
                 return redirect()->back();  
             }
        }
        
       $created_at = $car->created_at;
       
       $bump = $car->bump;

       Car::where('id' , $car_id )->update(['bump_date' => $created_at , 'bump' => $bump+1 , 'created_at' => date('Y-m-d H:i:s')]);
     
        if(Auth::guard('vendor')->user()->bump > 0)
        {
            Vendor::where('id' , Auth::guard('vendor')->user()->id)->update(['bump' => Auth::guard('vendor')->user()->bump - 1 , 'bump_used' => Auth::guard('vendor')->user()->bump_used + 1 ]);
        }
        
       Session::flash('success', 'Updated successfully!');

       return redirect()->back();
    }

    function dealerAnalytics(Request $request)
    {
            $status = 1;

            if(!empty($request->status))
            {
                if($request->status == 3)
                {
                    $status = 0;
                }
                else{
                    $status = $request->status;
                }
            }

            $cars = Car::with('car_content')->where('vendor_id', Auth::guard('vendor')->user()->id)
            ->where('status', $status);

            if(!empty($request->reg_no))
            {
                $cars = $cars->where('vregNo', $request->reg_no);
            }

            if(!empty($request->model))
            {
                $cars = $cars->whereHas('car_content', function($q) use ($request){
                    $q->where('car_model_id', $request->model);
                });
            }

            if(!empty($request->make))
            {
                $cars = $cars->whereHas('car_content', function($q) use ($request){
                    $q->where('brand_id', $request->make);
                });
            }

            if(!empty($request->daterange))
            {
                $explode = explode('-' , $request->daterange);
                $start_date = trim($explode[0]);
                $end_date = trim($explode[1]);
                $start_date = date('Y-m-d' , strtotime($start_date));
                $end_date = date('Y-m-d' , strtotime($end_date));
                
                $cars = $cars->whereBetween('created_at', [$start_date, $end_date]);
            }


            $cars = $cars->orderBy('id', 'desc')
            ->get();

            $information['cars'] = $cars;
            
                        
            // Initialize arrays to hold brand and model IDs
            $brandIds = [];
            $modelIds = [];
            
            // Loop through each car and collect brand and model IDs from car_content
            foreach ($information['cars'] as $car) {
                if ($car->car_content) {
                    $contents = json_decode($car->car_content , true);
                    foreach($contents as $content)
                    {
                      if( $contents['brand_id'])
                      {
                          $brandIds[] =  $contents['brand_id'];
                      }
                      
                      if( $contents['car_model_id'])
                      {
                          $modelIds[] =  $contents['car_model_id'];
                      }
                    }
                }
            }
            
            $brandIds = array_unique(array_filter($brandIds));
            $modelIds = array_unique(array_filter($modelIds));
            
            // Fetch all brands with the collected brand IDs
            $information['brands'] = Brand::where('status', 1)
                ->whereIn('id', $brandIds)
                ->get(['id', 'name']);
            
            // Fetch all car models with the collected model IDs
            $information['models'] = CarModel::where('status', 1)
                ->whereIn('id', $modelIds)
                ->get(['id', 'name']);
  
 
            $car_ids = Car::where('vendor_id', Auth::guard('vendor')->user()->id)->where('status', $status)->pluck('id');
        
            $information['impressions'] = DB::table('ad_impressions')->whereIn('ad_id' , $car_ids)->sum('impressions');
            $information['visitors'] = DB::table('visitors')->whereIn('car_id' , $car_ids)->count();
            $information['saves'] = Wishlist::where('user_id', Auth::guard('vendor')->user()->id)->count(); 
            $information['leads'] = SupportTicket::where('admin_id', Auth::guard('vendor')->user()->id)->where('user_type', 'vendor')->count();
            $information['phone_no_revel'] = DB::table('cars')->whereIn('id' , $car_ids)->sum('phone_no_revel');

           
           
            $information['registration_no'] = Car::whereNotNull('vregNo')->get(['vregNo']);

            return view('vendors.car.dealer-analytics', $information);
    }

    function myAds(Request $request)
    {
        $information['langs'] = Language::all();
        $misc = new MiscellaneousController();
        $language = Language::where('code', $request->language)->firstOrFail();
        $information['language'] = $language;
        $language_id = $language->id;
        $information['bgImg'] = $misc->getBreadcrumb();

        if( $request->tab == 'withdrawn')
        {
            $status = 2;
        }
        elseif( $request->tab == 'draft')
        {
            $status = 0;
        }
        else
        {
            $status = 1;
        }

        $information['cars'] = Car::where('vendor_id', Auth::guard('vendor')->user()->id)->with([
            'car_content' => function ($q) use ($language_id) {
                $q->where('language_id', $language_id);
            },
        ])
        ->where('status', $status)
            ->orderBy('id', 'desc')
            ->get();

            $information['totalPublish'] = Car::where('vendor_id', Auth::guard('vendor')->user()->id)->with([
                'car_content' => function ($q) use ($language_id) {
                    $q->where('language_id', $language_id);
                },
            ])
            ->where('status', 1)->count();

            $information['totalWithDrawn'] = Car::where('vendor_id', Auth::guard('vendor')->user()->id)->with([
                'car_content' => function ($q) use ($language_id) {
                    $q->where('language_id', $language_id);
                },
            ])
            ->where('status', 2)->count();
            $information['totalDraft']  = Car::where('vendor_id', Auth::guard('vendor')->user()->id)->with([
                'car_content' => function ($q) use ($language_id) {
                    $q->where('language_id', $language_id);
                },
            ])
            ->where('status', 0)->count();


            $car_ids = Car::where('vendor_id', Auth::guard('vendor')->user()->id)->with([
                'car_content' => function ($q) use ($language_id) {
                    $q->where('language_id', $language_id);
                },
            ])
            ->where('status', $status)->pluck('id');
        
            $information['impressions'] = DB::table('ad_impressions')->whereIn('ad_id' , $car_ids)->sum('impressions');
            $information['visitors'] = DB::table('visitors')->whereIn('car_id' , $car_ids)->count();
            $information['saves'] = Wishlist::whereIn('car_id' , $car_ids)->count(); 
            $information['leads'] = SupportTicket::where('admin_id', Auth::guard('vendor')->user()->id)->where('user_type', 'vendor')->count();
            $information['phone_no_revel'] = DB::table('cars')->whereIn('id' , $car_ids)->sum('phone_no_revel');

            return view('vendors.car.my-ads', $information);
    }

    public function getCarModels(Request $request)
    {
        $models = CarModel::where('brand_id' , $request->make)->get(['id' , 'name']);

        return response()->json($models);
    }

    function getCrMdl(Request $request)
    {
        $carModelValue = $request->carModelValue;
        $makeSelect = $request->makeSelect;

        $models = CarModel::where('brand_id', $makeSelect)->get(['id' , 'name']);

        $matchedModel = null;
        
        foreach ($models as $model) {
            // Split strings into arrays
            $databaseWords = explode(' ', strtolower($model->name));
            $searchWords = explode(' ', strtolower($carModelValue));
        
            // Check if any word in $databaseWords matches any word in $searchWords
            $matchFound = count(array_intersect($databaseWords, $searchWords)) > 0;
        
            if ($matchFound) {
                $matchedModel = $model;
                break;
            }
        }
        
        echo $matchedModel->id;
    }

    //create
    public function create()
    {
        $information = [];
        $misc = new MiscellaneousController();
        $languages = Language::get();
        $information['languages'] = $languages;
        $vendor_id = Auth::guard('vendor')->user()->id;
        $information['vendor'] = Vendor::with('vendor_info')->where('id', $vendor_id)->first();
        $information['bgImg'] = $misc->getBreadcrumb();
        $data = CountryArea::where('status', 1)->orderBy('name', 'asc')->get();
        $information['countryArea'] = $data;
        $information['draft_ad'] =  DraftAd::where('vendor_id', Auth::guard('vendor')->user()->id)->first();
        $information['key_features'] = KeyFeature::where('user_id', Auth::guard('vendor')->user()->id)->pluck('name')->toArray();

        if(Auth::guard('vendor')->user()->vendor_type == 'dealer')
        {
            return view('vendors.car.dealer-create', $information);
        }

        return view('vendors.car.create', $information);
    }
    public function get_brand_model(Request $request)
    {
        $data = CarModel::where('brand_id', $request->id)->where('status', 1)->get();
        return $data;
    }
    public function imagesstore(Request $request)
    {
        $img = $request->file('file');
        $allowedExts = array('jpg', 'png', 'jpeg', 'svg', 'webp');
        $rules = [
            'file' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    $ext = $img->getClientOriginalExtension();
                    if (!in_array($ext, $allowedExts)) {
                        return $fail("Only png, jpg, jpeg images are allowed");
                    }
                },
            ]
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $filename = uniqid() . '.jpg';
        $img->move(public_path('assets/admin/img/car-gallery/'), $filename);
        $pi = new CarImage();
        if (!empty($request->car_id)) {
            $pi->car_id = $request->car_id;
        }
        $pi->image = $filename;
        $pi->save();
        return response()->json(['status' => 'success', 'file_id' => $pi->id]);
    }
    public function imagermv(Request $request)
    {
        $pi = CarImage::findOrFail($request->fileid);
        $imageCount = CarImage::where('car_id', $pi->car_id)->get()->count();
        if ($imageCount > 1) {
            @unlink(public_path('assets/admin/img/car-gallery/') . $pi->image);
            $pi->delete();
            return $pi->id;
        } else {
            return 'false';
        }
    }

    //imagedbrmv
    public function imagedbrmv(Request $request)
    {
        $pi = CarImage::findOrFail($request->fileid);
        $imageCount = CarImage::where('car_id', $pi->car_id)->get()->count();
        if ($imageCount > 1) {
            @unlink(public_path('assets/admin/img/car-gallery/') . $pi->image);
            $pi->delete();
            return $pi->id;
        } else {
            return 'false';
        }
    }
    
    
    function frameImage(Request $request)
    {
    
        if ($request->hasFile('photo_frame'))
        {
            $image = $request->file('photo_frame');
            
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            
            $image->move(public_path('assets/admin/img/car-gallery'), $imageName);

            // Optionally, you can store the image path in the database or use it as needed
            $imagePath = $imageName;
 
            return response()->json(['message' => 'Image uploaded successfully', 'image_path' => $imagePath], 200);
        }
    }
    
    //select payment method
    public function PaymentMethod(Request $request)
    {
        $information = [];
        $misc = new MiscellaneousController();
        $languages = Language::get();
        $information['languages'] = $languages;
        $vendor_id = Auth::guard('vendor')->user()->id;
        $information['bgImg'] = $misc->getBreadcrumb();
        $information['ad_id'] = Car::where('id', $request->ad_id)->first();
        $information['data'] = PrivatePackage::where('id', $information['ad_id']->package_id)->first();
        if($information['data']->price == 0 && session::get('promo_status')==0){
            $statusUpdate = Car::findOrFail($request->ad_id);
            $statusUpdate->update(['status' => 1]);
            
            // ------Send email if no payment ----
            $headermail =   view('email.mailheader')->render();
            $footermail =  view('email.mailfooter')->render();  

            $mailSubject = $information['ad_id']->car_content->title .' -  ad is Published';
            $mailBody = view('email.ads.newad', $information); 

            $info = DB::table('basic_settings')
            ->select('website_title', 'smtp_status', 'smtp_host', 'smtp_port', 'encryption', 'smtp_username', 'smtp_password', 'from_mail', 'from_name')
            ->first();      

        
            $headermail .= $mailBody; 
        //$headermail =view('email.mailbody')->render(); 
        $headermail .= $footermail;
        $data = [
            'subject' => $mailSubject,
            'to' => $information['ad_id']->vendor->email,
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
           // Session::flash('success', 'A verification mail has been sent to your email address');
        } catch (\Exception $e) {
            //echo "<pre>";
           // print_r($e); exit;
            Session::flash('message', 'Mail could not be sent!');
            Session::flash('alert-type', 'error');
            return redirect()->back();
        }

            return view('vendors.car.success', $information);

        }else {
        return view('vendors.car.payment', $information);
        }
    }
    

    //store
    public function store(CarStoreRequest $request)
    {
      
        if ($request->can_car_add != 1) {
           return back();
        }
        $vendor_id = Auth::guard('vendor')->user()->id;
      
        DB::transaction(function () use ($request,&$lastcarID) 
        {

            $languages = Language::all();
            $in = $request->all();

            if(!empty($request->car_cover_image)) 
            {
              $fImage =  CarImage::select('id','image')->where('id',$request->car_cover_image)->first();
             
            } 
            else
            {
                $fImage =  CarImage::select('id','image')->where('id',$request->slider_images[0])->first();
            }
            
            $in['feature_image'] = $fImage->image;
            
            if (!empty($request->label)) 
            {
                $specification = [];
                foreach ($request->label as $key => $varName) 
                {
                    $specification[] = [
                        'label' => $varName,
                        'value' => $request->value[$key]
                    ];
                }
                
                $in['specification'] = json_encode($specification);
            }

            $in['vendor_id'] = Auth::guard('vendor')->user()->id;
            
            $packg = PrivatePackage::where('id', $request->package_id)->first();
            
            if($packg->price == 0 && $request->promo_status==0)
            {
                $in['status'] =1; 
            } 
            else
            {
                $in['status'] =0;  
            }
            
            $in['package_id'] = $request->package_id;
            
            $in['order_id'] = $this->getNextOrderNumber();


            $car = Car::create($in);
            
            $lastcarID=$car->id;
            
            $vendor  = Vendor::where('id',$in['vendor_id'])->first();
           
            $inuser['phone'] = $request->phone;
            
            if(isset($request->traderstatus)) 
            {
                $inuser['trader'] = 1;
            } 
            else 
            {
                $inuser['trader'] = 0;
            }
            
            $vendor->update($inuser);
            
            $catinfo  = Category::where('id', $request['en_category_id'])->first();
            
            $vendorinfo  = VendorInfo::where('vendor_id', $in['vendor_id'])->first();
            
            if ($request->traderstatus) 
            {    
                $inuserinfo['business_name'] = $request['business_name'];
                $inuserinfo['vat_number'] = $request['vat_number'];
                $inuserinfo['business_address'] = $request['business_address'];   
            }
         
            $inuserinfo['city'] = $request->city;
           
            $vendorinfo->update($inuserinfo);

            $slders = $request->slider_images;
            
            if ($slders) 
            {
                $pis = CarImage::findOrFail($slders);
                
                foreach ($pis as $key => $pi) 
                {
                    $pi->car_id = $car->id;
                    $pi->save();
                }
            }

            foreach ($languages as $language) 
            {
                $carContent = new CarContent();
                $carContent->language_id = $language->id;
                $carContent->car_id = $car->id;
                $carContent->title = $request[$language->code . '_title'];
                $carContent->slug = createSlug($request[$language->code . '_title']);
                $carContent->category_id = $request[$language->code . '_category_id'];
                $carContent->main_category_id = $request[$language->code . '_main_category_id'];
                $carContent->car_color_id = $request['car_color_id'];
                $carContent->category_slug = createSlug($catinfo->name);
                $carContent->brand_id = $request['brand_id'];
                $carContent->car_model_id = $request['car_model_id'];
                $carContent->fuel_type_id = $request['fuel_type_id'];
                $carContent->transmission_type_id = $request['transmission_type_id'];
                $carContent->address = $request['address'];
                
                $carContent->description = Purifier::clean($request[$language->code . '_description'], 'youtube');
                $carContent->meta_keyword = $request[$language->code . '_meta_keyword'];
                $carContent->meta_description = $request[$language->code . '_meta_description'];
                $carContent->save();

                if (!empty($request[$language->code . '_label'])) {
                    $label_datas = $request[$language->code . '_label'];
                    foreach ($label_datas as $key => $data) {
                        $car_specification = CarSpecification::where([['car_id', $car->id], ['key', $key]])->first();
                        if (is_null($car_specification)) {
                            $car_specification = new CarSpecification();
                            $car_specification->car_id = $car->id;
                            $car_specification->key  = $key;
                            $car_specification->save();
                        }
                        $car_specification_content = new CarSpecificationContent();
                        $car_specification_content->language_id = $language->id;
                        $car_specification_content->car_specification_id = $car_specification->id;
                        $car_specification_content->label = $data;
                        $car_specification_content->value = $request[$language->code . '_value'][$key];
                        $car_specification_content->save();
                    }
                }
            }
           
        });
        
        Session::put('package_id', $request->package_id);
        Session::put('promo_status', $request->promo_status);
       
        return Response::json(['status' => 'success', 'action' => 'add','ad_id'=>$lastcarID], 200);
    }
      
    
    public function getNextOrderNumber()
    {
    // Get the last created order
    $lastOrder = Car::orderBy('created_at', 'desc')->first();

    // Set Prefix
    $prefix = date('Y');

    // Set db-field
    $field = 'order_id';

    // Set length of incrementing number
    $length = 4;

    if (!$lastOrder) {
        // We get here if there is no order at all
        // If there is no number set it to 0, which will be 1 at the end.

        $number = 0;
    } else {
        // If we have ORD2023000001 in the database then we only want the number
        // So the substr returns this 000001
        $number = substr($lastOrder->{$field}, strlen($prefix));
    }

    // Reset incrementing no if prefix has changed (e.g. in new year)
    if (substr($lastOrder->order_id, 0, strlen($prefix)) !== $prefix) {
        $number = 0;
    }

    // Add the string in front and higher up the number.
    // the %05d part makes sure that there are always 6 numbers in the string.
    // so it adds the missing zero's when needed.

    return sprintf('%s%0' . $length . 'd', $prefix, intval($number) + 1);
    }
    
    
    function getVheicleDeatails(Request $request)
    {
        
        if(Auth::guard('vendor')->user()->history_check == 0 && $request->type != 1)
        {
            echo json_encode(array('response' => 'no' , 'message' => 'Your History Check limit exceed please contact to admin.'));
            exit;
        }
        
        $reg_no = $request->vehicle_reg;
    
        $formatted_reg_no = str_replace([' ', '-'], '', $reg_no);

        $check_post = DB::table('registration_records')
        ->whereRaw('REPLACE(REPLACE(vrm, " ", ""), "-", "") LIKE ?', ['%' . $formatted_reg_no . '%'])
        ->first();
        
        
    
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        // CURLOPT_URL => 'https://uk1.ukvehicledata.co.uk/api/datapackage/VehicleData?v=2&api_nullitems=1&auth_apikey='.env('UKVEHICLEAPIKEY').'&key_VRM='.$vehicle_reg.'',
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        // CURLOPT_CUSTOMREQUEST => 'GET',
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);
        // $response = json_decode($response , true);
        // $data = array();
        
        
        if($check_post == true)
        {
            $data['NumberOfSeats'] =$check_post->seats;
            $data['Make'] = ucfirst(strtolower($check_post->make));
            $data['Model'] = ucfirst(strtolower($check_post->model));
            $data['Year'] = $check_post->year;
            $data['FuelType'] = ucfirst(strtolower($check_post->fuel_type));
            $data['TransmissionType'] = ucfirst(strtolower($check_post->transmission));
            $data['Color'] = ucfirst(strtolower($check_post->color));
            $data['Tax_Fee'] = $check_post->tax_fee;
        }
    
        if(count($data) > 0 )
        {
            Vendor::where('id' , Auth::guard('vendor')->user()->id)
            ->update(['history_check' => Auth::guard('vendor')->user()->history_check - 1 , 'history_check_used' => Auth::guard('vendor')->user()->history_check_used	 + 1 ]);
            
            echo json_encode(array('response' => 'yes' , 'output' => $data));
            exit;
        }
    
        echo json_encode(array('response' => 'no' , 'output' => []));

    }


    function getmillage($vehicle_reg)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://uk1.ukvehicledata.co.uk/api/datapackage/ValuationData?v=2&api_nullitems=1&auth_apikey='.env('UKVEHICLEAPIKEY').'&key_VRM='.$vehicle_reg.'',
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

        if($response['Response']['StatusCode'] == 'Success')
        {
           return $response['Response']['DataItems']['Mileage'];
        }
    }
    
     function imagerotates(Request $request)
    {
       DB::table('car_images')->where('id' , $request->fileid)->update(['rotation_point' => $request->rotationEvnt]);
       echo $request->fileid;
    }
    
    
     public function imageDrag(Request $request)
    {
        
        if(!empty($request->order))
        {
            foreach($request->order as $order)
            {
                $car_image = CarImage::find($order['id']);
                
                if($car_image == true)
                {
                    $car_image->priority = $order['priority'];
                    $car_image->save();
                }
            }
        }
    }
    

    function getSubEmail()
    {
        $vendor_id = Auth::guard('vendor')->user()->id;

        $vendor = Vendor::find( $vendor_id);

        $is_checked = $vendor->email_subscription_enable == 1 ?  'checked' : '';

        $textboxs = '';

        if($vendor->email_subscription_enable == 1 )
        {
            $emails = EmailSubscriptionReport::where('dealer_id' , $vendor_id )->get(['mails']);

            foreach($emails as $key => $email)
            {
                $counter = $key+1;
                $textboxs .=  '<div class="col-md-12" style="font-size: 13.5px;    margin-bottom: 1rem;">
                <b>Subscriber '. $counter.'</b>
                <input type="email" name="mail[]" required placeholder="enter here..." value="'.$email->mails.'" class="form-control" />
              </div>';
            }

        }
        else
        {
            for($i=0; $i<3;$i++)
            {
                $counter = $i+1;
                $textboxs .=  '<div class="col-md-12" style="font-size: 13.5px;    margin-bottom: 1rem;">
                <b>Subscriber '.$counter.'</b>
                <input type="email" name="mail[]" required placeholder="enter here..." class="form-control" />
              </div>';
            }
        }

        $output = '<div class="row">
        '.$textboxs.'
        <div class="col-md-12" style="font-size: 13.5px;    margin-bottom: 1rem;">
          <b>Enabled?</b>
          <input type="checkbox" '.$is_checked.' name="is_enable" value="1" style="zoom: 1.3;position: relative;top: 3px;" />
        </div>
        <div class="col-md-12 text-center" style="font-size: 13.5px;">
        <hr>
          <p style="margin-bottom: 2rem;">  
          <button type="submit" class="btn btn-sm btn-info" style="color:white;">Save</button>
        </p>
        </div>
      
       </div>';

       return $output;
    }

    public function SubEmail(Request $request)
    {
        $mails = $request->mail;

        $vendor_id = Auth::guard('vendor')->user()->id;

        EmailSubscriptionReport::where('dealer_id' , $vendor_id)->whereIn('mails' , $mails)->delete();
        
        if($request->is_enable == 1)
        {
            for($i=0; $i<count($mails); $i++)
            {
                EmailSubscriptionReport::create(['dealer_id' => $vendor_id , 'mails' => $mails[$i] ]);
            }
        }
        
        Vendor::where('id' , $vendor_id)->update(['email_subscription_enable' => $request->is_enable??0 ]);
        
        Session::flash('success', 'Settings Successfully');

        return redirect()->back();
    }

    public function storeData(CarStoreRequest $request)
    {

        if ($request->can_car_add != 1) 
        {
           return back();
        }
        
         $errorArray = [];
         
      
        
        $category = Category::find($request['en_main_category_id']);

        $vendor_id = Auth::guard('vendor')->user()->id;
       
        DB::transaction(function () use ($request) 
        {
            
        if(Auth::guard('vendor')->user()->no_of_ads == 0)
        {
            $bs = Basic::first();
            
            $validMembership = Auth::guard('vendor')->user()->memberships()
            ->where('expire_date', '>', Carbon::now())
            ->first();
            
            if($validMembership == false)
            {
               $invoice  = Invoice::create([
                     'vendor_id' => Auth::guard('vendor')->user()->id,
                    ]);
            
                Deposit::create([
                    'amount' => $bs->per_ad_price,
                    'invoice_id' => $invoice->id,
                    'vendor_id' => Auth::guard('vendor')->user()->id,
                    'short_des' => 'extra one ad'
                ]); 
            }
            
            if($validMembership == true)
            {
               
                DB::table('deposits')->insert([
                    'amount' => $bs->per_ad_price,
                    'invoice_id' => $validMembership->invoice_id,
                    'vendor_id' => Auth::guard('vendor')->user()->id,
                    'short_des' => 'extra one ad',
                    'created_at' => now()
                ]); 
            }
        
        }
        
        
            $languages = Language::all();
            
            $in = $request->all();
            
            $fImage =  CarImage::select('id','image')->where('id',$request->car_cover_image)->first();
            
            if(!empty($fImage))
            {
                $in['feature_image'] = $fImage->image;
            }

            if (!empty($request->label)) 
            {
                $specification = [];
                foreach ($request->label as $key => $varName) 
                {
                    $specification[] = [
                        'label' => $varName,
                        'value' => $request->value[$key]
                    ];
                }
                
                $in['specification'] = json_encode($specification);
            }

            $in['vendor_id'] = Auth::guard('vendor')->user()->id;
            
            if(!empty($request->vehicle_reg))
            {
                $in['vregNo'] = $request->vehicle_reg;
            }
            
            if (!empty($request->photo_frma)) 
            {
                $in['feature_image'] = $request->photo_frma;
            }
            
             if(isset($in['message_center']) && $in['message_center'] == 'yes')
            {
               $in['message_center'] = 1; 
            }
            
            if(isset($in['phone_text']) && $in['phone_text'] == 'yes')
            {
               $in['phone_text'] = 1; 
            }
        
            $in['enquiry_person_id'] = json_encode($request->enquirey_person);
            
            $car = Car::create($in);

            ////  logic for comfort_n_convenience///

            if(!empty($request->comfort_n_convenience) && count($request->comfort_n_convenience) > 0 )
            {
                    for($i = 0; $i<count($request->comfort_n_convenience); $i++)
                {
                    DB::table('vehicle_features')->insert(['add_id' => $car->id , 'parent_name' => 'comfort_n_convenience' 
                    , 'value' =>$request->comfort_n_convenience[$i] , 'created_at' => date('Y-m-d H:i:s') , 'updated_at' => date('Y-m-d H:i:s') ]);
                }
            }
            

            /// END////////////////////////////////


            ////  logic for media_n_conectivity///
            if(!empty($request->media_n_conectivity) && count($request->media_n_conectivity) > 0 )
            {
                for($i = 0; $i<count($request->media_n_conectivity); $i++)
                {
                    DB::table('vehicle_features')->insert(['add_id' => $car->id , 'parent_name' => 'media_n_conectivity' 
                    , 'value' =>$request->media_n_conectivity[$i] , 'created_at' => date('Y-m-d H:i:s') , 'updated_at' => date('Y-m-d H:i:s') ]);
                }
             }

            /// END////////////////////////////////


            ////  logic for assistance_n_utility///
            if(!empty($request->assistance_n_utility) && count($request->assistance_n_utility) > 0 )
            {
                for($i = 0; $i<count($request->assistance_n_utility); $i++)
                {
                    DB::table('vehicle_features')->insert(['add_id' => $car->id , 'parent_name' => 'assistance_n_utility' 
                    , 'value' =>$request->assistance_n_utility[$i] , 'created_at' => date('Y-m-d H:i:s') , 'updated_at' => date('Y-m-d H:i:s') ]);
                }
            }

            /// END////////////////////////////////


            ////  logic for styling_n_appearance///
            if(!empty($request->styling_n_appearance) && count($request->styling_n_appearance) > 0 )
            {
                for($i = 0; $i<count($request->styling_n_appearance); $i++)
                {
                    DB::table('vehicle_features')->insert(['add_id' => $car->id , 'parent_name' => 'styling_n_appearance' 
                    , 'value' =>$request->styling_n_appearance[$i] , 'created_at' => date('Y-m-d H:i:s') , 'updated_at' => date('Y-m-d H:i:s') ]);
                }
            }

            /// END////////////////////////////////


            ////  logic for lighting_n_illumination///
            if(!empty($request->lighting_n_illumination) && count($request->lighting_n_illumination) > 0 )
            {
                for($i = 0; $i<count($request->lighting_n_illumination); $i++)
                {
                    DB::table('vehicle_features')->insert(['add_id' => $car->id , 'parent_name' => 'lighting_n_illumination' 
                    , 'value' =>$request->lighting_n_illumination[$i] , 'created_at' => date('Y-m-d H:i:s') , 'updated_at' => date('Y-m-d H:i:s') ]);
                }
             }

            /// END////////////////////////////////


            ////  logic for safety_n_security///
            if(!empty($request->safety_n_security) &&  count($request->safety_n_security) > 0 )
            {
                for($i = 0; $i<count($request->safety_n_security); $i++)
                {
                    DB::table('vehicle_features')->insert(['add_id' => $car->id , 'parent_name' => 'safety_n_security' 
                    , 'value' =>$request->safety_n_security[$i] , 'created_at' => date('Y-m-d H:i:s') , 'updated_at' => date('Y-m-d H:i:s') ]);
                }
            }

            /// END////////////////////////////////


            ////  logic for performance_n_handling///
            if(!empty($request->performance_n_handling) && count($request->performance_n_handling) > 0 )
            {
                for($i = 0; $i<count($request->performance_n_handling); $i++)
                {
                    DB::table('vehicle_features')->insert(['add_id' => $car->id , 'parent_name' => 'performance_n_handling' 
                    , 'value' =>$request->performance_n_handling[$i] , 'created_at' => date('Y-m-d H:i:s') , 'updated_at' => date('Y-m-d H:i:s') ]);
                }
            }

            /// END////////////////////////////////

            $vendor  = Vendor::where('id',$in['vendor_id'])->first();
            $inuser['phone'] = $request->phone;
            $vendor->update($inuser);
            // update vendor info details
            $vendorinfo  = VendorInfo::where('vendor_id', $in['vendor_id'])->first();
            $inuserinfo['name'] = $request->full_name;
            $inuserinfo['city'] = $request->city;
            $vendorinfo->update($inuserinfo);

            $slders = $request->slider_images;
            if ($slders) {
                $pis = CarImage::findOrFail($slders);
                foreach ($pis as $key => $pi) {
                    $pi->car_id = $car->id;
                    $pi->save();
                }
            }
            $catinfo  = Category::where('id', $request['en_category_id'])->first();
            foreach ($languages as $language) {
                $carContent = new CarContent();
                $carContent->language_id = $language->id;
                $carContent->car_id = $car->id;
                $carContent->title = $request[$language->code . '_title'];
                $carContent->slug = createSlug($request[$language->code . '_title']);
                $carContent->category_slug = createSlug($catinfo->name);
                $carContent->category_id = $request[$language->code . '_category_id'];
                $carContent->main_category_id = $request[$language->code . '_main_category_id'];
                $carContent->car_color_id = $request[$language->code . '_car_color_id'];
                $carContent->brand_id = $request[$language->code . '_brand_id'];
                $carContent->car_model_id = $request[$language->code . '_car_model_id'];
                $carContent->fuel_type_id = $request[$language->code . '_fuel_type_id'];
                $carContent->transmission_type_id = $request[$language->code . '_transmission_type_id'];
                $carContent->address = $request[$language->code . '_address'];

                $carContent->description = Purifier::clean($request[$language->code . '_description'], 'youtube');
                $carContent->body_type_id = $request->body_type_id;
                $carContent->save();
            }
            
        if(Auth::guard('vendor')->user()->no_of_ads > 0)
        {
            Vendor::where('id' , Auth::guard('vendor')->user()->id)->update(['no_of_ads' => Auth::guard('vendor')->user()->no_of_ads - 1 , 'no_of_ads_used' => Auth::guard('vendor')->user()->no_of_ads_used + 1 ]);
        }
        
        });
        
        DraftAd::where('vendor_id', Auth::guard('vendor')->user()->id)->delete();
        KeyFeature::where('user_id', Auth::guard('vendor')->user()->id)->delete();
        
        Session::flash('success', 'New ad added successfully!');
        //return redirect()->route('vendor.car_management.car');
        return Response::json(['status' => 'success'], 200);
    }

    function enquiryPreferences()
    {
       $enquiry_preferences = EnquiryPreference::where('vendor_id' , Auth::guard('vendor')->user()->id)->get();

       return view('vendors.car.enquiry_preference', compact('enquiry_preferences'));
    }

    function saveUser(Request $request)
    {

        if(!empty( $request->enquiry_id))
        {
            EnquiryPreference::where('id' , $request->enquiry_id)->update(['name' => $request->name , 
            'email' => $request->email , 'phone_no' => $request->phone_no ]);
            Session::flash('success', 'New User Updated successfully!');
        }
        else
        {
            EnquiryPreference::create(['vendor_id' => Auth::guard('vendor')->user()->id , 'name' => $request->name , 
            'email' => $request->email , 'phone_no' => $request->phone_no ]); 
            Session::flash('success', 'New User added successfully!');
        }

       return redirect()->back();
    }

    function deleteUser(Request $request)
    {
        $user_id =  $request->user_id;

        EnquiryPreference::where('id' , $user_id)->delete();

        Session::flash('success', 'User deleted successfully!');

        return redirect()->back();

    }

     public function subCat(Request $request)
    {
      //echo request()->route()->getActionMethod(); exit;
        $option = "";
        $cat = new Category();
        $draftad = DraftAd::where('vendor_id', Auth::guard('vendor')->user()->id)->first();
        $cat = $cat::where('parent_id', '=', $request->id)->get();
        $option .="<option selected disabled>Select Sub Category</option>";
         foreach ($cat as $key => $value) 
         {
             $selected = '';
             
             if($draftad == true && !empty($draftad->sub_category_id) && $draftad->sub_category_id == $value->id)
             {
                 $selected = 'selected';
             }
            
             $option .="<option value=".$value->id."  ".$selected.">".$value->name."</option>";
         }
         
         echo $option;
    }
    
    public function updateFeatured(Request $request)
    {
        $car = Car::findOrFail($request->carId);

        if ($request->is_featured == 1) 
        {
            
          $setting = Basic::latest('id')->first();
         
            if(!empty(Auth::guard('vendor')->user()->last_spotlight_used))
            {
                $startDate = Carbon::parse(Auth::guard('vendor')->user()->last_spotlight_used);
                
                $endDate = Carbon::parse(date('Y-m-d'));
                
                $diffInDays = $endDate->diffInDays($startDate);
                
                 if($diffInDays < $setting->day_after_spotlight )
                 {
                     Session::flash('error', 'Spotlighting is not available until the last spotlight request has been made at least '.$setting->day_after_spotlight.' days ago.');
                     
                     return redirect()->back();  
                 }
            }
            
            
            if(Auth::guard('vendor')->user()->spotlight == 0)
            {
                $validMembership = Auth::guard('vendor')->user()->memberships()
                ->where('expire_date', '>', Carbon::now())
                ->first();
                
                if($validMembership == false)
                {
                   $invoice  = Invoice::create([
                         'vendor_id' => Auth::guard('vendor')->user()->id,
                        ]);
                
                    DB::table('deposits')->insert([
                        'amount' => $setting->per_spotlight_price,
                        'invoice_id' => $invoice->id,
                        'vendor_id' => Auth::guard('vendor')->user()->id,
                        'short_des' => 'ad featured'
                    ]); 
                }
                
                if($validMembership == true)
                {
                    DB::table('deposits')->insert([
                        'amount' => $setting->per_spotlight_price,
                        'invoice_id' => $validMembership->invoice_id,
                        'vendor_id' => Auth::guard('vendor')->user()->id,
                        'short_des' => 'ad featured',
                        'created_at' => now()
                    ]); 
                }
            }
        
        
            $car->update(['is_featured' => 1 , 'featured_date' =>  date('Y-m-d') ]);
            
            $total_blance_aval = Auth::guard('vendor')->user()->amount - $setting->per_spotlight_price;
            
            if(Auth::guard('vendor')->user()->spotlight > 0)
            {
                Vendor::where('id' , Auth::guard('vendor')->user()->id)->update([ 'last_spotlight_used' => date('Y-m-d')  , 'amount' => $total_blance_aval ]);
            }
            
            $day_after_spotlight = 1;
            
            if(!empty($setting->day_after_spotlight))
            {
                $day_after_spotlight =   $setting->day_after_spotlight;
            }
            
            Session::flash('success', 'Your ad has been successfully boost till '.$day_after_spotlight. ' days.');
            
        } 
        else 
        {
            $car->update(['is_featured' => 0]);

            Session::flash('success', 'Your ad has been unfeatured successfully!');
        }

        return redirect()->back();
    }
    
    public function updateStatus(Request $request)
    {
       
        $car = Car::findOrFail($request->carId);

        if ($request->status == 1) 
        {
          
            $car->update(['status' => 1]);
            Session::flash('success', 'Car Publish successfully!');
        }
        else if($request->status == 2)  
        {
            $car->update(['status' => 2]);

            Session::flash('success', 'Car Withdrawn successfully!');
        } 
        else 
        {
            $car->update(['status' => 0]);

            Session::flash('success', 'Car draft successfully!');
        }
        
       

        return redirect()->back();
    }
    public function edit($id)
    {
        $car = Car::with('galleries')->findOrFail($id);
        
        $information['car'] = $car;

        // get all the languages from db
        $information['languages'] = Language::all();

        $specifications = CarSpecification::where('car_id', $car->id)->get();
        
        $information['specifications'] = $specifications;
        
        $misc = new MiscellaneousController();
        $information['bgImg'] = $misc->getBreadcrumb();
        $vendor_id = Auth::guard('vendor')->user()->id;
        $information['vendor'] = Vendor::with('vendor_info')->where('id', $vendor_id)->first();
        $data = CountryArea::where('status', 1)->orderBy('name', 'asc')->get();
        $information['countryArea'] = $data;
        
        if(Auth::guard('vendor')->user()->vendor_type == 'dealer')
        {
            $misc = new MiscellaneousController();
            $vendor_id = Auth::guard('vendor')->user()->id;
            $information['vendor'] = Vendor::with('vendor_info')->where('id', $vendor_id)->first();
            $information['bgImg'] = $misc->getBreadcrumb();
            $information['countryArea'] = CountryArea::where('status', 1)->orderBy('name', 'asc')->get();
            $vehicle_features = DB::table('vehicle_features')->where('add_id' , $car->id)->get();
            $information['vehicle_features'] = json_decode(json_encode($vehicle_features) , true );
           
            return view('vendors.car.dealer-edit', $information);
        }
        
        return view('vendors.car.edit', $information);
    }


 static function isFeatureChecked($feature, $elements) {
    return array_reduce(
        array_filter(
            $elements,
            function ($element) use ($feature) {
                return count(array_diff($feature, $element)) === 0;
            }
        ),
        function ($carry, $item) {
            return $carry === 'checked' ? 'checked' : (count($item) > 0 ? 'checked' : '');
        },
        ''
    );
}


   public function dealerUpdate(Request $request, $id)
    {
        $vendor_id = Auth::guard('vendor')->user()->id;
      
        $rules = [
            'price' => 'required',
            'year' => 'required',
            'mileage' => 'required',
        ];

        $category = Category::find($request['en_main_category_id']);

        
        $languages = Language::all();
        
        foreach ($languages as $language) 
        {
            $rules[$language->code . '_title'] = 'required|max:255';
            $rules[$language->code . '_category_id'] = 'required';
            $rules[$language->code . '_description'] = 'required|min:15';
            $messages[$language->code . '_title.required'] = 'The title field is required for ' . $language->name . ' language';
            $messages[$language->code . '_title.max'] = 'The title field cannot contain more than 255 characters for ' . $language->name . ' language';
            $messages[$language->code . '_category_id.required'] = 'The category field is required for ' . $language->name . ' language';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 200);
        }

        $in = $request->all();
       

        if (!empty($request->label)) {
            $specification = [];
            foreach ($request->label as $key => $varName) {
                $specification[] = [
                    'label' => $varName,
                    'value' => $request->value[$key]
                ];
            }
            $in['specification'] = json_encode($specification);
        }
        
        if(!empty($request->vehicle_reg))
        {
            $in['vregNo'] = $request->vehicle_reg;
        }
        
        
        if(empty($request->is_sale))
        {
            $in['is_sale'] = 0;
        }
        
        if(empty($request->is_sold))
        {
            $in['is_sold'] = 0;
        }
        
        if(empty($request->reduce_price))
        {
            $in['reduce_price'] = 0;
        }
        
        if(empty($request->manager_special))
        {
            $in['manager_special'] = 0;
        }
        
        if(empty($request->deposit_taken))
        {
            $in['deposit_taken'] = 0;
        }
        
         if(isset($in['message_center']) && $in['message_center'] == 'yes')
            {
               $in['message_center'] = 1; 
            }
            
            if(isset($in['phone_text']) && $in['phone_text'] == 'yes')
            {
               $in['phone_text'] = 1; 
            }
            
        
        $in['enquiry_person_id'] = json_encode($request->enquirey_person);
            
        if (!empty($request->photo_frma)) 
        {
            $in['feature_image'] = $request->photo_frma;
        }
        
        $car = Car::findOrFail($request->car_id);
        
        $in['vendor_id'] = Auth::guard('vendor')->user()->id;
        
        $car = $car->update($in);

        $slders = $request->slider_images;
        if ($slders) {
            $pis = CarImage::findOrFail($slders);
            foreach ($pis as $key => $pi) {
                $pi->car_id = $request->car_id;
                $pi->save();
            }
        }
        
        $features_to_remove = array();

        ////  logic for comfort_n_convenience///

            if(!empty($request->comfort_n_convenience) && count($request->comfort_n_convenience) > 0 )
            {
                    for($i = 0; $i<count($request->comfort_n_convenience); $i++)
                {
                    $check_point =  DB::table('vehicle_features')->where('add_id' ,  $request->car_id )->where('parent_name' , 'comfort_n_convenience')->where('value' , $request->comfort_n_convenience[$i])->first();
                    
                     if($check_point == true)
                    {
                        
                        $curnt_id = $check_point->id;
                         DB::table('vehicle_features')->where('id' , $check_point->id)->update(['value' =>$request->comfort_n_convenience[$i] , 'updated_at' => date('Y-m-d H:i:s') ]);
                    }
                    
                    
                    if($check_point == false)
                    {
                       $check_point = DB::table('vehicle_features')->insertGetId(['add_id' => $request->car_id , 'parent_name' => 'comfort_n_convenience' 
                    , 'value' =>$request->comfort_n_convenience[$i] , 'created_at' => date('Y-m-d H:i:s') , 'updated_at' => date('Y-m-d H:i:s') ]); 
                    $curnt_id =$check_point ;
                    }
                    
                   $features_to_remove[] = $curnt_id;
                   
                }
            }
            

            /// END////////////////////////////////


            ////  logic for media_n_conectivity///
            if(!empty($request->media_n_conectivity) && count($request->media_n_conectivity) > 0 )
            {
                for($i = 0; $i<count($request->media_n_conectivity); $i++)
                {
                    
                    $check_point =  DB::table('vehicle_features')->where('add_id' ,  $request->car_id )->where('parent_name' , 'media_n_conectivity')->where('value' , $request->media_n_conectivity[$i])->first();
                    
                     if($check_point == true)
                    {
                        $curnt_id =$check_point->id ;
                         DB::table('vehicle_features')->where('id' , $check_point->id)->update(['value' =>$request->media_n_conectivity[$i] , 'updated_at' => date('Y-m-d H:i:s') ]);
                    }
                    
                    if($check_point == false)
                    {
                        $check_point = DB::table('vehicle_features')->insertGetId(['add_id' => $request->car_id , 'parent_name' => 'media_n_conectivity' 
                         , 'value' =>$request->media_n_conectivity[$i] , 'created_at' => date('Y-m-d H:i:s') , 'updated_at' => date('Y-m-d H:i:s') ]);
                         $curnt_id =$check_point ;
                    }
                    
                     $features_to_remove[] = $curnt_id;
                    
                }
             }

            /// END////////////////////////////////


            ////  logic for assistance_n_utility///
            if(!empty($request->assistance_n_utility) && count($request->assistance_n_utility) > 0 )
            {
                for($i = 0; $i<count($request->assistance_n_utility); $i++)
                {
                     $check_point =  DB::table('vehicle_features')->where('add_id' ,  $request->car_id )->where('parent_name' , 'assistance_n_utility')->where('value' , $request->assistance_n_utility[$i])->first();
                    
                    if($check_point == true)
                    {
                         $curnt_id =$check_point->id ;
                         DB::table('vehicle_features')->where('id' , $check_point->id)->update(['value' =>$request->assistance_n_utility[$i] , 'updated_at' => date('Y-m-d H:i:s') ]);
                    }
                    
                    if($check_point == false)
                    {
                       $check_point =   DB::table('vehicle_features')->insertGetId(['add_id' => $request->car_id , 'parent_name' => 'assistance_n_utility' 
                    , 'value' =>$request->assistance_n_utility[$i] , 'created_at' => date('Y-m-d H:i:s') , 'updated_at' => date('Y-m-d H:i:s') ]);
                     $curnt_id =$check_point ;
                    }
                    
                    $features_to_remove[] = $curnt_id;
                    
                    
                }
            }

            /// END////////////////////////////////


            ////  logic for styling_n_appearance///
            if(!empty($request->styling_n_appearance) && count($request->styling_n_appearance) > 0 )
            {
                for($i = 0; $i<count($request->styling_n_appearance); $i++)
                {
                    
                    $check_point =  DB::table('vehicle_features')->where('add_id' ,  $request->car_id )->where('parent_name' , 'styling_n_appearance')->where('value' , $request->styling_n_appearance[$i])->first();
                    
                     if($check_point == true)
                    {
                         $curnt_id =$check_point->id ;
                         DB::table('vehicle_features')->where('id' , $check_point->id)->update(['value' =>$request->styling_n_appearance[$i] , 'updated_at' => date('Y-m-d H:i:s') ]);
                    }
                    
                    
                    if($check_point == false)
                    {
                       $check_point =   DB::table('vehicle_features')->insertGetId(['add_id' => $request->car_id , 'parent_name' => 'styling_n_appearance' 
                    , 'value' =>$request->styling_n_appearance[$i] , 'created_at' => date('Y-m-d H:i:s') , 'updated_at' => date('Y-m-d H:i:s') ]);
                     $curnt_id =$check_point ;
                    }
                    
                   
                    $features_to_remove[] = $curnt_id;
                    
                    
                }
            }

            /// END////////////////////////////////


            ////  logic for lighting_n_illumination///
            if(!empty($request->lighting_n_illumination) && count($request->lighting_n_illumination) > 0 )
            {
                for($i = 0; $i<count($request->lighting_n_illumination); $i++)
                {
                    
                    $check_point =  DB::table('vehicle_features')->where('add_id' ,  $request->car_id )->where('parent_name' , 'lighting_n_illumination')->where('value' , $request->lighting_n_illumination[$i])->first();
                    
                    if($check_point == true)
                    {
                        $curnt_id =$check_point->id ;
                         DB::table('vehicle_features')->where('id' , $check_point->id)->update(['value' =>$request->lighting_n_illumination[$i] , 'updated_at' => date('Y-m-d H:i:s') ]);
                    }
                    
                    if($check_point == false)
                    {
                        $check_point =  DB::table('vehicle_features')->insertGetId(['add_id' => $request->car_id , 'parent_name' => 'lighting_n_illumination' 
                    , 'value' =>$request->lighting_n_illumination[$i] , 'created_at' => date('Y-m-d H:i:s') , 'updated_at' => date('Y-m-d H:i:s') ]);
                    $curnt_id =$check_point ;
                    }
                    
                     $features_to_remove[] = $curnt_id;
                    
                    
                    
                }
             }

            /// END////////////////////////////////


            ////  logic for safety_n_security///
            if(!empty($request->safety_n_security) &&  count($request->safety_n_security) > 0 )
            {
                for($i = 0; $i<count($request->safety_n_security); $i++)
                {
                    
                    $check_point =  DB::table('vehicle_features')->where('add_id' ,  $request->car_id)->where('parent_name' , 'safety_n_security')->where('value' , $request->safety_n_security[$i])->first();
                    
                    if($check_point == true)
                    {
                         $curnt_id =$check_point->id ;
                         DB::table('vehicle_features')->where('id' , $check_point->id)->update(['value' =>$request->safety_n_security[$i] , 'updated_at' => date('Y-m-d H:i:s') ]);
                    }
                    
                    
                    if($check_point == false)
                    {
                       $check_point =  DB::table('vehicle_features')->insertGetId(['add_id' => $request->car_id , 'parent_name' => 'safety_n_security' 
                    , 'value' =>$request->safety_n_security[$i] , 'created_at' => date('Y-m-d H:i:s') , 'updated_at' => date('Y-m-d H:i:s') ]);
                     $curnt_id =$check_point ;
                    }
                    
                    
                    $features_to_remove[] = $curnt_id;
                    
                    
                }
            }

            /// END////////////////////////////////


            ////  logic for performance_n_handling///
            if(!empty($request->performance_n_handling) && count($request->performance_n_handling) > 0 )
            {
                for($i = 0; $i<count($request->performance_n_handling); $i++)
                {
                    
                     $check_point =  DB::table('vehicle_features')->where('add_id' ,  $request->car_id )->where('parent_name' , 'performance_n_handling')->where('value' , $request->performance_n_handling[$i])->first();
                    
                    if($check_point == true)
                    {
                         $curnt_id =$check_point->id ;
                         DB::table('vehicle_features')->where('id' , $check_point->id)->update(['value' =>$request->performance_n_handling[$i] , 'updated_at' => date('Y-m-d H:i:s') ]);
                    }
                    
                    
                    if($check_point == false)
                    {
                     $check_point =  DB::table('vehicle_features')->insertGetId(['add_id' => $request->car_id , 'parent_name' => 'performance_n_handling' 
                    , 'value' =>$request->performance_n_handling[$i] , 'created_at' => date('Y-m-d H:i:s') , 'updated_at' => date('Y-m-d H:i:s') ]);
                     $curnt_id =$check_point ;
                    }
                    
                     $features_to_remove[] = $curnt_id;
                    
                    
                }
            }

            /// END////////////////////////////////
            
            if(count($features_to_remove) > 0 )
            {
                DB::table('vehicle_features')->whereNotIn('id' , $features_to_remove)->delete();
            }
            
        foreach ($languages as $language) {
            $carContent =  CarContent::where('car_id', $request->car_id)->where('language_id', $language->id)->first();
            if (empty($carContent)) {
                $carContent = new CarContent();
            }
             $carContent->language_id = $language->id;
                $carContent->car_id = $request->car_id;
                $carContent->title = $request[$language->code . '_title'];
                $carContent->slug = createSlug($request[$language->code . '_title']);
                $carContent->category_id = $request[$language->code . '_category_id'];
                $carContent->main_category_id = $request[$language->code . '_main_category_id'];
                $carContent->car_color_id = $request[$language->code . '_car_color_id'];
                $carContent->brand_id = $request[$language->code . '_brand_id'];
                $carContent->car_model_id = $request[$language->code . '_car_model_id'];
                $carContent->fuel_type_id = $request[$language->code . '_fuel_type_id'];
                $carContent->transmission_type_id = $request[$language->code . '_transmission_type_id'];
                $carContent->address = $request[$language->code . '_address'];

                $carContent->description = Purifier::clean($request[$language->code . '_description'], 'youtube');
                $carContent->body_type_id = $request->BodyType;
                $carContent->save();
        }

        Session::flash('success', 'Ad Updated successfully!');
        return Response::json(['status' => 'success'], 200);
    }
    
    
    
    public function update(Request $request, $id)
    {
      
      if ($request->can_car_add != 1) {
        return back();
     }
     $vendor_id = Auth::guard('vendor')->user()->id;
     
     DB::transaction(function () use ($request) {

      
       
         $languages = Language::all();
         $in = $request->all();

         if(!empty($request->car_cover_image)) {
           $fImage =  CarImage::select('id','image')->where('id',$request->car_cover_image)->first();
          $in['feature_image'] = $fImage->image;
         } 
         
         if (!empty($request->label)) {
             $specification = [];
             foreach ($request->label as $key => $varName) {
                 $specification[] = [
                     'label' => $varName,
                     'value' => $request->value[$key]
                 ];
             }
             $in['specification'] = json_encode($specification);
         }

         $in['vendor_id'] = Auth::guard('vendor')->user()->id;

         $car = Car::findOrFail($request->car_id);
         $in['vendor_id'] = Auth::guard('vendor')->user()->id;
         $car = $car->update($in);
         $vendor  = Vendor::where('id',$in['vendor_id'])->first();
         $inuser['phone'] = $request->phone;
         $vendor->update($inuser);
         // update vendor info details
         $vendorinfo  = VendorInfo::where('vendor_id', $in['vendor_id'])->first();
         $inuserinfo['name'] = $request->full_name;
         $inuserinfo['city'] = $request->city;
         $vendorinfo->update($inuserinfo);

         

         foreach ($languages as $language) {
            $carContent =  CarContent::where('car_id', $request->car_id)->first();
            if (empty($carContent)) {
                $carContent = new CarContent();
            }
             $carContent->language_id = $language->id;
           //  $carContent->car_id = $request->car_id;
             $carContent->title = $request[$language->code . '_title'];
             $carContent->slug = createSlug($request[$language->code . '_title']);
            // $carContent->category_id = $request[$language->code . '_category_id'];
            // $carContent->main_category_id = $request[$language->code . '_main_category_id'];
             $carContent->car_color_id = $request['car_colour_id'];
            // $carContent->brand_id = $request['brand_id'];
             $carContent->body_type_id = $request['body_type_id'];
            // $carContent->fuel_type_id = $request['fuel_type_id'];
             $carContent->transmission_type_id = $request['transmission_type_id'];
             //$carContent->address = $request['address'];

             $carContent->description = Purifier::clean($request[$language->code . '_description'], 'youtube');
             $carContent->meta_keyword = $request[$language->code . '_meta_keyword'];
             $carContent->meta_description = $request[$language->code . '_meta_description'];
             $carContent->save();

             if (!empty($request[$language->code . '_label'])) {
                 $label_datas = $request[$language->code . '_label'];
                 foreach ($label_datas as $key => $data) {
                     $car_specification = CarSpecification::where([['car_id', $car->id], ['key', $key]])->first();
                     if (is_null($car_specification)) {
                         $car_specification = new CarSpecification();
                         $car_specification->car_id = $car->id;
                         $car_specification->key  = $key;
                         $car_specification->save();
                     }
                     $car_specification_content = new CarSpecificationContent();
                     $car_specification_content->language_id = $language->id;
                     $car_specification_content->car_specification_id = $car_specification->id;
                     $car_specification_content->label = $data;
                     $car_specification_content->value = $request[$language->code . '_value'][$key];
                     $car_specification_content->save();
                 }
             }
         }
     });
     //Session::put('package_id', $request->package_id);
    // Session::put('promo_status', $request->promo_status);
     Session::flash('success', 'Ad updated successfully!');
     //return redirect()->route('vendor.car_management.car');
     return Response::json(['status' => 'success', 'action' => 'update'], 200);
 }
    //delete
    public function delete(Request $request)
    {
        $car = Car::findOrFail($request->car_id);
        // first, delete all the contents of this package
        $contents = $car->car_content()->get();
        foreach ($contents as $content) {
            $content->delete();
        }

        // third, delete feature_image image of this package
        if (!is_null($car->feature_image)) {
            @unlink(public_path('assets/admin/img/car/') . $car->feature_image);
        }

        // first, delete all the contents of this package
        $galleries = $car->galleries()->get();

        foreach ($galleries as $gallery) {
            @unlink(public_path('assets/admin/img/car-gallery/') . $gallery->image);
            $gallery->delete();
        }
        // finally, delete this package
        $car->delete();

        DB::table('vehicle_features')->where('add_id' , $car->id)->delete();

        Session::flash('success', 'Car deleted successfully!');
        return redirect()->back();
    }
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $car = Car::findOrFail($id);

            // first, delete all the contents of this package
            $contents = $car->car_content()->get();

            foreach ($contents as $content) {
                $content->delete();
            }

            // third, delete feature_image image of this package
            if (!is_null($car->feature_image)) {
                @unlink(public_path('assets/admin/img/car/') . $car->feature_image);
            }

            // first, delete all the contents of this package
            $galleries = $car->galleries()->get();

            foreach ($galleries as $gallery) {
                @unlink(public_path('assets/admin/img/car-gallery/') . $gallery->image);
                $gallery->delete();
            }
            // finally, delete this package
            $car->delete();
        }

        Session::flash('success', 'Car deleted successfully!');
       
        return response()->json(['status' => 'success'], 200);
    }
    
    
     public function PaymentOptions(Request $request)
     {
        $categories = Category::where('id', $request->category_id)->first();
        
        $apiarray = [];
        $filters = "";
        $draft_ad =  DraftAd::where('vendor_id', Auth::guard('vendor')->user()->id)->first();
      
        if (!empty($categories->filters) && in_array('make', json_decode($categories->filters))) {
        //yes: $id exits in array
        $make = 1;
        $filters = view('vendors.car.carfilteroptions', compact('categories' , 'draft_ad'))->render();
         }
        else {
            
            if($categories == null)
            {
                $filters = '';
                exit;
            }
            
        $filters = view('vendors.car.vehicledetails', compact('categories','apiarray','draft_ad'))->render();

        $make = 0;

        }
        
        $data = PrivatePackage::where('category_id', $categories->parent_id)->where('status', 1)->get();

        $html = view('vendors.car.paymentoptions', compact('data'))->render();
    
        return response()->json(['code' => 200, 'message' => 'successful.','data' =>$html, "make" => $make, "filters" => $filters]); 
     }
     public function PlanSelected(Request $request)
     {
        $data = PrivatePackage::where('id', $request->package_id)->where('status', 1)->first();

        $html = view('vendors.car.packageselected', compact('data'))->render();
    
        return response()->json(['code' => 200, 'message' => 'successful.','data' =>$html]); 
     }
     public function PromoSelected(Request $request)
     {
        $data = PrivatePackage::where('id', $request->package_id)->where('status', 1)->first();

        $html = view('vendors.car.packageselected', compact('data'))->render();
    
        return response()->json(['code' => 200, 'message' => 'successful.','data' =>$html]); 
     }

     public function BoostPayment(Request $request)
     {
        $data = PrivatePackage::where('category_id', $request->category_id)->where('price', '>', 0)->get();
        //print_r($data);

       // $html = view('vendors.car.packageselected', compact('data'))->render();
       return view('vendors.car.boost', compact('data'));
    
        //return response()->json(['code' => 200, 'message' => 'successful.','data' =>$html]); 
     }
     
     
}
