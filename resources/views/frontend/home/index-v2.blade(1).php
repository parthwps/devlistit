@php
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layouts.layout-v' . $version)

@section('pageHeading')
  {{ __('Listit | Isle of Man\'s Largest  Classifieds Marketplace') }}
@endsection

@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keyword_home }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_home }}
  @endif
@endsection

@section('content')

<style>
    .us_loan
    {
        margin-left: 5px;
        margin-top: 5px;
    }

    * {
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none;  /* IE and Edge */
    }

    ::-webkit-scrollbar {
        display: none;  /* Chrome, Safari */
    }


    .hero-banner-2{
      margin-top: 0px !important;
    }

    .font-type{
      font-family: 'Urbanist';
      font-style: normal;
      font-weight: bold;      
    }

    /* Set the color to blue when the li has the active class */
    .nav-item.active .nav-link {
        color: #348ceb;
    }

    .nextprevbtn {
      z-index: 999; /* Higher z-index to make the buttons visible above other content */
    }
    
    .loading-section{
      display: none !important;
    }

    /* General card container styling */
.card-container {
    padding: 25px;
    text-align: center;
}

/* Styling for the icon container (blue circle with white icon inside) */
.card-icon-container {
    background-color: #007bff; /* Blue background */
    color: #ffffff; /* White icon color */
    width: 100px; /* Set width and height to make the icon round */
    height: 100px;
    border-radius: 50%; /* Make the icon container a circle */
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto; /* Center the icon in the card */
    font-size: 40px; /* Adjust icon size */
}

/* Card title (heading) */
.card-title {
    font-size: 20px;
    color: #000000; /* Black color for heading */
    margin-bottom: 20px;
    font-weight: bold;
}

/* Subtitle or text below the heading */
.card-text {
    font-size: 14px;
    color: #a0a0a0; /* Light gray color for text */
    line-height: 1.5;
}

.vendor-info-container {
  display: flex;
  flex-direction: column;
  background-color: white; /* Background color for the container */
  padding: 15px;
  border-radius: 10px;
  color: black;
  max-width: 500px; /* Card width */
}

.vendor-info {
  display: flex;
  align-items: center;
  margin-bottom: 15px;
}

.vendor-info img {
  border-radius: 10%; /* Rounded corners */
  width: 100px; /* Increase the width as needed */
  height: 100px; /* Increase the height as needed */
  margin-right: 15px; /* Space between image and vendor details */
}

.vendor-details h1 {
  margin: 0;
  font-size: 28px;
}

.dealer-info {
  font-size: 22px;
  margin-top: 5px;
  color: #74787a;
}

.vendor-title{
  font-size: 20px;
  /* margin-top: 5px; */

}

.stock-ads {
  margin-top: 5px;
  font-size: 14px;
  color: #74787a;
}

/* Flexbox for the featured tag and stock ads */
.featured-stock-info {
  display: flex;
  justify-content: space-between; /* Align featured tag to left and stock ads to right */
  align-items: center;
  margin-top: 10px;
}

.featured-tag {
  background-color: #E7F2FF; 
  border: 2px solid #1D86F5; 
  color: #1D86F5;
  padding: 5px 10px;
  border-radius: 5px;
  font-size: 14px;
  /* font-weight: bold; Make the text bold if desired */
}

.stock-ads-right {
  font-size: 16px;
  color: #74787a;
}

.showroom-button,.blog-button {
  display: inline-block;
  background-color: #1D86F5;
  color: white;
  padding: 10px 20px; /* Padding for a form control look */
  margin-top: 30px;
  margin-bottom: 13px;
  border: none;
  border-radius: 5px;
  text-decoration: none;
  font-size: 16px;
  width: 100%; /* Make the button stretch like a form control */
  text-align: center; /* Center the text */
}

.showroom-button:hover {
  background-color: #0056b3; /* Darker blue on hover */
}

.dealer-card {
  margin-left: 5%;
}

