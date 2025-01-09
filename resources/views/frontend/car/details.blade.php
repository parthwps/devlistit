    @php
      $version = $basicInfo->theme_version;
    @endphp
    @extends("frontend.layouts.layout-v$version")
    @section('pageHeading')
      {{ __('Detail') }}
    @endsection

    @section('metaKeywords')
      @if ($car->car_content)
        {{ $car->car_content->meta_keyword }}
      @endif

    @endsection
    @section('metatags')
    <meta property="og:title" content="{{ strlen(@$car->car_content->title) > 40 ? substr(@$car->car_content->title, 0, 40) . '...' : @$car->car_content->title }}">
    <meta property="og:description" content="{{ strlen(@$car->car_content->title) > 40 ? substr(@$car->car_content->title, 0, 40) . '...' : @$car->car_content->title }}">
    <meta property="og:image" content="{{  $car->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' . $car->feature_image) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' .  $car->feature_image }}">
    @endsection

    @section('metaDescription')
      @if ($car->car_content)
        {{ $car->car_content->meta_description }}
      @endif
    @endsection

    @section('content')

    {{-- breadcrub start --}}
    <div class="page-title-area ptb-40 bg-img {{ $basicInfo->theme_version == 2 || $basicInfo->theme_version == 3 ? 'has_header_2' : '' }}"
    style="background-color:#FAFAFA; box-shadow:rgba(51, 51, 51, 0.24) 0px 1px 4px" >

    <div class="container">
      <div class="content">
        <ul class="list-unstyled pb-2">
          <li class="d-inline"><a href="{{ route('index') }}">{{ __('Home') }}</a></li>
          <li class="d-inline">></li>
            @php
                $parentCategory = $car->car_content->category->parent;
                $category = $car->car_content->category;
            @endphp
            @if($parentCategory)
                <li class="d-inline"><a href="{{ route('frontend.cars',['category' => $parentCategory->slug]) }}">{{ $parentCategory->name }}</a></li>
                <li class="d-inline">></li>
            @endif
            <li class="d-inline active opacity-75">{{ @$car->car_content->category->name }}</li>
        </ul>
        <h2>
          {{$car->car_content->title}}
        </h2>
      </div>
    </div>

    </div>

    @php
    $car_ids = $car->id;
    $review_data = null;

    @endphp
    @if($car->vendor->google_review_id > 0 )
    @php
    $review_data = get_vendor_review_from_google($car->vendor->google_review_id , true);
    @endphp
    @endif
    <style>
      body{
        background-color: rgb(34, 40, 49,.02) !important;
      }
      .card{
      background-color: #ffffff !important;
      background-color: #ffffff;
      border: 1px solid #ffffff !important;
      }
      .card, .card-light {
    border-radius: 5px;
    margin-bottom: 30px;
    -webkit-box-shadow: none !important;
    -moz-box-shadow: none !important;
    box-shadow: none !important;
    background-color: #ffffff;
    border: 1px solid #ffffff !important;
}
        .over-flow-fade{
          position: absolute;
          height: 25px;
          width:100%;
          bottom: 0px;
          background: linear-gradient(rgb(255, 255, 255) 0%, rgba(255, 255, 255, 0) 0.01%, rgb(255, 255, 255) 90%);
        }
        .partial-description {
            overflow: hidden;
            height:auto;
            padding-Bottom: 6px;
            line-height: 14px;
            transition: height 0.5s ease;
        }
        .partial-description-min-height {
            overflow: hidden;
            height:60px;
            line-height: 14px;
            transition: height 0.5s ease;
        }


      .NotifyFont{
        font-size: 18px;
      }
      .Notify-font-right{
        font-size: 20px;
      }
      .offsetCol{
           position: absolute;bottom: 10px; right: 0px;
         }
          .us_mrg {
        margin: 0px;
        margin-left: 0px !important;
    }

    .product-icon-list li:not(:last-child) {
    -webkit-padding-end: 15px;
    padding-inline-end: 15px;
    -webkit-margin-end: 15px;
    margin-inline-end: 15px;
    border-inline-end: none !important;
}
    select.form-control
    {
        appearance: auto;
        -webkit-appearance: auto;
        -moz-appearance: auto;
        padding-right: 2rem;
        background: white url('data:image/svg+xml;base64,...') no-repeat right center;
        background-size: 1rem;
    }

    @media only screen and (min-width: 991px) and (max-width: 1199px)
    {
        #card_body
        {
            @if($car->vendor->vendor_type == 'dealer')
             height: 550px;
            @else
            height: 480px;
            @endif
        }
    }

    @media only screen and (min-width: 1200px) and (max-width: 1399px)
    {
         #card_body
        {
             @if($car->vendor->vendor_type == 'dealer')
             height: 670px;
            @else
            height: 560px;
            @endif
        }
    }

     @media only screen and (min-width: 1400px)
    {
        #card_body
        {
               @if($car->vendor->vendor_type == 'dealer')
             height: 720px;
            @else
            height: 650px;
            @endif
        }
    }


    @media screen and (max-width: 375px)
    {

      .offsetCol{
           position: absolute;bottom: 10px; right: 0px;
         }
        }

     @media screen and (max-width: 450px)
    {

      .offsetCol{
           position: static;bottom: 10px; right: 0px;
         }
     .sticky-button
     {
         @if($car->phone_text == 1 && $car->vendor->also_whatsapp == 1)
         width:25% !important ;
         @else
         width:43% !important ;
         @endif
    }

      @if($car->phone_text == 1 && $car->vendor->also_whatsapp == 1)

    .original_text
    {
        display:none !important;
    }

    .mobile_icon
    {
        display:block !important;
    }

    .us_wat_btn
    {
        z-index: 10;
        bottom:2px !important;
         margin-right:7rem;
    }

    .us_button_st
    {
        margin-right: 14rem !important;
    }

    @endif
}

        @media screen and (max-width: 768px)
        {
            .us_socail_links
            {
                display:none !important;
            }
        }

        .btn-icon:hover
        {
            background:none;
        }


        #shareModal .modal-content {

            width: 100% !important;
        }

        /* Ensure the modal backdrop covers everything */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            z-index: 1040; /* Set a high z-index */
        }

        /* Modal container */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Fixed position */
            z-index: 1050; /* Set a higher z-index than the backdrop */
            left: 0;
            top: 26%;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: transparent; /* Semi-transparent background */
            transition: opacity 0.3s ease;
            opacity: 0; /* Start with the modal invisible */
        }

        /* Modal content */
        .modal-content {
            background-color: white;
            /* margin: 30% auto; */
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }



        /* Close button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Show the modal with fading effect */
        .modal.show {
            display: block;
            opacity: 1; /* Fully opaque when shown */
        }

        @media screen and (min-width: 580px)
        {
           .us_parent_cls
            {
                display:flex;
            }
        }

        /* .partial-description {
            overflow: hidden;
            max-height:180px;
            transition: max-height 0.5s ease; Smooth transition effect
        } */

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

            @media screen and (max-width: 777px)
            {

                /* .partial-description {

                max-height:170px !important;

                } */

                  .us_mrn
                  {
                     margin-top: 2rem;
                  }

                  .author.align-items-start .image
                  {
                     display:none;
                  }
            }
</style>


  <!-- Listing-single-area start -->
  <div class="listing-single-area pt-40 pb-60">
    <div class="container">
      @php
        $admin = App\Models\Admin::first();
        $car_id = $car->id;
        $carid = $car->id;
        $ctitle = $car->car_content->title;
      @endphp
      @if ($car->vendor_id != 0)
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <form action="{{ route('vendor.support_ticket.store') }}" enctype="multipart/form-data" method="POST">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ $car->vendor->vendor_info->name }}</h5>
        <input type="hidden" value="{{ $carid }}" name="car_id">
        <input type="hidden" value="{{ $ctitle }}" name="subject">
        <input type="hidden" value="{{ $car->vendor_id }}" name="admin_id">
        @csrf
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

            <div class="user mb-20">
               <div class="row">
              <div class="col-2">
                  <div class="user-img" style="max-width: 80px">
                    <div class="lazy-container ratio ratio-1-1 rounded-pill">
                      @if ($car->vendor->photo != null)


                    @php
                        $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $car->vendor->photo;

                        if (file_exists(public_path('assets/admin/img/vendor-photo/' . $car->vendor->photo))) {

                            $photoUrl = asset('assets/admin/img/vendor-photo/' . $car->vendor->photo);
                        }

                        if(empty($car->vendor->photo))
                        {
                              $photoUrl = asset('assets/img/blank-user.jpg');
                        }
                    @endphp

                    <img
                    class="lazyload "
                    src="{{ asset('assets/img/blank-user.jpg') }}"
                    data-src="{{ $photoUrl }}"
                    alt="Vendor"

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
                      <a href="{{ route('frontend.vendor.details', ['id' => $car->vendor->id , 'username' => $car->vendor->username]) }}"
                        title="{{ $car->vendor->username }}">{{ $car->vendor->vendor_info->name }}</a>
                    </h6>

                    @if($car->vendor->vendor_type == 'normal')
                    @if ($car->vendor->trader==0)
                        <p>{{ Ucfirst(@$car->vendor->vendor_info->city) }} @if(!empty($car->vendor->vendor_info->city)) . @endif  Private Seller, </p>
                    @else
                        <p>{{ Ucfirst(@$car->vendor->vendor_info->city) }} @if(!empty($car->vendor->vendor_info->city)) . @endif  Trader, </p>
                    @endif
                    @else
                        <p>Send an email to the dealer</p>
                    @endif

                    @if(!empty($review_data) && $review_data['total_reviews'] > 0 && $review_data['total_ratings'] > 0)
                    <div class="rating-container">
                    {!!$review_data['rating_stars']!!} . {{$review_data['total_ratings']}}/5
                    </div>

                    <div>  <a  target="_blank" style="color: #ee2c7b;" href="https://www.google.com/maps?q={{ str_replace(' ' , '+' , $car->vendor->vendor_info->name) }}"> {{number_format($review_data['total_reviews'] ) }} google reviews </a> </div>
                    @endif

                  </div>
            </div>

            </div>

            @if($car->vendor->vendor_type == 'dealer' && Auth::guard('vendor')->check())
              <div class="row">
                <div class="col-12 mb-3">
                    <label style="font-size: 15px;">Your full name</label>
                    <input type="text" name="full_name" class="form-control mt-1" required value="{{Auth::guard('vendor')->user()->vendor_info->name}}"/>
                </div>

                <div class="col-12 mb-3">
                    <label style="font-size: 15px;" >Your phone number</label>
                    <input type="text" name="phone_no" class="form-control mt-1"  required  value="{{Auth::guard('vendor')->user()->phone}}"/>
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
            <textarea id="en_description" class="form-control mt-1" name="description" data-height="200">Hi, is this still available? Is the price negotiable?
