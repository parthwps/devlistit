@php
  $version = $basicInfo->theme_version;
@endphp
@extends("frontend.layouts.layout-v$version")
@section('pageHeading')
  {{ __('Ads') }}
@endsection

@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keyword_cars }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_cars }}
  @endif
@endsection

@section('content')
 {{-- breadcrub start --}}
  <div class="page-title-area ptb-40 bg-img {{ $basicInfo->theme_version == 2 || $basicInfo->theme_version == 3 ? 'has_header_2' : '' }}"
    style="background-color:white; box-shadow: 0px 0px 0px;border:1px solid white;" >
    <div class="container">
      <div class="content">
        <ul class="list-unstyled pb-2 topbreadcrumb">
        <li class="d-inline bigarrow" style="color:gray !important;"><i class="fal fa-angle-left fa-2x" ></i></li>
        <li class="d-inline" style ="margin-right:10px;color:gray"><a style="color:gray !important;" class = "font-sm" href="{{ URL::previous() }}">{{ __('Back') }}</a></li>
          <li class="d-inline"><a style="color:gray !important;" class = "font-sm" href="{{ route('index') }}">{{ __('Home') }}</a></li>
           <span id="categories_breadcrium">
            @if($breadcrumb)
            @foreach ($breadcrumb as $key=>$val)
            <li class="d-inline" style="color:gray !important;">></li>
            <li class="d-inline active opacity-75" style="color:gray !important;">
            <a style="color:gray !important;" class = "font-sm" href="{{ route('frontend.cars', ['category' => $key]) }}">
            {{$val}}
            </a></li>
            @endforeach

            @else

            <li class="d-inline" style="color:gray !important;">></li>
            <li class="d-inline active opacity-75" style="color:gray !important;">All Sections</li>
            @endif

         </span>

        </ul>
        <h2 style="font-family: Lato, sans-serif;">
        @if (!empty(request()->input('category')))
        {{ ucwords(str_replace("-", " ", request()->input('category'))) }}

        @else
        All Sections
        @endif
        </h2>

      </div>
    </div>
  </div>
  {{-- breadcrub end --}}


<style>
  .loading-section{
    display: none !important;
  }
.card-deal-turncate
{
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        line-height: 1.2; /* Adjust as necessary */
        max-height: 2.4em; /* Adjust based on line-height for 2 lines */
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 18px;
}
.card-design
{
    width: 330px;
}
.left-container
{
    flex: 0 0 330px;
}

.save-search-btn{
  background-color: rgb(219, 223, 230) !important;
    box-shadow: none;
    border: none !important;
    cursor: not-allowed;
    color: rgb(158, 165, 178) !important;
}

.filter-reset-link{
  font-size: 14px;
    line-height: 24px;
    font-weight: 600;
    color: rgb(43, 94, 222);
    cursor: pointer;
    display: block;
    padding: 0px;
    text-align: right;
}

.widget-area .accordion-button::after {

  font-size: 30px !important;
  font-weight: 100 !important;

}

.us_cat_cls2{
  display: flex;
    -webkit-box-pack: justify;
    justify-content: space-between;
    padding: 0px 16px;
    font-size: 14px;
    line-height: 24px;
    color: rgb(34, 40, 49);
    height: 48px;
    -webkit-box-align: center;
    align-items: center;
    border-bottom: none;
    font-family: Lato, sans-serif;
    /* border: 1px solid red !important; */
}

.ads_header{
  flex: 1 1 auto;
  font-size: 16px;
  line-height: 24px;
  font-weight: normal;
  word-break: break-word;
  color: black;
}

.custom_col{
  width: 49% !important;
}
.custom_btn{
  width:95% !important;
  font-size: 13px !important;
}

.custom_btn:hover{
  font-size: 13px !important;
}

.feater-dealer-title{
  color:rgb(255, 255, 255);
  /* border:1px solid red; */
  font-size:18px;
  font-weight: 100;
}

.custom-product-title{
  font-size: 18px;
  overflow-wrap: break-word;
  /* white-space: normal; */
}

.custom-product-icon{
  font-size: 14px;
}


.us_loan
    {
        margin-left: 5px;
        margin-top: 5px;
    }


.product-sort-area .nice-select .list {
    height: auto !important;
        overflow-y: hidden !important;
}
.us_dot
{
    font-size: 25px;
    position: relative;
    margin-left: 5px;
    top: 5px;
}

.us_parent_dv
{
       margin-top: -3rem;
}

.us_child_dv
{
    margin-top: -1rem;
}

@media (max-width: 767px){
  .card-design{
    width: 100%;
  }

}
@media (max-width: 1280px) {
  .dealer-product-card{
      /* border: 1px solid red !important; */
  }
}
@media (max-width: 1200px) {
  .dealer-product-card{
      width: 20%;
      /* border: 1px solid green !important; */
  }
}