</style>
  <!-- Home-area start-->
  <section  class="hero-banner hero-banner-2" style="margin:0;border-radius:0;box-shadow: 0px 0px 0px;">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="swiper home-slider" id="home-slider-2" data-aos="">
          </div>
        </div>
        <div class="col-12">
        
        </div>
        <div class="col-lg-4 col-xl-6 us_homeclmn">
          <div class="banner-filter-form mw-60" data-aos="fade-up">
            <p class="text font-lg justify-content-center"></p>
            <ul class="nav nav-tabs border-0 m-3 bg-white" style="border-radius: 10px;">
             
                  <li class="nav-item active">
                    <button class="nav-link car_condition font-type" data-image = "newbanner.png" data-id="24" data-bs-toggle="tab"
                      data-bs-target="#all" type="button" style="color:#1D86F5">
                            
                      <i class="fas fa-car fa-fw me-2" style="color:#1D86F5"></i>
                      Cars
                    </button>
                  </li>
                   <li class="nav-item">
                    <button class="nav-link car_condition font-type" data-image = "market.jpg" data-id="0" data-bs-toggle="tab"
                      data-bs-target="#all" type="button" style="color:black">
                            
                       <i class="fas fa-store fa-fw me-2" style="color:gray"></i>
                       <!-- <i class="fas fa-shopping-cart back-cart" style="color: blue;"></i> -->
                        Marketplace
                    </button>
                  </li>
                   <li class="nav-item">
                    <button class="nav-link car_condition font-type" data-image = "property.jpg"  data-id="39" data-bs-toggle="tab"
                      data-bs-target="#all" type="button" style="color:black">

                      <i class="fas fa-building fa-fw me-2" style="color:gray"></i>
                        Property
                    </button>
                  </li>
                  
                  <li class="nav-item">
                    <button class="nav-link car_condition font-type" data-image = "farming.png"  data-id="28" data-bs-toggle="tab"
                      data-bs-target="#all" type="button" style="color:black">

                      <i class="fas fa-tractor" style="color:gray"></i>
                        Farming
                    </button>
                  </li>
                  
                
             {{--  @endforeach --}}
            </ul>
            <div class="tab-content form-wrapper shadow-lg p-20">
              <div class="tab-pane fade active show" id="all">
                <input type="hidden" name="getModel" id="getModel" value="{{ route('fronted.get-car.brand.model') }}">
                <form action="{{ route('frontend.cars') }}" method="GET" id= "homesearchform">
                <input class="form-control" type="hidden" value="cars-&-motors" name ="category" id="tabsCat">
                  <div class="row align-items-center gx-xl-3">
                    <div class="col-lg-12">
                      <div class="row ">
                       
                        <div class="col-md col-sm-6 carform">
                          <div class="mb-20">
                            <select class="form-control js-example-basic-single1 font-type" id="car_brand" name="brands[]">
                            <option value="">{{ __('All Makes') }}</option>
                            <option disabled>-- Popular Brands --</option>
                            @foreach ($brands as $brand)
                            <option value="{{ $brand->slug }}">{{ $brand->name }}</option>
                            @endforeach
                            <option disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-- Other Makes --</option>
                            @foreach ($otherBrands as $brand)
                            <option value="{{ $brand->slug }}">{{ $brand->name }}</option>
                            @endforeach
                            </select>

                          </div>
                        </div>
                        <div class="col-md col-sm-6 carform">
                          <div class="mb-20">
                            <select class="form-select form-control js-example-basic-single1 font-type" id="model" name="models[]">
                              <option value="">{{ __('All Models') }}</option>
                            </select>
                          </div>
                        </div>
                      </div>
                        <div class="row ">
                       <div class="col-6 col-sm-3 carform">
                          <div class="mb-20">
                            <select class="form-select form-control js-example-basic-single1 font-type" id="year_min" name="year_min">
                              <option value="">{{ __('Min Year') }}</option>
                              @foreach ($caryear as $year)
                                  <option 
                                    value="{{ $year->name }}">{{ $year->name }}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-6 col-sm-3 carform">
                          <div class="mb-20">
                            <select class="form-select form-control js-example-basic-single1 font-type" id="year_max" name="year_max">
                              <option value="">{{ __('Max Year') }}</option>
                               @foreach ($caryear as $year)
                                  <option 
                                    value="{{ $year->name }}">{{ $year->name }}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-6 col-sm-3 carform">
                          <div class="mb-20">
                          
                            <select class="form-select form-control js-example-basic-single1 font-type" id="min" name="min">
                              <option value="">{{ __('Min Price') }}</option>
                               @foreach ($adsprices as $prices)
                                  <option 
                                    value="{{ $prices->name }}">{{ symbolPrice($prices->name) }}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-6 col-sm-3 carform">
                          <div class="mb-20">
                            <select class="form-select form-control js-example-basic-single1" id="max" name="max">
                              <option value="">{{ __('Max Price') }}</option>
                              @foreach ($adsprices as $prices)
                                  <option 
                                    value="{{ $prices->name }}">{{ symbolPrice($prices->name) }}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                      </div>

                        <div class="col-12 carformtxt"  style="display: none;">
                          <div class="form-groupSearch">
                           <input type="text" class="form-control" id="searchByTitle"  name="title" value="" placeholder="Search By Title">
                           <div id="suggesstion-box" class="col-12 p-3 bg-white" style="display: none;"></div>
                          </div>
                        </div>

                        <input class="form-control" type="hidden" value="{{ $min }}" id="o_min">
                        <input class="form-control" type="hidden" value="{{ $max }}" id="o_max">
                        <input type="hidden" id="currency_symbol" value="{{ $currencyInfo->base_currency_symbol }}">
                      
                    </div>
                     <div class="col-lg-12 text-md-end">
                      <button type="button" onclick="updateUrlHome()" class="btn btn-primary bg-primary color-white w-100 searchNow">
                        {{ __('Search Now') }}</span>
                      </button>
                    </div> 
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Home-area end -->

  <!-- latest add section start -->
    <!-- @if($car_contents->count() > 0 ) -->
        
      <section class="product-area pt-60 pb-20 us_recent_pro" style=" margin:0px;border-radius:0px;box-shadow: 0px 0px 0px;margin-bottom: 1rem;">
         
        <div class="container-fluid">
          <div class="row d-flex align-items-center justify-content-center m-4 position-relative">
            <div class="row d-flex align-items-center justify-content-center" id="recent_all_ads">  
            <!-- Include recent-ads -->
              @include('frontend/home/recent-ads', ['car_contents' => $car_contents])
              @php
                  $lastindex = count($car_contents) - 1;
              @endphp
            </div>
            <input type="hidden" id="leftside" value="{{$car_contents[0]->id}}" />
              <input type="hidden" id="rightside" value="{{$car_contents[$lastindex]->id}}" />

              <!-- Left (Previous) Button -->
              <button type="button" class="nextprevbtn position-absolute" value="1" style="top: 50%; left: -25px; transform: translateY(-50%); background: white; box-shadow: 0px 0px 20px 0px rgba(76, 87, 125, 0.1);border-color: transparent; padding: 5px; height: 50px; width: 50px; border-radius: 50%; font-size: 30px; color: #A6A6A6;">
                  <i class="fa fa-angle-left" aria-hidden="true"></i>
              </button>

              <!-- Right (Next) Button -->
              <button type="button" class="nextprevbtn position-absolute" value="2" style="top: 50%; right: -25px; transform: translateY(-50%); background: white; white; box-shadow: 0px 0px 20px 0px rgba(76, 87, 125, 0.1);border-color: transparent; padding: 5px; height: 50px; width: 50px; border-radius: 50%; font-size: 30px; color: #A6A6A6;">
                  <i class="fa fa-angle-right" aria-hidden="true"></i>
              </button>
          </div>
        </div>
      </section>
    <!-- @endif       -->
  <!-- latest add  section end -->

   <!-- Steps-area start -->
   @if ($secInfo->work_process_section_status == 1)
    <section class="steps-area pt-60 pb-20 font-type" style="margin: 0px;border-radius:0px;box-shadow: 0px 0px 0px;background:#F4F9FF">
      <div class="container-fluid">
        <div class="row m-4">
        <!-- <div class="col-1"></div> -->
          <div class="col-8">
            <div class="section-title title" data-aos="" >
               <h2 class="title">{{ @$workProcessSecInfo->subtitle }}</h2>
            </div>
          </div>
          <!-- <div class="col-1"></div> -->
          <div class="col-4">  
            <div class="section-title title-center " data-aos="">
              <h4 class="title" style="color: #4a9dd9;">{{ @$workProcessSecInfo->title }}</h4>
            </div>
          </div>
          <div class="col-12 mb-20">
            <div class="row mt-4">
              @foreach ($processes as $process)
              <div class="col-lg-3 col-md-6" data-aos="">
                @include('frontend/home/dataloader')
                <div class="card-container align-items-center text-center radius-md p-25 loading-section">
                  <div class="card-icon-container mb-25">
                    <i class="{{ $process->icon }}"></i>
                  </div>
                  <div class="card-content">
                    <h4 class="card-title mb-20">{{ $process->title }}</h4>
                    <p class="card-text lc-3">{{ $process->text }}</p>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>
  @endif
  <!-- Steps-area end -->
        