Thanks</textarea>
            </div>
          </div> </div>
      </div>
      <div class="modal-footer justify-content-between">

        <button type="submit" value="Submit" class="btn btn-primary">Send </button>
      </div>
    </div>
  </form>
  </div>
</div>
 @endif


      <div class="row gx-xl-5">
        <div class="col-lg-8">

			<div class="card">
				<div class="card-body" id="card_body" style="    padding: 0;">


                    <div class="col-md-12 us_card_parent" style="">



                 @if ($car->vendor_id != 0 && $car->vendor->vendor_type == 'dealer')

                    <div id="numberSlides" style="float: right;font-family: monospace;position: relative;top: 65px;">
                            0/0 <i class="fa fa-camera" aria-hidden="true"></i>
                        </div>

                        <div class="author mb-15 us_parent_cls" >

                            <a style="display:flex;" class="color-medium"
                            href="{{ route('frontend.vendor.details', ['id' => $car->vendor->id , 'username' => ($vendor = @$car->vendor->username)]) }}"
                            target="_self" title="{{ $vendor = @$car->vendor->username }}">
                            @if ($car->vendor->photo != null)

                            @php
                            $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $car->vendor->photo;

                            if (file_exists(public_path('assets/admin/img/vendor-photo/' . $car->vendor->photo)))
                            {
                                $photoUrl = asset('assets/admin/img/vendor-photo/' . $car->vendor->photo);
                            }

                            if(empty($car->vendor->photo))
                            {
                                $photoUrl = asset('assets/img/blank-user.jpg');
                            }

                            @endphp

                            <img
                            style="border-radius: 10%; max-width: 80px;height:80px;"
                            class="lazyload blur-up"
                            src="{{ asset('assets/img/blank-user.jpg') }}"
                            data-src="{{ $photoUrl }}"
                            alt="Vendor"

                            onerror="{{ asset('assets/img/blank-user.jpg') }}" >

                            @else
                            <img style="border-radius: 10%;max-width: 80px;" class="lazyload blur-up" data-src="{{ asset('assets/img/blank-user.jpg') }}"
                            alt="Image">
                            @endif
                            <span style="    margin-left: 1rem;">

                            <strong class="us_font_15" style="color: black;font-size: 20px;">{{ $car->vendor->vendor_info->name }} @if(!empty($car->vendor->est_year)) <b>.</b> <span style="font-size: 15px;font-weight: normal;color: gray;">Est {{$car->vendor->est_year}}</span> @endif</strong>

                            @if($car->vendor->is_franchise_dealer == 1)

                                @php

                                $review_data = null;

                                @endphp

                                @if($car->vendor->google_review_id > 0 )
                                    @php

                                        $review_data = get_vendor_review_from_google($car->vendor->google_review_id , true);
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

                        @if($car->vendor->is_trusted == 1)
                           <div class="">  <span style="background: #0fbd0f;color: white;padding: 1px 10px;border-radius: 20px;font-size: 12px;"><i class="fa fa-check" aria-hidden="true"></i> Trusted Dealer </span></div>
                        @endif

                        @else

                        <div>Independent Dealer</div>
                            @endif
                            </span>
                            </a>
                        </div>
                        @else

                        <div id="numberSlides" style="text-align: right;margin-bottom: 1rem;font-family: monospace;">
                            0/0 <i class="fa fa-camera" aria-hidden="true"></i>
                        </div>
                        @endif
                    </div>

                    @if($car->is_featured == 1 && $car->updated_at && now()->diffInDays($car->updated_at) <= 3)
                    <div class="sale-tag">
    Spotlight
</div>

                    @endif
                    <style>
