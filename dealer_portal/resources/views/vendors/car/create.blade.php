@extends("frontend.layouts.layout-v$settings->theme_version")
@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('Place Ad') }}
  @else
    {{ __('Place Ad') }}
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
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Place Ad'),
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
        @includeIf('vendors.verify')
        @php
          $can_car_add = 0;
        @endphp
      @endif



      <div class="card">

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12 ">
              <div class="alert alert-danger pb-1 dis-none" id="carErrors">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <ul></ul>
              </div>
              <div id="imageCounter">Uploded Images: <span id="imageCount">0</span></div>
              <div class="col-lg-12">
                <label for="" class="mb-2"><strong>{{ __('Gallery Images') }} **</strong></label>
                <form action="{{ route('car.imagesstore') }}" id="my-dropzone" enctype="multipart/formdata"
                  class="dropzone create">
                  @csrf
                  <div class="fallback">
                    <input name="file" type="file" multiple />
                  </div>
                </form>
                <p class="em text-danger mb-0" id="errslider_images"></p>
              </div>
              <form class = "myajaxform" id="carForm" action="{{ route('vendor.car_management.store_car') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div id="sliders"></div>
                <input type="hidden" name="can_car_add" value="1">
                <input type="hidden" id="defaultImg" name="car_cover_image" value="">
               <!--  <div class="form-group">
                  <label for="">{{ __('Feature Image') . '*' }}</label>
                  <br>
                  <div class="thumb-preview">
                    <img src="{{ asset('assets/img/noimage.jpg') }}" alt="..." class="uploaded-img">
                  </div>

                  <div class="mt-3">
                    <div role="button" class="btn btn-primary btn-sm upload-btn">
                      {{ __('Choose Image') }}
                      <input type="file" class="img-input" name="feature_image">
                    </div>
                  </div>
                </div> -->

                <div class="row">
                  <div class="col-lg-8">
                              <div class="form-group ">
                                @php
                               $categories = App\Models\Car\Category::where('parent_id', 0)->where('status', 1)
                                      ->get();
                                @endphp

                                <label>{{ __('Category') }} *</label>
                                <select name="en_main_category_id"
                                  class="form-control " id="adsMaincat">
                                  <option selected disabled>{{ __('Select a Category') }}</option>

                                  @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                  <div class="col-lg-4"></div>
                </div>
                <div class="row">
                  <div class="col-lg-8 ">
                    <div class="form-group">
                      <label>{{ __('Select a Sub Category') }} *</label>
                        <select disabled name="en_category_id"
                          class="form-control  subhidden"  id="adsSubcat">
                          <option selected disabled>{{ __('Select sub Category') }}</option>
                        </select>
                    </div>
                  </div>
                  <div class="col-lg-4"></div>
                </div>
                <div class="row">
                  <div class="col-lg-6 col-sm-6 col-md-6">
                      <div class="form-group">
                        <div class="form-check form-check-inline">

                            <label class="form-check-label" for="inlineRadio3">Ad Type</label>
                        </div>
                        <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="ad_type" id="inlineRadio1" value="sale" required  checked>
                        <label class="form-check-label" for="ad_type">For Sale</label>
                        </div>
                        <div class="form-check form-check-inline">
                       <input class="form-check-input" type="radio" name="ad_type" id="inlineRadio2" value="Wanted">
                      <label class="form-check-label" for="ad_type">Wanted</label>
                     </div>
                    </div>
                  </div>
                </div>
                <hr/>
                <div class="col-lg-6 ">
                  <div class="form-group">
                    <label>{{ __('Optional YouTube Video') }} </label>
                        <input type="text" class="form-control" name="youtube_video" placeholder="Enter youtube Video URL">
                  </div>
                </div>

                <hr/>
                 <div id = "searcfilters" class="row">

                </div>
                <div id = "searcfiltersdata" class="row">

                </div>

                <h4 style="color:gray">Ad Details </h4>

                <div id="accordion" class="mt-3">
                  @foreach ($languages as $language)
                    <div class="">
                      <div class="version-header" id="heading{{ $language->id }}">
                        <h5 class="mb-0">
                          <!-- <button type="button" class="btn btn-link" data-toggle="collapse"
                            data-target="#collapse{{ $language->id }}"
                            aria-expanded="{{ $language->is_default == 1 ? 'true' : 'false' }}"
                            aria-controls="collapse{{ $language->id }}">
                            {{ $language->name . __(' Language') }} {{ $language->is_default == 1 ? '(Default)' : '' }}
                          </button> -->
                        </h5>
                      </div>

                      <div id="collapse{{ $language->id }}"
                        class="collapse {{ $language->is_default == 1 ? 'show' : '' }}"
                        aria-labelledby="heading{{ $language->id }}" data-parent="#accordion">
                        <div class="version-body">
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                                <label>{{ __('Ad Title') }} *</label>
                                <input type="text" class="form-control" name="{{ $language->code }}_title"
                                  placeholder="Insert your ad Title">
                                  <small><i class="fa fa-info-circle"  aria-hidden="false"></i> Your ad title will be shown in search results</small>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                                <label>{{ __('Description') }} *</label>
                                <textarea id="{{ $language->code }}_description" class="form-control "
                                  name="{{ $language->code }}_description" data-height="300" placeholder = "Tell us about your ad. Make sure to give us as much information as possible."></textarea>
                              </div>
                            </div>
                            </div>
                            <div class="row">

                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>{{ __('Price') }}  &pound;</label>
                                  <input type="text" class="form-control" name="price" placeholder="Enter Price in  &pound;">
                                </div>
                              </div>
                  <!-- <div class="col-lg-6">
                    <div class="form-group">
                      <label>{{ __('Status') }} *</label>
                      <select name="status" id="" class="form-control">
                        <option value="1" selected>{{ __('Active') }}</option>
                        <option value="0">{{ __('Deactive') }}</option>
                      </select>
                    </div>
                  </div>  -->
                </div>


                         <!--  <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                                <label>{{ __('Meta Keywords') }} </label>
                                <input class="form-control" name="{{ $language->code }}_meta_keyword"
                                  placeholder="Enter Meta Keywords" data-role="tagsinput">
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                                <label>{{ __('Meta Description') }}</label>
                                <textarea class="form-control" name="{{ $language->code }}_meta_description" rows="5"
                                  placeholder="Enter Meta Description"></textarea>
                              </div>
                            </div> -->
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
                      <input type="text" class="form-control" name="full_name" value="{{ $vendor->username }}" disabled>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label>{{ __('Email') }}</label>
                      <input type="text" value="{{ $vendor->email }}" class="form-control" name="email" disabled>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <label style="margin-left:8px; font-size: 1.2rem; color: #0d0c1b;">{{ __('Phone') }}</label>
                    <div class="form-group input-group">

                      <input  type="tel" value="{{ $vendor->phone }}" class="form-control" name="phone" required>
                       @if ($vendor->phone_verified == 1)
                        <button disabled   class="btn btn-success2" type="button">Verified</button>
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
                     <input id ="packageId" type="hidden" name="package_id" value="">
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
                  <div class="col-lg-8 col-sm-12 col-md-12">
                      <div class="form-group checkbox-xl">
                      <div> <label>{{ __('Allow contact by') }}</label></div>
                        <div class="form-check form-check-inline">

                        <input class="form-check-input" type="checkbox" name="message_center" id="inlineRadio1" value="yes" required  checked>
                        <label class="form-check-label" for="message_center">Message Center</label>
                        </div>
                        <div class="form-check form-check-inline">
                       <input class="form-check-input" type="checkbox" name="phone_text" id="inlineRadio2" value="yes">
                      <label class="form-check-label" for="message_center">Phone/Text</label>
                     </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-8 col-sm-12 col-md-12">
                      <div class="form-group checkbox-xl">
                      <div> <label>{{ __('Are you a professional trader?') }}</label></div>
                        <div class="form-check form-check-inline">

                        <input class="form-check-input traderradio" type="checkbox" name="traderstatus" id="inlineRadio1"     @if ($vendor->trader == 1) checked @endif>
                        <label class="form-check-label" for="message_center">Yes, I'm a trader</label>
                        </div>

                    </div>
                  </div>
                </div>
                <div class="row" id="trader">
                            <div class="col-lg-12 chkbox" @if ($vendor->trader == 0) style="display: none;" @endif>
                              <div class="form-group ">
                                <label>{{ __('Business Name*') }} </label>
                                <input type="text" value="{{ $vendor->vendor_info->business_name }}" class="form-control" name="business_name">
                              </div>
                            </div>

                            <div class="col-lg-12 chkbox" @if ($vendor->trader == 0) style="display: none;" @endif>
                              <div class="form-group ">
                                <label>{{ __('Business Address') }} </label>
                                <textarea id="" class="form-control "
                                  name="business_address" data-height="300">{{ $vendor->vendor_info->business_address }}</textarea>
                              </div>
                            </div>
                            <div class="col-lg-8 chkbox" @if ($vendor->trader == 0) style="display: none;" @endif>
                            <label style="margin-left:8px; font-size: 1.2rem; color: #0d0c1b;">{{ __('VAT Number') }}</label>
                            <div class="form-group input-group">

                                <input type="text" value="{{ $vendor->vendor_info->vat_number }}" class="form-control" name="vat_number">
                                @if ($vendor->vendor_info->vatVerified == 1)
                                <button disabled  title="Verified"  class="btn btn-success2" type="button"><i class='fa fa-check-circle fa-lg' aria-hidden='true'></i></button>
                                @endif
                              </div>
                            </div>
                            </div>

                  <div id = "payplans" class="row">


                  </div>
                  <div id ="packageSelected" class="row"></div>
                  <div class="col-lg-12">
                  <div class="form-group text-center">
                  <button style="width:40%" type="submit" id="CarSubmit" data-can_car_add="{{ $can_car_add }}" class="btn btn-success btn-lg btn-block">

                {{ __('Sell Now') }}
              </button></div> </div>
              </form>
                </div>



            </div>
          </div>
        </div>

        <div class="card-footer">
          <div class="row">
            <div class="col-12 text-center">

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
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    background-image: none !important;
}
option {
  padding: 0px 8px 8px;
}