<!-- Category-area start -->
  @if ($secInfo->category_section_status == 1)
    <section class="category-area category-1 pt-40 mt-4 font-type" style="margin: 0px;border-radius:0px;box-shadow: 0px 0px 0px #afafaf;">
      <div class="container-fluid">
        <div class="row m-4">
          <div class="col-12">
            <div class="section-title title-inline mb-50" data-aos="">
              <h2 class="title mb-0">{{ @$catgorySecInfo->title }}</h2>
            </div>
          </div>
          <div class="col-12">
            @include('frontend/home/dataloader')
            <div class="row m-4 tabsHtmlData loading-section">
            @foreach ($car_categories as $category)
                <div class="col-6 col-lg-3" data-aos="">
                  <a href="{{ route('frontend.cars', ['category' => $category->slug]) }}">
                     
                    <div class="category-item">

                      <div class="d-flex flex-wrap justify-content-between mb-10">

                        <h6 class="category-title mb-10">
                          <img class="lazyload blur-up category-icon" 
                              data-src="{{ asset('assets/admin/img/car-category/' . $category->image) }}?v=0.3"  
                              alt="{{ $category->name }}" 
                              title="{{ $category->name }}" style=""> 
                          {{ $category->name }}
                        </h6>
                        
                      </div>
                    
                    </div>
                  </a>
                </div>
            @endforeach

            </div>
         
          </div>
        </div>
      </div>
    </section>
  @endif
  <!-- Category-area end -->
 

  

  <!-- featured section start -->
  @if ($secInfo->feature_section_status == 1 && !empty($getFeaturedVendors->cars))
    <section class="product-area pt-60 pb-70 mt-4 font-type" style="margin: 0px;border-radius:0px;background:#F4F9FF;box-shadow: 0px 0px 0px 0px">
      <div class="container-fluid" style="border: 0px solid red;">
        <div class="row">
          <div class="col-12" data-aos="">
            <div class="section-title title-inline mb-30 dealer-card" data-aos="" style="margin-left: 3%;">
              <h1 class="title mb-20" style="color:black;font-weight:bold">
                Featured Car Dealer
              </h1>
            </div>
          </div>
          
          <div class="col-12 col-md-5" data-aos="" style="border: px solid orange;"> 
            @include('frontend/home/dataloader')   
            <div class="vendor-info-container dealer-card loading-section" style="box-shadow: 0px 0px 20px 0px rgba(76, 87, 125, 0.1);border-color: transparent;">
              @php
                $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $getFeaturedVendors->photo;
                
                if (file_exists(public_path('assets/admin/img/vendor-photo/' . $getFeaturedVendors->photo))) {
                  $photoUrl = asset('assets/admin/img/vendor-photo/' . $getFeaturedVendors->photo);
                }
              @endphp
              
              <div class="vendor-info">
                <img  
                  class="lazyload blur-up"
                  src="{{ asset('assets/img/blank-user.jpg') }}"
                  data-src="{{ $photoUrl }}"  
                  alt="Vendor" 
                  onload="handleImageLoad(this)"
                  onerror="this.onerror=null;this.src='{{ asset('assets/img/blank-user.jpg') }}';" 
                >  
              
                <div class="vendor-details">
                  <h1 class="vendor-title text-dark">{{$getFeaturedVendors->vendor_info->name}}</h1>
                  <span class="dealer-info">
                    {{($getFeaturedVendors->is_franchise_dealer == 1) ? 'Franchise' : 'Independent' }} Dealer
                  </span>
                </div>
              </div>

              <div class="featured-stock-info">
                <div class="featured-tag">
                  Featured
                </div>
                <div class="stock-ads-right text-center">
                <i class="fas fa-car fa-fw me-2 text-info" ></i>
                  Total Stock <br/>
                  <span style="font-weight: bold;color:black;">{{$getFeaturedVendors->cars_count}} Ads</span>
                </div>
              </div>
              <a href="{{ route('frontend.vendor.details', [ 'id' => $getFeaturedVendors->id ,  'username' => ( $getFeaturedVendors->username)]) }}" class="showroom-button">See Showroom</a>
            </div>
    
          </div>
          <div class="col-12 col-md-7" data-aos="" style="border: 0px solid orange;"> 
            <div class="row"  style="margin-right:3%">     
            @foreach ($getFeaturedVendors->cars as $featureads)

             @php
            
              $image_path = $featureads->feature_image;
              
              $rotation = 0;
              
              if($featureads->rotation_point > 0 )
              {
                  $rotation = $featureads->rotation_point;
              }
              
              if(!empty($image_path) && $featureads->rotation_point == 0 )
              {   
                $rotation = $featureads->galleries->where('image' , $image_path)->first();
                
                if($rotation == true)
                {
                      $rotation = $rotation->rotation_point;  
                }
                else
                {
                      $rotation = 0;   
                }
              }
            
              if(empty($featureads->feature_image))
              {
                  $imng = $featureads->galleries->sortBy('priority')->first();
                  $image_path = $imng->image;
                  $rotation = $imng->rotation_point;
              } 
              

              @endphp
   
              <!-- ------------------------------------------------- -->
              <div class="col-12 col-md-4">
              @include('frontend/home/dataloader')
                <div class="product-default p-15 mb-10 loading-section" style="padding: 0px !important;box-shadow: 0px 0px 20px 0px rgba(76, 87, 125, 0.1);border-color: transparent;border-radius: 10px;" data-id="{{$featureads->id}}">

                    <figure class="product-img mb-15">
                      <a href="{{ route('frontend.car.details', ['cattitle' => catslug($featureads->car_content->category_id),'slug' => $featureads->car_content->slug, 'id' => $featureads->id]) }}"
                      class="lazy-container ratio ratio-2-3">
                        <img class="lazyload"
                        data-src="{{  $featureads->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path }}"
                        alt="{{ optional($featureads)->title }}" style="transform: rotate({{$rotation}}deg);" >
                      </a>

                      @if (Auth::guard('vendor')->check())
                            @php
                              $user_id = Auth::guard('vendor')->user()->id;
                              $checkWishList = checkWishList($featureads->id, $user_id);
                            @endphp
                          @else
                            @php
                              $checkWishList = false;
                            @endphp
                          @endif
                      <a href="javascript:void(0);" 
                        onclick="addToWishlist({{$featureads->id}})" 
                        class="btn btn-icon us_front_ad"
                        data-tooltip="tooltip" 
                        data-bs-placement="right"
                        title="{{ $checkWishList == false ? __('Save Ad') : __('Saved') }}" 
                        style="position: absolute; right: 10px; top: 10px; z-index: 999; background: white; border-radius: 10%; padding: 5px;">
                          @if($checkWishList == false)
                              <i class="fal fa-heart" style="color: blue;"></i>
                          @else
                              <i class="fa fa-heart" aria-hidden="true" style="color: blue;"></i>
                          @endif
                      </a>
                    </figure>
                
                      <div class="product-details" style="padding: 7px !important;padding-left: 15px !important;">
                    
                        <span class="product-category font-xsm">
                            
                            <h5 class="product-title mb-0" style="display: inline-block;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: 250px;vertical-align: top;">
                                <a href="{{ route('frontend.car.details', ['cattitle' => catslug($featureads->car_content->category_id),'slug' => $featureads->car_content->slug, 'id' => $featureads->id]) }}"
                                title="{{ optional($featureads)->title }}">{{ carBrand($featureads->car_content->brand_id) }}
                                {{ carModel($featureads->car_content->car_model_id) }} {{ optional($featureads->car_content)->title }}</a>
                            </h5>
                          
                        </span>
                        
                        <div class="d-flex align-items-center justify-content-between ">
                      
                       
                          <div class="author us_child_dv" style="cursor:pointer;" onclick="window.location='{{ route('frontend.car.details', ['cattitle' => catslug($featureads->car_content->category_id),'slug' => $featureads->car_content->slug, 'id' => $featureads->id]) }}'" >
                      
                            <span style="line-height: 15px;font-size: 14px;">
                                
                                <!-- @if($featureads->year)
                                    {{ $featureads->year }} 
                                @endif
                                
                                @if($featureads->engineCapacity && $featureads->car_content->fuel_type )
                                  <b class="us_dot"> - </b>   {{ roundEngineDisplacement($featureads) }} 
                                @endif -->
                                
                                <!-- @if($featureads->car_content->fuel_type )
                                  <b class="us_dot"> - </b>   {{ $featureads->car_content->fuel_type->name }} 
                                @endif
                                
                                
                                @if($featureads->mileage)
                                  <b class="us_dot"> - </b>    {{ number_format( $featureads->mileage ) }} mi 
                                @endif -->
                                
                                @if($featureads->created_at && $featureads->is_featured != 1)
                                    <b class="us_dot"> - </b> {{calculate_datetime($featureads->created_at)}} 
                                @endif
                                
                                <!-- @if($featureads->city)
                                    <b class="us_dot"> - </b> {{  Ucfirst($featureads->city) }} 
                                @endif -->
                                  
                            </span>
                        
                          </div>
                        
                          @if(!$featureads->year && !$featureads->mileage && !$featureads->engineCapacity)
                          
                            <div style="display:flex;margin-top: 1.5rem;">
                            </div>
                          
                          @endif 

                            <a href="javascript:void(0);" onclick="openShareModal(this)" 
                               data-url="{{ route('frontend.car.details', ['cattitle' => catslug($featureads->car_content->category_id),'slug' => $featureads->car_content->slug, 'id' => $featureads->id]) }}"
                              style="background: transparent; border: none; color: #1D86F5; font-size: 25px;">
                                <i class="fa fa-share-alt" aria-hidden="true"></i>
                            </a>
                        </div>
                                                
                        <div class="d-flex align-items-center justify-content-between mt-4 mb-3" style="height: 10px;font-size: 20px;font-weight:bold;">
                          <div class="author">
                              
                              @if($featureads->previous_price && $featureads->previous_price < $featureads->price )
                                  <strike style="font-weight: 300;color: red;font-size: 14px;float: left;">{{ symbolPrice($featureads->price) }}</strike> 
                                  <!-- <div> {{ symbolPrice($featureads->previous_price) }}</div> -->
                                  <span style="color: #1D86F5;">{{ symbolPrice($featureads->previous_price) }}</span>
                                @else
                                  <span style="color: #1D86F5;">{{ symbolPrice($featureads->price) }}</span>
                                @endif
                          </div>
                          <div>
                            <!-- {!! calulcateloanamount(!empty($featureads->previous_price && $featureads->previous_price < $featureads->price  ) ? $featureads->previous_price : $featureads->price)[0] !!} -->
                           
                            @php
                                // Get loan amount data
                                $loanAmount = calulcateloanamount(!empty($featureads->previous_price && $featureads->previous_price < $featureads->price) ? $featureads->previous_price : $featureads->price)[0];

                                // Remove span tags and replace p/w, p/m with 'week' and 'month'
                                $formattedLoanAmount = strip_tags($loanAmount);
                                $formattedLoanAmount = str_replace(['p/w', 'p/m'], ['week', 'month'], $formattedLoanAmount);

                                // Extract the number and the period (week/month) using regex or simple logic
                                preg_match('/(\d+)\s*\/?(week|month)/', $formattedLoanAmount, $matches);
                                $number = $matches[1] ?? ''; // The number (1, 2, etc.)
                                $period = $matches[2] ?? ''; // The period ('week' or 'month')
                            @endphp

                            {{-- Display with custom styles --}}
                            <span style="font-size: 18px; color: black;">
                                {{ symbolPrice($number) }}
                            </span>
                            <span style="font-size: 14px; color: gray;">
                                /{{ $period }}
                            </span>
                          </div>
                        </div>


                      </div>
                </div>
              </div>
              
            @endforeach
          </div>
          </div>             
        </div>
      </div>
    </section>
  @endif
  <!-- featured section end -->

       
    
  <!-- counter section start -->
  @if ($secInfo->counter_section_status == 1)
    <section class="choose-area choose-2 pb-60" style="margin: 0px;border-radius:0px;box-shadow: 0px 0px 0px 0px">
      <div class="container-fluid mb-40">
        <div class="row justify-content-center m-4">
          <div class="col-lg-6" data-aos="" style="border-radius:10px 0px 0px 10px;box-shadow: 1px 0px 10px 0px rgba(76, 87, 125, 0.1);border-color: transparent">
              
            @include('frontend/home/dataloader')

            <div class="content-title text-center mb-40 loading-section">
              <div class="w-lg-40">
                <!-- <h2 class="title mb-20 mt-0">{{ @$counterSectionInfo->title }}</h2> -->
                <h2 class="title mt-4">Download our mobile app!</h2>
                <!-- <p>{{ @$counterSectionInfo->subtitle }}</p> -->
                <div class="image">
                  <img class="lazyload blur-up" data-src="{{ asset('assets/img/comingsoon.svg') }}"
                    alt="Image" style="width: 300px;height:300px;">
                </div>
                <p style="font-size: 18px;font-weight:bold;">on</p>
                <div class="small-images">
                  <img src="{{ asset('assets/img/appstore.svg') }}" alt="App Store" 
                  style="width: 180px; height: auto;">
                  <img src="{{ asset('assets/img/playstore.svg') }}" alt="Play Store" 
                  style="width: 180px; height: auto;">
                </div>
              </div>
              <div class="info-list">
                <div class="row align-items-center">
                  @foreach ($counters as $counter)
                    <div class="col-sm-6">
                      <div class="card mt-30">
                        <div class="d-flex align-items-center">
                          <div class="card-icon radius-md bg-primary-light"><i class="{{ $counter->icon }}"></i>
                          </div>
                          <div class="card-content">
                            <span class="h3 mb-1"><span class="counter">{{ $counter->amount }}</span>+</span>
                            <p class="card-text">{{ $counter->title }}</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6" data-aos="fade-{{ $currentLanguageInfo->direction == 1 ? 'right' : 'left' }}" style="background-color:#B4D6FF;border-radius:0px 10px 10px 0px;">
            @include('frontend/home/dataloader')
            <div class="image img-right mb-40 loading-section">
              <img class="lazyload blur-up" data-src="{{ asset('assets/img/12345678900.svg') }}"
                alt="Image">
            </div>
          </div>
        </div>
      </div>
    </section>
  @endif
  <!-- counter section end -->

  <!-- Testimonial-area start -->
  @if ($secInfo->testimonial_section_status == 1)
    <section class="testimonial-area testimonial-2 mb-60">
      <div class="container">
        <div class="section-title title-inline mb-30" data-aos="">
          <div class="col-lg-5">
            <span class="subtitle">{{ !empty($testimonialSecInfo->title) ? $testimonialSecInfo->title : '' }}</span>
            <h2 class="title mb-20 mt-0">
              {{ !empty($testimonialSecInfo->subtitle) ? $testimonialSecInfo->subtitle : '' }}</h2>
          </div>
          <div class="col-lg-6">
            <!-- Slider navigation buttons -->
            <div class="slider-navigation text-end mb-20">
              <button type="button" title="Slide prev" class="slider-btn" id="testimonial-slider-btn-prev">
                <i class="fal fa-angle-left"></i>
              </button>
              <button type="button" title="Slide next" class="slider-btn" id="testimonial-slider-btn-next">
                <i class="fal fa-angle-right"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="row align-items-center justify-content-end" data-aos="">
          <div class="col-lg-9">
            <div class="swiper pt-xl-5" id="testimonial-slider-1">
              <div class="swiper-wrapper">
                @foreach ($testimonials as $testimonial)
                  <div class="swiper-slide pb-25">
                    <div class="slider-item radius-md">
                      <div class="quote">
                        <span class="icon"><i class="fal fa-quote-right"></i></span>
                        <p class="text mb-0">
                          {{ $testimonial->comment }}
                        </p>
                      </div>
                      <div class="client">
                        <div class="client-info d-flex align-items-center">
                          <div class="client-img">
                            <div class="lazy-container rounded-pill ratio ratio-1-1">

                              @if (is_null($testimonial->image))
                                <img class="lazyload" data-src="{{ asset('assets/front/images/avatar-1.jpg') }}"
                                  alt="Person Image">
                              @else
                                <img class="lazyload"
                                  data-src="{{ asset('assets/img/clients/' . $testimonial->image) }}"
                                  alt="Person Image">
                              @endif
                            </div>
                          </div>
                          <div class="content">
                            <h6 class="name">{{ $testimonial->name }}</h6>
                            <span class="designation">{{ $testimonial->occupation }}</span>
                          </div>
                        </div>
                        <div class="ratings">
                          <div class="rate">
                            <div class="rating-icon" style="width: {{ $testimonial->rating * 20 }}%"></div>
                          </div>
                          <span class="ratings-total">{{ $testimonial->rating }} {{ __('star') }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="img-content d-none d-lg-block"
        data-aos="fade-{{ $currentLanguageInfo->direction == 1 ? 'left' : 'right' }}">
        <div class="img">
          <img class="lazyload blur-up" data-src="{{ asset('assets/img/' . $testimonialSecImage) }}" alt="Image">
        </div>
      </div>
    </section>
  @endif
  <!-- Testimonial-area end -->

  <!-- call to action section start -->
  @if ($secInfo->call_to_action_section_status == 1)
    <section class="video-banner pt-60 pb-20 bg-img"
      data-bg-image="{{ asset('assets/img/' . $callToActionSectionImage) }}">
      <!-- Bg overlay -->
      <div class="overlay opacity-50"></div>

      <div class="container">
        <div class="row align-items-center gx-xl-5">
          <div class="col-lg-5 col-md-7" data-aos="">
            <div class="content-title mb-40">
              <span class="subtitle color-light mb-10">{{ @$callToActionSecInfo->title }}</span>
              <h2 class="title color-white mb-20 mt-0">{{ @$callToActionSecInfo->subtitle }}</h2>
              <p class="text color-light">{{ @$callToActionSecInfo->text }}</p>
              <div class="cta-btn mt-30">
                @if (!empty($callToActionSecInfo))
                  @if (!is_null($callToActionSecInfo->button_url))
                    <a href="{{ @$callToActionSecInfo->button_url }}" class="btn btn-lg radius-md btn-primary"
                      title="{{ @$callToActionSecInfo->button_name }}"
                      target="_self">{{ @$callToActionSecInfo->button_name }}</a>
                  @endif
                @endif
              </div>
            </div>
          </div>
          <div class="col-lg-7 col-md-5" data-aos="">
            <div class="d-flex align-items-center justify-content-center justify-content-md-end mb-40">
              @if (!empty($callToActionSecInfo))
                @if (!is_null($callToActionSecInfo->video_url))
                  <a href="{{ @$callToActionSecInfo->video_url }}" class="video-btn youtube-popup">
                    <i class="fas fa-play"></i>
                  </a>
                @endif
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>
  @endif
  <!-- call to action section end -->

  <!-- Blog-area start -->
  @if ($secInfo->blog_section_status == 1)
    <section class="blog-area blog-2 pt-50 pb-70 font-type" style="margin: 0px;border-radius:0px;box-shadow: 0px 0px 0px;">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12" data-aos="">
              <div class="section-title title-center mb-50" data-aos="">
                  <h2 class="title mb-0 mt-0">{{ !empty($blogSecInfo->title) ? $blogSecInfo->title : '' }}</h2>
              </div>
          </div>
          <div class="col-12">
        <div class="row justify-content-center m-4">
            @foreach ($blogs as $blog)
            <div class="col-sm-6 col-lg-3" data-aos="">
              <article class="card mb-30">
                @include('frontend/home/dataloader')
                  <!-- Real Content (hidden initially) -->
                  <div class="content loading-section">
                    <div class="card-img radius-0 mb-25">
                        <a href="{{ route('blog_details', ['slug' => $blog->slug]) }}" class="lazy-container radius-md ratio">
                            <img class="lazyload" data-src="{{ asset('assets/img/blogs/' . $blog->image) }}" alt="Blog Image">
                        </a>
                    </div>
                    <div style="padding: 1rem;">  
                      <h4 class="card-title">
                          <a href="{{ route('blog_details', ['slug' => $blog->slug]) }}">
                              {{ strlen(strip_tags($blog->title)) > 20 ? mb_substr(strip_tags($blog->title), 0, 20, 'UTF-8') . '...' : $blog->title }}
                          </a>
                      </h4>
                      <p class="card-text" style="color: #616161;">
                          {{ strlen(strip_tags($blog->content)) > 120 ? mb_substr(strip_tags($blog->content), 0, 120, 'UTF-8') . '...' : $blog->content }}
                      </p>
                      <div class="mt-10">
                          <a href="{{ route('blog_details', ['slug' => $blog->slug]) }}" class="text-white form-control text-center blog-button">{{ __('Read More') }}</a>
                      </div>
                    </div>
                  </div>
              </article>
            </div>
            @endforeach
        </div>
    </div>
</div>

      </div>
    </section>
  @endif
  <!-- Blog-area end -->
@endsection
@section('script')
<script>
  'use strict';

  const baseURL = "{{ url('/') }}";
  
  $(document).ready(function() {

  //  // Simulating data loading
   setTimeout(function() {
        $('.skeleton').hide(); // Hide skeletons
        // $('.loading-section').fadeIn()
        $('.loading-section').removeClass('loading-section');
    }, 5000); // Adjust the timeout according to your actual data loading time

    // Toggle active class on click
    $('.nav-link').on('click', function() {

      $('.nav-item').removeClass('active');
      $('.nav-link').css('border', '0px');
      
      $('.nav-link').css('color', 'black');
      $('.nav-link i').css('color', 'gray');
     
      let current_obj = $(this); 
      current_obj.css('color', '#1D86F5');
      current_obj.find('i').css('color', '#1D86F5');
    
  });




  var popups = [];
  var stopLoop = false; // This flag will control whether to stop the loop.

  // Collect all popup data into the array
  $('.popup-wrapper').each(function() {
    var delay = $(this).data('popup_delay');   // Get delay attribute
    var popupId = $(this).data('popup_id');    // Get id attribute
    var priority = $(this).data('popup_priority'); // Get priority attribute

    // Push the popup data into the array
    popups.push({ delay: delay, popupId: popupId, priority: priority });
  });

  // Sort the popups array by priority (ascending order)
  popups.sort(function(a, b) {
    return a.priority - b.priority;
  });

  // Recursive function to loop through the modals and start over
  function showPopups(index) {
    if (index >= popups.length) {
      // Once all modals have been shown, start over
      index = 0;
    }

    // Stop the loop if flag is true
    if (stopLoop) return;

    var popup = popups[index];
    var popupElement = $('#modal-popup-' + popup.popupId);

    // Check if the popup element exists in the DOM
    if (popupElement.length > 0) {
      // Set timeout based on delay and show the modal
      setTimeout(function() {
        // Stop the loop if flag is true
        if (stopLoop) return;

        // Get the content of the popup with the corresponding id
        var popupContent = popupElement.html();

        // Insert the content into the modal body
        $('#popup_body').html(popupContent);

        // Show the modal
        $('#popupModals').modal('show');

        // When the modal is fully hidden, stop the loop
        $('#popupModals').on('hidden.bs.modal', function() {
          stopLoop = true; // Stop the loop when the modal is closed
        });

        // Move to the next modal after the current one is displayed
        showPopups(index + 1);

      }, popup.delay * 1000); // Multiply by 1000 to convert delay from seconds to milliseconds
    } else {
      // If the popup doesn't exist, move to the next one immediately
      showPopups(index + 1);
    }
  }

  // Start the modal display process
  showPopups(0);
});


  
</script>
@endsection
