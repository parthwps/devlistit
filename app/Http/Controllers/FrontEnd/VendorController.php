<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\BasicSettings\Basic;
use App\Models\Car;
use App\Models\Car\CarColor;
use App\Models\Car\Category;
use App\Models\HomePage\Section;
use App\Models\Vendor;
use App\Models\VendorInfo;
use Carbon\Carbon;
use Config;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Validator;
use Mews\Purifier\Facades\Purifier;
use DB;

class VendorController extends Controller
{
    
    public function index(Request $request)
    {
        $misc = new MiscellaneousController();

        $language = $misc->getLanguage();
        
        $queryResult['language'] = $language;

        $queryResult['pageHeading'] = $misc->getPageHeading($language);

        $queryResult['seoInfo'] = $language->seoInfo()->select('meta_keywords_vendor_page', 'meta_description_vendor_page')->first();
        
        $name = $location = null;
        
        $vendorIds = [];
        
        if ($request->filled('name')) 
        {
            $name = $request->name;
            
            $u_infos = Vendor::where('vendors.username', 'like', '%' . $name . '%')->get();
            
            $v_infos = VendorInfo::where([['vendor_infos.name', 'like', '%' . $name . '%'], ['language_id', $language->id]])->get();

            foreach ($u_infos as $info) 
            {
                if (!in_array($info->id, $vendorIds)) 
                {
                    array_push($vendorIds, $info->id);
                }
            }
            
            foreach ($v_infos as $v_info) 
            {
                if (!in_array($v_info->vendor_id, $vendorIds)) 
                {
                    array_push($vendorIds, $v_info->vendor_id);
                }
            }
        }

        if ($request->filled('location')) 
        {
            $location = $request->location;
        }

        $secInfo = Section::query()->select('subscribe_section_status')->first();
        
        $queryResult['secInfo'] = $secInfo;

        if ($request->filled('location')) 
        {
            $vendor_contents = VendorInfo::where('country', 'like', '%' . $location . '%')
            ->orWhere('city', 'like', '%' . $location . '%')
            ->orWhere('state', 'like', '%' . $location . '%')
            ->orWhere('zip_code', 'like', '%' . $location . '%')
            ->orWhere('address', 'like', '%' . $location . '%')
            ->get();
                
            foreach ($vendor_contents as $vendor_content) 
            {
                if (!in_array($vendor_content->vendor_id, $vendorIds)) 
                {
                    array_push($vendorIds, $vendor_content->vendor_id);
                }
            }
        }

        $queryResult['bgImg'] = $misc->getBreadcrumb();
        
        $vendors = Vendor::with('vendor_info')->where('status', 1)
            ->where('vendor_type' , 'dealer')
            ->when($name, function ($query) use ($vendorIds) 
            {
                return $query->whereIn('id', $vendorIds);
            })
            ->when($location, function ($query) use ($vendorIds) 
            {
                return $query->whereIn('id', $vendorIds);
            });
            
            if ($request->filled('dealer_type') ) 
            {
                $d_type = 1;
                
                if($request->dealer_type  == 2)
                {
                  $d_type = 0;  
                }
                
                $vendors = $vendors->where('is_franchise_dealer' , $d_type);
            }
            
            $vendors = $vendors->withCount('cars') // Assuming 'cars' is the name of the relationship
            ->whereHas('vendor_info') // Ensure the vendor_info relationship exists
            ->where('id', '!=', 0) // Filter vendors with id not equal to 0
            ->orderBy('cars_count', 'desc') // Sort by the count of cars in descending order
            ->paginate(10);
        
        $queryResult['vendors'] =    $vendors;
        
        return view('frontend.vendor.index', $queryResult);
    }
    
    public function details(Request $request , $id , $username= null)
    {
        $misc = new MiscellaneousController();

        $language = $misc->getLanguage();
        
        $queryResult['language'] = $language;

        $queryResult['bgImg'] = $misc->getBreadcrumb();
        
        $queryResult['pageHeading'] = $misc->getPageHeading($language);

        if ($request->admin == true) 
        {
            $vendor = Admin::first();
            
            $vendor_id = 0;
            
            $queryResult['total_cars'] = Car::where('vendor_id', 0)->get()->count();
        } 
        else 
        {
            $vendor = Vendor::where('vendors.id', $id )->firstOrFail();
            
            $vendorInfo = VendorInfo::where([['vendor_id', $vendor->id], ['language_id', $language->id]])->first();
            
            $queryResult['vendorInfo'] = $vendorInfo;
            
            $vendor_id = $vendor->id;
        }
        
        $queryResult['vendor'] = $vendor;
        
        $queryResult['categories'] = Category::where([['language_id', $language->id], ['status', 1]])->get();
        
        $queryResult['all_cars'] = Car::where([['cars.vendor_id', $vendor_id], ['cars.status', 1] , ['cars.is_sold', 0]])->orderBy('id', 'desc')->get();
        
        $queryResult['price_ranges'] = Car::where([['cars.vendor_id', $vendor_id], ['cars.status', 1] , ['cars.is_sold', 0]])->orderBy('price', 'asc')->distinct('price')->pluck('price');
        
        $queryResult['categories'] = Car::where([['cars.vendor_id', $vendor_id],['cars.status', 1],['cars.is_sold', 0]])
        ->whereHas('car_content.category')
        ->with('car_content.category')
        ->get()
        ->groupBy(function($car) {
            return $car->car_content->category->id; // Group by category ID
        })
        ->map(function ($cars, $categoryId) {
            return [
                'category' => $cars->first()->car_content->category, // Return category details
                'count' => $cars->count() // Count number of cars in this category
            ];
        });

        
        $queryResult['currentDay'] = ucfirst(now()->format('l')); 
        $queryResult['currentTime'] = now()->format('H:i'); 
        $queryResult['openingHours']  = DB::table('opening_hours')->where('vendor_id' , $queryResult['vendor']->id )->get()->keyBy('day_of_week')->toArray();

        $secInfo = Section::query()->select('subscribe_section_status')->first();
        $queryResult['secInfo'] = $secInfo;
        $queryResult['currencyInfo'] = $this->getCurrencyInfo();
        $queryResult['info'] = Basic::select('google_recaptcha_status')->first();
        return view('frontend.vendor.details', $queryResult);
    }
    
