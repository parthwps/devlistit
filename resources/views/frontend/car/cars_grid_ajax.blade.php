@if($car_contents->count() == 0)
                <div class="col-12"> <center> <h4>Sorry, No Posts Matched Your Criteria</h4> </center> </div>
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

             @if ( $key == 6 || $key == 12 )

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

            <div class="col-xl-4 col-md-6">

            @if($car_content->is_featured == 1)
            <div class="product-default set_height position-relative  bg-white border mb-25" data-id="{{$car_content->id}}"
            style="border-radius: 10px;">

            @else
            <div class="product-default set_height position-relative bg-white border mb-25 " data-id="{{$car_content->id}}"
            style="border-radius: 10px;">

            @endif

            <figure class="product-img mb-15 position-relative">
            <a href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}"
            class="lazy-container ratio ratio-2-3">
            <img class="lazyload"
            data-src="{{  $car_content->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path }}"
            alt="{{ optional($car_content)->title }}" style="transform: rotate({{$rotation}}deg);" >
            </a>

            @if($car_content->deposit_taken  == 1)
            <div class="reduce-tag">DEPOSIT TAKEN</div>
            @endif
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

                 @if ($car_content->is_sold == 1)
    <div href="javascript:void(0);"
         onclick="addToWishlist({{$car_content->id}})"
         class="us_wishlist"
         data-tooltip="tooltip" data-bs-placement="right"
         title="{{ $checkWishList == false ? __('Save Ad') : __('Saved') }}"
         style="position: absolute;
                right: 10px;
                bottom: 3px;
                cursor: pointer;
                background:white;
                color:red !important;
                z-index: 0; /* Adjusted z-index */
                border: none;
                border-radius: 50%;
                padding: 6px;
                width: 40px;
                height:40px;
                display: flex;
                justify-content: center;
                align-items: center;">
        @if($checkWishList == false)
            <i class="fal fa-heart" style="color:#35373b !important;font-size:20px;"></i>
        @else
            <i class="fa fa-heart" style="color:#35373b !important;font-size:20px;" aria-hidden="true"></i>
        @endif
    </div>
@else
    <div href="javascript:void(0);"
         onclick="addToWishlist({{$car_content->id}})"
         class="us_wishlist"
         data-tooltip="tooltip" data-bs-placement="right"
         title="{{ $checkWishList == false ? __('Save Ad') : __('Saved') }}"
         style="position: absolute;
                right: 10px;
                bottom: 3px;
                cursor: pointer;
                background:white;
                color:red !important;
                z-index: 1; /* Adjusted z-index */
                border: none;
                border-radius: 50%;
                padding: 6px;
                width: 40px;
                height:40px;
                display: flex;
                justify-content: center;
                align-items: center;">
        @if($checkWishList == false)
            <i class="fal fa-heart" style="color:#35373b !important;font-size:20px;"></i>
        @else
            <i class="fa fa-heart" style="color:#35373b !important;font-size:20px;" aria-hidden="true"></i>
        @endif
    </div>
