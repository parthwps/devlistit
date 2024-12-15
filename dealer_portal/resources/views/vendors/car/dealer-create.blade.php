@extends("frontend.layouts.layout-v$settings->theme_version")
@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('Ads') }}
  @else
    {{ __('Ads') }}
  @endif
@endsection
@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keywords_vendor_signup }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_vendor_signup }}
  @endif
@endsection

@section('content')
 @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Ads'),
  ])
<div class="user-dashboard pt-20 pb-60">
    <div class="container">
      
  
      
  <div class="row gx-xl-5">
  
       @includeIf('vendors.partials.side-custom')
  <div class="col-md-9">      
  

  @php
    $current_package = App\Http\Helpers\VendorPermissionHelper::packagePermission(Auth::guard('vendor')->user()->id);
   //echo "<pre>"; print_r($countryArea);
  @endphp

  <div class="row">
    <div class="col-md-12">
      @if ($current_package != '[]')
        @if (vendorTotalAddedCar() >= $current_package->number_of_car_add)
          <div class="alert alert-danger">
            {{ __("You can't add more car. Please buy/extend a plan to add car") }}
          </div>
          @php
            $can_car_add = 2;
          @endphp
        @else
          @php
            $can_car_add = 1;
          @endphp
        @endif
      @else
        @php
          $pendingMemb = \App\Models\Membership::query()
              ->where([['vendor_id', '=', Auth::id()], ['status', 0]])
              ->whereYear('start_date', '<>', '9999')
              ->orderBy('id', 'DESC')
              ->first();
          $pendingPackage = isset($pendingMemb) ? \App\Models\Package::query()->findOrFail($pendingMemb->package_id) : null;
        @endphp
        @if ($pendingPackage)
          <div class="alert alert-warning text-dark">
            {{ __('You have requested a package which needs an action (Approval / Rejection) by Admin. You will be notified via mail once an action is taken.') }}
          </div>
          <div class="alert alert-warning text-dark">
            <strong>{{ __('Pending Package') . ':' }} </strong> {{ $pendingPackage->title }}
            <span class="badge badge-secondary">{{ $pendingPackage->term }}</span>
            <span class="badge badge-warning">{{ __('Decision Pending') }}</span>
          </div>
        @else
          <!-- <div class="alert alert-warning text-dark">
            {{ __('Your membership is expired. Please purchase a new package / extend the current package.') }}
          </div> -->
        @endif
        
        @php
          $can_car_add = 0;
        @endphp
      @endif
  <form id="carForm"  action="{{ route('vendor.cars_management.store_Data') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
        <div id="sliders">
        
         @if($draft_ad == true && !empty($draft_ad->images))
        @php
        $images = json_decode($draft_ad->images, true);
        $items = [];
        @endphp
        
        @if(count($images) > 0)
        
        @foreach($images as $image)
            @php
                $item = \App\Models\Car\CarImage::where('image', $image)->first();
            @endphp
        
            @if($item)
                @php
                    $items[] = [
                        'id' => $item->id,
                        'image' => $item->image,
                        'rotation_point' => $item->rotation_point,
                        'priority' => $item->priority,
                    ];
                @endphp
            @endif
        @endforeach
        
        @php
            // Sort items by priority
            usort($items, function($a, $b) {
                return $a['priority'] <=> $b['priority'];
            });
        @endphp
        
        @foreach($items as $itm)
            <input type="hidden" name="slider_images[]" id="slider{{$itm['id']}}" value="{{$itm['id']}}">
        @endforeach
        
        @endif
        @endif
        
        </div>
                  
                  
        <div class="card">

        <div class="card-body">
        <div class="row">


                <div class="col-lg-12 ">
                <div class="alert alert-danger pb-1 dis-none" id="carErrors">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <ul></ul>
                </div>
                </div>


                <div class="col-md-12">
                <strong>
                Let's start with the basics
                </strong>

                <br><br>
                </div>


                  <div class="col-lg-6">


                              <div class="form-group ">
                                @php
                               $categories = App\Models\Car\Category::where('parent_id', 0)->where('status', 1)
                                      ->get();
                                @endphp

                                <label>{{ __('Section') }} *</label>
                                <select name="en_main_category_id"
                                  class="form-control " onchange="checkIfVhecleCat(this); saveDraftData(this , 'category_id') " id="adsMaincat">
                                  <option selected disabled>{{ __('Select a Category') }}</option>

                                  @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                 

                            <div class="col-lg-6 ">

                            
                            <div class="form-group">
                            <label>{{ __('Subsection') }} *</label>
                            <select disabled name="en_category_id" class="form-control  subhidden" onchange="hideFuelIf(this); saveDraftData(this , 'sub_category_id')"  id="adsSubcat">
                                <option selected disabled>{{ __('Select sub Category') }}</option>
                            </select>
                            </div>
                  </div>


                </div>
              
        </div>
        </div>
        
        
    <div id="loadFiltersCategoryWise">
        
        <div class="card car_category"  style="display:none;">
        
                <div class="card-body">
                
                <div class="row " >
                  <div class="col-lg-8 ">
                    <div class="form-group">
                      <h3>{{ __('Add Details') }} </h3>
                      <!--<label>Get all your vehicle details instantly</label>-->
                  
                    </div>
                  </div>
                  
                </div>
              
            
                <div class="row us_car_features" >
                
                <div class="col-lg-2">
                <div class="form-group">
                <label id="labael_new"> New </label>
                &nbsp;&nbsp; <input type="radio"  name="what_type" value="brand_new" onchange="hide_owner_if_new(this);saveDraftData(this , 'what_type')"  id="what_type"  @if($draft_ad == true && empty($draft_ad->what_type) ) checked @endif @if($draft_ad == true && !empty($draft_ad->what_type) && $draft_ad->what_type == 'brand_new') checked @endif >
                </div>
                </div>
                
                <div class="col-lg-2">
                <div class="form-group">
                <label id="labael_used">Used </label>
                &nbsp;&nbsp; <input type="radio"   name="what_type" value="used" onchange="hide_owner_if_new(this);saveDraftData(this , 'what_type')"  id="what_type"  @if($draft_ad == true && empty($draft_ad->what_type) ) checked @endif @if($draft_ad == true && !empty($draft_ad->what_type) && $draft_ad->what_type == 'used') checked @endif >
                </div>
                </div>
                
                <div class="col-lg-8"></div>
                
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                <div class="form-group">
                <label>Enter vehicle registration *</label>
                <div style="display:flex;">
                <input type="text" class="form-control validateTextBoxs" name="vehicle_reg" style="border-top-right-radius:0px;border-bottom-right-radius:0px;" placeholder="Enter vehicle registration" id="vehicle_reg" >
                <button class="btn btn-sm btn-success" type="button" onclick="getVehicleData(this , 1)" style="border-top-left-radius:0px;border-bottom-left-radius:0px;"><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
                
                <div id="result_status"></div>
                </div>
                </div>
                
                
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                <div class="form-group">
                @php
                
                $brands = App\Models\Car\Brand::where('cat_id', 44)
                ->where('status', 1)
                ->withCount('cars')
                ->orderBy('cars_count', 'desc')
                ->orderBy('name', 'asc')
                ->take(10) 
                ->get();
                
                
                $otherBrands = App\Models\Car\Brand::where('cat_id', 44)
                ->where('status', 1)
                ->whereNotIn('id', $brands->pluck('id'))
                ->orderBy('name', 'asc')
                ->get();
                
                @endphp
                
                <label>{{ __('Make') }} *</label>
                <select name="en_brand_id"
                class="form-control  validateTextBoxs" onchange="getModel(this);saveDraftData(this , 'make')" id="make" data-code="en">
                <option value="" >{{ __('Select make') }}</option>
                <option disabled>-- Popular Brands --</option>
                @foreach ($brands as $brand)
                
                @php
                
                if($draft_ad == true && !empty($draft_ad->make) && $draft_ad->make == $brand->id)
                {
                $brandId = $draft_ad->make;
                } 
                
                @endphp
                
                <option value="{{ $brand->id }}" @if($draft_ad == true && !empty($draft_ad->make) && $draft_ad->make == $brand->id) selected @endif>{{ $brand->name }}</option>
                @endforeach
                <option disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-- Other Brands --</option>
                @foreach ($otherBrands as $brand)
                
                @php
                
                if($draft_ad == true && !empty($draft_ad->make) && $draft_ad->make == $brand->id)
                {
                $brandId = $draft_ad->make;
                } 
                
                @endphp
                
                <option value="{{ $brand->id }}" @if($draft_ad == true && !empty($draft_ad->make) && $draft_ad->make == $brand->id) selected @endif >{{ $brand->name }}</option>
                @endforeach
                </select>
                </div>
                </div>
                
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                <div class="form-group">
                
                <label>{{ __('Model') }} *</label>
                @php
                if(isset($brandId)) 
                {
                $models = App\Models\Car\CarModel::where('brand_id', $brandId)->get();
                } 
                @endphp
                
                <select name="en_car_model_id" class="form-control validateTextBoxs en_car_brand_model_id" onchange="saveDraftData(this , 'model')"   id="carModel">
                @if(isset($brandId)) 
                @foreach ($models as $model)
                <option    value="{{ $model->id }}"   @if($draft_ad == true && !empty($draft_ad->model) && $draft_ad->model == $model->id) selected @endif    >{{ $model->name }}</option>
                @endforeach
                @else
                <option  value="">Any</option>
                @endif
                </select>
                </div>
                </div>
                
                
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                <div class="form-group">
                <label>{{ __('Year') }} *</label>
                <input type="number" class="form-control validateTextBoxs" oninput="checkYearAgo(this)" 
                value="@if($draft_ad == true && !empty($draft_ad->year)){{$draft_ad->year}}@endif" onfocusout="saveDraftData(this , 'year')" name="year" placeholder="Enter Year" id="carYear" >
                </div>
                </div>
                
                
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                <div class="form-group">
                @php
                $fuel_types = App\Models\Car\FuelType::where('status', 1)
                ->get();
                @endphp
                
                <label>{{ __('Fuel Type') }} *</label>
                <select name="en_fuel_type_id" id="fuelType" onchange="changeVal();saveDraftData(this , 'fuel')" class="form-control validateTextBoxs" >
                <option value="" >{{ __('Select') }}</option>
                
                @foreach ($fuel_types as $fuel_type)
                <option value="{{ $fuel_type->id }}"  @if($draft_ad == true && !empty($draft_ad->fuel) && $draft_ad->fuel == $fuel_type->id) selected @endif >{{ $fuel_type->name }}</option>
                @endforeach
                </select>
                </div>
                </div>
                
                
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 " id="new_engine_caacity">
                <div class="form-group">
                <label> Engine Size  *</label>
                <input type="text" class="form-control validateTextBoxs" name="engineCapacity" value="@if($draft_ad == true && !empty($draft_ad->engine)) {{$draft_ad->engine}}  @endif" onfocusout="saveDraftData(this , 'engine')" placeholder="Enter Size" id="EngineCapacity" >
                </div>
                </div>
                </div>
                <div class="row us_car_features" >
                
                <!-- editable --> 
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                <div class="form-group">
                @php
                $transmission_types = App\Models\Car\TransmissionType::where('status', 1)
                ->get();
                @endphp
                
                <label>{{ __('Transmission Type') }} *</label>
                <select name="en_transmission_type_id" class="form-control validateTextBoxs" id="transmissionType" onchange="saveDraftData(this , 'transmission')">
                <option value="" >{{ __('Select') }}</option>
                
                @foreach ($transmission_types as $transmission_type)
                <option value="{{ $transmission_type->id }}" @if($draft_ad == true && !empty($draft_ad->transmission) && $draft_ad->transmission == $transmission_type->id) selected @endif>{{ $transmission_type->name }}
                </option>
                @endforeach
                </select>
                </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                <div class="form-group">
                @php
                
                $body_types =  App\Models\Car\BodyType::where('status', 1)->orderBy('serial_number', 'asc')->get();
                
                @endphp
                <label>{{ __('Body Type') }} </label>
                <select name="body_type_id" id="bodyType" class="form-control" onchange="saveDraftData(this , 'body')" >
                <option value="" >Please Select Body Type</option>
                @foreach ($body_types as $body_type)
                
                <option value="{{ $body_type->id }}"   @if($draft_ad == true && !empty($draft_ad->body) && $draft_ad->body == $body_type->id) selected @endif >{{ $body_type->name }}
                </option>
                @endforeach
                </select>
                </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                <div class="form-group">
                <label>{{ __('Doors') }} *</label>
                <select name="doors" class="form-control validateTextBoxs" id="carDoors" required onchange="saveDraftData(this , 'doors')" >
                <option value="">Please select...</option>
                <option value="2" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 2) selected @endif >2</option>
                <option value="3"  @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 3) selected @endif>3</option>
                <option value="4" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 4) selected @endif>4</option>
                <option value="5" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 5) selected @endif>5</option>
                <option value="6" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 6) selected @endif>6</option>
                <option value="7" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 7) selected @endif>7</option>
                <option value="8" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 8) selected @endif>8</option>
                </select>
                </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                <div class="form-group ">
                @php
                $colour = \DB::table('car_colors')->where('status', 1)
                ->get(['id' , 'name']);
                @endphp
                
                <label>{{ __('Colour') }} *</label>
                <select name="en_car_color_id" class="form-control validateTextBoxs" id="carColour" onchange="saveDraftData(this , 'color')">
                <option value="">{{ __('Select Colour') }}</option>
                
                @foreach ($colour as $colour)
                <option value="{{ $colour->id }}" @if($draft_ad == true && !empty($draft_ad->color) && $draft_ad->color == $colour->id) selected @endif>{{ $colour->name }}</option>
                @endforeach
                </select>
                </div>
                </div>
                
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                <div class="form-group">
                <label>{{ __('Seats') }} *</label>
                <select name="seats" id="carSeats" class="form-control validateTextBoxs" onchange="saveDraftData(this , 'seats')">
                <option value="">Please select...</option>
                <option value="2" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 2) selected @endif >2</option>
                <option value="3"  @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 3) selected @endif>3</option>
                <option value="4" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 4) selected @endif>4</option>
                <option value="5" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 5) selected @endif>5</option>
                <option value="6" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 6) selected @endif>6</option>
                <option value="7" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 7) selected @endif>7</option>
                <option value="8" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 8) selected @endif>8</option>
                </select>
                </div>
                </div>
                
                
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                <div class="form-group">
                <label>{{ __('Add your mileage') }} (M) *</label>
                <input type="number" class="form-control validateTextBoxs" name="mileage" step="any"  value="@if($draft_ad == true && !empty($draft_ad->milage)){{$draft_ad->milage}}@endif" onfocusout="saveDraftData(this , 'milage')" id="Mileage" placeholder="Enter Mileage"> 
                </div>
                </div>
                
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 " id="ownerParentDiv">
                <div class="form-group">
                <label>{{ __('Number of Owners') }} *</label>
                <select name="number_of_owners" id="" class="form-control validateTextBoxs" onchange="saveDraftData(this , 'owners')">
                <option value="1"  @if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 1 ) selected @endif >1</option>
                <option value="2"   @if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 2 ) selected @endif>2</option>
                <option value="3"   @if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 3 ) selected @endif>3</option>
                <option value="4"   @if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 4 ) selected @endif>4</option>
                <option value="5"   @if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 5 ) selected @endif>5</option>
                <option value="6"   @if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 6 ) selected @endif>6</option>
                <option value="7"  @if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 7 ) selected @endif>7</option>
                <option value="8"  @if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 8 ) selected @endif >8</option>
                </select>
                </div>
                </div>
                
                
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                <div class="form-group">
                @php
                // Determine the value to display
                $taxValue = !empty($draft_ad->tax) ? $draft_ad->tax : (isset($check_post->tax_fee) ? $check_post->tax_fee : '');
                @endphp
                
                <label>Annual Road Tax </label>
                <input type="number" class="form-control validateTextBoxs" name="annual_road_tax" onfocusout="saveDraftData(this , 'tax')"    value="{{ $taxValue }}"  placeholder="Enter Annual Road Tax" id="carRoadTax" >
                
                
                </div>
                </div>
                
                
                <input type="hidden" value="{{$vendor->vendor_info->city}}" name="current_area_regis" />
                
                
                
                <div class="col-lg-12">
                <div class="form-group">
                <hr>
                </div>
                </div>
                
                <div class="col-2" style="width: 130px;">
                <div class="form-group" style="padding-left: 0px;padding-right: 0px;">
                <label style="    font-size: 18px !important;">Sale </label>
                &nbsp;&nbsp; <input type="checkbox"  style="zoom: 1.3;position: relative;top: 1px;" @if($draft_ad == true && !empty($draft_ad->sale) && $draft_ad->sale == '1') checked @endif onchange="saveDraftData(this , 'sale')" name="is_sale" value="1"  id="sale" >
                </div>
                </div>
                
                <div class="col-2"  style="width: 130px;">
                <div class="form-group" style="padding-left: 0px;padding-right: 0px;">
                <label style="    font-size: 18px !important;" id="labael_sold" >Sold </label>
                &nbsp;&nbsp; <input type="checkbox"  style="zoom: 1.3;position: relative;top: 1px;" onchange="saveDraftData(this , 'sold')" @if($draft_ad == true && !empty($draft_ad->sold) && $draft_ad->sold == '1') checked @endif  name="is_sold" value="1"  id="sold" >
                </div>
                </div>
                
                <div class="col">
                <div class="form-group">
                <label style="    font-size: 18px !important;" id="labael_reduced_price">Reduced Price </label>
                &nbsp;&nbsp; <input type="checkbox"  style="zoom: 1.3;position: relative;top: 1px;"  name="reduce_price" value="1" @if($draft_ad == true && !empty($draft_ad->reduced_price) && $draft_ad->reduced_price == '1') checked @endif onchange="saveDraftData(this , 'reduced_price')"   id="reduce_price" >
                </div>
                </div>
                
                <div class="col">
                <div class="form-group" style="padding-left: 0px;padding-right: 0px;">
                <label style="    font-size: 18px !important;" id="labael_manager_special" >Manager special </label>
                &nbsp;&nbsp; <input type="checkbox"   style="zoom: 1.3;position: relative;top: 1px;"  name="manager_special"  value="1" @if($draft_ad == true && !empty($draft_ad->manager_special) && $draft_ad->manager_special == '1') checked @endif  onchange="saveDraftData(this , 'manager_special')" id="manager_special" >
                </div>
                </div>
                
                <div class="col">
                <div class="form-group">
                <label style="    font-size: 18px !important;">Deposit  Taken </label>
                &nbsp;&nbsp; <input type="checkbox"  style="zoom: 1.3;position: relative;top: 1px;"   name="deposit_taken"  value="1" @if($draft_ad == true && !empty($draft_ad->deposit_taken) && $draft_ad->deposit_taken == '1') checked @endif  onchange="saveDraftData(this , 'deposit_taken')"  id="deposit_taken" >
                </div>
                </div>
                
                
                </div>
           

         </div>
         </div>
       


        <div class="card car_category us_key_feture"  style="display:none;">

        <div class="card-body">
        <div class="row">
    
                <div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
                    <b style="font-size: 20px;">Comfort & Convenience </b>
                    
                    <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
                </div>

      
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                       
                         <input class="chekbox" name="comfort_n_convenience[]" value="air_conditioning" type="checkbox"    {{ in_array('air_conditioning', $key_features) ? 'checked' : '' }}   />
                         <label class="lbel">Air Conditioning </label>
                    </div>
                </div>



                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                        
                         <input class="chekbox" name="comfort_n_convenience[]" value="climate_control" type="checkbox"  {{ in_array('climate_control', $key_features) ? 'checked' : '' }} />
                         <label  class="lbel">Climate control </label>
                    </div>
                </div>



                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                         
                         <input  class="chekbox" name="comfort_n_convenience[]" value="dual_zone_climate_control" type="checkbox"  {{ in_array('dual_zone_climate_control', $key_features) ? 'checked' : '' }} />
                         <label  class="lbel">Dual zone  climate control </label>
                    </div>
                </div>

                
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                         <input class="chekbox" name="seat_n_vantilation[]" value="seat_vantilation" type="checkbox"  {{ in_array('seat_vantilation', $key_features) ? 'checked' : '' }}/>
                         <label class="lbel">Seat Ventilation</label>
                    </div>
                </div>
                
                
                 <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                         <input class="chekbox" name="electric_n_handbrake[]" value="electric_handbrake" type="checkbox" {{ in_array('electric_handbrake', $key_features) ? 'checked' : '' }} />
                         <label class="lbel">Electric Handbrake</label>
                    </div>
                </div>
                

                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                       
                         <input class="chekbox" name="comfort_n_convenience[]" value="multi_zone_climate_control"  type="checkbox"  {{ in_array('multi_zone_climate_control', $key_features) ? 'checked' : '' }}/>
                         <label class="lbel">Multi zone  climate control</label>
                    </div>
                </div>


                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                        
                         <input class="chekbox" name="comfort_n_convenience[]" value="armrest" type="checkbox" {{ in_array('armrest', $key_features) ? 'checked' : '' }} />
                         <label  class="lbel">Armrest </label>
                    </div>
                </div>



                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                         
                         <input  class="chekbox"  name="comfort_n_convenience[]" value="keyless_entry" type="checkbox"  {{ in_array('keyless_entry', $key_features) ? 'checked' : '' }}/>
                         <label  class="lbel">Keyless Entry </label>
                    </div>
                </div>



                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                       
                         <input class="chekbox" name="comfort_n_convenience[]" value="electrically_adjustable_seats" type="checkbox"  {{ in_array('electrically_adjustable_seats', $key_features) ? 'checked' : '' }} />
                         <label class="lbel">Electrically adjustable seats </label>
                    </div>
                </div>



                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                        
                         <input class="chekbox"  name="comfort_n_convenience[]" value="heated_windshield" type="checkbox" {{ in_array('heated_windshield', $key_features) ? 'checked' : '' }} />
                         <label  class="lbel">Heated Windshield </label>
                    </div>
                </div>



                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                         
                         <input  class="chekbox"  name="comfort_n_convenience[]" value="electric_boot" type="checkbox"  {{ in_array('electric_boot', $key_features) ? 'checked' : '' }} />
                         <label  class="lbel">Electric boot </label>
                    </div>
                </div>


                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                       
                         <input class="chekbox"  name="comfort_n_convenience[]" value="electric_side_mirrors" type="checkbox" {{ in_array('electric_side_mirrors', $key_features) ? 'checked' : '' }}  />
                         <label class="lbel">Electric side mirrors </label>
                    </div>
                </div>





                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                         
                         <input  class="chekbox" name="comfort_n_convenience[]" value="heated_seats" type="checkbox"  {{ in_array('heated_seats', $key_features) ? 'checked' : '' }} />
                         <label  class="lbel">Heated seats</label>
                    </div>
                </div>


                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                       
                         <input class="chekbox" name="comfort_n_convenience[]" value="heated_steering_wheel" type="checkbox"  {{ in_array('heated_steering_wheel', $key_features) ? 'checked' : '' }}/>
                         <label class="lbel">Heated steering wheel </label>
                    </div>
                </div>



                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                        
                         <input class="chekbox" name="comfort_n_convenience[]" value="lumbar_support" type="checkbox" {{ in_array('lumbar_support', $key_features) ? 'checked' : '' }} />
                         <label  class="lbel">Lumbar support </label>
                    </div>
                </div>



                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                         
                         <input  class="chekbox" name="comfort_n_convenience[]" value="massage_seats" type="checkbox"  {{ in_array('massage_seats', $key_features) ? 'checked' : '' }} />
                         <label  class="lbel">Massage seats </label>
                    </div>
                </div>


                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                       
                         <input class="chekbox"  name="comfort_n_convenience[]" value="multi_func_steering_wheel" type="checkbox" {{ in_array('multi_func_steering_wheel', $key_features) ? 'checked' : '' }} />
                         <label class="lbel">Multi function steering wheel </label>
                    </div>
                </div>



                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                        
                         <input class="chekbox" name="comfort_n_convenience[]" value="rain_sensor" type="checkbox" {{ in_array('rain_sensor', $key_features) ? 'checked' : '' }}/>
                         <label  class="lbel">Rain sensor </label>
                    </div>
                </div>


                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                       
                         <input class="chekbox" name="comfort_n_convenience[]" value="rain_sensor" type="checkbox"  {{ in_array('rain_sensor', $key_features) ? 'checked' : '' }}/>
                         <label class="lbel">Spare tyre </label>
                    </div>
                </div>



               
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                         
                         <input  class="chekbox" name="comfort_n_convenience[]" value="electric_windows" type="checkbox" {{ in_array('electric_windows', $key_features) ? 'checked' : '' }} />
                         <label  class="lbel">Electric windows </label>
                    </div>
                </div>


                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                       
                         <input class="chekbox" name="comfort_n_convenience[]" value="gear_shift_paddles" type="checkbox"  {{ in_array('gear_shift_paddles', $key_features) ? 'checked' : '' }}/>
                         <label class="lbel">Gear Shift Paddles </label>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                       
                         <input class="chekbox" name="comfort_n_convenience[]" value="split_rear_seats" type="checkbox"  {{ in_array('split_rear_seats', $key_features) ? 'checked' : '' }} />
                         <label class="lbel">Split rear seats</label>
                    </div>
                </div>



   </div>
