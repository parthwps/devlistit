@extends("frontend.layouts.layout-v$settings->theme_version")
@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('Signup') }}
  @else
    {{ __('Signup') }}
  @endif
@endsection
@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keywords_vendor_signup }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_vendor_signup }}
  @endif
@endsection

@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Ads Management'),
  ])
  <div class="user-dashboard pt-20 pb-60">
    <div class="container">



  <div class="row gx-xl-5">

       @includeIf('vendors.partials.side-custom')

    <div class="col-md-9">
  @php
    $current_package = App\Http\Helpers\VendorPermissionHelper::packagePermission(Auth::guard('vendor')->user()->id);
  @endphp
  @if ($current_package != '[]')
    @if (vendorTotalAddedCar() > $current_package->number_of_car_add)
      @php
        $car_add = 'over';
      @endphp
      <div class="mt-2 mb-4">
        <div class="alert alert-danger text-dark">
          <ul>
            <li>{{ __('You have added total ') . vendorTotalAddedCar() }} {{ __(' cars.') }}</li>
            <li>{{ __('Your current package supports') . ' ' . $current_package->number_of_car_add . ' cars.' }} </li>
            <li>{{ __('You have to remove ') }}
              {{ vendorTotalAddedCar() - $current_package->number_of_car_add . __(' cars  to enable car editing.') }}</li>
          </ul>
        </div>
      </div>
    @else
      @php
        $car_add = '';
      @endphp
    @endif
    @if (vendorTotalFeaturedCar() > $current_package->number_of_car_featured)
      @php
        $car_featured = 'over';
      @endphp
      <div class="mt-2 mb-4">
        <div class="alert alert-danger text-dark">
          <ul>
            <li>{{ __('You have total  ') . vendorTotalFeaturedCar() . ' featured cars.' }}</li>
            <li>
              {{ __('With your current package you can feature ') . $current_package->number_of_car_featured . __(' cars.') }}
            </li>
            <li>{{ __('Your cars has been removed from featured cars section of our website.') }}
            </li>
            <li>{{ __('You have to unfeature ') }}
              {{ vendorTotalFeaturedCar() - $current_package->number_of_car_featured . __(' cars  to show your cars in featured cars section of our website.') }}
            </li>
          </ul>

        </div>
      </div>
    @else
      @php
        $car_featured = '';
      @endphp
    @endif
  @else
    @php
      $can_car_add = 0;
      $car_add = '';
      $car_featured = 'over';

      $pendingMemb = \App\Models\Membership::query()
          ->where([['vendor_id', '=', Auth::id()], ['status', 0]])
          ->whereYear('start_date', '<>', '9999')
          ->orderBy('id', 'DESC')
          ->first();
      $pendingPackage = isset($pendingMemb) ? \App\Models\Package::query()->findOrFail($pendingMemb->package_id) : null;
    @endphp
    @if ($pendingPackage)
      <div class="alert alert-warning text-dark">
        {{ __('You have requested a package which needs an action (Approval / Rejection) by Admin. You will be notified via mail once an action is taken.') }}
      </div>
      <div class="alert alert-warning text-dark">
        <strong>{{ __('Pending Package') . ':' }} </strong> {{ $pendingPackage->title }}
        <span class="badge badge-secondary">{{ $pendingPackage->term }}</span>
        <span class="badge badge-warning">{{ __('Decision Pending') }}</span>
      </div>
    @else
      <!-- <div class="alert alert-warning text-dark">
        {{ __('Your membership is expired. Please purchase a new package / extend the current package.') }}
      </div> -->
    @endif
    @includeIf('vendors.verify')
  @endif




  <div class="row">
    <div class="col-md-12">
    <div class="m-4">
    <h4>Recently Viewed Ads</h4>
</div>
  </div>
  </div>

  <div class="row">
      @php
        $car_contents = $cars;
      @endphp


     @if(empty($car_contents))
                <div class="col-12" data-aos="fade-up"> <center> <h4>No browsing history</h4> </center> </div>
            @else

