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

class SaveAdController extends Controller
{   
        public function __construct()
        {
                 
        }
        
        public function getAdsAfterFilter(Request $request)
        {
            
            $category_id =0;
            $category_carIds = [];
            $category = $mileage_min = $mileage_max = $title = $location = $brands = $models = $fuel_type = $transmission = $colour = $min = $max =  null;
            if ($request->filled('category')) 
            {
                
                $category = $request->category;
                $category_content = Category::where([ ['slug', $category]])->first();
                 $categories = Category::with('children')->where('parent_id', $category_content->id)->where('status', 1)->get()->map(function ($category) {
                        $children = $category->childArray(); 
                         unset($category->children);
                        $category->children = $children;
                        return $category;
                    });
                    
                 $cid=  [];
                foreach ($categories as $cat) 
                {
                    if (!in_array($cat->id,$cid)) 
                    {
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
          
    
            $brandIds = [];
            if ($request->filled('brands')) 
            {
                $brands = $request->brands;
                 
                if(empty($brands))
                {
                   $brands =  Brand::where('status' , 1)->pluck('slug'); 
                   $brands = json_decode($brands , true);
                }
              
                $b_ids = [];
    
              
                    $brand_car_contents = Brand::where([ ['slug', $brands]])->first();
                    if (!in_array($brand_car_contents->id, $b_ids)) {
                        array_push($b_ids, $brand_car_contents->id);
                    }
               
    
                $contents = CarContent::whereIn('brand_id', $b_ids)
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
    
            if ($request->filled('models')) 
            {
                
              //  print_r($request->models); exit;
                if(($request->models!="")) 
                {
                $models = $request->models;
                $m_ids = [];
              
                $model_car_contents = CarModel::where([['slug', $models]])->where('brand_id' , $brand_car_contents->id)->where('status', 1)->first();
                 
                if (!in_array($model_car_contents->id, $m_ids)) 
                {
                    array_push($m_ids, $model_car_contents->id);
                }
                
    
                $contents = CarContent::whereIn('car_model_id', $m_ids)
                    ->get();
                   
                foreach ($contents as $content) {
                    if (!in_array($content->car_id, $modelIds)) {
                        array_push($modelIds, $content->car_id);
                    }
                }
            }
        }
 
            $fuel_type_id = [];
            if ($request->filled('fuel_type_id')) {
                $fuel_type = $request->fuel_type_id;
                $fuel_type_content = FuelType::where([ ['slug', $fuel_type]])->first();
                if (!empty($fuel_type_content)) {
                    $f_id = $fuel_type_content->id;
                    $contents = CarContent::where('fuel_type_id', $f_id)
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
            if ($request->filled('transmission_type_id')) {
                $transmission = $request->transmission_type_id;
                $transmission_content = TransmissionType::where([ ['slug', $transmission]])->first();
                if (!empty($transmission_content)) {
                    $t_id = $transmission_content->id;
                    $contents = CarContent::where('transmission_type_id', $t_id)
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
            if ($request->filled('car_colour_id')) {
                $colour = $request->car_colour_id;
                $colour_content = CarColor::where([['slug', $colour]])->first();
                if (!empty($colour_content)) {
                    $c_id = $colour_content->id;
                    $contents = CarContent::where('car_colour_id', $c_id)->orWhere('car_color_id' , $c_id)
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
        
            $location =  $seat_min = $seat_max = $adtype = $doors  = $owners  = $year_min = $year_max = $engine_min = $engine_max = $power_min = $power_max = $dealer_type = "";
            
            if ($request->filled('ad_type')) { $adtype = $request->ad_type;  }
            if ($request->filled('dealer_type')) { $dealer_type = $request->dealer_type;  }
            if ($request->filled('doors')) { $doors = $request->doors;  }
            if ($request->filled('owners')) { $owners = $request->owners;  }
            if ($request->filled('year_min')) { $year_min = $request->year_min;  }
            if ($request->filled('year_max')) { $year_max = $request->year_max;  }
            if ($request->filled('engine_min')) { $engine_min = $request->engine_min;  }
            if ($request->filled('engine_max')) { $engine_max = $request->engine_max;  }
            if ($request->filled('power_min')) { $power_min = $request->power_min;  }
            if ($request->filled('power_max')) { $power_max = $request->power_max;  }
            if ($request->filled('seat_min')) { $seat_min = $request->seat_min;  }
            if ($request->filled('seat_max')) { $seat_max = $request->seat_max;  }
            if ($request->filled('location')) { $location = $request->location;  }
            
             $car_contents = Car::join('car_contents', 'cars.id', 'car_contents.car_id')
            ->join('vendors', 'cars.vendor_id', '=', 'vendors.id')
            ->where([['vendors.status', 1], ['cars.status', 1]])
            
             ->when($adtype, function ($query) use ($adtype) {
                return $query->where('cars.ad_type', $adtype);
            })
            ->when($dealer_type && $dealer_type != 'any', function ($query) use ($dealer_type) {
            return $query->whereHas('vendor', function ($vendorQuery) use ($dealer_type) {
            if ($dealer_type == 'dealer') {
            $vendorQuery->where('vendor_type', 'dealer');
            } else {
            $vendorQuery->where('vendor_type', 'normal');
            }
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
                return $query->where('cars.doors', $doors);
            })
         
            ->when($owners, function ($query) use ($owners) {
                return $query->where('cars.number_of_owners', $owners)->orWhere('cars.owners', $owners);
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
            ->when($min && $max, function ($query) use ($priceIds) {
                return $query->whereIn('cars.id', $priceIds);
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
                    $car_contents = $car_contents->whereJsonContains('cars.filters->' . $filterName, $value);
                } 
                else 
                {
                    $car_contents = $car_contents->where('cars.filters->' . $filterName, $value);
                }
            }

            $car_contents = $car_contents->select('cars.*', 'car_contents.title','car_contents.brand_id', 'car_contents.car_model_id', 'car_contents.slug', 'car_contents.category_id', 'car_contents.description')
            ->orderByDesc('cars.is_featured')
            ->orderBy($order_by_column, $order)
            ->paginate(15);
            
            
            $car_contents->getCollection()->transform(function ($car) 
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
    
            
            
             return response()->json($car_contents, 200);
        }
        
        
        
        public function imagermv(Request $request)
    {
        
        $rules = [
                'fileid' => 'required',
            ];
        
            $messages =  [
                'fileid.required' => 'file id is required.',
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()) 
            {
                return response()->json([
                'error' => $validator->errors()
                ], 422);
            } 
            
            
        $pi = CarImage::findOrFail($request->fileid);
        
        $imageCount = CarImage::where('car_id', $pi->car_id)->get()->count();
        
        if ($imageCount > 1) 
        {
            @unlink(public_path('assets/admin/img/car-gallery/') . $pi->image);
            $pi->delete();
            
            return response()->json([
                'success' => 'deleted successfully deleted'
                ], 200);
        } 
        else 
        {
           return response()->json([
                'error' => 'something went wrong'
                ], 500);
        }
    }
    
    
        function updateAd(Request $request)
        {
            
            $rules = [
                'ad_id' => 'required',
                'title' => 'required|max:255',
                'price' => 'required',
                'description' => 'required|min:15',
            ];
        
            $messages =  [
                'ad_id.required' => 'Ad id is required.',
                'title.required' => 'Title is required.',
                'price.required' => 'Price is required.',
                'description.required' => 'Description is required minimum 15 char.',
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()) 
            {
                return response()->json([
                'error' => $validator->errors()
                ], 422);
            } 
            
            $city = request()->user()->vendor_info->city;
            
            if(empty($city))
            {
                return response()->json([
                'error' => 'Please first update your city and phone number from your edit profile section.'
                ], 422);
            }
            
            $ad = Car::find($request->ad_id);
            
            $packg = PrivatePackage::where('id', $ad->package_id)->first();
            
            if(!empty($request->slider_images))
            {
                
        
            $max_file_upload = $packg->photo_allowed;
            
            $slider_images_count = count($request->slider_images);
            
            if ($slider_images_count > $max_file_upload) 
            {
                $errors = [
                    'slider_images' => [
                        "You can upload a maximum of {$max_file_upload} images on selected package. Please remove some images or select different package."
                    ]
                ];
            
                return response()->json(['errors' => $errors], 422);
            }
            
            
                   $allowedExts = ['jpg', 'png', 'jpeg', 'svg', 'webp'];
                
                $rules = [
                'slider_images.*' => [
                function ($attribute, $value, $fail) use ($allowedExts) {
                    $ext = $value->getClientOriginalExtension();
                    if (!in_array($ext, $allowedExts)) {
                        return $fail("Only png, jpg, jpeg, svg, and webp images are allowed.");
                    }
                },
                ]
                ];
                
                $validator = Validator::make($request->all(), $rules);
                
                if ($validator->fails()) 
                {
                return response()->json([
                'error' => $validator->errors()
                ], 422); // Explicitly set the 422 status code
                }
    
            }
            
            $filters = [];
            
            
            DB::transaction(function () use ($request , &$ad , &$packg , &$city) 
            {
                $images_ids = [];
                
                if(!empty($request->slider_images))
                {
                    foreach ($request->file('slider_images') as $key => $img) 
                    {
                        $filename = uniqid() . '.' . $img->getClientOriginalExtension();
                        $img->move(public_path('assets/admin/img/car-gallery/'), $filename);
                        $pi = new CarImage();
                        $pi->rotation_point = $request->rotation_point[$key];
                        $pi->priority = $request->priority[$key];
                        $pi->user_id = request()->user()->id;
                        $pi->image = $filename;
                        $pi->save();
                        $images_ids[] = $pi->id;
                    }
                }
    
                $in = $request->all();
                
               
                
                if(!empty($images_ids)) 
                {
                    $fImage = CarImage::select('id', 'image')
                    ->whereIn('id', $images_ids)
                    ->orderBy('priority', 'asc')
                    ->first();
                    
                    $in['feature_image'] = $fImage->image;
                }
        
                $in['vendor_id'] = request()->user()->id;
                
                if(isset($in['message_center']) && $in['message_center'] == 'yes')
                {
                   $in['message_center'] = 1; 
                }
                
                if(isset($in['phone_text']) && $in['phone_text'] == 'yes')
                {
                   $in['phone_text'] = 1; 
                }
                
                foreach ($in as $key => $value) 
                {
                    if (strpos($key, 'filters') !== false) 
                    {
                        $key =  str_replace('filters_' , '' , $key);
                        
                        $filters[$key] = $value;
                    } 
                }
                
                if(!empty($filters))
                {
                    $in['filters'] = json_encode($filters);
                }
                
                $ad_id = $in['ad_id'];
                
                unset($in['ad_id']);
                
                $ad->update($in);
                
                if ($images_ids) 
                {
                    foreach($images_ids as $images_id)
                    {
                        $pis = CarImage::find($images_id);
                        $pis->car_id = $car->id;
                        $pis->save();
                    }
                }
                
                
                $carContent =  CarContent::find($ad->car_content->id);
             
                $carContent->title = $request['title'];
                $carContent->slug = createSlug($request['title']);
                $carContent->car_colour_id = $request['car_colour_id'];
                $carContent->car_color_id = $request['car_colour_id'];
                $carContent->car_condition_id = $request['car_condition_id'];
                $carContent->body_type_id = $request['body_type_id'];
                $carContent->transmission_type_id = $request['transmission_type_id'];
                $carContent->description = Purifier::clean($request['description'], 'youtube');
                $carContent->save();
                
            });
            
            return Response::json(['status' => 'success', 'action' => 'update'], 200);
        }

        
        public function edit($id)
        {
            if(empty($id) || !is_numeric($id))
            {
              return response()->json([
                    'error' => 'Ad Id must be required with integer value.'
                ], 422);  
            }
            
            $ad = Car::find($id);
             
             if($ad == false)
             {
                   return response()->json([
                    'error' => 'Ad deleted or not found.'
                ], 404);  
             }
             
            $effectivePrice = $ad->price;
            
            if ($ad->previous_price && $ad->previous_price < $ad->price) 
            {
                $effectivePrice = $ad->previous_price;
            }
            
            $galleries = $ad->galleries->map(function ($gallery) use ($ad) 
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
            });
                
            $information['galleries'] = $galleries;    
            $information['title'] = $ad->car_content->title;
            $information['description'] = $ad->car_content->description;
            $information['price'] = $effectivePrice;
            $information['youtube_link'] = $ad->youtube_video;
            $information['message_center'] = $ad->message_center == 1 ? 'on' : off;
            $information['phone_text'] = $ad->phone_text == 1 ? 'on' : 'off';
            
            $information['category'] = Category::select('id' , 'name' , 'slug' , 'parent_id' , 'filters')->where('id' , $ad->car_content->category_id )->first();
            
            $cate_id = $information['category'] ? [$information['category']->id] : [];
            
            if($information['category'] && $information['category']->parent_id == 0)
            {
                $cate_id =  $information['category']->children()->pluck('id');
            }
            
            $formData = null;
            
             if(!empty($ad->fil_sub_categories) || !empty($ad->car_content->category_id) )
            {
               
                if(!empty($ad->fil_sub_categories) && !empty($ad->filters))
                {
                    $json_decode = json_decode($ad->fil_sub_categories , true);
                    
                    foreach($json_decode as $list)
                    {
                        $form_records = FormFields::where('category_field_id' , $list)->get();
                        
                        if($form_records->count() > 0 )
                        {
                             $formData = $form_records;
                        }
                    }
                }
                else
                {
                    $form_records = FormFields::where('category_field_id' , $ad->car_content->category_id )->get();
                    
                    if($form_records->count() > 0 )
                    {
                         $formData = $form_records;
                    }
                }
            }
            
            $filtersArray = [];
            
            if(!empty($formData))
            {
             
               $filterData = $this->getFilter($formData);
               
               $filters =  json_decode($ad->filters , true);  
             
               foreach($filterData as $key => $filter)
               {
                   $key = str_replace('::'.$filter->type , '' ,  $key);
                   
                   $optionsArray = [];
                    $value = '';
                    
                   if($filter->type == 'select' && !empty($filter->form_options) )
                   {
                       
                        $key_to_find = strtolower($filter->type.'_'.str_replace(' ' , '_' , $filter->label));

                            if (array_key_exists($key_to_find, $filters)) 
                            {
                                $value = $filters[$key_to_find];
                            }
                    
                       foreach ($filter->form_options as $form_option)
                       {
                           $optionsArray[] = array( 'option' => $form_option->value);
                       }
                       
                       $filtersArray['filters_select_'.strtolower(str_replace(' ' , '_' , $key ))] = array('label' => $key ,'type' => 'select' , 'element_value' => $value  , 'value' => $optionsArray);
                   }
                   elseif($filter->type == 'radio' && !empty($filter->form_options) )
                   {
                         $key_to_find = strtolower($filter->type.'_'.str_replace(' ' , '_' , $filter->label));

                            if (array_key_exists($key_to_find, $filters)) 
                            {
                                $value = $filters[$key_to_find];
                            }
                            
                       foreach ($filter->form_options as $form_option)
                       {
                           $optionsArray[] = array('option' => $form_option->value);
                       }
                       
                       $filtersArray['filters_radio_'.strtolower(str_replace(' ' , '_' , $key ))] = array('label' => $key ,'type' => 'radio' ,  'element_value' => $value   , 'value' => $optionsArray);
                   }
                   elseif($filter->type == 'input')
                   {
                       $key_to_find = strtolower($filter->type.'_'.str_replace(' ' , '_' , $filter->label));

                        if (array_key_exists($key_to_find, $filters)) 
                        {
                            $value = $filters[$key_to_find];
                        }
                        
                       $filtersArray['filters_input_'.strtolower(str_replace(' ' , '_' , $key ))] = array('label' => $key ,'type' => 'input'  ,  'element_value' => $value );
                   }
                   elseif($filter->type == 'textarea')
                   {
                       $key_to_find = strtolower($filter->type.'_'.str_replace(' ' , '_' , $filter->label));

                        if (array_key_exists($key_to_find, $filters)) 
                        {
                            $value = $filters[$key_to_find];
                        }
                        
                       $filtersArray['filters_textarea_'.strtolower(str_replace(' ' , '_' , $key ))] = array('label' => $key ,'type' => 'textarea' ,  'element_value' => $value  );
                   }
                   elseif($filter->type == 'checkbox' && !empty($filter->form_options))
                   {
                        $key_to_find = strtolower($filter->type.'_'.str_replace(' ' , '_' , $filter->label));

                        if (array_key_exists($key_to_find, $filters)) 
                        {
                            $value = $filters[$key_to_find];
                        }
                            
                        foreach ($filter->form_options as $form_option)
                       {
                           $optionsArray[] = array( 'option' => $form_option->value);
                       }
                       
                       $filtersArray['filters_checkbox_'.strtolower(str_replace(' ' , '_' , $key ))] = array('label' => $key ,'type' => 'checkbox'  ,  'element_value' => $value  , 'value' => $optionsArray);
                   }
                }
            }
            
            
        if(!empty($filtersArray) && $information['category']->brands()->count() == 0 &&  $information['category']->id != 24)
        {
              unset($information['category']);
              
              $mergedArray =  array_merge_recursive($information , $filtersArray);
        }
        else
        {
            
             if (in_array('make', json_decode($information['category']->filters))) 
            {
                $information['make'] =  $ad->car_content->brand->name;
                
                $information['model'] = $ad->car_content->model->name;
            }
            
            if (in_array('year', json_decode($information['category']->filters))) 
            {
                $information['year'] =  $ad->year;
            }
            
             if (in_array('fuel_types', json_decode($information['category']->filters))) 
            {
                $information['fuel_type'] = $ad->car_content->fuel_type->name;
            }
             
            if (in_array('engine', json_decode($information['category']->filters))) 
            {
                if(in_array($ad->car_content->fuel_type->slug , ['petrol' , 'diesel']))
                {
                    $engine_sizes = EngineSize::where('status', 1)->get(['id' , 'name' ]);
                    $type = 'select';
                }
                else
                {
                    $engine_sizes = '';
                     $type = 'input';
                }
                
                 $information['engine_sizes'] = array('label' => 'Engine size' , 'type' => $type , 'element_value' => $ad->engineCapacity , 'value' => $engine_sizes ); 
            }
            
            if (in_array('transmision_type', json_decode($information['category']->filters))) 
            {
                $information['transmission_types'] = array('label' => 'Transmission Type' , 'type' => 'select' , 'element_value' => $ad->car_content->transmission_type_id  , 'value' => TransmissionType::where('status', 1)->orderBy('serial_number', 'asc')->get(['id' , 'name' , 'slug'])  );
            }
            
             if (in_array('body_type', json_decode($information['category']->filters))) 
            {
                $cate_id = json_decode(json_encode($cate_id) , true);
                
                if(in_array(24 , $cate_id))
                {
                    $information['body_type'] =  array('label' => 'Body Type' , 'type' => 'select'  , 'element_value' => $ad->car_content->body_type_id   , 'value' => BodyType::where('status', 1)->orderBy('serial_number', 'asc')->get(['id' , 'name' , 'slug'])  ) ;
                }
                else
                {
                    $information['body_type'] = array('label' => 'Body Type' , 'type' => 'select' , 'element_value' => $ad->car_content->body_type_id  , 'value' => BodyType::where('status', 1)->whereIn('cat_id' , $cate_id)->orderBy('serial_number', 'asc')->get(['id' , 'name' , 'slug'] )  );
                }
            }
            
            if (in_array('colour', json_decode($information['category']->filters))) 
            {
                $information['car_colors'] = array('label' => 'Colours' , 'type' => 'select' , 'element_value' => $ad->car_content->car_colour_id  , 'value' => CarColor::where('status', 1)->orderBy('serial_number', 'asc')->get(['id' , 'name' , 'slug']) );
            }
            
             if (in_array('doors', json_decode($information['category']->filters))) 
            {
                $information['doors'] = array('label' => 'No of doors' , 'type' => 'select' , 'element_value' => $ad->doors  , 'value' => [2,3,4,5,6]);
            }
            
         
            
           if (in_array('seat_count', json_decode($information['category']->filters))) 
            {
                $information['seat_count'] = array('label' => 'Seat count' , 'type' => 'select' , 'element_value' => $ad->seats  , 'value' => [2,3,4,5,6,7,8]);
            }
            
            if (in_array('power', json_decode($information['category']->filters))) 
            {
                $information['engine_power'] = array('label' => 'Power' , 'type' => 'select' , 'element_value' => $ad->power , 'value' => CarPower::where('status', 1)->orderBy('id', 'asc')->get() );
            }
            
            if (in_array('owners', json_decode($information['category']->filters))) 
            {
                $information['owners'] = array('label' => 'No of owners' , 'type' => 'select' , 'element_value' => $ad->owners  , 'value' => [2,3,4,5,6]);
            }
            
           if (in_array('road-tax', json_decode($information['category']->filters))) 
            {
                $information['road_tax'] = array('label' => 'Annual road tax' , 'type' => 'text' , 'element_value' => $ad->road_tax );
            }
            
            unset($information['category']);
            
            $mergedArray =  array_merge_recursive($information , $filtersArray);
        }
            
           return response()->json($mergedArray , 200 );
        }
        
         public function changeAdStatus(Request $request)
        {
            $rules = [
                'id' => 'required',
                'status' => 'required',
            ];
            
            $messages = 
            [
                'id.required' => 'The ad id is required.',
                'status.required' => 'Status is required to proceed further.',
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()) 
            {
                return response()->json([
                    'error' => $validator->errors()
                ], 422);
            }
        
            $car = Car::findOrFail($request->id);
            
            if($request->status == "withdraw")
            {
                $inuser['status'] = 3;
            }
            elseif($request->status == "relist")
            {
                $inuser['status'] = 1;
            }
            
            $car->update($inuser);
            
            return response()->json(['success' => 'Status updated successfully!' ] , 200);
        }
        
        
         function normalizeFilter($value) {
    // Check if value is an array
    if (is_array($value)) {
        // Apply strtolower to each element in the array
        return array_map('strtolower', $value);
    } 
    // Check if value is a string
    elseif (is_string($value)) {
        // Apply strtolower to a single string
        return strtolower($value);
    }
    
    // Return the original value if it's neither a string nor an array
    return $value;
}
        
        public function deleteAd(Request $request)
        {
            $rules = [
                'ad_id' => 'required',
                'remove_option' => 'required',
                'recommendation' => 'required',
                'request_for' => 'required',
            ];
            
            $messages = [
                'ad_id.required' => 'The ad id is required.',
                'remove_option.required' => 'Please choose one reason atleast.',
                'recommendation.required' => 'Please tell us how much you recommend us?',
                'request_for.required' => 'Tell us which operation you need to call? sold or remove?'
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()) 
            {
                return response()->json([
                    'error' => $validator->errors()
                ], 422);
            }
            
            $ad_id = $request->ad_id;
            $request_for = $request->request_for;
            $remove_remarks = $request->remarks;
            $recommendation = $request->recommendation;
            $remove_option = $request->remove_option;
            
            $car = Car::findOrFail($ad_id);
            $car->remove_option = $remove_option;
            $car->recommendation = $recommendation;
            $car->remove_remarks = $remove_remarks;
            
            if($request_for == 'removed')
            {
                $car->deleted_at = date('Y-m-d');
                
                // first, delete all the contents of this package
                $contents = $car->car_content()->get();
                foreach ($contents as $content) 
                {
                    $content->delete();
                }
                
                // third, delete feature_image image of this package
                if (!is_null($car->feature_image)) 
                {
                    @unlink(public_path('assets/admin/img/car/') . $car->feature_image);
                }
                
                // first, delete all the contents of this package
                $galleries = $car->galleries()->get();
                
                foreach ($galleries as $gallery) 
                {
                    @unlink(public_path('assets/admin/img/car-gallery/') . $gallery->image);
                    $gallery->delete();
                }
            }
            
             if($request_for == 'sold')
            {
              $car->is_sold = 1;  
            }
            
            $car->save();
            
            $flash_message = ($request_for == 'sold') ? 'Ad Sold successfully!' : 'Ad deleted successfully!' ;
        
            return response()->json(['success' => $flash_message ] , 200);
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
    
    
        public function myAds(Request $request)
        {
        
            $userId = request()->user()->id;
           
            $rules = [
                'status' => 'required',
            ];
            
            $messages = [
                'status.required' => 'The status field is required.'
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()) 
            {
                return response()->json([
                    'error' => $validator->errors()
                ], 422);
            }
            
            if($request->status=="all")
           {
                $cars  = Car::where('vendor_id', '=', $userId)->orderBy('cars.id', 'desc')->get();
           
           } 
           else 
           {
             
                $cars = Car::where('vendor_id', '=', $userId);
                
                $status = $request->status;
                
                if ($status == 1) 
                {
                    $cars = $cars->where('cars.status', 1)->where('cars.is_sold', 0);
                } 
                else 
                {
                    $cars = $cars->where(function ($query) 
                    {
                        $query->where('cars.status', '!=', 1)
                              ->orWhere('cars.is_sold', 1);
                    })->with('car_content');
                }
                
                $cars = $cars->orderBy('cars.id', 'desc')->get();
                
           }
           
           if($cars->count() == 0)
           {
                return response()->json(['data' => [] ] , 200);
           }
           
            $cars = $cars->map(function ($car) 
            {
               
                $effectivePrice = $car->price;
                
                if ($car->previous_price && $car->previous_price < $car->price) 
                {
                    $effectivePrice = $car->previous_price;
                }
                
                $featureImageUrl = $car->vendor
                ? ($car->vendor->vendor_type === 'normal'
                ? asset('assets/admin/img/car-gallery/' . $car->feature_image)
                : env('SUBDOMAIN_APP_URL') . 'assets/admin/img/car-gallery/' . $car->feature_image)
                : asset('assets/admin/img/default-photo.jpg');  
                
                $status = null;
                
                 if($car->is_sold == 1 || $car->status == 2 )
                 {
                    $status = 'Sold'; 
                 }
                 else
                 {
                    if($car->status==3)
                    {
                        $status = 'Withdrawn'; 
                    }
                    
                    if($car->status==0)
                    {
                        $status = 'Needs Payment (Not Listed)'; 
                    }
                    elseif($car->status==1 || $car->status==4 )
                    {
                       $status =  noDaysLeftByAd($car->package_id,$car->created_at);
                    }
                 }
                
                return [
                    'id' => $car->id,
                    'feature_image' => $featureImageUrl,
                    'slug' => $car->car_content ? $car->car_content->slug : null,
                    'title' => $car->car_content ? $car->car_content->title : null,
                    'category_id' => $car->car_content->main_category_id,
                    'sub_category_id' => $car->car_content->category_id,
                    'price' => symbolPrice($effectivePrice),
                    'created_at' => calculate_datetime($car->created_at),
                    'status' => $status,
                    'no_of_saves' => ($car->wishlists()->get()->count() > 0 ) ? $car->wishlists()->get()->count() : 0,
                    'no_of_views' => ($car->visitors()->get()->count() > 0 ) ? $car->visitors()->get()->count() : 0,
                ];
            
            });
            
            return response()->json(['data' => $cars] , 200);
    
        }
        
        public function storeAd(Request $request)
        {
            
            $rules = [
                'slider_images' => 'required',
                'title' => 'required|max:255',
                'price' => 'required',
                'package_id' => 'required', 
                'category_id' => 'required',
                'description' => 'required|min:15',
            ];
        
            $messages =  [
                'slider_images.required' => 'Slider Images is required.',
                'title.required' => 'Title is required.',
                'price.required' => 'Price is required.',
                'package_id.required' => 'Package Id is required.',
                'category_id.required' => 'Category Id is required.',
                'description.required' => 'Description is required minimum 15 char.',
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()) 
            {
                return response()->json([
                'error' => $validator->errors()
                ], 422);
            } 
            
            $city = request()->user()->vendor_info->city;
            
            if(empty($city))
            {
                return response()->json([
                'error' => 'Please first update your city and phone number from your edit profile section.'
                ], 422);
            }
            
            
            $packg = PrivatePackage::where('id', $request->package_id)->first();
            
            $max_file_upload = $packg->photo_allowed;
            
            $slider_images_count = count($request->slider_images);
            
            if ($slider_images_count > $max_file_upload) 
            {
                $errors = [
                    'slider_images' => [
                        "You can upload a maximum of {$max_file_upload} images on selected package. Please remove some images or select different package."
                    ]
                ];
            
                return response()->json(['errors' => $errors], 422);
            }
            
            
               $allowedExts = ['jpg', 'png', 'jpeg', 'svg', 'webp'];
                
                $rules = [
                'slider_images.*' => [
                function ($attribute, $value, $fail) use ($allowedExts) {
                    $ext = $value->getClientOriginalExtension();
                    if (!in_array($ext, $allowedExts)) {
                        return $fail("Only png, jpg, jpeg, svg, and webp images are allowed.");
                    }
                },
                ]
                ];
                
                $validator = Validator::make($request->all(), $rules);
                
                if ($validator->fails()) 
                {
                return response()->json([
                'error' => $validator->errors()
                ], 422); // Explicitly set the 422 status code
                }
    
            $lastcarID = '';
            $filters = [];
            
            
            DB::transaction(function () use ($request , &$lastcarID, &$packg , &$city) 
            {
                $images_ids = [];
                foreach ($request->file('slider_images') as $key => $img) 
                {
                    $filename = uniqid() . '.' . $img->getClientOriginalExtension();
                    $img->move(public_path('assets/admin/img/car-gallery/'), $filename);
                    $pi = new CarImage();
                    $pi->rotation_point = $request->rotation_point[$key];
                    $pi->priority = $request->priority[$key];
                    $pi->user_id = request()->user()->id;
                    $pi->image = $filename;
                    $pi->save();
                    $images_ids[] = $pi->id;
                }
    
                $in = $request->all();
    
                if(!empty($images_ids)) 
                {
                    $fImage = CarImage::select('id', 'image')
                    ->whereIn('id', $images_ids)
                    ->orderBy('priority', 'asc')
                    ->first();
                }
        
                $in['feature_image'] = $fImage->image;
                
                $in['vendor_id'] = request()->user()->id;
                
                if(isset($in['message_center']) && $in['message_center'] == 'yes')
                {
                   $in['message_center'] = 1; 
                }
                
                if(isset($in['phone_text']) && $in['phone_text'] == 'yes')
                {
                   $in['phone_text'] = 1; 
                }
                
                foreach ($in as $key => $value) 
                {
                    if (strpos($key, 'filters') !== false) 
                    {
                        $key =  str_replace('filters_' , '' , $key);
                        
                        $filters[$key] = $value;
                    } 
                }
                
                if(!empty($filters))
                {
                    $in['filters'] = json_encode($filters);
                }
                
                if(!empty($in['fil_sub_categories']))
                {
                    $in['fil_sub_categories'] = json_encode($in['fil_sub_categories']);
                }
                
                if($packg->price == 0)
                {
                    $in['status'] = 1; 
                } 
                else
                {
                    $in['status'] =0;  
                }
                
                $in['order_id'] = $this->getNextOrderNumber();
                
                $in['city'] = $city;
                
                $car = Car::create($in);
                
                $lastcarID = $car->id;
                
                if ($images_ids) 
                {
                    foreach($images_ids as $images_id)
                    {
                        $pis = CarImage::find($images_id);
                        $pis->car_id = $car->id;
                        $pis->save();
                    }
                }
                
                $catinfo  = Category::where('id', $request['category_id'])->first();
                
                $carContent = new CarContent();
                $carContent->language_id = 20;
                $carContent->car_id = $car->id;
                $carContent->title = $request['title'];
                $carContent->slug = createSlug($request['title']);
                $carContent->car_colour_id = $request['car_colour_id'];
                $carContent->car_color_id = $request['car_colour_id'];
                $carContent->category_id = $request['category_id'];
                $carContent->main_category_id = $request['main_category_id'];
                $carContent->car_condition_id = $request['car_condition_id'];
                $carContent->brand_id = $request['brand_id'];
                $carContent->body_type_id = $request['body_type_id'];
                $carContent->car_model_id = $request['car_model_id'];
                $carContent->fuel_type_id = $request['fuel_type_id'];
                $carContent->transmission_type_id = $request['transmission_type_id'];
                $carContent->category_slug = createSlug($catinfo->name);
                $carContent->description = Purifier::clean($request['description'], 'youtube');
                $carContent->save();
                
            });
            
            return Response::json(['status' => 'success', 'action' => 'add','ad_id'=>$lastcarID], 200);
        }
        
        function paymentOption(Request $request)
        {
            $rules = [
                'category_id' => 'required',          // Ensure each element in the array is an integer
            ];
        
            $messages = 
            [
                'category_id.required' => 'Category id is required.',
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()) 
            {
                return response()->json([
                'error' => $validator->errors()
                ], 422);
            } 
            
            $parent_id  = $this->loadingMoreParentCategory( $request->category_id);
       
            $data = PrivatePackage::select('id' , 'title' , 'price' , 'days_listing' , 'photo_allowed' ,'ad_views' ,'number_of_bumps' ,'priority_placement')->where('category_id', $parent_id);
            
            if(!empty($request->type) && $request->type == 'boost')
            {
                $data = $data->where('price' , '>' , 0);
            }
            
            $data = $data->where('status', 1)->get();
            
            return response()->json( $data , 200 );
        }
        
        function loadingMoreParentCategory($category_id)
        {
            $category = Category::where('id', $category_id)->first();
            
            if ($category && $category->parent_id != 0) 
            {
                return $this->loadingMoreParentCategory($category->parent_id);
            }
            
            if ($category && $category->parent_id == 0) 
            {
                return $category->id;
            }
            
            return null;
        }

        public function checkFuelType(Request $request)
        {
            $rules = [
                'fuel_type' => 'required',          // Ensure each element in the array is an integer
            ];
        
            $messages = 
            [
                'fuel_type.required' => 'Fuel Type is required.',
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()) 
            {
                return response()->json([
                'error' => $validator->errors()
                ], 422);
            }
            
            if(in_array($request->fuel_type , ['petrol' , 'diesel']))
            {
                $fuel_types = array('label' => 'Engine size (litres)' , 'type' => 'select' , 'value' => EngineSize::where('status', 1)->get(['id' , 'name']) );
            }
            else
            {
                $fuel_types =  array('label' => 'Engine size (KW)' ,'type' => 'input' );
            }
            
            return response()->json($fuel_types , 200 );
        }
        
        public function loadFilterDataForAd(Request $request)
        {
          
        $information['category'] = Category::select('id' , 'name' , 'slug' , 'parent_id' , 'filters')->where('id' , $request->category_id)->first();
        
        $cate_id = $information['category'] ? [$information['category']->id] : [];
        
        if($information['category'] && $information['category']->parent_id == 0)
        {
            $cate_id =  $information['category']->children()->pluck('id');
        }
        
        $filters = $this->getCategoriesFilter($request->category_id);
        
        $filtersArray = [];
        
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
                   elseif($filter->type == 'input')
                   {
                       $filtersArray['filters_input_'.strtolower(str_replace(' ' , '_' , $key ))] = array('label' => $key ,'type' => 'input' );
                   }
                   elseif($filter->type == 'textarea')
                   {
                       $filtersArray['filters_textarea_'.strtolower(str_replace(' ' , '_' , $key ))] = array('label' => $key ,'type' => 'textarea' );
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
              unset($information['category']);
              $mergedArray =  array_merge_recursive($information , $filtersArray);
        }
        else
        {
            
              if (in_array('adType', json_decode($information['category']->filters))) 
            {
                $information['ad_type'] = array('label' => 'Ad Type' , 'type' => 'radio' , 'value' => ['sale' , 'wanted']);
            }
            
            
               if (in_array('registration', json_decode($information['category']->filters))) 
            {
                $information['vregNo'] = array('label' => 'vehicle registration' , 'type' => 'input' );
            }
            
            
            if (in_array('mileage', json_decode($information['category']->filters))) 
            {
                $information['mileage'] = array('label' => 'Add your mileage (M)' , 'type' => 'input' );
            }
            
            
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
                
                $information['popular_makes'] = array('label' => 'Popular Makes' , 'type' => 'select' , 'value' => $popularBrands );
                
                $information['other_makes'] = array('label' => 'Other Makes' , 'type' => 'select' , 'value' => $otherBrands );
                
                $information['car_model_id'] = array('label' => 'Model' , 'type' => 'select' , 'value' => 'Any' );
            }
            
            if (in_array('year', json_decode($information['category']->filters))) 
            {
                $information['year'] = array('label' => 'Year' , 'type' => 'input' );
            }
            
             if (in_array('fuel_types', json_decode($information['category']->filters))) 
            {
                $information['fuel_type_id'] = array('label' => 'Fuel Type' , 'type' => 'select' , 'value' => FuelType::where('status', 1)->orderBy('serial_number', 'asc')->get(['id' , 'name' , 'slug']) );
            }
            
            if (in_array('engine', json_decode($information['category']->filters))) 
            {
                $information['engineCapacity'] = array('label' => 'Engine size' , 'type' => 'input' );
            }
            
            if (in_array('transmision_type', json_decode($information['category']->filters))) 
            {
                $information['transmission_type_id'] = array('label' => 'Transmission Type' , 'type' => 'select' , 'value' => TransmissionType::where('status', 1)->orderBy('serial_number', 'asc')->get(['id' , 'name' , 'slug'])  );
            }
            
             if (in_array('body_type', json_decode($information['category']->filters))) 
            {
                $cate_id = json_decode(json_encode($cate_id) , true);
                
                if(in_array(24 , $cate_id))
                {
                    $information['body_type_id'] =  array('label' => 'Body Type' , 'type' => 'select' , 'value' => BodyType::where('status', 1)->orderBy('serial_number', 'asc')->get(['id' , 'name' , 'slug'])  ) ;
                }
                else
                {
                    $information['body_type_id'] = array('label' => 'Body Type' , 'type' => 'select' , 'value' => BodyType::where('status', 1)->whereIn('cat_id' , $cate_id)->orderBy('serial_number', 'asc')->get(['id' , 'name' , 'slug'] )  );
                }
            }
            
            if (in_array('colour', json_decode($information['category']->filters))) 
            {
                $information['car_colour_id'] = array('label' => 'Colours' , 'type' => 'select' , 'value' => CarColor::where('status', 1)->orderBy('serial_number', 'asc')->get(['id' , 'name' , 'slug']) );
            }
            
             if (in_array('doors', json_decode($information['category']->filters))) 
            {
                $information['doors'] = array('label' => 'No of doors' , 'type' => 'select' , 'value' => [2,3,4,5,6]);
            }
            
             if (in_array('battery', json_decode($information['category']->filters))) 
            {
                $information['battery'] = array('label' => 'Battery' , 'type' => 'select' , 'value' => ['100+ M','200+ M','300+ M','400+ M','500+ M']);
            }
            
           if (in_array('seat_count', json_decode($information['category']->filters))) 
            {
                $information['seats'] = array('label' => 'Seat count' , 'type' => 'select' , 'value' => [2,3,4,5,6,7,8]);
            }
            
            if (in_array('power', json_decode($information['category']->filters))) 
            {
                $information['power'] = array('label' => 'Power' , 'type' => 'select' , 'value' => CarPower::where('status', 1)->orderBy('id', 'asc')->get() );
            }
            
            if (in_array('owners', json_decode($information['category']->filters))) 
            {
                $information['owners'] = array('label' => 'No of owners' , 'type' => 'select' , 'value' => [2,3,4,5,6]);
            }
            
           if (in_array('road-tax', json_decode($information['category']->filters))) 
            {
                $information['road_tax'] = array('label' => 'Annual road tax' , 'type' => 'text' );
            }
            
            unset($information['category']);
            
            $mergedArray =  array_merge_recursive($information , $filtersArray);
        }
        
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
    
    
    
    public function compareSavedAds(Request $request)
    {
        $rules = [
            'compare_id' => 'required|array|min:1|max:5',  // Ensure compare_id is an array with at least one and at most two elements
            'compare_id.*' => 'required|integer',          // Ensure each element in the array is an integer
        ];
        
        $messages = [
        'compare_id.required' => 'At least one compare ID is required.',
        'compare_id.array' => 'The compare ID must be an array.',
        'compare_id.min' => 'The compare ID array must contain at least one item.',
        'compare_id.max' => 'The compare ID array cannot contain more than two items.',  // Custom message for max size
        'compare_id.*.required' => 'Each compare ID is required.',
        'compare_id.*.integer' => 'Each compare ID must be an integer.',
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) 
        {
            return response()->json([
            'error' => $validator->errors()
            ], 422);
        }

        $cars = Car::whereIn('id' , $request->compare_id)->get();
        
        $ads = $cars->map(function ($ad) 
            {
                
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
                            
                            foreach($filter as $list)
                            {
                                if(!empty($list))
                                {
                                    $selectArray[] = $list; 
                                }
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
                    'Model Year' => $ad->year,
                    'Mileage' => $ad->mileage ? number_format($ad->mileage) : null,
                    'Top Speed' => $ad->speed ? $ad->speed . ' KMH' : null,
                    'Make' => $ad->car_content && $ad->car_content->brand ? $ad->car_content->brand->name : null,
                    'Model' => $ad->car_content && $ad->car_content->model ? $ad->car_content->model->name : null,
                    'Fuel Type' => $ad->car_content && $ad->car_content->fuel_type ? $ad->car_content->fuel_type->name : null,
                    'Transmission' => $ad->car_content && $ad->car_content->transmission_type ? $ad->car_content->transmission_type->name : null,
                    'Engine Capacity' => $ad->engineCapacity ? roundEngineDisplacement($ad) : null,
                    'Battery Range' => ($ad->car_content && in_array(optional($ad->car_content->fuel_type)->name, ['Electric', 'Hybrid'])) ? ($ad->bettery_range ? $ad->bettery_range : $ad->battery . ' + M') : null,
                    'Location' => $ad->current_area_regis ? ucfirst($ad->current_area_regis) : null,
                    'History Checked' => $ad->history_checked > 0 ? 'Yes' : 'No',
                    'Delivery Available' => $ad->delivery_available > 0 ? 'Yes' : 'No',
                    'Warranty Type' => $ad->warranty_type,
                    'Warranty Duration' => $ad->warranty_duration ? $ad->warranty_duration : $ad->warranty,
                    'Power' => $ad->power,
                    'Road Tax' => $ad->road_tax,
                    'Number Of Owners' => $ad->number_of_owners ? $ad->number_of_owners : $ad->owners,
                    'Doors' => $ad->doors,
                    'Seats' => $ad->seats
                ];
                
                if(!empty($ad->filters) && !empty($ad->year))
                {
                  $sepecification = array_merge($sepecification, $filters);  
                }
                
                if(!empty($ad->filters) && empty($ad->year))
                {
                    $sepecification = $filters;
                }
    
             return  [
                'id' => $ad->id,
                'feature_image' => $featureImageUrl,
                'price' => symbolPrice($ad->price),
                'youtube_video' => $ad->youtube_video,
                'year' => $ad->year,
                'created_at' => calculate_datetime($ad->created_at),
                'slug' => $ad->car_content ? $ad->car_content->slug : null,
                'title' => $ad->car_content ? $ad->car_content->title : null,
                'description' => $ad->car_content ? $ad->car_content->description : null,
                'is_added_on_wishlist' => checkWishList($ad->id, request()->user()->id),
                'vendor' => 
                [
                    'vendor_id' => $ad->vendor->id,
                    'vendor_name' => $ad->vendor && $ad->vendor->vendor_info ? $ad->vendor->vendor_info->name : null,
                    'vendor_photo' => !empty($ad->vendor->photo) ? asset('assets/admin/img/vendor-photo/' . $ad->vendor->photo) : asset('assets/img/blank-user.jpg'),
                    'vendor_type' => $ad->vendor ? ($ad->vendor->vendor_type === 'dealer' ? ($ad->vendor->is_franchise_dealer ? 'Franchise Dealer' : 'Independent Dealer') : 'Private Seller') : 'Private Seller',
                    'user_type' => $ad->vendor->vendor_type,
                    'location' => $ad->vendor && $ad->vendor->vendor_info ? ucfirst($ad->vendor->vendor_info->city) : null,
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
            ];
        
        });

        
           return response()->json(['data' => $ads ] , 200);
    }
    
    public function deleteMultipleSaveAd(Request $request)
    {
        $rules = [
            'wishlist_id' => 'required|array|min:1',
            'wishlist_id.*' => 'required|integer', 
        ];
        
        $messages = [
            'wishlist_id.required' => 'At least one wishlist ID is required.',
            'wishlist_id.array' => 'The wishlist ID must be an array.',
            'wishlist_id.min' => 'The wishlist ID array must contain at least one item.',
            'wishlist_id.*.required' => 'Each wishlist ID is required.',
            'wishlist_id.*.integer' => 'Each wishlist ID must be an integer.',
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) 
        {
            return response()->json([
            'error' => $validator->errors()
            ], 422);
        }
        
        $wishlist_ids = $request->wishlist_id;
        
        foreach($wishlist_ids as $wishlist_id)
        {
            $if_exist =  Wishlist::where('id' , $wishlist_id )->first();
        
            if($if_exist == true)
            {
                $if_exist->delete();
            }
        }
        
        return response()->json(['success' =>  'All records successfully removed from wishlist'] , 200);
    }
    
    public function deleteSaveAd($wishlist_id)
    {
        if (empty($wishlist_id)) 
        {
            return response()->json([
                'error' => 'wishlist id is required'
            ], 422);
        }
        
        $if_exist =  Wishlist::where('id' , $wishlist_id )->first();
        
        if($if_exist == false)
        {
               return response()->json(['error' => 'No record found or invalid request id'], 404);
        }
        
        $if_exist->delete();
        
        return response()->json([ 'success' => 'successfully removed from wishlist' ] , 200);
    }
    
    public function getFilterValue()
    {
        $userId = request()->user()->id;
        
        $wishlists = Car::with('car_content')
            ->join('wishlists', 'wishlists.car_id', '=', 'cars.id')
            ->where('wishlists.user_id', $userId)
            ->select(['cars.*', 'wishlists.id as wishlist_id', 'wishlists.car_id', 'wishlists.user_id'])
            ->get();
        
        $mainCategoryIds = collect($wishlists)->map(function($item) {
            return $item->car_content->main_category_id;
            })->unique();
            
        
        if(!empty($mainCategoryIds))
        {
            $categories = Category::whereIn('parent_id', $mainCategoryIds)->get(['id' , 'name']);
        }
        else
        {
           $categories = Category::where('parent_id', 24)->get(['id' , 'name']); 
        }
        
        $sorting_options[] = ['name' => 'Most Recent' , 'value' => 'recent' ];
        $sorting_options[] = ['name' => 'Price (Lowest)' , 'value' => 'lowest_price' ];
        $sorting_options[] = ['name' => 'Price (Highest)' , 'value' => 'highest_price'];
        
        
        $totalArray = array('categories' => $categories , 'sorting_options' => $sorting_options );
        
        return response()->json(['data' => $totalArray ] , 200);
    }

    public function index(Request $request)
    {
        $userId = request()->user()->id;
       
        $rules = [
            'status' => 'required',
        ];
        
        $messages = [
            'status.required' => 'The status field is required.'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) 
        {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }
        
        if($request->status=="all")
       {
            $cars  = Car::select('cars.*',  'wishlists.id as wishlist_id', 'wishlists.car_id', 'wishlists.user_id')
            ->join('wishlists', function ($join) {
            $join->on(['wishlists.car_id' => 'cars.id']);
            })->where('wishlists.user_id', '=', $userId);
            
            if (!empty($request->category_id) && $request->has('category_id')) 
            {
                $category_id = $request->category_id;
                $cars->whereHas('car_content', function ($query) use ($category_id) 
                {
                    $query->where('category_id', $category_id);
                });
            }
            
            if ($request->filter_type == 'recent') 
            {
                $cars->orderBy('cars.created_at', 'desc');
            } 
            elseif ($request->filter_type == 'lowest_price') 
            {
                $cars->orderByRaw('COALESCE(NULLIF(cars.previous_price, 0), cars.price) ASC');
            } 
            elseif ($request->filter_type == 'highest_price') 
            {
                $cars->orderByRaw('COALESCE(NULLIF(cars.previous_price, 0), cars.price) DESC');
            } 
            else 
            {
                $cars->orderBy('cars.id', 'desc');
            }
            
           $cars =  $cars->get();
       
       } 
       else 
       {
         
            $cars = Car::select('cars.*', 'wishlists.id as wishlist_id', 'wishlists.car_id', 'wishlists.user_id')
            ->join('wishlists', function ($join) 
            {
                $join->on('wishlists.car_id', '=', 'cars.id');
            })
            ->where('wishlists.user_id', '=', $userId);
             
            $status = $request->status;
            
            if ($status == 1) 
            {
                $cars = $cars->where('cars.status', 1)->where('cars.is_sold', 0);
            } 
            else 
            {
                $cars = $cars->where(function ($query) 
                {
                    $query->where('cars.status', '!=', 1)
                          ->orWhere('cars.is_sold', 1);
                })->with('car_content');
            }
            
            if (!empty($request->category_id) && $request->has('category_id')) 
            {
                $category_id = $request->category_id;
                $cars->whereHas('car_content', function ($query) use ($category_id) 
                {
                    $query->where('category_id', $category_id);
                });
            }
            
            if ($request->filter_type == 'recent') 
            {
                $cars->orderBy('cars.created_at', 'desc');
            } elseif ($request->filter_type == 'lowest_price') {
                $cars->orderByRaw('COALESCE(NULLIF(cars.previous_price, 0), cars.price) ASC');
            } elseif ($request->filter_type == 'highest_price') {
                $cars->orderByRaw('COALESCE(NULLIF(cars.previous_price, 0), cars.price) DESC');
            } else {
                $cars->orderBy('cars.id', 'desc');
            }
            
            $cars = $cars->get();
       }
       
       if($cars->count() == 0)
       {
            return response()->json(['data' => [] ] , 200);
       }
       
       
        $cars = $cars->map(function ($car) 
        {
           
            $effectivePrice = $car->price;
            
            if ($car->previous_price && $car->previous_price < $car->price) 
            {
                $effectivePrice = $car->previous_price;
            }
            
            $featureImageUrl = $car->vendor
            ? ($car->vendor->vendor_type === 'normal'
            ? asset('assets/admin/img/car-gallery/' . $car->feature_image)
            : env('SUBDOMAIN_APP_URL') . 'assets/admin/img/car-gallery/' . $car->feature_image)
            : asset('assets/admin/img/default-photo.jpg');  
            
            $status = null;
            
             if($car->is_sold == 1 || $car->status == 2 )
             {
                $status = 'Sold'; 
             }
             else
             {
                if($car->status==3)
                {
                    $status = 'Withdrawn'; 
                }
                
                if($car->status==0)
                {
                    $status = 'Needs Payment (Not Listed)'; 
                }
                elseif($car->status==1 || $car->status==4 )
                {
                   $status =  noDaysLeftByAd($car->package_id,$car->created_at);
                }
             }
            
            return [
                'id' => $car->id,
                'feature_image' => $featureImageUrl,
                'price' => symbolPrice($effectivePrice),
                'year' => $car->year,
                'created_at' => calculate_datetime($car->created_at),
                'slug' => $car->car_content ? $car->car_content->slug : null,
                'title' => $car->car_content ? $car->car_content->title : null,
                'status' => $status,
                'fuel_type' => $car->car_content && $car->car_content->fuel_type ? $car->car_content->fuel_type->name : null,
                'engine_capacity' => $car->engineCapacity ? roundEngineDisplacement($car) : null,
                'mileage' => number_format($car->mileage) . ' mi',
                'wishlist_id' => $car->wishlist_id,
            ];
        
        });
        
        return response()->json(['data' => $cars] , 200);
    }

   
}
