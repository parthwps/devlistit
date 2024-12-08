<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Helpers\VendorPermissionHelper;
use App\Http\Requests\Car\CarStoreRequest;
use App\Http\Controllers\FrontEnd\MiscellaneousController;
use App\Models\Car;
use App\Models\Car\CarContent;
use App\Models\Car\CarImage;
use App\Models\Car\CarModel;
use App\Models\Car\CarSpecification;
use App\Models\Car\CarSpecificationContent;
use App\Models\Language;
use App\Models\Car\Category;
use  App\Models\Car\CarPower;
use App\Models\Car\FormFields;
use App\Models\Vendor;
use App\Models\VendorInfo;
use App\Models\SupportTicket;
use App\Models\PrivatePackage;
use App\Models\Car\Brand;
use App\Models\CountryArea;
use App\Models\DraftAd;
use Auth;
use App\Models\Car\Wishlist;
use Config;
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

class CarController extends Controller
{
    //index
    public function index(Request $request)
    {
        $information['langs'] = Language::all();
        $misc = new MiscellaneousController();
        $language = Language::where('code', $request->language)->firstOrFail();
        $information['language'] = $language;
        $language_id = $language->id;
        $information['bgImg'] = $misc->getBreadcrumb();

        $information['cars'] = Car::where('vendor_id', Auth::guard('vendor')->user()->id)->with([
            'car_content' => function ($q) use ($language_id)
            {
                $q->where('language_id', $language_id);
            },
        ])
        ->orderBy('id', 'desc')
        ->get();

        return view('vendors.car.index', $information);
    }

    static function getAdStats($car_id)
    {

        $information['impressions'] = DB::table('ad_impressions')->where('ad_id' , $car_id)->sum('impressions');
        $information['visitors'] = DB::table('visitors')->where('car_id' , $car_id)->count();
        $information['saves'] = Wishlist::where('user_id', Auth::guard('vendor')->user()->id)->where('car_id' , $car_id)->count();
        $information['leads'] = SupportTicket::where('admin_id', Auth::guard('vendor')->user()->id)->where('ad_id' , $car_id)->where('user_type', 'vendor')->count();
        $information['phone_no_revel'] = DB::table('cars')->where('id' , $car_id)->sum('phone_no_revel');

        return  $information;
    }

    function getCategoriesBread(Request $request)
    {
        $pid = $request->pid;
        $category = $request->category;
        $output = '';
        if($pid == 0)
        {
            $output = '<li class="d-inline" style="color:gray !important">></li>
            <li class="d-inline active opacity-75"><a  style="color:gray !important" href="javascript:void(0);" data-category="'.$category.'" data-pid="0" onclick="updatecate(this)" class="mt-2 us_customize_bread_crum">
            '.str_replace('-' , ' ' , $category ).'
            </a></li> ';
        }
        else
        {
                $category_ids = [];
                $category = Category::where([['slug', $category]])->first();

                if ($category)
                {
                    $category_ids[] = $category->id;

                    if($category->parent_id > 0 )
                    {
                      $this->loadingMoreCategory($category_ids, $category->parent_id);
                    }
                }

                if(!empty($category_ids))
                {
                    $categories =  Category::whereIn('id' , $category_ids)->get([ 'name' , 'slug' , 'parent_id']);
                    foreach($categories as $category)
                    {
                        $output .= '<li class="d-inline" style="color:gray !important">></li>
                        <li class="d-inline active opacity-75" style="color:gray !important"><a  style="color:gray !important" href="javascript:void(0);" data-category="'.$category->slug.'" data-pid="'.$category->parent_id.'" onclick="updatecate(this)" class="mt-2 us_customize_bread_crum">
                        '.$category->name.'
                        </a></li> ';
                    }
                }
        }

        return $output;
    }



