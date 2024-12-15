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
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->car_page_title : __('Ads'),
  ])


<style>

@media screen and (min-width: 580px) {
   .us_parent_cls
    {
        display:flex;
    }
}

@media screen and (max-width: 580px) 
{
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

   
</style>
    
    
  <!-- Listing-grid-area start -->
  <div class="listing-grid-area pt-40 pb-40">
    <div class="container">
      <div class="row gx-xl-5">
        <div class="col-lg-4 col-xl-3">
          <div class="widget-offcanvas offcanvas-lg offcanvas-start" tabindex="-1" id="widgetOffcanvas"
            aria-labelledby="widgetOffcanvas">
            <div class="offcanvas-header px-20">
              <h4 class="offcanvas-title">{{ __('Filter') }}</h4>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#widgetOffcanvas"
                aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-3 p-lg-0">
              <form action="{{ route('frontend.cars') }}" method="get" id="searchForm" class="w-100">
                 @if (!empty(request()->input('category')))
                          <input type="hidden" name="category" value="{{ request()->input('category') }}">
                        @endif
                       
                <aside class="widget-area" data-aos="fade-up">
                  <div class="widget widget-select p-0 mb-20">
                    <div class="row">
                      <div class="col-12 pb-40"><a href="{{ route('frontend.cars') }}" class="btn btn-lg btn-outline active icon-start w-100" style="cursor: not-allowed;" ><i class="fal fa-star fa-lg" ></i>{{ __('Save Search') }}</a></div>
                      <div class="col-6"><h4>Filters</h4></div>
                      <div class="col-6 text-right"> <div class="cta">
                    <a href="{{ route('frontend.cars') }}" class="btn btn-sm btn-primary icon-start"><i class="fal fa-sync-alt"></i>{{ __('Reset All') }}</a>
                  </div></div>
                    </div>                    
                 
                </div>
                @if(count($categories) >0)
                  <div class="widget widget-select p-0 mb-20">
                    <h5 class="title">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#select"
                        aria-expanded="true" aria-controls="select">
                        {{ __('Category') }}
                      </button> 
                    </h5>
                  
                    <div id="select" class="collapse show">
                      <div class="accordion-body  ">
                        <div class="row gx-sm-3">
                          <div class="col-12">
                            <div class="form-group">
                              
                                <div class="list-group list-group-flush">
                                   @foreach ($categories as $category)

                                  <a href="{{ route('frontend.cars', ['category' => $category->slug, 'pid' => $category->parent_id]) }}" class="mt-2 " @if (request()->input('category') == $category->slug) style="font-weight: bold; color: #EE2C7B; "   @endif> {{ $category->name }} </a>

                                  <!--  class="list-group-item">{{ $category->name }} <span class="float-right badge badge-light round">142</span> </a> -->
                                   @endforeach
                                   </div>  <!-- list-group .// -->
                         

                              <!-- <select name="category" id="" class="form-control" onchange="updateUrl()">
                                <option value="">{{ __('All') }}</option>
                                @foreach ($categories as $category)
                                  <option @selected(request()->input('category') == $category->slug) value="{{ $category->slug }}">{{ $category->name }}
                                  </option>
                                @endforeach
                              </select> -->
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif
                 
                  <div class="widget widget-select p-0 mb-20">
                    <h5 class="title">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#location"
                        aria-expanded="true" aria-controls="location">
                        {{ __('Location') }}
                      </button>
                    </h5>
                    <div id="location" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row gx-sm-3">
                          <div class="col-12">
                             <div class="form-group">
                             <div class="col-12 float-start"> 
                              <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()" name="location">
                                <option value="">{{ __('Any') }}</option>
                                
                                 @foreach ($carlocation as $clocation)
                                  <option value="{{ $clocation->slug }}" @selected(request()->input('location') == $clocation->slug)>{{ $clocation->name }}</option>
                                @endforeach
                              </select>
                            </div>
                          <!--   <div class="form-group">
                              <input type="text" name="location" placeholder="{{ __('Search By Location') }}"
                                class="form-control" id="searchByLocation" value="{{ request()->input('location') }}">
                            </div> -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="widget widget-price p-0 mb-20">
                    <h5 class="title">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#price" aria-expanded="true" aria-controls="price">
                        {{ __('Pricing') }}
                      </button>
                    </h5>
                    <div id="price" class="collapse show">
                      <div class="accordion-body scroll-y mt-20">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group">
                             <div class="col-6 float-start"float-start> 
                              <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()" name="min">
                                <option value="">{{ __('Min Price') }}</option>
                                @foreach ($adsprices as $prices)
                                  <option 
                                    value="{{ $prices->name }}" @selected(request()->input('min') == $prices->name)>{{ symbolPrice($prices->name) }}</option>
                                @endforeach
                              </select>

                             
                            </div>
                        <div class="col-6 float-end">
                        <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()" name="max">
                                <option value="">{{ __('Max Price') }}</option>
                                @foreach ($adsprices as $prices)
                                  <option 
                                    value="{{ $prices->name }}" @selected(request()->input('max') == $prices->name)>{{ symbolPrice($prices->name) }}</option>
                                @endforeach
                              </select>
                            </div>
                            </div>
                          </div>
                        </div>
                       <!--  <div class="row gx-sm-3 d-none">
                          <div class="col-md-6">
                            <div class="form-group mb-30">
                              <input class="form-control" type="hidden"
                                value="{{ request()->filled('min') ? request()->input('min') : $min }}" name="min"
                                id="min">

                              <input class="form-control" type="hidden" value="{{ $min }}" id="o_min">
                              <input class="form-control" type="hidden" value="{{ $max }}" id="o_max">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group mb-20">
                              <input class="form-control"
                                value="{{ request()->filled('max') ? request()->input('max') : $max }}" type="hidden"
                                name="max" id="max">
                            </div>
                          </div>
                        </div> -->
                        <input type="hidden" id="currency_symbol" value="{{ $basicInfo->base_currency_symbol }}">
                        <!-- <div class="price-item mt-10">
                          <div class="price-slider" data-range-slider='filterPriceSlider'></div>
                          <div class="price-value">
                            <span class="color-dark">{{ __('Price') . ':' }}
                              <span class="filter-price-range" data-range-value='filterPriceSliderValue'></span>
                            </span>
                          </div>
                        </div> -->
                      </div>
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
              </form>
            </div>
          </div>

        </div>
        <div class="col-lg-8 col-xl-9" id="ajaxcall">
          <div class="product-sort-area" data-aos="fade-up">
            <div class="row align-items-center">
              <div class="col-lg-6">
                <h4 class="mb-20">{{ $total_cars }} {{ $total_cars > 1 ? __('Ads') : __('Ads') }}
                  {{ __('Found') }}
                  @if (!empty(request()->input('category')))
                  {{ __('in') }}  {{ ucfirst(str_replace("-"," ",(request()->input('category')))) }}
                   @endif
                </h4>
              </div>
              <div class="col-4 d-lg-none">
                <button class="btn btn-sm btn-outline icon-end radius-sm mb-20" type="button"
                  data-bs-toggle="offcanvas" data-bs-target="#widgetOffcanvas" aria-controls="widgetOffcanvas">
                  {{ __('Filter') }} <i class="fal fa-filter"></i>
                </button>
              </div>
              <div class="col-8 col-lg-6">
                <ul class="product-sort-list list-unstyled mb-20">
                  <li class="item me-4">
                    <div class="sort-item d-flex align-items-center">
                      <label class="me-2 font-sm">{{ __('Sort By') }}:</label>
                      <form action="{{ route('frontend.cars') }}" method="get" id="SortForm">
                        @if (!empty(request()->input('category')))
                          <input type="hidden" name="category" value="{{ request()->input('category') }}">
                        @endif
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
                        <select name="sort" class="nice-select right color-dark" onchange="updateUrl2()">
                          <option {{ request()->input('sort') == 'new' ? 'selected' : '' }} value="new">
                            {{ __('Date : Newest on top') }}
                          </option>
                          <option {{ request()->input('sort') == 'old' ? 'selected' : '' }} value="old">
                            {{ __('Date : Oldest on top') }}
                          </option>
                          <option {{ request()->input('sort') == 'high-to-low' ? 'selected' : '' }} value="high-to-low">
                            {{ __('Price : High to Low') }}</option>
                          <option {{ request()->input('sort') == 'low-to-high' ? 'selected' : '' }} value="low-to-high">
                            {{ __('Price : Low to High') }}</option>
                        </select>
                      </form>
                    </div>
                  </li>
                  
                   <li class="item">
                    <a href="{{route('frontend.cars' , ['type' => 'list'] )}}"   class="btn-icon @if(empty(request()->type) || request()->type == 'list') active @endif " data-tooltip="tooltip" data-type='list'
                      data-bs-placement="top" title="{{ __('List View') }}">
                      <i class="fas fa-th-list"></i>
                    </a>
                  </li> 
                  
                  <li class="item">
                    <a href="{{route('frontend.cars' , ['type' => 'grid'] )}}" class="btn-icon @if(!empty(request()->type) && request()->type == 'grid') active @endif  " data-tooltip="tooltip" data-type="grid"
                      data-bs-placement="top" title="{{ __('Grid View') }}">
                      <i class="fas fa-th-large"></i>
                    </a>
                  </li>
                  
                </ul>
              </div>
            </div>
          </div>
          <div class="row">
            @php
              $admin = App\Models\Admin::first();
            @endphp
            
            @foreach ($car_contents as $car_content)
            
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
                $image_path = $car_content->galleries[0]->image;
                $rotation = $car_content->galleries[0]->rotation_point;
            }
           
            @endphp
            
              <div class="col-12" data-aos="fade-up">
                  
                  @if($car_content->is_featured == 1)
                    <div class="row g-0 product-default product-column border mb-30 align-items-center p-15" style="transform: translateY(-5px);border-color: #ee2c7b !important;border-bottom-color: var(--color-primary) !important;box-shadow: 0px 0px 20px 0px rgba(76, 87, 125, 0.1);" data-id="{{$car_content->id}}">
                    @else
                        <div class="row g-0 product-default product-column border mb-30 align-items-center p-15" data-id="{{$car_content->id}}">
                    @endif
                    
                    
                    @if ($car_content->vendor_id != 0)   
                    @if($car_content->vendor->vendor_type == 'dealer')
                    @if($car_content->is_featured == 1)
                        <div class="col-md-12" style="border-bottom: 1px solid #ee2c7b;">
                    @else
                        <div class="col-md-12" style="border-bottom: 1px solid #e9e9e9;">
                    @endif
                    
                        <div class="author mb-15 us_parent_cls" >
                        
                            <a style="display:flex;" class="color-medium"
                            href="{{ route('frontend.vendor.details', ['username' => ($vendor = @$car_content->vendor->username)]) }}"
                            target="_self" title="{{ $vendor = @$car_content->vendor->username }}">
                            @if ($car_content->vendor->photo != null)
                           
                            
                            <img
                            style="border-radius: 10%; max-width: 60px;"
                            class="lazyload blur-up"
                            data-src="{{ asset('assets/admin/img/vendor-photo/' . $car_content->vendor->photo) }}"
                            onerror="this.onerror=null;this.src='{{ asset('assets/img/default.png') }}';"
                            alt="Image"
                            >

                            @else
                            <img style="border-radius: 10%;max-width: 60px;" class="lazyload blur-up" data-src="{{ asset('assets/img/default.png') }}"
                            alt="Image">
                            @endif
                            <span>
                             
                             <strong class="us_font_15" style="color: black;font-size: 20px;">{{ $car_content->vendor->vendor_info->name }} </strong>
                            
                                 @if($car_content->vendor->is_franchise_dealer == 1)
                            
                                    @php
                                    
                                    $review_data = null;
                                    
                                    @endphp
                            
                                @if($car_content->vendor->google_review_id > 0 )
                                    @php
                                        $review_data = get_vendor_review_from_google($car_content->vendor->google_review_id , true);
                                    @endphp
                                @endif
    
                             <div style="display: flex;">Franchise Dealer 
                             
                             
                              @if(!empty($review_data) && $review_data['total_reviews'] > 0 && $review_data['total_ratings'] > 0)
                            . <span> 
                            <div class="rating-container" style="font-size: 15px;margin-top: -0.4rem;">
                            <span class="star on"></span>  {{$review_data['total_ratings']}}/5
                            </div>
                            </span>
                        @endif
                        </div>
                        
                        @else
                        
                        <div>Independent Dealer</div> 
                            @endif
                            
                            
                            </span>
                            </a>
                        @if($car_content->vendor->is_trusted == 1)
                              <div class="us_trusted">  <span style="background: #0fbd0f;color: white;padding: 1px 10px;border-radius: 20px;font-size: 12px;margin-left: 0.5rem;"><i class="fa fa-check" aria-hidden="true"></i> Trusted Dealer </span></div>
                          @endif 
                          
                             @if($car_content->is_sold == 1)
                           <div class="us_trusted">  <span style="background: #ff2f00; margin-left:5px;color: white;padding: 1px 10px;border-radius: 20px;font-size: 12px;"><i class="fa fa-check" aria-hidden="true"></i> Sold </span></div>
                        @endif
                        
                         @if($car_content->is_featured == 1)
                           <div class="us_trusted">  <span style="background: #ee2c7b; margin-left:5px;color: white;padding: 1px 10px;border-radius: 20px;font-size: 12px;"><i class="fa fa-check" aria-hidden="true"></i> Spotlight </span></div>
                        @endif
                        
                        
                        </div>
                        
                    </div>
                     @endif
                    @endif
            
                  <figure class="product-img col-xl-4 col-lg-5 col-md-6 col-sm-12">
                      
                    @if($car_content->is_sale == 1)
                    <div class="sale-tag">Sale</div>
                    @endif
                    
                    @if($car_content->reduce_price == 1)
                    <div class="red-tag" style="    margin-left: 232px;">REDUCED</div>
                    @endif
                
                    <a href="{{ route('frontend.car.details', ['slug' => $car_content->slug, 'id' => $car_content->id]) }}"
                      class="lazy-container ratio ratio-2-3">
                      <img class="lazyload"
                        data-src="{{ asset('assets/admin/img/car-gallery/' .$image_path) }}" alt="Product" style="transform: rotate({{$rotation}}deg);" onerror="this.onerror=null;this.src='{{ asset('assets/img/default.png') }}';">
                    </a>
                    
                    @if($car_content->deposit_taken  == 1)
                        <div class="reduce-tag">DEPOSIT TAKEN</div>
                    @endif
            
                  </figure>
                  
                    <div class="product-details col-xl-5 col-lg-5 col-md-6 col-sm-12 border-lg-end pe-lg-2" >
                        <span class="product-category font-sm" style=" display: flex;margin-bottom: 1rem;"  >
                        {{ carBrand($car_content->brand_id) }}
                        {{ carModel($car_content->car_model_id) }}
                      
                        @if ($car_content->manager_special  == 1)
                        <div class="price-tag" style="margin-left: 1rem;padding: 2px 10px;" >Manage Special</div>
                        @endif
                        
                          @if($car_content->is_featured == 1 && $car_content->vendor->vendor_type == 'normal')
                           <div class="us_trusted">  <span style="background: #ee2c7b; margin-left:5px;color: white;padding: 1px 10px;border-radius: 20px;font-size: 12px;"><i class="fa fa-check" aria-hidden="true"></i> Spotlight </span></div>
                        @endif
                        
                    </span>
                    
                    <h5 class="product-title mb-10"><a
                        href="{{ route('frontend.car.details', ['slug' => $car_content->slug, 'id' => $car_content->id]) }}">{{ $car_content->title }}</a>
                    </h5>
                    
                    <div class="author mb-10">
                     
                         <span> {{calculate_datetime($car_content->created_at)}} </span>
                    
                    </div>
                    
                    <p class="text mb-0 lc-2">
                      {!! strlen(strip_tags($car_content->description)) > 100
                          ? mb_substr(strip_tags($car_content->description), 0, 100, 'utf-8') . '...'
                          : strip_tags($car_content->description) !!}
                    </p>
                    <ul class="product-icon-list mt-15 list-unstyled d-flex align-items-center">
                      @if ($car_content->year != null)
                      <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                        title="{{ __('Model Year') }}">
                        <i class="fal fa-calendar-alt"></i>
                        <span>{{ $car_content->year }}</span>
                      </li>
                      @endif
                      @if ($car_content->mileage != null)
                      <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                        title="{{ __('mileage') }}">
                        <i class="fal fa-road"></i>
                        <span>{{ number_format($car_content->mileage) }} km</span>
                      </li>
                      @endif
                      @if ($car_content->speed != null)
                      <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                        title="{{ __('Top Speed') }}">
                        <i class="fal fa-tachometer-fast"></i>
                        <span>{{ $car_content->speed }}</span>
                      </li>
                      @endif
                    </ul>
                  </div>
                  <div class="product-action col-xl-3 col-lg-2 col-md-12 col-sm-12">
                    <div class="product-price" style="margin: 1rem;">
                      <h6 class="new-price color-primary">
                        {{ symbolPrice($car_content->price) }}
                      </h6>
                      @if (!is_null($car_content->previous_price) &&  ($car_content->previous_price != $car_content->price))
                        <span class="old-price font-sm">
                          {{ symbolPrice($car_content->previous_price) }}
                        </span>
                      @endif
                    </div>
                    <a href="{{ route('frontend.car.details', ['slug' => $car_content->slug, 'id' => $car_content->id]) }}"
                      class="btn btn-sm btn-primary" title="{{ __('View Details') }}"  style="margin: 1rem;" >
                        {{ __('View Details') }}
                      </a>
                  </div>
                  
                  
                   
                   
                  @if (Auth::guard('web')->check())
                    @php
                      $user_id = Auth::guard('web')->user()->id;
                      $checkWishList = checkWishList($car_content->id, $user_id);
                    @endphp
                  @else
                    @php
                      $checkWishList = false;
                    @endphp
                  @endif
                  
                 
                  <a href="{{ $checkWishList == false ? route('addto.wishlist', $car_content->id) : route('remove.wishlist', $car_content->id) }}"
                    class="btn btn-icon {{ $checkWishList == false ? '' : 'wishlist-active' }}" data-tooltip="tooltip"
                    data-bs-placement="right"
                    title="{{ $checkWishList == false ? __('Save Ads') : __('Saved') }}">
                    <i class="fal fa-heart"></i>
                  </a>
                </div><!-- product-default -->
              </div>
            @endforeach
          </div>
          <div class="pagination mb-40 justify-content-center" data-aos="fade-up">
            {{ $car_contents->appends([
                    'category' => request()->input('category'),
                    'location' => request()->input('location'),
                    'brands' => request()->input('brands'),
                    'models' => request()->input('models'),
                    'fuel_type' => request()->input('fuel_type'),
                    'transmission' => request()->input('transmission'),
                    'condition' => request()->input('condition'),
                    'min' => request()->input('min'),
                    'max' => request()->input('max'),
                    'sort' => request()->input('sort'),
                ])->links() }}
          </div>

          @if (!empty(showAd(3)))
            <div class="text-center mt-4 mb-40">
              {!! showAd(3) !!}
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
  <!-- Listing-list-area end -->
@endsection
@section('script')
<script>
  'use strict';

  const baseURL = "{{ url('/') }}";
</script>
@endsection