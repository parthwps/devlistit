
    @foreach ($cars as $car)
    @php
      $car_content = $car->car_content;
      if (is_null($car_content)) {
          $car_content = $car->car_content()->first();
      }

    @endphp
    @if($car_content)
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
      @elseif($car->status==1 || $car->status==4 )
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
        @if($car->status==1 || $car->status==4 && $forExpired !="Expired")
        <a class="dropdown-item mb-2" href = "{{ route('vendor.cars_management.ad_status', ['withdraw',$car->id]) }}">Withdraw</a>
        @endif
        @if( $forExpired=="Expired"  && ( !empty($car->package_id) && in_array($car->status , [0,1,4]) && $car->is_sold != 1 ) )
        <a class="dropdown-item mb-2"  href = "{{ route('vendor.package.payment_boost',  [$car->car_content->main_category_id,$car->id]) }}">Republish</a>
        @endif

        @if( $forExpired != "Expired" && !in_array($car->status , [0,1,4])  && $car->status == 3  && $car->is_sold != 1  )
            <a class="dropdown-item mb-2"  href = "{{ route('vendor.cars_management.ad_status', ['relist',$car->id]) }}">Relist</a>
        @endif

        @if($forExpired!="Expired")
        <a class="dropdown-item mb-2" href="{{  route('vendor.cars_management.edit_car', $car->id)  }}">Edit</a>
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
      <div class="card-body" style="padding: 0;">
    <div class="row no-gutters">
      <div class="col-md-4 col-sm-*">
      <div class="image-container">
      <img class=" us_design"  src="{{  $car->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$car->feature_image) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $car->feature_image }}" alt="Ad Image">
      </div>
       </div>
       <div class="col-md-8 col-sm-*">

        <label class="card-title us_mrg" >
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

     @if( !empty($car->package_id) && in_array($car->status , [0,1,4]) && $car->is_sold !=1 )
        <div style="text-align:right; border-top: 1px solid #ebe8e8 !important;" class="card-footer text-right">
        @if($car->status==0)
        <a href = "{{ route('vendor.package.payment_method',  $car->id) }}" style="color:#1572E8; font-weight:300; font-size:17px; margin-right:20px;">Pay Now</a>
        @endif
        @if($car->status==1 || $car->status==4 )
        <a href = "{{ route('vendor.package.payment_boost',  [$car->car_content->main_category_id,$car->id]) }}" style="color:#EE2C7B; font-weight:400; font-size:17px; margin-right:30px;">
            <i class="fal fa-paper-plane"></i> Boost</a>
        @endif
        </div>
     @endif

  </div>
  @endif
@endforeach
