            @if($car_contents->count() == 0)
                <div class="col-12" data-aos="fade-up"> <center> <h4>Sorry, No Posts Matched Your Criteria</h4> </center> </div>
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
            
              <div class="col-12" data-aos="fade-up">
                  
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
                
                  @if($car_content->is_featured == 1)
                    <div class="row g-0 product-default product-column border mb-30 align-items-center p-15" style="<?= ( $car_content->vendor->vendor_type == 'normal' ) ? 'border-top: 5px solid #ff9e02 !important;' : '' ?> padding: 0px !important;transform: translateY(-5px);box-shadow: 0px 0px 20px gray; border-radius:5px;" data-id="{{$car_content->id}}">
                    @else
                        <div class="row g-0 product-default product-column border mb-30 align-items-center p-15" style="padding: 0px !important;transform: translateY(-5px);box-shadow: 0px 0px 20px gray; border-radius:5px;"  data-id="{{$car_content->id}}">
                    @endif
                    
                    @if ($car_content->vendor_id != 0)   
                    @if($car_content->vendor->vendor_type == 'dealer')
                    
                    @if($car_content->is_featured == 1)
                        <div class="col-md-12" style="border-bottom: 5px solid #ff9e02;">
                    @else
                        <div class="col-md-12" style="border-bottom: 1px solid #e9e9e9;">
                    @endif
                    
                        <div class="author mb-15 us_parent_cls" >
                        
                            <a style="padding-top: 1rem;display: flex;padding-left: 1rem;" class="color-medium"
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
                            src="{{ asset('assets/img/blank-user.jpg') }}"
                            data-src="{{ $photoUrl }}"  
                            alt="Vendor" 
                            onload="handleImageLoad(this)"
                            onerror="{{ asset('assets/img/blank-user.jpg') }}" >
                    
                    
                            @else
                            <img style="border-radius: 10%;max-width: 60px;" class="lazyload blur-up" data-src="{{ asset('assets/img/blank-user.jpg') }}"
                            alt="Image">
                            @endif
                            <span>
                             
                             <strong class="us_font_15" style="color: black;font-size: 20px;">{{ $car_content->vendor->vendor_info->name }} </strong>
                            
                                 @if($car_content->vendor->is_franchise_dealer == 1)
                            
                                    @php
                                    
                                    $review_data = null;
                                    
                                    @endphp
                            
                                @if($car_content->vendor->google_review_id > 0 )
                                    @php
                                        $review_data = get_vendor_review_from_google($car_content->vendor->google_review_id , true);
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
                        
                        </div>
                        
                    </div>
                     @endif
                    @endif
            
                  <figure class="product-img col-xl-4 col-lg-5 col-md-6 col-sm-12">
                      
                    @if($car_content->is_featured == 1)
                     <div class="sale-tag" style="border-bottom-right-radius: 0px;     background: #ff9e02;">Spotlight</div>
                    @endif
                    
                    <a href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}"
                      class="lazy-container ratio ratio-2-3">
                      <img class="lazyload"
                        data-src=" {{  $car_content->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path }}  " alt="Product" style="transform: rotate({{$rotation}}deg);" onerror="this.onerror=null;this.src='{{ asset('assets/img/noimage.jpg') }}';">
                    </a>
                    
                    @if($car_content->deposit_taken  == 1)
                        <div class="reduce-tag">DEPOSIT TAKEN</div>
                    @endif
            
                  </figure>
                  
                   <div class="product-details col-xl-8 col-lg-7 col-md-6 col-sm-12 border-lg-end pe-lg-2" style="margin-top:0.5rem;cursor:pointer;padding-left: 15px;"  onclick="window.location='{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id), 'slug' => $car_content->slug, 'id' => $car_content->id]) }}'" >
                        
                    <span class="product-category font-sm " style=" display: flex;"  >
                        
                    <h5 class="product-title "><a
                        href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}">{{ carBrand($car_content->brand_id) }} {{ carModel($car_content->car_model_id) }} {{ $car_content->title }}</a>
                    </h5>
                    
                    </span>
                    
                    <div class="author mb-10 us_child_dv"   >
                     
                         <span>
                             
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
                    
                    <div style="display:flex;margin-top: 1rem;margin-bottom: 1.5rem;">
                        
                        @if ($car_content->manager_special  == 1)
                        <div class="price-tag" style="padding: 3px 5px;border-radius:5px; background:#25d366;font-size: 10.5px;" > Manage Special</div>
                        @endif
                        
                        @if($car_content->is_sale == 1)
                        
                        <div class="price-tag" style="padding: 3px 5px;border-radius:5px;margin-left: 10px;background:#434d89;font-size: 10.5px;" > Sale </span></div>
                        
                        @endif
                        
                        @if($car_content->reduce_price == 1)
                        
                        <div class="price-tag" style="padding: 3px 5px;border-radius:5px;margin-left: 10px;background:#ff4444;font-size: 10.5px;" > Reduced </span></div>
                        
                        @endif
                        
                         @if(!empty($car_content->warranty_duration))
                            <div class="price-tag" style="padding: 3px 5px;border-radius: 5px;margin-left: 10px;background: #ebebeb;font-size: 10.5px;color: #525252;border: 1px solid #d6d6d6;box-shadow: 0px 0px 5px gray;" > {{$car_content->warranty_duration}} Warranty</span></div>
                        @endif
                    
                    </div>
                    
                    
                     <ul class="product-icon-list  list-unstyled d-flex align-items-center"  style="position:relative; bottom:10px;" >
                      
                      @if ($car_content->price != null)
                      <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                        title="Price">
                          <b style="color: gray;">Price</b>
                          <br>
                          <strong  class="us_mrg" style="color: black;font-size: 20px;    margin-left: 0;">
                            @if($car_content->previous_price && $car_content->previous_price < $car_content->price )
                            <strike style="font-weight: 300;color: red;font-size: 14px;    float: left;">{{ symbolPrice($car_content->price) }}</strike> 
                            <div style="color:black;"> {{ symbolPrice($car_content->previous_price) }}</div>
                            @else
                            {{ symbolPrice($car_content->price) }}   
                            @endif
                        </strong>
                      </li>
                      @endif
                      
                       @if ($car_content->price != null && $car_content->price >= 1000)
                          <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                            title="">
                              <b style="color: gray;">From</b>
                              <br>
                            <strong style="color: black;font-size: 20px;">{!! calulcateloanamount(!empty($car_content->previous_price && $car_content->previous_price < $car_content->price) ? $car_content->previous_price : $car_content->price)[0] !!}</strong>
                          </li>
                      @endif
                      
                    </ul>
                   
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
                  
                  <a href="javascript:void(0);"
                        onclick="addToWishlist({{$car_content->id}})"
                    class="btn btn-icon us_wishlist2 us_list_downside" data-tooltip="tooltip"
                    data-bs-placement="right"
                    title="{{ $checkWishList == false ? __('Save Ads') : __('Saved') }}">
                    @if($checkWishList == false)
                            <i class="fal fa-heart"></i>
                        @else
                            <i class="fa fa-heart" aria-hidden="true"></i>
                        @endif
                  </a>
                  
                   <a href="javascript:void(0);" class="us_wishlist2 btn-icon us_list_downside us_share_icon" style=" color: #1b87f4 !important;" onclick="openShareModal(this)" 
                    data-url="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id]) }}"
                    style="
                    color: #1b87f4;
                    " ><i class="fa fa-share-alt" aria-hidden="true"></i>
                    </a>
                    
                    
                    
                </div><!-- product-default -->
              </div>
            @endforeach
            
             <div class="pagination us_pagination_filtered mb-40 justify-content-center" data-aos="fade-up" id="pagination">
                
                {{ $car_contents->links() }}
                
          </div>
          </div>
        </div>
        @endif