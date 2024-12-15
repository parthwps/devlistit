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

  @php
                      $carContent = App\Models\Car\CarContent::where('car_id', $car->id)->first();
                      $categories = App\Models\Car\Category::where('id', $carContent->category_id)->first();
                     
                    @endphp
<div class="user-dashboard pt-20 pb-60">
    <div class="container">
      
  
      
  <div class="row gx-xl-5">
  
       @includeIf('vendors.partials.side-custom')
  <div class="col-md-9">      
  

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">{{ __('Edit Ad') }}</div>
          <a style="float: right;" class="btn btn-info btn-sm float-right d-inline-block"
            href="{{ route('vendor.car_management.car', ['language' => $defaultLang->code]) }}">
            <span class="btn-label">
              <i class="fas fa-backward"></i>
            </span>
            {{ __('Back') }}
          </a>
          @php
            $dCarContent = App\Models\Car\CarContent::where('car_id', $car->id)
                ->where('language_id', $defaultLang->id)
                ->first();
          @endphp
          <a style="float: right;margin-right: 1rem;" class="mr-2 btn btn-success btn-sm float-right d-inline-block"
            href="{{ route('frontend.car.details', ['cattitle' => catslug($dCarContent->category_id), 'slug' => $dCarContent->slug, 'id' => $car->id]) }}" target="_blank">
            <span class="btn-label">
              <i class="fas fa-eye"></i>
            </span>
            {{ __('Preview') }}
          </a>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="alert alert-danger pb-1 dis-none" id="carErrors">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <ul></ul>
              </div>
              <div class="col-lg-12">
                <label for="" class="mb-2"><strong>{{ __('Gallery Images') }} **</strong></label>
                <div class="row">
                  <div class="col-12">
                    <table class="table table-striped" id="imgtable">
                      @foreach ($car->galleries as $item)
                        <tr class="trdb table-row" id="trdb{{ $item->id }}">
                          <td>
                            <div class="">
                              <img class="thumb-preview wf-150"
                                src="{{ asset('assets/admin/img/car-gallery/' . $item->image) }}" alt="Ad Image">
                            </div>
                          </td>
                          <td>
                            <i class="fa fa-times rmvbtndb" data-indb="{{ $item->id }}"></i>
                            @if ($item->image==$car->feature_image)
                            <label>Cover photo</label>
                            @endif
                           
                          </td>
                          
                          
                        </tr>

                      @endforeach
                    </table>
                  </div>
                </div>
                <form action="{{ route('vendor.car.imagesstore') }}" id="my-dropzone" enctype="multipart/formdata"
                  class="dropzone create">
                  @csrf
                  <div class="fallback">
                    <input name="file" type="file" multiple />
                  </div>
                  <input type="hidden" value="{{ $car->id }}" name="car_id">
                </form>
                <p class="em text-danger mb-0" id="errslider_images"></p>
              </div>

              <form id="carForm" action="{{ route('vendor.car_management.update_car', $car->id) }}" method="POST"
                enctype="multipart/form-data" >
                @csrf
                <input type="hidden" name="car_id" value="{{ $car->id }}">
                <input type="hidden" name="can_car_add" value="1">
                <input type="hidden" id="defaultImg" name="car_cover_image" value="">
                <!-- <div class="form-group">
                  <label for="">{{ __('Thumbnail Image') . '*' }}</label>
                  <br>
                  <div class="thumb-preview">
                    <img
                      src="{{ $car->feature_image ? asset('assets/admin/img/car/' . $car->feature_image) : asset('assets/admin/img/noimage.jpg') }}"
                      alt="..." class="uploaded-img">
                  </div>
                  <div class="mt-3">
                    <div role="button" class="btn btn-primary btn-sm upload-btn">
                      {{ __('Choose Image') }}
                      <input type="file" class="img-input" name="thumbnail">
                    </div>
                  </div>
                </div> -->
                @if (in_array('make', json_decode($categories->filters))) 
                <div class="row">
                <div class="col-lg-8">
                    <div class="form-group">
                    <h3>{{ __('Vehicle Details') }} </h3>
                               
                      </div>
                  </div>
                
                </div>
                @endif

                <div class="row">
                @if (in_array('make', json_decode($categories->filters))) 
                  <div class="col-lg-6 col-sm-6">
                    <div class="form-group editAdLabel">
                    @php
                    $brands = App\Models\Car\Brand::where('id', $carContent->brand_id)->first();
                    @endphp
                      <label>{{ __('Make:') }} </label>
                      <b>{{$brands->name}}</b>
                    </div>
                  </div>
                  @endif 
                  @if (in_array('model', json_decode($categories->filters))) 

                  <div class="col-lg-6 col-sm-6">
                    <div class="form-group editAdLabel">
                    @php
                    $models = App\Models\Car\CarModel::where('id', $carContent->car_model_id)->first();
                  
                    @endphp
                      <label>{{ __('Model:') }} </label>
                      <b>{{$models->name}}</b>
                    </div>
                  </div>
                  @endif 

                  @if (in_array('year', json_decode($categories->filters))) 
                  <div class="col-lg-6 col-sm-6">
                    <div class="form-group editAdLabel">
                      <label>{{ __('Year:') }} </label>
                      <b>{{$car->year}}</b>
                    </div>
                  </div>
                  @endif 
                  @if (in_array('fuel_types', json_decode($categories->filters)))
                  <div class="col-lg-6 col-sm-6">
                    <div class="form-group editAdLabel">
                    @php
                     $fuel_types = App\Models\Car\FuelType::where('id', $carContent->fuel_type_id)->first();
                     @endphp
                      <label>{{ __('Fuel Type:') }} </label>
                      <b>{{$fuel_types->name}}</b>
                    </div>
                  </div>
                  @endif

 @if (in_array('engine', json_decode($categories->filters)))
    <div class="col-lg-4">
        <div class="form-group">
        @php
            $engine_sizes = App\Models\Car\EngineSize::where('status', 1)->get();
        @endphp
        <label>{{ __('Engine size (litres)') }} </label>
        <select name="engineCapacity" id="engine_sizes" class="form-control" >
            <option value="" >{{ __('Select') }}</option>
            @foreach ($engine_sizes as $engine)
             <option  value="{{ $engine->slug }}"  @selected($engine->slug == $car->engineCapacity)>{{ ($engine->name) }}</option>
            @endforeach
            </select>
        </div>
    </div>   
    
