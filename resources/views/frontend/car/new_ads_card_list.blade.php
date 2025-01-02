
      @if($car_contents->count() == 0)
        <div class="col-12 w-100" data-aos="fade-up"> <center> <h4>Sorry, No Posts Matched Your Criteria</h4> </center> </div>
      @else

            @php
            $admin = App\Models\Admin::first();
            @endphp

            @foreach ($car_contents as $key => $car_content)

              @php

              $other_images = isset($car_content->images) && $car_content->images ? explode(',', $car_content->images) : [];
              // Limit the number of images to display to 3
              $limited_images = array_slice($other_images, 0, 3);

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

              <div class="w-100 border bg-white  rounded position-relative  mb-4 p-0" >
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



                  @if ($car_content->vendor_id != 0 && $car_content->vendor->vendor_type == 'dealer' && $car_content->is_featured == 1)

                    <div class="w-100 p-3" style="animation: glow 1.5s infinite alternate;">
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
                      <div class="d-flex align-items-center gap-2">
                        <div >
                        <a  class="color-medium"
                            href="{{ route('frontend.vendor.details', ['id' => $car_content->vendor->id ,'username' => ($vendor = @$car_content->vendor->username)]) }}"
                            target="_self" title="{{ $vendor = @$car_content->vendor->username }}">
                            @if ($car_content->vendor->photo != null)

                              @php
                              $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $car_content->vendor->photo;

                              if (file_exists(public_path('assets/admin/img/vendor-photo/' . $car_content->vendor->photo)))
                              {
                                $photoUrl = asset('assets/admin/img/vendor-photo/' . $car_content->vendor->photo);
                              }
                              @endphp

                              <img
                              style="border-radius: 10%; max-width: 60px;"
                              class="lazyload blur-up"

                              data-src="{{ $photoUrl }}"
                              src="{{ $photoUrl }}"
                              alt="Vendor"
                              onload="handleImageLoad(this)"
                              onerror="{{ asset('assets/img/blank-user.jpg') }}" >

                            @else
                              <img style="border-radius: 10%;max-width: 60px;" class="lazyload blur-up" data-src="{{ asset('assets/img/blank-user.jpg') }}"
                              alt="Image">
                            @endif

                        </a>
                        </div>
                        <div>
                            <p style="color: #222831;font-size: 14px;margin:0px!important;">{{ $car_content->vendor->vendor_info->name }}</p>
                            <p style="color: #586176; font-size: 12px;margin:0px!important;">
                              <svg width="15" height="15" fill="#1c9b40" viewBox="0 0 24 24" data-testid="shield-icon" class="BrandingStripstyled__TrustedDealerBadge-sc-n7l181-6 fEIxXh">
                                  <path fill="#1c9b40" d="M22.456 5.22a.75.75 0 00-.616-.69c-4.055-.728-5.747-1.254-9.531-2.963a.75.75 0 00-.618 0c-3.784 1.709-5.476 2.235-9.53 2.962a.75.75 0 00-.617.691c-.18 2.865.204 5.534 1.145 7.933a16.38 16.38 0 003.358 5.274c2.506 2.66 5.167 3.814 5.675 4.019a.75.75 0 00.563 0c.507-.205 3.168-1.36 5.675-4.019a16.379 16.379 0 003.351-5.274c.941-2.4 1.326-5.068 1.145-7.933zm-6.14 3.52l-5.194 6a.748.748 0 01-.535.26h-.03a.75.75 0 01-.526-.214l-2.306-2.26a.75.75 0 111.05-1.071l1.734 1.7 4.674-5.396a.75.75 0 111.134.982h-.001z"></path>
                              </svg>
                              @if($car_content->vendor->is_trusted == 1)
                                <span>Trusted</span>
                              @endif

                              @if($car_content->vendor->is_franchise_dealer == 1)
                                Franchise Dealership
                              @else
                                Independent Dealership
                              @endif

                              @php
                                $review_data = null;
                              @endphp

                              @if($car_content->vendor->google_review_id > 0 )
                                @php
                                  $review_data = get_vendor_review_from_google($car_content->vendor->google_review_id , true);
                                @endphp
                              @endif

                              @if(!empty($review_data) && $review_data['total_reviews'] > 0 && $review_data['total_ratings'] > 0)
                                <span>
                                    <span class="star on"></span>  {{$review_data['total_ratings']}}/5
                                </span>
                              @endif

                            </p>

                        </div>
                      </div>
                    </div>
                  @elseif($car_content->vendor->vendor_type == 'normal' )
                  <div class="w-100 p-3" style="display: none;">
                    <div class="d-flex align-items-center gap-2">
                      <div >
                      <a  class="color-medium"
                          href="{{ route('frontend.vendor.details', ['id' => $car_content->vendor->id ,'username' => ($vendor = @$car_content->vendor->username)]) }}"
                          target="_self" title="{{ $vendor = @$car_content->vendor->username }}">
                          @if ($car_content->vendor->photo != null)

                            @php
                            $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $car_content->vendor->photo;

                            if (file_exists(public_path('assets/admin/img/vendor-photo/' . $car_content->vendor->photo)))
                            {
                              $photoUrl = asset('assets/admin/img/vendor-photo/' . $car_content->vendor->photo);
                            }
                            @endphp

                            <img
                            style="border-radius: 10%; max-width: 60px;"
                            class="lazyload blur-up"

                            data-src="{{ $photoUrl }}"
                            src="{{ $photoUrl }}"
                            alt="Vendor"
                            onload="handleImageLoad(this)"
                            onerror="{{ asset('assets/img/blank-user.jpg') }}" >

                          @else
                            <img style="border-radius: 10%;max-width: 60px;" class="lazyload blur-up" data-src="{{ asset('assets/img/blank-user.jpg') }}"
                            alt="Image">
                          @endif

                      </a>
                      </div>
                      <div>
                          <p style="color: #222831;font-size: 14px;margin:0px!important;">{{ $car_content->vendor->vendor_info->name }}</p>
                          <p style="color: #586176; font-size: 12px;margin:0px!important;">
                            <svg width="15" height="15" fill="#1c9b40" viewBox="0 0 24 24" data-testid="shield-icon" class="BrandingStripstyled__TrustedDealerBadge-sc-n7l181-6 fEIxXh">
                                <path fill="#1c9b40" d="M22.456 5.22a.75.75 0 00-.616-.69c-4.055-.728-5.747-1.254-9.531-2.963a.75.75 0 00-.618 0c-3.784 1.709-5.476 2.235-9.53 2.962a.75.75 0 00-.617.691c-.18 2.865.204 5.534 1.145 7.933a16.38 16.38 0 003.358 5.274c2.506 2.66 5.167 3.814 5.675 4.019a.75.75 0 00.563 0c.507-.205 3.168-1.36 5.675-4.019a16.379 16.379 0 003.351-5.274c.941-2.4 1.326-5.068 1.145-7.933zm-6.14 3.52l-5.194 6a.748.748 0 01-.535.26h-.03a.75.75 0 01-.526-.214l-2.306-2.26a.75.75 0 111.05-1.071l1.734 1.7 4.674-5.396a.75.75 0 111.134.982h-.001z"></path>
                            </svg>
                            @if($car_content->vendor->is_trusted == 1)
                              <span>Trusted</span>
                            @endif

                            @if($car_content->vendor->is_franchise_dealer == 1)
                              Franchise Dealership
                            @else
                              Independent Dealership
                            @endif

                            @php
                              $review_data = null;
                            @endphp

                            @if($car_content->vendor->google_review_id > 0 )
                              @php
                                $review_data = get_vendor_review_from_google($car_content->vendor->google_review_id , true);
                              @endphp
                            @endif

                            @if(!empty($review_data) && $review_data['total_reviews'] > 0 && $review_data['total_ratings'] > 0)
                              <span>
                                  <span class="star on"></span>  {{$review_data['total_ratings']}}/5
                              </span>
                            @endif

                          </p>

                      </div>
                    </div>
                  </div>
                  @else
                  <div class="w-100 p-3">
                    <div class="d-flex align-items-center gap-2">
                      <div >
                      <a  class="color-medium"
                          href="{{ route('frontend.vendor.details', ['id' => $car_content->vendor->id ,'username' => ($vendor = @$car_content->vendor->username)]) }}"
                          target="_self" title="{{ $vendor = @$car_content->vendor->username }}">
                          @if ($car_content->vendor->photo != null)

                            @php
                            $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $car_content->vendor->photo;

                            if (file_exists(public_path('assets/admin/img/vendor-photo/' . $car_content->vendor->photo)))
                            {
                              $photoUrl = asset('assets/admin/img/vendor-photo/' . $car_content->vendor->photo);
                            }
                            @endphp

                            <img
                            style="border-radius: 50%; max-width: 60px;object-fit:cover;"
                            class="lazyload blur-up"

                            data-src="{{ $photoUrl }}"
                            src="{{ $photoUrl }}"
                            alt="Vendor"
                            onload="handleImageLoad(this)"
                            onerror="{{ asset('assets/img/blank-user.jpg') }}" >

                          @else
                            <img style="border-radius: 10%;max-width: 60px;" class="lazyload blur-up" data-src="{{ asset('assets/img/blank-user.jpg') }}"
                            alt="Image">
                          @endif

                      </a>
                      </div>
                      <div>
                          <p style="color: #222831;font-size: 14px;margin:0px!important;">{{ $car_content->vendor->vendor_info->name }}</p>
                          <p style="color: #586176; font-size: 12px;margin:0px!important;">
                            <svg width="15" height="15" fill="#1c9b40" viewBox="0 0 24 24" data-testid="shield-icon" class="BrandingStripstyled__TrustedDealerBadge-sc-n7l181-6 fEIxXh">
                                <path fill="#1c9b40" d="M22.456 5.22a.75.75 0 00-.616-.69c-4.055-.728-5.747-1.254-9.531-2.963a.75.75 0 00-.618 0c-3.784 1.709-5.476 2.235-9.53 2.962a.75.75 0 00-.617.691c-.18 2.865.204 5.534 1.145 7.933a16.38 16.38 0 003.358 5.274c2.506 2.66 5.167 3.814 5.675 4.019a.75.75 0 00.563 0c.507-.205 3.168-1.36 5.675-4.019a16.379 16.379 0 003.351-5.274c.941-2.4 1.326-5.068 1.145-7.933zm-6.14 3.52l-5.194 6a.748.748 0 01-.535.26h-.03a.75.75 0 01-.526-.214l-2.306-2.26a.75.75 0 111.05-1.071l1.734 1.7 4.674-5.396a.75.75 0 111.134.982h-.001z"></path>
                            </svg>
                            @if($car_content->vendor->is_trusted == 1)
                              <span>Trusted</span>
                            @endif

                            @if($car_content->vendor->is_franchise_dealer == 1)
                              Franchise Dealership
                            @else
                              Independent Dealership
                            @endif

                            @php
                              $review_data = null;
                            @endphp

                            @if($car_content->vendor->google_review_id > 0 )
                              @php
                                $review_data = get_vendor_review_from_google($car_content->vendor->google_review_id , true);
                              @endphp
                            @endif

                            @if(!empty($review_data) && $review_data['total_reviews'] > 0 && $review_data['total_ratings'] > 0)
                              <span>
                                  <span class="star on"></span>  {{$review_data['total_ratings']}}/5
                              </span>
                            @endif

                          </p>

                      </div>
                    </div>
                  </div>
                  @endif

                  <div class="w-100 h-full">
                    <div class="w-100 d-flex flex-md-row flex-column">
                      <div class="left-container" style="position: relative; cursor: pointer;">
                          <div class="imageSize" >

                            @if($car_content->is_featured == 1)
                            <div class="sale-tag">
                              Spotlight
                          </div>                            @endif
                          <style>
                            .sale-tag {
                                border-radius: 7px;
                                background: linear-gradient(45deg, #ff5900, #ffd700); /* Vibrant orange-to-gold gradient */
                                color: white;
                                font-weight: bold;
                                padding: 5px 10px;
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

                            <!-- @if ($car_content->is_sold == 1 || $car_content->status == 2 )
                                <div class="sold-badge">
                                    <span class="sold-text">Sold</span>
                                    <span class="sold-text">Sold</span>
                                    <span class="sold-text">Sold</span>
                                </div>
                            @endif -->

                          <a class="" href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}">

                            <img class="ls-is-cached  lazyloaded card-design"
                              style="transform: rotate(0deg); width: 100%; height: 240px; object-fit: cover;"
                              data-src=" {{  $car_content->vendor->vendor_type == 'dealer' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path }}  "
                              alt="Product" onerror="this.onerror=null;this.src='{{ asset('assets/img/noimage.jpg') }}';"
                              src=" {{  $car_content->vendor->vendor_type == 'normal' ?
                              asset('assets/admin/img/car-gallery/' .$image_path) :
                              env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path }}  ">
                          </a>
                            @if($car_content->deposit_taken == 1)
                            <div class="reduce-tag">DEPOSIT TAKEN</div>
                            @endif
                           </div>
                            @if ($car_content->vendor->vendor_type == 'dealer' && !empty($limited_images) && count($limited_images) == 3)
                            <div class="d-flex gap-1 mt-1 w-100">
                              @foreach ($limited_images as $image)
                                <div class="imageSize flex-fill">
                                  <img class="ls-is-cached lazyloaded card-design-smalls"
                                    style="transform: rotate(0deg); height: 88px; width: 100%; object-fit: cover;"
                                    data-src=" {{  $car_content->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image }}  "
                                    alt="Product" onerror="this.onerror=null;this.src='http://localhost:8000/assets/img/noimage.jpg';"
                                    src=" {{  $car_content->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image }}  "
                                  >
                                  </div>
                              @endforeach
                              </div>
                            @endif
                            @if ($car_content->is_sold == 1 )
                            <div style="position: absolute; top:0px; width: 100%; z-index: -1px; height: 100%; background: rgba(0,0,0,0.3)"></div>
                            <img src="assets/img/Sold.png"  alt="sold out" style="position: absolute;  left:12px; right:0px; width: 45%; z-index: 1px; top:14%;" class="mx-auto" ></img>
                            @endif
                          </div>
                      <div class="p-20 w-100 d-flex flex-column justify-content-between align-items-center">
                        <div class="w-100">
                          <h6 class="card-deal-turncate">
                          <a href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}">
                            {{ carBrand($car_content->brand_id) }} {{ carModel($car_content->car_model_id) }} {{ $car_content->title }}
                          </a>
                          </h6>
                          <div class="d-flex gap-1  flex-wrap justify-content-start align-items-center">

                              @if($car_content->created_at && $car_content->is_featured != 1)
                                <p style="white-space: nowrap; ">
                                  <div style="border-radius: 100%; margin-right: -10px !important;"></div>
                                  {{calculate_datetime($car_content->created_at)}}
                                </p>
                              @endif

                              @if($car_content->year)
                                <p style="white-space: nowrap;">
                                  <div style=" width: 5px; height:5px; background: #7A7575; border-radius: 100%;"></div>
                                  {{ $car_content->year }}
                                </p>
                              @endif

                              @if($car_content->engineCapacity && $car_content->car_content->fuel_type )
                                <p style="white-space: nowrap;  ">
                                  <div style=" width: 5px; height:5px; background: #7A7575; border-radius: 100%;"></div>
                                  {{ roundEngineDisplacement($car_content) }}
                                </p>
                              @endif

                              @if($car_content->car_content->fuel_type )
                                <p style="white-space: nowrap;  ">
                                  <div style=" width: 5px; height:5px; background: #7A7575; border-radius: 100%;"></div>
                                  {{ $car_content->car_content->fuel_type->name }}
                                </p>
                              @endif

                              @if($car_content->mileage)
                                <p style="white-space: nowrap;  ">
                                  <div style=" width: 5px; height:5px; background: #7A7575; border-radius: 100%;"></div>
                                  {{ number_format( $car_content->mileage ) }} mi
                                </p>
                              @endif

                              @if($car_content->city)
                                <p style="white-space: nowrap;  ">
                                  <div style=" width: 5px; height:5px; background: #7A7575; border-radius: 100%;"></div>
                                  {{  Ucfirst($car_content->city) }}
                                </p>
                              @endif

                          </div>

                          @if(!empty($car_content->warranty_duration))
                          <div class="mt-20"
                              style="display: inline-block; padding: 3px 5px;border-radius: 5px; background: #ebebeb; font-size: 12px;color: #525252;
                              border: 1px solid #d6d6d6;
                              /* box-shadow: 0px 0px 5px gray; */">
                              <svg width="24" height="24" fill="#F3F4F7" viewBox="0 0 24 24" color="GREEN">
                                <path fill="currentColor" fill-rule="evenodd" d="M17.469 5.747a.71.71 0 01.068 1l-6.074 6.969a.71.71 0 11-1.07-.932l6.075-6.969a.71.71 0 011-.068zm4.289 0a.71.71 0 01.067 1.001L11.819 18.183a.709.709 0 01-1.025.045l-5.956-5.716a.71.71 0 11.982-1.024l5.42 5.203 9.517-10.877a.71.71 0 011-.066zm-19.55 7.18a.71.71 0 011.003 0l4.288 4.288a.71.71 0 01-1.003 1.003L2.208 13.93a.71.71 0 010-1.003z" clip-rule="evenodd"></path>
                              </svg>
                              {{$car_content->warranty_duration}} Warranty
                          </div>
                          @endif

                          @if ($car_content->manager_special  == 1)
                          <div class="mt-20"
                              style="display: inline-block; padding: 3px 5px;border-radius: 5px; background: #ebebeb; font-size: 12px;color: #525252;
                              border: 1px solid #d6d6d6;
                              /* box-shadow: 0px 0px 5px gray; */">
                              <!-- <svg width="24" height="24" fill="none" viewBox="0 0 24 24" color="GREEN"> -->
                                <!-- <path fill="currentColor" fill-rule="evenodd" d="M17.469 5.747a.71.71 0 01.068 1l-6.074 6.969a.71.71 0 11-1.07-.932l6.075-6.969a.71.71 0 011-.068zm4.289 0a.71.71 0 01.067 1.001L11.819 18.183a.709.709 0 01-1.025.045l-5.956-5.716a.71.71 0 11.982-1.024l5.42 5.203 9.517-10.877a.71.71 0 011-.066zm-19.55 7.18a.71.71 0 011.003 0l4.288 4.288a.71.71 0 01-1.003 1.003L2.208 13.93a.71.71 0 010-1.003z" clip-rule="evenodd"></path> -->
                              <!-- </svg> -->
                              Manage Special
                          </div>
                          @endif

                          <!-- @if($car_content->is_sale == 1)
                          <div class="mt-20"
                              style="display: inline-block; padding: 3px 5px;border-radius: 5px; background: #ebebeb; font-size: 12px;color: #525252;
                              border: 1px solid #d6d6d6;
                              /* box-shadow: 0px 0px 5px gray; */">
                              Sale
                          </div>
                          @endif -->

                          @if($car_content->reduce_price == 1)
                          <div class="mt-20"
                              style="display: inline-block; padding: 3px 5px;border-radius: 5px; background: #ebebeb; font-size: 12px;color: #525252;
                              border: 1px solid #d6d6d6;
                              /* box-shadow: 0px 0px 5px gray; */">
                              Reduced
                          </div>
                          @endif

                        </div>

                        <div class="w-100 mt-20 mt-sm-0 d-flex justify-content-between align-items-center">
                          <div class="w-100 d-flex gap-1">
                              @if ($car_content->price != null)
                              <div class="price-font" style="font-size: 32px;line-height: 40px; color: rgb(34, 40, 49);font-weight: 700;">
                                @if($car_content->previous_price && $car_content->previous_price < $car_content->price )
                                  <strike style="font-weight: 300;color: red;font-size: 14px;    float: left;">{{ symbolPrice($car_content->price) }}</strike>
                                  <div style="color:black;"> {{ symbolPrice($car_content->previous_price) }}</div>
                                @else
                                £{{ number_format($car_content->price, 0, '.', ',') }}
                                @endif

                              </div>
                              @endif

                              <div class="pmon-font"
                              style="font-size: 16px; line-height: 40px; color: rgb(34, 40, 49);font-weight: 400;padding-top:5px;">
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
                          <div class="d-sm-block d-none">
                            <a  href="javascript:void(0);"
                                onclick="addToWishlist({{$car_content->id}})"
                                class="shadow" data-tooltip="tooltip"
                                data-bs-placement="right"
                                title="{{ $checkWishList == false ? __('Save Ads') : __('Saved') }}"
                                style="border-radius:50%;height: 35px; width:35px; cursor: pointer;
                                      display: flex !important; justify-content: center !important;
                                      align-items: center !important;">
                                @if($checkWishList == false)
                                  <i class="fal fa-heart" style="color:#35373b !important;font-size:22px;"></i>
                                @else
                                  <i class="fal fa-heart"  aria-hidden="true" style="color:#35373b !important;font-size:22px;"></i>
                                @endif
                            </a>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                  @if($car_content->is_sale == 1 && $car_content->is_sold != 1)
                  <img src="assets/img/saletag.svg" width="120px" style="position: absolute; width: 60px; top:-13px; right:10px;" alt="sale"></img>
                       @endif
                </div>
             @endforeach

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
<!-- end of pagination --->
      @endif
