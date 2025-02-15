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
  <!-- Authentication-area start -->
  <div class="authentication-area ptb-60">
    <div class="container">
      <div class="auth-form border radius-md">
        @if (Session::has('success'))
          <div class="alert alert-success">{{ __(Session::get('success')) }}</div>
        @endif
        <form action="{{ route('vendor.signup_submit') }}" method="POST"  id="signup-form">
          @csrf
          <div class="title">
            <h4 class="mb-20">{{ __('Signup') }}</h4>
          </div>

          <div class="form-group" hidden>
            <h5>Are You a</h5>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="traderstatus" value="1" id="flexRadioDefault1">
              <label class="form-check-label" for="flexRadioDefault1">
                Dealer
              </label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="traderstatus" value="0" id="flexRadioDefault2" checked>
              <label class="form-check-label" for="flexRadioDefault2">
                Private Seller
              </label>
            </div>
          </div>

          <div class="form-group mb-20">
            <input type="text" class="form-control" name="email" placeholder="{{ __('Email') }}" required>
            @error('email')
              <p class="text-danger mt-2">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group mb-20">
            <input type="text" class="form-control" name="phone" placeholder="{{ __('Phone No') }}" required>
            @error('phone')
              <p class="text-danger mt-2">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group mb-20">
            <div class="password-container">
              <input type="password" id="password" class="form-control" autocomplete="off" name="password" placeholder="{{ __('Password') }}" required>
              <span id="togglePassword" class="eye-icon">
              <i class="fa fa-eye"></i>
              </span>
              </div>
              @error('password')
                <p class="text-danger mt-2">{{ $message }}</p>
              @enderror
          </div>
          <div class="form-group mb-20">
            <div class="password-container">
            <input type="password" name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation') }}"
              class="form-control" placeholder="{{ __('Confirm Password') }}" required>
              <span id="togglePasswordConfirmation" class="eye-icon">
                <i class="fa fa-eye"></i>
                </span>
            </div>
            @error('password_confirmation')
              <p class="text-danger mt-2">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group mb-20">
            <input type="text" class="form-control" name="username" placeholder="{{ __('Username') }}" required>
            @error('username')
              <p class="text-danger mt-2">{{ $message }}</p>
            @enderror
          </div>
          {{-- @if ($recaptchaInfo->google_recaptcha_status == 1)
            <div class="form-group mb-20">
              {!! NoCaptcha::renderJs() !!}
              {!! NoCaptcha::display() !!}

              @error('g-recaptcha-response')
                <p class="mt-1 text-danger">{{ $message }}</p>
              @enderror
            </div>
          @endif --}}

          <div class="row align-items-center mb-20">
            <div class="col-12">
              <div class="link">
                {{ __('Already have an account') . '?' }} <a
                  href="{{ route('vendor.login') }}">{{ __('Click Here') }}</a>
                {{ __('to Login') }}
              </div>
            </div>
          </div>
          <button id="signup-button" type="submit" class="btn btn-lg btn-primary radius-md w-100" disabled> {{ __('Signup') }} </button>
        </form>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const form = document.getElementById('signup-form');
      const inputs = form.querySelectorAll('input[required], select[required]');
      const submitButton = document.getElementById('signup-button');

      const validateForm = () => {
        let isValid = true;
        inputs.forEach(input => {
          if (!input.value.trim()) {
            isValid = false;
          }
        });
        submitButton.disabled = !isValid;
      };

      inputs.forEach(input => {
        input.addEventListener('input', validateForm);
      });

      validateForm();
    });
  </script>
  <!-- Authentication-area end -->
@endsection
