@extends("frontend.layouts.layout-v$settings->theme_version")
@section('pageHeading')
  {{ !empty($pageHeading) ? $pageHeading->vendor_login_page_title : __('Login to Listit') }}
@endsection
@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keywords_vendor_login }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_vendor_login }}
  @endif
@endsection

@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_login_page_title : __('Login to Listit'),
  ])
  <!-- Authentication-area start -->
  <div class="authentication-area ptb-100">
    <div class="container">
    <div class="">
      <div class="auth-form border radius-md">
        @if (Session::has('success'))
          <div class="alert alert-success">{{ __(Session::get('success')) }}</div>
        @endif
        @if (Session::has('error'))
          <div class="alert alert-danger">{{ __(Session::get('error')) }}</div>
        @endif

          <div class="title">
           <h4 class="mb-20">{{ __('Verify your phone number') }}</h4>
           <p>In order to protect the security of your account, please verify your phone number</p>
          </div>
          <form action="{{ route('vendor.send_code') }}" method="POST" class = "verifyopt-form">
          <!--@csrf-->
          <div id = "phonecode">
          <label>{{ __('Enter phone number') }}</label>
          <div class="form-group mb-30 d-flex flex-row">

          <input type="text" class="form-control w-50" style = "margin-right:5px;" name="country_code"  value="+44" >
            <input type="text" class="form-control" name="phone_number"  required>
            @error('username')
             <p class="text-danger mt-2">{{ $message }}</p>
           @enderror
          </div>
          <button type="submit" class="btn btn-lg btn-primary radius-md w-100"> {{ __('Send code') }} </button>
          </div>
          </form>
          <form action="{{ route('vendor.verify_code') }}" method="POST" class = "verifyopt-code">
          @csrf
          <div id = "verifycode">
          <p class ="mycode">Enter the code via text to </p>
          <div class="form-group mb-30 d-flex flex-row">
 <input type="text" class="form-control" name="code" >



          </div>
          <p class="text-danger-code text-danger mt-2"></p>
          <button type="submit" class="btn btn-lg btn-primary radius-md w-100"> {{ __('Verify Phone') }} </button>
          </div>
          </form>

      </div>
      </div>
    </div>
  </div>
  <!-- Authentication-area end -->
@endsection