.sale-tag {
    border-radius: 10px;
    background: linear-gradient(45deg, #ff5900, #ffd700); /* Vibrant orange-to-gold gradient */
    color: white;
    font-weight: bold;
    padding: 10px 20px;
    /* text-transform: uppercase; */
    font-size: 16px;
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
</style>
@if($car->is_featured == 1 && $car->updated_at && now()->diffInDays($car->updated_at) <= 3)
<div style="border-top: 5px solid #ff9e02; animation: glow 1.5s infinite alternate;">
</div>
@endif
					<div class="product-single-gallery mb-40"@if($car->is_featured == 1)    @endif>
<style>
  @keyframes glow {
  0% {
    box-shadow: 0 0 5px #ff9e02, 0 0 10px #ff9e02, 0 0 15px #ff9e02;
  }
  50% {
    box-shadow: 0 0 20px #ff9e02, 0 0 30px #ff9e02, 0 0 40px #ff9e02;
  }
  100% {
    box-shadow: 0 0 5px #ff9e02, 0 0 10px #ff9e02, 0 0 15px #ff9e02;
  }

}

</style>
						<div class="swiper product-single-slider">

						  <div class="swiper-wrapper" >



                            @php
                            $sortedGalleries = $car->galleries->sortBy('priority');
                            @endphp
                            @foreach ($sortedGalleries as $key => $gallery)




						      @if(!empty($car->youtube_video) && $key == 1)
						      <div class="swiper-slide" >
								<figure class="lazy-container ratio ratio-5-3">

								         <iframe width="560" height="315" src="{{youtube_embed_link($car->youtube_video)}}" frameborder="0" allowfullscreen></iframe>

								</figure>
							  </div>
							  @else
							      <div class="swiper-slide">
                            <figure class="lazy-container ratio ratio-5-3">
                                @if ($car->is_sold == 1 || $car->status == 2 )
                                    <div class="sold-badge">
                                        <span class="sold-text">Sold</span>
                                        <span class="sold-text">Sold</span>
                                        <span class="sold-text">Sold</span>
                                    </div>
                                @endif

                              <a href="{{  $car->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' . $gallery->image) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' .  $gallery->image }}" class="lightbox-single">

                            	<img class="lazyload us_imgs_carosals" data-src="{{  $car->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' . $gallery->image) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' .  $gallery->image }}"
                            	  alt="product image" style="transform: rotate({{$gallery->rotation_point}}deg);"   onerror="this.onerror=null;this.src='{{ asset('assets/img/Image_not_available.png') }}';"  />
                              </a>
                            </figure>
                            </div>
						      @endif

                            @endforeach



						  </div>


                        <div class="slider-navigation">
                            <button type="button" title="Slide prev" class="slider-btn slider-btn-prev radius-0">
                                <i class="fal fa-angle-left"></i>
                            </button>
                            <button type="button" title="Slide next" class="slider-btn slider-btn-next radius-0">
                                <i class="fal fa-angle-right"></i>
                            </button>
                        </div>



						</div>

						<div class="product-thumb">
						  <div class="swiper slider-thumbnails">
							<div class="swiper-wrapper">
    							  @foreach ($sortedGalleries as $key => $gallery)

            								<div class="swiper-slide">
            								  <div class="thumbnail-img lazy-container ratio ratio-5-3">
            									<img class="lazyload " data-src="{{  $car->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' . $gallery->image) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' .  $gallery->image }}"
            									  alt="product image"  style="transform: rotate({{$gallery->rotation_point}}deg);"  onerror="this.onerror=null;this.src='{{ asset('assets/img/Image_not_available.png') }}';"  />
            								  </div>
            								</div>

    							  @endforeach
							</div>
						  </div>


						</div>
					  </div>

				</div>
			</div>



          <div class="product-single-details">

			<div class="card">
				<div class="card-body">
					<div class="row">
					  <div class="col-md-8">
						<h5 class="product-title mb-0">{{ @$car->car_content->title }}</h5>
						<ul class="dotted-inlinelist list-inline mb-3">
							<li class="list-inline-item">
								<a href="{{ route('frontend.cars', ['category' => @$car->car_content->category->slug]) }}" class="small text-secondary">{{ @$car->car_content->category->name }}</a>
                <li class="list-inline-item">
								<span class="small text-secondary">
								 - {{$car->visitors()->get()->count()}} Views
								</span>
							</li>
                <li class="list-inline-item">
                  <span class="small text-secondary">
                   - 	{{calculate_datetime($car->created_at)}}
                  </span>
                </li>
							</li>


						</ul>

                        @if ($car->is_sold == 0)

                            <div style="display:flex;margin-top: 1rem;">

                                @if ($car->manager_special  == 1)
                                <div class="price-tag" style="padding: 3px 10px;border-radius:5px; background:#25d366;font-size: 9px;margin-bottom:15px;" > Manage Special</div>
                                @endif

                                @if($car->is_sale == 1)
                                <div class="price-tag" style="padding: 3px 10px;border-radius:5px;margin-left: 7px;background: #434d89;font-size: 9px;margin-bottom:15px;" >  Sale </span></div>
                                @endif

                                @if($car->reduce_price == 1)
                                <div class="price-tag" style="padding: 3px 10px;border-radius:5px;margin-left: 7px;background:#ff4444;font-size: 9px;margin-bottom:15px;" >    Reduced </span></div>
                                @endif

                                @if($car->deposit_taken == 1)
                                <div class="price-tag" style="padding: 3px 10px;border-radius:5px;margin-left: 7px;background:#32a1be;font-size: 9px;margin-bottom:15px;" >  Deposit Taken </span></div>
                                @endif

                                @if(!empty($car->warranty_duration))
                                <div class="price-tag" style="padding: 3px 10px;border-radius: 5px;margin-left: 10px; margin-bottom:15px;background: #ebebeb;font-size: 11.5px;color: #525252;border: 1px solid #d6d6d6;box-shadow: 0px 0px 5px gray;" > {{$car->warranty_duration}} Warranty</span></div>
                                @endif

                            </div>

                        @endif

					    <ul class="product-icon-list  list-unstyled d-flex justify-content-start align-items-end" >

                       @if ($car->price != null)
                      <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                        title="Price">
                           <!--<b style="color: gray;">Price</b>
                          <br>--->
                          <strong  class="us_mrg priceFormat" style="color: black;font-size: 26px;    margin-left: 0;"
                          data-price="{{ $car->price }}">
                       @if($car->previous_price && $car->previous_price < $car->price)
                         <strike style="font-weight: 300;color: gray;font-size: 14px; float: left;"
                         class="priceFormat" data-price="{{ $car->price }}"
                         >
                         {{ symbolPrice($car->price) }}</strike> <br>
                          <div style="color:black;" class="priceFormat" data-price="{{ $car->previous_price }}"> {{ symbolPrice($car->previous_price) }}</div>
                          @else
                          £{{ number_format($car->price, 0, '.', ',') }}

                        @endif
                        </strong>
                      </li>
                      @endif

                       @if ($car->price != null && $car->price >= 1000)
                          <li class="icon-start" style="border-bottom: 2px solid #00000;" data-tooltip="tooltip" data-bs-placement="top"
                            title="">
                              <b style="color: gray;">From</b>

                            <strong style="color: black;font-size: 20px;" class="priceFormat" data-price="{{ calulcateloanamount(!empty($car->previous_price && $car->previous_price < $car->price) ?
                              $car->previous_price : $car->price)[0] }}">
                            {!! calulcateloanamount(!empty($car->previous_price && $car->previous_price < $car->price) ?
                               $car->previous_price : $car->price)[0] !!}
                               </strong>
                          </li>
                      @endif

                    </ul>


                    @php
                        $financing_url = '';
                        $financing_dealer = '';
                    @endphp

                    @if ($car->price != null && $car->price >= 1000)
                      <a href="javascript:void(0);" style="color:#00b1f5; font-size:14px;" data-text="{!!calulcateloanamount($car->price)[1]!!}" onclick="return openPopModal(this , {{$car->price}})">
                          @if(!empty($car->financing_dealer) && !empty($car->financing_url) )
                            {{$car->financing_dealer}}

                            @php
                                $financing_url = $car->financing_url;
                                $financing_dealer = $car->financing_dealer;
                            @endphp

                          @else
                            <strong style="font-size: 18px; font-weight: bold;">Get Finance Approval</strong>
                          @endif
                          </a>
                      @endif

					  </div>


					  <div class="col-md-4 d-flex align-items-end pb-2 offsetCol"
            >
                        @if (Auth::guard('vendor')->check())
                        @php
                            $user_id = Auth::guard('vendor')->user()->id;
                            $checkWishList = checkWishList($car->id, $user_id);
                        @endphp
                        @else
                        @php
                            $checkWishList = false;
                        @endphp
                        @endif

						<div class="d-flex justify-content-between align-items-center" style="width:140px ; margin-left:auto;">
                <a href="javascript:void(0);" class="btn2" style=" color: #1b87f4 !important; display: inline-block;
                      font-size: 18px;font-weight:bold;" onclick="openShareModal(this)"
                data-url="{{ route('frontend.car.details', ['cattitle' => catslug($car->car_content->category_id), 'slug' => $car->car_content->slug, 'id' => $car->id]) }}"
                style="color: #1b87f4;" >
                <i class="fa fa-share-alt" aria-hidden="true"></i> Share
                </a>
                <a href="javascript:void(0);"
                      onclick="addToWishlist({{$car->id}})"
								class="btn2  " style="display: inline-block;font-size:18px;font-weight:bold;"
								data-tooltip="tooltip" data-bs-placement="right"
								title="{{ $checkWishList == false ? __('Save Ads') : __('Saved') }}">
                @if($checkWishList == false)
                            <i class="fal fa-heart" style="font-size: 18px; color:red;padding-right: 2px;font-weight:bold;" ></i>Save
                        @else
                            <i class="fa fa-heart" aria-hidden="true" style="font-size: 18px; color:red;padding-right: 2px;font-weight:bold;"></i>Save
                        @endif
							  </a>




						</div>
					  </div>

					</div>
				</div>
			</div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                        @if($car->car_content->main_category_id && $car->car_content->main_category_id == 24)
                        <div class="col-12 col-md-6">
                        <div class="d-flex border-bottom py-3 justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                        <i class="fal fa-calendar" style="font-size: 19px;color: #1b87f4;"></i></div>

                                        <div class="NotifyFont" >Mileage</div>

                                    </div>
                                    <div class="fw-bolder Notify-font-right">
                                    {{number_format($car->mileage ? $car->mileage : 0)}}
                                    </div>
                                </div>
                        </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex border-bottom py-3 justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                        <i class="fal fa-tachometer" style="font-size: 19px;color: #1b87f4;"></i></div>
                                        <div class="NotifyFont" >Year</div>
                                    </div>
                                    <div class="fw-bolder Notify-font-right">
                                    {{ $car->year ? $car->year : 0 }}
                                    </div>

                                </div>
                        </div>

                        <div class="col-12 col-md-6">
                        <div class="d-flex border-bottom py-3 justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                        <i class="fal fa-wrench"" style="font-size: 19px;color: #1b87f4;"></i></div>
                                        <div class="NotifyFont" >Engine Capacity
                                        </div>
                                    </div>
                                    <div class="fw-bolder Notify-font-right">
                                    {{ roundEngineDisplacement($car) ? roundEngineDisplacement($car) : ''  }}
                                    </div>
                                </div>
                        </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex border-bottom py-3 justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                        <i class="fal fa-cogs" style="font-size: 19px;color: #1b87f4;"></i></div>
                                        <div class="NotifyFont" >Transmission Type</div>
                                    </div>
                                    <div class="fw-bolder Notify-font-right">
                                    {{ optional($car->car_content->transmission_type)->name ? optional($car->car_content->transmission_type)->name : '' }}
                                    </div>
                                </div>
                        </div>
                        @endif


                        <div class="{{$car->vendor->vendor_type == 'dealer' ? 'col-12 col-md-6' : 'col-12'}}">
                        <div class="d-flex border-bottom py-3 justify-content-between align-items-center">

                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                        <i class="fal fa-shipping-fast"" style="font-size: 19px;color: #1b87f4;"></i></div>
                                        <div class="NotifyFont" >Delivery available

                                        </div>
                                    </div>

                                    <div class="fw-bolder Notify-font-right">
                                      @if($car->delivery_available == 1)
                                          Yes
                                      @else
                                          No
                                      @endif
                                    </div>
                                </div>
                        </div>
                        @if($car->car_content->main_category_id && $car->car_content->main_category_id == 24)
                            <div class="col-12 col-md-6">
                                <div class="d-flex border-bottom py-3 justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                        <i class="fal fa-users" style="font-size: 19px;color: #1b87f4;"></i></div>
                                        <div class="NotifyFont" >Total Owners</div>
                                    </div>
                                    <div class="fw-bolder Notify-font-right">
                                    {{ (!empty($car->number_of_owners)) ? $car->number_of_owners : $car->owners }}
                                    </div>
                                </div>
                        </div>
                        @endif