</div>
</div>



<div class="card car_category us_key_feture"  style="display:none;">
<div class="card-body">
<div class="row">

                
                 <div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
                    <b style="font-size: 20px;">Media & Conectivity </b>
                    
                    <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
                </div>



              <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="andriod_auto" type="checkbox" {{ in_array('andriod_auto', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Andriod auto</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="apple_carplay" type="checkbox" {{ in_array('apple_carplay', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Apple Carplay</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="bluetooth" type="checkbox" {{ in_array('bluetooth', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Bluetooth</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="cd" type="checkbox" {{ in_array('cd', $key_features) ? 'checked' : '' }} />
        <label class="lbel">CD</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="mp3_compatitble" type="checkbox" {{ in_array('mp3_compatitble', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Mp3 compatible</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="12v_power_outlet" type="checkbox" {{ in_array('12v_power_outlet', $key_features) ? 'checked' : '' }} />
        <label class="lbel">12v power outlet</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="radio" type="checkbox" {{ in_array('radio', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Radio</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="touch_screen_display" type="checkbox" {{ in_array('touch_screen_display', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Touch screen display</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="usb_connection" type="checkbox" {{ in_array('usb_connection', $key_features) ? 'checked' : '' }} />
        <label class="lbel">USB connection (front)</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="usb_connection_rear" type="checkbox" {{ in_array('usb_connection_rear', $key_features) ? 'checked' : '' }} />
        <label class="lbel">USB connection (rear)</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="wifi" type="checkbox" {{ in_array('wifi', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Wifi</label>
    </div>
</div>

                

   </div>
</div>
</div>



  <div class="card car_category us_key_feture"  style="display:none;">
<div class="card-body">
<div class="row">

            <div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
                <b style="font-size: 20px;">Assistance & Utility </b>
                
                <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
            </div>
                
              
              <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="adaptive_cruise_control" type="checkbox" {{ in_array('adaptive_cruise_control', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Adaptive cruise control</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="cruise_control" type="checkbox" {{ in_array('cruise_control', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Cruise control</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="hill_hold_assist" type="checkbox" {{ in_array('hill_hold_assist', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Hill hold assist</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="navigation_system" type="checkbox" {{ in_array('navigation_system', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Navigation system</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="self_steering_parking" type="checkbox" {{ in_array('self_steering_parking', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Self-steering parking</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="parking_camera" type="checkbox" {{ in_array('parking_camera', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Parking camera</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="front_parking_sensor" type="checkbox" {{ in_array('front_parking_sensor', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Front parking sensor</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="rear_parking_sensor" type="checkbox" {{ in_array('rear_parking_sensor', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Rear parking sensor</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="remote_boot_release" type="checkbox" {{ in_array('remote_boot_release', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Remote boot release</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="roof_rails" type="checkbox" {{ in_array('roof_rails', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Roof rails</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="speed_limiter" type="checkbox" {{ in_array('speed_limiter', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Speed limiter</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="start_stop_system" type="checkbox" {{ in_array('start_stop_system', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Start-stop system</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="traffic_sign_recognition" type="checkbox" {{ in_array('traffic_sign_recognition', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Traffic sign recognition</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="trailer_hitch" type="checkbox" {{ in_array('trailer_hitch', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Trailer hitch</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="voice_control" type="checkbox" {{ in_array('voice_control', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Voice control</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="parking_assistance" type="checkbox" {{ in_array('parking_assistance', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Parking Assistance</label>
    </div>
</div>


   </div>
</div>
</div>



<div class="card car_category us_key_feture"  style="display:none;">
<div class="card-body">
<div class="row">
    

            <div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
            <b style="font-size: 20px;">Styling & Appearance </b>
            
            <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
            </div>

               <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="digital_instrument_panel" type="checkbox" {{ in_array('digital_instrument_panel', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Digital instrument panel</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="alloy_wheels" type="checkbox" {{ in_array('alloy_wheels', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Alloy wheels</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="electric_sunroof" type="checkbox" {{ in_array('electric_sunroof', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Electric sunroof</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="leather_interior" type="checkbox" {{ in_array('leather_interior', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Leather interior</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="leather_steel_wheel" type="checkbox" {{ in_array('leather_steel_wheel', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Leather steering wheel</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="panaramic_sunroof" type="checkbox" {{ in_array('panaramic_sunroof', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Panoramic sunroof</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="spoiler" type="checkbox" {{ in_array('spoiler', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Spoiler</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="sport_seats" type="checkbox" {{ in_array('sport_seats', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Sport seats</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="sunroof" type="checkbox" {{ in_array('sunroof', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Sunroof</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="tinted_windows" type="checkbox" {{ in_array('tinted_windows', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Tinted windows</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="steel_wheels" type="checkbox" {{ in_array('steel_wheels', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Steel wheels</label>
    </div>
</div>


    
   </div>
</div>
</div>


 <div class="card car_category us_key_feture"  style="display:none;">
<div class="card-body">
<div class="row">
    

<div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
            <b style="font-size: 20px;">Lighting & Illumination </b>
            
            <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
            </div>

             <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="night_visson_assist" type="checkbox" {{ in_array('night_visson_assist', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Night vision assist</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="adaptive_headlights" type="checkbox" {{ in_array('adaptive_headlights', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Adaptive headlights</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="ambient_lighting" type="checkbox" {{ in_array('ambient_lighting', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Ambient lighting</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="auto_lights" type="checkbox" {{ in_array('auto_lights', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Auto lights (dusk sensor)</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="bi_xenon_headlights" type="checkbox" {{ in_array('bi_xenon_headlights', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Bi-xenon headlights</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="daytime_runing_lights" type="checkbox" {{ in_array('daytime_runing_lights', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Daytime running lights</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="fog_lights" type="checkbox" {{ in_array('fog_lights', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Fog Lights</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="high_beam_assist" type="checkbox" {{ in_array('high_beam_assist', $key_features) ? 'checked' : '' }} />
        <label class="lbel">High beam assist</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="led_headlights" type="checkbox" {{ in_array('led_headlights', $key_features) ? 'checked' : '' }} />
        <label class="lbel">LED headlights</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="xenon_headlights" type="checkbox" {{ in_array('xenon_headlights', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Xenon headlights</label>
    </div>
</div>

    
   </div>
</div>
</div>   



    <div class="card car_category us_key_feture"  style="display:none;">
    <div class="card-body">
    <div class="row">
        
     <div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
            <b style="font-size: 20px;">Safety & Security </b>
            
            <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
            </div>
           

              <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="abs" type="checkbox" {{ in_array('abs', $key_features) ? 'checked' : '' }} />
        <label class="lbel">ABS</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="lane_change_assist" type="checkbox" {{ in_array('lane_change_assist', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Lane change assist</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="anti_collision_system" type="checkbox" {{ in_array('anti_collision_system', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Anti collision system</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="alarm_system" type="checkbox" {{ in_array('alarm_system', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Alarm system</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="blind_spot_assist" type="checkbox" {{ in_array('blind_spot_assist', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Blind spot assist</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="emergency_brake_assist" type="checkbox" {{ in_array('emergency_brake_assist', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Emergency brake assist</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="remote_central_locking" type="checkbox" {{ in_array('remote_central_locking', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Remote central locking</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="driver_side_airbag" type="checkbox" {{ in_array('driver_side_airbag', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Driver-side airbag</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="immobilizer" type="checkbox" {{ in_array('immobilizer', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Immobilizer</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="isofix" type="checkbox" {{ in_array('isofix', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Isofix</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="lane_departure_warning" type="checkbox" {{ in_array('lane_departure_warning', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Lane departure warning</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="tyre_pressure_monitor" type="checkbox" {{ in_array('tyre_pressure_monitor', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Tyre pressure monitor</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="passenger_side_airbag" type="checkbox" {{ in_array('passenger_side_airbag', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Passenger-side airbag</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="seat_belt_warning" type="checkbox" {{ in_array('seat_belt_warning', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Seat belt warning</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="side_airbag" type="checkbox" {{ in_array('side_airbag', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Side airbag</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="stabilty_control" type="checkbox" {{ in_array('stabilty_control', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Stability control</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="traction_control" type="checkbox" {{ in_array('traction_control', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Traction control</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="emergency_tyre_repair_kit" type="checkbox" {{ in_array('emergency_tyre_repair_kit', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Emergency tyre repair kit</label>
    </div>
</div>

 
   </div>
</div>
</div>    
    
    
    
     <div class="card car_category us_key_feture"  style="display:none;">
<div class="card-body">
<div class="row">
    
     <div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
            <b style="font-size: 20px;">Performance & Handling </b>
            
            <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
            </div>
    
              <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="performance_n_handling[]" value="air_suspension" type="checkbox" {{ in_array('air_suspension', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Air suspension</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="performance_n_handling[]" value="4wd" type="checkbox" {{ in_array('4wd', $key_features) ? 'checked' : '' }} />
        <label class="lbel">4WD</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="performance_n_handling[]" value="sport_suspension" type="checkbox" {{ in_array('sport_suspension', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Sport suspension</label>
    </div>
</div>

    
    </div>
</div>
</div>    
    
       </div>   


<div class="card car_category us_key_feture"  style="display:none;">
        
        <div class="card-body">

        <div class="row">


        <div class="col-lg-12 ">
                    <div class="form-group">
                      <h3>Key Selling Points </h3>
                  
                    </div>
                  </div>



            <div class="col-lg-6">
                        <div class="form-group ">
                            
                            <input  class="chekbox" name="history_checked" value="1" @if($draft_ad == true && $draft_ad->history_checked == '1' ) {{'checked'}} @endif  type="checkbox" onchange="saveDraftData(this , 'history_checked')"  />
                            <label  class="lbel">History checked</label>
                        </div>
                    
            </div>

            <div class="col-lg-6">
                        <div class="form-group ">
                            
                            <input  class="chekbox" name="delivery_available" value="1" type="checkbox" @if($draft_ad == true && $draft_ad->delivery_available == '1' ){{'checked'}}@endif  onchange="saveDraftData(this , 'delivery_available')"  />
                            <label  class="lbel">Delivery available</label>
                        </div>
                   
            </div>


                     <div class="col-lg-6">
                        <div class="form-group ">
                            
                            <label  class="lbel">Warranty Type *</label>

                            <select name="warranty_type" class="form-control"  onclick="checkwarrenty_type(this);" onchange="saveDraftData(this , 'warranty_type')" >
                                <option value="Dealer Warranty"  @if($draft_ad == true && $draft_ad->warranty_type == 'Dealer Warranty' ){{'selected'}}@endif >Dealer Warranty  </option>
                                <option value="Manufacturer Warranty" @if($draft_ad == true && $draft_ad->warranty_type == 'Manufacturer Warranty' ){{'selected'}}@endif>Manufacturer Warranty  </option>
                                <option value="No Warranty" @if($draft_ad == true && $draft_ad->warranty_type == 'No Warranty' ){{'selected'}}@endif >No Warranty  </option>
                            </select>

                        </div>
                    </div>
          

                    <div class="col-lg-6">
                        <div class="form-group ">
                                <label  class="lbel">Warranty Duration *</label>
                                <select name="warranty_duration" id="warranty_duration" class="form-control" onchange="saveDraftData(this , 'warranty_duration')" >
                                <option value="0" @if($draft_ad == true && $draft_ad->warranty_duration == '0' ){{'selected'}}@endif >0 month  </option>
                                    <option value="3 month" @if($draft_ad == true && $draft_ad->warranty_duration == '3 month' ){{'selected'}}@endif >3 month  </option>
                                    <option value="6 month" @if($draft_ad == true && $draft_ad->warranty_duration == '6 month' ){{'selected'}}@endif>6 month  </option>
                                    <option value="9 month" @if($draft_ad == true && $draft_ad->warranty_duration == '9 month' ){{'selected'}}@endif>9 month   </option>

                                    <option value="1 year" @if($draft_ad == true && $draft_ad->warranty_duration == '1 year' ){{'selected'}}@endif>1 year  </option>
                                    <option value="2 year" @if($draft_ad == true && $draft_ad->warranty_duration == '2 year' ){{'selected'}}@endif>2 year  </option>
                                    <option value="3 year" @if($draft_ad == true && $draft_ad->warranty_duration == '3 year' ){{'selected'}}@endif>3 year   </option>

                                    <option value="5 year" @if($draft_ad == true && $draft_ad->warranty_duration == '5 year' ){{'selected'}}@endif>5 year  </option>
                                    <option value="6 year" @if($draft_ad == true && $draft_ad->warranty_duration == '6 year' ){{'selected'}}@endif>6 year  </option>
                                    <option value="7 year" @if($draft_ad == true && $draft_ad->warranty_duration == '7 year' ){{'selected'}}@endif>7 year   </option>

                                    <option value="8 year" @if($draft_ad == true && $draft_ad->warranty_duration == '8 year' ){{'selected'}}@endif >8 year   </option>
                                </select>
                        </div>
                    </div>
            

                </div>

                </div>
                
            </div>
            
            
        

    <div class="card car_category"  style="display:none;">
        
        <div class="card-body">

        <div class="row">


        <div class="col-lg-12 ">
                    <div class="form-group">
                      <h3>Enquiry Preferences </h3>
                  <p>Please select the sales representative responsible for dealing with this listing</p>
                    </div>
                  </div>

                  @php
                    $enquire_persons = \App\Models\EnquiryPreference::where('vendor_id' , Auth::guard('vendor')->user()->id)->get(['id' , 'name' , 'email']);
                  @endphp

                <div class="col-lg-12">
                    
                        <div class="form-group ">
                            <label  class="lbel">Sales Contact *</label>
                                <div class="row">
                                @foreach( $enquire_persons as  $enquire_person)
                                @php
                                // Initialize $checked variable
                                $checked = '';
                                
                                // Check if $draft_ad is set and enquirey_person is not empty
                                if($draft_ad == true && !empty($draft_ad->enquirey_person)) {
                                // Decode the enquirey_person JSON into an array
                                $enquirey_person_ids = json_decode($draft_ad->enquirey_person, true);
                                
                                // Ensure the decoded value is an array
                                if (is_array($enquirey_person_ids)) {
                                // Check if the current enquire_person id is in the decoded array
                                if (in_array($enquire_person->id, $enquirey_person_ids)) {
                                // Set the checkbox to checked if the id is found
                                $checked = 'checked';
                                }
                                }
                                }
                                @endphp
                                  <div class="col-md-3">
                                      <span style="font-size: 16px;font-weight: 700;color: gray;    margin-right: 7px;"> 
                                      {{ucfirst($enquire_person->name)}}
                                  </span>    
                                  
                                    <input type="checkbox" style="zoom: 1.2;position: relative;top: 1px;" value="{{$enquire_person->id}}" {{ $checked }} name="enquirey_person[]" onchange="saveDraftData(this , 'enquirey_person')"  />
                                  
                                  </div>
                                @endforeach
                            </div>
                      </div>
                </div>
                   
            

                </div>

                </div>

    </div>



        
        <div class="card">

        <div class="card-body">
        <div class="row">
                  <div class="col-lg-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <div class="form-check form-check-inline">
    
                            <label class="form-check-label" for="inlineRadio3">Ad Type</label>
                        </div>
                        <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ad_type" id="inlineRadio1"  @if($draft_ad == true && !empty($draft_ad->ad_type) && $draft_ad->ad_type == 'Sale') checked @endif  value="sale" required onchange="saveDraftData(this , 'ad_type')" checked>
                        <label class="form-check-label" for="ad_type">For Sale</label>
                        </div>
                        <div class="form-check form-check-inline">
                       <input class="form-check-input" type="radio" name="ad_type" id="inlineRadio2"  @if($draft_ad == true && !empty($draft_ad->ad_type) && $draft_ad->ad_type == 'Wanted') checked @endif onchange="saveDraftData(this , 'ad_type')" value="Wanted">
                      <label class="form-check-label" for="ad_type">Wanted</label>
                     </div>
                    </div>
                  </div>
                </div>
        <div id="accordion" class="mt-3">
                  @foreach ($languages as $language)
                    <div class="">
                      <div class="version-header" id="heading{{ $language->id }}">
                        <h5 class="mb-0">
                        
                        </h5>
                      </div>

                      <div id="collapse{{ $language->id }}"
                        class="collapse {{ $language->is_default == 1 ? 'show' : '' }}"
                        aria-labelledby="heading{{ $language->id }}" data-parent="#accordion">
                        <div class="version-body">
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                                <label>{{ __('Title') }} *</label>
                                <input type="text" class="form-control" value="@if($draft_ad == true && !empty($draft_ad->ad_title)) {{$draft_ad->ad_title}} @endif" onfocusout="saveDraftData(this , 'ad_title')" name="{{ $language->code }}_title"
                                  placeholder="Enter Title">
                              </div>
                            </div>

                         
                          </div>

                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                                <label>{{ __('Description') }} *</label>
                                <textarea id="{{ $language->code }}_description"  onfocusout="saveDraftData(this , 'ad_description')" class="form-control "
                                  name="{{ $language->code }}_description" data-height="500" style="    height: 200px;">@if($draft_ad == true && !empty($draft_ad->ad_description)){{$draft_ad->ad_description}}@endif</textarea>
                              </div>
                            </div>
                            
                            
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label>{{ __('Price') }} £</label>
                      <input type="number" class="form-control" name="price" value="@if($draft_ad == true && !empty($draft_ad->price)){{$draft_ad->price}}@endif" onfocusout="saveDraftData(this , 'price')" placeholder="Enter  Price">
                    </div>
                  </div> 
                  
                  <div class="col-lg-6" >
                    <div class="form-group">
                      <label>Vat Status </label>
                      <select name="vat_status" id="" class="form-control">
                        <option value="No VAT">No VAT</option>
                         <option value="Yes">Yes</option>
                      </select>
                    </div>
                  </div>
                  
                  <div class="col-lg-6" style="display:none;">
                    <div class="form-group">
                      <label>{{ __('Status') }} *</label>
                      <select name="status" id="" class="form-control">
                        <option value="1">{{ __('Active') }}</option>
                        <option value="0">{{ __('Deactive') }}</option>
                      </select>
                    </div>
                  </div> 
                </div>
                

                      
                          </div>
                          </div>
                         
                          <div class="row">
                            <div class="col">
                              @php $currLang = $language; @endphp

                              @foreach ($languages as $language)
                                @continue($language->id == $currLang->id)

                                <div class="form-check py-0">
                                  <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox"
                                      onchange="cloneInput('collapse{{ $currLang->id }}', 'collapse{{ $language->id }}', event)">
                                    <span class="form-check-sign">{{ __('Clone for') }} <strong
                                        class="text-capitalize text-secondary">{{ $language->name }}</strong>
                                      {{ __('language') }}</span>
                                  </label>
                                </div>
                              @endforeach
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>

        </div>

        </div>




               

            <div class="card">

            <div class="card-body">


            <div class="row pt-20">
            <div class="col-lg-12">
            <div class="row " >
            <div class="col-lg-8 ">
                <div class="form-group">
                <h4>{{ __('Contact Details') }} </h4>
                

                </div>
            </div>
            </div>
            </div>

            </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label>{{ __('Full Name') }}</label>
                      <input type="text" class="form-control" name="full_name" value="{{ $vendor->vendor_info->name }}">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label>{{ __('Email') }}</label>
                      <input type="text" value="{{ $vendor->email }}" class="form-control" name="email" disabled>
                    </div>
                  </div> 
                  <div class="col-lg-6">
                    <label style="margin-left:8px; font-weight: 600;">{{ __('Phone') }}</label>
                    <div class="form-group input-group">
                      
                      <input  type="tel" value="{{ $vendor->phone }}" readonly class="form-control" name="phone" required> 
                      
                      <p id="editErr_phone" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                 
                  <div class="col-lg-6" style="display:none;">
                    <div class="form-group">
                     <label>{{ __('Area') }}</label>
                      <select name="city" id="" class="form-control">
                    <option value="">Please select...</option>
                    @foreach ($countryArea as $area)
                      <option value="{{ $area->slug }}" {{ $area->slug == $vendor->vendor_info->city ? 'selected' : '' }}>{{ $area->name }}</option>
                    @endforeach
                    </select>
                    </div>
                  </div> 
                  
                  
                  <div class="col-lg-3">
                    <div class="form-group">
                        <label style="color:white;display: block;">.</label>
                         <input type="checkbox" required style="zoom: 1.2;position: relative;top: 3px;margin-right: 5px;" checked name="message_center" value="yes">
                      <label>Message Centre </label>
                     
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                        <label style="color:white;display: block;">.</label>
                          <input type="checkbox"  style="zoom: 1.2;position: relative;top: 3px;margin-right: 5px;" checked name="phone_text" value="yes">
                      <label>Phone/Text</label>
                    
                    </div>
                  </div> 
                  
                </div> 
                
             
                <input type="hidden" name="can_car_add" value="1">
                <input type="hidden" id="defaultImg" name="car_cover_image" value="">
                 <input type="hidden" name="rotation_point" id="feature_photo_rotation" value="0">
                <input type="hidden" name="photo_frma" id="photoframe" />
           
            </div>


            
          </div>




    
    <div class="card">
    
    <div class="card-body">
    
    <div class="row">
    
    <div class="col-lg-12 ">
    <div class="form-group">
    <h3>{{ __('Optional YouTube Video') }}  </h3>
    <p>This video will be load after your cover image</p>
    </div>
    </div>
    
    
     <div class="row">
      <div class="col-lg-12 ">
        <div class="form-group">
       
      <input type="text" class="form-control" name="youtube_video"
                      placeholder="Enter youtube Video URL">
        </div>
      </div>
    
    </div>

    </div>
    
    </div>
    
    </div>
    
    
    
</form>

@if(Auth::guard('vendor')->user()->is_trusted  == 1)
    <div class="card car_category"  style="display:none;">
    
    <div class="card-body">
    
    <div class="row">
    
  
    <div class="col-lg-12 ">
        <div class="form-group">
          <h3>Photo Frame </h3>
      <p>This photo will be display as first image on this ad </p>
        </div>
      </div>
        <form id="imageUploadForm" enctype="multipart/form-data">
          <div class="col-lg-12">
                <div class="form-group ">
                        <label  class="lbel">Upload Photo </label>
                        <input type="file" class="form-control" id="image" name="photo_frame" accept="image/*" onchange="uploadImage()" />
                </div>
            </div>
            
            <div class="col-lg-12">
                  <div id="imagePreview"></div>
            </div>
            
        </form>
    </div>
    
    </div>
    
    </div>
    
@endif


    <div class="card">
    
    <div class="card-body">
    
    <div class="row">
    
      <div class="col-lg-12">
        <label for="" class="mb-2"><strong>{{ __('Gallery Images') }} **</strong> <br> <small class="text-danger">load up to 30 images .jpg, .png, & .gif</small></label>
        
                    
               @if($draft_ad == true && !empty($draft_ad->images))
    @php
        $images = json_decode($draft_ad->images, true);
        $items = [];
    @endphp

    @if(count($images) > 0)
        <div class="row">
            <div class="col-12">
                <table class="table table-striped" id="imgtable">
                    @foreach($images as $image)
                        @php
                            $item = \App\Models\Car\CarImage::where('image', $image)->first();
                        @endphp

                        @if($item)
                            @php
                                $items[] = [
                                    'id' => $item->id,
                                    'image' => $item->image,
                                    'rotation_point' => $item->rotation_point,
                                    'priority' => $item->priority,
                                ];
                            @endphp
                        @endif
                    @endforeach

                    @php
                        // Sort items by priority
                        usort($items, function($a, $b) {
                            return $a['priority'] <=> $b['priority'];
                        });
                    @endphp

                    @foreach($items as $item)
                        <tr class="trdb table-row" id="trdb{{ $item['id'] }}" draggable="true" ondragstart="dragStart(event)" ondrop="drop(event)" ondragover="allowDrop(event)">
                            <td>
                                <div class="">
                                    <img class="thumb-preview wf-150"
                                         src="{{ asset('assets/admin/img/car-gallery/' . $item['image']) }}"
                                         id="img_{{$item['id']}}"
                                         alt="Ad Image"
                                         style="height:120px; width:120px; object-fit: cover;transform: rotate({{$item['rotation_point']}}deg);">
                                </div>
                                
                                <div style="text-align: center;margin-bottom: 5px;color: gray;">
                                   Set Cover  <input class='form-check-input' value="{{ $item['id'] }}" onclick="setCoverPhoto({{ $item['id'] }})" type='radio' name='flexRadioDefault' >
                                </div>
                            </td>
                            <td>
                                <i class="fa fa-times" onclick="removethis({{ $item['id'] }})"></i>
                                <i class="fa fa-undo rotatebtndb" onclick="rotatePhoto({{ $item['id'] }})"></i>
                            </td>
                            
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endif
@endif


        <form action="{{ route('car.imagesstore') }}" id="my-dropzone" enctype="multipart/form-data"
          class="dropzone create">
          @csrf
          <div class="fallback">
            <input name="file" type="file" multiple />
          </div>
        </form>
        <p class="em text-danger mb-0" id="errslider_images"></p>
      </div>
    
        </div>
        </div>
    
        </div>
    
        <div class="card-footer">
          <div class="row">
            <div class="col-12 text-center" style="display: flex;justify-content: center;">
               
          <button type="button"  class="btn btn-success" onclick="showAlertForDebit()" id="prmrnt_artBtn"  @if(Auth::guard('vendor')->user()->no_of_ads == 0) style="display:block;" @else style="display:none;"  @endif >
                {{ __('Save') }}
            </button>
            
           <button type="submit" id="CarSubmit" data-can_car_add="{{ $can_car_add }}" class="btn btn-success"  @if(Auth::guard('vendor')->user()->no_of_ads == 0) style="display:none;" @else style="display:block;"  @endif  >
                {{ __('Save') }}
            </button>
                
                
            </div>
          </div>
        </div>
      </div>
    
    </div>
    </div>
    
    </div>
    </div>
    </div>
    </div>
  
  


  <div class="modal fade" id="draftModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-body">
          
          <h5>
               <i class="fa fa-info-circle" aria-hidden="true" style="color: #367ede;font-size: 25px;"></i> 
               <span style="position: relative;bottom: 3px;font-size: 17px;left: 5px;color:#585858;">
                   You have a draft ad
               </span>
               
                <a href="javascript:void(0);" class="btn btn-success"  onclick="hidePanel()" style="background: white !important;
                color: black;
                text-align: right;
                float: right;
                height: 0px;
                position: relative;
                bottom: 5px;
                padding-right: 0px;">
                <i class="fa fa-times" style="font-size: 18px;color:#585858;" aria-hidden="true"></i>
                </a>
      
      
          </h5>
          
          <div style="margin-bottom: 1rem;margin-top: 1rem;color:gray">
              We've saved some details from the last time you started placing as ad.
          </div>
          
         <div style="display:flex;">
              <button type="button" class="btn btn-secondary" style="    padding: 5px;
    margin-right: 5px;
    width: 100%;
    color: black;
    background: white !important;
    border: 1px solid #000000 !important;
    font-size: 11px;" onclick="deletDarftAd()"> Start new ad</button>
                <button type="button" class="btn btn-primary" style="    padding: 5px;
    margin-left: 5px;
    width: 100%;
    font-size: 11px;" onclick="hidePanel()">Continue ad</button>
         </div>
        
        
      </div>
      
    </div>
  </div>
</div>


 
@endsection
@php
  $languages = App\Models\Language::get();
  $labels = '';
  $values = '';
  foreach ($languages as $language) {
      $label_name = $language->code . '_label[]';
      $value_name = $language->code . '_value[]';
      if ($language->direction == 1) {
          $direction = 'form-group rtl text-right';
      } else {
          $direction = 'form-group';
      }
  
      $labels .= "<div class='$direction'><input type='text' name='" . $label_name . "' class='form-control' placeholder='Label ($language->name)'></div>";
      $values .= "<div class='$direction'><input type='text' name='$value_name' class='form-control' placeholder='Value ($language->name)'></div>";
  }
@endphp

@section('script')


@if($draft_ad == true)

<script>

function hidePanel()
{
    $('#draftModal').remove();
    
    $('body').css('overflow', 'auto');
    
    $('body').css('padding', '0px');
    
    $('.modal-backdrop.fade.show').remove()
}


$(document).ready(function(){
    // Show the modal on page load
    $('#draftModal').modal('show');

    // Prevent modal from closing when clicking outside or pressing Esc key
    $('#draftModal').on('hide.bs.modal', function(event) {
        event.preventDefault();
        event.stopPropagation();
    });
    
    @if($draft_ad == true && !empty($draft_ad->category_id))
        var selectedOption = "{{ $draft_ad->category_id }}";
        $('#adsMaincat').val(selectedOption);
        $('#adsMaincat').change()
    @endif
    
});

</script>
@endif



{{-- dropzone css --}}
<link rel="stylesheet" href="{{ asset('assets/css/dropzone.min.css') }}">

{{-- atlantis css --}}

{{-- select2 css --}}
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/front/css/pages/inner-pages.css') }}">
{{-- admin-main css --}}
<link rel="stylesheet" href="{{ asset('assets/css/admin-main.css') }}">
<style type="">
    .chekbox
    {
        zoom:2;
    }
    .car_category .us_hide_by_default
    {
        display:none;
    }
    .rotatebtndb
{
     
    top: 30px !important;
   
    color: #004eabd6 !important;
   
    cursor: pointer !important;
}
    .lbel
    {
        position: relative;
        bottom: 9px;
        font-weight: 500 !important;
        margin-left: 5px;
    }

  #carForm .form-control {
    display: block;
    width: 100%;
    /*height: calc(1.5em + .75rem + 2px);*/
    padding: .375rem .75rem;
    font-size: 14px !important;
    font-weight: 400;
    line-height: 1.5 !important;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out
}
 #carForm .btn-secondary{
  line-height: 13px !important;
 }
 .customRadio{
  width: 1.2em !important;
    height: 1.2em !important;
    border-color:#b1b1b1 !important;
    margin-right:4px !important;
 }
 .customRadiolabel{
  margin-top:3px !important;
  font-size: 14px;
  font-weight: 600;
 }
 
 button.rotate-btn {
    font-size: 12px;
    position: absolute;
    top: 40px;
    right: 10px;
    z-index: 30;
    border-radius: 5px;
    background-color: #004eabd6;
    color: #fff;
    outline: 0;
    border: none;
    cursor: pointer !important;
}

</style>
<script>

    function openClosestBox(self)
    {
        $(self).closest('.car_category').find('.us_hide_by_default').toggle()
    }
    
    function removeFeatureImg(self)
    {
        $(self).closest('#imagePreview').html('');
    }
    
    
          var rotationAngle1 = 0;
    
    function rotatePhoto(id) 
{
    // Find the image element within the file preview element
    var imageElement = $('#img_'+id);
    
    
    if (imageElement.length) {
        // Increment the rotation angle by 90 degrees
        rotationAngle1 += 90;
    
        // Apply the rotation to the image element
        imageElement.css('transform', 'rotate(' + rotationAngle1 + 'deg)');
    
        // Reset rotation to 0 if it reaches 360 degrees
        if (rotationAngle1 === 360) {
            rotationAngle1 = 0;
        }
        
        rotationSave(id, rotationAngle1);
    }
    
    return false;
}

    
     function rotationSave(fileid , rotationEvnt)
    {
        var requestMethid = "POST";
        
        if($('#request_method').val() != '')
        {
           var requestMethid = "GET"; 
        }
        
           $.ajax({
          url: '/vendor/car-management/img-db-rotate',
          type: requestMethid,
          data: {
            fileid: fileid , rotationEvnt:rotationEvnt
          },
          success: function (data) 
          {
           
          }
        }); 
    }
    
    function removethis(fileid) 
    {
        $.ajax({
          url: removeUrl,
          type: 'POST',
          data: {
            fileid: fileid
          },
          success: function (data) {
            $("#slider" + fileid).remove();
            $('#trdb'+fileid).remove()
          }
        });
    }
    
    
    function uploadImage() {
        var formData = new FormData($('#imageUploadForm')[0]);
        var fileInput = document.getElementById('image');

        formData.append('photo_frame', fileInput.files[0]);
    
        $('#CarSubmit').prop('disabled' , true);
        
        // Display image preview (you can customize this part)
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').html('<img src="' + e.target.result + '" alt="Image Preview"  id="previewImg"  style="max-width: 200px; max-height: 200px;"><i class="fa fa-undo rotatebtndb" style="position: relative;top: -40px !important;right: 15px;background: white;padding: 5px;border-radius: 50%;" onclick="rotateFeatureImg()" title="rotate" ></i> <i class="fa fa-times " style="position: relative;top: -65px !important;right: 40px;background: white;padding: 5px;border-radius: 50%;" onclick="removeFeatureImg(this)" title="remove" ></i>');
        };
        reader.readAsDataURL(fileInput.files[0]);

        // Perform AJAX request to upload the image
        $.ajax({
            type: 'POST',
            url: "{{ route('vendor.frame.image') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) 
            {
                $('#photoframe').val(response.image_path)
                $('#CarSubmit').prop('disabled' , false);
         
            },
            error: function(error) 
            {
                // Handle the error response, e.g., display an error message
                console.log(error);
            }
        });
    }
    
    
    var rotationAnglef = 0;

 
    function closeModal()
    {
         $('#vintageYearAlertModal').modal('hide')
    }
    
    
function rotateFeatureImg()
{
    // Find the image element within the file preview element
    var imageElement = $('#previewImg');
    
    
    if (imageElement.length) {
        // Increment the rotation angle by 90 degrees
        rotationAnglef += 90;
    
        // Apply the rotation to the image element
        imageElement.css('transform', 'rotate(' + rotationAnglef + 'deg)');
    
        // Reset rotation to 0 if it reaches 360 degrees
        if (rotationAnglef === 360) {
            rotationAnglef = 0;
        }
        
        $('#feature_photo_rotation').val(rotationAnglef);
    }
    
    return false; 
}



    function checkwarrenty_type(self)
    {
    if($(self).val() == 'No Warranty')
    {
       $('#warranty_duration').val('0').change();
       $('#warranty_duration').prop('disabled' , true);
    }
    else
    {
         $('#warranty_duration').prop('disabled' , false);
    }
    }
    
    
    function checkIfVhecleCat(self) 
    {
       var selectedCategory = $(self).find('option:selected').text();
        var searchWord = "car";
        console.log(selectedCategory)
        if (selectedCategory.toLowerCase().includes(searchWord.toLowerCase())) 
        {
             $('.car_category').show();
            $('.us_car_features .col-lg-4').show();
        } 
        else 
        {
            $('.car_category').hide();
             $('.us_car_features .col-lg-4').hide();
        }
    }

    $(document).ready(function() 
    {
        // Specify the word to search for in options
        var searchWord = "car";

        // Iterate through each option and check if it contains the search word
        $('#adsMaincat option').each(function() 
        {
            if ($(this).text().toLowerCase().includes(searchWord.toLowerCase())) 
            {
                
                $(this).prop('selected', true);
                $(this).change()
                $('.car_category').show();
                $('.us_car_features .col-lg-4').show();
            }
        });
    });

function getModel(self)
    {
        var make = $(self).val();

        // Make an Ajax request to get car models
            $.ajax({
                type: 'GET',
                url: '{{ route('getmodel') }}',
                data:{'make' : make},
                success: function(data) {
                    // Populate car models dropdown with the received data
                    $('#carModel').html('');
                    $.each(data, function(index, model) {
                        $('#carModel').append('<option value="' + model.id + '">' + model.name + '</option>');
                    });

                    // Enable the car models dropdown
                    $('#carModel').prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching car models: ' + status);
                }
            });
    }



  'use strict';

  const baseUrl = "{{ url('/') }}";
</script>

{{-- core js files --}}



{{-- jQuery ui --}}
<script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.ui.touch-punch.min.js') }}"></script>

{{-- jQuery time-picker --}}
<script type="text/javascript" src="{{ asset('assets/js/jquery.timepicker.min.js') }}"></script>

{{-- jQuery scrollbar --}}
<script type="text/javascript" src="{{ asset('assets/js/jquery.scrollbar.min.js') }}"></script>

{{-- bootstrap notify --}}
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-notify.min.js') }}"></script>

{{-- sweet alert --}}
<script type="text/javascript" src="{{ asset('assets/js/sweet-alert.min.js') }}"></script>

{{-- bootstrap tags input --}}
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-tagsinput.min.js') }}"></script>

{{-- bootstrap date-picker --}}
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
{{-- js color --}}
<script type="text/javascript" src="{{ asset('assets/js/jscolor.min.js') }}"></script>

{{-- fontawesome icon picker js --}}
<script type="text/javascript" src="{{ asset('assets/js/fontawesome-iconpicker.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/js/tinymce/js/tinymce/tinymce.min.js') }}"></script>

{{-- datatables js --}}
<script type="text/javascript" src="{{ asset('assets/js/datatables-1.10.23.min.js') }}"></script>

{{-- datatables bootstrap js --}}
<script type="text/javascript" src="{{ asset('assets/js/datatables.bootstrap4.min.js') }}"></script>


{{-- dropzone js --}}
<script type="text/javascript" src="{{ asset('assets/js/dropzone.min.js') }}"></script>

{{-- atlantis js --}}
<script type="text/javascript" src="{{ asset('assets/js/atlantis.js') }}"></script>

{{-- fonts and icons script --}}
<script type="text/javascript" src="{{ asset('assets/js/webfont.min.js') }}"></script>

<!-- @if (session()->has('success'))
  <script>
    'use strict';
    var content = {};

    content.message = '{{ session('success') }}';
    content.title = 'Success';
    content.icon = 'fa fa-bell';

    $.notify(content, {
      type: 'success',
      placement: {
        from: 'top',
        align: 'right'
      },
      showProgressbar: true,
      time: 1000,
      delay: 4000
    });
  </script>
@endif -->

@if (session()->has('warning'))
  <script>
    'use strict';
    var content = {};

    content.message = '{{ session('warning') }}';
    content.title = 'Warning!';
    content.icon = 'fa fa-bell';

    $.notify(content, {
      type: 'warning',
      placement: {
        from: 'top',
        align: 'right'
      },
      showProgressbar: true,
      time: 1000,
      delay: 4000
    });
    
  </script>
@endif



{{-- select2 js --}}
<script type="text/javascript" src="{{ asset('assets/js/select2.min.js') }}"></script>

{{-- admin-main js --}}
<script type="text/javascript" src="{{ asset('assets/js/admin-main.js') }}"></script>

  <script>
    'use strict';
    var storeUrl = "{{ route('car.imagesstore') }}";
    var removeUrl = "{{ route('user.car.imagermv') }}";
    var getBrandUrl = "{{ route('user.get-car.brand.model') }}";
    const account_status = "{{ Auth::guard('vendor')->user()->status }}";
    const secret_login = "{{ Session::get('secret_login') }}";
  </script>

  <script src="{{ asset('assets/js/car.js?v=0.1') }}"></script>
  <script>
    var labels = "{!! $labels !!}";
    var values = "{!! $values !!}";
  </script>
   <script type="text/javascript" src="{{ asset('assets/js/admin-partial.js?v=0.2') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/admin-dropzone.js?v=0.92') }}"></script>
@endsection
