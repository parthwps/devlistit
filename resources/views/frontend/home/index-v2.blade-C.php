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
</style>
  <!-- Home-area start-->
  <section  class="hero-banner hero-banner-2">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="swiper home-slider" id="home-slider-2" data-aos="fade-up">
           
          </div>
        </div>
        <div class="col-12">
        
        </div>
        <div class="col-lg-6 col-xl-6 us_homeclmn " style="border:3px solid red">
          <div class="banner-filter-form mw-100 " data-aos="fade-up">
            <p class="text font-lg justify-content-center"></p>
            <ul class="nav nav-tabs border-0">
             
                  <li class="nav-item">
                    <button class="nav-link car_condition active" data-image = "63c8f9ac5c631.jpg" data-id="24" data-bs-toggle="tab"
                      data-bs-target="#all" type="button">
                            
                       <!-- <i class="fas fa-car fa-fw me-2"></i> -->
                    Cars
                    </button>
                  </li>
                   <li class="nav-item">
                    <button class="nav-link car_condition" data-image = "market.jpg" data-id="0" data-bs-toggle="tab"
                      data-bs-target="#all" type="button">
                            
                       <!-- <i class="fas fa-home fa-fw me-2"></i> -->
                        Marketplace
                    </button>
                  </li>
                   <li class="nav-item">
                    <button class="nav-link car_condition" data-image = "property.jpg"  data-id="39" data-bs-toggle="tab"
                      data-bs-target="#all" type="button">
                        Property
                    </button>
                  </li>
                  
                  <li class="nav-item">
                    <button class="nav-link car_condition" data-image = "farming.png"  data-id="28" data-bs-toggle="tab"
                      data-bs-target="#all" type="button">
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
                            <select class="form-control js-example-basic-single1" id="car_brand" name="brands[]">
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
                            <select class="form-select form-control js-example-basic-single1" id="model" name="models[]">
                              <option value="">{{ __('All Models') }}</option>
                            </select>
                          </div>
                        </div>
                      </div>
                        <div class="row ">
                       <div class="col-6 col-sm-3 carform">
                          <div class="mb-20">
                            <select class="form-select form-control js-example-basic-single1" id="year_min" name="year_min">
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
                            <select class="form-select form-control js-example-basic-single1" id="year_max" name="year_max">
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
                          
                            <select class="form-select form-control js-example-basic-single1" id="min" name="min">
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
<!-- Category-area start -->
  @if ($secInfo->category_section_status == 1)
    <section class="category-area category-1 pt-40">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title title-inline mb-50" data-aos="fade-up">
              <h3 class="title mb-0">{{ @$catgorySecInfo->title }}</h3>
            </div>
          </div>
          <div class="col-12">
            <div class="row tabsHtmlData">
              @foreach ($car_categories as $category)
                <div class=" col-6  col-lg-3" data-aos="fade-up">
                  <a href="{{ route('frontend.cars', ['category' => $category->slug]) }}">
                    <div class="category-item">

                      <div class="d-flex flex-wrep justify-content-between mb-10">

                        <h6 class="category-title mb-10">
                           <img class="lazyload blur-up" data-src="{{ asset('assets/admin/img/car-category/' . $category->image) }}?v=0.3"  alt="{{ $category->name }}" title="{{ $category->name }}"> 
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
  <!-- Steps-area start -->
  @if ($secInfo->work_process_section_status == 1)
    <section class="steps-area pt-60 pb-20">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title title-center " data-aos="fade-up">
              <span class="subtitle mb-10">{{ @$workProcessSecInfo->title }}</span>
              <h2 class="title">{{ @$workProcessSecInfo->subtitle }}</span></h2>
            </div>
          </div>
          <div class="col-12 mb-20">
            <div class="row">
              @foreach ($processes as $process)
                <div class="col-lg-3 col-md-6" data-aos="fade-up">
                  <div class="card align-items-center text-center radius-md p-25 ">
                    <div class="card-icon radius-md mb-25">
                      <i class="{{ $process->icon }}"></i>
                    </div>
                    <div class="card-content">
                      <h4 class="card-title mb-20">{{ $process->title }}</h4>
                      <p class="card-text lc-3">
                        {{ $process->text }}
                      </p>
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

  

  <!-- featured section start -->
  @if ($secInfo->feature_section_status == 1 && !empty($getFeaturedVendors->cars))
    <section class="product-area pt-60 pb-70" style="background: #232231;">
      <div class="container">
        <div class="row">
          <div class="col-12" data-aos="fade-up">
            <div class="section-title title-inline mb-30" data-aos="fade-up">
              <h2 class="title mb-20" style="color:#fff">
                Featured Car Dealer
              </h2>
             
            </div>
          </div> 
        
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
            
            
            <div class="col-12 col-md-3" data-aos="fade-up">

            <div class="product-default border p-15 mb-25 set_height" style="padding: 0px !important;box-shadow: 0px 0px 10px #868686;border-radius: 10px;" data-id="{{$featureads->id}}">
            <figure class="product-img mb-15">
            <a href="{{ route('frontend.car.details', ['cattitle' => catslug($featureads->car_content->category_id),'slug' => $featureads->car_content->slug, 'id' => $featureads->id]) }}"
            class="lazy-container ratio ratio-2-3">
            <img class="lazyload"
            data-src="{{  $featureads->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path }}"
            alt="{{ optional($featureads)->title }}" style="transform: rotate({{$rotation}}deg);" >
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
                        class="btn us_wishlist btn-icon "
                        data-tooltip="tooltip" data-bs-placement="right"
                        title="{{ $checkWishList == false ? __('Save Ad') : __('Saved') }}" style="position: absolute;
                        right: 0px;
                        bottom: 10px;
                        background:white;
                        color:red !important;
                        z-index: 10;
                        border: none;
                        color: white;
                        font-size: 25px;">
                        @if($checkWishList == false)
                            <i class="fal fa-heart"></i>
                        @else
                            <i class="fa fa-heart" aria-hidden="true"></i>
                        @endif
                      </a>
                     
                      <a href="javascript:void(0);"  class="us_grid_shared" onclick="openShareModal(this)" 
                        data-url="{{ route('frontend.car.details', ['cattitle' => catslug($featureads->car_content->category_id),'slug' => $featureads->car_content->slug, 'id' => $featureads->id]) }}"
                        style="background: transparent;
                        position: absolute;
                        right: 60px;
                        bottom: 5px;
                        z-index: 999;
                        border: none;
                        color: #1b87f4;
                        font-size: 25px;" ><i class="fa fa-share-alt" aria-hidden="true"></i>
                        </a>
                        
                       
                    </div>
                    
                    
                       <div class="author us_child_dv" style="cursor:pointer;" onclick="window.location='{{ route('frontend.car.details', ['cattitle' => catslug($featureads->car_content->category_id),'slug' => $featureads->car_content->slug, 'id' => $featureads->id]) }}'" >
                     
                         <span style="line-height: 15px;font-size: 14px;">
                             
                            @if($featureads->year)
                                {{ $featureads->year }} 
                             @endif
                             
                             @if($featureads->engineCapacity && $featureads->car_content->fuel_type )
                              <b class="us_dot"> - </b>   {{ roundEngineDisplacement($featureads) }} 
                             @endif
                             
                             @if($featureads->car_content->fuel_type )
                              <b class="us_dot"> - </b>   {{ $featureads->car_content->fuel_type->name }} 
                             @endif
                             
                             
                             @if($featureads->mileage)
                               <b class="us_dot"> - </b>    {{ number_format( $featureads->mileage ) }} mi 
                             @endif
                             
                             @if($featureads->created_at && $featureads->is_featured != 1)
                                <b class="us_dot"> - </b> {{calculate_datetime($featureads->created_at)}} 
                             @endif
                             
                             @if($featureads->city)
                                <b class="us_dot"> - </b> {{  Ucfirst($featureads->city) }} 
                             @endif
                               
                        </span>
                    
                    </div>
                    
                    @if(!$featureads->year && !$featureads->mileage && !$featureads->engineCapacity)
                    
                    <div style="display:flex;margin-top: 1.5rem;">
                       
                    
                    </div>
                    
                    @endif 
                    
                      <ul class="product-icon-list  list-unstyled d-flex align-items-center" style="    margin-top: 1rem;" >
                      
                    @if ($featureads->price != null)
                      <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                        title="Price">
                          <b style="color: gray;">Price</b>
                          <br>
                        <strong  class="us_mrg" style="color: black;font-size: 20px;">
                          @if($featureads->previous_price && $featureads->previous_price < $featureads->price )
                         <strike style="font-weight: 300;color: red;font-size: 14px;    float: left;">{{ symbolPrice($featureads->price) }}</strike> <div> {{ symbolPrice($featureads->previous_price) }}</div>
                          @else
                          <strike style="font-weight: 300;color: white;font-size: 14px;    float: left;">  </strike> <div>  {{ symbolPrice($featureads->price) }}  </div> 
                        
                        @endif
                      </strong>
                      </li>
                      @endif
                      
                      
                       @if ($featureads->price != null && $featureads->price >= 1000)
                      <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                        title="">
                          <b style="color: gray;">From</b>
                          <br>
                        <strong style="color: black;font-size: 20px;display:flex;">
                            
                            {!! calulcateloanamount(!empty($featureads->previous_price && $featureads->previous_price < $featureads->price  ) ? $featureads->previous_price : $featureads->price)[0] !!}
                            
                            </strong>
                      </li>
                      
                    
                      @endif
                      
                    </ul>
                  </div>
                </div>
              </div>
              
            @endforeach
            
             <div class="col-12 col-md-3" data-aos="fade-up">
                 
                 <div><h4 style="color:white;font-size: 30px;">{{$getFeaturedVendors->vendor_info->name}}</h4> <br>
                 <span style="color:white;display: flex;    margin-bottom: 1rem;"> <div>
                     {{($getFeaturedVendors->is_franchise_dealer == 1) ? 'Franchise' : 'Independent' }} Dealer
                 </div>  <b style="margin: 0px 10px;"> - </b> <div>Total stock: {{$getFeaturedVendors->cars_count}} Ads</div> <br>
                 
                 </span>
                 
                 <a href="{{ route('frontend.vendor.details', [ 'id' => $getFeaturedVendors->id ,  'username' => ( $getFeaturedVendors->username)]) }}" style="color: white;text-decoration: underline;">See Showroom</a>
                 
                <div style="    width: 100px;
                padding: 3px 10px;
                background: #ff7800;
                border-radius: 5px;
                color: white;
                margin-top: 1rem;">FEATURED</div>
                 
                 <br>
            
                 @php
                    $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $getFeaturedVendors->photo;
                    
                    if (file_exists(public_path('assets/admin/img/vendor-photo/' . $getFeaturedVendors->photo))) 
                    {
                    
                        $photoUrl = asset('assets/admin/img/vendor-photo/' . $getFeaturedVendors->photo);
                    }
                    @endphp
                    
                    <img 
                    style="border-radius: 10%; max-width: 60px;" 
                    class="lazyload blur-up"
                    src="{{ asset('assets/img/blank-user.jpg') }}"
                    data-src="{{ $photoUrl }}"  
                    alt="Vendor" 
                    onload="handleImageLoad(this)"
                    onerror="{{ asset('assets/img/blank-user.jpg') }}" >
                    
                    
                 </div>
                    
             </div>
             
                </div>
              </div>
            </section>
          @endif
          
        <!-- featured section end -->

        @if($car_contents->count() > 0 )
        <!-- latest add section start -->
        <section class="product-area pt-60 pb-20 us_recent_pro" style="    margin-bottom: 1rem;
        box-shadow: 0px 0px 10px #afafaf;">
        <div class="container-fluid">
        <div class="row" id="recent_all_ads">
        @include('frontend/home/recent-ads', ['car_contents' => $car_contents])
        </div>
        
        @php
            $lastindex = count($car_contents)-1;
        @endphp
        
        <div class="row">
        <input type="hidden" id="leftside" value="{{$car_contents[0]->id}}"/>
        <input type="hidden" id="rightside" value="{{$car_contents[$lastindex]->id}}"/>
        <center>
        
        <button type="button" class="nextprevbtn" value="1" style="background: white;margin:5px;box-shadow: 0px 0px 10px gray;padding: 5px 0px;height: 50px;width: 50px;border-radius: 50%;font-size: 30px;color: #4b4b4b;"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
        
        <button type="button" class="nextprevbtn" value="2" style="margin:5px;box-shadow: 0px 0px 10px gray;background: white;padding: 5px 0px;height: 50px;width: 50px;border-radius: 50%;font-size: 30px;color: #4b4b4b;"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
        
        </center>
        </div>
        
        </div>
        </section>
        
        <!-- latest add  section end -->
        @endif
    
        <!-- counter section start -->
        @if ($secInfo->counter_section_status == 1)
        <section class="choose-area choose-2 pb-60">
        <div class="container">
        <div class="row align-items-center gx-xl-5">
          <div class="col-lg-6" data-aos="fade-up">
            <div class="content-title mb-40">
              <div class="w-lg-80">
                <h2 class="title mb-20 mt-0">{{ @$counterSectionInfo->title }}</h2>
                <p>{{ @$counterSectionInfo->subtitle }}</p>
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
          <div class="col-lg-6" data-aos="fade-{{ $currentLanguageInfo->direction == 1 ? 'right' : 'left' }}">
            <div class="image img-right mb-40">
              <img class="lazyload blur-up" data-src="{{ asset('assets/img/' . $counterSectionImage) }}"
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
        <div class="section-title title-inline mb-30" data-aos="fade-up">
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
        <div class="row align-items-center justify-content-end" data-aos="fade-up">
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
          <div class="col-lg-5 col-md-7" data-aos="fade-up">
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
          <div class="col-lg-7 col-md-5" data-aos="fade-up">
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
    <section class="blog-area blog-2 pt-50 pb-70">
      <div class="container">
        <div class="row">
          <div class="col-12" data-aos="fade-up">
            <div class="section-title title-center mb-50" data-aos="fade-up">
              <span class="subtitle">{{ !empty($blogSecInfo->subtitle) ? $blogSecInfo->subtitle : '' }}</span>
              <h2 class="title mb-0 mt-0">{{ !empty($blogSecInfo->title) ? $blogSecInfo->title : '' }}</h2>
            </div>
          </div>
          <div class="col-12">
            <div class="row justify-content-center">
              @foreach ($blogs as $blog)
                <div class="col-sm-6 col-lg-4" data-aos="fade-up">
                  <article class="card mb-30">
                    <div class="card-img radius-0 mb-25">
                      <a href="{{ route('blog_details', ['slug' => $blog->slug]) }}"
                        class="lazy-container radius-md ratio">
                        <img class="lazyload" data-src="{{ asset('assets/img/blogs/' . $blog->image) }}"
                          alt="Blog Image">
                      </a>
                    </div>
                    <div class="content" style="padding:2rem;">
                      <h4 class="card-title">
                        <a href="{{ route('blog_details', ['slug' => $blog->slug]) }}">
                          {{ @$blog->title }}
                        </a>
                      </h4>
                      <p class="card-text">
                        {{ strlen(strip_tags($blog->content)) > 120 ? mb_substr(strip_tags($blog->content), 0, 120, 'UTF-8') . '...' : $blog->content }}
                      </p>
                      <div class="mt-10">
                        <a href="{{ route('blog_details', ['slug' => $blog->slug]) }}"
                          class="btn-text">{{ __('Read More') }}</a>
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