    function customerFilter(Request $request)
    {
    
    // Extract filter values from the request
    $searchQuery = $request->input('search_query');
    $minPrice = $request->input('min_price');
    $maxPrice = $request->input('max_price');
    $category = $request->input('category');
    $sortBy = $request->input('sort_by');
    $vendor_id = $request->input('vendor_id'); // Assuming you get this from the request or elsewhere

    // Base query with join
    $query = Car::join('car_contents', 'cars.id', '=', 'car_contents.car_id')
                ->where('cars.vendor_id', $vendor_id)
                ->where('cars.status', 1)
                ->where('cars.is_sold', 0)
                ->select('cars.*', 'car_contents.title', 'car_contents.slug', 'car_contents.category_id');

    // Apply search query filter
    if (!empty($searchQuery)) {
        $query->where('car_contents.title', 'like', "%{$searchQuery}%");
    }

    // Apply filtering based on car_contents table
    if (!empty($minPrice)) {
        $query->where('cars.price', '>=', $minPrice);
    }
    if (!empty($maxPrice)) {
        $query->where('cars.price', '<=', $maxPrice);
    }
    if (!empty($category)) {
        $query->where('car_contents.category_id', $category);
    }

    // Apply sorting
    switch ($sortBy) {
        case 'newest':
            $query->orderBy('cars.id', 'desc');
            break;
        case 'oldest':
            $query->orderBy('cars.id', 'asc');
            break;
        case 'lowest_price':
            $query->orderBy('cars.price', 'asc');
            break;
        case 'highest_price':
            $query->orderBy('cars.price', 'desc');
            break;
        default:
            $query->orderBy('cars.id', 'desc'); // Default sorting if none matched
            break;
    }

    // Get the results
    $queryResult['car_contents'] = $query->paginate(15);
    
    
    $HTMLVIEW = view('frontend.car.cars_list_ajax', $queryResult)->render();
    
    return response()->json(['data' => $HTMLVIEW , 'count' => count($queryResult['car_contents'])]);

    }

    //contact
    public function contact(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required'
        ];
        
        
        $messageArray = [];

        $validator = Validator::make($request->all(), $rules, $messageArray);
        
        if ($validator->fails()) 
        {
            return response()->json(['errors' => $validator->getMessageBag()->toArray()], 400);
        }

        $be = Basic::select('smtp_status', 'smtp_host', 'smtp_port', 'encryption', 'smtp_username', 'smtp_password', 'from_mail', 'from_name')->firstOrFail();

        
        $message = 'Name : '.$request->name. '<br>Phone : '.$request->phone_no .'<br>Email : '.$request->email ;
        
        if(!empty($request->field_name) && count($request->field_name) > 0 )
        {
             $message .= '<br><br>Iam interested in ... <br><br>';
             
            foreach($request->field_name as $list)
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

        $data = [
            'to' => $request->vendor_email,
            'subject' => "New User Query",
            'message' => $message,
        ];

        if ($be->smtp_status == 1) {
            try {
                $smtp = [
                    'transport' => 'smtp',
                    'host' => $be->smtp_host,
                    'port' => $be->smtp_port,
                    'encryption' => $be->encryption,
                    'username' => $be->smtp_username,
                    'password' => $be->smtp_password,
                    'timeout' => null,
                    'auth_mode' => null,
                ];
                Config::set('mail.mailers.smtp', $smtp);
            } catch (\Exception $e) {
                Session::flash('error', $e->getMessage());
                return back();
            }
        }
        try {
            Mail::send([], [], function (Message $message) use ($data, $be) {
                $fromMail = $be->from_mail;
                $fromName = $be->from_name;
                $message->to($data['to'])
                    ->subject($data['subject'])
                    ->from($fromMail, $fromName)
                    ->html($data['message'], 'text/html');
            });
            Session::flash('message', 'Message sent successfully');
            Session::flash('alert-type', 'success');
            return 'success';
        } catch (\Exception $e) {
            Session::flash('message', 'Something went wrong.');
            Session::flash('alert-type', 'error');
            return 'success';
        }
    }
}