    function loadingMoreCategory(&$category_ids, $category_id)
    {
        $category = Category::where([['id', $category_id]])->first();

        if($category == true)
        {
            $category_ids[] = $category->id;
            if($category->parent_id > 0 )
            {
                $this->loadingMoreCategory($category_ids, $category->parent_id);
            }
        }

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

    function getCompareCarDatas(Request $request)
    {
        $car_id = $request->car_id;
        $car_ids = $request->car_ids;
        $type = $request->type;
        $carID =  $this->getCurrentCarId($type , $car_ids , $car_id);
        $car_content = Car::find($carID[0]);
        if($car_content == false)
        {
            $car_content = Car::find($car_id);
        }

        $arraySize = $carID[1] - 1;
        $currentIndex = $carID[2] + 1;

        if($currentIndex > $arraySize)
        {
            $currentIndex = $arraySize;
        }

        echo  view('vendors.car.ajax-comparison', compact('car_content' , 'type' , 'arraySize' , 'currentIndex') )->render();
    }

    function getCurrentCarId($type , $car_ids , $car_id )
    {
        $idArray = explode(',', $car_ids);

        $currentId = $car_id;

        $arraySize = count($idArray);

        $currentIndex = array_search($currentId, $idArray);

        if ($currentIndex !== false)
        {
            if($type == 'f_previous' || $type == 's_previous')
            {
                $newId = ($currentIndex > 0) ? $idArray[$currentIndex - 1] : $currentId;
            }
            else
            {
                 $newId = ($currentIndex < count($idArray) - 1) ? $idArray[$currentIndex + 1] : $currentId;
            }

            $currentIndex = array_search($newId, $idArray);

            return [$newId , $arraySize , $currentIndex];
        }
        else
        {
            return $car_id;
        }
    }

    function getCompareCarData(Request $request)
    {
         if($request->request_type == 'removeall')
        {
            for($i=0; $i<count($request->comparison); $i++)
            {
                if(!empty($request->comparison[$i]))
                {
                   Wishlist::where('user_id', Auth::guard('vendor')->user()->id)->where('car_id' , $request->comparison[$i])->delete();
                }
            }

            Session::flash('success', 'All save ads deleted successfully');
            return back();

        }

        $cars = Car::whereIn('id' , $request->comparison)->get();
        return view('vendors.car.comparison', compact('cars') );
    }

    function imagerotates(Request $request)
    {
       DB::table('car_images')->where('id' , $request->fileid)->update(['rotation_point' => $request->rotationEvnt]);
       echo $request->fileid;
    }

    function mark_as_sold($id , $status)
    {
        $c_status = ($status == 'sold') ? '1' : 0;
        DB::table('cars')->where('id' , $id)->update(['is_sold' => $c_status]);
        Session::flash('success', 'Your ad mark as '.$status);
        return back();
    }

    public function indexAjax(Request $request)
    {
       if($request->status=="all")
       {
        $cars  = Car::where('vendor_id', Auth::guard('vendor')->user()->id)->with('car_content')
            ->orderBy('id', 'desc')
            ->get();
       }
       else
       {
            $carsQuery = Car::where('vendor_id', Auth::guard('vendor')->user()->id);

            if ($request->status == 1) {
            $carsQuery->where('is_sold', 0)
            ->where('status', $request->status)
            ->with('car_content');
            } else {
            $carsQuery->where(function ($query) {
            $query->where('status', '!=', 1)
            ->orWhere('is_sold', 1);
            })
            ->with('car_content');
            }

            $cars = $carsQuery->orderBy('id', 'desc')->get();
       }

        $html = view('vendors.car.indexajax', compact('cars'))->render();

        return response()->json(['code' => 200, 'data' =>$html]);
        return view('vendors.car.index', $information);
    }

    public function indexSaveAdsAjax(Request $request)
    {
       if($request->status=="all")
       {
                    $cars  = Car::select('cars.*',  'wishlists.id as wishlist_id', 'wishlists.car_id', 'wishlists.user_id')
                    ->join('wishlists', function ($join) {
                    $join->on(['wishlists.car_id' => 'cars.id']);
                    })->where('wishlists.user_id', '=', Auth::guard('vendor')->user()->id);

                    if (!empty($request->category_id) && $request->has('category_id')) {
            $category_id = $request->category_id;
            $cars->whereHas('car_content', function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
            });
            }


            // Apply sorting based on filter_type
            if ($request->filter_type == 'recent') {
            $cars->orderBy('cars.created_at', 'desc');
            } elseif ($request->filter_type == 'lowest_price') {
            $cars->orderByRaw('COALESCE(NULLIF(cars.previous_price, 0), cars.price) ASC');
            } elseif ($request->filter_type == 'highest_price') {
            $cars->orderByRaw('COALESCE(NULLIF(cars.previous_price, 0), cars.price) DESC');
            } else {
            // Default ordering if no filter_type is provided or matched
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
            ->where('wishlists.user_id', '=', Auth::guard('vendor')->user()->id);

            $status = $request->status;

            if ($status == 1) {
                $cars = $cars->where('cars.status', 1)->where('cars.is_sold', 0);
            } else {
                $cars = $cars->where(function ($query) {
                    $query->where('cars.status', '!=', 1)
                          ->orWhere('cars.is_sold', 1);
                })->with('car_content');
            }

            if (!empty($request->category_id) && $request->has('category_id')) {
                $category_id = $request->category_id;
                $cars->whereHas('car_content', function ($query) use ($category_id) {
                    $query->where('category_id', $category_id);
                });
            }

            if ($request->filter_type == 'recent') {
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

        $html = view('vendors.car.indexajaxsaveads', compact('cars'))->render();

        return response()->json(['code' => 200, 'data' =>$html]);

        return view('vendors.car.index', $information);
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
        $information['country_codes'] = DB::table('phone_country_codes')->get();
        $data = CountryArea::where('status', 1)->orderBy('name', 'asc')->get();
        $information['countryArea'] = $data;
        $information['draft_ad'] =  DraftAd::where('vendor_id', Auth::guard('vendor')->user()->id)->first();
        return view('vendors.car.create', $information);
    }

    public function get_brand_model(Request $request)
    {
         $data = CarModel::where('brand_id', $request->id)->where('status', 1)->get();

        if($data->count()>0)
        {
             return $data;
        }

       $brand = Brand::find($request->id);

       $slugs = Brand::where('slug' , $brand->slug)->pluck('id');

       $data = CarModel::whereIn('brand_id', $slugs)->where('status', 1)->get();

       foreach($data as $dt)
       {
           DB::table('car_models')->insert(['language_id' => 20 , 'name' => $dt->name , 'slug' => $dt->slug , 'brand_id' => $request->id ]);
       }

       return $data;
    }

    public function imagesstore(Request $request)
    {
        //print_r($request->file('file')); exit;
        $img = $request->file('file');
        $allowedExts = array('jpg', 'png', 'jpeg', 'svg', 'webp');
        $rules =
        [
            'file' =>
            [
                function ($attribute, $value, $fail) use ($img, $allowedExts)
                {
                    $ext = $img->getClientOriginalExtension();
                    if (!in_array($ext, $allowedExts))
                    {
                        return $fail("Only png, jpg, jpeg images are allowed");
                    }
                },
            ]
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            $validator->getMessageBag()->add('error', 'true');

            return response()->json($validator->errors());
        }

        $filename = uniqid() . '.jpg';

        $img->move(public_path('assets/admin/img/car-gallery/'), $filename);

        $pi = new CarImage();

        if (!empty($request->car_id))
        {
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
        if ($imageCount > 1)
        {
            @unlink(public_path('assets/admin/img/car-gallery/') . $pi->image);
            $pi->delete();
            return $pi->id;
        }
        else
        {
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
    public function BoostPackage(Request $request)
    {
        $data = Car::where('id', $request->ad_id)->first();
        $data->update(['package_id' => $request->package_id]);
        return redirect()->route('vendor.package.payment_method',$request->ad_id);


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
        // dd($request->all());
        $max_file_upload = 20;
        $slider_images_count = count($request->slider_images);
        if ($slider_images_count > $max_file_upload) {
            $errors = [
                'slider_images' => [
                    "You can upload a maximum of {$max_file_upload} images on selected package. Please remove some images."
                ]
            ];
            return response()->json(['errors' => $errors,'max_file' => $slider_images_count,'limit' => $max_file_upload], 422);
        }
        if ($request->can_car_add != 1)
        {
            return back();
        }
        $vendor_id = Auth::guard('vendor')->user()->id;
        $current_package = VendorPermissionHelper::packagePermission($vendor_id);
        $total_car_added = Car::where('vendor_id', $vendor_id)->get()->count();
        if ($current_package != '[]') {
            if ($total_car_added > $current_package->number_of_car_add) {
                Session::flash('warning', 'Something went wrong');
                return Response::json(['status' => 'success'], 200);
            }
        }
        $lastcarID = '';
        $filters = [];
        DB::transaction(function () use ($request , &$lastcarID)
        {
            if(!empty($request->c_code) && !empty($request->phone))
            {
                Auth::guard('vendor')->user()->update(['phone' => $request->phone , 'country_code' => $request->c_code  ]);
            }

            $featuredImgURL = $request->feature_image;

            $languages = Language::all();
            $in = $request->all();
            if(!empty($request->car_cover_image))
            {
              $fImage =  CarImage::select('id','image')->where('id',$request->car_cover_image)->first();

              if($fImage == false)
              {
                 $fImage =  CarImage::select('id','image')->whereNull('car_id')->where('user_id',Auth::guard('vendor')->user()->id)->whereIn('id' , $request->slider_images)->orderBy('priority','asc')->first();
              }
            }
            else
            {
                $fImage = CarImage::select('id','image')->whereNull('car_id')->where('user_id',Auth::guard('vendor')->user()->id)->whereIn('id' , $request->slider_images)->orderBy('priority','asc')->first();
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

            if(!empty($in['power']))
            {
                $check_if_power_exsit = CarPower::where('slug' , $in['power'])->first();

                if($check_if_power_exsit == false)
                {
                    CarPower::create(['name' => $in['power']. ' HP' , 'slug' => $in['power'] ]);
                }
            }


            $packg = PrivatePackage::where('id', $request->package_id)->first();

            if($packg->price == 0 && $request->promo_status==0)
            {
                $in['status'] =1;
            }
            else
            {
                $in['status'] =0;
            }

            $in['order_id'] = $this->getNextOrderNumber();

            $car = Car::create($in);

            $lastcarID = $car->id;

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

            $catinfo  = Category::where('id', $request['en_category_id'])->first();
            foreach ($languages as $language) {
                $carContent = new CarContent();
                $carContent->language_id = $language->id;
                $carContent->car_id = $car->id;
                $carContent->title = $request[$language->code . '_title'];
                $carContent->slug = createSlug($request[$language->code . '_title']);
                $carContent->car_colour_id = $request[ 'car_colour_id'];
                $carContent->car_color_id = $request[ 'car_colour_id'];
                $carContent->category_id = $request[$language->code . '_category_id'];
                $carContent->main_category_id = $request[$language->code . '_main_category_id'];
                $carContent->car_condition_id = $request[ 'car_condition_id'];
                $carContent->brand_id = $request[ 'brand_id'];
                $carContent->body_type_id = $request[ 'body_type_id'];
                $carContent->car_model_id = $request[ 'car_model_id'];
                $carContent->fuel_type_id = $request[ 'fuel_type_id'];
                $carContent->transmission_type_id = $request[ 'transmission_type_id'];
                $carContent->address = $request[ 'address'];
                $carContent->category_slug = createSlug($catinfo->name);
                $carContent->description = Purifier::clean($request[$language->code . '_description'], 'youtube');

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
        Session::flash('success', 'New ad added successfully!');

        DraftAd::where('vendor_id', Auth::guard('vendor')->user()->id)->delete();

        return Response::json(['status' => 'success', 'action' => 'add','ad_id'=>$lastcarID], 200);
    }
    public function storeData(CarStoreRequest $request)
    {

        if ($request->can_car_add != 1)
        {
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
              if($fImage == false)
              {
                 $fImage =  CarImage::select('id','image')->whereNull('car_id')->where('user_id',Auth::guard('vendor')->user()->id)->whereIn('id' , $request->slider_images)->orderBy('priority','asc')->first();
              }

            }
            else
            {
                $fImage =  CarImage::select('id','image')->whereNull('car_id')->where('user_id',Auth::guard('vendor')->user()->id)->whereIn('id' , $request->slider_images)->orderBy('priority','asc')->first();
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

           // echo $lastcarID; exit;
           // get category detail for cat title
           $catinfo  = Category::where('id', $request['en_category_id'])->first();
            // update vendor info details
            $vendorinfo  = VendorInfo::where('vendor_id', $in['vendor_id'])->first();
            if ($request->traderstatus) {
                if(!empty($request['vat_number']))
                {
                    if($vendorinfo->vatVerified != 1) {
                        if($this->vatVerify($request['vat_number'])== true)
                        {
                            $inuserinfo['vatVerified'] = 1;
                        }else{
                            $inuserinfo['vatVerified'] = 0;
                        }
                    }
                }
                $inuserinfo['business_name'] = $request['business_name'];
                $inuserinfo['vat_number'] = $request['vat_number'];
                $inuserinfo['business_address'] = $request['business_address'];
            }
           // $inuserinfo['name'] = $request->full_name;
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

            foreach ($languages as $language) {
                $carContent = new CarContent();
                $carContent->language_id = $language->id;
                $carContent->car_id = $car->id;
                $carContent->title = $request[$language->code . '_title'];
                $carContent->slug = createSlug($request[$language->code . '_title']);
                $carContent->category_id = $request[$language->code . '_category_id'];
                $carContent->main_category_id = $request[$language->code . '_main_category_id'];
                $carContent->car_colour_id = $request['car_colour_id'];
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
           // return compact('lastcarID');
        });
        Session::put('package_id', $request->package_id);
        Session::put('promo_status', $request->promo_status);
        //Session::flash('success', 'New ads added successfully!');
        //return redirect()->route('vendor.car_management.car');

        DraftAd::where('vendor_id', Auth::guard('vendor')->user()->id)->delete();

        return Response::json(['status' => 'success', 'action' => 'add','ad_id'=>$lastcarID], 200);
    }

    public function vatVerify($vatnumber){
      //  echo "hello";

        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => "https://anyapi.io/api/v1/vat/validate?vat_number=".$vatnumber."&apiKey=".env('VAT_API_KEY'),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        ]);

        $response = curl_exec($curl);
      $err = curl_error($curl);

       // curl_close($curl);
        $data = json_decode($response, true);
       // echo "<pre>";
       return $data['valid'];


       //print_r($data); exit;

       /*  if ($err) {
        echo "cURL Error #:" . $err;
        } else {
        echo $response->valid;
        } */

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
        $current_package = VendorPermissionHelper::packagePermission(Auth::guard('vendor')->user()->id);

        $vendor_total_car = Car::where([['vendor_id', Auth::guard('vendor')->user()->id], ['is_featured', 1]])->get()->count();

        $car = Car::findOrFail($request->carId);

        if ($request->is_featured == 1)
        {
            $car->update(['is_featured' => 1]);

            $bs = DB::table('basic_settings')->select('day_after_spotlight')->first();

            $day_after_spotlight = 1;

            if($bs == true && !empty($bs->day_after_spotlight))
            {
                $day_after_spotlight =   $bs->day_after_spotlight;
            }

            Session::flash('success', 'Your ad has been successfully featured till '.$day_after_spotlight. ' days.');
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

        if ($request->status == 1) {
            $car->update(['status' => 1]);

            Session::flash('success', 'Car Active successfully!');
        } else {
            $car->update(['status' => 0]);

            Session::flash('success', 'Car Deactive successfully!');
        }

        return redirect()->back();
    }



    public function edit($id)
    {
        $current_package = VendorPermissionHelper::packagePermission(Auth::guard('vendor')->user()->id);

        $vendor_total_car = Car::where('vendor_id', Auth::guard('vendor')->user()->id)->get()->count();

        $car = Car::with('galleries')->findOrFail($id);

        $information['car'] = $car;

        if((!empty($car->fil_sub_categories) || !empty($car->car_content->category_id) ) && !empty($car->filters))
        {

            if(!empty($car->fil_sub_categories))
            {
                $json_decode = json_decode($car->fil_sub_categories , true);

                $formData = null;

                foreach($json_decode as $list)
                {
                    $formData = FormFields::where('category_field_id' , $list)->get();

                    if($formData->count() >0 )
                    {
                         $information['output'] =  $this->editHTML($formData , $car);
                         break;
                    }
                }

            }

             if(!empty($car->car_content->category_id))
            {
                $formData = FormFields::where('category_field_id' , $car->car_content->category_id)->get();

                if($formData->count() >0 )
                {
                     $information['output'] =  $this->editHTML($formData , $car);
                }
            }

            }

        // get all the languages from db
        $information['languages'] = Language::all();

        $misc = new MiscellaneousController();
        $information['bgImg'] = $misc->getBreadcrumb();
        $information['country_codes'] = DB::table('phone_country_codes')->get();
        $specifications = CarSpecification::where('car_id', $car->id)->get();
        $information['specifications'] = $specifications;
        $vendor_id = Auth::guard('vendor')->user()->id;
        $information['vendor'] = Vendor::with('vendor_info')->where('id', $vendor_id)->first();
        $data = CountryArea::where('status', 1)->orderBy('name', 'asc')->get();
        $information['countryArea'] = $data;

        return view('vendors.car.edit', $information);
    }

    function editHTML($formData , $car)
    {
        $output = '';

         if($formData)
            {

                $filters =  json_decode($car->filters , true);

                $output .= '<div class="row ">
                <div class="col-lg-12">
                <div class="form-group">
                <h4 style="color:gray">Ad Filters </h4>
                </div>
                </div>
                </div> <div class="row" style="    padding-left: 25px;"> <div class="form-group">';

                foreach($formData as $list)
                {

                if($list->type == 'input')
                {
                    $value = '';
                    $key_to_find = strtolower($list->type.'_'.str_replace(' ' , '_' , $list->label));

                    if (array_key_exists($key_to_find, $filters))
                    {
                        $value = $filters[$key_to_find];
                    }

                    $output .= '<div class="col-md-12 mt-4" > <label class=" us_label mb-2"> '.$list->label.'</label> <input type="text" value="'.$value.'" placeholder="type here ..." name="filters_input_'.strtolower(str_replace(' ' , '_' , $list->label)).'" class="form-control" />';
                }

                if($list->type == 'textarea')
                {
                    $value = '';
                    $key_to_find = strtolower($list->type.'_'.str_replace(' ' , '_' , $list->label));

                    if (array_key_exists($key_to_find, $filters))
                    {
                        $value = $filters[$key_to_find];
                    }

                    $output .= '<div class="col-md-12 mt-4" > <label class=" us_label mb-2"> '.$list->label.'</label> <textarea name="filters_textarea_'.strtolower(str_replace(' ' , '_' , $list->label) ).'"
                    placeholder="type here ..." class="form-control" rows="4">'.$value.'</textarea>';
                }

                if($list->type == 'checkbox')
                {
                    if(!empty($list->form_options))
                    {
                        $output .= '<div class="col-md-12 mt-4" > <label class="us_label mb-2"> '.$list->label.'</label><br>';

                        foreach($list->form_options as $option)
                        {

                            $value = '';
                            $key_to_find = strtolower($list->type.'_'.str_replace(' ' , '_' , $list->label));

                            if (array_key_exists($key_to_find, $filters))
                            {
                               $filtr_keys = $this->normalizeFilter($filters[$key_to_find]);
                                if(in_array(strtolower($option->value) , $filtr_keys ))
                                {
                                    $value = 'checked';
                                }
                            }

                            $output .= '<b>'.$option->value.'</b> : &nbsp;&nbsp;<input type="checkbox" value="'.$option->value.'" '.$value.' style="position: relative;margin-right: 1rem;top: 2.2px;" name="filters_checkbox_'.strtolower(str_replace(' ' , '_' , $list->label) ).'[]"  /> ';
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
                            $value = '';
                            $key_to_find = strtolower($list->type.'_'.str_replace(' ' , '_' , $list->label));

                            if (array_key_exists($key_to_find, $filters))
                            {
                               $filtr_keys = $this->normalizeFilter($filters[$key_to_find]);
                                if($filtr_keys == strtolower($option->value))
                                {
                                    $value = 'checked';
                                }
                            }

                            $output .= '<b>'.$option->value.'</b> : &nbsp;&nbsp;<input type="radio" value="'.$option->value.'" '.$value.' style="position: relative;margin-right: 1rem;top: 2.2px;" name="filters_radio_'.strtolower(str_replace(' ' , '_' , $list->label) ).'"  /> ';
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
                           $value = '';
                            $key_to_find = strtolower($list->type.'_'.str_replace(' ' , '_' , $list->label));

                            if (array_key_exists($key_to_find, $filters))
                            {
                                $filtr_keys = $this->normalizeFilter($filters[$key_to_find]);

                                if( $filtr_keys  == strtolower($option->value))
                                {
                                    $value = 'selected';
                                }
                            }

                            $output .= '<option value="'.$option->value.'" '.$value.'>'.$option->value.'</option> ';
                        }

                        $output .= '</select>';
                    }
                }

                }

                    $output .= '</div></div>';
                }

                return $output;
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

    public function update(Request $request, $id)
    {

        $max_file_upload = $request->max_file_upload;

        $slider_images_count = count($request->slider_images);

        if ($slider_images_count > $max_file_upload) {

            $errors = [
                'slider_images' => [
                    "You can upload a maximum of {$max_file_upload} images on selected package. Please remove some images."
                ]
            ];

            return response()->json(['errors' => $errors], 422);
        }

        //  print_r($request->request->all()); exit;
      //return Response::json(['status' => 'succewwwss'], 200); exit;
      if ($request->can_car_add != 1) {
        return back();
     }
     $vendor_id = Auth::guard('vendor')->user()->id;

     DB::transaction(function () use ($request) {

        // $featuredImgURL = $request->feature_image;

        if(!empty($request->c_code) && !empty($request->phone))
            {
                Auth::guard('vendor')->user()->update(['phone' => $request->phone , 'country_code' => $request->c_code  ]);
            }


         $languages = Language::all();
         $in = $request->all();

        $in['price'] = $in['previous_price'];

         if(!empty($request->car_cover_image))
            {
              $fImage =  CarImage::select('id','image')->where('id',$request->car_cover_image)->first();

              if($fImage == false)
              {
                 $fImage =  CarImage::select('id','image')->whereNull('car_id')->where('user_id',Auth::guard('vendor')->user()->id)->whereIn('id' , $request->slider_images)->orderBy('priority','asc')->first();
              }
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

        if(isset($in['message_center']) && $in['message_center'] == 'yes')
        {
           $in['message_center'] = 1;
        }

        if(isset($in['phone_text']) && $in['phone_text'] == 'yes')
        {
           $in['phone_text'] = 1;
        }


        if(!empty($in['power']))
        {
            $check_if_power_exsit = CarPower::where('slug' , $in['power'])->first();

            if($check_if_power_exsit == false)
            {
                CarPower::create(['name' => $in['power']. ' HP' , 'slug' => $in['power'] ]);
            }
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

         $car = $car->update($in);
         $vendor  = Vendor::where('id',$in['vendor_id'])->first();
         $inuser['phone'] = $request->phone;
         $vendor->update($inuser);
         // update vendor info details
         $vendorinfo  = VendorInfo::where('vendor_id', $in['vendor_id'])->first();
         $inuserinfo['name'] = $request->full_name;
         $inuserinfo['city'] = $request->city;
         $vendorinfo->update($inuserinfo);



         foreach ($languages as $language)
         {
            $carContent =  CarContent::where('car_id', $request->car_id)->first();
            if (empty($carContent)) {
                $carContent = new CarContent();
            }

            $carContent->title = $request[$language->code . '_title'];
            $carContent->slug = createSlug($request[$language->code . '_title']);
            $carContent->car_colour_id = $request[ 'car_colour_id'];
            $carContent->car_color_id = $request[ 'car_colour_id'];
            $carContent->car_condition_id = $request[ 'car_condition_id'];
            $carContent->body_type_id = $request[ 'body_type_id'];
            $carContent->transmission_type_id = $request[ 'transmission_type_id'];
            $carContent->address = $request[ 'address'];
            $carContent->description = Purifier::clean($request[$language->code . '_description'], 'youtube');

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

    //--- Change status -------
    public function adStatus(Request $request)
    {
        //print_r($request->status); exit;
        $car = Car::findOrFail($request->id);
        if($request->status == "withdraw"){
        $inuser['status'] = 3;
        }elseif($request->status == "relist"){
            $inuser['status'] = 1;
        }
        $car->update($inuser);
        Session::flash('success', 'Status updated successfully!');
        return redirect()->back();
    }

    function removePost(Request $request)
    {
        $car_id = $request->car_id;
        $request_for = $request->request_for;
        $remove_remarks = $request->remove_remarks;
        $recommendation = $request->recommendation;
        $remove_option = $request->remove_option;

        $car = Car::findOrFail($car_id);
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

        $flash_message = ($request_for == 'sold') ? Session::flash('success', 'Ad Sold successfully!') : Session::flash('success', 'Ad deleted successfully!');

        return redirect()->back();

    }

    //delete
    public function delete(Request $request)
    {
        $car = Car::findOrFail($request->car_id);

        $car->deleted_at = date('Y-m-d');

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
        $car->save();

        Session::flash('success', 'Ad deleted successfully!');
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

        Session::flash('success', 'Ad deleted successfully!');
        /**
         * this 'success' is returning for ajax call.
         * if return == 'success' then ajax will reload the page.
         */
        return response()->json(['status' => 'success'], 200);
    }

     // get payment options
     public function PaymentOptions(Request $request)
     {

        // return response()->json($request);
        $categories = Category::where('id', $request->category_id)->first();
        // return response()->json($categories);
        //print_r($cat->filters);
        $apiarray = [];
        $filters = "";

        if (in_array('make', json_decode($categories->filters)))
        {
            $make = 1;

            $filters = view('vendors.car.carfilteroptions', compact('categories'))->render();
        }
        else
        {
             $draft_ad =  DraftAd::where('vendor_id', Auth::guard('vendor')->user()->id)->first();

            $filters = view('vendors.car.vehicledetails', compact('categories','apiarray' , 'draft_ad'))->render();

            $make = 0;
        }

        $data = PrivatePackage::where('category_id', $categories->parent_id)->where('status', 1)->get();
        // $data = PrivatePackage::where('category_id', $request->category_id)->where('status', 1)->get();
        // return response()->json($data);

        $html = view('vendors.car.paymentoptions', compact('data'))->render();

        return response()->json(['code' => 200, 'message' => 'successful.','data' =>$html, "make" => $make, "filters" => $filters]);
     }


     public function PlanSelected(Request $request)
     {
        $data = PrivatePackage::where('id', $request->package_id)->where('status', 1)->first();

        $html = view('vendors.car.packageselected', compact('data'))->render();

        return response()->json(['code' => 200, 'message' => 'successful.','data' =>$html , 'photo_allowed' => $data->photo_allowed ]);
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