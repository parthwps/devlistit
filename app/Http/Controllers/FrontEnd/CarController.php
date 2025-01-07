<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\BasicSettings\Basic;
use App\Models\BasicSettings\MailTemplate;
use App\Models\Car;
use App\Models\Car\Brand;
use App\Models\Car\CarColor;
use App\Models\Car\CarContent;
use App\Models\Car\CarImage;
use App\Models\Car\CarModel;
use App\Models\Car\CarSpecification;
use App\Models\Car\Category;
use App\Models\Car\FuelType;
use App\Models\Car\FormFields;
use App\Models\Car\TransmissionType;
use App\Models\Car\CustomerSearch;
use App\Models\Car\BodyType;
use App\Models\Vendor;
use App\Models\VendorInfo;
use App\Models\Visitor;
use App\Models\SaveSearch;
use App\Models\CountryArea;
use App\Models\CarYear;
use App\Models\Car\EngineSize;
use App\Models\Car\CarPower;
use App\Models\AdsPrice;
use App\Models\BrowsingHistory;
use App\Models\AdsMileage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Config;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Session;

class CarController extends Controller
{
    public function siteMap()
    {
        $categories = Category::where('parent_id' , 0)->where('status' , 1)->get(['id' , 'name' , 'slug']);
        return view('frontend.car.sitemap', compact('categories') );
    }