@media (max-width: 1024px) {
  .dealer-product-card{
      /* border: 1px solid blue !important; */
      width: 22%;
  }
}
@media (max-width: 991px) {
  .dealer-product-card{
    width: 33%;
    /* border: 1px solid purple !important; */
  }
  .custom-dealer-detail{
    width:50%;
    /* border:1px solid purple; */
  }
}

@media (max-width: 768px)
{
  .dealer-product-card{
    /* border: 1px solid orange !important; */
  }
  .custom-dealer-detail{
    width:100%;
    /* border:1px solid orange; */
  }
  #carFeature{
    margin: 0px !important;
  }
}

@media (max-width: 575px)
{
  .dealer-product-card{
    width:98%;
    margin: 10px 4px;
    /* border: 1px solid yellow !important; */
  }
}


@media screen and (min-width: 580px)
{
  .card-design{
    width: 100%;
  }

    .us_parent_cls
    {
    display:flex;
    }
    }

    .us_custom_spot
    {
    position: absolute;
    top: 25%;
    float: right;
    left: 86%;
    z-index: 999;
    }


    @media screen and (max-width: 580px)
    {
      .card-design{
    width: 100%;
  }

    .us_custom_spot
    {
    position: absolute;
    top: 15%;
    float: right;
    left: 86%;
    z-index: 999;
    }
     .us_parent_dv
    {
       margin-top: 0rem !important;
    }
    .us_child_dv
    {
      margin-top: -1rem;
    }


.us_trusted
    {
        float:right;
        margin-top:1rem;
        margin-bottom:1rem;
    }

    .us_font_15
    {
        font-size:15px !important;
    }
  }
  @media (min-width: 426px) and (max-width: 768px) {
    .card-deal-turncate {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        line-height: 1.2; /* Adjust as necessary */
        max-height: 2.4em; /* Adjust based on line-height for 2 lines */
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 18px;
    }
}
@media (min-width: 900px) and (max-width: 1024px){
  .pmon-font{
  font-size: 13px !important;
  }
  .price-font{
font-size: 20px !important;
  }
}
  @media (max-width: 425px){
    .card-design{
      width: 170%;

    }
    .left-container
{
    flex: 0 0 0px;
}
  }
@media (max-width: 375px){
  .card-design{
    width: 100%;


  }
  .left-container
{
    flex: 0 0 0px;
}
  .title-para
  {
 display:flex;
 /* flex-wrap: wrap; */
  }
  .flex-fill{
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
  }
}

