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
<div class="user-dashboard pt-20 pb-60 us_top">
    <div class="container">



  <div class="row gx-xl-5">

       @includeIf('vendors.partials.side-custom')
  <div class="col-md-9">


  @php
    $current_package = App\Http\Helpers\VendorPermissionHelper::packagePermission(Auth::guard('vendor')->user()->id);
   //echo "<pre>"; print_r($countryArea);
  @endphp

  <div class="row ">
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
       <div class="alert alert-danger text-dark" id="error_list" style="display:none;"> </div>


        <form  id="myForm"  method="POST" enctype="multipart/form-data">
            @csrf

            <div id="sliders"></div>


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
                          class="form-control " onchange="checkIfVhecleCat(this)" id="adsMaincats">
                          <option selected disabled>{{ __('Select a Category') }}</option>

                          @foreach ($categories as $category)
                            <option value="{{ $category->id }}" <?= ($car->car_content->main_category_id === $category->id) ? 'selected' : '' ?> >{{ $category->name }} </option>
                          @endforeach
                        </select>
                      </div>
                    </div>


                    <div class="col-lg-6 ">


                    <div class="form-group">
                    <label>{{ __('Subsection') }} *</label>
                        <select disabled name="en_category_id" class="form-control  subhidden" onchange="hideFuelIf(this)"  id="adsSubcat">
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
                    </div>
                  </div>

                </div>


            <div class="row us_car_features" >

              <div class="col-lg-2">
                <div class="form-group">
                  <label id="labael_new"> New </label>
                  &nbsp;&nbsp; <input type="radio"  name="what_type" value="brand_new" onchange="hide_owner_if_new(this)"  <?= ($car->what_type == 'brand_new') ? 'checked' : ''  ?>  id="what_type" >
                </div>
              </div>

              <div class="col-lg-2">
                <div class="form-group">
                  <label id="labael_used">Used </label>
                  &nbsp;&nbsp; <input type="radio"   name="what_type" value="used" onchange="hide_owner_if_new(this)" <?= ($car->what_type == 'used') ? 'checked' : ''  ?>  id="what_type" >
                </div>
              </div>

              <div class="col-lg-8"></div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                    <div class="form-group">
                      <label>Enter vehicle registration *</label>
                      <div style="display:flex;">
                      <input type="text" class="form-control validateTextBoxs" value="{{$car->vregNo}}" name="vehicle_reg" style="border-top-right-radius:0px;border-bottom-right-radius:0px;" placeholder="Enter vehicle registration" id="vehicle_reg" >
                      <button class="btn btn-sm btn-success" type="button" onclick="getVehicleData(this)" style="border-top-left-radius:0px;border-bottom-left-radius:0px;"><i class="fa fa-search" aria-hidden="true"></i></button>
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
                                  class="form-control  validateTextBoxs" onchange="getModel(this)" id="make" data-code="en">
                                  <option value="" >{{ __('Select make') }}</option>
                                  <option disabled>-- Popular Brands --</option>
                                  @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"   <?= ($car->car_content->brand->id === $brand->id) ? 'selected' : '' ?>   >{{ $brand->name }}</option>
                                  @endforeach
                                  <option disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-- Other Brands --</option>
                                  @foreach ($otherBrands as $brand)
                                    <option value="{{ $brand->id }}"   <?= ($car->car_content->brand->id === $brand->id) ? 'selected' : '' ?>   >{{ $brand->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                              <div class="form-group">

                                <label>{{ __('Model') }} *</label>
                                <select name="en_car_model_id"
                                  class="form-control validateTextBoxs en_car_brand_model_id"   id="carModel">

                                </select>
                              </div>
                            </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                    <div class="form-group">
                      <label>{{ __('Year') }} *</label>
                      <input type="text" class="form-control validateTextBoxs" value="{{ $car->year }}" oninput="checkYearAgo(this)"  name="year" placeholder="Enter Year" id="carYear" >
                    </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                              <div class="form-group">
                                @php
                                  $fuel_types = App\Models\Car\FuelType::where('status', 1)
                                      ->get();
                                @endphp

                                <label>{{ __('Fuel Type') }} *</label>
                                <select name="en_fuel_type_id" id="fuelType" onchange="changeVal()"  class="form-control validateTextBoxs" >
                                  <option value="" >{{ __('Select') }}</option>

                                  @foreach ($fuel_types as $fuel_type)
                                    <option value="{{ $fuel_type->id }}" <?= ($car->car_content->fuel_type_id === $fuel_type->id) ? 'selected' : '' ?>   @if( ($car->car_content->category_id == 48 || $car->car_content->category_id == 62) && $fuel_type->name == 'Diesel')
                                     class="hidden-option"
                                     @endif  >{{ $fuel_type->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>


                  <div class="col-xl-6 col-lg-6 col-md-6 col-12 " id="new_engine_caacity">
                    <div class="form-group">
                      <label>
                           Engine Size

                       @if($car->car_content->category_id == 48 || $car->car_content->category_id == 62 )
                       (cc)
                       @elseif($car->car_content->fuel_type_id  == 14 || $car->car_content->fuel_type_id  == 15)
                      (Liter)
                      @else
                      (KW)
                      @endif
                      *</label>
                      <input type="text" class="form-control validateTextBoxs" value="{{ $car->engineCapacity }}" name="engineCapacity" placeholder="Enter Size" id="EngineCapacity" >
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
                                <select name="en_transmission_type_id" class="form-control validateTextBoxs" id="transmissionType">
                                 <option value="" >{{ __('Select') }}</option>

                                  @foreach ($transmission_types as $transmission_type)
                                    <option value="{{ $transmission_type->id }}"  <?= ($car->car_content->transmission_type_id === $transmission_type->id) ? 'selected' : '' ?>   >{{ $transmission_type->name }}
                                    </option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                    <div class="form-group">
                      <label>{{ __('Body Type') }} *</label>
                      <select name="BodyType" id="bodyType" class="form-control validateTextBoxs">
                        <option value="">Please select..</option>
                        <option value="8"  <?= ($car->car_content->body_type_id === 8) ? 'selected' : '' ?>   >Convertible</option>
                        <option value="14" <?= ($car->car_content->body_type_id === 14) ? 'selected' : '' ?>>Coupe</option>
                        <option value="15" <?= ($car->car_content->body_type_id === 15) ? 'selected' : '' ?>>Saloon</option>
                        <option value="9" <?= ($car->car_content->body_type_id ===   9) ? 'selected' : '' ?>>Hatchback</option>
                        <option value="16" <?= ($car->car_content->body_type_id === 16) ? 'selected' : '' ?>>Estate</option>
                        <option value="17" <?= ($car->car_content->body_type_id === 17) ? 'selected' : '' ?>>MPV</option>
                        <option value="18" <?= ($car->car_content->body_type_id === 18) ? 'selected' : '' ?>>SUV</option>
                        <option value="19" <?= ($car->car_content->body_type_id === 19) ? 'selected' : '' ?>>Van</option>
                        <option value="20" <?= ($car->car_content->body_type_id === 20) ? 'selected' : '' ?> >Pick Up</option>
                      </select>
                    </div>
                  </div>
                   <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                    <div class="form-group">
                   <label>{{ __('Doors') }} *</label>
                   <select name="doors" class="form-control validateTextBoxs" id="carDoors" required>
                    <option value="">Please select...</option>
                    <option value="2"  <?= ($car->doors === 2) ? 'selected' : '' ?>  >2</option>
                    <option value="3" <?= ($car->doors === 3) ? 'selected' : '' ?>>3</option>
                    <option value="4" <?= ($car->doors === 4) ? 'selected' : '' ?>>4</option>
                    <option value="5" <?= ($car->doors === 5) ? 'selected' : '' ?>>5</option>
                    <option value="6" <?= ($car->doors === 6) ? 'selected' : '' ?>>6</option>
                    <option value="7" <?= ($car->doors === 7) ? 'selected' : '' ?>>7</option>
                    <option value="8" <?= ($car->doors === 8) ? 'selected' : '' ?> >8</option>
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
                                <select name="en_car_color_id" class="form-control validateTextBoxs" id="carColour">
                                  <option value="">{{ __('Select Colour') }}</option>

                                  @foreach ($colour as $colour)
                                    <option value="{{ $colour->id }}"  <?= ($car->car_content->car_color_id === $colour->id) ? 'selected' : '' ?>  >{{ $colour->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>

                  <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                    <div class="form-group">
                   <label>{{ __('Seats') }} *</label>
                    <select name="seats" id="carSeats" class="form-control validateTextBoxs">
                    <option value="">Please select...</option>
                    <option value="2"  <?= ($car->seats === 2) ? 'selected' : '' ?>>2</option>
                    <option value="3" <?= ($car->seats === 3) ? 'selected' : '' ?>>3</option>
                    <option value="4" <?= ($car->seats === 4) ? 'selected' : '' ?>>4</option>
                    <option value="5" <?= ($car->seats === 5) ? 'selected' : '' ?>>5</option>
                    <option value="6" <?= ($car->seats === 6) ? 'selected' : '' ?>>6</option>
                    <option value="7" <?= ($car->seats === 7) ? 'selected' : '' ?>>7</option>
                    <option value="8" <?= ($car->seats === 8) ? 'selected' : '' ?>>8</option>
                    </select>
                    </div>
                  </div>

                  <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                    <div class="form-group">
                      <label>{{ __('Add your mileage') }} (M) *</label>
                      <input type="number" class="form-control validateTextBoxs" value="{{$car->mileage}}" name="mileage" id="Mileage" placeholder="Enter Mileage">
                    </div>
                  </div>

                  <div class="col-xl-6 col-lg-6 col-md-6 col-12 " @if($car->what_type == 'brand_new') style="display:none;" @endif id="ownerParentDiv">
                        <div class="form-group">
                            <label>{{ __('Number of Owners') }} *</label>
                            <select name="number_of_owners" id="" class="form-control validateTextBoxs">
                                <option value="1" <?= ($car->number_of_owners === 1) ? 'selected' : '' ?>  >1</option>
                                <option value="2" <?= ($car->number_of_owners === 2) ? 'selected' : '' ?> >2</option>
                                <option value="3" <?= ($car->number_of_owners === 3) ? 'selected' : '' ?> >3</option>
                                <option value="4" <?= ($car->number_of_owners === 4) ? 'selected' : '' ?> >4</option>
                                <option value="5" <?= ($car->number_of_owners === 5) ? 'selected' : '' ?> >5</option>
                                <option value="6" <?= ($car->number_of_owners === 6) ? 'selected' : '' ?> >6</option>
                                <option value="7" <?= ($car->number_of_owners === 7) ? 'selected' : '' ?>  >7</option>
                            </select>
                        </div>
                  </div>


                 <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                <div class="form-group">
                  <label>Annual Road Tax </label>
                  <input type="number" class="form-control validateTextBoxs" value="{{$car->road_tax}}" name="annual_road_tax" placeholder="Enter Annual Road Tax" id="carRoadTax" >
                </div>
                </div>


                 <input type="hidden" value="{{$car->current_area_regis}}" name="current_area_regis" />



                  <div class="col-lg-12">
                    <div class="form-group">
                     <hr>
                    </div>
                  </div>

                   <div class="col-2"  style="width: 130px;">
                    <div class="form-group" style="padding-left: 0px;padding-right: 0px;">
                      <label style="    font-size: 18px !important;">Sale </label>
                      &nbsp;&nbsp; <input type="checkbox" style="zoom: 1.3;position: relative;top: 1px;"  {{  $car->is_sale == 1 ? 'checked' : '' }}  name="is_sale" value="1"  id="sale" >
                    </div>
                  </div>

                    <div class="col-2"  style="width: 130px;">
                    <div class="form-group" style="padding-left: 0px;padding-right: 0px;">
                      <label style="    font-size: 18px !important;" id="labael_sold">Sold </label>
                      &nbsp;&nbsp; <input type="checkbox"  style="zoom: 1.3;position: relative;top: 1px;" {{  $car->is_sold == 1 ? 'checked' : '' }}  name="is_sold" value="1"  id="sold" >
                    </div>
                  </div>

                  <div class="col">
                    <div class="form-group">
                      <label style="    font-size: 18px !important;" id="labael_reduced_price">Reduced Price </label>
                      &nbsp;&nbsp; <input type="checkbox" style="zoom: 1.3;position: relative;top: 1px;"  {{  $car->reduce_price == 1 ? 'checked' : '' }} name="reduce_price" value="1"   id="reduce_price" >
                    </div>
                  </div>

                  <div class="col">
                    <div class="form-group" style="padding-left: 0px;padding-right: 0px;">
                      <label style="    font-size: 18px !important;" id="labael_manager_special">Manager special</label>
                      &nbsp;&nbsp; <input type="checkbox"  style="zoom: 1.3;position: relative;top: 1px;" {{  $car->manager_special == 1 ? 'checked' : '' }}  name="manager_special"  value="1"  id="manager_special" >
                    </div>
                  </div>

                  <div class="col">
                    <div class="form-group">
                      <label style="    font-size: 18px !important;">Deposit  Taken </label>
                      &nbsp;&nbsp; <input type="checkbox"  style="zoom: 1.3;position: relative;top: 1px;" {{  $car->deposit_taken == 1 ? 'checked' : '' }}  name="deposit_taken"  value="1"  id="deposit_taken" >
                    </div>
                  </div>

                </div>
        </div>
 </div>


        <div class="card car_category"  style="display:none;">

        <div class="card-body">
        <div class="row">

                <div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
                    <b style="font-size: 20px;">Comfort & Convenience </b>

                    <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
                </div>


<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="comfort_n_convenience[]" value="air_conditioning" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'comfort_n_convenience', 'value' => 'air_conditioning'], $vehicle_features); ?> type="checkbox" />
        <label class="lbel">Air Conditioning</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="comfort_n_convenience[]" value="climate_control" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'comfort_n_convenience', 'value' => 'climate_control'], $vehicle_features); ?> type="checkbox" />
        <label class="lbel">Climate control</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="comfort_n_convenience[]" value="dual_zone_climate_control" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'comfort_n_convenience', 'value' => 'dual_zone_climate_control'], $vehicle_features); ?> type="checkbox" />
        <label class="lbel">Dual zone climate control</label>
    </div>