    public function index(Request $request)
    {


        if ($request->filled('category') && $request->category == 'all') {
            // Clear all request data
            $request->replace([]);
        }

        if ($request->filled('category') && $request->category == 'dealership_cars') {
            $request->merge([
                'category' => 'cars-&-motors',
                'dealer_type' => ['dealer']
            ]);
        }

        if ($request->filled('category') && $request->category == 'family_cars') {
            $request->merge([
                'category' => 'cars-&-motors',
                'bodyTypeArray' => ['suv', 'van', 'estate', 'mpv'],
                'seat_min' => 5
            ]);
        }

        if ($request->filled('category') && $request->category == 'first_cars') {
            $request->merge([
                'category' => 'cars-&-motors',
                'bodyTypeArray' => ['hatchback', 'coupe'],
                // 'price' => 20000,
                // 'road_tax' => 300,
                // 'engine_min' =>

            ]);
        }

        if ($request->filled('category') && $request->category == 'eco_friendly_cars') {
            $request->merge([
                'category' => 'cars-&-motors',
                'fuelTypeArray' => ['electric', 'hybrid'],
            ]);
        }

        if ($request->filled('category') && $request->category == 'luxury_cars') {
            $request->merge([
                'category' => 'cars-&-motors',
                'brands' => ['audi', 'bmw', 'mercedes-benz'],
                // 'price' => 50000,
                'dealer_type' => ['dealer']
            ]);
        }

        if ($request->filled('category') && $request->category == 'city_cars') {
            $request->merge([
                'category' => 'cars-&-motors',
                'fuelTypeArray' => ['petrol', 'electric', 'hybrid'],
                'bodyTypeArray' => ['hatchback'],
            ]);
        }


        if(isset($_GET) && count($_GET) > 1) {
            if (!Auth::guard('vendor')->check()){
                Session::put('lastSearch', json_encode($_GET));
            }else{
                Session::put('lastSearch', json_encode($_GET));
                $last_search = CustomerSearch::where('customer_id', Auth::guard('vendor')->user()->id)->first();
                if($last_search){
                    $last_search->update(['customer_filters' => json_encode($_GET)]);
                } else{
                    $in['customer_id'] = Auth::guard('vendor')->user()->id;
                    $in['customer_filters'] = json_encode($_GET);
                    CustomerSearch::create($in);
                }
            }
        }

        $misc = new MiscellaneousController();
        $language = $misc->getLanguage();
        $information['seoInfo'] = $language->seoInfo()->select('meta_keyword_cars', 'meta_description_cars')->first();

        if ($request->filled('type')) {
            Session::put('car_view_type', $request->type);
        }
        $view_type = Session::get('car_view_type');
        //echo $view_type; exit;
        $colourTypeArray = $transmissionTypeArray = $fuelTypeArray = $bodyTypeArray = $category = $mileage_min = $mileage_max = $title = $location = $brands = $models = $fuel_type = $transmission = $colour = $min = $max =  null;

        $carIds = [];

        if ($request->filled('title'))
        {
            $title = $request->title;
            $car_contents = CarContent::where('language_id', $language->id)
                ->where('title', 'like', '%' . $title . '%')
                ->get()
                ->pluck('car_id');

            foreach ($car_contents as $car_content)
            {
                if (!in_array($car_content, $carIds))
                {
                    array_push($carIds, $car_content);
                }
            }
        }

        $parr =array();
        if ($request->filled('category')) {

            if($request->category === 'market-place'){
                // echo $request->category;exit;
                $excludedCategories = ['cars-&-motors', 'property', 'farming'];
                $categoryID = Category::whereNotIn('slug', $excludedCategories)->get();

                $parent = 0;
                $parr['market-place'] = 'Market Place';

            }else{
                $categoryID = Category::where([['slug', $request->category]])->first();
                if($categoryID){

                    $parent = $categoryID->id; //25
                    // echo $categoryID->name; exit;
                    $parr[$categoryID->slug] = $categoryID->name; //cars = 24
                    repeat:
                    $category =  Category::find($parent);//24,
                    if ($category->parent_id != 0) {//24
                        $parent = $category->parent_id;//24
                        $parr[$category->slug] = $category->name;
                        //array_push($parr, $category->name);
                        goto repeat;
                    } else{
                        $parr[$category->slug] = $category->name;
                    }
                }
            }




        }
        // --- Breadcrumb -----

        $category_id =0;
        $category_carIds = [];
        if ($request->filled('category'))
        {

            $parentCatId = 0;
            $category = $request->category;

            if($category !== 'market-place'){
                $category_content = Category::where([['language_id', $language->id], ['slug', $category]])->first();
                $categories = Category::with('children')->where('parent_id', $category_content->id)->where('status', 1)->get()->map(function ($category) {
                    $children = $category->childArray();
                     unset($category->children);
                    $category->children = $children;
                    return $category;
                });



                if (!empty($category_content))
                {
                    $parentCatId = $category_content->id;
                }
            }else{
                // echo "else";die;
                // $excludedCategories = ['cars-&-motors', 'property', 'farming'];//24,28,39
                // $categories = Category::whereNotIn('slug', $excludedCategories)->get();
                $excludedCategories = [24,28,39];
                $childCategories = Category::whereIn('parent_id', $excludedCategories)->pluck('id')->toArray();

                $allExcludedCategories = array_merge($excludedCategories, $childCategories);
                // Get all categories except the excluded ones
                $categories = Category::whereNotIn('id', $allExcludedCategories)->get();

            }

                $cid=  [];
                foreach ($categories as $cat)
                {
                    if (!in_array($cat->id,$cid))
                    {
                        array_push($cid,$cat->id);
                    }
                }


                array_push($cid,$parentCatId);

                    $category_id = $parentCatId;

                // Get initial records from CarContent
                    $contents_from_car_content = CarContent::whereIn('category_id', $cid)->get()->pluck('car_id');

                    // Add the initial records to the category_carIds array
                    $category_carIds = $contents_from_car_content->toArray();

                    // Get additional records from Car
                    $additional_contents = Car::whereRaw('JSON_CONTAINS(fil_sub_categories, \'["' . $category_id . '"]\')')->get()->pluck('id');

                    // Merge additional contents with category_carIds and ensure uniqueness
                    foreach ($additional_contents as $content)
                    {
                        if (!in_array($content, $category_carIds))
                        {
                            array_push($category_carIds, $content);
                        }
                    }
        }


        $brandIds = [];
        if ($request->filled('brands'))
        {
            $brands = $request->brands;

            if(empty($brands[0]))
            {
               $brands =  Brand::where('status' , 1)->where('language_id', $language->id)->pluck('slug');
               $brands = json_decode($brands , true);
            }

            $b_ids = [];

            if (is_array($brands)) {
                foreach ($brands as $brand) {
                    if (!is_null($brand)) {
                        $brand_car_contents = Brand::where([['language_id', $language->id], ['slug', $brand]])->first();
                        if (!empty($brand_car_contents)) {
                            if (!in_array($brand_car_contents->id, $b_ids)) {
                                array_push($b_ids, $brand_car_contents->id);
                            }
                        }
                    }
                }
            } else {
                $brand_car_contents = Brand::where([['language_id', $language->id], ['slug', $brands]])->first();
                if (!in_array($brand_car_contents->id, $b_ids)) {
                    array_push($b_ids, $brand_car_contents->id);
                }
            }

            $contents = CarContent::where('language_id', $language->id)
                ->whereIn('brand_id', $b_ids)
                ->get()
                ->pluck('car_id');
            foreach ($contents as $content) {
                if (!in_array($content, $brandIds)) {
                    array_push($brandIds, $content);
                }
            }
        }
        //echo "<pre>";
        //print_r($brandIds);

        $modelIds = [];

        if ($request->filled('models')) {

          //  print_r($request->models); exit;
            if(($request->models[0]!="")) {
            $models = $request->models;
            $m_ids = [];
            if (is_array($models)) {
                foreach ($models as $model) {
                    $model_car_contents = CarModel::where([['language_id', $language->id], ['slug', $model] ,  ['brand_id', $brand_car_contents->id ]])->where('status', 1)->first();
                    if (!in_array($model_car_contents->id, $m_ids)) {
                        array_push($m_ids, $model_car_contents->id);
                    }
                }
            } else {


                $model_car_contents = CarModel::where([['language_id', $language->id], ['slug', $models] ,  ['brand_id', $brand_car_contents->id ]])->where('status', 1)->first();
                if (!in_array($model_car_contents->id, $m_ids)) {
                    array_push($m_ids, $model_car_contents->id);
                }
            }

            $contents = CarContent::where('language_id', $language->id)
                ->whereIn('car_model_id', $m_ids)
                ->get();
            foreach ($contents as $content) {
                if (!in_array($content->car_id, $modelIds)) {
                    array_push($modelIds, $content->car_id);
                }
            }
        }
    }

        $fuel_type_id = [];
        if ($request->filled('fuel_type')) {
            $fuel_type = $request->fuel_type;
            $fuel_type_content = FuelType::where([['language_id', $language->id], ['slug', $fuel_type]])->first();
            if (!empty($fuel_type_content)) {
                $f_id = $fuel_type_content->id;
                $contents = CarContent::where('language_id', $language->id)
                    ->where('fuel_type_id', $f_id)
                    ->get()
                    ->pluck('car_id');
                foreach ($contents as $content) {
                    if (!in_array($content, $fuel_type_id)) {
                        array_push($fuel_type_id, $content);
                    }
                }
            }
        }

        $transmission_type_id = [];
        if ($request->filled('transmission')) {
            $transmission = $request->transmission;
            $transmission_content = TransmissionType::where([['language_id', $language->id], ['slug', $transmission]])->first();
            if (!empty($transmission_content)) {
                $t_id = $transmission_content->id;
                $contents = CarContent::where('language_id', $language->id)
                    ->where('transmission_type_id', $t_id)
                    ->get()
                    ->pluck('car_id');
                foreach ($contents as $content) {
                    if (!in_array($content, $transmission_type_id)) {
                        array_push($transmission_type_id, $content);
                    }
                }
            }
        }

        $transmissionTypesArrayIds = [];
        if ($request->filled('transmissionTypeArray'))
        {
            $transmissionTypeArray = $request->transmissionTypeArray;

            $transmission_ids = [];

            if (is_array($transmissionTypeArray)) {
                foreach ($transmissionTypeArray as $transmissionTypeArrayValue) {
                    if (!is_null($transmissionTypeArrayValue)) {
                        $transmission_type_contents = TransmissionType::where([['language_id', $language->id], ['slug', $transmissionTypeArrayValue]])->first();
                        if (!empty($transmission_type_contents)) {
                            if (!in_array($transmission_type_contents->id, $transmission_ids)) {
                                array_push($transmission_ids, $transmission_type_contents->id);
                            }
                        }
                    }
                }
            }

            $transmission_type_contents = CarContent::where('language_id', $language->id)
                ->whereIn('transmission_type_id', $transmission_ids)
                ->get()
                ->pluck('car_id');
            foreach ($transmission_type_contents as $content) {
                if (!in_array($content, $transmissionTypesArrayIds)) {
                    array_push($transmissionTypesArrayIds, $content);
                }
            }
        }

        $colour_id = [];
        if ($request->filled('colour')) {
            $colour = $request->colour;
            $colour_content = CarColor::where([['language_id', $language->id], ['slug', $colour]])->first();
            if (!empty($colour_content)) {
                $c_id = $colour_content->id;
                $contents = CarContent::where('language_id', $language->id)
                    ->where('car_colour_id', $c_id)->orWhere('car_color_id' , $c_id)
                    ->get()
                    ->pluck('car_id');
                foreach ($contents as $content) {
                    if (!in_array($content, $colour_id)) {
                        array_push($colour_id, $content);
                    }
                }
            }
        }

        $colourTypeArrayIds = [];
        if ($request->filled('colourTypeArray'))
        {
            $colourTypeArray = $request->colourTypeArray;

            $colour_ids = [];

            if (is_array($colourTypeArray)) {
                foreach ($colourTypeArray as $colourTypeArrayValue) {
                    if (!is_null($colourTypeArrayValue)) {
                        $colour_type_contents = CarColor::where([['language_id', $language->id], ['slug', $colourTypeArrayValue]])->first();
                        if (!empty($colour_type_contents)) {
                            if (!in_array($colour_type_contents->id, $colour_ids)) {
                                array_push($colour_ids, $colour_type_contents->id);
                            }
                        }
                    }
                }
            }

            $colour_type_contents = CarContent::where('language_id', $language->id)
                ->whereIn('car_colour_id', $colour_ids)
                ->get()
                ->pluck('car_id');
            foreach ($colour_type_contents as $content) {
                if (!in_array($content, $colourTypeArrayIds)) {
                    array_push($colourTypeArrayIds, $content);
                }
            }
        }

        $priceIds = [];

        if ($request->filled('min') || $request->filled('max')) {
            if ($request->filled('min') && $request->filled('max')) {
                $min = intval($request->min);
                $max = intval($request->max);
            } elseif ($request->filled('min')) {
                $min = intval($request->min);
                $max = intval(65000);
            } elseif ($request->filled('max')) {
                 $min = intval(0);
                $max = intval(($request->max));
            }
            $price_cars = DB::table('cars')
                ->select('*')
                ->where('price', '>=', $min)
                ->where('price', '<=', DB::raw($max))
                ->get();
            foreach ($price_cars as $car) {
                if (!in_array($car->id, $priceIds)) {
                    array_push($priceIds, $car->id);
                }
            }
        }

        $mileageIds = [];

        if ($request->filled('mileage_min') || $request->filled('mileage_max')) {
            if ($request->filled('mileage_min') && $request->filled('mileage_max')) {
                $mileage_min = ($request->mileage_min);
                $mileage_max = ($request->mileage_max);
            } elseif ($request->filled('mileage_min')) {
                $mileage_min = ($request->mileage_min);
                $mileage_max = (400000);
            } elseif ($request->filled('mileage_max')) {
                 $mileage_min = (0);
                $mileage_max = (($request->mileage_max));
            }
          //  echo $mileage_min; exit;
            $mileage_cars = DB::table('cars')
                ->select('*')
                ->where('mileage', '>=', $mileage_min)
                ->where('mileage', '<=', $mileage_max)
                ->get();
            foreach ($mileage_cars as $mileage) {
                if (!in_array($mileage->id, $mileageIds)) {
                    array_push($priceIds, $mileage->id);
                }
            }
        }

        if ($request->filled('sort')) {
            if ($request['sort'] == 'new') {
                $order_by_column = 'cars.id';
                $order = 'desc';
            } elseif ($request['sort'] == 'old') {
                $order_by_column = 'cars.id';
                $order = 'asc';
            } elseif ($request['sort'] == 'high-to-low') {
                $order_by_column = 'cars.price';
                $order = 'desc';
            } elseif ($request['sort'] == 'low-to-high') {
                $order_by_column = 'cars.price';
                $order = 'asc';
            }
            elseif ($request['sort'] == 'high-to-mileage') {
                $order_by_column = 'cars.mileage';
                $order = 'desc';
            } elseif ($request['sort'] == 'low-to-mileage') {
                $order_by_column = 'cars.mileage';
                $order = 'asc';
            }
            else
            {
                $order_by_column = 'cars.id';
                $order = 'desc';
            }
        }
        else
        {
            $order_by_column = 'cars.id';
            $order = 'desc';
        }

        $bodyTypesArrayIds = [];
        if ($request->filled('bodyTypeArray'))
        {
            $bodyTypeArray = $request->bodyTypeArray;

            $bt_ids = [];

            if (is_array($bodyTypeArray)) {
                foreach ($bodyTypeArray as $bodyTypeArrayValue) {
                    if (!is_null($bodyTypeArrayValue)) {
                        $body_type_contents = BodyType::where([['slug', $bodyTypeArrayValue]])->whereIn('cat_id',$cid)->first();
                        if (!empty($body_type_contents)) {
                            if (!in_array($body_type_contents->id, $bt_ids)) {
                                array_push($bt_ids, $body_type_contents->id);
                            }
                        }
                    }
                }
            }

            $bt_contents = CarContent::where('language_id', $language->id)
                ->whereIn('body_type_id', $bt_ids)
                ->get()
                ->pluck('car_id');
            foreach ($bt_contents as $content) {
                if (!in_array($content, $bodyTypesArrayIds)) {
                    array_push($bodyTypesArrayIds, $content);
                }
            }
        }

        $fuelTypesArrayIds = [];
        if ($request->filled('fuelTypeArray'))
        {
            $fuelTypeArray = $request->fuelTypeArray;

            $ft_ids = [];

            if (is_array($fuelTypeArray)) {
                foreach ($fuelTypeArray as $fuelTypeArrayValue) {
                    if (!is_null($fuelTypeArrayValue)) {
                        $fuel_type_contents = FuelType::where([['language_id', $language->id], ['slug', $fuelTypeArrayValue]])->first();
                        if (!empty($fuel_type_contents)) {
                            if (!in_array($fuel_type_contents->id, $ft_ids)) {
                                array_push($ft_ids, $fuel_type_contents->id);
                            }
                        }
                    }
                }
            }

            $ft_contents = CarContent::where('language_id', $language->id)
                ->whereIn('fuel_type_id', $ft_ids)
                ->get()
                ->pluck('car_id');
            foreach ($ft_contents as $content) {
                if (!in_array($content, $fuelTypesArrayIds)) {
                    array_push($fuelTypesArrayIds, $content);
                }
            }
        }

        // if ($request->filled('bodyTypeArray')) {
            // return response()->json([$bodyTypeArray,$bt_ids,$bodyTypesArrayIds]);
            // return response()->json([$bodyTypeArray,$bodyTypesArrayIds,$category_carIds]);
        // }

        $price = $body_type = $location =  $seat_min = $seat_max = $adtype = $delivery_available = $engine_size = $engine_power = $doors = $road_tax = $battery = $verification = $warranty = $owners = $mot = $year_min = $year_max = $engine_min = $engine_max = $power_min = $power_max = $dealer_type = "";
        
        if ($request->filled('adtype')) { $adtype = $request->adtype;  }
        if ($request->filled('delivery_available')) { $delivery_available = $request->delivery_available; }
        if ($request->filled('dealer_type')) { $dealer_type = $request->dealer_type;  }
        if ($request->filled('doors')) { $doors = $request->doors;  }
        if ($request->filled('engine_size')) { $engine_size = $request->engine_size;  }
        if ($request->filled('engine_power')) { $engine_power = $request->engine_power;  }
        if ($request->filled('road_tax')) { $road_tax = $request->road_tax;  }
        if ($request->filled('battery')) { $battery = $request->battery;  }
        if ($request->filled('verification')) { $verification = $request->verification;  }
        if ($request->filled('warranty')) { $warranty = $request->warranty;  }
        if ($request->filled('owners')) { $owners = $request->owners;  }
        if ($request->filled('mot')) { $mot = $request->mot;  }
        if ($request->filled('year_min')) { $year_min = $request->year_min;  }
        if ($request->filled('year_max')) { $year_max = $request->year_max;  }
        if ($request->filled('engine_min')) { $engine_min = $request->engine_min;  }
        if ($request->filled('engine_max')) { $engine_max = $request->engine_max;  }
        if ($request->filled('power_min')) { $power_min = $request->power_min;  }
        if ($request->filled('power_max')) { $power_max = $request->power_max;  }
        if ($request->filled('seat_min')) { $seat_min = $request->seat_min;  }
        if ($request->filled('seat_max')) { $seat_max = $request->seat_max;  }
        if ($request->filled('location')) { $location = $request->location;  }
        if ($request->filled('body_type')) { $body_type =

            $body_type = BodyType::where(['slug' =>$request->body_type])
            ->whereIn('cat_id',$cid)
            ->get()
            ->pluck('id');

        }
        if ($request->filled('price')) { $price = $request->price;  }
        //($request->filled('owners') ? $owners : $request->owners);

            $car_contents = Car::join('car_contents', 'cars.id', 'car_contents.car_id')
            ->join('vendors', 'cars.vendor_id', '=', 'vendors.id')
            ->leftjoin('car_images', 'cars.id', '=', 'car_images.car_id')
            ->leftjoin('body_types', 'body_types.id', '=', 'car_contents.body_type_id')
            ->where([['vendors.status', 1], ['cars.status', 1]])
            ->when($title, function ($query) use ($carIds) {
                return $query->whereIn('cars.id', $carIds);
            })
             ->when($adtype, function ($query) use ($adtype) {
                 return $query->where('cars.ad_type','LIKE', '%'.$adtype.'%');
            })
            ->when($delivery_available === '0' || $delivery_available === '1', function ($query) use ($delivery_available) {
                return $query->where('cars.delivery_available', $delivery_available);
            })
            ->when($dealer_type, function ($query) use ($dealer_type) {
                return $query->whereHas('vendor', function ($vendorQuery) use ($dealer_type) {
                    $vendorQuery->whereIn('vendor_type',$dealer_type);
                });
            })
            ->when($category, function ($query) use ($category_carIds) {
                // return $query->whereIn('car_id', $category_carIds);
                return $query->whereIn('car_contents.car_id', $category_carIds);
            })
            ->when($location, function ($query) use ($location) {
                return $query->where('cars.city', $location);
            })
            ->when($brands, function ($query) use ($brandIds) {
                return $query->whereIn('cars.id', $brandIds);
            })

            ->when($models, function ($query) use ($modelIds) {
                return $query->whereIn('cars.id', $modelIds);
            })
            ->when($fuel_type, function ($query) use ($fuel_type_id) {
                return $query->whereIn('cars.id', $fuel_type_id);
            })
            ->when($transmission, function ($query) use ($transmission_type_id) {
                return $query->whereIn('cars.id', $transmission_type_id);
            })
            ->when($colour, function ($query) use ($colour_id) {
                return $query->whereIn('cars.id', $colour_id);
            })
            ->when($doors, function ($query) use ($doors) {
                return $query->whereIn('cars.doors', $doors);
            })
            ->when($engine_size, function ($query) use ($engine_size) {
                return $query->where('cars.engineCapacity', $engine_size);
            })
            ->when($engine_power, function ($query) use ($engine_power) {
                return $query->where('cars.power', $engine_power);
            })
            ->when($road_tax, function ($query) use ($road_tax) {
                return $query->where('cars.road_tax', $road_tax);
            })
            ->when($battery, function ($query) use ($battery) {
                return $query->where('cars.battery', $battery);
            })
            ->when($verification, function ($query) use ($verification) {
                return $query->where('cars.verification', $verification);
            })
            ->when($warranty, function ($query) use ($warranty) {
                return $query->where('cars.warranty', $warranty);
            })
            ->when($owners, function ($query) use ($owners) {
                return $query->where('cars.number_of_owners', $owners)->orWhere('cars.owners', $owners);
            })
            ->when($mot, function ($query) use ($mot) {
                return $query->where('cars.valid_test', $mot);
            })
            ->when($year_min, function ($query) use ($year_min) {
                return $query->where('cars.year', '>=', $year_min);
            })
            ->when($year_max, function ($query) use ($year_max) {
                return $query->where('cars.year', '<=', $year_max);
            })
            ->when($engine_min, function ($query) use ($engine_min) {
                return $query->where('cars.engineCapacity', '>=', $engine_min);
            })
            ->when($engine_max, function ($query) use ($engine_max) {
                return $query->where('cars.engineCapacity', '<=', $engine_max);
            })
            ->when($power_min, function ($query) use ($power_min) {
                return $query->where('cars.power', '>=', $power_min);
            })
            ->when($power_max, function ($query) use ($power_max) {
                return $query->where('cars.power', '<=', $power_max);
            })
            ->when($seat_min, function ($query) use ($seat_min) {
                return $query->where('cars.seats', '>=', $seat_min);
            })
            ->when($seat_max, function ($query) use ($seat_max) {
                return $query->where('cars.seats', '<=', $seat_max);
            })
            ->when($min, function ($query) use ($min) {
                return $query->where('cars.price', '>=', $min);
            })
            ->when($max, function ($query) use ($max) {
                return $query->where('cars.price', '<=', $max);
            })
             ->when($mileage_min && $mileage_max, function ($query) use ($mileageIds) {
                return $query->whereIn('cars.id', $mileageIds);
            })
            ->when($body_type, function ($query) use ($body_type) {
                return $query->whereIn('car_contents.body_type_id', $body_type);
            })
            ->when($bodyTypeArray, function ($query) use ($bodyTypesArrayIds) {
                return $query->whereIn('cars.id', $bodyTypesArrayIds);
            })
            ->when($price, function ($query) use ($price) {
                return $query->where('cars.price', '>=', $price);
            })
            ->when($fuelTypeArray, function ($query) use ($fuelTypesArrayIds) {
                return $query->whereIn('cars.id', $fuelTypesArrayIds);
            })
            ->when($transmissionTypeArray, function ($query) use ($transmissionTypesArrayIds) {
                return $query->whereIn('cars.id', $transmissionTypesArrayIds);
            })
            ->when($colourTypeArray, function ($query) use ($colourTypeArrayIds) {
                return $query->whereIn('cars.id', $colourTypeArrayIds);
            });



            $filters = $request->all();

            $filteredKeys = [];

            foreach ($filters as $key => $value)
            {
                if (strpos($key, 'filters_') === 0)
                {
                    $filteredKeys[$key] = $value;
                }
            }


            foreach ($filteredKeys as $key => $value)
            {
                $filterName = substr($key, 8);

                if (is_array($value))
                {
                    $car_contents = $car_contents->whereJsonContains('cars.filters->' . $filterName, $value);
                }
                else
                {
                    $car_contents = $car_contents->where('cars.filters->' . $filterName, $value);
                }
            }

            if(empty($request->all()))
            {
                $car_contents = $car_contents->where('car_contents.main_category_id' , '!=' , 24);
            }


            // $car_contents = $car_contents->where('car_contents.language_id', $language->id)
            // ->select('cars.*', 'car_contents.title','car_contents.brand_id', 'car_contents.car_model_id', 'car_contents.slug', 'car_contents.category_id', 'car_contents.description',
            // )
            // ->orderByDesc('cars.is_featured')
            // ->orderBy($order_by_column, $order)
            // ->paginate(8);

            $car_contents = $car_contents->select(
                'cars.id',
                'cars.vendor_id',
                'cars.status',
                'cars.city',
                'cars.ad_type',
                'cars.delivery_available',
                'cars.doors',
                'cars.road_tax',
                'cars.verification',
                'cars.warranty',
                'cars.number_of_owners',
                'cars.owners',
                'cars.valid_test',
                'cars.year',
                'cars.engineCapacity',
                'cars.power',
                'cars.seats',
                'car_contents.title',
                'car_contents.brand_id',
                'car_contents.car_model_id',
                'car_contents.slug',
                'car_contents.category_id',
                'car_contents.description',
                'cars.feature_image',
                'cars.package_id',
                'cars.price',
                'cars.previous_price',
                'cars.is_featured',
                'cars.featured_date',
                'cars.created_at',
                'cars.updated_at',
                'cars.is_sale',
                'cars.is_sold',
                'cars.reduce_price',
                'cars.manager_special',
                'cars.deposit_taken',
                'cars.latitude',
                'cars.longitude',
                'cars.current_area_regis',
                'cars.warranty_type',
                'cars.warranty_duration',
                'cars.what_type',
                'cars.phone_no_revel',
                'cars.bump',
                'cars.bump_date',
                'cars.battery',
                'cars.order_id',
                'cars.deleted_at',
                'cars.phone_text',
                'cars.message_center',
                'cars.filters',
                'cars.fil_sub_categories',
                'cars.remove_option',
                'cars.recommendation',
                'cars.remove_remarks',
                'cars.financing_dealer',
                'cars.financing_url',
                'cars.vat_status',
                'body_types.id as body_type_id',
                'body_types.slug as body_type_slug',
                DB::raw('GROUP_CONCAT(car_images.image) as images') // Concatenate images
            )
            ->where('car_contents.language_id', $language->id)
            ->groupBy(
                'cars.id',
                'cars.vendor_id',
                'cars.status',
                'cars.city',
                'cars.ad_type',
                'cars.doors',
                'cars.road_tax',
                'cars.verification',
                'cars.warranty',
                'cars.number_of_owners',
                'cars.owners',
                'cars.valid_test',
                'cars.year',
                'cars.engineCapacity',
                'cars.power',
                'cars.seats',
                'car_contents.title',
                'car_contents.brand_id',
                'car_contents.car_model_id',
                'car_contents.slug',
                'car_contents.category_id',
                'car_contents.description',
                'cars.feature_image',
                'cars.package_id',
                'cars.price',
                'cars.previous_price',
                'cars.is_featured',
                'cars.featured_date',
                'cars.created_at',
                'cars.updated_at',
                'cars.is_sale',
                'cars.is_sold',
                'cars.reduce_price',
                'cars.manager_special',
                'cars.deposit_taken',
                'cars.latitude',
                'cars.longitude',
                'cars.current_area_regis',
                'cars.warranty_type',
                'cars.warranty_duration',
                'cars.what_type',
                'cars.phone_no_revel',
                'cars.bump',
                'cars.bump_date',
                'cars.battery',
                'cars.order_id',
                'cars.deleted_at',
                'cars.phone_text',
                'cars.message_center',
                'cars.filters',
                'cars.fil_sub_categories',
                'cars.remove_option',
                'cars.recommendation',
                'cars.remove_remarks',
                'cars.financing_dealer',
                'cars.financing_url',
                'cars.vat_status',
                'cars.vat_status',
                'body_types.id',
                'body_type_slug',
            )
            ->orderByDesc('cars.is_featured')
            ->orderBy($order_by_column, $order)
            ->paginate(15);

            // dd($car_contents);

            $total_cars = Car::join('car_contents', 'cars.id', 'car_contents.car_id')
            ->join('vendors', 'cars.vendor_id', '=', 'vendors.id')

            ->where([['vendors.status', 1], ['cars.status', 1]])
            ->when($title, function ($query) use ($carIds) {
                return $query->whereIn('cars.id', $carIds);
            })
             ->when($adtype, function ($query) use ($adtype) {
                 return $query->where('cars.ad_type','LIKE', '%'.$adtype.'%');
            })
            ->when($delivery_available === '0' || $delivery_available === '1', function ($query) use ($delivery_available) {
                return $query->where('cars.delivery_available', $delivery_available);
            })
            ->when($dealer_type, function ($query) use ($dealer_type) {
                return $query->whereHas('vendor', function ($vendorQuery) use ($dealer_type) {
                    $vendorQuery->whereIn('vendor_type',$dealer_type);
                });
            })
            ->when($category, function ($query) use ($category_carIds) {
                return $query->whereIn('car_id', $category_carIds);
            })
            ->when($location, function ($query) use ($location) {
                return $query->where('cars.city', $location);
            })
            ->when($brands, function ($query) use ($brandIds) {
                return $query->whereIn('cars.id', $brandIds);
            })

            ->when($models, function ($query) use ($modelIds) {
                return $query->whereIn('cars.id', $modelIds);
            })
            ->when($fuel_type, function ($query) use ($fuel_type_id) {
                return $query->whereIn('cars.id', $fuel_type_id);
            })
            ->when($transmission, function ($query) use ($transmission_type_id) {
                return $query->whereIn('cars.id', $transmission_type_id);
            })
            ->when($colour, function ($query) use ($colour_id) {
                return $query->whereIn('cars.id', $colour_id);
            })
            ->when($doors, function ($query) use ($doors) {
                return $query->whereIn('cars.doors', $doors);
            })
            ->when($engine_size, function ($query) use ($engine_size) {
                return $query->where('cars.engineCapacity', $engine_size);
            })
            ->when($engine_power, function ($query) use ($engine_power) {
                return $query->where('cars.power', $engine_power);
            })
            ->when($road_tax, function ($query) use ($road_tax) {
                return $query->where('cars.road_tax', $road_tax);
            })
            ->when($battery, function ($query) use ($battery) {
                return $query->where('cars.battery', $battery);
            })
            ->when($verification, function ($query) use ($verification) {
                return $query->where('cars.verification', $verification);
            })
            ->when($warranty, function ($query) use ($warranty) {
                return $query->where('cars.warranty', $warranty);
            })

            ->when($owners, function ($query) use ($owners) {
                  return $query->where('cars.number_of_owners', $owners)->orWhere('cars.owners', $owners);
            })
            ->when($mot, function ($query) use ($mot) {
                return $query->where('cars.valid_test', $mot);
            })
            ->when($year_min, function ($query) use ($year_min) {
                return $query->where('cars.year', '>=', $year_min);
            })
            ->when($year_max, function ($query) use ($year_max) {
                return $query->where('cars.year', '<=', $year_max);
            })
            ->when($engine_min, function ($query) use ($engine_min) {
                return $query->where('cars.engineCapacity', '>=', $engine_min);
            })
            ->when($engine_max, function ($query) use ($engine_max) {
                return $query->where('cars.engineCapacity', '<=', $engine_max);
            })
            ->when($power_min, function ($query) use ($power_min) {
                return $query->where('cars.power', '>=', $power_min);
            })
            ->when($power_max, function ($query) use ($power_max) {
                return $query->where('cars.power', '<=', $power_max);
            })
            ->when($seat_min, function ($query) use ($seat_min) {
                return $query->where('cars.seats', '>=', $seat_min);
            })
            ->when($seat_max, function ($query) use ($seat_max) {
                return $query->where('cars.seats', '<=', $seat_max);
            })
            ->when($min, function ($query) use ($min) {
                return $query->where('cars.price', '>=', $min);
            })
            ->when($max, function ($query) use ($max) {
                return $query->where('cars.price', '<=', $max);
            })
             ->when($mileage_min && $mileage_max, function ($query) use ($mileageIds) {
                return $query->whereIn('cars.id', $mileageIds);
            })
            ->when($body_type, function ($query) use ($body_type) {
                return $query->whereIn('car_contents.body_type_id', $body_type);
            })
            ->when($bodyTypeArray, function ($query) use ($bodyTypesArrayIds) {
                return $query->whereIn('cars.id', $bodyTypesArrayIds);
            })
            ->when($price, function ($query) use ($price) {
                return $query->where('cars.price', '>=', $price);
            })
            ->when($fuelTypeArray, function ($query) use ($fuelTypesArrayIds) {
                return $query->whereIn('cars.id', $fuelTypesArrayIds);
            })
            ->when($transmissionTypeArray, function ($query) use ($transmissionTypesArrayIds) {
                return $query->whereIn('cars.id', $transmissionTypesArrayIds);
            })
            ->when($colourTypeArray, function ($query) use ($colourTypeArrayIds) {
                return $query->whereIn('cars.id', $colourTypeArrayIds);
            });

             foreach ($filteredKeys as $key => $value)
            {
                $filterName = substr($key, 8);

                if (is_array($value))
                {
                    $total_cars = $total_cars->whereJsonContains('cars.filters->' . $filterName, $value);
                }
                else
                {
                    $total_cars = $total_cars->where('cars.filters->' . $filterName, $value);
                }
            }

            if(empty($request->all()))
            {
                $total_cars = $total_cars->where('car_contents.main_category_id' , '!=' , 24);
            }


            $total_cars= $total_cars->where('car_contents.language_id', $language->id)
            ->select('cars.*', 'car_contents.title',  'car_contents.slug', 'car_contents.category_id', 'car_contents.description')
            ->orderBy($order_by_column, $order)
            ->get()->count();

            // $car_contents['images']  = CarImage::whereIn('car_id',$carIds)->get();
            // $car_contents['images']  = 'waris';

        $information['car_contents'] = $car_contents;

        // dd($information['car_contents']);


        $min = Car::min('price');
        $max = Car::max('price');

        $information['min'] = intval($min);
        $information['max'] = intval($max);

        $information['total_cars'] = $total_cars;

        if($category_id >0 )
        {
            if($request->input('pid')>0)
            {
                $category_id = $request->input('pid');
            }

            $information['categories'] = Category::where('status', 1)->where('parent_id', $category_id)->orderBy('serial_number', 'asc')->get();
        }
        else
        {
            $information['categories'] = Category::where('status', 1)->where('parent_id', 0)->orderBy('serial_number', 'asc')->get();
        }

        if($category_id == 24)
        {
            $information['body_type'] =  BodyType::where('status', 1)->orderBy('serial_number', 'asc')->get();
        }
        else
        {
            $information['body_type'] = BodyType::where('status', 1)->where('cat_id' , $category_id)->orderBy('serial_number', 'asc')->get();
        }

        $information['category'] = Category::where('slug' , $request->category)->first();
        $information['carlocation'] = CountryArea::where('status', 1)->orderBy('name', 'asc')->get();
        $information['caryear'] = CarYear::where('status', 1)->orderBy('name', 'desc')->get();
        $information['adsprices'] = AdsPrice::where('status', 1)->orderBy('id', 'asc')->get();
        $information['adsmileage'] = AdsMileage::where('status', 1)->orderBy('id', 'asc')->get();
        //}

        $cate_id = $information['category'] ? [$information['category']->id] : [];

        if($information['category'] && $information['category']->parent_id == 0)
        {
           $cate_id =  $information['category']->children()->pluck('id');
        }

        // Retrieve popular brands
        $popularBrands = Brand::whereIn('cat_id', $cate_id)
        ->where('status', 1)
        ->withCount('cars')
        ->orderBy('cars_count', 'desc')
        ->orderBy('name', 'asc')
        ->take(10) // Adjust this number based on what you consider 'popular'
        ->get();

        // Retrieve remaining brands
        $otherBrands = Brand::whereIn('cat_id',  $cate_id )
        ->where('status', 1)
        // ->whereNotIn('id', $popularBrands->pluck('id'))
        ->orderBy('name', 'asc')
        ->get();

        // Combine results for view
        $information['brands'] = $popularBrands;

        $information['otherBrands'] = $otherBrands;

        $information['car_conditions'] = CarColor::where('status', 1)->orderBy('serial_number', 'asc')->get();

        $information['fuel_types'] = FuelType::where('status', 1)->orderBy('serial_number', 'asc')->get();

        $information['transmission_types'] = TransmissionType::where('status', 1)->orderBy('serial_number', 'asc')->get();

        $cate_id = json_decode(json_encode($cate_id) , true);

        if(in_array(24 , $cate_id))
        {
           $information['body_type'] =  BodyType::where('status', 1)->orderBy('serial_number', 'asc')->get();
        }
        else
        {
            $information['body_type'] = BodyType::where('status', 1)->whereIn('cat_id' , $cate_id)->orderBy('serial_number', 'asc')->get();
        }

        $information['engine_sizes'] = Car::select('engineCapacity')->whereNotNull('engineCapacity')->where('status', 1)->orderBy('engineCapacity','ASC')->get()->unique('engineCapacity')->values()->pluck('engineCapacity');

        $information['engine_power'] = Car::select('power')->whereNotNull('power')->where('status', 1)->orderBy('power','ASC')->get()->unique('power')->values()->pluck('power');

        $information['road_taxes'] = Car::select('road_tax')->whereNotNull('road_tax')->where('status', 1)->orderBy('road_tax','ASC')->get()->unique('road_tax')->values()->pluck('road_tax');

        $information['breadcrumb'] = array_reverse($parr);

        $information['bgImg'] = $misc->getBreadcrumb();

        $information['pageHeading'] = $misc->getPageHeading($language);

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
        ->whereHas('memberships.package', function ($query)
        {
            $query->where('title', 'turbo');
        })
        ->whereHas('cars')
        ->inRandomOrder()
        ->first();

        $information['getFeaturedVendors'] = $getFeaturedVendors;

        $filters = $this->getCategoriesFilter($request->category);

        if(!empty($filters))
        {
            $form_fields = FormFields::with('form_options')
            ->whereIn('category_field_id', $filters)
            ->whereNotIn('type', ['textarea', 'input'])
            ->get();

            if($form_fields->count() > 0 )
            {
               $filterData = $this->getFilter($form_fields);
               $information['filters'] = $filterData;
            }
        }


        if ($view_type == 'grid')
        {
             if ($request->isXmlHttpRequest())
            {
                $countHeading = $total_cars;

                if( $total_cars > 1)
                {
                    $countHeading .= ' Ads Found';
                }
                else
                {
                    $countHeading .= ' Ad Found';
                }

                 if (!empty(request()->input('category')))
                 {
                    $countHeading .=  ' in '.ucwords(str_replace("-"," ",(request()->input('category'))));
                 }

                $HTMLVIEW = view('frontend.car.cars_grid_ajax', $information)->render();

                return response()->json(['countHeading' => $countHeading , 'html_view' => $HTMLVIEW ]);
            }
            else
            {
               return view('frontend.car.cars_grid', $information);
            }


        }
        else
        {
            if ($request->isXmlHttpRequest())
            {
                $countHeading = $total_cars;

                if( $total_cars > 1)
                {
                    $countHeading .= ' Ads Found';
                }
                else
                {
                    $countHeading .= ' Ad Found';
                }

                 if (!empty(request()->input('category')))
                 {
                    $countHeading .=  ' in '.ucwords(str_replace("-"," ",(request()->input('category'))));
                 }

                //  return response()->json($information['car_contents']);

                $HTMLVIEW = view('frontend.car.cars_list_ajax', $information)->render();

                return response()->json(['countHeading' => $countHeading , 'html_view' => $HTMLVIEW ]);
            }
            else
            {

                return view('frontend.car.cars_list', $information);
            }
        }
    }