</style>
  <!-- Listing-grid-area start -->
  <div class="listing-grid-area pt-40 pb-40">
    <div class="container">
      <div class="row gx-xl-5">
        <div class="col-lg-4 col-xl-3 p-0">
          <div class="widget-offcanvas offcanvas-lg offcanvas-start" tabindex="-1" id="widgetOffcanvas"
            aria-labelledby="widgetOffcanvas">
            <div class="offcanvas-header px-20">
              <button type="button" class="btn-close us_btn_close" data-bs-dismiss="offcanvas" data-bs-target="#widgetOffcanvas"
                aria-label="Close"></button>
            </div>

            <div class="offcanvas-body p-3 p-lg-0 us_filter_design" style="box-shadow: 0px 0px 0px 0px;border-radius:0px;">
              <form action="{{ route('frontend.cars') }}" method="get" id="searchForm" class="w-100">
                @if (!empty(request()->input('category')))
                  <input type="hidden" name="category" value="{{ request()->input('category') }}">
                @endif

                <aside class="widget-area" data-aos="">
                  <div class="widget widget-select p-0 mb-20">
                    <div class="row">
                      <div class="col-12 pb-20"><a href="javascript:void(0);" onclick="SaveSeraches()" class="btn btn-lg btn-outline active icon-start w-100 save-search-btn"  ><i class="fal fa-star fa-lg" style="color: rgb(158, 165, 178);" ></i>{{ __('Save Searches') }}</a></div>
                      <div class="col-7"><h4 style="font-family: Lato, sans-serif;">Filters</h4></div>
                      <div class="col-5 text-right"> <div class="cta">
                        <a href="{{ route('frontend.cars') }}" class="filter-reset-link">
                          <!-- <i class="fal fa-sync-alt"></i> -->
                          {{ __('Reset All') }}</a>
                      </div></div>
                      <hr/>
                    </div>
                  </div>
                  <!-- Car filters only start here -->
                  @if( request()->get('category') != "carsuu" )
                     @includeIf('frontend.car.carfilter')
                  @endif


                  @if (!empty(showAd(1)))
                    <div class="text-center mt-40">
                      {!! showAd(1) !!}
                    </div>
                  @endif
                  <!-- Spacer -->
                  <div class="pb-40"></div>
                </aside>
            </div>
          </div>

            </div>


        <div class="col-lg-8 col-xl-9" id="ajaxcall">
          <div class="product-sort-area" data-aos="">
            <div class="row align-items-center">
              <div class="col-lg-6">
                <h2 class="mb-20 ads_header" style="display: none;" id="total_counter_with_category">{{ $total_cars }} {{ $total_cars > 1 ? __('Ads') : __('Ads') }}
                  {{ __('Found') }}
                  @if (!empty(request()->input('category')))
                  {{ __('in') }}  {{ ucwords(str_replace("-"," ",(request()->input('category')))) }}
                   @endif
                </h2>
              </div>
              <div class="col-4 d-lg-none">
                <button class="btn btn-sm btn-outline icon-end radius-sm mb-20" type="button"
                  data-bs-toggle="offcanvas" data-bs-target="#widgetOffcanvas" aria-controls="widgetOffcanvas">
                  {{ __('Filter') }} <i class="fal fa-filter"></i>
                </button>
              </div>
              <div class="col-8 col-lg-6">
                <ul class="product-sort-list list-unstyled mb-20">
                  <li class="item">
                    @php
                    $queryParamsList = array_merge(request()->query(), ['type' => 'list']);
                    @endphp
                    <a href="{{ route('frontend.cars', $queryParamsList) }}" class="btn-icon @if(empty(request()->type) || request()->type == 'list') active @endif" data-tooltip="tooltip" data-type='list'
                    data-bs-placement="top" title="{{ __('List View') }}" style="min-width:0px !important">
                      <i class="fas fa-th-list"></i>
                    </a>
                  </li>

                  <li class="item">
                      @php
                      $queryParamsGrid = array_merge(request()->query(), ['type' => 'grid']);
                      @endphp
                      <a href="{{ route('frontend.cars', $queryParamsGrid) }}" class="btn-icon @if(!empty(request()->type) && request()->type == 'grid') active @endif" data-tooltip="tooltip" data-type="grid"
                      data-bs-placement="top" title="{{ __('Grid View') }}"  style="min-width:0px !important">
                      <i class="fas fa-th-large"></i>
                      </a>
                  </li>
                  <li class="item me-4">
                    <div class="sort-item d-flex align-items-center">
                      <label class="me-2 font-sm">{{ __('Sort by') }}:</label>


                        @if (!empty(request()->input('title')))
                          <input type="hidden" name="title" value="{{ request()->input('title') }}">
                        @endif
                        @if (!empty(request()->input('location')))
                          <input type="hidden" name="location" value="{{ request()->input('location') }}">
                        @endif
                        @if (!empty(request()->input('brands')))
                          @foreach (request()->input('brands') as $brand)
                            <input type="hidden" name="brands[]" value="{{ $brand }}">
                          @endforeach
                        @endif
                        @if (!empty(request()->input('models')))
                          @foreach (request()->input('models') as $model)
                            <input type="hidden" name="models[]" value="{{ $model }}">
                          @endforeach
                        @endif
                        @if (!empty(request()->input('fuel_type')))
                          <input type="hidden" name="fuel_type" value="{{ request()->input('fuel_type') }}">
                        @endif
                        @if (!empty(request()->input('transmission')))
                          <input type="hidden" name="transmission" value="{{ request()->input('transmission') }}">
                        @endif
                        @if (!empty(request()->input('condition')))
                          <input type="hidden" name="condition" value="{{ request()->input('condition') }}">
                        @endif
                        @if (!empty(request()->input('min')))
                          <input type="hidden" name="min" value="{{ request()->input('min') }}">
                        @endif
                        @if (!empty(request()->input('max')))
                          <input type="hidden" name="max" value="{{ request()->input('max') }}">
                        @endif
                        <select name="sort" class="nice-select right color-dark" onchange="updateUrl()">
                          <option {{ request()->input('sort') == 'new' ? 'selected' : '' }} value="new">
                            {{ __('Newest') }}
                          </option>
                          <option {{ request()->input('sort') == 'old' ? 'selected' : '' }} value="old">
                            {{ __('Oldest') }}
                          </option>
                          <option {{ request()->input('sort') == 'high-to-low' ? 'selected' : '' }} value="high-to-low">
                            {{ __(' Highest price') }}</option>
                          <option {{ request()->input('sort') == 'low-to-high' ? 'selected' : '' }} value="low-to-high">
                            {{ __('Lowest Price') }}</option>
                       @if(request()->category && (request()->category  == 'cars' || request()->category  == 'cars-&-motors' ) )
                         <option {{ request()->input('sort') == 'high-to-mileage' ? 'selected' : '' }} value="high-to-mileage">
                            {{ __(' Highest  mileage') }}</option>
                          <option {{ request()->input('sort') == 'low-to-mileage' ? 'selected' : '' }} value="low-to-mileage">
                            {{ __(' Lowest mileage') }}</option>
                            @endif
                        </select>

                      </form>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>

          @include('frontend/car/dataloader')
          @include('frontend/car/dataloader')
          @include('frontend/car/dataloader')
          @include('frontend/car/dataloader')
          @include('frontend/car/dataloader')
          @include('frontend/car/dataloader')
          <div class="row px-2" id="ajaxListing" style="display: none;">

            @if($car_contents->count() == 0)
                <div class="col-12 position-relative" > <center> <h4>Sorry, No Posts Matched Your Criteria</h4> </center> </div>
            @else

            @php
              $admin = App\Models\Admin::first();
            @endphp

            @foreach ($car_contents as $key => $car_content)

              @php

              $image_path = $car_content->feature_image;

              $rotation = 0;

              if($car_content->rotation_point > 0 )
              {
                  $rotation =    $car_content->rotation_point;
              }

              if(!empty($image_path) && $car_content->rotation_point == 0 )
              {
                $rotation = $car_content->galleries->where('image' , $image_path)->first();

                if($rotation == true)
                {
                      $rotation = $rotation->rotation_point;
                }
                else
                {
                      $rotation = 0;
                }
              }

              if(empty($car_content->feature_image))
              {
                  $imng = $car_content->galleries->sortBy('priority')->first();

                  $image_path = $imng->image;
                  $rotation = $imng->rotation_point;
              }


              @endphp

              <div class="col-12 position-relative" >


                @if ($key == 2 || $key == 6 || $key == 9 )

                <div class="widget-banner" style="margin-bottom: 1rem;">
                  @if (!empty(showAd(1)))
                  <div class="text-center">
                    {!! showAd(1) !!}
                  </div>
                  @endif
                  @if (!empty(showAd(2)))
                    <div class="text-center">
                      {!! showAd(2) !!}
                    </div>
                  @endif
                </div>

                @endif


                  @if($car_content->is_featured == 1)
                    <div class="row g-0 product-default  product-column mb-30 align-items-center p-15"
                    style="<?= ( $car_content->vendor->vendor_type == 'normal' ) ? 'border-top: 5px solid #ff9e02 !important;' : '' ?>
                     padding: 0px !important;transform: translateY(-5px);border-radius:5px;box-shadow:rgba(88, 97, 118, 0.12) 0px 2px 8px 0px;"
                     data-id="{{$car_content->id}}">
                    @else
                        <div class="row g-0 product-default  product-column mb-30 align-items-center p-15"
                        style="padding: 0px !important;transform: translateY(-5px); border-radius:5px;box-shadow:rgba(88, 97, 118, 0.12) 0px 2px 8px 0px;"
                        data-id="{{$car_content->id}}">
                    @endif

                    @if ($car_content->vendor_id != 0)
                    @if($car_content->vendor->vendor_type == 'dealer')

                    <!-- <div style="display:flex;margin-top: 1rem;margin-bottom: 1.5rem;">



                        @if($car_content->is_sale == 1)
                            <div class="price-tag" style="padding: 3px 5px;border-radius:5px;margin-left: 10px;background:#434d89;font-size: 10.5px;" > Sale </span></div>
                        @endif





                    </div> -->
                    @if($car_content->is_featured == 1)
                        <div class="col-md-12" style="border-bottom: 2px solid #35373b;">
                    @else
                        <div class="col-md-12" style="border-bottom: 2px solid #35373b;">
                    @endif


                        <div class="author mb-15 us_parent_cls" >
                            <a style="padding-top: 1rem;display: flex;padding-left: 1rem;" class="color-medium"
                            href="{{ route('frontend.vendor.details', [ 'id' => $car_content->vendor->id , 'username' => ($vendor = @$car_content->vendor->username)]) }}"
                            target="_self" title="{{ $vendor = @$car_content->vendor->username }}">
                            @if ($car_content->vendor->photo != null)

                   @php
                    $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $car_content->vendor->photo;

                    if (file_exists(public_path('assets/admin/img/vendor-photo/' . $car_content->vendor->photo))) {

                    $photoUrl = asset('assets/admin/img/vendor-photo/' . $car_content->vendor->photo);
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


                            @else

                            @endif
                            <span>

                             <strong class="us_font_15" style="color:rgb(34, 40, 49);font-size: 14px;font-family: Lato, sans-serif;">{{ $car_content->vendor->vendor_info->name }} </strong>

                                 @if($car_content->vendor->is_franchise_dealer == 1)

                                    @php

                                    $review_data = null;

                                    @endphp

                                @if($car_content->vendor->google_review_id > 0 )
                                    @php
                                        $review_data = get_vendor_review_from_google($car_content->vendor->google_review_id , true);
                                    @endphp
                                @endif

                             <div style="display: flex;font-family: Lato, sans-serif;">Franchise Dealer


                              @if(!empty($review_data) && $review_data['total_reviews'] > 0 && $review_data['total_ratings'] > 0)
                            . <span>
                            <div class="rating-container" style="font-size: 15px;margin-top: -0.4rem;">
                            <span class="star on"></span>  {{$review_data['total_ratings']}}/5
                            </div>
                            </span>
                        @endif
                        </div>

                        @else

                        <div style="font-family: Lato, sans-serif;">Independent Dealer</div>
                            @endif


                            </span>
                            </a>


                        @if($car_content->vendor->is_trusted == 1)
                              <div class="us_trusted">
                                <span style="background: #0fbd0f;color: white;padding: 1px 10px;border-radius: 20px;font-size: 12px;margin-left: 0.5rem;"><i class="fa fa-check" aria-hidden="true"></i> Trusted Dealer </span></div>
                          @endif

                             @if($car_content->is_sold == 1)
                           <div class="us_trusted">  <span style="background: #ff2f00; margin-left:5px;color: white;padding: 1px 10px;border-radius: 20px;font-size: 12px;"><i class="fa fa-check" aria-hidden="true"></i> Sold </span></div>
                        @endif

                        </div>

                    </div>
                     @endif
                    @endif

                  <figure class="product-img col-xl-4 col-lg-5 col-md-6 col-sm-12">

                    @if($car_content->is_featured == 1)
                     <div class="sale-tag" style="border-bottom-right-radius: 0px;     background: #ff9e02;">Spotlight</div>
                    @endif
                    <style>
                      .sale-tag {
                          border-radius: 10px;
                          background: linear-gradient(45deg, #ff5900, #ffd700); /* Vibrant orange-to-gold gradient */
                          color: white;
                          font-weight: bold;
                          padding: 7px 10px;
                          /* text-transform: uppercase; */
                          font-size: 12px;
                          position: relative;
                          box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2), 0 0 20px rgba(255, 154, 2, 0.5);
                          overflow: hidden;
                          display: inline-block;
                          cursor: pointer;
                      }

                      .sale-tag::before {
                          content: '';
                          position: absolute;
                          top: 0;
                          left: -150%; /* Start shimmer off-screen */
                          width: 150%;
                          height: 100%;
                          background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.7), transparent);
                          transform: skewX(-20deg);
                          animation: shine 2s infinite;
                      }
                      .sale-tag:hover {
                          background: linear-gradient(45deg, #007bff, #0056b3); /* Primary blue gradient on hover */
                          transform: scale(1.05); /* Slight zoom effect */
                      }

                      @keyframes shine {
                          0% {
                              left: -150%;
                          }
                          100% {
                              left: 150%;
                          }
                      }
                      </styl>


                    <!-- @if ($car_content->is_sold == 1 || $car_content->status == 2)
                        <div class="sold-badge">
                            <span class="sold-text">Sold</span>
                            <span class="sold-text">Sold</span>
                            <span class="sold-text">Sold</span>
                        </div>
                    @endif -->

                    <a href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}"
                    class="lazy-container ratio ratio-2-3">

                    <img class="lazyload"
                    data-src=" {{  $car_content->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path }}  " alt="Product" style="transform: rotate({{$rotation}}deg);" onerror="this.onerror=null;this.src='{{ asset('assets/img/noimage.jpg') }}';">

                    </a>

                    @if($car_content->deposit_taken  == 1)
                        <div class="reduce-tag">DEPOSIT TAKEN</div>
                    @endif

                  </figure>

                   <div class="product-details col-xl-8 col-lg-7 col-md-6 col-sm-12 pe-lg-2" style="margin-top:0.5rem;cursor:pointer;padding-left: 15px;"  onclick="window.location='{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id), 'slug' => $car_content->slug, 'id' => $car_content->id]) }}'" >

                    <span class="product-category font-sm " style=" display: flex;"  >

                    <h5 class="product-title " style="font-family: Lato, sans-serif;"><a
                        href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}">{{ carBrand($car_content->brand_id) }} {{ carModel($car_content->car_model_id) }} {{ $car_content->title }}</a>
                    </h5>

                    </span>

                    <div class="author mb-10 us_child_dv" >

                    <span>

                      @if($car_content->created_at && $car_content->is_featured != 1)
                        <b class="us_dot"> </b>
                        {{calculate_datetime($car_content->created_at)}}
                      @endif

                      @if($car_content->year)
                        <b class="us_dot"> - </b>
                        {{ $car_content->year }}
                      @endif

                      @if($car_content->engineCapacity && $car_content->car_content->fuel_type )
                      <b class="us_dot"> - </b>   {{ roundEngineDisplacement($car_content) }}
                      @endif

                      @if($car_content->car_content->fuel_type )
                      <b class="us_dot"> - </b>   {{ $car_content->car_content->fuel_type->name }}
                      @endif


                      @if($car_content->mileage)
                        <b class="us_dot"> - </b>    {{ number_format( $car_content->mileage ) }} mi
                      @endif

                      @if($car_content->city)
                        <b class="us_dot"> - </b> {{  Ucfirst($car_content->city) }}
                      @endif

                    </span>

                    </div>

                    <div style="display:flex;margin-top: 1rem;margin-bottom: 1.5rem;">

                        @if ($car_content->manager_special  == 1)
                            <div class="price-tag" style="padding: 3px 5px;border-radius:5px; background:#25d366;font-size: 10.5px;" > Manage Special</div>
                        @endif

                        <!-- @if($car_content->is_sale == 1)
                            <div class="price-tag" style="padding: 3px 5px;border-radius:5px;margin-left: 10px;background:#434d89;font-size: 10.5px;" > Sale </span></div>
                        @endif -->

                        @if($car_content->reduce_price == 1)
                            <div class="price-tag" style="padding: 3px 5px;border-radius:5px;margin-left: 10px;background:#ff4444;font-size: 10.5px;" > Reduced </span></div>
                        @endif

                        @if(!empty($car_content->warranty_duration))
                            <div class="price-tag" style="padding: 3px 5px;border-radius: 5px;margin-left: 10px;background: #ebebeb;font-size: 10.5px;color: #525252;border: 1px solid #d6d6d6;box-shadow: 0px 0px 5px gray;" > {{$car_content->warranty_duration}} Warranty</span></div>
                        @endif

                    </div>


                    <ul class="product-icon-list  list-unstyled d-flex align-items-center"  style="position:relative; bottom:10px">

                      @if ($car_content->price != null)
                          <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                            title="Price">
                              <!-- <b style="color: gray;">Price</b>
                              <br> -->
                              <strong  class="" style="color: #505254;font-size: 32px;margin-left: 0;font-family:lato,sans-serif;">
                                    @if($car_content->previous_price && $car_content->previous_price < $car_content->price)
                                    <!-- <strike style="font-weight: 300;color: red;font-size: 14px;    float: left;"> -->
                                      £{{ number_format($car_content->price, 0, '.', ',') }}
                                      <!-- </strike>  -->

                                    <div style="color:#505254;">
                                        {{ symbolPrice($car_content->previous_price) }}
                                    </div>
                                    @else
                                    £{{ number_format($car_content->price, 0, '.', ',') }}
                                    @endif
                            </strong>
                          </li>
                      @endif

                       @if ($car_content->price != null && $car_content->price >= 1000)
                          <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                            title="">
                              <!-- <b style="color: gray;">From</b>
                              <br>
                            <strong style="color: black;font-size: 20px;">{!! calulcateloanamount(!empty($car_content->previous_price && $car_content->previous_price < $car_content->price ) ? $car_content->previous_price : $car_content->price)[0] !!}</strong> -->
                            <div style="font-size: 16px;font-family:lato,sans-serif;">
                              @php
                                  // Get loan amount data
                                  $loanAmount = calulcateloanamount(!empty($car_content->previous_price && $car_content->previous_price < $car_content->price) ? $car_content->previous_price : $car_content->price)[0];

                                  // Remove span tags and replace p/w, p/m with 'week' and 'month'
                                  $formattedLoanAmount = strip_tags($loanAmount);
                                  $formattedLoanAmount = str_replace(['p/w', 'p/m'], ['week', 'month'], $formattedLoanAmount);

                                  // Extract the number and the period (week/month) using regex or simple logic
                                  preg_match('/(\d+)\s*\/?(week|month)/', $formattedLoanAmount, $matches);
                                  $number = $matches[1] ?? ''; // The number (1, 2, etc.)
                                  $period = $matches[2] ?? ''; // The period ('week' or 'month')
                              @endphp

                              @if ($car_content->category_id == 44 || $car_content->category_id == 45
                              || $car_content->parent_id == 24 || $car_content->main_category_id == 24)

                                @if ($car_content->price>=5000)

                                  {{-- Display with custom styles --}}
                                  <span class="text-18-categ-perWeek" style="color: black;">
                                     From {{ symbolPrice($number) }}
                                  </span>

                                  <span class="text-18-categ-perWeek" style="color: gray;">
                                      /{{ $period }}
                                  </span>

                                @endif

                              @endif
                            </div>
                          </li>
                      @endif

                    </ul>

                  </div>


                  @if (Auth::guard('vendor')->check())
                    @php
                      $user_id = Auth::guard('vendor')->user()->id;
                      $checkWishList = checkWishList($car_content->id, $user_id);
                    @endphp
                  @else
                    @php
                      $checkWishList = false;
                    @endphp
                  @endif

                  <a href="javascript:void(0);"
                        onclick="addToWishlist({{$car_content->id}})"
                    class="btn us_wishlist2 btn-icon us_list_downside shadow" data-tooltip="tooltip"
                    data-bs-placement="right"
                    title="{{ $checkWishList == false ? __('Save Ads') : __('Saved') }}">
                    @if($checkWishList == false)
                            <i class="fal fa-heart" style="color:#35373b !important;font-size:22px;"></i>
                        @else
                            <i class="fa fa-heart" style="color:#35373b !important;font-size:22px;" aria-hidden="true"></i>
                        @endif
                  </a>

                    <!-- <a href="javascript:void(0);" class="us_wishlist2 btn-icon us_list_downside us_share_icon " style=" color: #1b87f4 !important;" onclick="openShareModal(this)"
                    data-url="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}"
                    style="
                    color: #1b87f4;
                    " ><i class="fa fa-share-alt" aria-hidden="true"></i>
                    </a> -->
                  </div>
                  <img src="assets/img/saletag.svg" width="120px" style="position: absolute; width: 60px; top:0px; right:0px;" alt="sale"></img>
                <!-- product-default -->
              </div>
            @endforeach

               <!-- <div class="pagination us_pagination_default  mb-40 justify-content-center" data-aos="" >
                 {{ $car_contents->appends(request()->input())->links() }}
          </div> -->
          <!-- Limited Pagination -->
          <div class="pagination us_pagination_filtered mb-40 justify-content-center" id="pagination">
    @if ($car_contents->lastPage() > 1)
        <ul class="pagination">
            @if ($car_contents->currentPage() > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $car_contents->url(1) }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            @endif

            @php
                $halfVisiblePages = 2; // Maximum of 5 visible pages (2 before and 2 after current page)
                $start = max(1, $car_contents->currentPage() - $halfVisiblePages);
                $end = min($car_contents->lastPage(), $car_contents->currentPage() + $halfVisiblePages);
            @endphp

            @for ($page = $start; $page <= $end; $page++)
                <li class="page-item {{ $car_contents->currentPage() == $page ? 'active' : '' }}">
                    <a class="page-link" href="{{ $car_contents->url($page) }}">{{ $page }}</a>
                </li>
            @endfor

            @if ($car_contents->currentPage() < $car_contents->lastPage())
                <li class="page-item">
                    <a class="page-link" href="{{ $car_contents->url($car_contents->currentPage() + 1) }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            @endif
        </ul>
    @endif
