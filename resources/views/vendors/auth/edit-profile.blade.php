@extends("frontend.layouts.layout-v$settings->theme_version")
@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('Signup') }}
  @else
    {{ __('Signup') }}
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
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Signup'),
  ])
  <div class="user-dashboard pt-20 pb-60">
    <div class="container">



  <div class="row gx-xl-5">

       @includeIf('vendors.partials.side-custom')



    <div class="col-md-9">


  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-12">
              <div class="card-title">{{ __('Edit Profile') }}</div>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12 mx-auto">
              @php
                   $vendor_info = App\Models\VendorInfo::where('vendor_id', $vendor->id)->where('language_id', $language->id)->first();
              @endphp

              @foreach ($languages as $language)

              <form id="ajaxEditForm" action="{{ route('vendor.update_profile') }}" method="post">
                @csrf

                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label for="">{{ __('Photo') }}</label>
                      <br>
                      <div class="thumb-preview" id="image-preview">
                        @if ($vendor->photo != null)
                          <img src="{{ asset('assets/admin/img/vendor-photo/' . $vendor->photo) }}" alt="..."  class="uploaded-img">

                            <a href="javascript:void(0);" onclick="removeImage(this)" style="    color: red;
                            position: absolute;
                            background: white;
                            padding: 3px;
                            top: 40px;
                            left: 0px;
                            height: 30px;
                            width: 30px;
                            border-radius: 50%;
                            text-align: center;
                            border: 1px solid #ff0000;">
                            <i class="fa fa-times" aria-hidden="true"></i></a>

                        @else
                          <img src="{{ asset('assets/img/noimage.jpg') }}" alt="..." class="uploaded-img">
                        @endif
                      </div>


                      <div class="mt-3">
                        <div role="button" class="btn btn-primary btn-sm upload-btn">
                          {{ __('Choose Photo') }}
                          <input type="file" class="img-input" name="photo">
                        </div>
                        <p id="editErr_photo" class="mt-1 mb-0 text-danger em"></p>
                        <p class="mt-2 mb-0 text-warning">{{ __('Image Size 80x80') }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                  <div class="form-group">
                      <h5>I'm a:</h5>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input traderradio" type="radio" name="traderstatus" value="1" id="flexRadioDefault1" @if ($vendor->trader == 1) checked @endif>
                        <label class="form-check-label" for="flexRadioDefault1">
                          Trader
                        </label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input traderradio" type="radio" name="traderstatus" value="0" id="flexRadioDefault2"
                        @if ($vendor->trader == 0) checked @endif>
                        <label class="form-check-label" for="flexRadioDefault2">
                          Private Seller
                        </label>
                      </div>
                  </div>
                </div>

                <div class="col-lg-4 chkbox" @if ($vendor->trader == 0) style="display: none;" @endif>
                    <div class="form-group">
                      <label>{{ __('Business Name') }}</label>
                      <input type="text" value="{{ $vendor_info->business_name }}" class="form-control" name="business_name">
                      <p id="editErr_business_name" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-4 chkbox" @if ($vendor->trader == 0) style="display: none;" @endif>
                    <div class="form-group">
                      <label>{{ __('VAT Number (if applicable)') }}</label>
                      <input type="text" value="{{ $vendor_info->vat_number }}" class="form-control" name="vat_number">
                      <p id="editErr_vat_number" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-4 chkbox" @if ($vendor->trader == 0) style="display: none;" @endif>
                    <div class="form-group">
                      <label>{{ __('Business Address') }}</label>
                      <input type="text" value="{{ $vendor_info->business_address }}" class="form-control" name="business_address">
                      <p id="editErr_business_address" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label>{{ __('Name*') }}</label>
                      <input type="text" value="{{ !empty($vendor_info) ? $vendor_info->name : '' }}"
                        class="form-control" name="name" placeholder="Enter Name" disabled>
                      <p id="editErr_{{ $language->code }}_name" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label>{{ __('Email*') }}</label>
                      <input type="text" value="{{ $vendor->email }}" class="form-control" name="email" disabled>
                      <p id="editErr_email" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <label style="margin-left:8px; font-size:1.2rem;color:black;">{{ __('Phone') }} </label>
                    <div class="form-group input-group">

                     <div class="d-flex">
                        <div class="custom-select">
                        <div class="select-selected">

                            @php
                                $ct = $country_codes->firstWhere('country', 'United Kingdom');

                                $flagUrl = $ct->flag_url;
                                $flagcode = $ct->code;
                                $s_code = $ct->short_code;

                                if(!empty($vendor->country_code))
                                {
                                    $ct = $country_codes->firstWhere('code', $vendor->country_code);

                                    $flagUrl = $ct->flag_url;
                                    $flagcode = $ct->code;
                                    $s_code = $ct->short_code;

                                }

                            @endphp
                        <img src="{{ $flagUrl }}" alt="UK Flag" class="flag">
                        <span class="short_code"> {{$s_code}} </span> ({{ $flagcode }})
                        </div>
                        <div class="select-items select-hide">
                        <div class="search-box">
                        <input type="text" id="country-search" placeholder="Search country...">
                        </div>
                        @foreach($country_codes as $country)
                        <div class="country-option" data-value="{{ $country->code }}" data-flag="{{ $country->flag_url }}">
                        <img src="{{ $country->flag_url }}" alt="{{ $country->country }}" class="flag">
                        <span  class="short_code">  {{$country->short_code}} </span> <span style="display:none;">{{$country->country}}</span> ({{ $country->code }})
                        </div>
                        @endforeach
                        </div>
                        </div>

                        <input type="hidden" name="c_code" id="c_code" value="{{ !empty(Auth::guard('vendor')->user()->country_code) ? Auth::guard('vendor')->user()->country_code : '+44' }}"/>

                        <input  type="number" value="{{ $vendor->phone }}" style="height: 40px;margin-top: 10px;    margin-right: 5px;" class="form-control" name="phone" required>


                       @if ($vendor->phone_verified == 1)
                        <button disabled   class="btn  btn-success2"  style="    height: 40px;
                        margin-top: 10px;
                        font-size: 25px;
                        padding-top: 5px;
                        width: 50px;
                        padding-left: 12px;
                        background: transparent;
                        color: #1b87f4;" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
                         @else
                        <button  id="verifyPhone" class="btn btn-outline-secondary"  style="height: 40px;
                        margin-top: 10px;
                        font-size: 25px;
                        padding-top: 5px;
                        width: 50px;
                        padding-left: 12px;
                        background: transparent;
                        color: #1b87f4;" type="button" title="verify"><i class='fas fa-fingerprint'></i></button>
                        @endif

                        </div>
                     <small>Verify your phone number and help reduce fraud and scams on Listit</small>
                      <p id="editErr_phone" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>

                  <div class="col-lg-6">
                      <div class="form-group">
                        <label>Use Whatsapp Function?</label>

                      <div class="d-flex">
                            <div style="display:flex;    margin-right: 70px;">
                            <span style="font-weight: bold;margin-right: 10px;">Yes </span> <input type="radio" name="also_whatsapp" <?= ($vendor->also_whatsapp == 1) ? 'checked' : '' ?>  />
                        </div>


                        <div style="display:flex;">
                            <span style="font-weight: bold;margin-right: 10px;">No </span> <input type="radio" name="also_whatsapp"  <?= ($vendor->also_whatsapp == 0) ? 'checked' : '' ?> />
                        </div>
                      </div>
                      </div>
                    </div>
                  <div class="col-lg-6">
                      <div class="form-group">
                        <label>{{ __('Country') }}</label>
                        <input type="text"
                          value="Isle of Man"
                          class="form-control" name="{{ $language->code }}_country"
                          placeholder="Enter Country" disabled >
                        <p id="editErr_{{ $language->code }}_country" class="mt-1 mb-0 text-danger em"></p>
                      </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                    <label>{{ __('Select your location ')  }}</label>
                    <select name="{{ $language->code }}_city" id="" class="form-control">
                    <option value="">Please select...</option>
                         @foreach ($countryArea as $area)
                    <option value="{{ $area->slug }}" {{ $area->slug == $vendor_info->city ? 'selected' : '' }}>{{ $area->name }}</option>
                         @endforeach
                    </select>
                       <!--  <input type="text" value="{{ !empty($vendor_info) ? $vendor_info->city : '' }}"
                          class="form-control" name="{{ $language->code }}_city" placeholder="Enter City" required> -->
                        <p id="editErr_{{ $language->code }}_city" class="mt-1 mb-0 text-danger em"></p>
                      </div>
                    </div>
                  <div class="col-lg-12">
                    <div id="accordion" class="">
                        <div class="version" style="border: 0px !important;">
                          <div id="collapse{{ $language->id }}"
                            class="collapse {{ $language->is_default == 1 ? 'show' : '' }}"
                            aria-labelledby="heading{{ $language->id }}" data-parent="#accordion">
                            <div class="version-body" >
                              <div class="row">
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" {{ $vendor->show_email_addresss == 1 ? 'checked' : '' }}
                              name="show_email_addresss" class="custom-control-input" id="show_email_addresss">
                            <label class="custom-control-label"
                              for="show_email_addresss">{{ __('Show Email Address in Profile Page') }}</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" {{ $vendor->show_phone_number == 1 ? 'checked' : '' }}
                              name="show_phone_number" class="custom-control-input" id="show_phone_number">
                            <label class="custom-control-label"
                              for="show_phone_number">{{ __('Show Phone Number in Profile Page') }}</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" {{ $vendor->show_contact_form == 1 ? 'checked' : '' }}
                              name="show_contact_form" class="custom-control-input" id="show_contact_form">
                            <label class="custom-control-label"
                              for="show_contact_form">{{ __('Show  Contact Form') }}</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
        <div class="row justify-content-center">
    <div class="col-12 col-lg-12 col-xl-12 mx-auto">
        <div class="my-4">
        <h4 class="mb-4 mt-5 ms-3">Notification Preferences</h4>
            <div class="list-group mb-5 ">
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col">
                            <strong class="mb-0">Listit News & Offers</strong>
                            <p class="text-muted mb-0">We'll send you members-only updates, news and offers.</p>
                        </div>
                        <div class="col-auto p-3">
                          <div class="custom-control  form-switch">
                            <input class="form-check-input" name="notification_news_offer" type="checkbox" role="switch" {{ $vendor->notification_news_offer == 1 ? 'checked' : '' }}>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col">
                            <strong class="mb-0">Saved Searches</strong>
                            <p class="text-muted mb-0">We'll let you know when new ads are added to your saved searches. You can turn on/off alerts below or manage individual alerts here.</p>
                        </div>
                        <div class="col-auto p-3">
                          <div class="custom-control  form-switch">
                            <input name="notification_saved_search" class="form-check-input" type="checkbox" role="switch" {{ $vendor->notification_saved_search == 1 ? 'checked' : '' }}>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col">
                            <strong class="mb-0">Selling Tips & Tools</strong>
                            <p class="text-muted mb-0">We'll send you stats on your ads performance, important reminders and selling tips..</p>
                        </div>
                        <div class="col-auto">
                          <div class="custom-control  form-switch">
                            <input name="notification_tips" class="form-check-input" type="checkbox" role="switch" {{ $vendor->notification_tips == 1 ? 'checked' : '' }}>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col">
                            <strong class="mb-0">Recommendations</strong>
                            <p class="text-muted mb-0">We'll send you suggested ads you may like based on your searches</p>
                        </div>
                        <div class="col-auto">
                          <div class="custom-control  form-switch">
                            <input name="notification_recommendations" class="form-check-input" type="checkbox" role="switch" {{ $vendor->notification_recommendations == 1 ? 'checked' : '' }}>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col">
                            <strong class="mb-0">Saved Ads</strong>
                            <p class="text-muted mb-0">We'll let you know when there are updates to your saved ads, like price changes.</p>
                        </div>
                        <div class="col-auto">
                          <div class="custom-control  form-switch">
                            <input name="notification_saved_ads" class="form-check-input" type="checkbox" role="switch" {{ $vendor->notification_saved_ads == 1 ? 'checked' : '' }}>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                </div>
              </form>
              @endforeach
            </div>
          </div>
        </div>

        <div class="card-footer">
          <div class="row">
            <div class="col-12 text-center">
              <button type="submit" id="updateBtn" class="btn btn-success">
                {{ __('Update') }}
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


{{-- select2 css --}}
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/front/css/pages/inner-pages.css') }}">
{{-- admin-main css --}}
<link rel="stylesheet" href="{{ asset('assets/css/admin-main.css') }}">
<style type="">
  #carForm .form-control {
    display: block;
    width: 80%;
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
 .btn-success2 {
    background: #28a745 !important;
    border-color: #28a745 !important;
}
.list-group {
    display: flex;
    flex-direction: column;
    padding-left: 0;
    margin-bottom: 0;
    border-radius: 0.25rem;
}

.list-group-item-action {
    width: 100%;
    color: #4d5154;
    text-align: inherit;
}
.list-group-item-action:hover,
.list-group-item-action:focus {
    z-index: 1;
    color: #4d5154;
    text-decoration: none;
    background-color: #f4f6f9;
}
.list-group-item-action:active {
    color: #8e9194;
    background-color: #eef0f3;
}

.list-group-item {
    position: relative;
    display: block;
    padding: 0.75rem 1.25rem;
    background-color: #ffffff;
    border: 1px solid #eef0f3;
}
.list-group-item p{
  font-size:14px;
}
.form-check-input[type=checkbox]{
  zoom:1.6;
  background-color:#CCCCCC;
  border-color:#CCCCCC !important;
  --bs-form-switch-bg:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e") !important;

}.form-check-input:checked[type=checkbox]{
  zoom:1.6;
  background-color:#31CE36;
  border-color:#31CE36 !important;

}


.list-group-item:first-child {
    border-top-left-radius: inherit;
    border-top-right-radius: inherit;
}
.list-group-item:last-child {
    border-bottom-right-radius: inherit;
    border-bottom-left-radius: inherit;
}
.list-group-item.disabled,
.list-group-item:disabled {
    color: #6d7174;
    pointer-events: none;
    background-color: #ffffff;
}
.list-group-item.active {
    z-index: 2;
    color: #ffffff;
    background-color: #1b68ff;
    border-color: #1b68ff;
}
.list-group-item + .list-group-item {
    border-top-width: 0;
}
.list-group-item + .list-group-item.active {
    margin-top: -1px;
    border-top-width: 1px;
}

.list-group-horizontal {
    flex-direction: row;
}
.list-group-horizontal > .list-group-item:first-child {
    border-bottom-left-radius: 0.25rem;
    border-top-right-radius: 0;
}
.list-group-horizontal > .list-group-item:last-child {
    border-top-right-radius: 0.25rem;
    border-bottom-left-radius: 0;
}
.list-group-horizontal > .list-group-item.active {
    margin-top: 0;
}
.list-group-horizontal > .list-group-item + .list-group-item {
    border-top-width: 1px;
    border-left-width: 0;
}
.list-group-horizontal > .list-group-item + .list-group-item.active {
    margin-left: -1px;
    border-left-width: 1px;
}

@media (min-width: 576px) {
    .list-group-horizontal-sm {
        flex-direction: row;
    }
    .list-group-horizontal-sm > .list-group-item:first-child {
        border-bottom-left-radius: 0.25rem;
        border-top-right-radius: 0;
    }
    .list-group-horizontal-sm > .list-group-item:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-left-radius: 0;
    }
    .list-group-horizontal-sm > .list-group-item.active {
        margin-top: 0;
    }
    .list-group-horizontal-sm > .list-group-item + .list-group-item {
        border-top-width: 1px;
        border-left-width: 0;
    }
    .list-group-horizontal-sm > .list-group-item + .list-group-item.active {
        margin-left: -1px;
        border-left-width: 1px;
    }
}