    function loadFilters(Request $request)
    {
        $category = $request->category;
        $deliveryAvailable = $request->delivery_available == '1' ? 1 : 0; // Fetch the delivery_available value


        $pid = $request->pid;

         $HTML = '';

        $category = Category::where([['slug', $category]])->first();

        if($category )
        {
            $categories = Category::where('parent_id' , $category->id)->get();

            $filter = $this->getCategoriesFilter($category->slug);

            $filters = null;

            if(!empty($filter) )
            {
                $form_fields = FormFields::with('form_options')
                ->whereIn('category_field_id', $filter)
                ->whereNotIn('type', ['textarea', 'input'])
                ->get();

                if($form_fields->count() > 0 )
                {
                    $filters = $this->getFilter($form_fields);
                }
            }

            $information['categories'] = $categories;
            $information['filters'] = $filters;
            $information['category']  = Category::where('slug' , $category->slug)->first();
            $information['carlocation'] = CountryArea::where('status', 1)->orderBy('name', 'asc')->get();
            // $information['delivery_available'] = Car::where('delivaery_available', $deliveryAvailable)->get(); // Filter by delivery_available
            $information['caryear'] = CarYear::where('status', 1)->orderBy('name', 'desc')->get();
            $information['adsprices'] = AdsPrice::where('status', 1)->orderBy('id', 'asc')->get();
            $information['adsmileage'] = AdsMileage::where('status', 1)->orderBy('id', 'asc')->get();



             $cate_id = $information['category'] ? [$information['category']->id] : [];

        if($information['category'] && $information['category']->parent_id == 0)
        {
           $cate_id =  $information['category']->children()->pluck('id');
        }



        // Retrieve popular brands
        $popularBrands = Brand::whereIn('cat_id', $cate_id)
        ->where('status', 1)
        ->withCount('cars')
        ->orderBy('cars_count', 'desc')
        ->orderBy('name', 'asc')
        ->take(10) // Adjust this number based on what you consider 'popular'
        ->get();

        // Retrieve remaining brands
        $otherBrands = Brand::whereIn('cat_id',  $cate_id )
        ->where('status', 1)
        // ->whereNotIn('id', $popularBrands->pluck('id'))
        ->orderBy('name', 'asc')
        ->get();

            $information['brands'] = $popularBrands;

            $information['delivery_available'] = Car::where('delivery_available', $deliveryAvailable)->get(); // Filter by delivery_available

            $information['otherBrands'] = $otherBrands;

            $information['car_conditions'] = CarColor::where('status', 1)->orderBy('serial_number', 'asc')->get();

            $information['fuel_types'] = FuelType::where('status', 1)->orderBy('serial_number', 'asc')->get();

            $information['transmission_types'] = TransmissionType::where('status', 1)->orderBy('serial_number', 'asc')->get();

            $cate_id = json_decode(json_encode($cate_id) , true);

            if(in_array(24 , $cate_id))
            {
               $information['body_type'] =  BodyType::where('status', 1)->orderBy('serial_number', 'asc')->get();
            }
            else
            {
                $information['body_type'] = BodyType::where('status', 1)->whereIn('cat_id' , $cate_id)->orderBy('serial_number', 'asc')->get();
            }

            $information['engine_sizes'] = Car::select('engineCapacity')->whereNotNull('engineCapacity')->where('status', 1)->orderBy('engineCapacity','ASC')->get()->unique('engineCapacity')->values()->pluck('engineCapacity');

            $information['engine_power'] = Car::select('power')->whereNotNull('power')->where('status', 1)->orderBy('power','ASC')->get()->unique('power')->values()->pluck('power');

            $information['road_taxes'] = Car::select('road_tax')->whereNotNull('road_tax')->where('status', 1)->orderBy('road_tax','ASC')->get()->unique('road_tax')->values()->pluck('road_tax');

            $HTML = view('frontend.car.carfilter', $information)->render();

            return response()->json(['result' => 'ok' , 'output' => $HTML , 'category_slug' => null ]);
        }
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


        function getCategoriesFilter($category)
    {
        $category_ids = [];
        $category = Category::where([['slug', $category]])->first();

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

    function notifyUser(Request $request)
    {
        $users = SaveSearch::with('user')->distinct('user_id')->pluck('user_id');

        $totalArray = [];

        foreach($users as $user)
        {
            $searches = SaveSearch::where('user_id' , $user)->get();

           $userArray = [];
            $user = Vendor::find($user);

            foreach($searches as $search)
            {
                $url = $search->search_url.'&lastcrawldate='.$search->last_save_date;

                $parsedUrl = parse_url($url);

                parse_str($parsedUrl['query'], $queryParams);

                $newRequest = new Request($queryParams);

                $countIf =  $this->getnotifyUserCount($newRequest);

                if($countIf > 0 )
                {
                    $searchArray = json_decode(json_encode($search), true);
                    $searchArray['countertotal'] = $countIf;
                    $userArray[] = $searchArray;
                }
            }

            if(count($userArray) > 0 )
            {

                $HTML =  view('email.savesearchalert' , compact('userArray'))->render();

                $data = ['recipient' => $user->email , 'subject' => 'Saved Search Alert'  , 'body' => $HTML ];

                SaveSearch::where('user_id' , $user->id)->update(['last_save_date' => date('Y-m-d H:i:s')]);

                \App\Http\Helpers\BasicMailer::sendMail($data);

                echo 'sent';
            }
        }

    }

        function getnotifyUserCount($request)
        {

        $misc = new MiscellaneousController();
        $language = $misc->getLanguage();
        $information['seoInfo'] = $language->seoInfo()->select('meta_keyword_cars', 'meta_description_cars')->first();

        if ($request->filled('type')) {
            Session::put('car_view_type', $request->type);
        }
        $view_type = Session::get('car_view_type');
        //echo $view_type; exit;
        $category = $mileage_min = $mileage_max = $title = $location = $brands = $models = $fuel_type = $transmission = $colour = $min = $max =  null;

        $carIds = [];
        if ($request->filled('title')) {
            $title = $request->title;
            $car_contents = CarContent::where('language_id', $language->id)
                ->where('title', 'like', '%' . $title . '%')
                ->get()
                ->pluck('car_id');
            foreach ($car_contents as $car_content) {
                if (!in_array($car_content, $carIds)) {
                    array_push($carIds, $car_content);
                }
            }
        }





        $category_id =0;
        $category_carIds = [];
        if ($request->filled('category')) {

            $category = $request->category;

            $category_content = Category::where([['language_id', $language->id], ['slug', $category]])->first();

            if($category_content == true)
            {
             $categories = Category::with('children')->where('parent_id', $category_content->id)->where('status', 1)->get()->map(function ($category) {
                    $children = $category->childArray();
                     unset($category->children);
                    $category->children = $children;
                    return $category;
                });
             $cid=  [];
              foreach ($categories as $cat) {
                    if (!in_array($cat->id,$cid)) {
                        array_push($cid,$cat->id);
                    }
                }

             array_push($cid,$category_content->id);

            if (!empty($category_content))
            {
                $category_id = $category_content->id;

               // Get initial records from CarContent
                $contents_from_car_content = CarContent::whereIn('category_id', $cid)->get()->pluck('car_id');

                // Add the initial records to the category_carIds array
                $category_carIds = $contents_from_car_content->toArray();

                // Get additional records from Car
                $additional_contents = Car::whereRaw('JSON_CONTAINS(fil_sub_categories, \'["' . $category_id . '"]\')')->get()->pluck('id');

                // Merge additional contents with category_carIds and ensure uniqueness
                foreach ($additional_contents as $content)
                {
                    if (!in_array($content, $category_carIds))
                    {
                        array_push($category_carIds, $content);
                    }
                }
            }

            }

        }


        $brandIds = [];
        if ($request->filled('brands'))
        {
            $brands = $request->brands;

            if(empty($brands[0]))
            {
               $brands =  Brand::where('status' , 1)->pluck('slug');
               $brands = json_decode($brands , true);
            }

            $b_ids = [];

            if (is_array($brands)) {
                foreach ($brands as $brand) {
                    if (!is_null($brand)) {
                        $brand_car_contents = Brand::where([['language_id', $language->id], ['slug', $brand]])->first();
                        if (!empty($brand_car_contents)) {
                            if (!in_array($brand_car_contents->id, $b_ids)) {
                                array_push($b_ids, $brand_car_contents->id);
                            }
                        }
                    }
                }
            } else {
                $brand_car_contents = Brand::where([['language_id', $language->id], ['slug', $brands]])->first();
                if (!in_array($brand_car_contents->id, $b_ids)) {
                    array_push($b_ids, $brand_car_contents->id);
                }
            }

            $contents = CarContent::where('language_id', $language->id)
                ->whereIn('brand_id', $b_ids)
                ->get()
                ->pluck('car_id');
            foreach ($contents as $content) {
                if (!in_array($content, $brandIds)) {
                    array_push($brandIds, $content);
                }
            }
        }
        //echo "<pre>";
        //print_r($brandIds);

        $modelIds = [];

        if ($request->filled('models')) {

          //  print_r($request->models); exit;
            if(($request->models[0]!="")) {
            $models = $request->models;
            $m_ids = [];
            if (is_array($models)) {
                foreach ($models as $model) {
                    $model_car_contents = CarModel::where([['language_id', $language->id], ['slug', $model]])->where('status', 1)->first();
                    if (!in_array($model_car_contents->id, $m_ids)) {
                        array_push($m_ids, $model_car_contents->id);
                    }
                }
            } else {
                $model_car_contents = CarModel::where([['language_id', $language->id], ['slug', $models]])->where('status', 1)->first();
                if (!in_array($model_car_contents->id, $m_ids)) {
                    array_push($m_ids, $model_car_contents->id);
                }
            }

            $contents = CarContent::where('language_id', $language->id)
                ->whereIn('car_model_id', $m_ids)
                ->get();
            foreach ($contents as $content) {
                if (!in_array($content->car_id, $modelIds)) {
                    array_push($modelIds, $content->car_id);
                }
            }
        }
    }

        $fuel_type_id = [];
        if ($request->filled('fuel_type')) {
            $fuel_type = $request->fuel_type;
            $fuel_type_content = FuelType::where([['language_id', $language->id], ['slug', $fuel_type]])->first();
            if (!empty($fuel_type_content)) {
                $f_id = $fuel_type_content->id;
                $contents = CarContent::where('language_id', $language->id)
                    ->where('fuel_type_id', $f_id)
                    ->get()
                    ->pluck('car_id');
                foreach ($contents as $content) {
                    if (!in_array($content, $fuel_type_id)) {
                        array_push($fuel_type_id, $content);
                    }
                }
            }
        }

        $transmission_type_id = [];
        if ($request->filled('transmission')) {
            $transmission = $request->transmission;
            $transmission_content = TransmissionType::where([['language_id', $language->id], ['slug', $transmission]])->first();
            if (!empty($transmission_content)) {
                $t_id = $transmission_content->id;
                $contents = CarContent::where('language_id', $language->id)
                    ->where('transmission_type_id', $t_id)
                    ->get()
                    ->pluck('car_id');
                foreach ($contents as $content) {
                    if (!in_array($content, $transmission_type_id)) {
                        array_push($transmission_type_id, $content);
                    }
                }
            }
        }
        $colour_id = [];
        if ($request->filled('colour')) {
            $colour = $request->colour;
            $colour_content = CarColor::where([['language_id', $language->id], ['slug', $colour]])->first();
            if (!empty($colour_content)) {
                $c_id = $colour_content->id;
                $contents = CarContent::where('language_id', $language->id)
                    ->where('car_colour_id', $c_id)
                    ->get()
                    ->pluck('car_id');
                foreach ($contents as $content) {
                    if (!in_array($content, $colour_id)) {
                        array_push($colour_id, $content);
                    }
                }
            }
        }


        $priceIds = [];

        if ($request->filled('min') || $request->filled('max')) {
            if ($request->filled('min') && $request->filled('max')) {
                $min = intval($request->min);
                $max = intval($request->max);
            } elseif ($request->filled('min')) {
                $min = intval($request->min);
                $max = intval(65000);
            } elseif ($request->filled('max')) {
                 $min = intval(0);
                $max = intval(($request->max));
            }
            $price_cars = DB::table('cars')
                ->select('*')
                ->where('price', '>=', $min)
                ->where('price', '<=', DB::raw($max))
                ->get();
            foreach ($price_cars as $car) {
                if (!in_array($car->id, $priceIds)) {
                    array_push($priceIds, $car->id);
                }
            }
        }

        $mileageIds = [];

        if ($request->filled('mileage_min') || $request->filled('mileage_max')) {
            if ($request->filled('mileage_min') && $request->filled('mileage_max')) {
                $mileage_min = ($request->mileage_min);
                $mileage_max = ($request->mileage_max);
            } elseif ($request->filled('mileage_min')) {
                $mileage_min = ($request->mileage_min);
                $mileage_max = (400000);
            } elseif ($request->filled('mileage_max')) {
                 $mileage_min = (0);
                $mileage_max = (($request->mileage_max));
            }
          //  echo $mileage_min; exit;
            $mileage_cars = DB::table('cars')
                ->select('*')
                ->where('mileage', '>=', $mileage_min)
                ->where('mileage', '<=', $mileage_max)
                ->get();
            foreach ($mileage_cars as $mileage) {
                if (!in_array($mileage->id, $mileageIds)) {
                    array_push($priceIds, $mileage->id);
                }
            }
        }

        if ($request->filled('sort')) {
            if ($request['sort'] == 'new') {
                $order_by_column = 'cars.id';
                $order = 'desc';
            } elseif ($request['sort'] == 'old') {
                $order_by_column = 'cars.id';
                $order = 'asc';
            } elseif ($request['sort'] == 'high-to-low') {
                $order_by_column = 'cars.price';
                $order = 'desc';
            } elseif ($request['sort'] == 'low-to-high') {
                $order_by_column = 'cars.price';
                $order = 'asc';
            }
            elseif ($request['sort'] == 'high-to-mileage') {
                $order_by_column = 'cars.mileage';
                $order = 'desc';
            } elseif ($request['sort'] == 'low-to-mileage') {
                $order_by_column = 'cars.mileage';
                $order = 'asc';
            }
            else
            {
                $order_by_column = 'cars.id';
                $order = 'desc';
            }
        }
        else
        {
            $order_by_column = 'cars.id';
            $order = 'desc';
        }
        
        
        $location =$seat_min = $seat_max = $adtype = $delivery_available = $doors = $engine_size = $engine_power = $road_tax = $battery = $verification = $warranty = $owners = $mot = $year_min = $year_max = $engine_min = $engine_max = $power_min = $power_max = $dealer_type = "";
        
        if ($request->filled('adtype')) { $adtype = $request->adtype;  }
        if ($request->filled('delivery_available')) { $delivery_available = $request->delivery_available;  }
        if ($request->filled('dealer_type')) { $dealer_type = $request->dealer_type;  }
        if ($request->filled('doors')) { $doors = $request->doors;  }
        if ($request->filled('engine_size')) { $engine_size = $request->engine_size;  }
        if ($request->filled('engine_power')) { $engine_power = $request->engine_power;  }
        if ($request->filled('road_tax')) { $road_tax = $request->road_tax;  }
        if ($request->filled('battery')) { $battery = $request->battery;  }
        if ($request->filled('verification')) { $verification = $request->verification;  }
        if ($request->filled('warranty')) { $warranty = $request->warranty;  }
        if ($request->filled('owners')) { $owners = $request->owners;  }
        if ($request->filled('mot')) { $mot = $request->mot;  }
        if ($request->filled('year_min')) { $year_min = $request->year_min;  }
        if ($request->filled('year_max')) { $year_max = $request->year_max;  }
        if ($request->filled('engine_min')) { $engine_min = $request->engine_min;  }
        if ($request->filled('engine_max')) { $engine_max = $request->engine_max;  }
        if ($request->filled('power_min')) { $power_min = $request->power_min;  }
        if ($request->filled('power_max')) { $power_max = $request->power_max;  }
        if ($request->filled('seat_min')) { $seat_min = $request->seat_min;  }
        if ($request->filled('seat_max')) { $seat_max = $request->seat_max;  }
        if ($request->filled('location')) { $location = $request->location;  }
        //($request->filled('owners') ? $owners : $request->owners);

            $total_cars = Car::join('car_contents', 'cars.id', 'car_contents.car_id')
            ->join('vendors', 'cars.vendor_id', '=', 'vendors.id')

            ->where([['vendors.status', 1], ['cars.status', 1]])
            ->when($title, function ($query) use ($carIds) {
                return $query->whereIn('cars.id', $carIds);
            })
             ->when($adtype, function ($query) use ($adtype) {
                return $query->where('cars.ad_type','LIKE', '%'.$adtype.'%');
            })
            ->when($delivery_available === '0' || $delivery_available === '1', function ($query) use ($delivery_available) {
                return $query->where('cars.delivery_available', $delivery_available);
            })
            ->when($dealer_type, function ($query) use ($dealer_type) {
                return $query->whereHas('vendor', function ($vendorQuery) use ($dealer_type) {
                    $vendorQuery->whereIn('vendor_type',$dealer_type);
                });
            })
            ->when($category, function ($query) use ($category_carIds) {
                return $query->whereIn('car_id', $category_carIds);
            })
            ->when($location, function ($query) use ($location) {
                return $query->where('cars.city', $location);
            })
            ->when($brands, function ($query) use ($brandIds) {
                return $query->whereIn('cars.id', $brandIds);
            })
            ->when($models, function ($query) use ($modelIds) {
                return $query->whereIn('cars.id', $modelIds);
            })
            ->when($fuel_type, function ($query) use ($fuel_type_id) {
                return $query->whereIn('cars.id', $fuel_type_id);
            })
            ->when($transmission, function ($query) use ($transmission_type_id) {
                return $query->whereIn('cars.id', $transmission_type_id);
            })
            ->when($colour, function ($query) use ($colour_id) {
                return $query->whereIn('cars.id', $colour_id);
            })
            ->when($doors, function ($query) use ($doors) {
                return $query->whereIn('cars.doors', $doors);
            })
            ->when($engine_size, function ($query) use ($engine_size) {
                return $query->where('cars.engineCapacity', $engine_size);
            })
            ->when($engine_power, function ($query) use ($engine_power) {
                return $query->where('cars.power', $engine_power);
            })
            ->when($road_tax, function ($query) use ($road_tax) {
                return $query->where('cars.road_tax', $road_tax);
            })
            ->when($battery, function ($query) use ($battery) {
                return $query->where('cars.battery', $battery);
            })
            ->when($verification, function ($query) use ($verification) {
                return $query->where('cars.verification', $verification);
            })
            ->when($warranty, function ($query) use ($warranty) {
                return $query->where('cars.warranty', $warranty);
            })
            ->when($owners, function ($query) use ($owners) {
                return $query->where('cars.owners', $owners);
            })
            ->when($mot, function ($query) use ($mot) {
                return $query->where('cars.valid_test', $mot);
            })
            ->when($year_min, function ($query) use ($year_min) {
                return $query->where('cars.year', '>=', $year_min);
            })
            ->when($year_max, function ($query) use ($year_max) {
                return $query->where('cars.year', '<=', $year_max);
            })
            ->when($engine_min, function ($query) use ($engine_min) {
                return $query->where('cars.engineCapacity', '>=', $engine_min);
            })
            ->when($engine_max, function ($query) use ($engine_max) {
                return $query->where('cars.engineCapacity', '<=', $engine_max);
            })
            ->when($power_min, function ($query) use ($power_min) {
                return $query->where('cars.power', '>=', $power_min);
            })
            ->when($power_max, function ($query) use ($power_max) {
                return $query->where('cars.power', '<=', $power_max);
            })
            ->when($seat_min, function ($query) use ($seat_min) {
                return $query->where('cars.seats', '>=', $seat_min);
            })
            ->when($seat_max, function ($query) use ($seat_max) {
                return $query->where('cars.seats', '<=', $seat_max);
            })
            ->when($min, function ($query) use ($min) {
                return $query->where('cars.price', '>=', $min);
            })
            ->when($max, function ($query) use ($max) {
                return $query->where('cars.price', '<=', $max);
            })
             ->when($mileage_min && $mileage_max, function ($query) use ($mileageIds) {
                return $query->whereIn('cars.id', $mileageIds);
            });

            $filters = $request->all();

            $filteredKeys = [];

            foreach ($filters as $key => $value)
            {
                if (strpos($key, 'filters_') === 0)
                {
                    $filteredKeys[$key] = $value;
                }
            }

            foreach ($filteredKeys as $key => $value)
            {
                $filterName = substr($key, 8);

                if (is_array($value))
                {
                    $total_cars = $total_cars->whereJsonContains('cars.filters->' . $filterName, $value);
                }
                else
                {
                    $total_cars = $total_cars->where('cars.filters->' . $filterName, $value);
                }
            }

            $total_cars= $total_cars->where('car_contents.language_id', $language->id)
            ->where('cars.created_at', '>', $request->lastcrawldate)
            ->whereNull('cars.bump_date')
            ->select('cars.*', 'car_contents.title',  'car_contents.slug', 'car_contents.category_id', 'car_contents.description')
            ->orderBy($order_by_column, $order)
            ->get()->count();


            return $total_cars;
    }


    function phoneRevealCount(Request $request)
    {
        $car_id =  $request->car_id;
        $car = Car::find( $car_id);
        $counter = 0;
        if($car == true)
        {
            $counter = $car->phone_no_revel;
        }
        Car::where('id' , $car_id)->update(['phone_no_revel' => $counter+1]);
        echo  $counter;
    }

    function adImpressionCount(Request $request)
    {

        $ad_id =  $request->ad_id;

        $ad_impression = DB::table('ad_impressions')->where('ad_id' ,  $ad_id)->first();

        $counter = 0;

        if($ad_impression == true)
        {
            $counter = $ad_impression->impressions;
            DB::table('ad_impressions')->where('ad_id' ,  $ad_id)->update(['impressions' => $counter+1]);
        }

        if($ad_impression == false)
        {
            DB::table('ad_impressions')->insert(['impressions' => 1 , 'ad_id' =>  $ad_id ]);
        }

        echo  $counter;
    }
    public function details($cattitle, $slug, $id)
    {

        $misc = new MiscellaneousController();

        $language = $misc->getLanguage();

        $information['car'] = Car::with(['car_content' => function ($query) use ($language)
        {
            return $query->where('language_id', $language->id);
        }, 'galleries'])
            ->join('vendors', 'cars.vendor_id', '=', 'vendors.id')
            ->where([
                ['vendors.status', '=', 1]
            ])
            ->select('cars.*')
            ->where('cars.id', $id)->firstOrFail();

        if (Auth::guard('vendor')->check()) {
        $userId = Auth::guard('vendor')->user()->id;
        $adId = $information['car']->id;

        // Get the current timestamp rounded to the nearest minute
        $currentTimestamp = now()->format('Y-m-d H:i');

        // Check if a record already exists with the same user_id, ad_id, and created_at within the same minute
        $existingRecord = DB::table('browsing_histories')
        ->where('user_id', $userId)
        ->where('ad_id', $adId)
        ->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') = ?", [$currentTimestamp])
        ->exists();

        // Only create a new record if no existing record is found
            if (!$existingRecord)
            {
                BrowsingHistory::create([
                    'user_id' => $userId,
                    'ad_id' => $adId,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        $information['currentDay'] = ucfirst(now()->format('l')); // Get the current day of the week
        $information['currentTime'] = now()->format('H:i'); // Get the current time in 24-hour format
        $information['openingHours']  = DB::table('opening_hours')->where('vendor_id' , $information['car']->vendor->id )->get()->keyBy('day_of_week')->toArray();

        $information['bgImg'] = $misc->getBreadcrumb();

        $car_content = CarContent::where('language_id', $language->id)->where('car_id', $id)->first();
        if (is_null($car_content)) {
            Session::flash('message', 'No ads information found for ' . $language->name . ' language');
            Session::flash('alert-type', 'warning');
            return redirect()->route('index');
        }
        $category_id = $car_content->category_id;
        $information['language'] = $language;

        if($information['car']->vendor->vendor_type == 'normal' )
        {
          $information['specifications'] = CarSpecification::where('car_id', $id)->get();
        }
        else
        {
            $information['specifications'] = DB::table('vehicle_features')->where('add_id', $id)->get();

            $information['specification_pluck'] = DB::table('vehicle_features')->where('add_id', $id)->distinct()->pluck('parent_name');
        }

         if($information['car']->vendor->vendor_type == 'normal' )
         {
            $information['related_cars'] = Car::with('vendor')->join('car_contents', 'car_contents.car_id', 'cars.id')

            ->where('car_contents.language_id', $language->id)
            ->where('car_contents.category_id', $category_id)
            ->where('cars.id', '!=', $id)
            ->where('cars.is_sold', false) // Exclude sold cars
            ->select('cars.*', 'car_contents.slug', 'car_contents.title', 'car_contents.category_id', 'car_contents.language_id', 'car_contents.brand_id', 'car_contents.car_model_id')
            ->limit(6)->get();
         }
         else
         {
            $information['related_cars'] = Car::with('vendor')->join('car_contents', 'car_contents.car_id', 'cars.id')

            ->where('car_contents.language_id', $language->id)
            ->where('cars.id', '!=', $id)
            ->where('cars.vendor_id', $information['car']->vendor->id)
            ->select('cars.*', 'car_contents.slug', 'car_contents.title', 'car_contents.category_id', 'car_contents.language_id', 'car_contents.brand_id', 'car_contents.car_model_id')
            ->limit(6)->get();
         }


        $latest_cars = Car::join('car_contents', 'car_contents.car_id', 'cars.id')
        ->where('car_contents.language_id', $language->id)
        ->where('cars.id', '!=', $id);

        if($information['car']->vendor->vendor_type == 'dealer')
        {
           $latest_cars = $latest_cars->where('cars.vendor_id', $information['car']->vendor->id);
        }

        $latest_cars = $latest_cars->orderBy('id', 'desc')
        ->select('cars.*', 'car_contents.slug', 'car_contents.language_id', 'car_contents.category_id', 'car_contents.title', 'car_contents.brand_id', 'car_contents.car_model_id')
        ->limit(4)->get();

        $information['latest_cars'] = $latest_cars;

        $information['info'] = Basic::select('google_recaptcha_status')->first();

        /// new visitor count

         $ipAddress = \Request::ip();

        if ($information['car'])
        {
            $visitor = new Visitor();
            $visitor->car_id = $id;
            $visitor->ip_address = $ipAddress;
            $visitor->vendor_id = $information['car']->vendor_id;
            $visitor->date = Carbon::now()->format('y-m-d');
            $visitor->save();
        }

        return view('frontend.car.details', $information);
    }


    //contact
    public function contact(Request $request)
    {
        $mail_template = MailTemplate::where('mail_type', 'inquiry_about_car')->first();

        $rules = [
            'name' => 'required',
            'car_id' => 'required',
            'email' => 'required|email:rfc,dns',
            'phone' => 'required',
            'message' => 'required'
        ];

        $info = Basic::select('google_recaptcha_status')->first();
        if ($info->google_recaptcha_status == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $messageArray = [];

        if ($info->google_recaptcha_status == 1) {
            $messageArray['g-recaptcha-response.required'] = 'Please verify that you are not a robot.';
            $messageArray['g-recaptcha-response.captcha'] = 'Captcha error! try again later or contact site admin.';
        }

        $be = Basic::select('smtp_status', 'smtp_host', 'smtp_port', 'encryption', 'smtp_username', 'smtp_password', 'from_mail', 'from_name', 'to_mail', 'website_title')->firstOrFail();

        $misc = new MiscellaneousController();

        $language = $misc->getLanguage();
        $car = Car::with(['car_content' => function ($query) use ($language) {
            return $query->where('language_id', $language->id);
        }])->where('id', $request->car_id)->first();

        $car_name = $car->car_content->title;
        $slug = $car->car_content->slug;
        $url = route('frontend.car.details', ['slug' => $slug, 'id' => $request->car_id]);


        if ($car->vendor_id != 0) {
            $vendor = Vendor::where('id', $car->vendor_id)->select('email', 'username')->first();
            $send_email_address = $vendor->email;
            $user_name = $vendor->username;
        } else {
            $send_email_address = $be->to_mail;
            $user_name = 'Admin';
        }

        $request->validate($rules, $messageArray);



        if ($be->smtp_status == 111) {
            $subject = 'Inquiry about ' . $car_name;

            $body = $mail_template->mail_body;
            $body = preg_replace("/{username}/", $user_name, $body);
            $body = preg_replace("/{car_name}/", "<a href=" . $url . ">$car_name</a>", $body);
            $body = preg_replace("/{enquirer_name}/", $request->name, $body);
            $body = preg_replace("/{enquirer_email}/", $request->email, $body);
            $body = preg_replace("/{enquirer_phone}/", $request->phone, $body);
            $body = preg_replace("/{enquirer_message}/", nl2br($request->message), $body);
            $body = preg_replace("/{website_title}/", $be->website_title, $body);

            // if smtp status == 1, then set some value for PHPMailer
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
                $data = [
                    'to' => $send_email_address,
                    'subject' => $subject,
                    'body' => $body,
                ];

                Mail::send([], [], function (Message $message) use ($data, $be) {
                    $fromMail = $be->from_mail;
                    $fromName = $be->from_name;
                    $message->to($data['to'])
                        ->subject($data['subject'])
                        ->from($fromMail, $fromName)
                        ->html($data['body'], 'text/html');
                });

                Session::flash('success', 'Message sent successfully');
                return back();
            } catch (Exception $e) {
                Session::flash('error', $e);
                return back();
            }
        }
    }

    public function store_visitor(Request $request)
    {
        $request->validate([
            'car_id'
        ]);
        $ipAddress = \Request::ip();
        $check = Visitor::where([['car_id', $request->car_id], ['ip_address', $ipAddress], ['date', Carbon::now()->format('y-m-d')]])->first();

        $car = Car::where('id', $request->car_id)->first();
        if ($car) {
            if (!$check) {
                $visitor = new Visitor();
                $visitor->car_id = $request->car_id;
                $visitor->ip_address = $ipAddress;
                $visitor->vendor_id = $car->vendor_id;
                $visitor->date = Carbon::now()->format('y-m-d');
                $visitor->save();
            }
        }
    }
}