@endif
                 <!-- <a href="javascript:void(0);"  class="us_grid_shared" onclick="openShareModal(this)"
                   data-url="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}"
                   style="background: transparent;
                   position: absolute;
                   right: 10px;
                   bottom: 5%;
                   z-index: 999;
                   border: none;
                   color: #1b87f4;
                   font-size: 25px;" ><i class="fa fa-share-alt" aria-hidden="true"></i>
                   </a> -->

            </figure>

              <div class="product-details pt-2 px-2" style="cursor:pointer;"  onclick="window.location='{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id), 'slug' => $car_content->slug, 'id' => $car_content->id]) }}'" >


                    <span class="product-category font-xsm">

                           <h5 class="product-title mb-0">
                        <a href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}"
                          title="{{ optional($car_content)->title }}" class="us_grid_width">
                            {{ carBrand($car_content->brand_id) }}
                         {{ carModel($car_content->car_model_id) }} {{ optional($car_content)->title }}
                         </a>
                      </h5>


                        </span>




                    <div class="author us_child_dv" style="cursor:pointer; height: 41px;" >

                         <span style="line-height: 15px;font-size: 14px;"  onclick="window.location='{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id), 'slug' => $car_content->slug, 'id' => $car_content->id]) }}'">

                            @if($car_content->year)
                                {{ $car_content->year }}
                             @endif

                             @if($car_content->engineCapacity && $car_content->car_content->fuel_type )
                              <b class="us_dot "> . </b>   {{ roundEngineDisplacement($car_content) }}
                             @endif

                             @if($car_content->car_content->fuel_type )
                              <b class="us_dot "> . </b>   {{ $car_content->car_content->fuel_type->name }}
                             @endif


                             @if($car_content->mileage)
                               <b class="us_dot "> .</b>    {{ number_format( $car_content->mileage ) }} mi
                             @endif

                             @if($car_content->created_at && $car_content->is_featured != 1)
                                <b class="us_dot "> . </b> {{calculate_datetime($car_content->created_at)}}
                             @endif

                             @if($car_content->city)
                                <b class="us_dot "> . </b> {{  Ucfirst($car_content->city) }}
                             @endif

                        </span>

                    </div>

                    @if(!$car_content->year && !$car_content->mileage && !$car_content->engineCapacity)

                    <div style="display:flex;">

                        @if ($car_content->manager_special  == 1)
                        <div class="price-tag" style="padding: 3px 10px;border-radius:5px; background:#25d366;font-size: 10px;" > Manage Special</div>
                        @endif


                        <!-- @if($car_content->is_sale == 1)

                        <div class="price-tag" style="padding: 3px 10px;border-radius:5px;margin-left: 10px;background: #434d89;font-size: 10px;" >
                             Sale </span></div>

                        @endif -->


                        @if($car_content->reduce_price == 1)

                        <div class="price-tag" style="padding: 3px 10px;border-radius:5px;margin-left: 10px;background:#ff4444;font-size: 10px;" >    Reduced </span></div>

                        @endif

                    </div>

                    @endif

                     <!-- <ul class="product-icon-list  list-unstyled d-flex align-items-center us_absolute_position" style="margin-top: 10px;"  onclick="window.location='{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id), 'slug' => $car_content->slug, 'id' => $car_content->id]) }}'"  >

                        @if ($car_content->price != null)
                        <li class="icon-start us_price_icon" data-tooltip="tooltip" data-bs-placement="top"
                        title="Price">
                        <b style="color: gray;float: left;">Price</b>

                        <strong  class="us_mrg" style="color: black;font-size: 20px;">
                        @if($car_content->previous_price && $car_content->previous_price < $car_content->price)
                        <strike style="font-weight: 300;color: red;font-size: 14px;margin-left: 15px;float: left;" class="us_mr_15">{{ symbolPrice($car_content->price) }}</strike>

                        <div> {{ symbolPrice($car_content->previous_price) }}</div>
                        @else
                        <strike style="font-weight: 300;color: white;font-size: 14px;    float: left;">  </strike> <div>                            £{{ number_format($car_content->price, 0, '.', ',') }}
  </div>
                        @endif
                        </strong>
                        </li>
                        @endif

                        @if ($car_content->price != null && $car_content->price >= 1000)
                        <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                        title="">
                        <b style="color: gray;">From</b>

                        <strong style="color: black;font-size: 20px;">

                        {!! calulcateloanamount(!empty($car_content->previous_price && $car_content->previous_price < $car_content->price) ? $car_content->previous_price : $car_content->price)[0] !!}

                        </strong>
                        </li>
                        @endif

                    </ul> -->
                    <div class="d-flex paddingTop pt-0 pt-xl-5 justify-content-start align-items-end gap-3 ">

                     @if ($car_content->price != null)
                           <div class="icon-start us_price_icon " data-tooltip="tooltip" data-bs-placement="top"
                           title="Price">
                           <strong  class="us_mrg grid_card_price" style="color: black;">
                           @if($car_content->previous_price && $car_content->previous_price < $car_content->price)
                           <strike style="font-weight: 700;color: red;font-size: 14px;padding-top:16px;float: left;" class="us_mr_15">{{ symbolPrice($car_content->price) }}</strike>

                           <div  class="grid_card_price"> {{ symbolPrice($car_content->previous_price) }}</div>
                           @else
                           <strike style="font-weight: 300;color: white;font-size: 14px;    float: left;">  </strike>
                           <div class="grid_card_price">  {{ symbolPrice($car_content->price) }}  </div>
                           @endif
                           </strong>
                       </div>
                           @endif

                           @if ($car_content->price != null && $car_content->price >= 1000)
                           <li class="icon-start pb-1" data-tooltip="tooltip" data-bs-placement="top"
                           title="" style="list-style: none;">
                           <b style="color: #000000;font-size:14px; font-weight: 300px;">From</b>

                           <strong style="color: black;font-size: 14px; font-weight: 300px;">

                           £{!! calulcateloanamount(!empty($car_content->previous_price && $car_content->previous_price < $car_content->price) ? $car_content->previous_price : $car_content->price)[0] !!}

                           </strong>
                           </li>
                           @endif
   </div>
                  </div>

                  @if ($car_content->is_sold == 1 )
                  <div style="position: absolute; top:0px; width: 100%; z-index: -1px; height: 100%; background: rgba(0,0,0,0.3)"></div>
                  <img src="assets/img/Sold.png"  alt="sold out" style="position: absolute;  left:0px; right:0px; width: 45%; z-index: 1px; top:30%;" class="mx-auto" ></img>
                          @endif
                </div>
                <!-- product-default     £-->
                @if($car_content->is_sale == 1 && $car_content->is_sold != 1)
                <img src="assets/img/saletag.svg" width="120px" style=" position: absolute; width: 60px; top: 0px; right: 5px !important;"
       alt="sale"></img>

                @endif
                </div>
                <!-- product-default -->
              </div>
            @endforeach

             <!-- <div class="pagination us_pagination_filtered mb-40 justify-content-center" data-aos="fade-up">
            {{ $car_contents->links() }}
          </div> -->
           <!-- Limited Pagination -->
           <div class="pagination us_pagination_filtered mb-40 justify-content-center mt-20" id="pagination">
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
        @endif
