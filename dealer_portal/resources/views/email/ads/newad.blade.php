<div class="col-xl-4 col-md-6" data-aos="fade-up">
                <div class="product-default border p-15 mb-25">
                 
                    <a href="{{ route('frontend.car.details', ['cattitle' => catslug($ad_id->car_content->category_id),'slug' => $ad_id->car_content->slug, 'id' => $ad_id->id]) }}"
                      class="lazy-container ratio ratio-2-3">
                      <img class="lazyload"
                        src="https://listit.im/assets/admin/img/car-gallery/{{  $ad_id->feature_image }}"
                        alt="{{ optional($ad_id)->title }}">
                    </a>
                 
                  <div class="product-details">
                    
                    <div class="d-flex align-items-center justify-content-between mb-10">
                      <h5 class="product-title mb-0">
                        <a href="https://listit.im/{{ route('frontend.car.details', ['cattitle' => catslug($ad_id->car_content->category_id),'slug' => $ad_id->car_content->slug, 'id' => $ad_id->id]) }}"
                          title="{{ optional($ad_id->car_content)->title }}"><p style="color:#455056; font-size:16px; font-weight:bold; line-height:24px; margin:0; font-family:'Rubik',sans-serif; ">{{ optional($ad_id->car_content)->title }}</p></a>
                      </h5>
                    
                       
                    </div>
                   
                    <div class="product-price mb-10">
                      <h6 style="color:#455056; font-size:14px;line-height:24px; margin:0; font-family:'Rubik',sans-serif; ">
                        {{ symbolPrice($ad_id->price) }}
                      </h6>
                      @if (!is_null($ad_id->previous_price))
                        <span class="old-price font-sm">
                          {{ symbolPrice($ad_id->previous_price) }}</span>
                      @endif
                    </div>
                  </div>
                </div>
              </div>