<!-- end of milage and  -->

                            <div class="col-12 mt-3">
                            <div class="alert alert-success" role="alert" id="alertSuccess" style="display:none;">
                                We have just saved your interest will notify you once any match found.
                            </div>
                            </div>
                            <div class="col-lg-6 ">
                                <div class="col-md-12  clearfix ">
                                    <div class="float-start "><p> <b>Get notified when similar ads are posted</b> <br>
                                         <small>Save this search to get notifications for ads like this</small> </p></div>
                                   </div>
                             </div>
                         <div class="col-lg-6 d-flex justify-content-center">
                            <div class="col-12 col-md-12 mt-2 clearfix">
                                <div class="">
                                    @if (Auth::guard('vendor')->check() )


                                    <a class="btn btn-lg btn-outline active  w-100"  href="javascript:void(0);" data-name="{{ @$car->car_content->title }}" data-category_slug="{{$car->car_content->category_slug}}"  data-transmissiontype="{{ optional($car->car_content->transmission_type)->slug }}" data-fueltype="{{ optional($car->car_content->fuel_type)->slug }}"   data-model="{{ optional($car->car_content->model)->slug }}"  data-brand="{{ optional($car->car_content->brand)->slug }}" data-year="{{$car->year}}" onclick="notifyMe(this)">
                                    Notify Me</a>

                                    @else

                                    <a class="btn btn-lg btn-outline active  w-100"  href="{{ route('vendor.login') }}" >
                                    Notify Me</a>

                                    @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(!empty($car->filters) && empty($car->year))
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="mb-20" onclick="openDropdown(this)" style="cursor:pointer;" >
						        {{ __('Specifications') }}
						        <span style="float: right;font-size: 1.5rem;" ><i class="fa fa-caret-down" aria-hidden="true"></i></span>
						  </h4>

                            <div class="row us_open_row">
                                    @php
                                       $filters = json_decode($car->filters , true);
                                    @endphp

                                    @foreach($filters as  $key => $filter)

                                    @if (strpos($key, 'select') !== false)
                                        <div class="col-md-6" style="display: flex; margin-bottom: 1rem;">
                                            <h5>{{ ucwords(strtolower(str_replace('select', '', str_replace('_', ' ', $key)))) }}</h5>
                                            <div style="margin-left: 1rem; font-size: 15px;">{{$filter}}</div>
                                        </div>
                                    @endif

                                    @if (strpos($key, 'radio') !== false)
                                        <div class="col-md-6" style="display: flex; margin-bottom: 1rem;">
                                            <h5>{{ ucwords(strtolower(trim(str_replace('radio', '', str_replace('_', ' ', $key))))) }}</h5>
                                            <div style="margin-left: 1rem; font-size: 15px;">{{$filter}}</div>
                                        </div>
                                    @endif

                                    @if (strpos($key, 'input') !== false)
                                        <div class="col-md-6" style="margin-bottom: 1rem;">
                                            <h5>{{ ucwords(strtolower(trim(str_replace('input', '', str_replace('_', ' ', $key))))) }}</h5>
                                            <div>
                                                 @if($car->car_content->main_category_id == '233' && ($key == 'input_pay_maximum' || $key == 'input_pay_minimum' ))
                                                   <b>£</b>
                                                 @endif

                                                {{ str_replace('_', ' ', $filter) }}

                                                </div>
                                        </div>
                                    @endif

                                    @if (strpos($key, 'textarea') !== false)
                                        <div class="col-md-6" style="margin-bottom: 1rem;">
                                            <h5>{{ ucwords(strtolower(trim(str_replace('textarea', '', str_replace('_', ' ', $key))))) }}</h5>
                                            <div>
                                                    @if($car->car_content->main_category_id == '233')
                                                    @php
                                                        $explode = explode(',', $filter);

                                                        if(count($explode) > 0)
                                                        {
                                                            foreach($explode as $skill)
                                                            {
                                                                echo '<span style="background: #c4c4c4;color: white;padding: 2px 10px 3px;margin: 5px;border-radius: 5px;font-size: 13px;display: inline-block;border: 1px solid #b3b3b3;">' . ucfirst($skill) . '</span>';
                                                            }
                                                        }
                                                        else
                                                        {
                                                            echo $filter;
                                                        }

                                                    @endphp

                                                    @else
                                                        {{ $filter }}
                                                    @endif
                                            </div>
                                        </div>
                                    @endif

                                    @if (strpos($key, 'checkbox') !== false && $filter)

                                        <div class="col-md-6"  style="display: flex;margin-bottom: 1rem;">
                                        <h5>{{ ucwords(strtolower(trim(str_replace('checkbox', '', str_replace('_', ' ', $key))))) }}</h5>


                                            @foreach($filter as $list)
                                                <div style="margin-left: 1rem;font-size: 15px;" >
                                                      <i class="fa fa-check-square text-primary" aria-hidden="true" style="margin-right: 5px;"></i>  {{$list}}
                                                </div>
                                            @endforeach

                                        </div>

                                    @endif

                                    @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">

              <div class="col-lg-12">
				@if ($car->year != null)
				<!-- Product specification -->
				<div class="card">
					<div class="card-body">
						<div class="product-spec">

						  <h4 class="mb-20" onclick="openDropdown(this)" style="cursor:pointer;" >
						        {{ __('Specifications') }}
						        <span style="float: right;font-size: 1.5rem;" ><i class="fa fa-caret-down" aria-hidden="true"></i></span>
						  </h4>

						  <div class="row us_open_row">
							@if ($car->what_type != null)
						<div class=" col-6 col-md-3 mb-20 d-flex" >
							    <i class="fal fa-info-circle" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
							        <div>
							  <h6 class="mb-1">{{ __('Condition') }}</h6>
							  <span>{{ ucwords(str_replace('_' , ' ' , $car->what_type )) }}</span>
							</div>
							</div>
							@endif

							@if ($car->year != null)
							<div class=" col-6 col-md-3 mb-20 d-flex" >
							    <i class="fal fa-calendar" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
							        <div>
							            <h6 class="mb-1">  {{ __('Model Year') }}</h6>
							            <span>{{ $car->year }}</span>
							        </div>
							</div>
							@endif

							@if ($car->mileage != null)
							<div class="col-6 col-md-3 mb-20 d-flex">
							     <i class="fal fa-tachometer" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
                                <div>
                                    <h6 class="mb-1">{{ __('Mileage') }}</h6>
                                    <span>{{ number_format($car->mileage) }}</span>
                                </div>
							</div>
							@endif


							@if ($car->car_content->brand != null)
							<div class="col-6 col-md-3 mb-20 d-flex">
							     <i class="fal fa-taxi" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
							     <div>
							        <h6 class="mb-1">Make</h6>
							        <span>{{ optional($car->car_content->brand)->name }}</span>
							    </div>
							</div>
							@endif

							 @if ($car->car_content->model != null)
							<div class="col-6 col-md-3 mb-20 d-flex">
							    <i class="fal fa-car" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
							    <div>
							        <h6 class="mb-1">{{ __('Model') }}</h6>
							        <span>{{ optional($car->car_content->model)->name }}</span>
							   </div>
							</div>
							@endif

							@if ($car->car_content->fuel_type != null )
							<div class="col-6 col-md-3 mb-20 d-flex">

							    <i class="fal fa-gas-pump" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>

							   <div>
							        <h6 class="mb-1">{{ __('Fuel Type') }}</h6>
							        <span>{{ optional($car->car_content->fuel_type)->name }}</span>
							   </div>
							</div>
							@endif

							@if ($car->car_content->transmission_type != null)
							<div class="col-6 col-md-3 mb-20 d-flex">

							    <i class="fal fa-cogs" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>

                                <div>
                                    <h6 class="mb-1">{{ __('Transmission Type') }}</h6>
                                    <span>{{ optional($car->car_content->transmission_type)->name }}</span>
                                </div>

							</div>
							@endif

							@if ($car->engineCapacity != null)
							<div class="col-6 col-md-3 mb-20 d-flex">

                                <i class="fal fa-wrench" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>

                                <div>
                                <h6 class="mb-1">{{ __('Engine Capacity') }}</h6>
                                <span> {{ roundEngineDisplacement($car) }} </span>
                                </div>
							 </div>
							@endif

							@if ($car->doors != null)
							<div class="col-6 col-md-3 mb-20 d-flex">

                                <img src="{{asset('car.png')}}" style="margin-right: 1rem;height: 30px;" />
                                <div>
							  <h6 class="mb-1">{{ __('Doors') }}</h6>
							  <span>{{ $car->doors }}</span>
							</div>
							</div>
							@endif

							@if ($car->seats != null)
							<div class="col-6 col-md-3 mb-20 d-flex">

                               <img src="{{asset('seat.png')}}" style="margin-right: 1rem;height: 30px;" />

                                <div>
							  <h6 class="mb-1">{{ __('Seats') }}</h6>
							  <span>{{ $car->seats }}</span>
							  	</div>
							</div>
							@endif



							@if ($car->number_of_owners != null || $car->owners != null )
								<div class="col-6 col-md-3 mb-20 d-flex">

                                <i class="fal fa-users" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>

                                <div>
							  <h6 class="mb-1">{{ __('Number of owners') }}</h6>
							  <span>{{ (!empty($car->number_of_owners)) ? $car->number_of_owners : $car->owners }}</span>
							</div>
							</div>
							@endif


                            @if ($car->road_tax != null)
                            <div class="col-6 col-md-3 mb-20 d-flex">

                                <i class="fal fa-file-invoice-dollar" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>

                                <div>
                                    <h6 class="mb-1">{{ __('Road Tax') }}</h6>
                                    <span>{{ $car->road_tax }}</span>
                                </div>
                            </div>
                            @endif

                             @if ($car->vat_status != null)
                            <div class="col-6 col-md-3 mb-20 d-flex">

                                 <img src="{{asset('tax.png')}}" style="margin-right: 1rem;height: 30px;" />

                                <div>
                                    <h6 class="mb-1">VAT Status</h6>
                                    <span>{{ $car->vat_status }}</span>
                                </div>
                            </div>
                            @endif



                            @if ($car->power != null)
                            <div class="col-6 col-md-3 mb-20 d-flex">

                            <i class="fal fa-power-off" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>

                            <div>
                            <h6 class="mb-1">{{ __('Power') }}</h6>
                            <span>{{ $car->power }} BHP</span>
                            </div>
                            </div>
                            @endif




							@if ($car->bettery_range != null || $car->battery != null  && in_array(optional($car->car_content->fuel_type)->name , ['Electric' , 'Hybrid']) )
							<div class="col-6 col-md-3 mb-20 d-flex">

                            <i class="fal fa-battery-full" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>

                            <div>
							  <h6 class="mb-1">{{ __('Bettery Range') }}</h6>
							  <span>{{ (!empty($car->bettery_range)) ? $car->bettery_range : $car->battery. '+ M' }}</span>
							</div>
							 </div>
							@endif


							@if ($car->history_checked > 0)
								<div class="col-6 col-md-3 mb-20 d-flex">

                            <i class="fal fa-history" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>

                            <div>
							  <h6 class="mb-1">{{ __('History checked') }}</h6>
							  <span>Yes</span>
							</div>
							</div>

							@endif

							@if ($car->delivery_available > 0)
							<div class="col-6 col-md-3 mb-20 d-flex">

                            <i class="fal fa-shipping-fast" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>

                            <div>
							  <h6 class="mb-1">{{ __('Delivery available') }}</h6>
							  <span>Yes</span>
							</div>
								</div>
							@endif

							@if ($car->warranty_type != null)
						<div class="col-6 col-md-3 mb-20 d-flex">

                            <i class="fal fa-check" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>

                            <div>
							  <h6 class="mb-1">{{ __('Warranty Type') }}</h6>
							  <span>{{ $car->warranty_type }}</span>
							</div>
							</div>
							@endif

							@if ($car->warranty_duration != null || $car->warranty != null )
								<div class="col-6 col-md-3 mb-20 d-flex">

                            <i class="fal fa-clock" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>

                            <div>
							  <h6 class="mb-1">{{ __('Warranty duration') }}</h6>
							  <span>{{ (!empty($car->warranty_duration)) ? $car->warranty_duration : $car->warranty }}</span>
							</div>
							</div>
							@endif

						  </div>

                                    @if(!empty($car->filters))
                                    @php
                                    $filters = json_decode($car->filters , true);
                                    @endphp

                                    <div class="row">


								<div class="col-12 mb-20" style="font-size: 25px;font-weight: bold;color: #1b87f4;">
						           <i class="fa fa-info-circle" style="font-size:24px"></i> Additional Specifications
							    </div>


                                    @foreach($filters as  $key => $filter)

                                    @if (strpos($key, 'select') !== false)
                                    <div class="col-md-6" style="display: flex; margin-bottom: 1rem;">
                                        <h5>{{ ucwords(strtolower(str_replace('select', '', str_replace('_', ' ', $key)))) }}</h5>
                                        <div style="margin-left: 1rem; font-size: 15px;">{{$filter}}</div>
                                    </div>
                                    @endif



                                    @if (strpos($key, 'radio') !== false)
                                    <div class="col-md-6" style="display: flex; margin-bottom: 1rem;">
                                        <h5>{{ ucwords(strtolower(trim(str_replace('radio', '', str_replace('_', ' ', $key))))) }}</h5>
                                        <div style="margin-left: 1rem; font-size: 15px;">{{$filter}}</div>
                                    </div>
                                    @endif



                                    @if (strpos($key, 'input') !== false)
                                    <div class="col-md-6" style="margin-bottom: 1rem;">
                                        <h5>{{ ucwords(strtolower(trim(str_replace('input', '', str_replace('_', ' ', $key))))) }}</h5>
                                        <div>{{ str_replace('_', ' ', $filter) }}</div>
                                    </div>
                                    @endif


                                    @if (strpos($key, 'textarea') !== false)
                                    <div class="col-md-6" style="margin-bottom: 1rem;">
                                        <h5>{{ ucwords(strtolower(trim(str_replace('textarea', '', str_replace('_', ' ', $key))))) }}</h5>
                                        <div>{{$filter}}</div>
                                    </div>
                                    @endif


                                    @if (strpos($key, 'checkbox') !== false && $filter)

                                        <div class="col-md-6"  style="display: flex;margin-bottom: 1rem;">
                                        <h5>{{ ucwords(strtolower(trim(str_replace('checkbox', '', str_replace('_', ' ', $key))))) }}</h5>


                                            @foreach($filter as $list)
                                                <div style="margin-left: 1rem;font-size: 15px;" >
                                                      <i class="fa fa-check-square text-primary" aria-hidden="true" style="margin-right: 5px;"></i>  {{$list}}
                                                </div>
                                            @endforeach

                                        </div>

                                    @endif

                                    @endforeach

                                    </div>


                                    @endif
						</div>
					</div>
				</div>
				@endif


				@if ($car->vendor->vendor_type == 'dealer' && $specification_pluck->count() > 0 && $specifications->count() > 0)
				<div class="card">
					<div class="card-body">
						<h4 class="mb-40 mt-20" onclick="openDropdown(this)" style="cursor:pointer;"  >
						    {{ __('  Vehicle Features') }}

						    <span style="float: right;font-size: 1.5rem;" ><i class="fa fa-caret-down" aria-hidden="true"></i></span>
						</h4>

						<div class="row us_open_row" style="display:none;">
						@foreach($specification_pluck as $speci_pluck)
							<div class="col-lg-12 col-sm-12 col-md-12 mb-20">
								<h6 class="mb-1">{{ str_replace('_N_' , ' & ' ,  strtoupper($speci_pluck )) }}</h6>
							</div>
							@foreach ($specifications as $specification)

								@if($specification->parent_name === $speci_pluck)
								<div class="col-lg-4 col-sm-4 col-md-4 mb-20">
								  <span> <i class="fal fa-circle" style="font-size: 14px;margin-right: 5px;"></i> {{ str_replace('_' , ' ' ,  ucfirst($specification->value ))  }}</span>
								</div>
								@endif
							@endforeach
						@endforeach
						</div>
					</div>
				</div>
				@endif


				<div class="card">
					<div class="card-body">
						<div class="product-desc">
						  <h4 class="mb-20">{{ __('Description') }}  </h4>
                                <div class="tinymce-content us_open_row" >
                                <div id="car-description" class="partial-description" style="position: relative;">
                                       {!! optional($car->car_content)->description !!}
                                       <div id="over-flow-fade"></div>
                                       </div>
                                <button id="read-more" style="margin-left: -3px;color: #00278c; z-index: 1;">
                                    Read More
                                </button>
                                <button id="read-less" style="margin-left: -3px;color: #00278c;z-index: 1;">
                                    Read Less
                                </button>
                                </div>
						</div>
					</div>
				</div>



				<div class="card">


				       @if ($car->vendor_id != 0)
                    <div class="col-md-12" style=" margin: 1rem;">

                        <div class="author mb-15 us_parent_cls" >

                            <a style="display:flex;" class="color-medium"
                            href="{{ route('frontend.vendor.details', ['id' => $car->vendor->id , 'username' => ($vendor = @$car->vendor->username)]) }}"
                            target="_self" title="{{ $vendor = @$car->vendor->username }}">
                            @if ($car->vendor->photo != null)

                            @php
                            $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $car->vendor->photo;

                            if (file_exists(public_path('assets/admin/img/vendor-photo/' . $car->vendor->photo))) {

                            $photoUrl = asset('assets/admin/img/vendor-photo/' . $car->vendor->photo);
                            }

                            if(empty($car->vendor->photo))
                            {
                                $photoUrl = asset('assets/img/blank-user.jpg');
                            }

                            @endphp

                            <img
                            style="border-radius: 10%; max-width: 60px;"
                            class="lazyload blur-up"
                            src="{{ asset('assets/img/blank-user.jpg') }}"
                            data-src="{{ $photoUrl }}"
                            alt="Vendor"

                            onerror="{{ asset('assets/img/blank-user.jpg') }}" >


                            @else
                            <img style="border-radius: 10%;max-width: 60px;" class="lazyload blur-up" data-src="{{ asset('assets/img/blank-user.jpg') }}"
                            alt="Image">
                            @endif
                            <span style="    margin-left: 1rem;">

                             <strong class="us_font_15" style="color: black;font-size: 20px;">{{ $car->vendor->vendor_info->name }}
                             @if(!empty($car->vendor->est_year)) <b>.</b> <span style="font-size: 15px;font-weight: normal;color: gray;">Est {{$car->vendor->est_year}}</span> @endif </strong>

                                @php

                                $review_data = null;

                                @endphp

                                    @if($car->vendor->google_review_id > 0 )
                                        @php
                                            $review_data = get_vendor_review_from_google($car->vendor->google_review_id , true);
                                        @endphp
                                    @endif

                                    @if($car->vendor->vendor_type == 'dealer')

                                        @if($car->vendor->is_franchise_dealer == '1')
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
                                    @else


                                @if ($car->vendor->trader==0)
                                <div>{{ Ucfirst(@$car->vendor->vendor_info->city) }} @if(!empty($car->vendor->vendor_info->city)) . @endif Private Seller </div>
                                @else
                                <div>{{ Ucfirst(@$car->vendor->vendor_info->city) }} @if(!empty($car->vendor->vendor_info->city)) . @endif  Trader </div>
                                @endif


                                    @endif
                            </span>
                            </a>
                        </div>
                    </div>
                    @endif

                    @if ($car->vendor->banner_image)

                    <img src=" {{  $car->vendor->vendor_type == 'normal' ? asset('public/uploads/'.$car->vendor->banner_image) :  env('SUBDOMAIN_APP_URL').'public/uploads/' . $car->vendor->banner_image }} " style="height:400px;    object-fit: cover;" alt="banner" />

                    @endif

                    <div class="container">
                        <div class="row" style="margin-top: 1rem;">

                        <div class="col-md-6">


                        @if(Auth::guard('vendor')->check() && $car->vendor->id == Auth::guard('vendor')->user()->id )

                         @if( !empty($car->package_id) && in_array($car->status , [0,1]) && $car->is_sold != 1 )

                            @if($car->status==0)
                                <a href = "{{ route('vendor.package.payment_method',  $car->id) }}"  class="btn btn-md  w-100 showLoader mb-3 us_hider" style="color:white;background-color: #007BFF;padding-top: 0.8rem;padding-bottom: 0.8rem;margin-bottom: 0px !important;" >
                                <i class="fal fa-money"></i> Pay Now
                                </a>
                            @endif

                            @if($car->status==1)
                                <a href = "{{ route('vendor.package.payment_boost',  [$car->car_content->main_category_id,$car->id]) }}"  class="btn btn-md  w-100 showLoader mb-3 us_hider" style="color:white;padding-top: 0.8rem;padding-bottom: 0.8rem;margin-bottom: 0px !important;background-color: #007BFF;" >
                                <i class="fal fa-paper-plane"></i> Boost
                                </a>
                            @endif

                        @endif

                        <a href="{{ route('vendor.cars_management.edit_car', $car->id)  }}"  class="btn btn-md btn-primary w-100 showLoader mt-3 mb-3 us_hider" >
                        <i class="fa fa-pencil" aria-hidden="true"></i>  Edit
                        </a>

                        @else

                        @if($car->vendor->show_contact_form == 1 && $car->message_center == 1)

                            @if (Auth::guard('vendor')->check() )
                                <button type="button" class="btn btn-md  w-100 us_hider " style="color:white;background-color: #007BFF;padding-top: 0.8rem;padding-bottom: 0.8rem;margin-bottom: 0px !important;" data-toggle="modal" data-target="#exampleModal">
                                     @if($car->vendor->vendor_type == 'normal')
                    {{ __('Send message') }}
                    @else
                     {{ __('Make  Enquiry') }}
                    @endif
                                </button>
                            @else
                                <a href="{{ route('vendor.login') }}">
                                    <button type="submit" id="showform2ee"  class="btn btn-md  w-100 showLoader mb-3 us_hider" style="color:white;background-color: #007BFF;padding-top: 0.8rem;padding-bottom: 0.8rem;margin-bottom: 0px !important;">
                                          @if($car->vendor->vendor_type == 'normal')
                    {{ __('Send message') }}
                    @else
                     {{ __('Make  Enquiry') }}
                    @endif
                                    </button>
                                </a>
                            @endif


                        @endif

                            @if($car->phone_text == 1)

                                <a href="tel:{{$car->vendor->country_code.$car->vendor->phone}}" id="userphonebutton" style="margin-top:1rem;" onclick="savePhoneView({{@$car->id}} , this)"  class="btn btn-md btn-primary w-100 showLoader mb-3  us_hider" data-phone_number="{{$car->vendor->country_code.$car->vendor->phone}}">Call Now</a>

                                @if($car->vendor->also_whatsapp == 1)
                                <a href="https://api.whatsapp.com/send?phone={{ $car->vendor->country_code.$car->vendor->phone }}&text=I'm%20interested%20in%20this%20item%3A%20{{ urlencode(route('frontend.car.details', ['cattitle' => catslug($car->car_content->category_id), 'slug' => $car->car_content->slug, 'id' => $car->id])) }}"
                                class="btn btn-md btn-primary w-100 showLoader mb-3 us_hider" target="_blank">
                                WhatsApp Now
                                </a>
                                @endif

                            @endif
                        @endif

                        <a class="btn btn-md btn-outline w-100 showLoader mb-3 @if($car->phone_text == 0) mt-3 @endif" href="{{ route('frontend.vendor.details' , ['id' => $car->vendor->id , 'username' => $car->vendor->username]) }}">
                        @if($car->vendor->vendor_type == 'dealer')
                        Visit Showroom
                        @else
                        View All Ads
                        @endif
                        </a>

                        </div>

                            <div class="col-md-6">
                                @php

                                $totl_per = 'N/A';

                                $totalSupportTicket = \App\Models\SupportTicket::where('admin_id', $car->vendor->id)->count();

                                if($totalSupportTicket > 0 )
                                {
                                     $totalSupportTicketWithMessages = \App\Models\SupportTicket::where('admin_id', $car->vendor->id)
                                    ->has('messages')
                                    ->count();
                                    $responseRate = ($totalSupportTicketWithMessages / $totalSupportTicket) * 100;

                                   $totl_per =  round($responseRate, 2) . "%";
                                }


                                @endphp
                            <div class="flex" style="margin-bottom:  0.5rem;">
                                <label style="font-size: 15px;">Avg. Response Rate</label>
                                <div style="float:right">{{  $totl_per }}</div>
                            </div>

                             <div class="flex" style="margin-bottom:  0.5rem;">
                                <label style="font-size: 15px;">Location</label>
                                <div style="float:right">{{  !empty($car->vendor->vendor_info) ? ucfirst($car->vendor->vendor_info->city) : 'none' }}</div>
                            </div>

                             <div class="flex" style="margin-bottom:  0.5rem;">
                                <label style="font-size: 15px;">Member since</label>
                                <div style="float:right">{{  !empty($car->vendor->created_at) ? date('Y' , strtotime($car->vendor->created_at)) : date('Y') }}</div>
                            </div>

                            @if(!empty($car->vendor->est_year))
                             <div class="flex" style="margin-bottom:  0.5rem;">
                                <label style="font-size: 15px;">Est year</label>
                                <div style="float:right">{{  !empty($car->vendor->est_year) ? $car->vendor->est_year : date('Y') }}</div>
                            </div>
                            @endif

                             <div class="flex" style="margin-bottom:  0.5rem;">
                                <label style="font-size: 15px;">Active Ads</label>
                                <div style="float:right">{{  !empty($car->vendor->cars) ? $car->vendor->cars->where('status' , 1)->count() : '0' }}</div>
                            </div>

                            @if($car->vendor->vendor_type == 'normal')
                             <div class="flex" style="margin-bottom:  0.5rem;">
                                <label style="font-size: 15px;">Life time Ads</label>
                                <div style="float:right">{{  !empty($car->vendor->cars) ? $car->vendor->carsWithTrashed->count() : '0' }}</div>
                            </div>
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
                                <div class="flex" style="margin-bottom: 0.5rem;cursor:pointer;" onclick="openHours(this)">
                                    <label style="font-size: 15px; color: {{ $p_label }}">{{ $p_status }}</label>
                                        <div style="float:right; color: black">
                                        {{ $p_timeRange }} <i class="fa fa-caret-down" style="position: relative;
                                        margin-left: 10px;
                                        font-size: 20px;
                                        top: 1px;" aria-hidden="true"></i>
                                    </div>
                                </div>
                                @endif

                                <div class="flex us_open_hours" style="margin-bottom:  0.5rem; display:none;">
                                    <label style="font-size: 15px; color: {{ $labelColor }}">{{ $day }}</label>
                                    <div style="float:right; color: {{ $labelColor }}">
                                        {{ $status }} {{ $timeRange }}
                                    </div>
                                </div>
                            @endforeach

                            </div>


                            @if(!empty($car->vendor->about_us))
                            <div class="col-md-12">

                                <h4>About Us</h4>

                                <p style="font-size: 14px;line-height: 1.6;">

                                    {{$car->vendor->about_us}}

                                </p>

                            </div>
                            @endif

                            <div class="col-md-12">

                            <hr>
                            </div>

                            <div style="font-size: 13px;color: #6d6b6b;">
                                All information in this ad is provided by third parties and ListIt are not in a position to offer any warranty or guarantee in relation to the content.
                             <span style="display:none;"  id="showDisTxt">
                                 <br>
                                 <br>
                                    Both buyer and seller should confirm all information in relation to the vehicle before committing to the sale. We disclaim all liability arising out of or in connection with any reliance placed on the above content. We accept no responsibility for keeping the content and information accurate, up to date or complete.
                             </span>

                             <br><span id="readBtn">
                                    <a href="javascript:void(0);" style="color: #0063fc;" onclick="showmore(1 , this)">read more</a>
                                </span>


                            </div>






                        </div>
                    </div>


					<div class="card-body" style="    padding-top: 0;">
						<div class="product-desc">
						  <h4 class="mb-20">

						  @if(!empty($review_data) &&  $review_data['total_reviews'] > 0 && $review_data['total_ratings'] > 0)
						       {{ $car->vendor->vendor_info->name }}
                            <div class="rating-container" style="font-size: 13px;font-weight: 500;">
                            {!!$review_data['rating_stars']!!}  <b>{{$review_data['total_ratings']}}</b>/5 .   <a target="_blank" style="color: #ee2c7b;" href="https://www.google.com/maps?q={{ str_replace(' ' , '+' , $car->vendor->vendor_info->name) }}"> {{number_format($review_data['total_reviews'] ) }} google reviews </a>
                            </div>

                        @endif
						  </h4>
						  <div class="tinymce-content">
						      @if(!empty($review_data) && $review_data['total_reviews'] > 0 )
						    	{!!$review_data['reviews_output']!!}
							  @endif
						  </div>


						   <div>
						         <hr>

                           <a href="javascript:void(0);" style="color: gray;">
                             <i class="fa fa-flag" aria-hidden="true"></i>  <span style="font-size: 14px;margin-left: 5px;" onclick="reportModal()">Report This Ad</span>
                           </a>
                       </div>


						</div>
					</div>
				</div>



              </div>
              @if (!empty(showAd(3)))
                <div class="text-center mb-3 mt-3">
                  {!! showAd(3) !!}
                </div>
              @endif
            </div>
			  <!--Related Product-area start -->
            @if (count($related_cars) > 0)

              <div class="product-area pt-60" style="padding:2rem;">
                <div class="section-title title-inline mb-30">
                  <h3 class="title mb-20">
                      @if($car->vendor->vendor_type == 'normal' )
                      {{ __('Related Cars') }}
                      @else
                      {{ __('Our Stock') }}
                      @endif
                </h3>

                <div class="slider-navigations mb-20">
                    <a href="{{ route('frontend.vendor.details', ['id' => $car->vendor->id , 'username' => ($vendor = @$car->vendor->username)]) }}">View All</a>
                  </div>

                </div>

                @include('frontend/car/related_ads', ['related_cars' => $related_cars])

              </div>

              @if (!empty(showAd(3)))
                <div class="text-center mb-40">
                  {!! showAd(3) !!}
                </div>
              @endif

              <!-- Product-area end -->
            @endif
          </div>
        </div>
        <div class="col-lg-4">
          <aside class="widget-area">
            <!-- Widget form -->
            <div class="widget widget-form card">
              @if (Session::has('success'))
                <div class="alert alert-success">{{ __(Session::get('success')) }}</div>
              @endif
              @if (Session::has('error'))
                <div class="alert alert-success">{{ __(Session::get('error')) }}</div>
              @endif
              <h5 class="title mb-20">
                  @if($car->vendor->vendor_type == 'dealer')
                {{ __('Contact Dealer') }}
                @else
                Contact Seller
                @endif
              </h5>
              @if ($car->vendor_id != 0)
                <div class="user mb-20">
                  <div class="user-img">
                    <div class="lazy-container ratio ratio-1-1 rounded-pill">
                      @if ($car->vendor->photo != null)

                        @php
                            $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $car->vendor->photo;

                            if (file_exists(public_path('assets/admin/img/vendor-photo/' . $car->vendor->photo))) {

                            $photoUrl = asset('assets/admin/img/vendor-photo/' . $car->vendor->photo);
                            }

                            if(empty($car->vendor->photo))
                            {
                                $photoUrl = asset('assets/img/blank-user.jpg');
                            }

                            @endphp

                            <img
                            class="lazyload "
                            src="{{ asset('assets/img/blank-user.jpg') }}"
                            data-src="{{ $photoUrl }}"
                            alt="Vendor"

                            onerror="{{ asset('assets/img/blank-user.jpg') }}" >



                      @else
                        <img class="lazyload" data-src="{{ asset('assets/img/blank-user.jpg') }}" alt="">
                      @endif
                    </div>
                  </div>
                  <div class="user-info">
                    <h6 class="mb-1">
                      <a href="{{ route('frontend.vendor.details', ['id' => $car->vendor->id , 'username' => $car->vendor->username]) }}"
                        title="{{ $car->vendor->username }}">{{ $car->vendor->vendor_info->name }}</a>
                    </h6>
                    {{ Ucfirst(@$car->vendor->vendor_info->city) }}  @if(!empty($car->vendor->vendor_info->city)) . @endif


                        @if($car->vendor->vendor_type == 'normal')

                        @if ($car->vendor->trader==0)
                        <div> Private Seller </div>
                        @else
                        <div>  Trader </div>
                        @endif
                        @else

                        @if($car->vendor->is_franchise_dealer == 1)
                           Dealer
                          @else
                            Dealer
                          @endif

                        @endif
                        <div style="display: flex;flex-wrap: wrap;">
                          @if($car->vendor->email_verified_at) <!-- Check if email is verified -->
                              <span class="email-verified" style="font-size: 12px;">
                                  <i class="fa fa-check-circle" style="color: #4caf50;"></i> Email Verified
                              </span>
                          @endif &nbsp;
                          @if ($car->vendor->phone_verified == 1)
                              <span class="phone_verified" style="font-size: 12px;">
                                  <i class="fa fa-check-circle" style="color: #4caf50;"></i> Phone Verified
                              </span>
                          @endif
                        </div>




                        @if(!empty($review_data) &&  $review_data['total_reviews'] > 0 && $review_data['total_ratings'] > 0)
                            <div class="rating-container">
                            {!!$review_data['rating_stars']!!} . {{$review_data['total_ratings']}}/5
                            </div>

                        <div >  <a target="_blank" style="color: #ee2c7b;" href="https://www.google.com/maps?q={{ str_replace(' ' , '+' , $car->vendor->vendor_info->name) }}">  {{number_format($review_data['total_reviews'] ) }} google reviews  </a></div>
                        @endif

                  </div>
                </div>
              @else
                <div class="user mb-20">
                  <div class="user-img">
                    <div class="lazy-container ratio ratio-1-1 rounded-pill">
                      <img class="lazyload" data-src="{{ asset('assets/img/admins/' . $admin->image) }}" alt="">
                    </div>
                  </div>
                  <div class="user-info">
                    <h6 class="mb-1"><a
                        href="{{ route('frontend.vendor.details', ['username' => $admin->username, 'admin' => 'true']) }}">{{ $admin->username }}</a>
                    </h6>
                    <a href="tel:123456789">{{ $admin->phone }}</a>
                    <br>
                    <!-- <a href="mailto:{{ $admin->email }}">{{ $admin->email }}</a> -->
                  </div>
                </div>
              @endif
              <input type="hidden" name="userphone" value="{{ $car->vendor->country_code.$car->vendor->phone }}">

                @if(Auth::guard('vendor')->check() && $car->vendor->id == Auth::guard('vendor')->user()->id )

                 @if( !empty($car->package_id) && in_array($car->status , [0,1]) && $car->is_sold != 1 )

                    @if($car->status==0)
                        <a href = "{{ route('vendor.package.payment_method',  $car->id) }}" class="btn btn-md btn-outline w-100 showLoader mb-3 sticky-button us_button_st" >
                        <i class="fal fa-money"></i> Pay Now
                        </a>
                    @endif

                    @if($car->status==1)
                        <a href = "{{ route('vendor.package.payment_boost',  [$car->car_content->main_category_id,$car->id]) }}" class="btn btn-md btn-outline w-100 showLoader mb-3 sticky-button us_button_st" >
                        <i class="fal fa-paper-plane"></i> Boost
                        </a>
                    @endif

                @endif

                <a href="{{ route('vendor.cars_management.edit_car', $car->id)  }}" class="btn btn-md btn-primary w-100 showLoader sticky-button" >
                    <i class="fa fa-pencil" aria-hidden="true"></i>  Edit
                </a>

                @else
                @if($car->website_url == 1)
                  <a href="{{ $car->website_url }}" id="userwebsitebutton" class="btn btn-md btn-outline w-100 showLoader mb-3 us_button_st @if($car->phone_text == 1 && $car->message_center == 0) us_sing_doub @else sticky-button @endif" target="_blank">
                      <span class="original_text">Visit Website</span> <span class="mobile_icon" style="display:none;"><i class="fa fa-globe"></i></span>
                  </a>
                @endif

                @if($car->phone_text == 1)
                    <a href="tel:{{$car->vendor->country_code.$car->vendor->phone}}" id="userphonebutton"  onclick="savePhoneView({{@$car->id}} , this)"
                    class="btn btn-md btn-outline w-100 showLoader mb-3  us_button_st  @if($car->phone_text == 1 && $car->message_center == 0) us_sing_doub @else sticky-button @endif " data-phone_number="{{$car->vendor->country_code.$car->vendor->phone}}">
                        <span class="original_text">Call Now</span>  <span class="mobile_icon" style="display:none;"> <i class="fa fa-phone fa-rotate-90"></i></span>
                    </a>

                @if($car->vendor->also_whatsapp == 1)
                <a href="https://api.whatsapp.com/send?phone={{ $car->vendor->country_code.$car->vendor->phone }}&text=I'm%20interested%20in%20this%20item%3A%20{{ urlencode(route('frontend.car.details', ['cattitle' => catslug($car->car_content->category_id), 'slug' => $car->car_content->slug, 'id' => $car->id])) }}"
                class="btn btn-md btn-outline w-100 showLoader mb-3  us_wat_btn @if($car->phone_text == 1 && $car->message_center == 0) us_sing_doub @else sticky-button @endif" target="_blank">
                <span class="original_text"> WhatsApp Now </span>   <span class="mobile_icon" style="display:none;"><i class='fab fa-whatsapp'></i></span>
                </a>
                @endif


                @endif

                @if($car->vendor->show_contact_form == 1 && $car->message_center == 1 )

                    @if (Auth::guard('vendor')->check())
                        <button type="button" class="btn btn-md btn-primary w-100  us_open_modal  @if($car->phone_text == 0 && $car->message_center == 1) us_sing_doub @else sticky-button @endif " data-toggle="modal" data-target="#exampleModal">
                            <span class="original_text">
                                @if($car->vendor->vendor_type == 'normal')
                                {{ __('Send message') }}
                                @else
                                {{ __('Make  Enquiry') }}
                                @endif
                                </span>

                                 <span class="mobile_icon" style="display:none;"> <i class="fa fa-envelope" aria-hidden="true"></i> </span>

                        </button>
                    @else
                        <a href="{{ route('vendor.login') }}">
                            <button type="submit" id="showform2ee" class="btn btn-md btn-primary w-100 showLoader @if($car->phone_text == 0 && $car->message_center == 1) us_sing_doub @else sticky-button @endif ">
                                <span class="original_text">
                                    @if($car->vendor->vendor_type == 'normal')
                                        {{ __('Send message') }}
                                    @else
                                        {{ __('Make  Enquiry') }}
                                    @endif
                                </span>

                                 <span class="mobile_icon" style="display:none;"> <i class="fa fa-envelope" aria-hidden="true"></i> </span>
                            </button>
                        </a>
                    @endif
                @endif

                @endif

              <form class="contactForm" style="display: none;" action="{{ route('frontend.car.contact_message') }}" method="POST">
                @csrf
                <div class="row" >
                  <input type="hidden" name="car_id" value="{{ $car->id }}">

                  <div class="col-12">
                    <div class="form-group mb-20">
                      <input type="text" class="form-control" name="name"
                        placeholder="{{ __('Name') . ' *' }}" required>
                      @error('name')
                        <p class="text-danger">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group mb-20">
                      <input type="email" name="email" class="form-control"
                        placeholder="{{ __('Email Address') . ' *' }}" required>
                      @error('email')
                        <p class="text-danger">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group mb-20">
                      <input type="number" name="phone" class="form-control"
                        placeholder="{{ __('Phone Number') . ' *' }}">
                      @error('phone')
                        <p class="text-danger">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group mb-20">
                      <textarea name="message" id="message" class="form-control" cols="30" rows="8"
                        data-error="Please enter your message" placeholder="{{ __('Message') . '...' }}"></textarea>
                      @error('message')
                        <p class="text-danger">{{ $message }}</p>
                      @enderror
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                @if ($info->google_recaptcha_status == 1)
                  <div class="col-12">
                    <div class="form-group captcha mb-20">
                      {!! NoCaptcha::renderJs() !!}
                      {!! NoCaptcha::display() !!}
                      @error('g-recaptcha-response')
                        <div class="help-block with-errors text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                @endif
                <button  type="submit"
                  class="btn btn-md btn-primary w-100 showLoader">  @if($car->vendor->vendor_type == 'normal')
                    {{ __('Send message') }}
                    @else
                     {{ __('Make  Enquiry') }}
                    @endif</button>
              </form>
            </div>
            <!-- Widget share -->
            <div class="widget widget-share card us_share_laptop_view">
    <h5 class="title">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#share"
            aria-expanded="true" aria-controls="share">
            {{ __('Share Now') }}
        </button>
    </h5>
    <div id="share" class="collapse show">
        <div class="accordion-body">
            <div class="social-link style-2 mb-20 d-flex justify-content-start ">
                <a data-tooltip="tooltip" data-bs-placement="top"
                    title="Facebook" href="https://www.facebook.com/sharer/sharer.php?quote=Check Out this ad on List It&utm_source=facebook&utm_medium=social&u={{ urlencode(url()->current()) }}"
                    target="_blank"><i class="fab fa-facebook-f"></i></a>

                <a data-tooltip="tooltip" data-bs-placement="top"
                    title="Twitter" href="//twitter.com/intent/tweet?text=Check Out this ad on List It&amp;url={{ urlencode(url()->current()) }}"
                    target="_blank"><i class="fab fa-twitter"></i></a>

                <a data-tooltip="tooltip" data-bs-placement="top"
                    title="Whatsapp" href="//wa.me/?text=Check Out this ad on List it {{ urlencode(url()->current()) }}&amp;title= "
                    target="_blank"><i class="fab fa-whatsapp"></i></a>

                <a data-tooltip="tooltip" data-bs-placement="top"
                    title="LinkedIn" href="//www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}&amp;title=Check Out this ad on List it"
                    target="_blank"><i class="fab fa-linkedin-in"></i></a>

                <a data-tooltip="tooltip" data-bs-placement="top"
                    title="Email" href="mailto:?subject=Check Out this ad on List it&amp;body=Check Out this ad on List it {{ urlencode(url()->current()) }}&amp;title="
                    target="_blank"><i class="fas fa-envelope"></i></a>

                <a data-tooltip="tooltip" data-bs-placement="top"
                    title="Copy Link" id="copy_url" onclick="copy('{{ (url()->current()) }}','#copy_url')" id="copy_button_1" href="javascript:void(0)">
                    <i class="fas fa-link"></i></a>
            </div>
        </div>
    </div>