@media (min-width: 768px) {
    .list-group-horizontal-md {
        flex-direction: row;
    }
    .list-group-horizontal-md > .list-group-item:first-child {
        border-bottom-left-radius: 0.25rem;
        border-top-right-radius: 0;
    }
    .list-group-horizontal-md > .list-group-item:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-left-radius: 0;
    }
    .list-group-horizontal-md > .list-group-item.active {
        margin-top: 0;
    }
    .list-group-horizontal-md > .list-group-item + .list-group-item {
        border-top-width: 1px;
        border-left-width: 0;
    }
    .list-group-horizontal-md > .list-group-item + .list-group-item.active {
        margin-left: -1px;
        border-left-width: 1px;
    }
}

@media (min-width: 992px) {
    .list-group-horizontal-lg {
        flex-direction: row;
    }
    .list-group-horizontal-lg > .list-group-item:first-child {
        border-bottom-left-radius: 0.25rem;
        border-top-right-radius: 0;
    }
    .list-group-horizontal-lg > .list-group-item:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-left-radius: 0;
    }
    .list-group-horizontal-lg > .list-group-item.active {
        margin-top: 0;
    }
    .list-group-horizontal-lg > .list-group-item + .list-group-item {
        border-top-width: 1px;
        border-left-width: 0;
    }
    .list-group-horizontal-lg > .list-group-item + .list-group-item.active {
        margin-left: -1px;
        border-left-width: 1px;
    }
}

