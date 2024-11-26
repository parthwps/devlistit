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
    style="background-color:#FAFAFA; box-shadow:rgba(51, 51, 51, 0.24) 0px 1px 4px" >
    <div class="container">
      <div class="content">
        <ul class="list-unstyled pb-2 topbreadcrumb">
        <li class="d-inline bigarrow"><i class="fal fa-angle-left fa-2x" ></i></li>
        <li class="d-inline" style ="margin-right:10px;"><a class = "font-sm" href="{{ URL::previous() }}">{{ __('Back') }}</a></li>
          <li class="d-inline"><a class = "font-sm" href="{{ route('index') }}">{{ __('Home') }}</a></li>
           <span id="categories_breadcrium">
            @if($breadcrumb)
            @foreach ($breadcrumb as $key=>$val)
            <li class="d-inline">></li>
            <li class="d-inline active opacity-75">
            <a class = "font-sm" href="{{ route('frontend.cars', ['category' => $key]) }}">  
            {{$val}}
            </a></li>
            @endforeach
            
            @else
            
            <li class="d-inline">></li>
            <li class="d-inline active opacity-75">All Sections</li>
            @endif
        
         </span>
         
        </ul>
        <h2>
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

@media screen and (min-width: 580px) 
{
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
</style>
  <!-- Listing-grid-area start -->
  <div class="listing-grid-area pt-40 pb-40">
    <div class="container">
      <div class="row gx-xl-5">
        <div class="col-lg-4 col-xl-3">
          <div class="widget-offcanvas offcanvas-lg offcanvas-start" tabindex="-1" id="widgetOffcanvas"
            aria-labelledby="widgetOffcanvas">
            <div class="offcanvas-header px-20">
              <button type="button" class="btn-close us_btn_close" data-bs-dismiss="offcanvas" data-bs-target="#widgetOffcanvas"
                aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-3 p-lg-0 us_filter_design">
              <form action="{{ route('frontend.cars') }}" method="get" id="searchForm" class="w-100">
                @if (!empty(request()->input('category')))
                  <input type="hidden" name="category" value="{{ request()->input('category') }}">
                @endif
                       
                <aside class="widget-area" data-aos="fade-up">
                  <div class="widget widget-select p-0 mb-20">
                    <div class="row">
                      <div class="col-12 pb-40"><a href="javascript:void(0);" onclick="SaveSeraches()" class="btn btn-lg btn-outline active icon-start w-100"  ><i class="fal fa-star fa-lg" style="color: orange;" ></i>{{ __('Save Search') }}</a></div>
                      <div class="col-6"><h4>Filters</h4></div>
                      <div class="col-6 text-right"> <div class="cta">
                    <a href="{{ route('frontend.cars') }}" class="btn btn-sm btn-primary icon-start us-filter-reset"><i class="fal fa-sync-alt"></i>{{ __('Reset All') }}</a>
                  </div></div>
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
          <div class="product-sort-area" data-aos="fade-up">
            <div class="row align-items-center">
              <div class="col-lg-6">
                <h4 class="mb-20" id="total_counter_with_category">{{ $total_cars }} {{ $total_cars > 1 ? __('Ads') : __('Ads') }}
                  {{ __('Found') }}
                  @if (!empty(request()->input('category')))
                  {{ __('in') }}  {{ ucwords(str_replace("-"," ",(request()->input('category')))) }}
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
                            {{ __('Date : Newest') }}
                          </option>
                          <option {{ request()->input('sort') == 'old' ? 'selected' : '' }} value="old">
                            {{ __('Date : Oldest') }}
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
                  
                    <li class="item">
                    @php
                    $queryParamsList = array_merge(request()->query(), ['type' => 'list']);
                    @endphp
                    <a href="{{ route('frontend.cars', $queryParamsList) }}" class="btn-icon @if(empty(request()->type) || request()->type == 'list') active @endif" data-tooltip="tooltip" data-type='list'
                    data-bs-placement="top" title="{{ __('List View') }}">
                    <i class="fas fa-th-list"></i>
                    </a>
                    </li>
                    
                    <li class="item">
                        @php
                        $queryParamsGrid = array_merge(request()->query(), ['type' => 'grid']);
                        @endphp
                        <a href="{{ route('frontend.cars', $queryParamsGrid) }}" class="btn-icon @if(!empty(request()->type) && request()->type == 'grid') active @endif" data-tooltip="tooltip" data-type="grid"
                        data-bs-placement="top" title="{{ __('Grid View') }}">
                        <i class="fas fa-th-large"></i>
                        </a>
                    </li>

                  
                </ul>
              </div>
            </div>
          </div>
         
          
          <div class="row" id="ajaxListing">
              
                @if($car_contents->count() == 0)
                <div class="col-12" data-aos="fade-up"> <center> <h4>Sorry, No Posts Matched Your Criteria</h4> </center> </div>
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
            
              <div class="col-12" data-aos="fade-up">
                  
                  
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
                    <div class="row g-0 product-default product-column border mb-30 align-items-center p-15" style="<?= ( $car_content->vendor->vendor_type == 'normal' ) ? 'border-top: 5px solid #ff9e02 !important;' : '' ?> padding: 0px !important;transform: translateY(-5px);box-shadow: 0px 0px 20px gray; border-radius:5px;" data-id="{{$car_content->id}}">
                    @else
                        <div class="row g-0 product-default product-column border mb-30 align-items-center p-15" style="padding: 0px !important;transform: translateY(-5px);box-shadow: 0px 0px 20px gray; border-radius:5px;"  data-id="{{$car_content->id}}">
                    @endif
                    
                    @if ($car_content->vendor_id != 0)   
                    @if($car_content->vendor->vendor_type == 'dealer')
                    
                    @if($car_content->is_featured == 1)
                        <div class="col-md-12" style="border-bottom: 5px solid #ff9e02;">
                    @else
                        <div class="col-md-12" style="border-bottom: 1px solid #e9e9e9;">
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
                            <img style="border-radius: 10%;max-width: 60px;" class="lazyload blur-up" data-src="{{ asset('assets/img/blank-user.jpg') }}"
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
                        
                        </div>
                        
                    </div>
                     @endif
                    @endif
            
                  <figure class="product-img col-xl-4 col-lg-5 col-md-6 col-sm-12">
                      
                    @if($car_content->is_featured == 1)
                     <div class="sale-tag" style="border-bottom-right-radius: 0px;     background: #ff9e02;">Spotlight</div>
                    @endif
                    
                    <a href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}"
                    class="lazy-container ratio ratio-2-3">
                        
                    <img class="lazyload"
                    data-src=" {{  $car_content->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path }}  " alt="Product" style="transform: rotate({{$rotation}}deg);" onerror="this.onerror=null;this.src='{{ asset('assets/img/noimage.jpg') }}';">
                    
                    </a>
                    
                    @if($car_content->deposit_taken  == 1)
                        <div class="reduce-tag">DEPOSIT TAKEN</div>
                    @endif
            
                  </figure>
                  
                   <div class="product-details col-xl-8 col-lg-7 col-md-6 col-sm-12 border-lg-end pe-lg-2" style="margin-top:0.5rem;cursor:pointer;padding-left: 15px;"  onclick="window.location='{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id), 'slug' => $car_content->slug, 'id' => $car_content->id]) }}'" >
                        
                    <span class="product-category font-sm " style=" display: flex;"  >
                        
                    <h5 class="product-title "><a
                        href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}">{{ carBrand($car_content->brand_id) }} {{ carModel($car_content->car_model_id) }} {{ $car_content->title }}</a>
                    </h5>
                    
                    </span>
                    
                    <div class="author mb-10 us_child_dv"   >
                     
                         <span>
                             
                             @if($car_content->year)
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
                             
                             @if($car_content->created_at && $car_content->is_featured != 1)
                                <b class="us_dot"> - </b> {{calculate_datetime($car_content->created_at)}} 
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
                        
                        @if($car_content->is_sale == 1)
                            <div class="price-tag" style="padding: 3px 5px;border-radius:5px;margin-left: 10px;background:#434d89;font-size: 10.5px;" > Sale </span></div>
                        @endif
                        
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
                              <b style="color: gray;">Price</b>
                              <br>
                              <strong  class="us_mrg" style="color: black;font-size: 20px;    margin-left: 0;">
                                    @if($car_content->previous_price && $car_content->previous_price < $car_content->price)
                                    <strike style="font-weight: 300;color: red;font-size: 14px;    float: left;">{{ symbolPrice($car_content->price) }}</strike> 
                                    
                                    <div style="color:black;"> 
                                        {{ symbolPrice($car_content->previous_price) }}
                                    </div>
                                    @else
                                        {{ symbolPrice($car_content->price) }}   
                                    @endif
                            </strong>
                          </li>
                      @endif
                      
                       @if ($car_content->price != null && $car_content->price >= 1000)
                          <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                            title="">
                              <b style="color: gray;">From</b>
                              <br>
                            <strong style="color: black;font-size: 20px;">{!! calulcateloanamount(!empty($car_content->previous_price && $car_content->previous_price < $car_content->price ) ? $car_content->previous_price : $car_content->price)[0] !!}</strong>
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
                    class="btn us_wishlist2 btn-icon us_list_downside" data-tooltip="tooltip"
                    data-bs-placement="right"
                    title="{{ $checkWishList == false ? __('Save Ads') : __('Saved') }}">
                    @if($checkWishList == false)
                            <i class="fal fa-heart"></i>
                        @else
                            <i class="fa fa-heart" aria-hidden="true"></i>
                        @endif
                  </a>
                  
                    <a href="javascript:void(0);" class="us_wishlist2 btn-icon us_list_downside us_share_icon " style=" color: #1b87f4 !important;" onclick="openShareModal(this)" 
                    data-url="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}"
                    style="
                    color: #1b87f4;
                    " ><i class="fa fa-share-alt" aria-hidden="true"></i>
                    </a>
                    
                </div>
                <!-- product-default -->
              </div>
            @endforeach
            
               <div class="pagination us_pagination_default  mb-40 justify-content-center" data-aos="fade-up" >
                 {{ $car_contents->appends(request()->input())->links() }}
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
                 
                 <a href="{{ route('frontend.vendor.details', ['id' => $getFeaturedVendors->id ,  'username' => ( $getFeaturedVendors->username)]) }}" style="color: white;text-decoration: underline;">See Showroom</a>
                 
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
</script>
@endsection