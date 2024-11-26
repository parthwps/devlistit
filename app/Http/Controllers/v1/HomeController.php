<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\MiscellaneousController;
use App\Http\Helpers\BasicMailer;
use App\Models\BasicSettings\Basic;
use App\Models\BasicSettings\MailTemplate;
use App\Models\Car\Category;
use App\Models\Conversation;
use App\Models\SupportTicket;
use App\Models\Car\CarSpecification;
use App\Models\Car;
use App\Models\Vendor;
use App\Models\Car\Wishlist;
use App\Rules\MatchOldPasswordRule;
use Carbon\Carbon;
use Mews\Purifier\Facades\Purifier;
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
use App\Models\BrowsingHistory;
use PHPMailer\PHPMailer\PHPMailer;
use Str;
use App\Models\CountryArea;
use App\Models\CarYear;
use App\Models\Car\EngineSize;
use App\Models\Car\CarPower;
use App\Models\AdsPrice;
use App\Models\AdsMileage;
use App\Models\AdReport;
use App\Models\Car\Brand;
use App\Models\Car\CarColor;
use App\Models\Car\CarContent;
use App\Models\Car\CarModel;
use App\Models\Car\FuelType;
use App\Models\Car\FormFields;
use App\Models\Car\TransmissionType;
use App\Models\Car\CustomerSearch;
use App\Models\Car\BodyType;

class HomeController extends Controller
{
      public function __construct()
      {
        
      }
      
      function getFilterData(Request $request)
      {
          
        $information['category'] = Category::select('id' , 'name' , 'slug' , 'parent_id' , 'filters')->where('id' , $request->category_id)->first();
        
        if ($request->category_id === null || $request->category_id === '' || $request->category_id == 0) 
        {
            $information['categories'] =  array('label' => 'Categories' , 'type' => 'select' , 'value' => Category::select('id' , 'name' , 'slug')->where('parent_id' , 0)->get());
            
            return response()->json($information , 200 );
        }
        else
        {
           $information['categories'] = array('label' => 'Categories' , 'type' => 'select' , 'value' =>  Category::select('id' , 'name' , 'slug')->where('status', 1)->where('parent_id', $request->category_id )->get()); 
        }
        
        
        $popularBrands = null;
        
        $cate_id = $information['category'] ? [$information['category']->id] : [];
        
        if($information['category'] && $information['category']->parent_id == 0)
        {
            $cate_id =  $information['category']->children()->pluck('id');
        }
        
        $filters = $this->getCategoriesFilter($request->category_id);
        
        if(!empty($filters))
        {
            $form_fields = FormFields::with('form_options')
            ->whereIn('category_field_id', $filters)
            ->get();
            
            if($form_fields->count() > 0 )
            {
               $filterData = $this->getFilter($form_fields);
              
               foreach($filterData as $key => $filter)
               {
                   $key = str_replace('::'.$filter->type , '' ,  $key);
                   
                   $optionsArray = [];
                   
                   if($filter->type == 'select' && !empty($filter->form_options) )
                   {
                       foreach ($filter->form_options as $form_option)
                       {
                           $optionsArray[] = array( 'option' => $form_option->value);
                       }
                       
                       $filtersArray['filters_select_'.strtolower(str_replace(' ' , '_' , $key ))] = array('label' => $key ,'type' => 'select'  , 'value' => $optionsArray);
                   }
                   elseif($filter->type == 'radio' && !empty($filter->form_options) )
                   {
                       foreach ($filter->form_options as $form_option)
                       {
                           $optionsArray[] = array('option' => $form_option->value);
                       }
                       
                       $filtersArray['filters_radio_'.strtolower(str_replace(' ' , '_' , $key ))] = array('label' => $key ,'type' => 'radio'  , 'value' => $optionsArray);
                   }
                   elseif($filter->type == 'checkbox' && !empty($filter->form_options))
                   {
                        foreach ($filter->form_options as $form_option)
                       {
                           $optionsArray[] = array( 'option' => $form_option->value);
                       }
                       
                       $filtersArray['filters_checkbox_'.strtolower(str_replace(' ' , '_' , $key ))] = array('label' => $key ,'type' => 'checkbox'  , 'value' => $optionsArray);
                   }
               }
            }
        }
        
        
        
        if(!empty($filtersArray) && $information['category']->brands()->count() == 0 &&  $information['category']->id != 24)
        {
            $information['location'] = array('label' => 'Location' , 'type' => 'select' , 'value' => CountryArea::where('status', 1)->orderBy('name', 'asc')->get() );
        
            $information['prices'] =  array('label' => 'Prices' , 'type' => 'select' , 'value' =>  AdsPrice::where('status', 1)->orderBy('id', 'asc')->get() );  
        
            $mergedArray =  array_merge_recursive($information , $filtersArray);
        }
        else
        {
            
            if (in_array('make', json_decode($information['category']->filters))) 
            {
                $popularBrands = Brand::select('id' , 'name' , 'slug' , 'cat_id')->whereIn('cat_id', $cate_id)
                ->where('status', 1)
                ->withCount('cars')
                ->orderBy('cars_count', 'desc')
                ->orderBy('name', 'asc')
                ->take(10)
                ->get();
                
                $otherBrands = Brand::whereIn('cat_id',  $cate_id )
                ->where('status', 1)
                ->orderBy('name', 'asc')
                ->get(['id' , 'name' , 'slug' , 'cat_id']);
           
            
            // Combine results for view
            $information['popular_makes'] = array('label' => 'Popular Makes' , 'type' => 'select' , 'value' => $popularBrands );
            
            $information['other_makes'] = array('label' => 'Other Makes' , 'type' => 'select' , 'value' => $otherBrands );
            
            $information['car_model_id'] = array('label' => 'Model' , 'type' => 'select' , 'value' => 'Any' );
            
            }
            
            $information['location'] = array('label' => 'Location' , 'type' => 'select' , 'value' => CountryArea::where('status', 1)->orderBy('name', 'asc')->get() );
        
            $information['prices'] =  array('label' => 'Prices' , 'type' => 'select' , 'value' =>  AdsPrice::where('status', 1)->orderBy('id', 'asc')->get() ); 
            
            
            if (in_array('colour', json_decode($information['category']->filters))) 
            {
                $information['car_colour_id'] = array('label' => 'Colour' , 'type' => 'select' , 'value' => CarColor::where('status', 1)->orderBy('serial_number', 'asc')->get(['id' , 'name' , 'slug']) ) ;
            }
            
            if (in_array('fuel_types', json_decode($information['category']->filters))) 
            {
                $information['fuel_type_id'] =  array('label' => 'Fuel Type' , 'type' => 'select' , 'value' => FuelType::where('status', 1)->orderBy('serial_number', 'asc')->get(['id' , 'name' , 'slug']) ) ;
            }
            
             if (in_array('transmision_type', json_decode($information['category']->filters))) 
            {
                $information['transmission_type_id'] =   array('label' => 'Transmission Type' , 'type' => 'select' , 'value' => TransmissionType::where('status', 1)->orderBy('serial_number', 'asc')->get(['id' , 'name' , 'slug']) ) ;
            }
            
             if (in_array('body_type', json_decode($information['category']->filters))) 
            {
                $cate_id = json_decode(json_encode($cate_id) , true);
                
                if(in_array(24 , $cate_id))
                {
                    $information['body_type_id'] =  array('label' => 'Body Type' , 'type' => 'select' , 'value' =>  BodyType::where('status', 1)->orderBy('serial_number', 'asc')->get());
                }
                else
                {
                    $information['body_type_id'] =  array('label' => 'Body Type' , 'type' => 'select' , 'value' => BodyType::where('status', 1)->whereIn('cat_id' , $cate_id)->orderBy('serial_number', 'asc')->get() );
                }
            }
            
            if (in_array('year', json_decode($information['category']->filters))) 
            {
                $information['year'] = array('label' => 'Year' , 'type' => 'select' , 'value' =>   CarYear::where('status', 1)->orderBy('name', 'desc')->get() ) ;
            }
            
            if (in_array('mileage', json_decode($information['category']->filters))) 
            {
                $information['mileage'] =  array('label' => 'Mileage' , 'type' => 'select' , 'value' =>   AdsMileage::where('status', 1)->orderBy('id', 'asc')->get() ) ;
            }
            
            if (in_array('engine', json_decode($information['category']->filters))) 
            {
                $information['engineCapacity'] =  array('label' => 'Engine Size' , 'type' => 'select' , 'value' => EngineSize::where('status', 1)->orderBy('id', 'asc')->get() ) ;
            }
            
            if (in_array('power', json_decode($information['category']->filters))) 
            {
                $information['power'] = array('label' => 'Power' , 'type' => 'select' , 'value' =>  CarPower::where('status', 1)->orderBy('id', 'asc')->get() ) ;
            }
            
             if (in_array('owners', json_decode($information['category']->filters))) 
            {
                $information['owners'] = array('label' => 'No of owners' , 'type' => 'select'   , 'value' => [2,3,4,5,6]);
            }
            
            
             if (in_array('doors', json_decode($information['category']->filters))) 
            {
                $information['doors'] = array('label' => 'No of doors' , 'type' => 'select' , 'value' => [2,3,4,5,6]);
            }
            
        
           if (in_array('seat_count', json_decode($information['category']->filters))) 
            {
                $information['seats'] = array('label' => 'Seat count' , 'type' => 'select' , 'value' => [2,3,4,5,6,7,8]);
            }
            
            if ($information['category']->id == 24  || $information['category']->parent_id == 24 ) 
            {
                $information['ad_type'] = array('label' => 'Ad Type' , 'type' => 'radio' , 'value' => ['sale' , 'wanted']);
            }
            
             if ($information['category']->id == 24  || $information['category']->parent_id == 24 ) 
            {
                $information['dealer_type'] = array('label' => 'Seller Type' , 'type' => 'radio' , 'value' => ['any' , 'private' , 'dealer']);
            }
            
            
             $mergedArray =  array_merge_recursive($information , $filtersArray);
        
        }
        
        unset($information['category']['filters']);
        
        return response()->json($mergedArray , 200 );
      }
      
      
        function getFilter($form_fields)
    {
        $unique_form_fields = [];
        
        foreach ($form_fields as $form_field) 
        {
            $label = $form_field->label;
            $type = $form_field->type;  // Assuming that the form field has a 'type' property
            
            $options = $form_field->form_options->pluck('value')->toArray();
            
            $key = $label . '::' . $type;  // Create a unique key based on label and type
            
            if (!isset($unique_form_fields[$key])) 
            {
                $unique_form_fields[$key] = 
                [
                    'form_field' => $form_field,
                    'options' => $options,
                ];
            } 
            else 
            {
                $existing_options = $unique_form_fields[$key]['options'];
                
                if (array_diff($existing_options, $options) || array_diff($options, $existing_options)) 
                {
                    $unique_form_fields[$key]['options'] = array_unique(array_merge($existing_options, $options));
                }
            }
        }
        
        $unique_form_fields_collection = collect($unique_form_fields)->map(function ($item) 
        {
            return $item['form_field'];
        });
        
        return $unique_form_fields_collection;
    }
    
      
         function getCategoriesFilter($category_id)
    {
        $category_ids = [];
        $category = Category::where([['id', $category_id]])->first();
        
        if ($category) {
            $category_ids[] = $category->id;
            $this->loadingMoreCategory($category_ids, $category->id);
        }
        
        return $category_ids;
    }
    
