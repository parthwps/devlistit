@php
  $version = $basicInfo->theme_version;
@endphp
@extends("frontend.layouts.layout-v$version")

@section('pageHeading')
  {{ __('About Us') }}
@endsection

@section('content')
<section class="breadcrumb-area bg-primary text-white ">
  <div class="container">
    @includeIf('frontend.partials.breadcrumb', [
        'title' => __('About Us'),
    ])
  </div>
</section>

  <!-- About Us Section -->
  <section class="about-us-area pt-100 pb-100">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4" data-aos="fade-right">
          <div class="image">
            <img src="{{ asset('assets/img/63c8f6b0da689.png') }}" alt="About Us Image" class="img-fluid">
          </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
          <h2 class="section-title text-primary">{{ __('Welcome to ListIt') }}</h2>
          <p class="">
            Welcome to ListIt, where buying and selling is simple, safe, and secure. Since 2022, we’ve been redefining the way people buy and sell vehicles—whether it’s cars, commercial vehicles, farming equipment, or beyond. By embracing cutting-edge technology and innovative solutions, we make navigating the marketplace easier, faster, and more reliable than ever before.          </p>
          <p>
            At ListIt.im our mission is to simplify the buying and selling process by providing a trustworthy platform that you can count on. We know how frustrating it can be to sift through endless listings, dodge scams, and deal with irrelevant ads. That’s why we’ve built a marketplace that offers a seamless, straightforward experience where you can make well-informed decisions with ease.          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Why Choose ListIt Section -->
  {{-- <section class="features-area bg-light py-5">
    <div class="container">
      <div class="section-title text-center mb-5">

        <h2>
            {{ __('Here’s how ') }}
            <span class="text-primary">{{ __('ListIt.im') }}</span>
            {{ __(' stands out:') }}
        </h2>
    </div>

      <div class="row mt-0 ">
        @php
          $features = [
              ['icon' => 'fas fa-pound-sign', 'title' => 'Simple Price Comparison', 'text' => 'Effortlessly compare prices, makes, models, and more, so you can find the best deal in just a few clicks & made Exclusive Deals & Models.
'],
              ['icon' => 'fas fa-shield-alt', 'title' => 'Safe Transactions', 'text' => 'Shop or sell with confidence, knowing that our platform is equipped with robust security features to ensure a safe experience every time.'],
              ['icon' => 'fas fa-check-circle', 'title' => 'Secure Listings', 'text' => 'Our team diligently reviews all listings to ensure they’re legitimate, so you can browse without worrying about scams or misleading offers.'],
              ['icon' => 'fas fa-map-marker-alt', 'title' => 'Filter by Location', 'text' => 'Quickly find options near you by filtering results by location, helping you narrow down your choices and saving you time.'],
              ['icon' => 'fas fa-th-large', 'title' => 'Diverse Options', 'text' => 'Access a wide variety of listings from both private sellers and trusted dealerships, giving you more options to choose from.'],
              ['icon' => 'fas fa-headset', 'title' => 'Dedicated Support', 'text' => ' Our expert customer service team is always ready to assist, ensuring a smooth and stress-free experience from start to finish.']
          ];
        @endphp
        @foreach ($features as $feature)
          <div class="col-lg-4 col-md-6">
            <div class="card feature-card text-center p-4">
              <div class="card-icon mb-3">
                <i class="{{ $feature['icon'] }} fa-2x color-primary"></i>
              </div>
              <h4 class="card-title text-dark">{{ $feature['title'] }}</h4>
              <p class="card-text">{{ $feature['text'] }}</p>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section> --}}
  <section class="features-area bg-light py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>
                {{ __('Here’s how ') }}
                <span class="text-primary">{{ __('ListIt.im') }}</span>
                {{ __(' stands out:') }}
            </h2>
        </div>

        <div class="row mt-0">
            @php
                $features = [
                    ['icon' => 'fas fa-pound-sign', 'title' => 'Simple Price Comparison', 'text' => 'Effortlessly compare prices, makes, models, and more, so you can find the best deal in just a few clicks & made Exclusive Deals & Models.'],
                    ['icon' => 'fas fa-shield-alt', 'title' => 'Safe Transactions', 'text' => 'Shop or sell with confidence, knowing that our platform is equipped with robust security features to ensure a safe experience every time.'],
                    ['icon' => 'fas fa-check-circle', 'title' => 'Secure Listings', 'text' => 'Our team diligently reviews all listings to ensure they’re legitimate, so you can browse without worrying about scams or misleading offers.'],
                    ['icon' => 'fas fa-map-marker-alt', 'title' => 'Filter by Location', 'text' => 'Quickly find options near you by filtering results by location, helping you narrow down your choices and saving you time.'],
                    ['icon' => 'fas fa-th-large', 'title' => 'Diverse Options', 'text' => 'Access a wide variety of listings from both private sellers and trusted dealerships, giving you more options to choose from.'],
                    ['icon' => 'fas fa-headset', 'title' => 'Dedicated Support', 'text' => 'Our expert customer service team is always ready to assist, ensuring a smooth and stress-free experience from start to finish.']
                ];
            @endphp
            @foreach ($features as $feature)
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                    <div class="card feature-card text-center p-4 w-100">
                        <div class="card-icon mb-3">
                            <i class="{{ $feature['icon'] }} fa-2x color-primary"></i>
                        </div>
                        <h4 class="card-title text-dark">{{ $feature['title'] }}</h4>
                        <p class="card-text">{{ $feature['text'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


  <!-- Team Message Section -->
  <section class="team-message-area pt-50 pb-50">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 order-lg-2 mb-4" data-aos="fade-left">
          <div class="image">
            <img src="{{ asset('assets/img/12345678900.png' ) }}" alt="Team Message" class="img-fluid">
          </div>
        </div>
        <div class="col-lg-6 order-lg-1" data-aos="fade-right">
          <h2 class="section-title text-justify text-primary">{{ __('From the ListIt Team') }}</h2>
          <p class="text-justify">{{ __('At ListIt.im, we are committed to creating a marketplace that is simple, safe, and secure. Explore our platform today and discover how we’re shaping the future of online classifieds.') }}</p>
          <p class="text-justify"><strong>{{ __('From all of us at the ListIt team') }}</strong></p>
        </div>
      </div>
    </div>
  </section>
@endsection