@endif
@if (in_array('transmision_type', json_decode($categories->filters)))
<div class="col-lg-4">
    <div class="form-group">
        @php
        $transmission_types = App\Models\Car\TransmissionType::where('status', 1)
            ->get();
        @endphp

        <label>{{ __('Transmission Type') }} </label>
        <select name="transmission_type_id" class="form-control" id="transmissionType">
        <option value="" >{{ __('Select') }}</option>
        
        @foreach ($transmission_types as $transmission_type)
            <option value="{{ $transmission_type->id }}" @selected($transmission_type->id == $carContent->transmission_type_id)>{{ $transmission_type->name }}
            </option>
        @endforeach
        </select>
    </div>
</div>
@endif
@if (in_array('body_type', json_decode($categories->filters)))
<div class="col-lg-4">
    <div class="form-group">
        @php
        $body_types = App\Models\Car\BodyType::where('status', 1)->get();
        @endphp
        <label>{{ __('Body Type') }} </label>
        <select name="body_type_id" id="bodyType" class="form-control">
        @foreach ($body_types as $body_type)
        
            <option value="{{ $body_type->id }}" @selected($body_type->id == $carContent->body_type_id)>{{ $body_type->name }}
            </option>
        @endforeach
        </select>
    </div>
</div> 
@endif
@if (in_array('colour', json_decode($categories->filters)))
<div class="col-lg-4">
    <div class="form-group ">
    @php
        $colour = App\Models\Car\CarColor::where('status', 1)->get();
    @endphp

    <label>{{ __('Colour') }} </label>
    <select name="car_colour_id" class="form-control" id="carColour">
        <option value="">{{ __('Select Colour') }}</option>
        
        @foreach ($colour as $colour)
        <option value="{{ $colour->id }}"  @selected($colour->id == $carContent->car_color_id)>{{ $colour->name }}</option>
        @endforeach
    </select>
    </div>