@media (min-width: 1200px) {
    .list-group-horizontal-xl {
        flex-direction: row;
    }
    .list-group-horizontal-xl > .list-group-item:first-child {
        border-bottom-left-radius: 0.25rem;
        border-top-right-radius: 0;
    }
    .list-group-horizontal-xl > .list-group-item:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-left-radius: 0;
    }
    .list-group-horizontal-xl > .list-group-item.active {
        margin-top: 0;
    }
    .list-group-horizontal-xl > .list-group-item + .list-group-item {
        border-top-width: 1px;
        border-left-width: 0;
    }
    .list-group-horizontal-xl > .list-group-item + .list-group-item.active {
        margin-left: -1px;
        border-left-width: 1px;
    }
}

.list-group-flush {
    border-radius: 0;
}
.list-group-flush > .list-group-item {
    border-width: 0 0 1px;
}
.list-group-flush > .list-group-item:last-child {
    border-bottom-width: 0;
}

.list-group-item-primary {
    color: #0e3685;
    background-color: #bfd5ff;
}
.list-group-item-primary.list-group-item-action:hover,
.list-group-item-primary.list-group-item-action:focus {
    color: #0e3685;
    background-color: #a6c4ff;
}
.list-group-item-primary.list-group-item-action.active {
    color: #ffffff;
    background-color: #0e3685;
    border-color: #0e3685;
}

