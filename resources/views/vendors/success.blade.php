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
      'breadcrumb' => 123,
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
            <div class="col-lg-5">
              <div class="card-title d-inline-block">
                {{ __('Payment Success') }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card-body">
        <div class="row">
          <div class="col-lg-6 mx-auto">
            <div class="card p-4 text-center">
            <img class="lazyload"
                        data-src="{{ asset('assets/admin/img/car-gallery/ad-success.png') }}"
                        alt="">
            </div>
          </div>
          <div class="col-lg-6 mx-auto">
            <div class="card p-4 text-center">
              <div class="mb-3">
                <i class="fas fa-check color-white p-3 rounded-circle bg-success text-white"></i>
              </div>
              <h1>{{ __('Success') }}</h1>
              <p>{{ __('Your Payment successfsssully completed.') }}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="card-footer"></div>
    </div>
  </div>
  </div>
  </div>
  </div>
  </div>
@endsection