</div>


<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group ">
         <input class="chekbox" name="seat_n_vantilation[]" value="seat_vantilation" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'seat_n_vantilation', 'value' => 'seat_vantilation'], $vehicle_features); ?>  />
         <label class="lbel">Seat Ventilation</label>
    </div>
</div>


 <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group ">
         <input class="chekbox" name="electric_n_handbrake[]" value="electric_handbrake" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'electric_n_handbrake', 'value' => 'electric_handbrake'], $vehicle_features); ?> />
         <label class="lbel">Electric Handbrake</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="comfort_n_convenience[]" value="multi_zone_climate_control" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'comfort_n_convenience', 'value' => 'multi_zone_climate_control'], $vehicle_features); ?> type="checkbox" />
        <label class="lbel">Multi zone climate control</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="comfort_n_convenience[]" value="armrest" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'comfort_n_convenience', 'value' => 'armrest'], $vehicle_features); ?> type="checkbox" />
        <label class="lbel">Armrest</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="comfort_n_convenience[]" value="keyless_entry" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'comfort_n_convenience', 'value' => 'keyless_entry'], $vehicle_features); ?> type="checkbox" />
        <label class="lbel">Keyless Entry</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="comfort_n_convenience[]" value="electrically_adjustable_seats" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'comfort_n_convenience', 'value' => 'electrically_adjustable_seats'], $vehicle_features); ?> type="checkbox" />
        <label class="lbel">Electrically adjustable seats</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="comfort_n_convenience[]" value="heated_windshield" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'comfort_n_convenience', 'value' => 'heated_windshield'], $vehicle_features); ?> type="checkbox" />
        <label class="lbel">Heated Windshield</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="comfort_n_convenience[]" value="electric_boot" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'comfort_n_convenience', 'value' => 'electric_boot'], $vehicle_features); ?> type="checkbox" />
        <label class="lbel">Electric boot</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="comfort_n_convenience[]" value="electric_side_mirrors" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'comfort_n_convenience', 'value' => 'electric_side_mirrors'], $vehicle_features); ?> type="checkbox" />
        <label class="lbel">Electric side mirrors</label>
    </div>