    function loadingMoreCategory(&$category_ids, $category_id)
    {
        $category_childs = Category::where([['parent_id', $category_id]])->pluck('id');
        
        foreach ($category_childs as $category_child) {
            $category_ids[] = $category_child;
            $this->loadingMoreCategory($category_ids, $category_child);
        }
    }
    
    
    
      function vendorDetail(Request $request)
      {
          
         $rules = [
            'vendor_id' => 'required',
        ];
        
        $messages = [
            'vendor_id.required' => 'The vendor id field is required.'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) 
        {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }
        
        $vendor_id = $request->vendor_id; 
        
        $vendor = Vendor::find($vendor_id);
        
        if($vendor == false)
        {
              return response()->json(['error' => 'Vendor deleted or not found.'], 404);
        }
        
        $openingHours = DB::table('opening_hours')->where('vendor_id',$vendor_id)->get()->keyBy('day_of_week')->toArray();
        
        $ads = Car::with('vendor')
        ->join('car_contents', 'car_contents.car_id', 'cars.id')
        ->where('cars.vendor_id', $vendor_id)
        ->select('cars.*', 'car_contents.slug', 'car_contents.title', 'car_contents.category_id', 'car_contents.brand_id', 'car_contents.car_model_id')
        ->get();
        
        $userId = request()->user()->id;
        
         $ads = $ads->map(function ($car) use ($userId) 
            {
                
                $featureImageUrl = $car->vendor
                    ? ($car->vendor->vendor_type === 'normal'
                        ? asset('assets/admin/img/car-gallery/' . $car->feature_image)
                        : env('SUBDOMAIN_APP_URL') . 'assets/admin/img/car-gallery/' . $car->feature_image)
                    : asset('assets/admin/img/default-photo.jpg');
            
                    
                    $vendorPhotoUrl = asset('assets/img/blank-user.jpg'); // Default to blank user image
                    
                    if (!empty($car->vendor->photo)) 
                    {
                    $vendorPhotoUrl = $car->vendor->vendor_type === 'dealer'
                    ? env('SUBDOMAIN_APP_URL') . 'assets/admin/img/vendor-photo/' . $car->vendor->photo
                    : asset('assets/admin/img/vendor-photo/' . $car->vendor->photo);
                    }
                    
                
                    $effectivePrice = $car->price;
                    
                    if ($car->previous_price && $car->previous_price < $car->price) 
                    {
                        $effectivePrice = $car->previous_price;
                    }
                
                $vendorType = $car->vendor 
                    ? ($car->vendor->vendor_type === 'dealer' 
                        ? ($car->vendor->is_franchise_dealer ? 'Franchise Dealer' : 'Independent Dealer') 
                        : 'Private Seller') 
                    : 'Private Seller';
                
                $checkWishList = checkWishList($car->id, $userId);
                
                return [
                    'id' => $car->id,
                    'feature_image' => $featureImageUrl,
                    'price' => symbolPrice($effectivePrice),
                    'year' => $car->year,
                    'created_at' => calculate_datetime($car->created_at),
                    'slug' => $car->car_content ? $car->car_content->slug : null,
                    'title' => $car->car_content ? $car->car_content->title : null,
                    'fuel_type' => $car->car_content && $car->car_content->fuel_type ? $car->car_content->fuel_type->name : null,
                    'engine_capacity' => $car->engineCapacity ? roundEngineDisplacement($car) : null,
                    'mileage' => number_format($car->mileage) . ' mi',
                    'is_added_on_wishlist' => $checkWishList,
                    'vendor_name' => $car->vendor && $car->vendor->vendor_info ? $car->vendor->vendor_info->name : null,
                    'vendor_photo' => $vendorPhotoUrl,
                    'vendor_type' => $vendorType,
                    'user_type' => $car->vendor->vendor_type,
                ];
                
            });
       
     
        $vendorPhotoUrl = asset('assets/img/blank-user.jpg'); // Default to blank user image
        
        if (!empty($vendor->photo)) 
        {
            $vendorPhotoUrl = $vendor->vendor_type === 'dealer'
                ? env('SUBDOMAIN_APP_URL') . 'assets/admin/img/vendor-photo/' . $vendor->photo
                : asset('assets/admin/img/vendor-photo/' . $vendor->photo);
        }
                
        return  [
            'vendor_name' => $vendor && $vendor->vendor_info ? $vendor->vendor_info->name : null,
            'vendor_photo' => $vendorPhotoUrl,
            'vendor_type' => $vendor ? ($vendor->vendor_type === 'dealer' ? ($vendor->is_franchise_dealer ? 'Franchise Dealer' : 'Independent Dealer') : 'Private Seller') : 'Private Seller',
            'user_type' => $vendor->vendor_type,
            'address' => $vendor && $vendor->vendor_info ? $vendor->vendor_info->address : null,
            'member_since' => !empty($vendor->est_year) ? $vendor->est_year : date('Y'),            
            'active_ads' => !empty($vendor->cars) ? $vendor->cars->where('status' , 1)->count() : '0' ,    
            'openingHours' => $openingHours,
            'ads' => $ads
        ];
        
      }
      
