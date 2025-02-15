   
 
  <!-- updated mo-->
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
            $imng = $car_content->galleries->sortBy('priority')->first();
            
            $image_path = $imng->image;
            $rotation = $imng->rotation_point;
            } 
          
            @endphp
            
            <div class="d-flex  align-items-center justify-content-start offSetLeft" style="">
           <div class="" style="max-width: 160px;">
          <div class="product-default mb-sm-25 mb-20  font-type" 
          style="padding: 0px !important;box-shadow: 0px 0px 20px 0px rgba(76, 87, 125, 0.1);
          border-color: transparent;border-radius: 10px;" data-id="{{$car_content->id}}">
            <figure class="product-img mb-sm-15 mb-2" style="width: 180px;height:109px">
              <a href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}"
              class="lazy-container ratio ratio-2-3">
                <img class="lazyload"
                data-src="{{  $car_content->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path }}"
                alt="{{ optional($car_content)->title }}" style="transform: rotate({{$rotation}}deg);" >
              </a>

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
              
            </figure>
          
            <div class="product-detail py-1 px-2 " >
              
                  <span class="product-category font-xsm">
                    <h5 class="product-title  mb-0" 
                    style="display: inline-block;white-space: nowrap;overflow: hidden;
                     font-size: 14px;
                    text-overflow: ellipsis;vertical-align: top;font-weight:bold" >
                      <a href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}"
                        title="{{ optional($car_content)->title }}">{{ carBrand($car_content->brand_id) }}
                       {{ carModel($car_content->car_model_id) }} {{ optional($car_content)->title }}</a>
                    </h5>    
                  </span>
                  <div class="d-flex align-items-center justify-content-between mb-sm-10 mb-2" >
                    <div class="author w-100  d-flex justify-content-between align-items-center" style="margin-bottom: -18px;">
                        @if ($car_content->vendor_id != 0)
                            <p style="font-size: 10px;">
                                {{ calculate_datetime($car_content->created_at) }} ago 
                            </p>
                        @endif
                    </div>
                  </div>
                      {{-- @if ($car_content->vendor_id != 0)
                      <span class="product-category font-xsm">
                        
                        <h5 class="product-title  mb-0" 
                        style="display: inline-block;white-space: nowrap;overflow: hidden;
                        font-size: 12px;margin-top:0px;margin-bottom:10px;
                        text-overflow: ellipsis;vertical-align: top;font-weight:bold" >
                          <a href="javascript:void(0);"
                            title="{{ $car_content->vendor->vendor_info->name}}">
                           {{ $car_content->vendor->vendor_info->name}}</a>
                        </h5>
                      </span>          
                      @endif --}}                      


                    <!-- <a href="javascript:void(0);" onclick="openShareModal(this)" 
                      data-url="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id), 'slug' => $car_content->slug, 'id' => $car_content->id]) }}"
                      style="background: transparent; border: none; color: #1D86F5;" class="shareIcon">
                        <i class="fa fa-share-alt" aria-hidden="true"></i>
                    </a> -->
                  <!-- </div> -->

                <div class="d-flex align-items-center mb-3 justify-content-between  my-1 " 
                style="height: 10px;font-size: 20px;font-weight:bold;">
                    <div class="author">
                        <span class="pricePound" style="color: #1D86F5; font-size: 16px;"  data-price="{{ $car_content->price }}">
                          {{ symbolPrice($car_content->price) }} 
                        </span>
                    </div>
                      <div>
                        <!-- {!! calulcateloanamount(!empty($car_content->previous_price && $car_content->previous_price < $car_content->price) ? $car_content->previous_price : $car_content->price)[0] !!} -->
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
                            <span class="" style="color: black; font-size: 12px;">
                                {{ symbolPrice($number) }}
                            </span>
                          
                            <span class="" style="color: gray; font-size: 10px;">
                                /{{ $period }}
                            </span>
                            
                          @endif
  
                        @endif
                        
                      </div>
                </div>
                

            </div>
          </div>
        </div>
          </div>
        @endforeach

 
        <script>

setTimeout(() => {
  
  function formatCurrency(number) {
    return '£' + new Intl.NumberFormat('en-GB', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(number);
}

function formatAllPrices() {
    $('.pricePound').each(function() { // Use class selector instead of ID
        var priceElement = $(this);
        var price = parseFloat(priceElement.data('price'));
        priceElement.text(formatCurrency(price));
      });
    }
    
    formatAllPrices();
  }, 2000);


        </script>      
              
              
            