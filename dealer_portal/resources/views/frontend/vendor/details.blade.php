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
  <!-- Page title start-->
  <div
    class="page-title-area ptb-100 bg-img {{ $basicInfo->theme_version == 2 || $basicInfo->theme_version == 3 ? 'has_header_2' : '' }}"
    @if (!empty($bgImg)) data-bg-image="{{ asset('assets/img/' . $bgImg->breadcrumb) }}" @endif
    src="{{ asset('assets/front/images/placeholder.png') }}">
    <div class="container">
      <div class="content">
          
            <ul class="list-unstyled">
          <li class="d-inline"><a href="{{ route('index') }}">{{ __('Home') }}</a></li>
          <li class="d-inline">/</li>
          <li class="d-inline "><a href="{{ route('frontend.vendors') }}">All Dealers</a></li>
          <li class="d-inline">/</li>
          <li class="d-inline active opacity-75"><a href="{{ route('frontend.vendor.details' , [$vendor->username]) }}">{{ $vendor->vendor_info->name }}</a></li>
        </ul>
        
        
        <div class="vendor " style="margin-top:2%;margin-bottom:-30px;justify-content: center;">
          <figure class="vendor-img">
            <a href="javaScript:void(0)" class="lazy-container ratio ratio-1-1" style="border-radius: 10px;">
              @if ($vendor->photo != null)
                <img class="lazyload" src="assets/images/placeholder.png"
                  data-src="{{ asset('assets/admin/img/vendor-photo/' . $vendor->photo) }}" alt="Vendor">
              @else
                <img class="lazyload" src="assets/images/placeholder.png"
                  data-src="{{ asset('assets/img/blank-user.jpg') }}" alt="Vendor">
              @endif
            </a>
          </figure>
          <div class="vendor-info">
            <h4 class="mb-2 color-white">{{ $vendor->vendor_info->name }}</h4>
            <span class="text-light">Established since 
                {{date('F Y' , strtotime($vendor->est_year))}}  </span>
            <span class="text-light d-block mt-2" style="display: flex !important;">Ads
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
        <div class="col-lg-8">
         
          <div class="tabs-navigation tabs-navigation-2 mb-20">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <button class="nav-link active btn-md" data-bs-toggle="tab" data-bs-target="#tab_all"
                  type="button">Our Stock</button>
              </li>
              @php
                if (request()->filled('admin')) {
                    $vendor_id = 0;
                } else {
                    $vendor_id = $vendor->id;
                }
              @endphp
              
              <li class="nav-item">
                    <button class="nav-link btn-md" data-bs-toggle="modal" data-bs-target="#contactModal" 
                      type="button">Contact us</button>
                  </li>
                  
                  
                   <li class="nav-item">
                    <button class="nav-link btn-md" data-bs-toggle="tab" data-bs-target="#tab_review"
                      type="button">Review</button>
                  </li>
                  
            </ul>
          </div>
          <div class="tab-content" data-aos="fade-up">
            <div class="tab-pane fade show active" id="tab_all">
              <div class="row">
                @if (count($all_cars) > 0)
                  @foreach ($all_cars as $car_content)
                
                    @if (!empty($car_content))
                    
                    @php 
                  
                        if(empty($car_content->feature_image))
                        {
                            $image_path = $car_content->galleries[0]->image;
                        }
                        else
                        {
                            $image_path = $car_content->feature_image;
                        }
                    $vendor = $car_content->vendor;
                    @endphp
            
            
            
              <div class="col-12" data-aos="fade-up">
                  
                @if($car_content->is_featured == 1)
                    <div class="row g-0 product-default product-column border mb-30 align-items-center p-15" style="transform: translateY(-5px);border-color: transparent !important;border-bottom-color: var(--color-primary) !important;box-shadow: 0px 0px 20px 0px rgba(76, 87, 125, 0.1);" data-id="{{$car_content->id}}">
                    @else
                        <div class="row g-0 product-default product-column border mb-30 align-items-center p-15" data-id="{{$car_content->id}}">
                    @endif
                    
                    
                    @if ($car_content->vendor_id != 0)   
                    
                    @if($car_content->is_featured == 1)
                        <div class="col-md-12" style="border-bottom: 1px solid #ee2c7b;">
                    @else
                        <div class="col-md-12" style="border-bottom: 1px solid #e9e9e9;">
                    @endif
                    
                        <div class="author mb-15 us_parent_cls" >
                        
                            <a style="display:flex;" class="color-medium"
                            href="{{ route('frontend.vendor.details', ['username' => ( @$car_content->vendor->username)]) }}"
                            target="_self" title="{{ $car_content->vendor->username }}">
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
                           
                             <strong class="us_font_15" style="color: black;font-size: 20px;">{{ request()->input('admin') == true ? @$car_content->vendor->first_name : @$vendorInfo->name }}</strong>
                            
                            @if($car_content->vendor->is_franchise_dealer == 1)
                            
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
            
                  <figure class="product-img col-xl-4 col-lg-5 col-md-6 col-sm-12">
                      
                    @if($car_content->is_sale == 1)
                    <div class="sale-tag">Sale</div>
                    @endif
                    
                    @if($car_content->reduce_price == 1)
                    <div class="red-tag" style="margin-left: 195px;">REDUCED</div>
                    @endif
                
                    <a href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}"
                      class="lazy-container ratio ratio-2-3">
                      <img class="lazyload"
                        data-src="{{ asset('assets/admin/img/car-gallery/' .$image_path) }}" alt="Product" onerror="this.onerror=null;this.src='{{ asset('assets/img/default.png') }}';">
                    </a>
                    
                    @if($car_content->deposit_taken  == 1)
                        <div class="reduce-tag">DEPOSIT TAKEN</div>
                    @endif
            
                  </figure>
                  
                    <div class="product-details col-xl-5 col-lg-5 col-md-6 col-sm-12 border-lg-end pe-lg-2" style="margin-top:0.5rem;" >
                        <span class="product-category font-sm" style=" display: flex;margin-bottom: 1rem;"  >
                        {{ carBrand($car_content->car_content->brand_id) }}
                        {{ carModel($car_content->car_content->car_model_id) }}
                      
                        @if ($car_content->manager_special  == 1)
                        <div class="price-tag" style="margin-left: 1rem;padding: 2px 10px;" >Manage Special</div>
                        @endif
                    
                    </span>
                    
                    <h5 class="product-title mb-10"><a
                        href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}">{{ $car_content->car_content->title }}</a>
                    </h5>
                    
                    <div class="author mb-10">
                     
                         <span>  <?= (new DateTime($car_content->car_content->created_at))->diff(new DateTime())->format('%a') == 0 ? 'Today' : (new DateTime($car_content->car_content->created_at))->diff(new DateTime())->format('%a') . ' days ago' ?> </span>
                    
                    </div>
                    
                    <p class="text mb-0 lc-2">
                      {!! strlen(strip_tags($car_content->car_content->description)) > 100
                          ? mb_substr(strip_tags($car_content->car_content->description), 0, 100, 'utf-8') . '...'
                          : strip_tags($car_content->car_content->description) !!}
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
                      @if (!is_null($car_content->previous_price))
                        <span class="old-price font-sm">
                          {{ symbolPrice($car_content->previous_price) }}
                        </span>
                      @endif
                    </div>
                    <a href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}"
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
                    @endif
                  @endforeach
                @else
                  <h4 class="text-center mt-4 mb-4">{{ __('No Ads Found') }}</h4>
                @endif
              </div>
            </div>
           
           
           
           
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
          <aside class="widget-area" data-aos="fade-up">
            <div class="widget-vendor mb-40 border p-20">
              <div class="vendor mb-20 text-center">
                <figure class="vendor-img mx-auto mb-15">
                  <div class="lazy-container ratio ratio-1-1" style="border-radius:10px;">
                    @if (!empty($car_content->vendor->photo))
                      <img class="lazyload" data-src="{{ asset('assets/admin/img/vendor-photo/' . $car_content->vendor->photo) }}"
                        alt="Vendor">
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
              
            
              <!-- Toggle list start -->
              <ul class="toggle-list list-unstyled mt-15" id="toggleList" data-toggle-show="6">
                <li>
                  <span class="first">{{ __('Total Cars') . ':' }}</span>
                  <span
                    class="last">{{ request()->input('admin') == true? $total_cars: $vendor->cars()->get()->count() }}</span>
                </li>

         

                @if ($vendor->show_phone_number == 1)
                  <li>
                    <span class="first">{{ __('Phone') }}</span>
                    <span class="last"><a href="tel:{{ $vendor->phone }}">{{ $vendor->phone }}</a></span>
                  </li>
                @endif

                @if (request()->input('admin') != true)
                  @if (!is_null(@$vendorInfo->city))
                    <li>
                      <span class="first">{{ __('City') . ':' }}</span>
                      <span class="last">{{ @$vendorInfo->city }}</span>
                    </li>
                  @endif

                  @if (!is_null(@$vendorInfo->state))
                    <li>
                      <span class="first">{{ __('State') . ':' }}</span>
                      <span class="last">{{ @$vendorInfo->state }}</span>
                    </li>
                  @endif

               
                @endif
                
                
                  @if (request()->input('admin') != true)
                  <li>
                    <span class="first">{{ __('Member since') . ':' }}</span>
                    <span class="last font-sm">{{ \Carbon\Carbon::parse($vendor->created_at)->format('F Y') }}</span>
                  </li>
                @endif
                
                

                @if (request()->input('admin') == true)
                  <li>
                    <span class="first">{{ __('Address') . ' : ' }}</span>
                    <span class="last">{{ $vendor->address != null ? $vendor->address : '-' }}</span>
                  </li>
                @else
                  <li>
                    <span class="first">{{ __('Address') . ' : ' }}</span>
                    <span class="last">{{ @$vendorInfo->address != null ? @$vendorInfo->address : '-' }}</span>
                  </li>
                @endif

                @if (request()->input('admin') != true)
                  @if (!is_null(@$vendorInfo->zip_code))
                    <li>
                      <span class="first">{{ __('Zip Code') . ':' }}</span>
                      <span class="last">{{ @$vendorInfo->zip_code }}</span>
                    </li>
                  @endif
                @endif


              

              </ul>
              <span class="show-more-btn" data-toggle-btn="toggleListBtn">
                {{ __('Show More') . ' +' }}
              </span>
            
             
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
        </div>
      </div>
    </div>
  </div>
  <!-- Vendor-area end -->

  <!-- Contact Modal -->
  <div class="modal contact-modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title mb-0" id="contactModalLabel">{{ __('Contact Now') }}</h1>
            <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close">X</button>
        </div>
        <div class="modal-body">
          <form action="{{ route('vendor.contact.message') }}" method="POST" id="vendorContactForm">
            @csrf
            <input type="hidden" name="vendor_email" value="{{ $vendor->email }}">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group mb-20">
                  <input type="text" class="form-control" placeholder="{{ __('Enter Your Full Name') }}"
                    name="name">
                  <p class="text-danger em" id="err_name"></p>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-20">
                  <input type="email" class="form-control" placeholder="{{ __('Enter Your Email') }}"
                    name="email">
                  <p class="text-danger em" id="err_email"></p>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group mb-20">
                  <input type="text" class="form-control" placeholder="{{ __('Enter Subject') }}" name="subject">
                  <p class="text-danger em" id="err_subject"></p>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group mb-20">
                  <textarea name="message" class="form-control" placeholder="{{ __('Message') }}"></textarea>
                  <p class="text-danger em" id="err_message"></p>
                </div>
              </div>
              
              <div class="col-lg-12 text-center">
                <button class="btn btn-lg btn-primary" id="vendorSubmitBtn" type="submit"
                  aria-label="button">{{ __('Send message') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
