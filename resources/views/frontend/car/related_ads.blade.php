<div class="row">
            @php
              $car_contents = $related_cars;
              $admin = App\Models\Admin::first();

            @endphp
            @foreach ($car_contents as $car_content)

             @php

            $image_path = $car_content->feature_image;

            $rotation = 0;

            if($car_content->rotation_point > 0 )
            {
                 $rotation = $car_content->rotation_point;
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

            <div class="col-xl-6 col-md-6" data-aos="fade-up">

            @if($car_content->is_sale == 1)
            <div class="sale-tag" style="    border-top-left-radius: 10px;">Sale</div>
            @endif


            @if($car_content->is_featured == 1)
            <div class="product-default border p-15 mb-25 us_custom_height" data-id="{{$car_content->id}}" style="box-shadow: 0px 0px 10px #b3b3b3;border-radius: 10px;border: 5px solid #ff9e02 !important;">

            @else
            <div class="product-default border p-15 mb-25 us_custom_height " data-id="{{$car_content->id}}" style="box-shadow: 0px 0px 10px #b3b3b3;border-radius: 10px;">

            @endif

            <figure class="product-img mb-15">
            <a href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}"
            class="lazy-container ratio ratio-2-3">
            <img class="lazyload"
            data-src="{{  (!empty($car_content->vendor->vendor_type) && $car_content->vendor->vendor_type == 'normal')  ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path }}"
            alt="{{ optional($car_content)->title }}" style="transform: rotate({{$rotation}}deg);"  onerror="this.onerror=null;this.src='{{ asset('assets/img/noimage.jpg') }}';" >
            </a>

            @if($car_content->deposit_taken  == 1)
            <div class="reduce-tag">DEPOSIT TAKEN</div>
            @endif


            </figure>

                  <div class="product-details" style="cursor:pointer;"   >


                    <span class="product-category font-xsm">

                           <h5 class="product-title mb-0">
                        <a href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}"
                          title="{{ optional($car_content)->title }}">{{ carBrand($car_content->brand_id) }}
                         {{ carModel($car_content->car_model_id) }} {{ optional($car_content)->title }}</a>
                      </h5>


                        </span>
                    <div class="d-flex align-items-center justify-content-between mb-10">



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
                        class="btn btn-icon {{ $checkWishList == false ? '' : 'wishlist-active' }}"
                        data-tooltip="tooltip" data-bs-placement="right"
                        title="{{ $checkWishList == false ? __('Save Ads') : __('Saved') }}" style="background-color: transparent !important;
                        position: absolute;
                        bottom:15px;
                        z-index: 999;
                        border: none;
                        color: red !important;
                        font-size: 20px;
                        right: 0;">
                        	@if($checkWishList == false)
                            <i class="fal fa-heart"></i>
                        @else
                            <i class="fa fa-heart" aria-hidden="true"></i>
                        @endif
                      </a>

                     <a href="javascript:void(0);" onclick="openShareModal(this)"
                        data-url="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}"
                        style="background: transparent;
                        position: absolute;
                        right: 50px;
                        bottom:11px;
                        z-index: 999;
                        border: none;
                        color: #1b87f4;
                        font-size: 25px;" ><i class="fa fa-share-alt" aria-hidden="true"></i>
                        </a>


                    </div>
                    <div class="author mb-10 us_child_dv" style="cursor:pointer;" onclick="window.location='{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id), 'slug' => $car_content->slug, 'id' => $car_content->id]) }}'" >

                         <span style="line-height: 20px;">

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

                    <div style="display:flex;margin-top: 0.5rem;margin-bottom: 0.5rem;">

                        @if ($car_content->manager_special  == 1)
                        <div class="price-tag" style="padding: 3px 10px;border-radius:5px; background:#25d366;font-size: 8px;" > Manage Special</div>
                        @endif


                        @if($car_content->is_featured == 1)

                        <div class="price-tag" style="padding: 3px 10px;border-radius:5px;margin-left: 10px;" >  Spotlight </span></div>

                        @endif
                        <style>
                          .price-tag {
                              border-radius: 7px;
                              background: linear-gradient(45deg, #ff5900, #ffd700); /* Vibrant orange-to-gold gradient */
                              color: white;
                              font-weight: bold;
                              /* padding: 5px 10px; */
                              /* text-transform: uppercase; */
                              font-size: 8px;
                              position: relative;
                              box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2), 0 0 20px rgba(255, 154, 2, 0.5);
                              overflow: hidden;
                              display: inline-block;
                              cursor: pointer;
                          }

                          .price-tag::before {
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
                          .price-tag:hover {
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


                        @if($car_content->reduce_price == 1)

                        <div class="price-tag" style="padding: 3px 10px;border-radius:5px;margin-left: 10px;background:#ff4444;font-size: 8px;" >    Reduced </span></div>

                        @endif

                    </div>


                    <ul class="product-icon-list  list-unstyled d-flex align-items-center" style="position: absolute;bottom: 10px;">

                    @if ($car_content->price != null)
                        <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                        title="Price">
                        <b style="color: gray;">Price</b>
                        <br>
                        <strong  class=" us_font_price" style="color: black;margin-left: 0;">
                        @if($car_content->previous_price && $car_content->previous_price < $car_content->price)
                        <strike style="font-weight: 300;color: red;font-size: 14px;    float: left;">{{ symbolPrice($car_content->price) }}</strike> <div> {{ symbolPrice($car_content->previous_price) }}</div>
                        @else
                        £{{ number_format($car_content->price, 0, '.', ',') }}
                        @endif
                        </strong>
                        </li>
                        @endif

                        @if ($car_content->price != null && $car_content->price >= 1000)
                        <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                        title="">
                        <b style="color: gray;">From</b>
                        <br>
                        <strong style="color: black;" class="us_font_price">

                        {!! calulcateloanamount(!empty($car_content->previous_price && $car_content->previous_price < $car_content->price ) ? $car_content->previous_price : $car_content->price)[0] !!}

                        </strong>
                        </li>
                        @endif

                    </ul>



                  </div>
                </div><!-- product-default -->
              </div>
            @endforeach
          </div>

        <style>
            @media screen and (max-width: 480px) {
            .go-top {
            bottom: 70px !important;
            }
            .whatsapp-button
            {
            bottom: 70px !important;
            }
            }
        </style>