</div>



<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="comfort_n_convenience[]" value="heated_seats" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'comfort_n_convenience', 'value' => 'heated_seats'], $vehicle_features); ?> type="checkbox" />
        <label class="lbel">Heated seats</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="comfort_n_convenience[]" value="heated_steering_wheel" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'comfort_n_convenience', 'value' => 'heated_steering_wheel'], $vehicle_features); ?> type="checkbox" />
        <label class="lbel">Heated steering wheel</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="comfort_n_convenience[]" value="lumbar_support" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'comfort_n_convenience', 'value' => 'lumbar_support'], $vehicle_features); ?> type="checkbox" />
        <label class="lbel">Lumbar support</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="comfort_n_convenience[]" value="massage_seats" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'comfort_n_convenience', 'value' => 'massage_seats'], $vehicle_features); ?> type="checkbox" />
        <label class="lbel">Massage seats</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="comfort_n_convenience[]" value="multi_func_steering_wheel" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'comfort_n_convenience', 'value' => 'multi_func_steering_wheel'], $vehicle_features); ?> type="checkbox" />
        <label class="lbel">Multi function steering wheel</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="comfort_n_convenience[]" value="rain_sensor" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'comfort_n_convenience', 'value' => 'rain_sensor'], $vehicle_features); ?> type="checkbox" />
        <label class="lbel">Rain sensor</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="comfort_n_convenience[]" value="spare_tyre" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'comfort_n_convenience', 'value' => 'spare_tyre'], $vehicle_features); ?> type="checkbox" />
        <label class="lbel">Spare tyre</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="comfort_n_convenience[]" value="electric_windows" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'comfort_n_convenience', 'value' => 'electric_windows'], $vehicle_features); ?> type="checkbox" />
        <label class="lbel">Electric windows</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="comfort_n_convenience[]" value="gear_shift_paddles" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'comfort_n_convenience', 'value' => 'gear_shift_paddles'], $vehicle_features); ?> type="checkbox" />
        <label class="lbel">Gear Shift Paddles</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="comfort_n_convenience[]" value="split_rear_seats" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'comfort_n_convenience', 'value' => 'split_rear_seats'], $vehicle_features); ?> type="checkbox" />
        <label class="lbel">Split rear seats</label>
    </div>