.form-check [type="checkbox"]:not(:checked), .form-check [type="checkbox"]:checked {

    left: inherit !important;
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
 .dropzone .dz-preview:hover .dz-image img {
      -webkit-transform: scale(1.05, 1.05);
      -moz-transform: scale(1.05, 1.05);
      -ms-transform: scale(1.05, 1.05);
      -o-transform: scale(1.05, 1.05);
      transform: scale(1.05, 1.05);
      -webkit-filter: blur(8px);
      filter: blur(0px);
    }
    .checkbox-xl .form-check-input
{
    scale: 1.5;

}
.checkbox-xl .form-check-label
{
    padding-left: 25px;


}
.form-check .form-check-input{
  margin-left: .0em !important;
  margin-top:5px;
}
.btn-success2 {
    background: #28a745 !important;
    border-color: #28a745 !important;
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
#payplans {
    padding: 15px 15px 15px 15px;
}

.card-pricing-vendor {
    padding-bottom: 10px;
    background: #fff !important;
    text-align: center;
    overflow: hidden;
    position: relative;
    border-radius: 5px;
    -webkit-box-shadow: rgba(51, 51, 51, 0.24) 0px 1px 4px;
    -moz-box-shadow: rgba(51, 51, 51, 0.24) 0px 1px 4px;
    box-shadow: rgba(51, 51, 51, 0.24) 0px 1px 4px;
    min-height: 400px;
}

.pricing-content-align {
    min-height: 133px;
}

.price-rcomm {
    background-color: rgb(0, 170, 255);
    padding: 5px;
    color: #fff;
    font-size: 14px;
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
    const account_status = "{{ Auth::guard('vendor')->user()->status }}";
    const secret_login = "{{ Session::get('secret_login') }}";
  </script>

  <script src="{{ asset('assets/js/car.js?v=0.6') }}"></script>
  <script>
    var labels = "{!! $labels !!}";
    var values = "{!! $values !!}";
  </script>
  <script type="text/javascript" src="{{ asset('assets/js/admin-partial.js?v=0.2') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/admin-dropzone.js?v=0.13') }}"></script>

@endsection
