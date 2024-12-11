@extends("frontend.layouts.layout-v$settings->theme_version")
@section('pageHeading')
  {{ !empty($pageHeading) ? $pageHeading->vendor_login_page_title : __('Login') }}
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
      'title' => "Dealer Login",
  ])
  <!-- Authentication-area start -->
  <div class="authentication-area ptb-100">
    <div class="container">
      <div class="auth-form border radius-md">
        @if (Session::has('success'))
          <div class="alert alert-success">{{ __(Session::get('success')) }}</div>
        @endif
        @if (Session::has('error'))
          <div class="alert alert-danger">{{ __(Session::get('error')) }}</div>
        @endif
         <div class="title">
            <h4 class="mb-20">{{ __('Login') }}</h4>
          </div>



        <form action="{{ route('vendor.login_submit') }}" method="POST">
          @csrf

          <div class="form-group mb-10">

        <a href="/login/google"  style="border: 1px solid #d7d7d7;
        background: #f4f4f4;
        border-radius: 5px;
        padding: 0.6rem;" class="social-login mt-20 p-10 text-center d-flex align-items-center justify-content-center">
            <img src="/google.svg" class="mr-auto" alt=" google svg">
            <span class="flex-grow-1">Login with Google account</span>
        </a>

        <div class="text-center mt-30">
                        <span class="badge badge-circle-gray300 text-secondary d-inline-flex align-items-center justify-content-center" style="font-size: 1.5rem;">OR</span>
                    </div>
        </div>

          <div class="form-group ">
            <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
            @error('email')
              <p class="text-danger mt-2">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group mb-30">
            <input type="password" class="form-control" name="password" id="password" autocomplete="off" placeholder="{{ __('Password') }}" required>
            <span id="togglePassword" class="eye-icon">
              <i class="fa fa-eye"></i>
              </span>
            @error('password')
              <p class="text-danger mt-2">{{ $message }}</p>
            @enderror
          </div>
          @if ($bs->google_recaptcha_status == 1)
            <div class="form-group mb-30">
              {!! NoCaptcha::renderJs() !!}
              {!! NoCaptcha::display() !!}

              @error('g-recaptcha-response')
                <p class="mt-1 text-danger">{{ $message }}</p>
              @enderror
            </div>
          @endif
          <div class="row align-items-center mb-20">
            <div class="col-4 col-xs-12">
              <div class="link">
                <a href="{{ route('vendor.forget.password') }}">{{ __('Forgot password') . '?' }}</a>
              </div>
            </div>
            <div class="col-8 col-xs-12">
             <div class="link go-signup">
                {{ __("Don't have an account") . '?' }} <a
                  href="{{ route('vendor.signup') }}">{{ __('Click Here') }}</a>
                {{ __('to Signup') }}
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-lg btn-primary radius-md w-100"> {{ __('Login') }} </button>
        </form>
      </div>
    </div>
  </div>
  <!-- Authentication-area end -->
@endsection