</div>

            <!-- widget product -->
            <div class="widget widget-product card">
              <h5 class="title pb-0">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#products">
                  {{ __('Latest Cars') }}
                </button>
              </h5>
              <div id="products" class="collapse show mt-3">
                <div class="accordion-body">
                  @foreach ($latest_cars as $car)


                    @php

                        $image_path = $car->feature_image;

                        $rotation = 0;

                        if($car->rotation_point > 0 )
                        {
                            $rotation =    $car->rotation_point;
                        }

                        if(!empty($image_path) && $car->rotation_point == 0 )
                        {
                            $rotation = $car->galleries->where('image' , $image_path)->first();

                            if($rotation == true)
                            {
                                $rotation = $rotation->rotation_point;
                            }
                            else
                            {
                                $rotation = 0;
                            }
                        }

                        if(empty($car->feature_image))
                        {
                            $imng = $car->galleries->sortBy('priority')->first();

                            $image_path = $imng->image;
                            $rotation = $imng->rotation_point;
                        }

                    @endphp


                    <div class="product-default product-inline" data-id="{{$car->id}}">
                      <figure class="product-img">

                        <a href="{{ route('frontend.car.details', ['cattitle' => catslug($car->car_content->category_id),'slug' => $car->car_content->slug, 'id' => $car->id]) }}"
                          class="lazy-container ratio ratio-1-1">
                          <img src="{{ asset('assets/admin/img/car-gallery/' . $car->feature_image) }}" alt="{{ @$car->title }}" class="lazyload" style="width: 100%; height: auto; transform: rotate({{ $rotation }}deg);" onerror="this.onerror=null;this.src='{{ asset('assets/img/Image_not_available.png') }}';">
                        </a>
                      </figure>


                     <div class="product-details" style="cursor:pointer;" onclick="window.location.href='{{ route('frontend.car.details', ['cattitle' => catslug($car->category_id), 'slug' => $car->slug, 'id' => $car->id]) }}'">

                        <h6 class="product-title mb-1 ellipsis_n">
                          {{ @$car->title }}
                        </h6>
                        <div class="author mb-2">
                          <span style="line-height: 15px;font-size: 12px;">

                             @if($car->year)
                             {{ $car->year }} <b class="us_dot"> - </b>
                             @endif

                               @if($car->engineCapacity && $car->car_content->fuel_type )
                             {{ roundEngineDisplacement($car) }} {{ $car->car_content->fuel_type->name }} <b class="us_dot"> - </b>
                             @endif

                             @if($car->mileage)
                             {{ number_format( $car->mileage ) }} mi <b class="us_dot"> - </b>
                             @endif

                              @if($car->created_at)
                             {{calculate_datetime($car->created_at)}}
                             @endif

                              @if($car->city)
                             <b class="us_dot"> - </b> {{  Ucfirst($car->city) }}
                             @endif

                        </span>
                        </div>


                        <ul class="product-icon-list  list-unstyled d-flex align-items-center" style="margin-bottom:0.5rem;">

                            @if ($car->price != null)
                            <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                            title="Price">
                            <b style="color: gray;font-size: 12px;">Price</b>
                            <br>
                            <strong  class="us_mrg" style="color: black;font-size: 12px;margin-left: 0;">
                            @if($car->previous_price && $car->previous_price < $car->price)
                            <strike style="font-weight: 300;color: gray;font-size: 12px;float: left;">{{ symbolPrice($car->price) }}</strike> <br> <div style="color:black;"> {{ symbolPrice($car->previous_price) }}</div>
                            @else
                            £{{ number_format($car->price, 0, '.', ',') }}
                            @endif
                            </strong>
                            </li>
                            @endif

                            @if ($car->price != null && $car->price >= 1000)
                            <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                            title="">
                            <b style="color: gray;font-size: 12px;">From</b>
                            <br>
                            <strong style="color: black;font-size: 12px;">{!! calulcateloanamount(!empty($car->previous_price && $car->previous_price < $car->price ) ? $car->previous_price : $car->price)[0] !!}</strong>
                            </li>
                            @endif

                        </ul>


                      </div>
                    </div><!-- product-default -->
                  @endforeach

                </div>
              </div>
            </div>
            <!-- Widget banner -->
            <div class="widget-banner">
              @if (!empty(showAd(1)))
                <div class="text-center mb-4">
                  {!! showAd(1) !!}
                </div>
              @endif
              @if (!empty(showAd(2)))
                <div class="text-center">
                  {!! showAd(2) !!}
                </div>
              @endif
            </div>
            <!-- Spacer -->
            <div class="pb-40"></div>
          </aside>
        </div>
      </div>
    </div>
    </div>
    </div>



    <div class="modal fade" id="financeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header" style="padding-bottom: 0;border: none;">
    <h5 class="modal-title" id="exampleModalLabel" style="color:white;">.</h5>
    <button type="button" class="close" style="z-index: 10;" onclick="closeModal()">
      <span aria-hidden="true">&times;</span>
    </button>
    </div>
      <div class="modal-body" style="padding-top: 0;margin-top: -2rem;">
           <center> <b style="color: #04de04;font-size: 2rem;">£</b><br>
            <b style="font-size: 2rem;" id="eventTag">Monthly Price</b><br>
            <p style="margin-top: 10px;" id="textHTML">
            </p></center>


                 @if(!empty($financing_dealer) && !empty($financing_url) )
                           <a href="{{$financing_url}}" class="btn btn-info" style="width: 100%;color: white;">   {{$financing_dealer}}
                          @else
                             <a href="{{getSetVal('finance_url')}}" class="btn btn-info" style="width: 100%;color: white;"> Get Finance Approval
                          @endif
                </a>
      </div>
    </div>
    </div>
    </div>


    <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" style="border: none;">
            <h5 class="modal-title" id="exampleModalLabel" style="display:flex;">

                <i class="fa fa-flag" aria-hidden="true" style="font-size: 25px;color: red;"></i>

                <div style="margin-left:10px">
                     <span style="font-size: 12px;color: gray;">Report Ad </span>
                     <!--<br>-->
                     <!--<small>Help us to understand the reason.</small>-->
                </div>
            </h5>
            <button type="button" class="close" onclick="closeReportModal()">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>

              <form method="GET" onsubmit="return reportAd()">

              <div class="modal-body">

                <div class="alert alert-success" role="alert" style="display:none;" id="successMessage">
                    Your message was sent.
                </div>


                        <select name="report_reason" class="form-control" style="    margin-bottom: 1rem;" required id="reasonOption">
                            <option value=""></option>
                            <option value="Animal Welfare Concern">Animal Welfare Concern</option>
                            <option value="Breach of T&C's">Breach of T&C's</option>
                            <option value="Suspected Fraud">Suspected Fraud</option>
                            <option value="Suspected Stolen Goods">Suspected Stolen Goods</option>
                            <option value="Suspected Counterfeit Goods">Suspected Counterfeit Goods</option>
                            <option value="Can't contact seller">Can't contact seller</option>
                            <option value="others">others</option>
                        </select>


                <label>
                        Comment
                </label>

                <input type="hidden" id="ad_id" value="{{$car_ids}}" />

                <textarea class="form-control mt-2" placeholder="Please Describe To Us" required   id="explaination" ></textarea>

                <button class="btn btn-primary" type="submit" style="width: 100%;margin-top: 20px;" id="submtBtn">Report Ad</button>

                </div>
          </form>
        </div>
      </div>
    </div>


  <!-- Listing-single-area start -->