</div>


  </div>
</div>

  </div>



  <div class="card car_category"  style="display:none;">
<div class="card-body">
<div class="row">


                 <div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
                    <b style="font-size: 20px;">Media & Conectivity </b>

                    <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
                </div>


              <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="andriod_auto" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'media_n_conectivity', 'value' => 'andriod_auto'], $vehicle_features); ?> />
        <label class="lbel">Android Auto</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="apple_carplay" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'media_n_conectivity', 'value' => 'apple_carplay'], $vehicle_features); ?> />
        <label class="lbel">Apple Carplay</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="bluetooth" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'media_n_conectivity', 'value' => 'bluetooth'], $vehicle_features); ?> />
        <label class="lbel">Bluetooth</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="cd" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'media_n_conectivity', 'value' => 'cd'], $vehicle_features); ?> />
        <label class="lbel">CD</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="mp3_compatitble" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'media_n_conectivity', 'value' => 'mp3_compatitble'], $vehicle_features); ?> />
        <label class="lbel">MP3 Compatible</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="12v_power_outlet" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'media_n_conectivity', 'value' => '12v_power_outlet'], $vehicle_features); ?> />
        <label class="lbel">12V Power Outlet</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="radio" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'media_n_conectivity', 'value' => 'radio'], $vehicle_features); ?> />
        <label class="lbel">Radio</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="touch_screen_display" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'media_n_conectivity', 'value' => 'touch_screen_display'], $vehicle_features); ?> />
        <label class="lbel">Touch Screen Display</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="usb_connection" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'media_n_conectivity', 'value' => 'usb_connection'], $vehicle_features); ?> />
        <label class="lbel">USB Connection (Front)</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="usb_connection_rear" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'media_n_conectivity', 'value' => 'usb_connection_rear'], $vehicle_features); ?> />
        <label class="lbel">USB Connection (Rear)</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="wifi" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'media_n_conectivity', 'value' => 'wifi'], $vehicle_features); ?> />
        <label class="lbel">WiFi</label>
    </div>
</div>


    </div>
</div>

  </div>



   <div class="card car_category"  style="display:none;">
<div class="card-body">
<div class="row">

            <div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
                <b style="font-size: 20px;">Assistance & Utility </b>

                <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
            </div>


      <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="adaptive_cruise_control" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'assistance_n_utility', 'value' => 'adaptive_cruise_control'], $vehicle_features); ?> />
        <label class="lbel">Adaptive Cruise Control</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="cruise_control" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'assistance_n_utility', 'value' => 'cruise_control'], $vehicle_features); ?> />
        <label class="lbel">Cruise Control</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="hill_hold_assist" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'assistance_n_utility', 'value' => 'hill_hold_assist'], $vehicle_features); ?> />
        <label class="lbel">Hill Hold Assist</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="navigation_system" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'assistance_n_utility', 'value' => 'navigation_system'], $vehicle_features); ?> />
        <label class="lbel">Navigation System</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="self_steering_parking" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'assistance_n_utility', 'value' => 'self_steering_parking'], $vehicle_features); ?> />
        <label class="lbel">Self-steering Parking</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="parking_camera" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'assistance_n_utility', 'value' => 'parking_camera'], $vehicle_features); ?> />
        <label class="lbel">Parking Camera</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="front_parking_sensor" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'assistance_n_utility', 'value' => 'front_parking_sensor'], $vehicle_features); ?> />
        <label class="lbel">Front Parking Sensor</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="rear_parking_sensor" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'assistance_n_utility', 'value' => 'rear_parking_sensor'], $vehicle_features); ?> />
        <label class="lbel">Rear Parking Sensor</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="remote_boot_release" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'assistance_n_utility', 'value' => 'remote_boot_release'], $vehicle_features); ?> />
        <label class="lbel">Remote Boot Release</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="roof_rails" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'assistance_n_utility', 'value' => 'roof_rails'], $vehicle_features); ?> />
        <label class="lbel">Roof Rails</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="speed_limiter" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'assistance_n_utility', 'value' => 'speed_limiter'], $vehicle_features); ?> />
        <label class="lbel">Speed Limiter</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="start_stop_system" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'assistance_n_utility', 'value' => 'start_stop_system'], $vehicle_features); ?> />
        <label class="lbel">Start-stop System</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="traffic_sign_recognition" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'assistance_n_utility', 'value' => 'traffic_sign_recognition'], $vehicle_features); ?> />
        <label class="lbel">Traffic Sign Recognition</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="trailer_hitch" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'assistance_n_utility', 'value' => 'trailer_hitch'], $vehicle_features); ?> />
        <label class="lbel">Trailer Hitch</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="voice_control" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'assistance_n_utility', 'value' => 'voice_control'], $vehicle_features); ?> />
        <label class="lbel">Voice Control</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="parking_assistance" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'assistance_n_utility', 'value' => 'parking_assistance'], $vehicle_features); ?> />
        <label class="lbel">Parking Assistance</label>
    </div>