.list-group-item-secondary {
    color: #0a395d;
    background-color: #bdd6ea;
}
.list-group-item-secondary.list-group-item-action:hover,
.list-group-item-secondary.list-group-item-action:focus {
    color: #0a395d;
    background-color: #aacae4;
}
.list-group-item-secondary.list-group-item-action.active {
    color: #ffffff;
    background-color: #0a395d;
    border-color: #0a395d;
}

.list-group-item-success {
    color: #107259;
    background-color: #c0f5e8;
}
.list-group-item-success.list-group-item-action:hover,
.list-group-item-success.list-group-item-action:focus {
    color: #107259;
    background-color: #aaf2e0;
}
.list-group-item-success.list-group-item-action.active {
    color: #ffffff;
    background-color: #107259;
    border-color: #107259;
}

.list-group-item-info {
    color: #005d83;
    background-color: #b8eafe;
}
.list-group-item-info.list-group-item-action:hover,
.list-group-item-info.list-group-item-action:focus {
    color: #005d83;
    background-color: #9fe3fe;
}
.list-group-item-info.list-group-item-action.active {
    color: #ffffff;
    background-color: #005d83;
    border-color: #005d83;
}

.list-group-item-warning {
    color: #855701;
    background-color: #ffe7b8;
}
.list-group-item-warning.list-group-item-action:hover,
.list-group-item-warning.list-group-item-action:focus {
    color: #855701;
    background-color: #ffde9f;
}
.list-group-item-warning.list-group-item-action.active {
    color: #ffffff;
    background-color: #855701;
    border-color: #855701;
}

