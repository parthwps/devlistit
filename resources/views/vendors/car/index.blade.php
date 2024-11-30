@extends("frontend.layouts.layout-v$settings->theme_version")
@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('My Ads') }}
  @else
    {{ __('My Ads') }}
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

    <div class="col-12 col-lg-9">
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
            <li>{{ __('You have to remove ') }} {{ vendorTotalAddedCar() - $current_package->number_of_car_add . __(' cars  to enable car editing.') }}</li>
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
    <ul class="nav nav-tabs nav-fill" style="justify-content:left !important;">
        <li class="nav-item">
            <a data-id="all" href="#" class="nav-link active">All Ads ({{count($cars)}})</a>
        </li>
        <li class="nav-item">
            <a data-id="1" href="#" class="nav-link">Listed ({{countAds(Auth::id(),1)}})</a>
        </li>
        <li class="nav-item">
            <a data-id="0" href="#" class="nav-link">Not Listed ({{count($cars) - countAds(Auth::id(),1) }})</a>
        </li>
    </ul>
    </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">

    <div class="container mt-4" id="fillwithAjax">
        @foreach ($cars as $car)
        <div class="card ">
        <div class="card-header">
        <div class="d-flex justify-content-between">

        <div class=" d-inline-block text-left">
            @php
            $forExpired ="";
            $forExpired = noDaysLeftByAd($car->package_id,$car->created_at);

            @endphp

            @if($car->is_sold == 1 || $car->status == 2 )
            <span class="text-warning">{{'Sold'}}</span>
            @else

            @if($car->status==3)
            {{ 'Withdraw' }}
            @endif

            @if($car->status==0)
            Needs Payment (Not Listed)
            @elseif($car->status==1 || $car->status==4)
            {{ noDaysLeftByAd($car->package_id,$car->created_at) }}
            @endif
            @endif
        </div>

        <h5 class="text-right">
          @if($car->is_sold == 0 && $car->status != 2 )

            <div class="dropdown">

                <a style="color:#1572E8; font-weight:100; font-size:15px;" class=" dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Manage
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                    @if($car->status==0 && $forExpired !="Expired")
                        <a class="dropdown-item mb-2" href = "{{ route('vendor.package.payment_method',  $car->id) }}">Pay Now</a>
                    @endif

                    @if(($car->status==1 || $car->status==4 ) && $forExpired !="Expired")
                        <a class="dropdown-item mb-2" href = "{{ route('vendor.cars_management.ad_status', ['withdraw',$car->id]) }}">Withdraw</a>
                    @endif

                    @if( $forExpired=="Expired"  && ( !empty($car->package_id) && in_array($car->status , [0,1,4]) && $car->is_sold != 1 ) )
                        <a class="dropdown-item mb-2"  href = "{{ route('vendor.package.payment_boost',  [$car->car_content->main_category_id,$car->id]) }}">Republish</a>
                    @endif

                    @if( $forExpired != "Expired" && !in_array($car->status , [0,1,4])  && $car->status == 3  && $car->is_sold != 1  )
                        <a class="dropdown-item mb-2"  href = "{{ route('vendor.cars_management.ad_status', ['relist',$car->id]) }}">Relist</a>
                    @endif

                    @if($forExpired!="Expired")
                        <a class="dropdown-item mb-2" href="{{ $car_add != 'over' ? route('vendor.cars_management.edit_car', $car->id) : '#' }}">Edit</a>
                    @endif

                    @if($car->status!=0)
                        @if($car->is_sold == 0)
                            <a class="dropdown-item mb-2" href="javascript:void(0);"   onclick="removeThisAd( 'sold' , {{$car->id}} )">Mark as sold</a>
                        @endif
                    @endif

                    <a class="dropdown-item mb-2" href="javascript:void(0);"   onclick="removeThisAd( 'removed' , {{$car->id}} )">Remove</a>

                </div>
        </div>
   @endif

  </h5>
      </div>
      </div>
      <div class="card-body" style="padding:0px;">
    <div class="row no-gutters">
      <div class="col-md-4 col-sm-*">
        <div class="image-container">
      <img class="  us_design" style="" src="{{  $car->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$car->feature_image) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $car->feature_image }}" alt="Ad Image">
      </div>
       </div>
      <div class="col-md-8 col-sm-*">

            <label class="card-title us_mrg" style="">
                @php
                  $car_content = $car->car_content;

                  if (is_null($car_content))
                  {
                      $car_content = $car->car_content()->first();
                  }

                @endphp
                <a href="{{ route('frontend.car.details', [catslug($car_content->category_id), 'slug' => $car_content->slug, 'id' => $car->id]) }}"
                  target="_blank">
                  {{ strlen(@$car_content->title) > 50 ? mb_substr(@$car_content->title, 0, 50, 'utf-8') . '...' : @$car_content->title }}
                </a>
            </label>


          <div style="" class="@if( !empty($car->package_id) && in_array($car->status , [0,1]) && $car->is_sold != 1 ) us_absolut_position_with_boost @else us_absolut_position @endif us_pro_mrg">
            <strong  class="us_mrg" style="color: black;font-size: 20px;">
                @if($car->previous_price && $car->previous_price < $car->price )
                    <strike style="font-weight: 300;color: gray;font-size: 14px;">{{ symbolPrice($car->price) }}</strike> . {{ symbolPrice($car->previous_price) }}
                @else
                £{{ number_format($car->price, 0, '.', ',') }}
                @endif
            </strong>
        </div>

        <div style="right: 0%;" class="@if( !empty($car->package_id) && in_array($car->status , [0,1,4]) && $car->is_sold != 1 ) us_absolut_position_with_boost @else us_absolut_position @endif us_footer_div">


            <span style="float:right;    margin-right: 15px;font-size: 16px;color: #a7a7a7;" data-tooltip="tooltip" data-bs-placement="top" title="How many times Ad saved" >
                <i class="fa fa-heart" aria-hidden="true" style="font-size: 20px;"></i>  {{ ($car->wishlists()->get()->count() > 0 ) ? $car->wishlists()->get()->count() : 'No' }} saves
            </span>

            <span style="float:right;    margin-right: 15px;font-size: 16px;color: #a7a7a7;" data-tooltip="tooltip" data-bs-placement="top" title="Total Views"  >
                <i class="fa fa-eye" aria-hidden="true" style="font-size: 20px;"></i>  {{ ($car->visitors()->get()->count() > 0 ) ? $car->visitors()->get()->count() : 'No' }} views
            </span>
        </div>

        </div>
      </div>
    </div>

    @if( !empty($car->package_id) && in_array($car->status , [0,1,4]) && $car->is_sold != 1 )

        <div style="text-align:right; border-top: 1px solid #ebe8e8 !important;" class="card-footer text-right">

        @if($car->status==0)
            <a href = "{{ route('vendor.package.payment_method',  $car->id) }}" style="color:#1572E8; font-weight:300; font-size:17px; margin-right:20px;">
                Pay Now
            </a>
        @endif

        @if($car->status==1 || $car->status==4)
            <a href = "{{ route('vendor.package.payment_boost',  [$car->car_content->main_category_id,$car->id]) }}" style="color:#EE2C7B; font-weight:400; font-size:17px; margin-right:30px;">
                <i class="fal fa-paper-plane"></i> Boost
            </a>
        @endif

      </div>

    @endif

  </div>

@endforeach
</div>


      </div>
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
    var url = '/customer/ad-management/ajaxcontent?status='+$(this).data("id");
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