</div>


</div>
</div>

  </div>




<div class="card car_category"  style="display:none;">
<div class="card-body">
<div class="row">


            <div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
            <b style="font-size: 20px;">Styling & Appearance </b>

            <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
            </div>

               <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="digital_instrument_panel" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'styling_n_appearance', 'value' => 'digital_instrument_panel'], $vehicle_features); ?> />
        <label class="lbel">Digital Instrument Panel</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="alloy_wheels" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'styling_n_appearance', 'value' => 'alloy_wheels'], $vehicle_features); ?> />
        <label class="lbel">Alloy Wheels</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="electric_sunroof" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'styling_n_appearance', 'value' => 'electric_sunroof'], $vehicle_features); ?> />
        <label class="lbel">Electric Sunroof</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="leather_interior" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'styling_n_appearance', 'value' => 'leather_interior'], $vehicle_features); ?> />
        <label class="lbel">Leather Interior</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="leather_steel_wheel" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'styling_n_appearance', 'value' => 'leather_steel_wheel'], $vehicle_features); ?> />
        <label class="lbel">Leather Steering Wheel</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="panoramic_sunroof" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'styling_n_appearance', 'value' => 'panoramic_sunroof'], $vehicle_features); ?> />
        <label class="lbel">Panoramic Sunroof</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="spoiler" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'styling_n_appearance', 'value' => 'spoiler'], $vehicle_features); ?> />
        <label class="lbel">Spoiler</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="sport_seats" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'styling_n_appearance', 'value' => 'sport_seats'], $vehicle_features); ?> />
        <label class="lbel">Sport Seats</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="sunroof" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'styling_n_appearance', 'value' => 'sunroof'], $vehicle_features); ?> />
        <label class="lbel">Sunroof</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="tinted_windows" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'styling_n_appearance', 'value' => 'tinted_windows'], $vehicle_features); ?> />
        <label class="lbel">Tinted Windows</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="steel_wheels" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'styling_n_appearance', 'value' => 'steel_wheels'], $vehicle_features); ?> />
        <label class="lbel">Steel Wheels</label>
    </div>
</div>


 </div>
</div>
</div>


   <div class="card car_category"  style="display:none;">
<div class="card-body">
<div class="row">


<div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
            <b style="font-size: 20px;">Lighting & Illumination </b>

            <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
            </div>


               <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="night_vision_assist" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'lighting_n_illumination', 'value' => 'night_vision_assist'], $vehicle_features); ?> />
        <label class="lbel">Night Vision Assist</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="adaptive_headlights" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'lighting_n_illumination', 'value' => 'adaptive_headlights'], $vehicle_features); ?> />
        <label class="lbel">Adaptive Headlights</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="ambient_lighting" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'lighting_n_illumination', 'value' => 'ambient_lighting'], $vehicle_features); ?> />
        <label class="lbel">Ambient Lighting</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="auto_lights" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'lighting_n_illumination', 'value' => 'auto_lights'], $vehicle_features); ?> />
        <label class="lbel">Auto Lights (Dusk Sensor)</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="bi_xenon_headlights" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'lighting_n_illumination', 'value' => 'bi_xenon_headlights'], $vehicle_features); ?> />
        <label class="lbel">Bi-Xenon Headlights</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="daytime_running_lights" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'lighting_n_illumination', 'value' => 'daytime_running_lights'], $vehicle_features); ?> />
        <label class="lbel">Daytime Running Lights</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="fog_lights" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'lighting_n_illumination', 'value' => 'fog_lights'], $vehicle_features); ?> />
        <label class="lbel">Fog Lights</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="high_beam_assist" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'lighting_n_illumination', 'value' => 'high_beam_assist'], $vehicle_features); ?> />
        <label class="lbel">High Beam Assist</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="led_headlights" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'lighting_n_illumination', 'value' => 'led_headlights'], $vehicle_features); ?> />
        <label class="lbel">LED Headlights</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="xenon_headlights" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'lighting_n_illumination', 'value' => 'xenon_headlights'], $vehicle_features); ?> />
        <label class="lbel">Xenon Headlights</label>
    </div>
</div>


   </div>
</div>
</div>



<div class="card car_category"  style="display:none;">
<div class="card-body">
<div class="row">

 <div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
            <b style="font-size: 20px;">Safety & Security </b>

            <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
            </div>

     <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="abs" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'safety_n_security', 'value' => 'abs'], $vehicle_features); ?> />
        <label class="lbel">ABS</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="lane_change_assist" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'safety_n_security', 'value' => 'lane_change_assist'], $vehicle_features); ?> />
        <label class="lbel">Lane Change Assist</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="anti_collision_system" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'safety_n_security', 'value' => 'anti_collision_system'], $vehicle_features); ?> />
        <label class="lbel">Anti Collision System</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="alarm_system" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'safety_n_security', 'value' => 'alarm_system'], $vehicle_features); ?> />
        <label class="lbel">Alarm System</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="blind_spot_assist" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'safety_n_security', 'value' => 'blind_spot_assist'], $vehicle_features); ?> />
        <label class="lbel">Blind Spot Assist</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="emergency_brake_assist" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'safety_n_security', 'value' => 'emergency_brake_assist'], $vehicle_features); ?> />
        <label class="lbel">Emergency Brake Assist</label>
    </div>
</div>