@endsection
@section('script')
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<!-- Popper JS -->
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <script>
    var visitor_store_url = "{{ route('frontend.store_visitor') }}";
    var car_id = "{{ $car_id }}";

    function closeModal()
    {
        $('#financeModal').modal('hide')
    }

    function openDropdown(self)
    {
        $(self).closest('.card-body').find('.us_open_row').toggle('slow')
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
      $('#textHTML').html(text)
      $('#financeModal').modal('show')
  }


     function copy(text, target) {
      setTimeout(function() {
      //$('#copied_tip').remove();
      }, 800);

        var input = document.createElement('input');
        input.setAttribute('value', text);
        document.body.appendChild(input);
        input.select();
        var result = document.execCommand('copy');
        document.body.removeChild(input)

      toastr["success"]("Ad Url copied successfully.")
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut ": 10000,
                "extendedTimeOut": 10000,
                "positionClass": "toast-top-right",
            }
            return result;

    }



  </script>
  <script src="{{ asset('assets/js/store-visitor.js') }}"></script>


  <script>
  setTimeout(()=>{
      function formatCurrency(number) {
    return '£' + new Intl.NumberFormat('en-GB', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(number);
    }
    $(".priceFormat").each(function(){
      var priceElement = $(this);
      var price = parseFloat(priceElement.data('price'))
       priceElement.text(formatCurrency(price))
    })
    },2000);


    document.addEventListener("DOMContentLoaded", function()
    {

        const carDescription = document.getElementById('car-description');
        const readMoreBtn = document.getElementById('read-more');
        const readLessBtn = document.getElementById('read-less');
        const overflowFade = document.getElementById('over-flow-fade');
        readLessBtn.style.display = 'none';
        carDescription.classList.add('partial-description-min-height');
        overflowFade.classList.add('over-flow-fade')
        readMoreBtn.addEventListener('click', function()
        {
          carDescription.classList.add('partial-description');
          carDescription.classList.remove('partial-description-min-height');
          overflowFade.classList.remove('over-flow-fade')
            readMoreBtn.style.display = 'none';
            readLessBtn.style.display = 'block';
        });
        readLessBtn.addEventListener('click', function()
        {
          carDescription.classList.remove('partial-description');
            carDescription.classList.add('partial-description-min-height');
            overflowFade.classList.add('over-flow-fade')
            readMoreBtn.style.display = 'block';
            readLessBtn.style.display = 'none';
        });
    });


    function savePhoneView(car_id , self)
    {
        var phone = $(self).data("phone_number");
        console.log(phone)
      $.ajax({
                url: '{{ route("phone.reavel.count") }}',
                method: 'GET',
                data: {car_id : car_id },
                success: function (response)
                {
                   $(self).html(phone)
                },
                error: function (xhr, status, error)
                {
                    console.error(xhr.responseText);
                }
            });
    }



    </script>
@endsection