      function sendMessage(Request $request)
      {
          
        $rules = [
            'user_type' => 'required',
            'ad_id' => 'required',
            'description' => 'required',
            'full_name' => 'required_if:user_type,dealer',
            'phone_no' => 'required_if:user_type,dealer',
            'purpose_name' => 'required_if:user_type,dealer|array', // Ensure it's treated as an array
            'purpose_name.*' => 'nullable|string', // Allow individual fields to be strings
        ];
        
        $messages = [
            'user_type.required' => 'User type is required.',
            'ad_id.required' => 'The ad ID field is required.',
            'description.required' => 'The description field is required.',
            'full_name.required_if' => 'The full name field is required when the user type is dealer.',
            'phone_no.required_if' => 'The phone number field is required when the user type is dealer.',
            'purpose_name.required_if' => 'At least one purpose name from (trading , conditions , scheduling or financing) is required when the user type is dealer.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) 
        {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }
        
        $in = $request->all();
        
        if($request->user_type == 'dealer')
        {
            $message = 'Name : '.$request->full_name. '<br>Phone : '.$request->phone_no;
            
            if(!empty($request->purpose_name) && count($request->purpose_name) > 0 )
            {
                 $message .= '<br><br>Iam interested in ... <br><br>';
                 
                foreach($request->purpose_name as $list)
                {
                   if($list == 'trading')
                   {
                       $message .= 'Trading in my current vehicle <br>';
                   }
                   else if($list == 'conditions')
                   {
                       $message .= 'More about condition <br>';
                   }
                    else if($list == 'scheduling')
                   {
                       $message .= 'Scheduling test drive <br>';
                   }
                    else if($list == 'financing')
                   {
                       $message .= 'Financing this vehicle <br>';
                   }
                }
            }
            
            $message .=  '<br>'.Purifier::clean($request->description, 'youtube');
        }
         
        $carContent = Car::find( $request->ad_id);
         
        $in['subject'] = $carContent->car_content->title; 
        $in['admin_id'] = $carContent->vendor->id; 
        $in['user_id'] = request()->user()->id;
        $in['user_type'] = 'vendor';
        $in['ad_id'] = $request->ad_id;
        $in['description'] = ($request->user_type == 'dealer') ? $message : Purifier::clean($request->description, 'youtube');
       
        $lattId = SupportTicket::create($in);
        
        $in['message_to'] = $carContent->vendor->id; 
        $in['support_ticket_id'] = $lattId->id; 
        $in['reply'] =  ($request->user_type == 'dealer' ) ? $message : Purifier::clean($request->description, 'youtube');

        $data = new Conversation();
        
        $data->create($in);
        
        $vendor = Vendor::find($carContent->vendor->id);
      
        if($vendor == true)
        {
            $vendor_email =  $vendor->email;
           
            $description =  $in['description'];
            
            $vendor = request()->user();
            
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
            
            $chat_url = url('customer/support/message/'. $lattId->id );
            
            $HTML =  view('email.new-message', compact('carContent' , 'description' , 'vendor' , 'imageUrl' , 'rotation' , 'chat_url'))->render();
            // return $HTML;
            $data = ['recipient' => $vendor_email  , 'subject' => 'New Message'  , 'body' => $HTML ];
            
            \App\Http\Helpers\BasicMailer::sendMail($data);  
            
            
             if($request->user_type == 'dealer' && !empty($carContent->enquiry_person_id))
            {
                $jsonArry = json_decode($carContent->enquiry_person_id , true);
                
                foreach($jsonArry as $data)
                {
                    $enquiry_email = DB::table('enquiry_preferences')->where('id' , $data)->first();
                    
                    if($enquiry_email == true)
                    {
                        $name = $enquiry_email->name;
                        
                        $HTML =  view('email.new-message', compact('carContent' , 'description' , 'vendor' , 'imageUrl' , 'rotation' , 'chat_url' , 'name'))->render();
                        
                        $email = $enquiry_email->email;
                        
                        $data = ['recipient' => $email  , 'subject' => 'New Message'  , 'body' => $HTML ];
                        
                        \App\Http\Helpers\BasicMailer::sendMail($data);  
                    }
                }
            }
        }
        
        return response()->json(['response' => 'message sent successfully']);
        
      }
      
      function reportAd(Request $request)
      {
           $rules = [
                'report_reason' => 'required',
                'report_detail' => 'required',
                'ad_id' => 'required',
                'report_detail' => 'required',
            ];
            
            $messages = [
                'report_reason.required' => 'The reason for report field is required.',
                 'ad_id.required' => 'The ad id field is required.',
                'report_detail.required' => 'Please provide us with the report details so we can review them thoroughly.'
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()) 
            {
                return response()->json([
                    'error' => $validator->errors()
                ], 422);
            }
            
            
            $reasonOption =   $request->report_reason;
            $user_id      =   request()->user()->id;
            $explaination =   $request->report_detail;
            $ad_id        =   $request->ad_id;
            
            $checkpoint = AdReport::where('ad_id' , $ad_id )->where('user_id' , $user_id)->first();
            
            if($checkpoint == false)
            {
                AdReport::create(['ad_id' => $ad_id ,'user_id' => $user_id ,'reason' => $reasonOption ,'explaination' => $explaination  ]); 
            }
            
            return response()->json(['response' => 'successfully submited']);
    
      }
      
      function showPhoneNumber(Request $request)
      {
              $rules = [
                'ad_id' => 'required',
            ];
            
            $messages = [
                'ad_id.required' => 'The ad id field is required.'
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()) 
            {
                return response()->json([
                    'error' => $validator->errors()
                ], 422);
            }
            
            $ad_id =  $request->ad_id;
            
            $car = Car::find( $ad_id);
            
            $counter = 0;
            
            if($car == true)
            {
                $counter = $car->phone_no_revel;
            }
            
            Car::where('id' , $ad_id)->update(['phone_no_revel' => $counter+1]);
            
           return response()->json(['phone' => $car->vendor->phone ], 200);
      }
      
      function adDetail(Request $request)
      {
          
        $rules = [
            'ad_id' => 'required',
        ];
        
        $messages = [
            'ad_id.required' => 'The ad id field is required.'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) 
        {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }
        
        $ad_id = $request->ad_id;

        // Fetch the ad with necessary relations
        $ad = Car::with([
            'galleries:id,car_id,rotation_point,priority,user_id,image',
            'car_content:id,car_id,slug,title,description,category_id,fuel_type_id,brand_id,car_model_id,transmission_type_id',
            'car_content.fuel_type:id,name',
            'car_content.brand:id,name',
            'car_content.model:id,name',
            'car_content.transmission_type:id,name',
            'vendor:id,vendor_type,photo,is_franchise_dealer,est_year',
            'vendor.vendor_info:id,name,vendor_id,city'
        ])->where('id', $ad_id)->first();

        if (!$ad) 
        {
            return response()->json(['error' => 'Ad deleted or not found.'], 404);
        }
        
        $userId = request()->user()->id;
        
        $adId = $ad->id;
        
        $category_id = $ad->car_content->category_id;
        
        $currentTimestamp = now()->format('Y-m-d H:i');
        
        $existingRecord = DB::table('browsing_histories')
            ->where('user_id', $userId)
            ->where('ad_id', $adId)
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') = ?", [$currentTimestamp])
            ->exists();
        
        if (!$existingRecord) 
        {
            BrowsingHistory::create([
                'user_id' => $userId,
                'ad_id' => $adId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        $openingHours = DB::table('opening_hours')->where('vendor_id', $ad->vendor->id)->get()->keyBy('day_of_week')->toArray();
        
        if ($ad->vendor->vendor_type == 'normal') {
            $specifications = CarSpecification::where('car_id', $adId)->get();
            $specification_pluck = null;
        } else {
            $specifications = DB::table('vehicle_features')->where('add_id', $adId)->get();
            $specification_pluck = DB::table('vehicle_features')->where('add_id', $adId)->distinct()->pluck('parent_name');
        }
      
        // Fetch related cars
        if ($ad->vendor->vendor_type == 'normal') {
            $related_cars = Car::with('vendor')
                ->join('car_contents', 'car_contents.car_id', 'cars.id')
                ->where('car_contents.category_id', $category_id)
                ->where('cars.id', '!=', $adId)
                ->select('cars.*', 'car_contents.slug', 'car_contents.title', 'car_contents.category_id', 'car_contents.brand_id', 'car_contents.car_model_id')
                ->limit(6)
                ->get();
        } else {
            $related_cars = Car::with('vendor')
                ->join('car_contents', 'car_contents.car_id', 'cars.id')
                ->where('cars.id', '!=', $adId)
                ->where('cars.vendor_id', $ad->vendor->id)
                ->select('cars.*', 'car_contents.slug', 'car_contents.title', 'car_contents.category_id', 'car_contents.brand_id', 'car_contents.car_model_id')
                ->limit(6)
                ->get();
        }
        
            // Fetch latest cars
            $latest_cars = Car::join('car_contents', 'car_contents.car_id', 'cars.id')
                ->where('cars.id', '!=', $adId)
                ->orderBy('id', 'desc')
                ->select('cars.*', 'car_contents.slug', 'car_contents.category_id', 'car_contents.title', 'car_contents.brand_id', 'car_contents.car_model_id')
                ->limit(4)
                ->get();
            
            $specfit = [];
            
            if ($ad->vendor->vendor_type == 'dealer' && $specification_pluck->count() > 0 && $specifications->count() > 0)
            {
               foreach($specification_pluck as $speci_pluck)
               {
                   $label = str_replace('_N_' , ' & ' ,  strtoupper($speci_pluck ));
                   $specification_data = [];
                   
                   	foreach ($specifications as $specification)
                   	{
               	    	if($specification->parent_name === $speci_pluck)
               	    	{
               	    	    $specification_data[] = str_replace('_' , ' ' ,  ucfirst($specification->value ));
               	    	} 
                   	}
                   	
                   	$specfit[] = array('label' => $label , 'data' =>  $specification_data);
               }
               
            }
    
    
            $related_cars = $related_cars->map(function ($car) use ($userId) 
            {
                
                $featureImageUrl = $car->vendor
                    ? ($car->vendor->vendor_type === 'normal'
                        ? asset('assets/admin/img/car-gallery/' . $car->feature_image)
                        : env('SUBDOMAIN_APP_URL') . 'assets/admin/img/car-gallery/' . $car->feature_image)
                    : asset('assets/admin/img/default-photo.jpg');
            
                    
                    $vendorPhotoUrl = asset('assets/img/blank-user.jpg'); // Default to blank user image
                    
                    if (!empty($car->vendor->photo)) 
                    {
                    $vendorPhotoUrl = $car->vendor->vendor_type === 'dealer'
                    ? env('SUBDOMAIN_APP_URL') . 'assets/admin/img/vendor-photo/' . $car->vendor->photo
                    : asset('assets/admin/img/vendor-photo/' . $car->vendor->photo);
                    }
        
                
                    $effectivePrice = $car->price;
                    
                    if ($car->previous_price && $car->previous_price < $car->price) 
                    {
                        $effectivePrice = $car->previous_price;
                    }
                
                $vendorType = $car->vendor 
                    ? ($car->vendor->vendor_type === 'dealer' 
                        ? ($car->vendor->is_franchise_dealer ? 'Franchise Dealer' : 'Independent Dealer') 
                        : 'Private Seller') 
                    : 'Private Seller';
                
                $checkWishList = checkWishList($car->id, $userId);
                
                return [
                    'id' => $car->id,
                    'feature_image' => $featureImageUrl,
                    'price' => symbolPrice($effectivePrice),
                    'year' => $car->year,
                    'created_at' => calculate_datetime($car->created_at),
                    'slug' => $car->car_content ? $car->car_content->slug : null,
                    'title' => $car->car_content ? $car->car_content->title : null,
                    'fuel_type' => $car->car_content && $car->car_content->fuel_type ? $car->car_content->fuel_type->name : null,
                    'engine_capacity' => $car->engineCapacity ? roundEngineDisplacement($car) : null,
                    'mileage' => number_format($car->mileage) . ' mi',
                    'is_added_on_wishlist' => $checkWishList,
                    'vendor_name' => $car->vendor && $car->vendor->vendor_info ? $car->vendor->vendor_info->name : null,
                    'vendor_photo' => $vendorPhotoUrl,
                    'vendor_type' => $vendorType,
                    'user_type' => $car->vendor->vendor_type,
                ];
                
            });
            
            $latest_cars = $latest_cars->map(function ($car) use ($userId) 
            {
                $featureImageUrl = $car->vendor
                    ? ($car->vendor->vendor_type === 'normal'
                        ? asset('assets/admin/img/car-gallery/' . $car->feature_image)
                        : env('SUBDOMAIN_APP_URL') . 'assets/admin/img/car-gallery/' . $car->feature_image)
                    : asset('assets/admin/img/default-photo.jpg');
            
                
                $vendorPhotoUrl = asset('assets/img/blank-user.jpg'); // Default to blank user image
                    
                    if (!empty($car->vendor->photo)) 
                    {
                    $vendorPhotoUrl = $car->vendor->vendor_type === 'dealer'
                    ? env('SUBDOMAIN_APP_URL') . 'assets/admin/img/vendor-photo/' . $car->vendor->photo
                    : asset('assets/admin/img/vendor-photo/' . $car->vendor->photo);
                    }
            
                $effectivePrice = $car->price;
                
                if ($car->previous_price && $car->previous_price < $car->price) 
                {
                    $effectivePrice = $car->previous_price;
                }
            
                $vendorType = $car->vendor 
                ? ($car->vendor->vendor_type === 'dealer' 
                    ? ($car->vendor->is_franchise_dealer ? 'Franchise Dealer' : 'Independent Dealer') 
                    : 'Private Seller') 
                : 'Private Seller';
            
                $checkWishList = checkWishList($car->id, $userId);
                
                return [
                    'id' => $car->id,
                    'feature_image' => $featureImageUrl,
                    'price' => symbolPrice($effectivePrice),
                    'year' => $car->year,
                    'created_at' => calculate_datetime($car->created_at),
                    'slug' => $car->car_content ? $car->car_content->slug : null,
                    'title' => $car->car_content ? $car->car_content->title : null,
                    'fuel_type' => $car->car_content && $car->car_content->fuel_type ? $car->car_content->fuel_type->name : null,
                    'engine_capacity' => $car->engineCapacity ? roundEngineDisplacement($car) : null,
                    'mileage' => number_format($car->mileage) . ' mi',
                    'is_added_on_wishlist' => $checkWishList,
                    'vendor_name' => $car->vendor && $car->vendor->vendor_info ? $car->vendor->vendor_info->name : null,
                    'vendor_photo' => $vendorPhotoUrl,
                    'vendor_type' => $vendorType,
                    'user_type' => $car->vendor->vendor_type,
                ];
            });


            $featureImageUrl = $ad->vendor
                    ? ($ad->vendor->vendor_type === 'normal'
                        ? asset('assets/admin/img/car-gallery/' . $ad->feature_image)
                        : env('SUBDOMAIN_APP_URL') . 'assets/admin/img/car-gallery/' . $ad->feature_image)
                    : asset('assets/admin/img/default-photo.jpg');
                    
                    
    $filters = [];
    
    if (!empty($ad->filters)) 
    {
        $filtrs = json_decode($ad->filters, true);
        
        foreach ($filtrs as $key => $filter) 
        {
            $keyFormatted = ucwords(strtolower(trim(str_replace(['select', 'radio', 'input', 'textarea', 'checkbox'], '', str_replace('_', ' ', $key)))));
            
            if (strpos($key, 'select') !== false)
            {
               if(!empty($filter))
                {
                   $filters[ucwords(strtolower(str_replace('select', '', str_replace('_', ' ', $key))))] = $filter;
                }
            }
            
            if (strpos($key, 'radio') !== false)
            {
                if(!empty($filter))
                {
                   $filters[ucwords(strtolower(str_replace('radio', '', str_replace('_', ' ', $key))))] = $filter;
                }
            }
            
            if (strpos($key, 'input') !== false)
            {
                 if(!empty($filter))
                {
                  $filters[ucwords(strtolower(str_replace('input', '', str_replace('_', ' ', $key))))] =  str_replace('_', ' ', $filter);
                }
            }
            
            if (strpos($key, 'textarea') !== false)
            {
                if(!empty($filter))
                {
                  $filters[ucwords(strtolower(str_replace('textarea', '', str_replace('_', ' ', $key))))] = $filter;  
                }
            }
            
            if (strpos($key, 'checkbox') !== false)
            {
                $selectArray = [];
                
                if(is_array($filter))
                {
                    foreach($filter as $list)
                    {
                        if(!empty($list))
                        {
                            $selectArray[] = $list; 
                        }
                    }
                }
                else
                {
                    $selectArray = $filter;
                }
                
                if(!empty($selectArray))
                {
                    $filters[ucwords(strtolower(str_replace('checkbox', '', str_replace('_', ' ', $key))))] =  $selectArray;
                }
            }
        }
    }
    
    $sepecification = [
        'Condition' => $ad->what_type ? str_replace('_', ' ', $ad->what_type) : null,
        'Model_Year' => $ad->year,
        'Mileage' => $ad->mileage ? number_format($ad->mileage) : null,
        'Top_Speed' => $ad->speed ? $ad->speed . ' KMH' : null,
        'Make' => $ad->car_content && $ad->car_content->brand ? $ad->car_content->brand->name : null,
        'Model' => $ad->car_content && $ad->car_content->model ? $ad->car_content->model->name : null,
        'Fuel_Type' => $ad->car_content && $ad->car_content->fuel_type ? $ad->car_content->fuel_type->name : null,
        'Transmission' => $ad->car_content && $ad->car_content->transmission_type ? $ad->car_content->transmission_type->name : null,
        'Engine_Capacity' => $ad->engineCapacity ? roundEngineDisplacement($ad) : null,
        'Battery_Range' => ($ad->car_content && in_array(optional($ad->car_content->fuel_type)->name, ['Electric', 'Hybrid'])) ? ($ad->bettery_range ? $ad->bettery_range : $ad->battery . ' + M') : null,
        'Location' => $ad->current_area_regis ? ucfirst($ad->current_area_regis) : null,
        'History_Checked' => $ad->history_checked > 0 ? 'Yes' : 'No',
        'Delivery_Available' => $ad->delivery_available > 0 ? 'Yes' : 'No',
        'Warranty_Type' => $ad->warranty_type,
        'Warranty_Duration' => $ad->warranty_duration ? $ad->warranty_duration : $ad->warranty,
        'Power' => $ad->power,
        'Road_Tax' => $ad->road_tax,
        'Number_Of_Owners' => $ad->number_of_owners ? $ad->number_of_owners : $ad->owners,
        'Doors' => $ad->doors,
        'Seats' => $ad->seats
    ];
    
    $filters = array_combine(
    array_map(function($key) 
    {
        return str_replace(' ', '_', trim($key));
        
    }, array_keys($filters)),
    $filters
    );

    
    if(!empty($ad->filters) && !empty($ad->year))
    {
      $sepecification = array_merge($sepecification, $filters);  
    }
    
    if(!empty($ad->filters) && empty($ad->year))
    {
        $sepecification = $filters;
    }
    
    
    
    $adData = [
        'id' => $ad->id,
        'feature_image' => $featureImageUrl,
        'price' => symbolPrice($ad->price),
        'youtube_video' => $ad->youtube_video,
        'year' => $ad->year,
        'created_at' => calculate_datetime($ad->created_at),
        'slug' => $ad->car_content ? $ad->car_content->slug : null,
        'title' => $ad->car_content ? $ad->car_content->title : null,
        'description' => $ad->car_content ? $ad->car_content->description : null,
        'is_added_on_wishlist' => checkWishList($ad->id, $userId),
        'vendor' => 
        [
            'vendor_id' => $ad->vendor->id,
            'vendor_name' => $ad->vendor && $ad->vendor->vendor_info ? $ad->vendor->vendor_info->name : null,
            'vendor_photo' => !empty($ad->vendor->photo) ? asset('assets/admin/img/vendor-photo/' . $ad->vendor->photo) : asset('assets/img/blank-user.jpg'),
            'vendor_type' => $ad->vendor ? ($ad->vendor->vendor_type === 'dealer' ? ($ad->vendor->is_franchise_dealer ? 'Franchise Dealer' : 'Independent Dealer') : 'Private Seller') : 'Private Seller',
            'user_type' => $ad->vendor->vendor_type,
            'vendor_response_time' => calculate_response_time($ad->vendor->id),
            'location' => $ad->vendor && $ad->vendor->vendor_info ? ucfirst($ad->vendor->vendor_info->city) : null,
            'member_since' => !empty($ad->vendor->est_year) ? $ad->vendor->est_year : date('Y'),            
            'active_ads' => !empty($ad->vendor->cars) ? $ad->vendor->cars->where('status' , 1)->count() : '0' ,            
            'life_time_ads' => !empty($ad->vendor->cars) ? $ad->vendor->carsWithTrashed->count() : '0',    
            'openingHours' => $openingHours,
        ],
        'galleries' => $ad->galleries->map(function ($gallery) use ($ad) 
        {
            
            $galleryImageUrl = $ad->vendor
                ? ($ad->vendor->vendor_type === 'normal'
                    ? asset('assets/admin/img/car-gallery/' . $gallery->image)
                    : env('SUBDOMAIN_APP_URL') . 'assets/admin/img/car-gallery/' . $gallery->image)
                : asset('assets/admin/img/default-photo.jpg');
            
            return [
                'id' => $gallery->id,
                'car_id' => $gallery->car_id,
                'rotation_point' => $gallery->rotation_point,
                'priority' => $gallery->priority,
                'image' => $galleryImageUrl,
            ];
        }),
   
        'specifications' => $sepecification,
        'vehicle_features' =>  $specfit,
        'related_cars' => $related_cars,
        'latest_cars' => $latest_cars,
        
    ];
    
    
    
        return response()->json($adData , 200);
          
      }
      
      function wishlistAddOrRemove(Request $request)
      {
          
         $rules = [
        'car_id' => 'required',
        ];
        
        $messages = [
            'car_id.required' => 'The car id field is required.'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) 
        {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }
        
          $user_id = request()->user()->id;
          $id = $request->car_id;
          $check = Wishlist::where('car_id', $id)->where('user_id', $user_id)->first();
    
          if (!empty($check)) 
          {
             Wishlist::where('car_id' , $id)->where('user_id' , $user_id)->delete();
            $notification = array('message' => 'This ad is removed from your wishlist!');
            return response()->json($notification , 200);
          } 
          else 
          {
            $add = new Wishlist;
            $add->car_id = $id;
            $add->user_id = $user_id;
            $add->save();
            $notification = array('message' => 'Successfully Added Wishlist');
            return response()->json($notification , 200);
          }
      }
  
    public function categoryAds(Request $request)
    {
        $category_id = $request->category_id;
        $sub_category_id = $request->sub_category_id;
        $perPage = 10;
        $searchQuery = $request->input('search_query'); // Assuming you get 'search_query' from request
    
        if ((is_null($category_id) || $category_id === '') && 
            (is_null($sub_category_id) || $sub_category_id === '') && 
            empty($searchQuery)) 
        {
            return response()->json(['error' => 'Category or Sub category Id or search query required'], 400);
        }
    
        $query = Car::where('status', 1)
            ->with([
                'car_content:id,car_id,slug,title,fuel_type_id,main_category_id,category_id', // Include fuel_type_id here
                'car_content.fuel_type:id,name', // Assuming fuel_type has 'id' and 'name' fields
                'vendor:id,vendor_type,photo,is_franchise_dealer', // Include vendor fields
                'vendor.vendor_info:id,name,vendor_id'
            ])
            ->latest();
    
        $category_id = !empty($category_id) ? $category_id : 0;
    
        if ($category_id == 0 && empty($sub_category_id)) 
        {
            $category_ids = Category::where('status', 1)
                ->where('parent_id', 0)
                ->pluck('id');
                
            $query->whereHas('car_content', function ($query) use ($category_ids) {
                $query->whereIn('main_category_id', $category_ids);
            });
        } 
        else 
        {
            if (empty($sub_category_id) && $category_id > 0) 
            {
                $query->whereHas('car_content', function ($query) use ($category_id) {
                    $query->where('main_category_id', $category_id);
                });
            } 
            else 
            {
                $query->whereHas('car_content', function ($query) use ($sub_category_id) {
                    $query->where('category_id', $sub_category_id);
                });  
            }
        }
    
        if (!empty($searchQuery)) 
        {
            $query->whereHas('car_content', function ($query) use ($searchQuery) {
                $query->where('title', 'LIKE', '%' . $searchQuery . '%');
            });
        }
    
        $ads = $query->paginate($perPage, ['id', 'feature_image', 'year', 'price', 'engineCapacity', 'mileage', 'previous_price', 'vendor_id', 'created_at']);
        
        // Transform the items in the paginated collection
        $ads->getCollection()->transform(function ($car) 
        {
            $effectivePrice = $car->price;
            if ($car->previous_price && $car->previous_price < $car->price) 
            {
                $effectivePrice = $car->previous_price;
            }
    
            // Construct the URL for the feature image based on vendor type
            $featureImageUrl = $car->vendor
                ? ($car->vendor->vendor_type === 'normal'
                    ? asset('assets/admin/img/car-gallery/' . $car->feature_image)
                    : env('SUBDOMAIN_APP_URL') . 'assets/admin/img/car-gallery/' . $car->feature_image)
                : asset('assets/admin/img/default-photo.jpg');
    
            // Vendor photo and type logic
            $vendorPhotoUrl = $car->vendor
                ? ($car->vendor->vendor_type === 'normal'
                    ? asset('assets/admin/img/vendor-photo/' . $car->vendor->photo)
                    : env('SUBDOMAIN_APP_URL') . 'assets/admin/img/vendor-photo/' . $car->vendor->photo)
                : asset('assets/img/blank-user.jpg');
    
            $vendorType = $car->vendor
                ? ($car->vendor->vendor_type === 'dealer'
                    ? ($car->vendor->is_franchise_dealer ? 'Franchise Dealer' : 'Independent Dealer')
                    : 'Private Seller')
                : 'Private Seller';
    
            // Check for wishlist
            $checkWishList = checkWishList($car->id, request()->user()->id);
    
            // Build the response structure
            return [
                'id' => $car->id,
                'feature_image' => $featureImageUrl,
                'price' => symbolPrice($effectivePrice),
                'year' => $car->year,
                'category_id' => $car->car_content->main_category_id,
                'sub_category_id' => $car->car_content->category_id,
                'created_at' => calculate_datetime($car->created_at),
                'slug' => $car->car_content ? $car->car_content->slug : null,
                'title' => $car->car_content ? $car->car_content->title : null,
                'fuel_type' => $car->car_content && $car->car_content->fuel_type ? $car->car_content->fuel_type->name : null,
                'engine_capacity' => $car->engineCapacity ? roundEngineDisplacement($car) : null,
                'mileage' => number_format($car->mileage) . ' mi',
                'is_added_on_wishlist' => $checkWishList,
                'vendor_name' => $car->vendor && $car->vendor->vendor_info ? $car->vendor->vendor_info->name : null,
                'vendor_photo' => (!empty($car->vendor->photo)) ? $vendorPhotoUrl : asset('assets/img/blank-user.jpg'),
                'vendor_type' => $vendorType,
                'user_type' => $car->vendor->vendor_type,
            ];
        });
    
        if ($ads->count() == 0) 
        {
              return response()->json([] , 200);
        }
    
        return response()->json($ads , 200);
    }

    
    public function allCategory(Request $request)
{
    $baseImageUrl = url('assets/admin/img/car-category/') . '/';
    
    $query = Category::where('parent_id', 0);

    // Check if the search_query parameter is present in the request
    if ($request->has('search_query')) {
        $searchQuery = $request->input('search_query');
        $query->where('name', 'like', '%' . $searchQuery . '%');
    }

    // Check if the 'page' parameter is present and not empty
    if ($request->has('page') && !empty($request->input('page'))) {
        // Paginate if 'page' parameter exists
        $categories = $query->paginate(10, ['id', 'name', 'slug', 'image'])
            ->through(function ($category) use ($baseImageUrl) {
                $category->image = $baseImageUrl . $category->image;
                return $category;
            });
    } else {
        // Retrieve all records if 'page' parameter is not sent or empty
        $categories = $query->get(['id', 'name', 'slug', 'image'])
            ->map(function ($category) use ($baseImageUrl) {
                $category->image = $baseImageUrl . $category->image;
                return $category;
            });
    }
    
    if ($categories->count() == 0) {
        return response()->json([], 200);
    } 
    
    return response()->json($categories, 200); 
}

    
    public function loadBodyTypes($category_id)
    {
       $body_types = BodyType::select('id' , 'name' , 'slug' )->where('status', 1)->where('cat_id' , $category_id)->orderBy('serial_number', 'asc')->get();
       
       return response()->json(['data' => $body_types], 200);
    }
    
    public function loadModels($id)
    {
       $models =   CarModel::select('id' , 'name' , 'slug' , 'brand_id')->where('brand_id', $id )->where('status', 1)->get();
       
       return response()->json(['data' => $models], 200);
    }
    
    public function laodSubCategory(Request $request , $id)
    {
        $categories =  Category::select('id' , 'name' , 'slug')->where('status', 1)->where('parent_id', $id )->get();
        
        if($categories->count() == 0 )
        {
             return response()->json(['data' => [] ], 200);     
        }
        
        return response()->json(['data' => $categories], 200);
    }
    
    
    function loadingCat($c_value)
    {
       
            $formData = FormFields::with('form_options')->where('category_field_id' , $c_value)->get();
            $output = '';
            
            if( $formData->count() > 0 )
            {
                $output .= ' <div class="row" style="padding-left: 25px;"> <div class="form-group >';
                
            foreach($formData as $list)
            {
                
                    if($list->type == 'input')
                    {
                        $output .= '<div class="col-md-12 mt-4" > <label class=" us_label mb-2"> '.$list->label.'</label> <input type="text" placeholder="type here ..." name="filters_input_'.strtolower(str_replace(' ' , '_' , $list->label)).'" class="form-control" />'; 
                    }
                    
                    if($list->type == 'textarea')
                    {
                        $output .= '<div class="col-md-12 mt-4" > <label class=" us_label mb-2"> '.$list->label.'</label> <textarea name="filters_textarea_'.strtolower(str_replace(' ' , '_' , $list->label) ).'" 
                        placeholder="type here ..." class="form-control" rows="4"></textarea>'; 
                    }
                
                    if($list->type == 'checkbox')
                    {
                        if(!empty($list->form_options))
                        {
                            $output .= '<div class="col-md-12 mt-4" > <label class="us_label mb-2"> '.$list->label.'</label><br>';
                           
                            foreach($list->form_options as $option)
                            {
                                $output .= '<b>'.$option->value.'</b> : &nbsp;&nbsp;<input type="checkbox" value="'.$option->value.'" style="position: relative;margin-right: 1rem;top: 2.2px;" name="filters_checkbox_'.strtolower(str_replace(' ' , '_' , $list->label) ).'[]"  /> ';
                            }
                        }
                    }
                    
                    if($list->type == 'radio')
                    {
                        if(!empty($list->form_options))
                        {
                            $output .= '<div class="col-md-12 mt-4" > <label class="us_label mb-2"> '.$list->label.'</label><br>';
                           
                            foreach($list->form_options as $option)
                            {
                                $output .= '<b>'.$option->value.'</b> : &nbsp;&nbsp;<input type="radio" value="'.$option->value.'" style="position: relative;margin-right: 1rem;top: 2.2px;" name="filters_radio_'.strtolower(str_replace(' ' , '_' , $list->label) ).'"  /> ';
                            }
                        }
                    }
                
                    if($list->type == 'select')
                    {
                        if(!empty($list->form_options))
                        {
                            $output .= '<div class="col-md-12 mt-4" > <label class="us_label mb-2"> '.$list->label.'</label><br> <select class="form-control" name="filters_select_'.strtolower(str_replace(' ' , '_' , $list->label) ).'" ><option value="">Select '.$list->label.'</option>';
                           
                            foreach($list->form_options as $option)
                            {
                                $output .= '<option value="'.$option->value.'">'.$option->value.'</option> ';
                            }
                            
                            $output .= '</select>';
                        }
                    }
                
                }
                
                $output .= '</div></div>';
                
                return $output;
            }
            else
            {
                return $output;
            }
        
    }
  
    public function subCategory(Request $request)
    {
        if ($request->category_id === null || $request->category_id === '') 
        {
            return response()->json(['error' => 'Category Id required'], 400);
        }
        
        $paginate = (!empty($request->limit)) ? $request->limit : 10;
    
        $baseImageUrl = url('assets/admin/img/car-category/').'/';
        
        $query = Category::where('parent_id', $request->category_id);
    
        // Check if the search_query parameter is present in the request
        if ($request->has('search_query')) {
            $searchQuery = $request->input('search_query');
            $query->where('name', 'like', '%' . $searchQuery . '%');
        }
    
        $categories = $query->paginate($paginate , ['id', 'name', 'slug', 'image'])
            ->through(function ($category) use ($baseImageUrl) 
            {
                $category->image = $baseImageUrl . $category->image;
                return $category;
            });
        
        if($categories->count() == 0)
        {
           return response()->json([], 200); 
        } 
        
        return response()->json($categories, 200);
    }

  
  function topFourCategories(Request $request)
  {

      // Retrieve the categories
    $categories = Category::whereIn('id', [24, 39, 28])->get(['id', 'name' , 'slug']);
    
    // Create an array for categories to modify and order
    $categoriesArray = $categories->map(function ($category) {
        // Modify the name for a specific ID
        if ($category->id == 24) {
            $category->name = 'Cars';
        } else if ($category->id == 39) {
            $category->name = 'Property';
        } else if ($category->id == 28) {
            $category->name = 'Farming';
        }
        return $category;
    })->keyBy('id')->toArray(); // Convert to an associative array keyed by ID

    // Add the additional marketplace item
    $categoriesArray[0] = (object) [
        'id' => 0,
        'name' => 'Marketplace'
    ];

    // Order the array manually
    $orderedCategories = collect([
        $categoriesArray[24] ?? null, // Cars
        $categoriesArray[0], // Marketplace
        $categoriesArray[39] ?? null, // Property
        $categoriesArray[28] ?? null  // Farming
    ])->filter(); // Remove null values if any

    // Return the ordered response
    return response()->json(['response' => $orderedCategories]);
    
  }
  


}
