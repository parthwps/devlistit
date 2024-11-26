<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\BasicSettings\Basic;
use App\Http\Controllers\FrontEnd\MiscellaneousController;
use App\Models\BasicSettings\MailTemplate;
use App\Models\Car;
use App\Models\Car\Brand;
use App\Models\Car\CarCondition;
use App\Models\Car\CarContent;
use App\Models\Car\CarImage;
use App\Models\Car\CarModel;
use App\Models\Car\CarSpecification; 
use App\Models\Car\CarSpecificationContent;
use App\Models\Car\Category;
use App\Models\Car\FuelType;
use App\Models\Car\BodyType;
use App\Models\Car\TransmissionType;
use App\Models\Vendor;
use App\Models\Visitor;
use App\Models\CountryArea;
use App\Models\CarYear;
use App\Models\AdsPrice;
use Carbon\Carbon;
use App\Models\Car\EngineSize;
use App\Models\Car\CarPower;
use Config;
use App\Models\PrivatePackage;
use DB;
use App\Models\AdsMileage;
use App\Models\Car\CarColor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Car\Wishlist;
use App\Models\Car\FormFields;
use App\Models\Car\CustomerSearch;
use App\Http\Requests\Car\CarStoreRequest;
use Purifier;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;

class PaypalController extends Controller
{   
        public function __construct()
        {
                 
        }
        
        function paypalStatus(Request $request , $status , $ad_id )
        {
            $appUrl = $request->appUrl;
            $msg = $request->msg;
                
            if($status == 'success')
            {
             $ad_id = Car::where('id',$ad_id)->first();
            
             //return response()->json(['success' => 'payment success' ] , 200 );
            
             return view('v1.success', compact('ad_id' , 'msg' , 'appUrl'));   
            }
            else
            {
                //return response()->json(['error' => $msg ] , 500 );
                 
                return view('v1.error' , compact('msg' , 'appUrl' ));   
            }
        }
        
        function boostAd(Request $request)
        {
            $rules = [
                'ad_id' => 'required',
                'package_id' => 'required',
            ];
            
            $messages = [
                'ad_id.required' => 'The ad id is required.',
                'package_id.required' => 'The package id is required.',
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()) 
            {
                return response()->json([
                    'error' => $validator->errors()
                ], 422);
            }
            
            $information['ad_id'] = Car::with('vendor')->where('id', $request->ad_id)->first();
            $information['data'] = PrivatePackage::where('id', $request->package_id)->first();
            $information['vendor'] =$information['ad_id']->vendor;
            
            
            session(['appUrl' => $request->appUrl]);
            
            return view('v1.payment', $information);
        }
        
        function adStatus(Request $request)
        {
            $rules = [
                'ad_id' => 'required',
                 'token' => 'required',
            ];
            
            $messages = [
                'ad_id.required' => 'The ad id is required.',
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()) 
            {
                return response()->json([
                    'error' => $validator->errors()
                ], 422);
            }
                
             $token = $request->query('token');
             
             $accessToken = PersonalAccessToken::findToken($token);
    
            if ($accessToken) 
            {
                $user = $accessToken->tokenable;
                $vendor_id =  $user->id;
            } 
            else 
            {
                return response()->json(['message' => 'Invalid token'], 401);
            }
            
            $information['ad_id'] = Car::with('vendor')->where('id', $request->ad_id)->first();
            $information['data'] = PrivatePackage::where('id', $information['ad_id']->package_id)->first();
            $information['vendor'] =$information['ad_id']->vendor;
            
            if($information['data']->price == 0 )
            {
                $statusUpdate = Car::findOrFail($request->ad_id);
                $statusUpdate->update(['status' => 1]);
                
                $headermail =   view('email.mailheader')->render();
                $footermail =  view('email.mailfooter')->render();  
    
                $mailSubject = $information['ad_id']->car_content->title .' -  ad is Published';
                $mailBody = view('email.ads.newad', $information); 
    
                $info = DB::table('basic_settings')
                ->select('website_title', 'smtp_status', 'smtp_host', 'smtp_port', 'encryption', 'smtp_username', 'smtp_password', 'from_mail', 'from_name')
                ->first();      
    
                $headermail .= $mailBody; 
                
                $headermail .= $footermail;
                
                $carContent = $information['ad_id'];
            
                $url =  route('frontend.car.details', ['cattitle' => catslug($carContent->car_content->category_id), 'slug' => $carContent->car_content->slug, 'id' => $carContent->id]);
                
                $manageUrl = url('customer/ad-management?language=en');
                
                 $image_path = $carContent->feature_image;
                
                $rotation = 0;
                
                if($carContent->rotation_point > 0 )
                {
                    $rotation = $carContent->rotation_point;
                }
                
                if(!empty($image_path) && $carContent->rotation_point == 0 )
                {   
                   $rotation = $carContent->galleries->where('image' , $image_path)->first();
                   
                   if($rotation == true)
                   {
                        $rotation = $rotation->rotation_point;  
                   }
                   else
                   {
                        $rotation = 0;   
                   }
                }
                
                if(empty($carContent->feature_image))
                {
                    $image_path = $carContent->galleries[0]->image;
                    $rotation = $carContent->galleries[0]->rotation_point;
                }
                
                $imageUrl = $carContent->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path;
                
                
                
            $headermail = view('email.sendaddlive' ,  compact('carContent' , 'url' , 'manageUrl' , 'imageUrl' , 'rotation' ))->render();
            
            $data = [
                'subject' => $mailSubject,
                'to' => $information['ad_id']->vendor->email,
                'body' => $headermail,
            ];
            
            if ($info->smtp_status == 1) 
            {
                try 
                {
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
                } 
                catch (\Exception $e) 
                {
                    Session::flash('error', $e->getMessage());
                    return back();
                }
            }
              
              try 
              {
                Mail::send([], [], function (Message $message) use ($data, $info) 
                {
                    $fromMail = $info->from_mail;
                    $fromName = $info->from_name;
                    $message->to($data['to'])
                        ->subject($data['subject'])
                        ->from($fromMail, $fromName)
                        ->html($data['body'], 'text/html');
                });
             
            } 
            catch (\Exception $e) 
            {
                return response()->json([
                    'error' => 'something went wrong'
                ], 500);
            }
            
            return response()->json([
                    'success' => 'Congratulations! Your ad is being live soon'
                ], 500);

            }
            else 
            {
                session(['appUrl' => $request->appUrl]);
                return view('v1.payment', $information);
            }
        }

   
}