</div>
@endif
@if (in_array('doors', json_decode($categories->filters)))
<div class="col-lg-4">
    <div class="form-group">
    <label>{{ __('Number of doors') }} </label>
    <select name="doors"  class="form-control" id="carDoors" >
    <option value="">Please select...</option>
    <option value="2" @selected($car->doors == 2)>2</option>
    <option value="3" @selected($car->doors == 3)>3</option>
    <option value="4" @selected($car->doors == 4)>4</option>
    <option value="5" @selected($car->doors == 5)>5</option>
    <option value="6" @selected($car->doors == 6)>6</option>
    <option value="7" @selected($car->doors == 7)>7</option>
    <option value="8" @selected($car->doors == 8)>8</option>
    </select>
    </div>
</div>
@endif
@if (in_array('seat_count', json_decode($categories->filters)))
<div class="col-lg-4">
    <div class="form-group">
    <label>{{ __('Seat count') }} </label>
    <select name="seats" id="seats" class="form-control">
    <option value="">Please select...</option>
    <option value="2" @selected($car->seats == 2)>2</option>
    <option value="3" @selected($car->seats == 3)>3</option>
    <option value="4" @selected($car->seats == 4)>4</option>
    <option value="5" @selected($car->seats == 5)>5</option>
    <option value="6" @selected($car->seats == 6)>6</option>
    <option value="7" @selected($car->seats == 7)>7</option>
    <option value="8" @selected($car->seats == 8)>8</option>
    </select>
    </div>
</div>
@endif
@if (in_array('power', json_decode($categories->filters)))
<div class="col-lg-4">
    <div class="form-group ">
    @php
        $engine_power = App\Models\Car\CarPower::where('status', 1)->get();
    @endphp

    <label>{{ __('Power') }} </label>
    <select name="power" class="form-control" id="power">
        <option value="">{{ __('Select power') }}</option>

        @foreach ($engine_power as $power)
            <option 
            value="{{ $power->slug }}" @selected($power->slug == $car->power)>{{ ($power->name) }}</option>
        @endforeach
    </select>
    </div>
</div>
@endif
@if (in_array('battery', json_decode($categories->filters)))
<div class="col-lg-4">
    <div class="form-group ">
   
    <label>{{ __('Battery') }} </label>
    <select name="battery" class="form-control" id="battery">
        <option value="">{{ __('Select battery') }}</option>

        <option value="">{{ __('Any') }}</option>
        <option value="100" @selected($car->battery == 100)>100+ M</option>
        <option value="200" @selected($car->battery == 200)>200+ M</option>
        <option value="300" @selected($car->battery == 300)>300+ M</option>
        <option value="400" @selected($car->battery == 400)>400+ M</option>
        <option value="500" @selected($car->battery == 500)>500+ M</option>
    </select>
    </div>
</div>
@endif
@if (in_array('owners', json_decode($categories->filters)))
<div class="col-lg-4">
    <div class="form-group ">
   
    <label>{{ __('Number of owners') }} </label>
    <select id="owners" class="form-select form-control"  name="owners">
        <option value="">{{ __('Any') }}</option>
        <option value="1" @selected($car->owners == 1)>1</option>
        <option value="2" @selected($car->owners == 2)>2</option>
        <option value="3" @selected($car->owners == 3)>3</option>
        <option value="4" @selected($car->owners == 4)>4</option>
        <option value="5" @selected($car->owners == 5)>5</option>
        <option value="6" @selected($car->owners == 6)>6</option>
        <option value="7" @selected($car->owners == 7)>7</option>
        <option value="8" @selected($car->owners == 8)>8</option>
        
    </select>
    </div>