<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="remote_central_locking" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'safety_n_security', 'value' => 'remote_central_locking'], $vehicle_features); ?> />
        <label class="lbel">Remote Central Locking</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="driver_side_airbag" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'safety_n_security', 'value' => 'driver_side_airbag'], $vehicle_features); ?> />
        <label class="lbel">Driver-Side Airbag</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="immobilizer" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'safety_n_security', 'value' => 'immobilizer'], $vehicle_features); ?> />
        <label class="lbel">Immobilizer</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="isofix" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'safety_n_security', 'value' => 'isofix'], $vehicle_features); ?> />
        <label class="lbel">Isofix</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="lane_departure_warning" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'safety_n_security', 'value' => 'lane_departure_warning'], $vehicle_features); ?> />
        <label class="lbel">Lane Departure Warning</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="tyre_pressure_monitor" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'safety_n_security', 'value' => 'tyre_pressure_monitor'], $vehicle_features); ?> />
        <label class="lbel">Tyre Pressure Monitor</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="passenger_side_airbag" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'safety_n_security', 'value' => 'passenger_side_airbag'], $vehicle_features); ?> />
        <label class="lbel">Passenger-Side Airbag</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="seat_belt_warning" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'safety_n_security', 'value' => 'seat_belt_warning'], $vehicle_features); ?> />
        <label class="lbel">Seat Belt Warning</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="side_airbag" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'safety_n_security', 'value' => 'side_airbag'], $vehicle_features); ?> />
        <label class="lbel">Side Airbag</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="stability_control" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'safety_n_security', 'value' => 'stability_control'], $vehicle_features); ?> />
        <label class="lbel">Stability Control</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="traction_control" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'safety_n_security', 'value' => 'traction_control'], $vehicle_features); ?> />
        <label class="lbel">Traction Control</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="emergency_tyre_repair_kit" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'safety_n_security', 'value' => 'emergency_tyre_repair_kit'], $vehicle_features); ?> />
        <label class="lbel">Emergency Tyre Repair Kit</label>
    </div>
</div>



   </div>
</div>
</div>



     <div class="card car_category"  style="display:none;">
