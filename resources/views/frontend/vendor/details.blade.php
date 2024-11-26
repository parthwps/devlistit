@php
  $version = $basicInfo->theme_version;
@endphp
@extends("frontend.layouts.layout-v$version")

@section('pageHeading')
  {{ $vendor->username }}
@endsection
@section('metaKeywords')
  {{ $vendor->username }}, {{ !request()->filled('admin') ? @$vendorInfo->name : '' }}
@endsection

@section('metaDescription')
  {{ !request()->filled('admin') ? @$vendorInfo->details : '' }}
@endsection

@section('content')


@php

$review_data = null;

@endphp

@if($vendor->google_review_id > 0 )
    @php
        $review_data = get_vendor_review_from_google($vendor->google_review_id , true);
    @endphp
@endif
                                
<style>

@media screen and (min-width: 580px) 
{
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
     @php
        $url = asset('assets/img/' . $bgImg->breadcrumb);
      @endphp
      
   @if ( !empty($vendor->banner_image)) 
      @php
        $url = env('SUBDOMAIN_APP_URL').'public/uploads/'.$vendor->banner_image;
      @endphp
  @endif
  


  <div
    class="page-title-area ptb-100 bg-img {{ $basicInfo->theme_version == 2 || $basicInfo->theme_version == 3 ? 'has_header_2' : '' }}"
    @if (!empty($bgImg)) data-bg-image="{{ $url }}" @endif
    src="{{ asset('assets/front/images/placeholder.png') }}" style="height:450px;    filter: brightness(85%);">
      
    <div class="container">
      <div class="content" style="margin-top: 85px;">
          
        <ul class="list-unstyled">
          <li class="d-inline"><a href="{{ route('index') }}" style="color:white;">{{ __('Home') }}</a></li>
          <li class="d-inline" style="color:white;">/</li>
          <li class="d-inline "><a href="{{ route('frontend.vendors') }}" style="color:white;">All Dealers</a></li>
          <li class="d-inline" style="color:white;">/</li>
          <li class="d-inline active opacity-75"><a href="{{ route('frontend.vendor.details' , ['id' => $vendor->id , 'username' => $vendor->username]) }}" style="color:white;">{{ $vendor->vendor_info->name }}</a></li>
        </ul>
        
        
        <div class="vendor " style="margin-top:2%;margin-bottom:-30px;">
            
          <figure class="vendor-img">
            <a href="javaScript:void(0)" class="lazy-container ratio ratio-1-1" style="border-radius: 10px;">
              @if ($vendor->photo != null)
              
                @php
                $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $vendor->photo;
                
                if (file_exists(public_path('assets/admin/img/vendor-photo/' . $vendor->photo))) {
                
                   $photoUrl = asset('assets/admin/img/vendor-photo/' . $vendor->photo);
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
                <img class="lazyload" src="assets/images/placeholder.png"
                  data-src="{{ asset('assets/img/blank-user.jpg') }}" alt="Vendor">
              @endif
            </a>
          </figure>
          
          <div class="vendor-info">
            <h4 class="mb-2 color-white">{{ $vendor->vendor_info->name }}</h4>
            <span class="text-light">
               {{'Member Since'}} 
            
               {{date('Y' , strtotime($vendor->created_at))}}   
                
            </span>
               
                
            <span class="text-light d-block mt-2" style="display: flex !important;">Listings : 
              @if (request()->filled('admin'))
                @php
                  $total_cars = App\Models\Car::where('vendor_id', 0)
                      ->get()
                      ->count();
                @endphp
                {{ $total_cars }}
              @else
                {{ count($vendor->cars()->get()) }}
              @endif
              
              @if(!empty($review_data['total_ratings']))
                &nbsp;. <span> 
                <div class="rating-container" style="font-size: 15px;margin-top: -0.5rem;margin-left: 0.5rem;">
                <span class="star on"></span>  {{$review_data['total_ratings']}}/5
                </div>
                </span>
                  @endif          
            </span>
          </div>
        </div>
      
      </div>
    </div>
  </div>
  <!-- Page title end-->

  <!-- Vendor-area start -->
  <div class="vendor-area pt-40 pb-60">
    <div class="container">
      <div class="row gx-xl-5">
        <div class="@if( $vendor->vendor_type == 'dealer' ) col-lg-8 @else  col-lg-12 @endif ">
         
          <div class="tabs-navigation tabs-navigation-2 mb-20">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <button class="nav-link active btn-md" data-bs-toggle="tab" data-bs-target="#tab_all"
                  type="button"> @if( $vendor->vendor_type == 'dealer' ) Our Stock @else All Ads @endif</button>
              </li>
              @php
                if (request()->filled('admin')) {
                    $vendor_id = 0;
                } else {
                    $vendor_id = $vendor->id;
                }
                
                $disabled = '';
                
                if(count($all_cars) == 0 )
                {
                   $disabled = 'disabled'; 
                }
                
              @endphp
              
              @if( $vendor->vendor_type == 'dealer' )
              @if (Auth::guard('vendor')->check() ) 
                <li class="nav-item" @if($disabled == 'disabled') style="border-radius: 0px;background: #dadada;cursor: not-allowed;"  @endif>
                    <button class="nav-link btn-md" data-bs-toggle="modal"  @if($disabled == 'disabled')  style="color: white;"  @endif data-bs-target="#contactModal" {{$disabled}} type="button">Contact us</button>
                </li>
                  @else
                  
                  @if($disabled == 'disabled')
                        <li class="nav-item"  style="border-radius: 0px;background: #dadada;cursor: not-allowed;" >
                      
                        <button class="nav-link btn-md" style="color: white;"  type="button"  {{$disabled}} >Contact us </button> 
                  </li>
                  
                  @else
                  
                  <li class="nav-item">
                  
                    <a class="nav-link btn-md" href="{{ route('vendor.login') }}"   >Contact us</a>
                  </li>
                  @endif
                  
                  @endif
                  
                <li class="nav-item" style="border-radius: 0px;background: #dadada;cursor: not-allowed;" >
                    <button class="nav-link btn-md" style="color: white;" disabled data-bs-toggle="tab" data-bs-target="#tab_review"
                    type="button">Review</button>
                </li>
                
               @endif 
            </ul>
          </div>
          <div class="tab-content" data-aos="fade-up">
            <div class="tab-pane fade show active" id="tab_all">
              <div class="row">
                  
                 
                  
                @if (count($all_cars) > 0)
                
                @if($vendor->vendor_type == 'dealer')
                
                <form method="post" onsubmit="return filterFormSubmission(this)" id="filterFormsssss" >
                    @csrf
                    
                    <input type="hidden" name="vendor_id" value="{{$vendor->id}}" /> 
                    
                        <div class="col-12" style="margin-bottom: 2rem;">
                        <div class="row">
                        <div class="col-lg-9 col-12">
                          <input type="text" class="form-control" name="search_query" placeholder="Search by title" />
                        </div>
                        
                        <div class="col-lg-3 col-12 d-flex us_filters_btns" id="buttonRows" >
                           
                           <button type="submit" class="btn btn-primary" style="margin-right: 10px;width: 100%;font-size: 20px;padding: 0px;"  id="serachBTN" title="Search" >
                               <i class="fal fa-search" aria-hidden="true"></i></button>
                           <button type="button" class="btn btn-primary" id="filter_btnn" onclick="showFilterSection()" style="width: 100%;font-size: 20px;padding: 0px; display:none;" title="Filters"><i class="fal fa-filter" aria-hidden="true"></i></button>
                        
                        </div>
                        
                        </div>
                        
                        
                        <div class="row us_hidden_by_default" style="margin-top:20px;">
                        <div class="col-lg-4 col-12">
                            <label style="font-size: 15px;margin-bottom: 5px;">Price</label>
                            <div class="d-flex">
                                <select class="form-control" name="min_price" onchange="applyFilter()">
                                    <option value="">Min Price</option>
                                    @foreach($price_ranges as $price)
                                    <option value="{{$price}}">{{symbolPrice($price)}}</option>
                                    @endforeach
                                </select>
                                
                                
                                 <select class="form-control" name="max_price" onchange="applyFilter()" >
                                    <option value="">Max Price</option>
                                    @foreach($price_ranges as $price)
                                        <option value="{{$price}}">{{symbolPrice($price)}}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-12 us_filters_btns">
                          <label style="font-size: 15px;margin-bottom: 5px;">Section</label>
                          
                            <select class="form-control" name="category"  onchange="applyFilter()">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $categoryData)
                                        <option value="{{ $categoryData['category']->id }}">
                                        {{ $categoryData['category']->name }} ({{ $categoryData['count'] }})
                                        </option>
                                    @endforeach
                            </select>
                                
                        </div>
                        
                        
                        <div class="col-lg-4 col-12 us_filters_btns">
                          <label style="font-size: 15px;margin-bottom: 5px;">Sort by: <span>Newest</span></label>
                          
                            <select class="form-control" name="sort_by"  onchange="applyFilter()">
                                    <option value="newest">Newest</option>
                                     <option value="oldest">Oldest</option>
                                      <option value="lowest_price">Lowest Price</option>
                                       <option value="higest_price">Higest Price</option>
                            </select>
                                
                        </div>
                        
                        
                        </div>
                        
                        
                        </div>
                  </form>
                  @endif
                  
                  
                  <div class="col-12" style="margin-bottom: 40px;">
                      <div>
                         <b id="car_counter">{{count($all_cars)}} </b> ads from    <b>{{ @$vendorInfo->name }}   </b>
                      </div>
                  </div>
                  
                  @foreach ($all_cars as $car_content)
                
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
            
            <span id="appendFilterListing">
             <div class="col-12" data-aos="fade-up" >
                  
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
                            href="{{ route('frontend.vendor.details', ['id' =>$car_content->vendor->id , 'username' => (@$car_content->vendor->username)]) }}"
                            target="_self" title="{{ @$car_content->vendor->username }}">
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
                     <div class="sale-tag" style="border-bottom-right-radius: 0px;background: #ff9e02;">Spotlight</div>
                    @endif
                  
                    <a href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id),'slug' => $car_content->car_content->slug, 'id' => $car_content->id]) }}"
                      class="lazy-container ratio ratio-2-3">
                      <img class="lazyload"
                        data-src=" {{  $car_content->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path }}  " alt="Product" style="transform: rotate({{$rotation}}deg);" onerror="this.onerror=null;this.src='{{ asset('assets/img/noimage.jpg') }}';">
                    </a>
                    
                    @if($car_content->deposit_taken  == 1)
                        <div class="reduce-tag">DEPOSIT TAKEN</div>
                    @endif
            
                  </figure>
                  
                   <div class="product-details col-xl-8 col-lg-7 col-md-6 col-sm-12 border-lg-end pe-lg-2" style="margin-top:0.5rem;cursor:pointer;padding-left: 15px;"  onclick="window.location='{{ route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id), 'slug' => $car_content->car_content->slug, 'id' => $car_content->id]) }}'" >
                        
                    <span class="product-category font-sm " style=" display: flex;"  >
                        
                    <h5 class="product-title "><a
                        href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id),'slug' => $car_content->car_content->slug, 'id' => $car_content->id]) }}">{{ carBrand($car_content->car_content->brand_id) }} {{ carModel($car_content->car_content->car_model_id) }} {{ $car_content->car_content->title }}</a>
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
                        
                        <div class="price-tag" style="padding: 3px 5px;border-radius:5px;margin-left: 10px;background:#434d89;font-size: 10.5px;" >  Sale </span></div>
                        
                        @endif
                        
                        @if($car_content->reduce_price == 1)
                        
                        <div class="price-tag" style="padding: 3px 5px;border-radius:5px;margin-left: 10px;background:#ff4444;font-size: 10.5px;" >  Reduced </span></div>
                        
                        @endif
                        
                        
                         @if(!empty($car_content->warranty_duration))
                            <div class="price-tag" style="padding: 3px 5px;border-radius: 5px;margin-left: 10px;background: #ebebeb;font-size: 10.5px;color: #525252;border: 1px solid #d6d6d6;box-shadow: 0px 0px 5px gray;" > {{$car_content->warranty_duration}} Warranty</span></div>
                        @endif
                        
                    
                    </div>
                    
                    
                    <ul class="product-icon-list  list-unstyled d-flex align-items-center" style="position:relative; bottom:10px;">
                      
                 
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
                    class="btn btn-icon us_wishlist2 " data-tooltip="tooltip"
                    data-bs-placement="right"
                    title="{{ $checkWishList == false ? __('Save Ads') : __('Saved') }}">
                    @if($checkWishList == false)
                    <i class="fal fa-heart" style="color:red;" ></i>
                    @else
                    <i class="fa fa-heart" aria-hidden="true" style="color:red;"></i>
                    @endif
                  </a>
                  
                  <a href="javascript:void(0);" class="us_wishlist2 btn-icon  us_share_icon" style=" color: #1b87f4 !important;" onclick="openShareModal(this)" 
                    data-url="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id),'slug' => $car_content->car_content->slug, 'id' => $car_content->id]) }}"
                    style="
                    color: #1b87f4;
                    " ><i class="fa fa-share-alt" aria-hidden="true"></i>
                    </a>
                        
                        
                </div><!-- product-default -->
              </div>
              
                  @endforeach
                @else
                  <h4 class="text-center mt-4 mb-4">{{ __('No Ads Found') }}</h4>
                @endif
              </div>
            </div>
           
           </span>
           
           
          <div class="tab-pane fade " id="tab_review">
				     
					<div class="card-body">
						<div class="product-desc">
						  <h4 class="mb-20">
						    
						  
						  @if(!empty($review_data) &&  $review_data['total_reviews'] > 0 && $review_data['total_ratings'] > 0)
						  {{ request()->input('admin') == true ? @$car_content->vendor->first_name : @$vendorInfo->name }}
                            <div class="rating-container" style="font-size: 13px;font-weight: 500;">
                            {!!$review_data['rating_stars']!!}  <b>{{$review_data['total_ratings']}}</b>/5 .   <a target="_blank" style="color: #ee2c7b;" href="https://www.google.com/maps?q={{ str_replace(' ' , '+' , $vendorInfo->name) }}"> {{number_format($review_data['total_reviews'] ) }} google reviews </a>
                            </div>

                        @endif
						  </h4>
						  <div class="tinymce-content">
						      @if(!empty($review_data) &&  $review_data['total_reviews'] > 0 && $review_data['total_ratings'] > 0)
						    	{!!$review_data['reviews_outout']!!}
							  @endif
						  </div>
						</div>
					</div>
				</div>
           
           
          </div>

          @if (!empty(showAd(3)))
            <div class="text-center mt-4">
              {!! showAd(3) !!}
            </div>
          @endif
        </div>
        
        
        <div class="col-lg-4">
        @if($vendor->vendor_type == 'dealer')
          <aside class="widget-area" data-aos="fade-up">
            <div class="widget-vendor mb-40 border p-20">
              <div class="vendor mb-20 text-center">
                <figure class="vendor-img mx-auto mb-15">
                  <div class="lazy-container ratio ratio-1-1" style="border-radius:10px;">
                    @if (!empty($vendor->photo))
               
                    @php
                    $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $vendor->photo;
                    
                    if (file_exists(public_path('assets/admin/img/vendor-photo/' . $vendor->photo))) {
                    
                    $photoUrl = asset('assets/admin/img/vendor-photo/' . $vendor->photo);
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
                      <img class="lazyload" data-src="{{ asset('assets/img/blank-user.jpg') }}" alt="Vendor">
                    @endif
                  </div>
                </figure>
                <div class="vendor-info">
                  <span class="verification">
                    {{ request()->input('admin') == true ? @$car_content->vendor->first_name : @$vendorInfo->name }}
                  </span>
                  <br>
                    @if(!empty($review_data['total_ratings']))
                 <span> 
                <div class="rating-container" style="font-size: 15px;">
                <span class="star on"></span>  {{$review_data['total_ratings']}}/5
                </div>
                </span>
                  @endif 
                </div>
              </div>
              <!-- about text -->
              @if (request()->input('admin') == true)
                @if (!is_null($car_content->vendor->details))
                  <div class="font-sm">
                    <div class="click-show">
                      <p class="text">
                        <span class="color-dark"><b>{{ __('About') . ':' }}</b></span>
                        {{ $car_content->vendor->details }}
                      </p>
                    </div>
                    <div class="read-more-btn"><span>{{ __('Read more') }}</span></div>
                  </div>
                @endif
              @else
                @if (!is_null(@$vendorInfo->details))
                  <div class="font-sm">
                    <div class="click-show">
                      <p class="text">
                        <span class="color-dark"><b>{{ __('About') . ':' }}</b></span>
                        {{ @$vendorInfo->details }}
                      </p>
                    </div>
                    <div class="read-more-btn"><span>{{ __('Read more') }}</span></div>
                  </div>
                @endif
              @endif
              <hr>
              
              <ul class="toggle-list list-unstyled mt-15" id="toggleList" data-toggle-show="6">
                <li>
                  <span class="first">{{ __('Stock') }}</span>
                  <span
                    class="last">{{ request()->input('admin') == true? $total_cars: $vendor->cars()->get()->count() }}</span>
                </li>

                @if ($vendor->show_phone_number == 1)
                  <li>
                    <span class="first">{{ __('Phone') }}</span>
                    <span class="last"><a href="tel:{{ $vendor->country_code.$vendor->phone }}">{{ $vendor->country_code.$vendor->phone }}</a></span>
                  </li>
                @endif

                @if (request()->input('admin') != true)
                  @if (!is_null(@$vendorInfo->city))
                    <li>
                      <span class="first">Location</span>
                      <span class="last">{{ Ucfirst(@$vendorInfo->city) }}</span>
                    </li>
                  @endif

              @endif
                
                  @if (request()->input('admin') != true)
                  <li>
                    <span class="first">{{ __('Member since') . ':' }}</span>
                    <span class="last font-sm">{{ \Carbon\Carbon::parse($vendor->created_at)->format('Y') }}</span>
                  </li>
                  
                  @if(!empty($vendor->est_year))
                             <li>
                    <span class="first">Est year</span>
                    <span class="last font-sm">{{  !empty($vendor->est_year) ? $vendor->est_year : date('Y') }}</span>
                  </li>
                            @endif
                @endif
                
                @if ($vendor->website_link)
                  <li>
                    <span class="first">Website</span>
                    <span class="last text-primary" ><a href="{{$vendor->website_link}}"  style="color: #1b87f4 !important;" target="_blank" >Visit</a></span>
                  </li>
                @endif
                
                
                @if (request()->input('admin') == true )
                  <li>
                    <span class="first">{{ __('Location') . ' : ' }}</span>
                    <span class="last">{{ $vendor->address != null ? $vendor->address : '-' }}</span>
                  </li>
                @else
                  <li>
                    <span class="first">{{ __('Location') . ' : ' }}</span>
                    <span class="last">{{ @$vendorInfo->address != null ? @$vendorInfo->address : '-' }}</span>
                  </li>
                @endif
                
               <div class="flex" style="margin-bottom:  1.5rem;cursor:pointer; display:none;" onclick="openHours(this)" id="append_dropdown"></div>
                            
                            
                                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                @php
                                    $dayKey = ucfirst($day);
                                    $openingHour = $openingHours[$dayKey] ?? null;
                                    $status = '';
                                    $timeRange = '';
                                    $labelColor = '';
                                    
                                    $p_label = '';
                                    $p_status = '';
                                    $p_timeRange = '';
                                    
                                    if ($openingHour) 
                                    {
                                        if ($openingHour->holiday) 
                                        {
                                            $status = 'Closed';
                                            $labelColor = 'red';
                                        } 
                                        else 
                                        {
                                            $openTime = \Carbon\Carbon::createFromFormat('H:i:s', $openingHour->open_time)->format('h:i A');
                                            $closeTime = \Carbon\Carbon::createFromFormat('H:i:s', $openingHour->close_time)->format('h:i A');
                                            $currentDateTime = \Carbon\Carbon::createFromFormat('H:i', $currentTime);
                            
                                            $openingDateTime = \Carbon\Carbon::createFromFormat('H:i:s', $openingHour->open_time);
                                            $closingDateTime = \Carbon\Carbon::createFromFormat('H:i:s', $openingHour->close_time);
                                                
                                                
                                            $timeRange = " $openTime to $closeTime";
                                           
                                            if ($currentDay === $dayKey) 
                                            {
                                           
                                                $labelColor = '#1b87f4';
                                            
                                                if ($currentDateTime->between($openingDateTime, $closingDateTime)) 
                                                {
                                                    $p_status = 'Opened Now';
                                                    $p_label = '#1b87f4';
                                                } 
                                                else 
                                                {
                                                    $p_status = 'Closed Now';
                                                    $p_label = 'red';
                                                }
                                                
                                                 $p_timeRange = 'See Opening Hours';
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $status = 'Closed';
                                        $labelColor = 'red';
                                    }
                                 
                                @endphp
                                
                                @if(!empty($p_status))
                              
                                <div class="flex" style="margin-bottom: 0.5rem;cursor:pointer; display:none;" onclick="openHours(this)">
                                    <label style="font-size: 15px; color: {{ $p_label }}">{{ $p_status }}</label>
                                        <div style="float:right; color: black">
                                        {{ $p_timeRange }} <i class="fa fa-caret-down" style="position: relative;
                                        margin-left: 10px;
                                        font-size: 20px;
                                        top: 1px;" aria-hidden="true"></i> 
                                    </div>
                                </div>
                                @endif
                                
                                <div class="flex us_open_hours" style="margin-bottom:  0.5rem;">
                                    <label style="font-size: 15px; color: {{ $labelColor }}">{{ $day }}</label>
                                    <div style="float:right; color: {{ $labelColor }}">
                                        {{ $status }} {{ $timeRange }}
                                    </div>
                                </div>
                            @endforeach
                            
                            
                
              </ul>
             
            
            </div>

            @if (!empty(showAd(1)))
              <div class="text-center mb-40">
                {!! showAd(1) !!}
              </div>
            @endif

            @if (!empty(showAd(2)))
              <div class="text-center mb-40">
                {!! showAd(2) !!}
              </div>
            @endif
          </aside>
             @endif
             
        </div>
      
         
      </div>
    </div>
  </div>
  <!-- Vendor-area end -->

  <!-- Contact Modal -->
  <div class="modal contact-modal fade" id="contactModal" style="background-color: rgba(0, 0, 0, 0.4);" tabindex="-1" aria-labelledby="contactModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title mb-0" id="contactModalLabel">{{ __('Contact Now') }}</h1>
            <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close">X</button>
        </div>
          <form action="{{ route('vendor.contact.message') }}" method="POST" id="vendorContactForm">
            @csrf
           <div class="modal-body">
           <input type="hidden" name="vendor_email" value="{{$vendor->email}}" />
            <div class="user mb-20">
               <div class="row">
              <div class="col-2">
                  <div class="user-img" style="max-width: 80px">
                    <div class="lazy-container ratio ratio-1-1 rounded-pill">
                      @if ($vendor->photo != null)
                  
                
                @php
                    $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $vendor->photo;
                    
                    if (file_exists(public_path('assets/admin/img/vendor-photo/' . $vendor->photo))) {
                    
                    $photoUrl = asset('assets/admin/img/vendor-photo/' . $vendor->photo);
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
                        <img class="lazyload" data-src="{{ asset('assets/img/blank-user.jpg') }}" alt="">
                      @endif
                    </div>
                  </div>
                </div> 
                 <div class="col-8"> 
                  <div class="user-info">
                    <h6 class="mb-1">
                      <a href="{{ route('frontend.vendor.details', ['id' => $vendor->id , 'username' => $vendor->username] ) }}"
                        title="{{ $vendor->username }}">{{ $vendor->vendor_info->name }}</a>
                    </h6>
                    
                    @if($vendor->vendor_type == 'normal')
                    @if ($vendor->trader==0)
                        <p>{{ Ucfirst(@$vendor->vendor_info->city) }} @if(!empty($vendor->vendor_info->city)) . @endif  Private Seller, </p>
                    @else
                        <p>{{ Ucfirst(@$vendor->vendor_info->city) }} @if(!empty($vendor->vendor_info->city)) . @endif  Trader, </p>
                    @endif
                    @else
                        <p>Send an email to the dealer </p>
                    @endif
                    
                    @if(!empty($review_data) && $review_data['total_reviews'] > 0 && $review_data['total_ratings'] > 0)
                    <div class="rating-container">
                    {!!$review_data['rating_stars']!!} . {{$review_data['total_ratings']}}/5
                    </div>
                    
                    <div>  <a  target="_blank" style="color: #ee2c7b;" href="https://www.google.com/maps?q={{ str_replace(' ' , '+' , $vendor->vendor_info->name) }}"> {{number_format($review_data['total_reviews'] ) }} google reviews </a> </div>
                    @endif
                        
                  </div>
            </div>

            </div>
            
            @if($vendor->vendor_type == 'dealer' && Auth::guard('vendor')->check())
              <div class="row" style="margin-top: 1rem;">
                <div class="col-12 mb-3">  
                    <label style="font-size: 15px;">Your full name</label>
                    <input type="text" name="name" class="form-control mt-1" required value="{{Auth::guard('vendor')->user()->vendor_info->name}}"/>
                </div>
                
                <div class="col-12 mb-3">  
                    <label style="font-size: 15px;" >Email</label>
                    <input type="text" name="email" class="form-control mt-1"  required readonly  value="{{Auth::guard('vendor')->user()->email}}"/>
                </div>
                
                
                <div class="col-12 mb-3">  
                    <label style="font-size: 15px;" >Your phone number</label>
                    <input type="text" name="phone_no" class="form-control mt-1"  required  value="{{Auth::guard('vendor')->user()->country_code.Auth::guard('vendor')->user()->phone}}"/>
                </div>
                
                <div class="col-12 mb-4">  
                    <label style="font-size: 15px;"  class="mb-3">I'm interested in ...</label>
                    <div style="display:flex;" class="mb-2">
                        <input type="checkbox" name="field_name[]" class=" mt-1" style="display:block;zoom: 1.5;" value="financing"/> <span style="margin-left: 10px;margin-top: 5px;">Financing this vehicle</span>
                    </div>
                      <div style="display:flex;" class="mb-2">
                    <input type="checkbox" name="field_name[]" class=" mt-1"  style="display:block;zoom: 1.5;" value="scheduling"/> <span style="margin-left: 10px;margin-top: 5px;">Scheduling test drive</span>
                     </div>
                      <div style="display:flex;" class="mb-2">
                    <input type="checkbox" name="field_name[]" class=" mt-1"  style="display:block;zoom: 1.5;" value="trading"/> <span style="margin-left: 10px;margin-top: 5px;">Trading in my current vehicle</span>
                     </div>
                      <div style="display:flex;" class="mb-2">
                    <input type="checkbox" name="field_name[]" class=" mt-1"  style="display:block;zoom: 1.5;" value="conditions"/> <span style="margin-left: 10px;margin-top: 5px;" >More about condition</span>
                     </div>
                </div>
                
              </div> 
            @endif 
            
           <div class="row">
              <div class="col-12">  
               <label style="font-size: 15px;" >Your message</label>
            <textarea id="en_description" class="form-control mt-1" name="description" data-height="200">Hi, Please Connect Call..</textarea>
            </div>
          </div> </div> 
         </div>
      
              <div class="col-lg-12 text-center">
                <button class="btn btn-lg btn-primary" id="vendorSubmitBtn" type="submit"
                  aria-label="button" style="    width: 95%;margin: 1rem 10px 1rem 10px;">
                    @if($vendor->vendor_type == 'normal')
                    {{ __('Send message') }}
                    @else
                     Enquire now
                    @endif
                   
                    
                    </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