</div>
          </div>
        </div>
         @if (!empty(showAd(3)))
            <div class="text-center mt-4 mb-40">
              {!! showAd(3) !!}
            </div>
          @endif
       @endif</div>
    </div>
  </div></div></div>
  <!-- Listing-list-area end -->


        <!-- featured section start -->
  @if ( !empty($getFeaturedVendors->cars))
    <section class="product-area pt-30 pb-30"
      style="background: rgb(0, 19, 52);margin:0px;border-bottom:4px solid rgb(221, 64, 69);display:none;box-shadow: 0px 0px 0px;border-radius: 0px;" id="carFeature">
      <div class="container">
        <div class="row">
          <div class="col-12" >
            <div class="section-title title-inline mb-10" >
              <h2 class="feater-dealer-title">
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


            <div class="col-12 col-md-2 dealer-product-card" >

              <div class="product-default p-15 set_heigh" style="padding: 0px !important;box-shadow: 0px 0px 0px;border-radius: 4px;margin:-6px;" data-id="{{$featureads->id}}">
                <figure class="product-img">
                  <a href="{{ route('frontend.car.details', ['cattitle' => catslug($featureads->car_content->category_id),'slug' => $featureads->car_content->slug, 'id' => $featureads->id]) }}"
                     class="lazy-container ratio ratio-2-3">
                    <img class="lazyload"
                         data-src="{{  $featureads->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path }}"
                         alt="{{ optional($featureads)->title }}" style="transform: rotate({{$rotation}}deg);" >
                  </a>

                </figure>

                  <div class="product-details" style="padding: 7px !important;padding-left: 15px !important;">

                    <span class="product-category font-xsm">

                        <h5 class="product-title custom-product-title mb-0" style="overflow: hidden;text-overflow: ellipsis;vertical-align: top;">
                            <a href="{{ route('frontend.car.details', ['cattitle' => catslug($featureads->car_content->category_id),'slug' => $featureads->car_content->slug, 'id' => $featureads->id]) }}"
                            title="{{ optional($featureads)->title }}">
                            {{ carBrand($featureads->car_content->brand_id) }}
                            {{ carModel($featureads->car_content->car_model_id) }} {{ optional($featureads->car_content)->title }}
                        </a>
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

                        <!-- <a href="javascript:void(0);"
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
                      </a> -->

                      <!-- <a href="javascript:void(0);"  class="us_grid_shared" onclick="openShareModal(this)"
                        data-url="{{ route('frontend.car.details', ['cattitle' => catslug($featureads->car_content->category_id),'slug' => $featureads->car_content->slug, 'id' => $featureads->id]) }}"
                        style="background: transparent;
                        position: absolute;
                        right: 60px;
                        bottom: 5px;
                        z-index: 999;
                        border: none;
                        color: #1b87f4;
                        font-size: 25px;" ><i class="fa fa-share-alt" aria-hidden="true"></i>
                        </a> -->


                    </div>


                    {{--
                      <div class="author us_child_dv" style="cursor:pointer;margin-top: 0px;" onclick="window.location='{{ route('frontend.car.details', ['cattitle' => catslug($featureads->car_content->category_id),'slug' => $featureads->car_content->slug, 'id' => $featureads->id]) }}'" >

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
                    --}}


                    <ul class="product-icon-list custom-product-icon list-unstyled d-flex align-items-center"  style="position:relative;">
                      @if ($featureads->price != null)
                          <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                            title="Price">
                              <b style="color: gray;font-weight:100;">Price</b>
                              <br>
                              <strong  class="us_mr" style="color: black;font-size: 18px;font-weight:600;    margin-left: 0;">
                                    @if($featureads->previous_price && $featureads->previous_price < $featureads->price)
                                    <strike style="font-weight: 300;color: red;font-size: 14px;    float: left;">{{ symbolPrice($featureads->price) }}</strike>

                                    <div style="color:black;">
                                        {{ symbolPrice($featureads->previous_price) }}
                                    </div>
                                    @else
                                        {{ symbolPrice($featureads->price) }}
                                    @endif
                            </strong>
                          </li>
                      @endif

                       @if ($featureads->price != null && $featureads->price >= 1000)
                        <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top" title="">
                          <strong style="color: black;font-size: 18px;font-weight:600">
                              @php
                                  // Get the loan amount output from the function and clean it up
                                  $loanAmountOutput = calulcateloanamount(!empty($featureads->previous_price && $featureads->previous_price < $featureads->price) ? $featureads->previous_price : $featureads->price)[0];

                                  // Strip any HTML tags in case there are span tags in the function output
                                  $loanAmountOutputClean = strip_tags($loanAmountOutput);

                                  // Use a regular expression to separate the numeric part and the dynamic text (like p/m or p/w)
                                  preg_match('/(\d+)(\D+)/', $loanAmountOutputClean, $matches);

                                  // Ensure we have both parts; default to empty strings if not
                                  $loanAmount = $matches[1] ?? '';
                                  $loanPeriod = $matches[2] ?? '';
                              @endphp
                              <b style="color: gray;font-size:14px;font-weight:100">From</b><br>
                              {{ $loanAmount }}
                              <span style="font-size: 10px; color: black;font-weight:100;">{{ $loanPeriod }}</span>
                          </strong>
                        </li>

                      @endif

                    </ul>
                  </div>
              </div>
            </div>

          @endforeach


              <div class="col-12 col-md-4 custom-dealer-detail" data-aos="">

                <div class="mt-3" style="color:rgb(219, 223, 230);">
                  <h4 style="color:white;font-size: 24px;font-weight:100;margin-bottom:0px;">{{$getFeaturedVendors->vendor_info->name}}</h4>
                    <span style="display: flex;margin-bottom: 3px;font-size:14px;">
                      <div>
                        {{($getFeaturedVendors->is_franchise_dealer == 1) ? 'Franchise' : 'Independent' }} Dealer
                      </div>  <b style="margin: 0px 5px;"> . </b>
                      <div>Total stock: {{$getFeaturedVendors->cars_count}} Ads</div>

                    </span>

                 <a href="{{ route('frontend.vendor.details', ['id' => $getFeaturedVendors->id ,  'username' => ( $getFeaturedVendors->username)]) }}" style="color: rgb(219, 223, 230);text-decoration: underline;font-size:14px;">See Showroom</a>

                  <div style="width: 65px;
                    padding: 2px;
                    background: rgb(229, 105, 16);
                    border-radius: 3px;
                    font-size:12px;
                    color: (255, 255, 255);
                    /* font-weight: 700; */
                    margin-top: 0.5rem;">FEATURED</div>

                  <br>


                   @php
                    $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $getFeaturedVendors->photo;

                    if (file_exists(public_path('assets/admin/img/vendor-photo/' . $getFeaturedVendors->photo)))
                    {

                        $photoUrl = asset('assets/admin/img/vendor-photo/' . $getFeaturedVendors->photo);
                    }
                    @endphp


                  <img
                    style="border-radius: 1%; width: 160px;height:80px;margin-top:-12px;"
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


  <div class="modal fade" id="financeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
   <div class="modal-header" style="    border: none;">
        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">.</h5>
        <button type="button" class="close" onclick="closeModal()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           <center> <b style="color: #04de04;font-size: 2rem;">£</b><br>
            <b style="font-size: 2rem;" id="eventTag">Monthly Price</b><br>
            <p style="    padding: 1rem;" id="textHTML">
            </p></center>
            <a href="{{getSetVal('finance_url')}}" class="btn btn-info" style="width: 100%;color: white;">Get Finance Aproval</a>
      </div>

    </div>
  </div>
</div>

@endsection
@section('script')
<script>

  'use strict';

  const baseURL = "{{ url('/') }}";
  // setTimeout(function() {
  //       $('.skeleton').hide(); // Hide skeletons
  //     //   $('.loading-section').fadeIn()
  //       $('.loading-section').removeClass('loading-section');

  //   }, 2000);
    function closeModal()
    {
        $('#financeModal').modal('hide')
    }

  function openPopModal(self , price)
  {
      var type = 'Monthly Price';
     var text =  $(self).data("text")
      if(parseInt(price) < 5000)
      {
          var type = 'Weekly Price';
      }

      $('#eventTag').html(type)
      $('#textHTML').html('<br>'+text)
      $('#financeModal').modal('show')
  }

  // setTimeout(function(){
  //   $('#total_counter_with_category').css('display','');
  //   $('#ajaxListing').css('display','');
  // },1000);


  if (sessionStorage.getItem('tabCategory')) {

    if (sessionStorage.getItem('tabCategory') == 'all'){
        updateUrl(1,'all');
        // updateUrl(1);
    }else{
        updateUrl(1,sessionStorage.getItem('tabCategory'));
    }

  }else{
    updateUrl(1,'cars-&-motors');
  }

</script>
@endsection