<div class="card-body">
<div class="row">

     <div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
            <b style="font-size: 20px;">Performance & Handling </b>

            <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
            </div>

              <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="performance_n_handling[]" value="air_suspension" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'performance_n_handling', 'value' => 'air_suspension'], $vehicle_features); ?> />
        <label class="lbel">Air Suspension</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="performance_n_handling[]" value="4wd" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'performance_n_handling', 'value' => '4wd'], $vehicle_features); ?> />
        <label class="lbel">4WD</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="performance_n_handling[]" value="sport_suspension" type="checkbox" <?= \App\Http\Controllers\Vendor\CarController::isFeatureChecked(['parent_name' => 'performance_n_handling', 'value' => 'sport_suspension'], $vehicle_features); ?> />
        <label class="lbel">Sport Suspension</label>
    </div>
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
                      <h3>Key Selling Points </h3>

                    </div>
                  </div>



            <div class="col-lg-6">
                        <div class="form-group ">

                            <input  class="chekbox" name="history_checked" <?= ($car->history_checked == 1) ? 'checked' : '' ?> value="1" type="checkbox" />
                            <label  class="lbel">History checked</label>
                        </div>

            </div>

            <div class="col-lg-6">
                        <div class="form-group ">

                            <input  class="chekbox" name="delivery_available" <?= ($car->delivery_available == 1) ? 'checked' : '' ?>  value="1" type="checkbox" />
                            <label  class="lbel">Delivery available</label>
                        </div>

            </div>


                     <div class="col-lg-6">
                        <div class="form-group ">

                            <label  class="lbel">Warranty Type *</label>

                            <select name="warranty_type" class="form-control" onclick="checkwarrenty_type(this)">
                                <option value="Dealer Warranty" <?= ($car->warranty_type == 'Dealer Warranty') ? 'checked' : '' ?>  >Dealer Warranty  </option>
                                <option value="Manufacturer Warranty" <?= ($car->warranty_type == 'Manufacturer Warranty') ? 'checked' : '' ?>>Manufacturer Warranty  </option>
                                <option value="No Warranty" <?= ($car->warranty_type == 'No Warranty') ? 'checked' : '' ?> >No Warranty  </option>
                            </select>

                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="form-group">

                                <label  class="lbel">Warranty Duration *</label>

                                <select name="warranty_duration" id="warranty_duration" class="form-control">

                                    <option value="0" <?= ($car->warranty_duration == '0 month') ? 'selected' : '' ?>  >0 month  </option>
                                    <option value="3 month" <?= ($car->warranty_duration == '3 month') ? 'selected' : '' ?> >3 month  </option>
                                    <option value="6 month" <?= ($car->warranty_duration == '6 month') ? 'selected' : '' ?> >6 month  </option>
                                    <option value="9 month" <?= ($car->warranty_duration == '9 month') ? 'selected' : '' ?> >9 month   </option>

                                    <option value="1 year" <?= ($car->warranty_duration == '1 year') ? 'selected' : '' ?> >1 year  </option>
                                    <option value="2 year" <?= ($car->warranty_duration == '2 year') ? 'selected' : '' ?> >2 year  </option>
                                    <option value="3 year" <?= ($car->warranty_duration == '3 year') ? 'selected' : '' ?> >3 year   </option>

                                    <option value="5 year" <?= ($car->warranty_duration == '5 year') ? 'selected' : '' ?> >5 year  </option>
                                    <option value="6 year" <?= ($car->warranty_duration == '6 year') ? 'selected' : '' ?> >6 year  </option>
                                    <option value="7 year" <?= ($car->warranty_duration == '7 year') ? 'selected' : '' ?>  >7 year   </option>

                                    <option value="8 year" <?= ($car->warranty_duration == '8 year') ? 'selected' : '' ?> >8 year   </option>

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

                                @php
                                    $jsonArray = json_decode($car->enquiry_person_id , true);
                                @endphp

                                <div class="row">
                                        @foreach( $enquire_persons as  $enquire_person)
                                          <div class="col-md-3">
                                              <span style="font-size: 16px;font-weight: 700;color: gray;    margin-right: 7px;">
                                              {{ucfirst($enquire_person->name)}}
                                          </span>

                                          <input type="checkbox" style="zoom: 1.2;position: relative;top: 1px;" @if(!empty($jsonArray) && in_array($enquire_person->id , $jsonArray)) checked @endif value="{{$enquire_person->id}}" name="enquirey_person[]" />
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
                        <input class="form-check-input" type="radio" <?= ($car->ad_type == 'sale' ) ? 'checked' : '' ?> name="ad_type" id="inlineRadio1" value="sale" required  checked>
                        <label class="form-check-label" for="ad_type">For Sale</label>
                        </div>
                        <div class="form-check form-check-inline">
                       <input class="form-check-input" type="radio" <?= ($car->ad_type == 'Wanted' ) ? 'checked' : '' ?> name="ad_type" id="inlineRadio2" value="Wanted">
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
                                <input type="text" class="form-control"  value="{{$car->car_content->title }}" name="{{ $language->code }}_title"
                                  placeholder="Enter Title">
                              </div>
                            </div>
                          </div>

                            <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                                <label>{{ __('Description') }} *</label>
                                <textarea id="{{ $language->code }}_description" class="form-control "
                                  name="{{ $language->code }}_description" data-height="300" style="    height: 200px;" >{{$car->car_content->description }}</textarea>
                              </div>
                            </div>

                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>{{ __('Price') }} £</label>
                                  <input type="number" class="form-control" name="price" value="{{$car->price }}" placeholder="Enter  Price">
                                </div>
                              </div>

                              <div class="col-lg-6" >
                                <div class="form-group">
                                  <label>Vat Status </label>
                                  <select name="vat_status" id="" class="form-control">
                                    <option value="No VAT" <?= ($car->vat_status == 'No VAT' ) ? 'selected' : '' ?> >No VAT</option>
                                     <option value="Yes" <?= ($car->vat_status == 'Yes' ) ? 'selected' : '' ?> >Yes</option>
                                  </select>
                                </div>
                              </div>

                              <div class="col-lg-6" style="display:none;">
                                <div class="form-group">
                                  <label>{{ __('Status') }} *</label>
                                  <select name="status" id="" class="form-control">
                                    <option value="1"  <?= ($car->status == '1' ) ? 'selected' : '' ?> >{{ __('Active') }}</option>
                                    <option value="0"  <?= ($car->status == '0' ) ? 'selected' : '' ?> >{{ __('Deactive') }}</option>
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

                  <div class="col-lg-6">
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
                         <input type="checkbox" style="zoom: 1.2;position: relative;top: 3px;margin-right: 5px;" <?= ($car->message_center == 1) ? 'checked' : '' ?> required checked name="message_center" value="yes">
                      <label>Message Centre </label>

                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                          <input type="checkbox"  style="zoom: 1.2;position: relative;top: 3px;margin-right: 5px;" <?= ($car->phone_text == 1) ? 'checked' : '' ?> name="phone_text" value="yes">
                      <label>Phone/Text</label>

                    </div>
                  </div>



                </div>
                 <input type="hidden" name="can_car_add" value="1">
                <input type="hidden" id="defaultImg" name="car_cover_image" value="">
                <input type="hidden" name="car_id" value="{{$car->id}}">
                <input type="hidden" name="rotation_point" id="feature_photo_rotation" value="{{$car->rotation_point}}">
                <input type="hidden" name="photo_frma" id="photoframe" />

            </div>



          </div>




    <div class="card" style="display:none;">

        <input type="text" class="form-control" placeholder="enter dealer name " readonly value="{{$car->financing_dealer}}"  name="financing_dealer" />

        <input type="text" class="form-control"  placeholder="Enter url here where user redirect" value="{{$car->vendor->finance_url}}" name="financing_url" />

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
            <input type="text" class="form-control" name="youtube_video"  value="{{$car->youtube_video}}"  placeholder="Enter youtube Video URL">
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
                  <div id="imagePreview">
                      @if(!empty($car->feature_image))
                      <img src="{{asset('assets/admin/img/car-gallery/'.$car->feature_image)}}" alt="Image Preview" id="previewImg" style="max-width: 200px; max-height: 200px; transform: rotate({{$car->rotation_point}}deg);">
                        <i class="fa fa-undo rotatebtndb" style="position: relative;
                        top: -40px !important;
                        right: 15px;
                        background: white;
                        padding: 5px;
                        border-radius: 50%;" onclick="rotateFeatureImg()" title="rotate" ></i>
                        <i class="fa fa-times " style="position: relative;top: -65px !important;right: 40px;background: white;padding: 5px;border-radius: 50%;" onclick="removeFeatureImg(this)" title="remove" ></i>

                      @endif
                          </div>

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
                <form action="{{ route('car.imagesstore') }}" id="my-dropzone" enctype="multipart/form-data"
                  class="dropzone create">
                  @csrf
                  <div class="fallback">
                    <input name="file" type="file" multiple />
                  </div>
                </form>
                <p class="em text-danger mb-0" id="errslider_images"></p>
              </div>

                   @php
                // Sort galleries by priority
                $sortedGalleries = $car->galleries->sortBy('priority');

                // Extract the feature image
                $featureImage = $sortedGalleries->firstWhere('image', $car->feature_image);

                // Remove the feature image from the sorted galleries
                if ($featureImage) {
                $sortedGalleries = $sortedGalleries->reject(function($item) use ($featureImage) {
                return $item->id === $featureImage->id;
                });

                // Prepend the feature image to the sorted galleries
                $sortedGalleries->prepend($featureImage);
                }
                @endphp


              <div class="col-12">
                    <table class="table table-striped" id="imgtable">
                      @foreach ($sortedGalleries as $item)
                        <tr class="trdb table-row" id="trdb{{ $item->id }}">
                          <td>
                            <div class="">
                              <img class="thumb-preview wf-150"
                                src="{{ asset('assets/admin/img/car-gallery/' . $item->image) }}" id="img_{{$item->id}}" alt="Ad Image" style=" transform: rotate({{$item->rotation_point}}deg);">
                            </div>
                          </td>
                          <td>
                            <i class="fa fa-times  " onclick="rmvimg({{ $item->id }} , this)"  data-indb="{{ $item->id }}"></i>
                            <i class="fa fa-undo rotatebtndb" onclick="rotatePhoto({{ $item->id }})" ></i>
                          </td>
                        </tr>
                      @endforeach
                     </table>
                  </div>

                </div>
                </div>

                </div>



        <div class="card-footer">
          <div class="row">
            <div class="col-12 text-center">
              <button type="button" id="CarSubmits" data-can_car_add="{{ $can_car_add }}" class="btn btn-success">
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

  <input type="hidden" id="request_method" value="GET" />
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
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 14px !important;
    font-weight: 400;
    line-height: 1.5;
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


