 @foreach ($cars as $car)

    @php
      $car_content = $car->car_content;

      if (is_null($car_content))
      {
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
                <span class="text-warning">
                    {{'Sold'}}
                </span>
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
            <a style="color:#1572E8; font-weight:100; font-size:15px;position: relative;z-index: 10;" href = "{{ route('remove.wishlist', $car->wishlist_id) }}">
                Remove
            </a>
        </h5>

      </div>
      </div>


      <div class="card-body" style="padding:0px;">

      @if($car->is_sold == 1 )
       <div class="overlay"></div>
      @endif

    <div class="row no-gutters">
      <div class="col-md-4 col-sm-*">
     <div class="image-container">
      <img class="  us_design"  src="{{  $car->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$car->feature_image) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $car->feature_image }}" alt="Ad Image">
      </div>
      </div>
        <div class="col-md-8 col-sm-*">

            <label class="card-title us_mrg ">

                <a href="{{ route('frontend.car.details', [catslug($car_content->category_id), 'slug' => $car_content->slug, 'id' => $car->id]) }}" target="_blank">
                    {{ strlen(@$car_content->title) > 50 ? mb_substr(@$car_content->title, 0, 50, 'utf-8') . '...' : @$car_content->title }}
                </a>

            </label>

            <div style="" class="us_absolut_position us_pro_mrg">
            <strong  class="us_mrg" style="color: black;font-size: 20px;">
                @if($car->previous_price && $car->previous_price < $car->price )
                    <strike style="font-weight: 300;color: gray;font-size: 14px;">{{ symbolPrice($car->price) }}</strike> . {{ symbolPrice($car->previous_price) }}
                @else
                £{{ number_format($car->price, 0, '.', ',') }}
                @endif
            </strong>
            </div>

            <div style="right: 0%;" class="us_absolut_position us_footer_div">
             <span style="float:right;margin-right: 15px;font-size: 16px;color: #a7a7a7;" data-tooltip="tooltip" data-bs-placement="top" title="Compare Ad" >
                <i class="fa fa-compress" aria-hidden="true" style="font-size: 20px;"></i>
                <input type="checkbox" style="zoom: 1.4;position: relative;top: 1.7px;margin-left: 1px;" class="compare_checkbox" onclick="compareCheckbox(this)" name="comparison[]" value="{{$car->id}}" />
            </span>

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


  </div>
  @endif
@endforeach