</div>
@endif
@if (in_array('road-tax', json_decode($categories->filters)))
<div class="col-lg-4">
    <div class="form-group ">
   
    <label>{{ __('Annual road tax') }} </label>
    <select id="tax" class="form-select form-control"  name="road_tax">
        <option value="">{{ __('Any') }}</option>
        <option value="150" @selected($car->road_tax == 150)>Up to {{symbolPrice(150)}}</option>
        <option value="200" @selected($car->road_tax == 200)>Up to {{symbolPrice(200)}}</option>
        <option value="300" @selected($car->road_tax == 300)>Up to {{symbolPrice(300)}}</option>
        <option value="400" @selected($car->road_tax == 400)>Up to {{symbolPrice(400)}}</option>
        <option value="500" @selected($car->road_tax == 500)>Up to {{symbolPrice(500)}}</option>
        <option value="1000" @selected($car->road_tax == 1000)>Up to {{symbolPrice(1000)}}</option>
        <option value="1000" @selected($car->road_tax == 1000)> {{symbolPrice(100)}}+</option>
        road_tax
        
    </select>
    </div>
</div>
@endif
@if (in_array('verification', json_decode($categories->filters)))
<div class="col-lg-4">
    <div class="form-group ">
   
    <label>{{ __('Verification') }} </label>
    <select id="verification" class="form-select form-control"  name="verification">
        <option value="">{{ __('Any') }}</option>
        <option value="manufacture" @selected($car->verification == 'manufacture')>Manufacturer Approved</option>
        <option value="greenlight" @selected($car->verification == 'greenlight')>Greenlight Verified</option>
        <option value="trusted" @selected($car->verification == 'trusted')>Trusted Dealer</option>
    </select>
    </div>
</div>
@endif
@if (in_array('warranty', json_decode($categories->filters)))
<div class="col-lg-4">
    <div class="form-group ">
   
    <label>{{ __('Warranty Duration') }} </label>
    <select id="warranty" class="form-select form-control"  name="warranty">
        <option value="">{{ __('Any') }}</option>
        <option value="3" @selected($car->warranty == 3)>3 Months</option>
        <option value="6" @selected($car->warranty == 6)>6 Months</option>
        <option value="9" @selected($car->warranty == 9)>9 Months</option>
        <option value="12" @selected($car->warranty == 12)>12 Months</option>
        <option value="24" @selected($car->warranty == 24)>2 Year</option>
        <option value="36" @selected($car->warranty == 36)>3 Year</option>
        <option value="48" @selected($car->warranty == 48)>4 Year</option>
        <option value="60" @selected($car->warranty == 60)>5 Year</option>
        <option value="72" @selected($car->warranty == 72)>6 Year</option>
        <option value="84" @selected($car->warranty == 84)>7 Year</option>
        <option value="96" @selected($car->warranty == 96)>8 Year</option>
    </select>
    </div>
</div>
@endif
@if (in_array('mot', json_decode($categories->filters)))
<div class="col-lg-4">
    <div class="form-group ">
   
    <label>{{ __('Valid Test/MOT') }} </label>
    <select id="valid_test" class="form-select form-control"  name="valid_test">
    <option value="">{{ __('Any') }}</option>
    <option value="3" @selected($car->valid_test == 3)>More than 3 Months</option>
    <option value="6" @selected($car->valid_test == 6)>More than 6 Months</option>
    <option value="9" @selected($car->valid_test == 9)>More than 9 Months</option>
    <option value="12" @selected($car->valid_test == 12)> 12 Months</option>
    <option value="">Not Applicable</option>
    
    </select>
    </div>