.rotatebtndb
{

    top: 30px !important;

    color: #004eabd6 !important;

    cursor: pointer !important;
}

</style>
<script>
var rotationAngle1 = 0;
var rotationAnglef = 0;

function rmvimg(fileid , self)
  {

    $.ajax({
      url: '{{ route('user.car.imagermvs') }}',
      type: 'GET',
      data: {
        fileid: fileid
      },
      success: function (data) {
        $('#trdb'+fileid).remove();
      }
    });

  }
   function openClosestBox(self)
    {
        $(self).closest('.car_category').find('.us_hide_by_default').toggle()
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


    function removeFeatureImg(self)
    {
        $(self).closest('#imagePreview').html('');
    }


    function uploadImage() {
        var formData = new FormData($('#imageUploadForm')[0]);
        var fileInput = document.getElementById('image');

        formData.append('photo_frame', fileInput.files[0]);

        $('#CarSubmits').prop('disabled' , true);

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
                $('#CarSubmits').prop('disabled' , false);

                // Handle the success response, e.g., display a message or update the UI
                console.log(response);
            },
            error: function(error)
            {
                // Handle the error response, e.g., display an error message
                console.log(error);
            }
        });
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

 $(document).ready(function () {
    // Add a click event listener to the submit button
    $("#CarSubmits").click(function () {
        // Serialize the form data
        var formData = $("#myForm").serialize();
        $('#CarSubmits').prop('disabled' , true)
        // Make an AJAX request
        $.ajax({
            type: "POST",
            url: "{{ route('vendor.car_management.update_dealer_ad' , [$car->id]) }}",  // Replace with your actual backend endpoint
            data: formData,
            dataType: 'json',
            success: function (response) {
                // Check if the 'errors' key is present
                if (response.errors) {
                    // Get the 'errors' object
                    var errors = response.errors;

                    // Create an unordered list
                    var $errorList = $('<ul>');

                    // Iterate through the errors object and create list items
                    $.each(errors, function (fieldName, errorMessages) {
                      var capitalizedFieldName = fieldName.charAt(0).toUpperCase() + fieldName.slice(1);

                        // Iterate through the array of error messages for each field
                        $.each(errorMessages, function (index, errorMessage) {
                            // Create a list item

                            console.log(errorMessage)
                            var $errorItem = $('<li style="    color: red;">').text(capitalizedFieldName  + ': ' + errorMessage);

                            // Append the list item to the list
                            $errorList.append($errorItem);
                        });
                    });

                    // Clear existing error messages
                    $('#error_list').empty();

                    // Append the list to the error_list element or any other container
                    $('#error_list').append($errorList);
                    $('#error_list').show();
                    $('html, body').animate({
                    scrollTop: $('.us_top').offset().top
                    }, 500);
                     $('#CarSubmits').prop('disabled' , false)
                } else {
                    // If no errors, reload the page or perform other actions
                    window.location.href = "/vendor/car-management?language=en&tab=publish";
                }
            },
            error: function (error) {
                // Handle the error
                console.error("AJAX request failed:", error);
            }
        });
    });
});



function checkIfVhecleCat(self)
{
    getSubCtegory()

    var searchWord = "car";

    if ($(self).text().toLowerCase().includes(searchWord.toLowerCase()))
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
    var searchWord = "car";

    $('#make').change();

    $('#adsMaincats option').each(function()
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


function getSubCtegory()
    {
        var adsMaincats = $('#adsMaincats').val();

        // Make an Ajax request to get car models
            $.ajax({
                type: 'GET',
                url: '{{ url('vendor/car-management/ads-subcat') }}/'+adsMaincats,
                success: function(data) {
                     $('#adsSubcat').prop('disabled' , false)
                     $('#adsSubcat').html(data);

                        var sub_cat = '{{$car->car_content->sub_category->id}}';

                        $('#adsSubcat option').each(function()
                        {

                            if ($(this).val().includes(sub_cat))
                            {
                                $(this).prop('selected', true);
                            }
                        });


                },
                error: function(xhr, status, error) {
                    console.error('Error fetching car models: ' + status);
                }
            });
    }



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


                    var car_model = '{{$car->car_content->model->id}}';

                        $('#carModel option').each(function()
                        {

                            if ($(this).val().includes(car_model))
                            {
                                $(this).prop('selected', true);
                            }
                        });


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

  <script src="{{ asset('assets/js/car.js') }}"></script>
  <script>
    var labels = "{!! $labels !!}";
    var values = "{!! $values !!}";
  </script>
    <script type="text/javascript" src="{{ asset('assets/js/admin-partial.js?v=0.2') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/admin-dropzone.js?v=0.92') }}"></script>
@endsection