.list-group-item-danger {
    color: #721c24;
    background-color: #f5c6cb;
}
.list-group-item-danger.list-group-item-action:hover,
.list-group-item-danger.list-group-item-action:focus {
    color: #721c24;
    background-color: #f1b0b7;
}
.list-group-item-danger.list-group-item-action.active {
    color: #ffffff;
    background-color: #721c24;
    border-color: #721c24;
}

.list-group-item-light {
    color: #7f8081;
    background-color: #fcfcfd;
}
.list-group-item-light.list-group-item-action:hover,
.list-group-item-light.list-group-item-action:focus {
    color: #7f8081;
    background-color: #ededf3;
}
.list-group-item-light.list-group-item-action.active {
    color: #ffffff;
    background-color: #7f8081;
    border-color: #7f8081;
}

.list-group-item-dark {
    color: #17191c;
    background-color: #c4c5c6;
}
.list-group-item-dark.list-group-item-action:hover,
.list-group-item-dark.list-group-item-action:focus {
    color: #17191c;
    background-color: #b7b8b9;
}
.list-group-item-dark.list-group-item-action.active {
    color: #ffffff;
    background-color: #17191c;
    border-color: #17191c;
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
<!--
@if (session()->has('success'))
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
@endif

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
 -->


{{-- select2 js --}}
<script type="text/javascript" src="{{ asset('assets/js/select2.min.js') }}"></script>

{{-- admin-main js --}}
<script type="text/javascript" src="{{ asset('assets/js/admin-main.js') }}?v=0.5"></script>

  <script>
    'use strict';
    var storeUrl = "{{ route('car.imagesstore') }}";
    var removeUrl = "{{ route('user.car.imagermv') }}";
    var getBrandUrl = "{{ route('user.get-car.brand.model') }}";
    const account_status = "{{ Auth::guard('vendor')->user()->status }}";
    const secret_login = "{{ Session::get('secret_login') }}";

  </script>


  <script>
    var labels = "{!! $labels !!}";
    var values = "{!! $values !!}";
  </script>


@endsection
