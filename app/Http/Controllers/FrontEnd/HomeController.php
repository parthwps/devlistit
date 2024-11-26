<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\MiscellaneousController;
use App\Models\BasicSettings\Basic;
use App\Http\Requests\Car\CarStoreRequest;
use App\Models\Car;
use App\Models\Vendor;
use App\Models\Car\Brand;
use App\Models\Car\CarColor;
use App\Models\Car\CarContent;
use App\Models\Car\CarModel;
use App\Models\Car\CarSpecification;
use App\Models\Car\CarSpecificationContent;
use App\Models\Car\Category;
use App\Models\Language;
use App\Models\Car\CarImage;
use App\Models\Car\FormFields;
use App\Models\AdReport;
use App\Models\CounterSection;
use App\Models\HomePage\Banner;
use App\Models\HomePage\CategorySection;
use App\Models\HomePage\Section;
use App\Models\Journal\Blog;
use App\Models\HomePage\Partner;
use App\Models\Prominence\FeatureSection;
use App\Models\CountryArea;
use App\Models\CarYear;
use App\Models\AdsPrice;
use App\Models\DraftAd;
use App\Models\Car\EngineSize;
use Carbon\Carbon;
use App\Models\SaveSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
function reportAd(Request $request)
{
     $reasonOption =   $request->reasonOption;
     $user_id      =   Auth::guard('vendor')->user()->id;
     $explaination =   $request->explaination;
     $ad_id        =   $request->ad_id;
     
     $checkpoint = AdReport::where('ad_id' , $ad_id )->where('user_id' , $user_id)->first();
     
     if($checkpoint == false)
     {
        AdReport::create(['ad_id' => $ad_id ,'user_id' => $user_id ,'reason' => $reasonOption ,'explaination' => $explaination  ]); 
     }
     
     return response()->json(['response' => 'ok']);
}
    
    function getEngineCapacity(Request $request)
    {
        $engine_sizes = EngineSize::where('status', 1)->get();
        $output = '';
        
        
        $c_value = $request->thisVal; 
        
        $column_name = 'fuel'; 
       
       $storeAdInDraft = DraftAd::where('vendor_id', Auth::guard('vendor')->user()->id)->first();
        
        if ($storeAdInDraft) 
        {
            $storeAdInDraft->$column_name = $c_value;
        
            $storeAdInDraft->save();
        } 
        else 
        {
            DraftAd::create([
                'vendor_id' => Auth::guard('vendor')->user()->id,
                $column_name  => $c_value ,
            ]);
        }
        
        if($request->subcatVal == 48 || $request->subcatVal == 62)
        {
             $output =  '<div class="form-group">
            <label>Engine size (cc) </label>
            <input type="number" class="form-control" id="addCapacity" name="engineCapacity" onfocusout="addnsjfjdfj(this)" />
            </div>';   
        }
        else
        {
            if($request->selectedText == 'Petrol' || $request->selectedText == 'Diesel' )
            {
                $output .='<div class="form-group">
                <label>Engine size (litres)</label>
                <select name="engineCapacity" id="engine_sizes" class="form-control"  onchange="saveDraftData(this, \'engine\')" >
                <option value="" >Select</option>';
                
                foreach ($engine_sizes as $engine)
                {
                    $output .='<option  value="'.$engine->name.'">'.$engine->name.'</option>';
                }
                
                $output .='</select> </div>'; 
            }
            else
            {
                $output =  '<div class="form-group">
                <label>Engine size (KW) </label>
                <input type="number" class="form-control" id="addCapacity" name="engineCapacity" onfocusout="addnsjfjdfj(this)" />
                </div>';
            }
        }
        
        echo $output;
    }
    
    
    function getModel(Request $request)
    {
        $make = $request->make;
        
        $brand = Brand::where('slug' , $make)->first();
        
        $select = '<select class="form-select form-control js-example-basic-single1" onchange="updateUrl()" name="models[]"> <option value="">Select Model</option>';
        
        foreach ($brand->models as $model)
        {
            $select .= '<option  value="'.$model->slug.'">'.$model->name.'</option>';   
        }
          
        $select .= '</select>';
        
        echo $select;
    }
    
    function changeSpotlightStatus()
    {
        $fiveDaysAgo = Carbon::now()->subDays(5);
        
        Car::where(function($query) use ($fiveDaysAgo) {
        $query->whereNull('featured_date')
        ->orWhere('featured_date', '<', $fiveDaysAgo);
        })->update(['is_featured' => 0 ]);
        
        echo 'unlist';

    }
    
    function saveSearch(Request $request)
    {
        $search_url = $request->search_url;
        $save_search_name = $request->save_search_name;
        $selectedAlertType = $request->selectedAlertType;
        $search_urls = $this->updatePageParam($search_url);
        
        $check = SaveSearch::where('user_id' , Auth::guard('vendor')->user()->id)->where('save_search_name' , $save_search_name)->first();
        
        if($check == false)
        {
            SaveSearch::create(['search_url' => $search_urls , 'save_search_name' => $save_search_name , 'selectedAlertType' => $selectedAlertType , 'user_id' => Auth::guard('vendor')->user()->id , 'last_save_date' => date('Y-m-d H:i:s')]);
        }
        
        if($check == true)
        {
            SaveSearch::where('id' , $check->id)->update(['search_url' => $search_urls , 'selectedAlertType' => $selectedAlertType,'user_id' => Auth::guard('vendor')->user()->id , 'last_save_date' => date('Y-m-d H:i:s')]);
        }
        
        return response()->json(['response' => 'saved']);
    }
    
    function updatePageParam($url) {
        // Use regular expression to replace page parameter
        return preg_replace('/(\?|&)page=\d+/', '$1page=1', $url);
    }
    
  public function index()
  {
    Cache::flush();
    
    cache()->flush();
    
    $themeVersion = Basic::query()->pluck('theme_version')->first();

    $secInfo = Section::query()->first();

    $misc = new MiscellaneousController();

    $language = $misc->getLanguage();

    $queryResult['language'] = $language;

    $queryResult['car_categories'] = Category::where('language_id', $language->id)->where('status', 1)->where('parent_id', 24)->orderBy('serial_number', 'asc')->get();

    $queryResult['seoInfo'] = $language->seoInfo()->select('meta_keyword_home', 'meta_description_home')->first();

    $queryResult['sliderInfos'] = $language->sliderInfo()->orderByDesc('id')->get();

    if ($secInfo->about_section_status == 1) 
    {
      $queryResult['aboutSectionImage'] = Basic::query()->pluck('about_section_image')->first();
      
      $queryResult['aboutSecInfo'] = $language->aboutSection()->first();
    }
    
    if ($themeVersion == 2) 
    {
      $queryResult['categorySectionImage'] = Basic::query()->pluck('category_section_background')->first();
    }
    
    $queryResult['catgorySecInfo'] = CategorySection::where('language_id', $language->id)->first();
    
    $queryResult['featuredSecInfo'] = FeatureSection::where('language_id', $language->id)->first();

    if ($themeVersion == 1) 
    {
      $queryResult['banners'] = Banner::where('language_id', $language->id)->get();
    }

    if ($secInfo->work_process_section_status == 1 && $themeVersion == 2) 
    {
      $queryResult['workProcessSecInfo'] = $language->workProcessSection()->first();
      $queryResult['processes'] = $language->workProcess()->orderBy('serial_number', 'asc')->get();
    }

    if ($secInfo->counter_section_status == 1) 
    {
      $queryResult['counterSectionImage'] = Basic::query()->pluck('counter_section_image')->first();
      $queryResult['counterSectionInfo'] = CounterSection::where('language_id', $language->id)->first();
      $queryResult['counters'] = $language->counterInfo()->orderByDesc('id')->get();
    }

    $queryResult['currencyInfo'] = $this->getCurrencyInfo();

    $min = Car::min('price');
    $max = Car::max('price');

    $queryResult['min'] = intval($min);
    $queryResult['max'] = intval($max);

    if ($secInfo->testimonial_section_status == 1) 
    {
      $queryResult['testimonialSecInfo'] = $language->testimonialSection()->first();
      $queryResult['testimonials'] = $language->testimonial()->orderByDesc('id')->get();
      $queryResult['testimonialSecImage'] = Basic::query()->pluck('testimonial_section_image')->first();
    }

    if ($themeVersion != 1 && $secInfo->call_to_action_section_status == 1) 
    {
      $queryResult['callToActionSectionImage'] = Basic::query()->pluck('call_to_action_section_image')->first();
      $queryResult['callToActionSecInfo'] = $language->callToActionSection()->first();
    }

    if ($secInfo->blog_section_status == 1) 
    {
      $queryResult['blogSecInfo'] = $language->blogSection()->first();

      $queryResult['blogs'] = Blog::query()->join('blog_informations', 'blogs.id', '=', 'blog_informations.blog_id')
        ->join('blog_categories', 'blog_categories.id', '=', 'blog_informations.blog_category_id')
        ->where('blog_informations.language_id', '=', $language->id)
        ->select('blogs.image', 'blog_categories.name AS categoryName', 'blog_categories.slug AS categorySlug', 'blog_informations.title', 'blog_informations.slug', 'blog_informations.author', 'blogs.created_at', 'blog_informations.content')
        ->orderBy('blogs.serial_number', 'desc')
        ->limit(4)
        ->get();
    }

    $queryResult['cars'] = Car::join('car_contents', 'car_contents.car_id', 'cars.id')
    ->join('vendors', 'cars.vendor_id', '=', 'vendors.id')
    ->where([['vendors.status', 1] , ['vendors.vendor_type', 'dealer'], ['cars.is_featured', 1], ['cars.status', 1]])
    ->where('car_contents.language_id', $language->id)
    ->inRandomOrder()
    ->limit(8)
    ->select('cars.*', 'car_contents.slug', 'car_contents.title','car_contents.category_id', 'car_contents.car_model_id', 'car_contents.brand_id')
    ->get();
    
    
   $getFeaturedVendors = Vendor::with([
        'vendor_info',
        'memberships.package', 
        'cars' => function ($query) {
            $query->latest()->limit(3);
        }
    ])
    ->withCount('cars') // Counting the number of cars for each vendor
    ->where('vendor_type', 'dealer')
    ->where('status', 1)
    ->whereHas('memberships.package', function ($query) {
        $query->where('title', 'turbo');
    })
    ->whereHas('cars')
    ->inRandomOrder()
    ->first();

    $queryResult['getFeaturedVendors'] = $getFeaturedVendors;
    
    $queryResult['car_contents'] = Car::join('car_contents', 'car_contents.car_id', 'cars.id')
    ->join('vendors', 'cars.vendor_id', '=', 'vendors.id')
    ->where([
    ['vendors.status', 1],
    // ['vendors.vendor_type', 'normal'],
    ['cars.status', 1],
    ['cars.is_featured', 0],
    ['car_contents.main_category_id', 24]
    ])
    ->where('car_contents.language_id', $language->id)
    ->orderBy('cars.created_at', 'desc') 
    ->limit(8)
    ->select('cars.*', 'car_contents.slug', 'car_contents.title', 'car_contents.category_id', 'car_contents.car_model_id', 'car_contents.brand_id')
    ->get();

    $queryResult['car_conditions'] = CarColor::where('language_id', $language->id)->where('status', 1)->orderBy('serial_number', 'asc')->get();

    $categories = Category::has('car_contents')->where('language_id', $language->id)->where('status', 1)->orderBy('serial_number', 'asc')->get();
    $queryResult['categories'] = $categories;
    $queryResult['carlocation'] = CountryArea::where('status', 1)->orderBy('name', 'asc')->get();
    $queryResult['caryear'] = CarYear::where('status', 1)->orderBy('name', 'desc')->get();
    $queryResult['adsprices'] = AdsPrice::where('status', 1)->orderBy('id', 'asc')->get();
    
    // Retrieve popular brands
    $popularBrands = Brand::where('cat_id', 44)
    ->where('status', 1)
    ->withCount('cars')
    ->orderBy('cars_count', 'desc')
    ->orderBy('name', 'asc')
    ->take(10) // Adjust this number based on what you consider 'popular'
    ->get();
    
   
    $otherBrands = Brand::where('cat_id', 44)
    ->where('status', 1)
    // ->whereNotIn('id', $popularBrands->pluck('id'))
    ->orderBy('name', 'asc')
    ->get();
    
    // Combine results for view
    $queryResult['brands'] = $popularBrands;
    $queryResult['otherBrands'] = $otherBrands;


    $queryResult['secInfo'] = $secInfo;

    $cat_ids = [
      24, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 213, 274, 345
    ]; 
    // Convert $cat_ids array to a comma-separated string
    $cat_ids_str = implode(',', $cat_ids);               

    /* ---- Dealership Cars ----*/
    $dealershipCarsQuery = "SELECT 
                              COUNT(cars.id) AS car_count,
                              CONCAT('Dealership Cars') AS title,
                              CONCAT('dealership_cars') AS custom_cat,
                              CONCAT('dealership_cars.png') AS image_path
                            FROM 
                              cars
                            JOIN 
                              vendors ON cars.vendor_id = vendors.id
                            JOIN 
                              car_contents ON cars.id = car_contents.car_id
                              WHERE 
                              car_contents.main_category_id = 24
                              AND
                               vendors.vendor_type = 'dealer'
                              AND
                              vendors.status = 1
                              AND
                              cars.status = 1
                              AND
                              car_contents.language_id = 20;
                              ";

    $dealershipCarsCount = DB::select($dealershipCarsQuery);

    /* ---- Family Cars ----*/
    $familyCarsQuery = "SELECT 
                          COUNT(*) AS car_count,
                          'Family Cars' AS title,
                          'family_cars' AS custom_cat,
                          'family_cars.png' AS image_path
                        FROM cars
                        JOIN car_contents ON cars.id = car_contents.car_id
                        JOIN body_types ON car_contents.body_type_id = body_types.id
                        JOIN vendors ON cars.vendor_id = vendors.id
                        WHERE body_types.slug IN ('suv', 'van', 'estate', 'mpv')
                        AND body_types.cat_id IN  ($cat_ids_str)
                        AND cars.seats >= 5
                        -- AND car_contents.main_category_id = 24
                        AND cars.status = 1
                        AND vendors.status = 1
                        AND car_contents.language_id = 20
                        and cars.deleted_at is null
                    ";

    $familyCarsCount = DB::select($familyCarsQuery);

    

    /* ---- First Cars ----*/
    $firstCarsQuery = "SELECT 
                        COUNT(*) AS car_count,
                        'First Cars' AS title,
                        'first_cars' AS custom_cat,
                        'first_cars.png' AS image_path
                      FROM (
                        SELECT 
                            cars.id, cars.seats, cars.price, cars.road_tax,
                            CASE 
                                WHEN cars.engineCapacity LIKE '%L' 
                                THEN CAST(SUBSTRING_INDEX(cars.engineCapacity, 'L', 1) AS DECIMAL(4, 2))
                                WHEN cars.engineCapacity LIKE '%Kw'
                                THEN CAST(SUBSTRING_INDEX(cars.engineCapacity, 'Kw', 1) AS DECIMAL(4, 2)) * 0.134
                                ELSE NULL
                            END AS engine_in_liters
                        FROM cars
                        JOIN car_contents ON cars.id = car_contents.car_id
                        JOIN body_types ON car_contents.body_type_id = body_types.id
                        JOIN vendors ON cars.vendor_id = vendors.id
                        WHERE body_types.slug IN ('hatchback', 'coupe')
                        AND body_types.cat_id IN  ($cat_ids_str)
                        -- AND car_contents.main_category_id = 24
                        AND cars.status = 1
                        AND vendors.status = 1
                        AND car_contents.language_id = 20
                        and cars.deleted_at is null
                            -- AND cars.price <= 20000
                            -- AND cars.road_tax <= 300
                            -- AND (cars.price BETWEEN 10000 AND 20000)
                            -- And cars.road_tax <= 300
                    ) AS cars_with_engine_capacity
                    -- WHERE engine_in_liters IS NOT NULL 
                    -- AND engine_in_liters >= 1.6
                    ;";


    $firstCarsCount = DB::select($firstCarsQuery);

    /* ---- Eco-Friendly Cars ----*/
    $eco_friendlyCarsQuery = "SELECT 
                                COUNT(*) AS car_count,
                                'Eco Friendly Cars' AS title,
                                'eco_friendly_cars' AS custom_cat,
                                'eco_friendly_cars.png' AS image_path
                              FROM cars
                              JOIN car_contents ON cars.id = car_contents.car_id
                              JOIN fuel_types ON car_contents.fuel_type_id = fuel_types.id
                              WHERE fuel_types.slug IN ('electric', 'hybrid')
                              AND fuel_types.language_id = 20
                              ";

    $eco_friendlyCarsCount = DB::select($eco_friendlyCarsQuery);


    /* ---- Luxury Cars ----*/
    $luxuryCarsQuery = "SELECT 
                          COUNT(*) AS car_count,
                          'Luxury Cars' AS title,
                          'luxury_cars' AS custom_cat,
                          'luxury_cars.png' AS image_path
                        FROM cars
                        JOIN car_contents ON cars.id = car_contents.car_id
                        JOIN brands ON car_contents.brand_id = brands.id
                        JOIN vendors ON cars.vendor_id = vendors.id
                        WHERE brands.slug IN ('audi', 'bmw', 'mercedes-benz')
                          AND brands.language_id = 20
                          AND vendors.vendor_type = 'dealer'
                          -- AND cars.price >= 50000;

                          AND cars.status = 1
                          AND vendors.status = 1
                          AND car_contents.language_id = 20
                          AND cars.deleted_at is null
                          ";

    $luxuryCarsCount = DB::select($luxuryCarsQuery);

    /* ---- Commercial Cars ----*/
    $commercialCarsQuery = "SELECT 
                              categories.slug AS category,
                              COUNT(cars.id) AS car_count,
                              CONCAT('Commercial Cars') AS title,
                              CONCAT('commercial_cars') AS custom_cat,
                              CONCAT('commercial_cars.png') AS image_path
                            FROM 
                                cars
                            JOIN 
                                car_contents ON cars.id = car_contents.car_id
                            JOIN 
                                categories ON car_contents.category_id = categories.id
                            GROUP BY 
                                categories.slug
                            HAVING 
                                categories.slug = 'commercials';
                            ";

    $commercialCarsCount = DB::select($commercialCarsQuery);

    /* ---- City Cars ----*/
    $cityCarsQuery = "SELECT 
                        COUNT(*) AS car_count,
                        'City Cars' AS title,
                        'city_cars' AS custom_cat,
                        'city_cars.png' AS image_path
                      FROM cars
                      JOIN car_contents ON cars.id = car_contents.car_id
                      JOIN vendors ON cars.vendor_id = vendors.id
                      JOIN fuel_types ON car_contents.fuel_type_id = fuel_types.id
                      JOIN body_types ON car_contents.body_type_id = body_types.id
                          WHERE fuel_types.slug IN ('petrol', 'electric', 'hybrid')
                          AND fuel_types.language_id = 20
                          AND body_types.slug = 'hatchback'
                          AND body_types.cat_id IN  ($cat_ids_str)
                          AND cars.status = 1
                          AND vendors.status = 1
                          AND car_contents.language_id = 20
                          AND cars.deleted_at is null
                      ;";

    $cityCarsCount = DB::select($cityCarsQuery);

    $lifestyle[] = $dealershipCarsCount[0];
    $lifestyle[] = $familyCarsCount[0]; 
    $lifestyle[] = $firstCarsCount[0]; 
    $lifestyle[] = $eco_friendlyCarsCount[0];
    $lifestyle[] = $luxuryCarsCount[0];
    // $lifestyle[] = $commercialCarsCount[0];
    $lifestyle[] = $cityCarsCount[0];

    $queryResult['browse_by_lifestyle'] = $lifestyle;

    // dd($queryResult['browse_by_lifestyle']);
    // dd($queryResult['car_categories']);

    if ($themeVersion == 1) {
      return view('frontend.home.index-v1', $queryResult);
    } elseif ($themeVersion == 2) {
      return view('frontend.home.index-v2', $queryResult);
    } elseif ($themeVersion == 3) {
      return view('frontend.home.index-v3', $queryResult);
    }
  }
  
  function getnewads(Request $request)
  {
      $type = $request->type??null;
      $rightside = $request->rightside??null;
      $leftside = $request->leftside??null;
      $mainCatId = $request->categoryId??null;

      // return response()->json($mainCatId);
            
    $car_contents = Car::join('car_contents', 'car_contents.car_id', 'cars.id')
    ->join('vendors', 'cars.vendor_id', '=', 'vendors.id')
    ->where([
    ['vendors.status', 1],
    // ['vendors.vendor_type', 'normal'],
    ['cars.status', 1],
    ['car_contents.language_id', 20],
    // ['car_contents.main_category_id',$mainCatId]
    ])
    ->when(($mainCatId === null || $mainCatId == '0'), function ($query) {
        return $query->whereNotIn('car_contents.main_category_id', [24, 28, 39]);
    }, function ($query) use ($mainCatId) {
      
        return $query->where('car_contents.main_category_id', $mainCatId);
    });
    
    if ($type && $rightside && $leftside) {
      // Check the type and adjust the query accordingly
      if ($type == 2) {
        // For the right side, fetch records with IDs less than the specified ID
        $car_contents = $car_contents->where('cars.id', '<', $rightside)
        ->orderBy('cars.created_at', 'desc') // Sort by created_at descending
        ->limit(8);
      } else {
        // For the left side, fetch records with IDs greater than the specified ID
          $car_contents = $car_contents->where('cars.id', '>', $leftside)
          ->orderBy('cars.created_at', 'asc') // Sort by created_at ascending first
          ->limit(8);
      }
    }else{
      $car_contents = $car_contents->orderBy('cars.created_at', 'desc')
      ->limit(8);
    }
    
    // Execute the query
    $car_contents = $car_contents->select('cars.*', 'car_contents.slug', 'car_contents.title', 'car_contents.category_id', 'car_contents.car_model_id', 'car_contents.brand_id')
    ->get();
    
    // If fetching records for the left side, reverse the collection to maintain consistent ordering
    if ($type && $type != 2) {
      $car_contents = $car_contents->sortByDesc('created_at')->values();
    }

    
    if($car_contents->count() == 0 )
    {
        return response()->json(['response' => 'no_result']);  
    }
      
      $lastindex = count($car_contents)-1;
      
      $html =  view('frontend.home.recent-ads-copy', compact('car_contents'))->render();
   
      return response()->json(['response' => 'yes' , 'htmldata' => $html , 'rightside' => $car_contents[$lastindex]->id    , 'leftside' => $car_contents[0]->id  ]);
  }
  
  public function mailtemplate()
  {
    return view('email.mailbody');
  }

  public function get_model(Request $request)
  {
    $slug = $request->id;

    $misc = new MiscellaneousController();
    $language = $misc->getLanguage();

    $car_brand = Brand::where([['language_id', $language->id], ['slug', $slug]])->first();
    if ($car_brand) {
      $models = CarModel::where([['brand_id', $car_brand->id], ['status', 1], ['language_id', $language->id]])->orderBy('name', 'asc')->get();
      return $models;
    } else {
      return [];
    }
  }
  public function suggestions(Request $request) {
    $searchTerm = $request->keyword;
    $catTerm = $request->selectedCat??null;

    $excludeKeywords = ['cars-&-motors', 'farming', 'property'];

    if($catTerm) {
      $cars = CarContent::join('categories as child', 'car_contents.category_id', '=', 'child.id') // Join car_contents with child categories
      ->join('categories as parent', 'child.parent_id', '=', 'parent.id') // Join child categories with parent categories
      ->where('car_contents.title', 'LIKE', '%' . $searchTerm . '%') // Search by title in car_contents
      ->when($catTerm === 'market-place', function ($query) use ($excludeKeywords) {
          return $query->whereNotIn('parent.slug', $excludeKeywords);
      })
      ->when($catTerm !== 'market-place',function($query) use ($catTerm){
          return $query->where('parent.slug', 'LIKE', '%' . $catTerm . '%');
      })
      ->selectRaw('car_contents.category_id, count(*) as total')
      ->groupBy('car_contents.category_id')
      ->with('category') // Load category relationship
      ->limit(25)
      ->get();
    } else {
        $cars = CarContent::where('title', 'LIKE', '%' . $searchTerm . '%')
        ->selectRaw('category_id, count(*) as total')
        ->with('category')
        ->groupBy('category_id')
        ->limit(25)
        ->get();
    }
    //echo "<pre>";
    //print_r($cars);

    $html = view('frontend.home.autocomplete', compact('searchTerm','cars'))->render();
    
    return response()->json(['code' => 200, 'message' => 'successful.','data' =>$html]); 
  }
  public function defaultsuggestions(Request $request){
    $html = view('frontend.home.autocompletefilled')->render();
    
    return response()->json(['code' => 200, 'message' => 'successful.','data' =>$html]); 

  }
  public function vehicleData(Request $request)
  {

    //echo "VehicleData"; exit;
        $apiarray = [];
        $categories = Category::where('id', $request->catid)->first();
        
        $check_post = null;
        
    if($request->vehiclereg !=7007)
    {
        $reg_no = $request->vehiclereg;
        
        $formatted_reg_no = str_replace([' ', '-'], '', $reg_no);

        $check_post = DB::table('registration_records')
        ->whereRaw('REPLACE(REPLACE(vrm, " ", ""), "-", "") LIKE ?', ['%' . $formatted_reg_no . '%'])
        ->first();
        
        DraftAd::where('vendor_id', Auth::guard('vendor')->user()->id)->delete();
        
        if($check_post)
        {
            $make = $check_post->make;
            $model = $check_post->model;
            
            $check_brand = Brand::where('name', ucfirst(strtolower($make)))->where('cat_id' , $request->catid)->first();
            
            if ($check_brand == false) 
            {
                $new_brand = Brand::create([
                    'language_id' => 20,
                    'cat_id' => $request->catid,
                    'name' => ucfirst(strtolower($make)),
                    'slug' => strtolower(str_replace(' ', '-', ucfirst(strtolower($make)))),
                    'status' => 1,
                    'created_at' => now()
                ]);
            
                $check_brand = $new_brand;
            }
            
            if($check_brand)
            {
                    $check_model = CarModel::where('brand_id', $check_brand->id)
                    ->where('name', ucfirst(strtolower($model)))
                    ->first();
                    
                    if (!$check_model) {
                    // Create the CarModel if it doesn't exist
                        CarModel::create([
                        'language_id' => 20, // Adjust if necessary
                        'brand_id' => $check_brand->id,
                        'name' => ucfirst(strtolower($model)),
                        'slug' => strtolower(str_replace(' ', '-', ucfirst(strtolower($model)))),
                        'status' => 1, // Active status
                        'created_at' => now()
                        ]);
                    }
            }
            
            
           $apiarray["response"] = "manually"; 
        }
        else
        {
            $apiarray["response"] = "ItemNotFound";
        }
        
    } 
    else 
    {
      $apiarray["response"] = "manually";
    }


    $apiarray["catID"] = $request->catid;
    $catID = $request->catid;
    $draft_ad =  DraftAd::where('vendor_id', Auth::guard('vendor')->user()->id)->first();
    $filters = view('vendors.car.vehicledetails', compact('apiarray' , 'catID','categories', 'draft_ad' , 'check_post'))->render();
    
    $filters .=$this->loadingCat($request->catid);
    
    $is_enable = 0;
    
    if (in_array('registration_no', json_decode($categories->filters))) 
    {
        $is_enable = 1;
    }
    
    //echo json_encode($apiarray); exit;
    return response()->json(['code' => 200, 'message' => 'successful.','data' =>$filters , 'is_enable' => $is_enable ]); exit;
    // echo json_encode($cardata);

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
                        $output .= '<div class="col-md-12 mt-4" > <label class=" us_label mb-2"> '.$list->label.'</label> <input type="text" placeholder="Please Enter Here" name="filters_input_'.strtolower(str_replace(' ' , '_' , $list->label)).'" class="form-control" />'; 
                    }
                    
                    if($list->type == 'textarea')
                    {
                        $output .= '<div class="col-md-12 mt-4" > <label class=" us_label mb-2"> '.$list->label.'</label> <textarea name="filters_textarea_'.strtolower(str_replace(' ' , '_' , $list->label) ).'" 
                        placeholder="Please Enter Here" class="form-control" rows="4"></textarea>'; 
                    }
                
                    if($list->type == 'checkbox')
                    {
                        if(!empty($list->form_options))
                        {
                            $output .= '<div class="col-md-12 mt-4" > <label class="us_label mb-2"> '.$list->label.'</label><br>';
                           
                            foreach($list->form_options as $option)
                            {
                                $output .= '<b style="color:gray;">'.$option->value.'</b> : &nbsp;&nbsp;<input type="checkbox" value="'.$option->value.'" style="position: relative;margin-right: 1rem;top: 2.2px;" name="filters_checkbox_'.strtolower(str_replace(' ' , '_' , $list->label) ).'[]"  /> ';
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
                                $output .= '<b style="color:gray;">'.$option->value.'</b> : &nbsp;&nbsp;<input type="radio" value="'.$option->value.'" style="position: relative;margin-right: 1rem;top: 2.2px;" name="filters_radio_'.strtolower(str_replace(' ' , '_' , $list->label) ).'"  /> ';
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
    
    
  public function tabsData(Request $request)
  {
    $misc = new MiscellaneousController();
    $language = $misc->getLanguage();
    $queryResult['language'] = $language;
    $hmlList = "";
    
    
    $car_categories = Category::where('language_id', $language->id)->where('status', 1)->where('parent_id', $request->catid);
    
    if($request->catid == 0)
    {
        $car_categories = $car_categories->where('id' , '!=' , 24);
    }
    
    $car_categories = $car_categories->orderBy('serial_number', 'asc')->get();
    
   foreach($car_categories as $key => $category)
    {
        $img = ($category->image ? $category->image : 'noicon.png').'';
        $hmlList .='<div class="col-6  col-lg-3" data-aos="fade-up">
        <a href="'.route('frontend.cars', ['category' => $category->slug]).'">
        <div class="category-item">
        <div class="d-flex border rounded pt-4 ps-sm-4 pe-sm-4 px-4 mb-10">
                        <h6 class="category-title urbanistFonts mb-10 w-100">
                          <div class="w-100 d-flex justify-content-start justify-content-sm-center align-items-center gap-1">
                            <div class="catImg w-25 w-sm-50 w-md-50 w-lg-50 w-xl-50  w-xxl-50  d-flex justify-content-end align-items-center">
                            <img class="lazyload blur-up category-icon" 
                            
                          style="    filter: brightness(0) saturate(100%) invert(72%) sepia(72%) saturate(6798%) hue-rotate(193deg)
                           brightness(95%) contrast(101%);" 
                              data-src="'.asset('assets/admin/img/car-category/' . $img).'?v=0.1"   
                              alt="{{ $category->name }}" 
                              title="{{ $category->name }}"
                              id="filterCSS'.$key.'" 
                              >
                            </div>
                            <div class="catImgText w-75 w-sm-50 w-md-50 w-lg-50 w-xl-50  w-xxl-50  ">
                             '. $category->name .'
                            </div>
                          </div>
                        </h6>
                      </div>
        </div>
        </a>
        </div>';
    }
    
    return response()->json(['code' => 200, 'message' => 'successful.','data' =>$hmlList]); exit;
  }
  //about
  public function about()
  {
    $misc = new MiscellaneousController();

    $language = $misc->getLanguage();

    $queryResult['seoInfo'] = $language->seoInfo()->select('meta_keywords_about_page', 'meta_description_about_page')->first();

    $queryResult['pageHeading'] = $misc->getPageHeading($language);

    $queryResult['bgImg'] = $misc->getBreadcrumb();
    $secInfo = Section::query()->first();
    $queryResult['secInfo'] = $secInfo;

    if ($secInfo->work_process_section_status == 1) {
      $queryResult['workProcessSecInfo'] = $language->workProcessSection()->first();
      $queryResult['processes'] = $language->workProcess()->orderBy('serial_number', 'asc')->get();
    }

    if ($secInfo->testimonial_section_status == 1) {
      $queryResult['testimonialSecInfo'] = $language->testimonialSection()->first();
      $queryResult['testimonials'] = $language->testimonial()->orderByDesc('id')->get();
      $queryResult['testimonialSecImage'] = Basic::query()->pluck('testimonial_section_image')->first();
    }

    if ($secInfo->counter_section_status == 1) {
      $queryResult['counterSectionImage'] = Basic::query()->pluck('counter_section_image')->first();
      $queryResult['counterSectionInfo'] = CounterSection::where('language_id', $language->id)->first();
      $queryResult['counters'] = $language->counterInfo()->orderByDesc('id')->get();
    }

    return view('frontend.about', $queryResult);
  }

  //offline
  public function offline()
  {
    return view('frontend.offline');
  }
  
}