@php
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
                $image_path = $car_content->galleries[0]->image;
                $rotation = $car_content->galleries[0]->rotation_point;
            }

            @endphp

            <div class="col-xl-4 col-md-6" data-aos="fade-up">



            <div class="product-default us_set_height set_height border p-15 mb-25" data-id="{{$car_content->id}}" style="box-shadow: 0px 0px 10px #b3b3b3;border-radius: 10px;">




         @if($car_content->is_sold == 1)
       <div class="overlay"></div>
      @endif


            <figure class="product-img mb-15">
            <a href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id),'slug' => $car_content->car_content->slug, 'id' => $car_content->id]) }}"
            class="lazy-container ratio ratio-2-3">
            <img class="lazyload"
            data-src="{{  $car_content->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path }}"
            alt="{{ optional($car_content)->title }}" style="transform: rotate({{$rotation}}deg);" >
            </a>



            </figure>


                 <div class="product-details" style="cursor:pointer;"   >


                    <span class="product-category font-xsm" onclick="window.location='{{ route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id), 'slug' => $car_content->car_content->slug, 'id' => $car_content->id]) }}'">

                           <h5 class="product-title mb-0">
                        <a href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id),'slug' => $car_content->car_content->slug, 'id' => $car_content->id]) }}"
                          title="{{ optional($car_content)->title }}" class="us_grid_widths">
                            {{ carBrand($car_content->car_content->brand_id) }}
                         {{ carModel($car_content->car_content->car_model_id) }} {{ optional($car_content->car_content)->title }}
                         </a>
                      </h5>


                        </span>

                        <div class="d-flex align-items-center justify-content-between ">

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
                        class="btn us_wishlist btn-icon "
                        data-tooltip="tooltip" data-bs-placement="right"
                        title="{{ $checkWishList == false ? __('Save Ad') : __('Saved') }}" style="position: absolute;
                        right: 0px;
                        bottom: 15%;
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
                        data-url="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id), 'slug' => $car_content->car_content->slug, 'id' => $car_content->id]) }}"
                        style="background: transparent;
                        position: absolute;
                        right: 10px;
                        bottom: 5%;
                        z-index: 999;
                        border: none;
                        color: #1b87f4;
                        font-size: 25px;" ><i class="fa fa-share-alt" aria-hidden="true"></i>
                        </a>

                    </div>

                    <div class="author us_child_div" style="cursor:pointer;" onclick="window.location='{{ route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id), 'slug' => $car_content->car_content->slug, 'id' => $car_content->id]) }}'" >

                         <span style="line-height: 15px;font-size: 14px;">

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

                    @if(!$car_content->year && !$car_content->mileage && !$car_content->engineCapacity)

                    <div style="display:flex;margin-top: 1.5rem;">

                        <!--@if ($car_content->manager_special  == 1)-->
                        <!--<div class="price-tag" style="padding: 3px 10px;border-radius:5px; background:#25d366;font-size: 10px;" > Manage Special</div>-->
                        <!--@endif-->


                        <!--@if($car_content->is_sale == 1)-->

                        <!--<div class="price-tag" style="padding: 3px 10px;border-radius:5px;margin-left: 10px;background: #434d89;font-size: 10px;" >  Sale </span></div>-->

                        <!--@endif-->


                        <!--@if($car_content->reduce_price == 1)-->

                        <!--<div class="price-tag" style="padding: 3px 10px;border-radius:5px;margin-left: 10px;background:#ff4444;font-size: 10px;" >    Reduced </span></div>-->

                        <!--@endif-->

                    </div>

                    @endif

                     <ul class="product-icon-list us_absolute_position_front list-unstyled d-flex align-items-center us_absolute_position" style="margin-top: 10px;"   onclick="window.location='{{ route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id), 'slug' => $car_content->car_content->slug, 'id' => $car_content->id]) }}'" >

                        @if ($car_content->price != null)
                        <li class="icon-start us_price_icon" data-tooltip="tooltip" data-bs-placement="top"
                        title="Price">
                        <b style="color: gray;float: left;">Price</b>

                        <strong  class="us_mrg" style="color: black;font-size: 20px;">
                        @if($car_content->previous_price && $car_content->previous_price < $car_content->price)
                        <strike style="font-weight: 300;color: red;font-size: 14px;margin-left: 15px;float: left;" class="us_mr_15">{{ symbolPrice($car_content->price) }}</strike>

                        <div> {{ symbolPrice($car_content->previous_price) }}</div>
                        @else
                        <strike style="font-weight: 300;color: white;font-size: 14px;    float: left;">  </strike> <div>                             £{{ number_format($car_content->price, 0, '.', ',') }}
                          £{{ number_format($car_content->price, 0, '.', ',') }}
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

                    </ul>

                  </div>
                </div><!-- product-default -->
              </div>
            @endforeach

             <div class="pagination us_pagination_filtered mb-40 justify-content-center" data-aos="fade-up">
            {{ $car_contents->links() }}
          </div>


          </div>

        </div>
        @endif



    </div>


  </div>
</div>
</div></div>
</div>
@endsection
@section('script')
{{-- admin-main css --}}
<link rel="stylesheet" href="{{ asset('assets/css/admin-main.css') }}">
<script>

  $(".nav-link").click(function(){
    // Remove active class from all items
    $(".nav-link").removeClass("active");
    // Add active class to the clicked item
    $(this).addClass("active");
    var url = '/customer/ad-management/ajaxsaveads?status='+$(this).data("id");
    $.ajax({
      type: 'GET',
      url: url,

      success: function (response) {


          $('#fillwithAjax').html(response.data);


      }
    });
  });
  </script>
  @endsection