</div>
@endif


               

                <div id="accordion" class="mt-3">
                  @foreach ($languages as $language)
                   
                   
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label>{{ __('Title*') }}</label>
                                <input type="text" class="form-control" name="{{ $language->code }}_title"
                                  placeholder="Enter Title" value="{{ $carContent ? $carContent->title : '' }}">
                              </div>
                            </div>

                            <!-- <div class="col-lg-3">
                              <div class="form-group ">
                                @php
                                  $categories = App\Models\Car\Category::where('language_id', $language->id)
                                      ->where('status', 1)
                                      ->get();
                                @endphp

                                <label>{{ __('Category') }} *</label>
                                <select name="{{ $language->code }}_category_id"
                                  class="form-control js-example-basic-single2">
                                  <option selected disabled>{{ __('Select a Category') }}</option>

                                  @foreach ($categories as $category)
                                    <option
                                      {{ ($carContent ? $carContent->category_id : '' == $category->id) ? 'selected' : '' }}
                                      value="{{ $category->id }}">{{ $category->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div> -->

                               
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label>{{ __('Description') }} *</label>
                                <textarea class="form-control" id="{{ $language->code }}_description"
                                  name="{{ $language->code }}_description" data-height="300">{{ $carContent ? $carContent->description : '' }}</textarea>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                 
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label>{{ __('Price') }} </label>
                              <input type="number" class="form-control" name="previous_price" placeholder="Enter Previous Price"
                                value="{{ $car->price }}">
                            </div>
                          </div>
                          <div class="col-lg-6 ">
                            <div class="form-group">
                              <label>{{ __('Optional YouTube Video') }} </label>
                                 <input type="text" class="form-control" name="youtube_video" placeholder="Enter youtube Video URL">
                              </div>
                              </div>                      
                           </div>
                           
                         
                        
                       
                  @endforeach
                </div>
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
                    <label style="margin-left:8px; margin-top:8px; font-size: 1.2rem; color: #0d0c1b;">{{ __('Phone') }}</label>
                    <div class="form-group input-group">
                      
                      <input  type="tel" value="{{ $vendor->phone }}" style= "width:70%;" class="form-control" name="phone" required> 
                       @if ($vendor->phone_verified == 1)
                        <button disabled   class="btn btn-outline" type="button">Verified</button>
                         @else
                        <button  id="verifyPhone" class="btn btn-outline-secondary" type="button">Verify</button>
                        @endif
                     <small>Verify your phone number and help reduce fraud and scam on Listit</small>
                      <p id="editErr_phone" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  
                  <div class="col-lg-6">
                    <div class="form-group">
                     <label>{{ __('Area') }}</label>
                     
                     <input id ="promoStatus" type="hidden" name="promo_status" value="0">
                      <select name="city" id="" class="form-control">
                    <option value="">Please select...</option>
                    @foreach ($countryArea as $area)
                      <option value="{{ $area->slug }}" {{ $area->slug == $vendor->vendor_info->city ? 'selected' : '' }}>{{ $area->name }}</option>
                    @endforeach
                    </select>
                    </div>
                  </div> 
                  <div class="row">
            <div class="col-12 text-center">
              <button type="submit" id="CarSubmit" class="btn btn-primary">
                {{ __('Update') }}
              </button>
            </div>
          </div>
                  </div> 
               

                <div id="sliders"></div>
              </form>
            </div>
          </div>
        </div>
        </div>

        <div class="card-footer">
         
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
  </div> </div>
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
{{-- dropzone css --}}
<link rel="stylesheet" href="{{ asset('assets/css/dropzone.min.css') }}">

{{-- atlantis css --}}

{{-- select2 css --}}
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/front/css/pages/inner-pages.css') }}">
{{-- admin-main css --}}
<link rel="stylesheet" href="{{ asset('assets/css/admin-main.css') }}">
<style type="">
  #carForm .form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem !important;
    font-size: 16px !important;
    font-weight: 400;
    line-height: 1.3 !important;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out
}
option {
  padding: 0px 8px 8px;
}

 #carForm .btn-secondary{
  line-height: 16px !important;
  left:-4px;
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
 .editAdLabel label{
  
  width:150px;
 }
</style>
<script>
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
    var rmvdbUrl = "{{ route('vendor.car.imgdbrmv') }}";
    const account_status = "{{ Auth::guard('vendor')->user()->status }}";
    const secret_login = "{{ Session::get('secret_login') }}";
  </script>

  <script src="{{ asset('assets/js/car.js') }}"></script>
  <script>
    var labels = "{!! $labels !!}";
    var values = "{!! $values !!}";
  </script>
  <script type="text/javascript" src="{{ asset('assets/js/admin-partial.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/admin-dropzone.js') }}"></script>
@endsection

