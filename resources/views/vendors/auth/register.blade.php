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
        <form action="{{ route('vendor.signup_submit') }}" method="POST" id="signup-form">
          @csrf
          <div class="title">
            <h4 class="mb-15">{{ __('Signup') }}</h4>
          </div>

          <!-- <div class="form-group">
            <h5>Are You a</h5>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="traderstatus" value="1" id="flexRadioDefault1">
              <label class="form-check-label" for="flexRadioDefault1">
                Trader
              </label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="traderstatus" value="0" id="flexRadioDefault2" checked>
              <label class="form-check-label" for="flexRadioDefault2">
                Private Seller
              </label>
            </div>
          </div> -->
          <div class="form-group mb-10">
            <input type="text" class="form-control" autocomplete="off" name="username" placeholder="Full Name" required>
            @error('username')
              <p class="text-danger mt-2">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group mb-10">
            <input type="text" class="form-control" autocomplete="off" name="email" placeholder="{{ __('Email') }}" required>
            @error('email')
              <p class="text-danger mt-2">{{ $message }}</p>
            @enderror
          </div>
          <!-- <div class="form-group mb-20">
            <input type="text" class="form-control" name="phone" placeholder="{{ __('Phone No') }}" required>
            @error('phone')
              <p class="text-danger mt-2">{{ $message }}</p>
            @enderror
          </div> -->
          <div class="form-group mb-10">
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
            <input type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}"
            class="form-control" placeholder="{{ __('Confirm Password') }}" required>
            <span id="togglePasswordConfirmation" class="eye-icon">
            <i class="fa fa-eye"></i>
            </span>
            </div>
            @error('password_confirmation')
              <p class="text-danger mt-2">{{ $message }}</p>
            @enderror
          </div>
          @php
          $languages = App\Models\Language::get();
          @endphp
          <div class="row mb-20">
          @foreach ($languages as $language)
          <div class="col-lg-6">
          <div class="form-group">
              <label>{{ __('Country') }}</label>
              <input type="text"
                value="Isle of Man"
                class="form-control" name=""
                placeholder="Enter Country" disabled >
                <input type="hidden" name="country" value="Isle of Man">
              <p id="editErr_{{ $language->code }}_country" class="mt-1 mb-0 text-danger em"></p>
          </div>
        </div>
          <div class="col-lg-6">
            <div class="form-group">
            <label>{{ __('Select your location ')  }}</label>
            <select name="city" id="" class="form-control" required>
            <option value="">Please select...</option>
                 @foreach ($countryArea as $area)
            <option value="{{ $area->slug }}" >{{ $area->name }}</option>
                 @endforeach
            </select>
                <p id="editErr_city" class="mt-1 mb-0 text-danger em"></p>
              </div>
            </div>
          @endforeach
          </div>
          @if ($recaptchaInfo->google_recaptcha_status == 1)
            <div class="form-group mb-15">
              {!! NoCaptcha::renderJs() !!}
              {!! NoCaptcha::display() !!}

              @error('g-recaptcha-response')
                <p class="mt-1 text-danger">{{ $message }}</p>
              @enderror
            </div>
          @endif
          <div class="form-group ">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="link">
              <p>To get the most from Listit. We will send you members only updates via email, push notification
              and on site messsaging. You can update our prefrences at anytime from Your Listit account page.</p>
                </div>
              </div>
            </div>
            </div>
          <div class="form-group">
            <div class="row align-items-center ">
              <div class="col-12">
                <div class="link">
              <input type = "checkbox"  name ="notification_allowed" style="width:1.2rem; height:1.2rem; padding-top:5px;" value="1" >  &nbsp; Yes I Agree</a>
                </div>
              </div>
            </div>
            </div>
          <div class="row align-items-center mb-10">
            <div class="col-12">
              <div class="link">
               {{ __('Already have an account') . '?' }} <a
                  href="{{ route('vendor.login') }}">{{ __('Click Here') }}</a>
                {{ __('to Login') }}
              </div>
            </div>
          </div>
          <button type="submit" id="signup-button" class="btn btn-lg btn-primary radius-md w-100" disabled> {{ __('Signup') }} </button>
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
