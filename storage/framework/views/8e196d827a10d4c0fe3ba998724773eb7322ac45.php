       
      <?php if($car_contents->count() == 0): ?>
        <div class="col-12 w-100" data-aos="fade-up"> <center> <h4>Sorry, No Posts Matched Your Criteria</h4> </center> </div>
      <?php else: ?>
        
            <?php
            $admin = App\Models\Admin::first();
            ?>
            
            <?php $__currentLoopData = $car_contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $car_content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 
              <?php
              
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
            
              ?>
             
              <div class="w-100 border bg-white  rounded position-relative  mb-4 p-0" >
                <?php if($key == 2 || $key == 6 || $key == 9 ): ?>
                  
                  <div class="widget-banner" style="margin-bottom: 1rem;">
                    <?php if(!empty(showAd(1))): ?>
                      <div class="text-center">
                    <?php echo showAd(1); ?>

                      </div>
                    <?php endif; ?>
                    <?php if(!empty(showAd(2))): ?>
                      <div class="text-center">
                    <?php echo showAd(2); ?>

                      </div>
                    <?php endif; ?>
                  </div>
                  
                <?php endif; ?>
                                    
                  <?php if($car_content->vendor_id != 0 && $car_content->vendor->vendor_type == 'dealer'): ?>   
                    
                    <div class="w-100 p-3" style="border-bottom: 2px solid rgb(34, 40, 49);">
                      <div class="d-flex align-items-center gap-2">
                        <div >
                        <a  class="color-medium"
                            href="<?php echo e(route('frontend.vendor.details', ['id' => $car_content->vendor->id ,'username' => ($vendor = @$car_content->vendor->username)])); ?>"
                            target="_self" title="<?php echo e($vendor = @$car_content->vendor->username); ?>">
                            <?php if($car_content->vendor->photo != null): ?>
                          
                              <?php
                              $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $car_content->vendor->photo;
                              
                              if (file_exists(public_path('assets/admin/img/vendor-photo/' . $car_content->vendor->photo))) 
                              {
                                $photoUrl = asset('assets/admin/img/vendor-photo/' . $car_content->vendor->photo);
                              }
                              ?>
                              
                              <img 
                              style="border-radius: 10%; max-width: 60px;" 
                              class="lazyload blur-up"
                             
                              data-src="<?php echo e($photoUrl); ?>"
                              src="<?php echo e($photoUrl); ?>"  
                              alt="Vendor" 
                              onload="handleImageLoad(this)"
                              onerror="<?php echo e(asset('assets/img/blank-user.jpg')); ?>" >
                    
                            <?php else: ?>
                              <img style="border-radius: 10%;max-width: 60px;" class="lazyload blur-up" data-src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>"
                              alt="Image">
                            <?php endif; ?>
                            
                        </a>    
                        </div>
                        <div>
                            <p style="color: #222831;font-size: 14px;margin:0px!important;"><?php echo e($car_content->vendor->vendor_info->name); ?></p>
                            <p style="color: #586176; font-size: 12px;margin:0px!important;">
                              <svg width="15" height="15" fill="#1c9b40" viewBox="0 0 24 24" data-testid="shield-icon" class="BrandingStripstyled__TrustedDealerBadge-sc-n7l181-6 fEIxXh">
                                  <path fill="#1c9b40" d="M22.456 5.22a.75.75 0 00-.616-.69c-4.055-.728-5.747-1.254-9.531-2.963a.75.75 0 00-.618 0c-3.784 1.709-5.476 2.235-9.53 2.962a.75.75 0 00-.617.691c-.18 2.865.204 5.534 1.145 7.933a16.38 16.38 0 003.358 5.274c2.506 2.66 5.167 3.814 5.675 4.019a.75.75 0 00.563 0c.507-.205 3.168-1.36 5.675-4.019a16.379 16.379 0 003.351-5.274c.941-2.4 1.326-5.068 1.145-7.933zm-6.14 3.52l-5.194 6a.748.748 0 01-.535.26h-.03a.75.75 0 01-.526-.214l-2.306-2.26a.75.75 0 111.05-1.071l1.734 1.7 4.674-5.396a.75.75 0 111.134.982h-.001z"></path>
                              </svg>
                              <?php if($car_content->vendor->is_trusted == 1): ?>
                                <span>Trusted</span>
                              <?php endif; ?> 

                              <?php if($car_content->vendor->is_franchise_dealer == 1): ?>
                                Franchise Dealership 
                              <?php else: ?>
                                Independent Dealership
                              <?php endif; ?>

                              <?php 
                                $review_data = null;
                              ?>  

                              <?php if($car_content->vendor->google_review_id > 0 ): ?>
                                <?php
                                  $review_data = get_vendor_review_from_google($car_content->vendor->google_review_id , true);
                                ?>
                              <?php endif; ?>
                          
                              <?php if(!empty($review_data) && $review_data['total_reviews'] > 0 && $review_data['total_ratings'] > 0): ?>
                                <span> 
                                    <span class="star on"></span>  <?php echo e($review_data['total_ratings']); ?>/5
                                </span>
                              <?php endif; ?>

                            </p>
                      
                        </div>
                      </div>
                    </div>
                  <?php endif; ?>

                  <div class="w-100 h-full">
                    <div class="w-100 d-flex flex-md-row flex-column">
                      <div class="left-container" style="position: relative; cursor: pointer;">
                          <div class="imageSize" >

                            <?php if($car_content->is_featured == 1): ?>
                              <div class="sale-tag" style="border-bottom-right-radius: 0px;     background: #ff9e02;">Spotlight</div>
                            <?php endif; ?>
        
                            <!-- <?php if($car_content->is_sold == 1 || $car_content->status == 2 ): ?>
                                <div class="sold-badge">
                                    <span class="sold-text">Sold</span>
                                    <span class="sold-text">Sold</span>
                                    <span class="sold-text">Sold</span>
                                </div>
                            <?php endif; ?> -->

                          <a class="" href="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id])); ?>">

                            <img class="ls-is-cached  lazyloaded card-design"
                              style="transform: rotate(0deg); width: 100%; height: 240px; object-fit: cover;"
                              data-src=" <?php echo e($car_content->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path); ?>  "
                              alt="Product" onerror="this.onerror=null;this.src='<?php echo e(asset('assets/img/noimage.jpg')); ?>';"
                              src=" <?php echo e($car_content->vendor->vendor_type == 'normal' ? 
                              asset('assets/admin/img/car-gallery/' .$image_path) :  
                              env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path); ?>  ">
                          </a>
                            <?php if($car_content->deposit_taken == 1): ?>
                            <div class="reduce-tag">DEPOSIT TAKEN</div>
                            <?php endif; ?>
                           </div>
                            <?php if($car_content->vendor->vendor_type == 'dealer' && !empty($limited_images) && count($limited_images) == 3): ?>
                            <div class="d-flex gap-1 mt-1 w-100">
                              <?php $__currentLoopData = $limited_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="imageSize flex-fill">
                                  <img class="ls-is-cached lazyloaded card-design-smalls" 
                                    style="transform: rotate(0deg); height: 88px; width: 100%; object-fit: cover;" 
                                    data-src=" <?php echo e($car_content->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image); ?>  "
                                    alt="Product" onerror="this.onerror=null;this.src='http://localhost:8000/assets/img/noimage.jpg';"
                                    src=" <?php echo e($car_content->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image); ?>  "
                                  >
                                  </div>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </div>
                            <?php endif; ?>  
                            <?php if($car_content->is_sold == 1 ): ?>
                            <div style="position: absolute; top:0px; width: 100%; z-index: -1px; height: 100%; background: rgba(0,0,0,0.3)"></div>
                            <img src="assets/img/Sold.png"  alt="sold out" style="position: absolute;  left:0px; right:0px; width: 45%; z-index: 1px; top:30%;" class="mx-auto" ></img>
                            <?php endif; ?>
                          </div>
                      <div class="p-20 w-100 d-flex flex-column justify-content-between align-items-center">
                        <div class="w-100">
                          <h6 class="card-deal-turncate">
                          <a href="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id])); ?>">
                            <?php echo e(carBrand($car_content->brand_id)); ?> <?php echo e(carModel($car_content->car_model_id)); ?> <?php echo e($car_content->title); ?>

                          </a>
                          </h6>
                          <div class="d-flex gap-1  flex-wrap justify-content-start align-items-center">
                              
                              <?php if($car_content->created_at && $car_content->is_featured != 1): ?>
                                <p style="white-space: nowrap; ">
                                  <div style="border-radius: 100%; margin-right: -10px !important;"></div>
                                  <?php echo e(calculate_datetime($car_content->created_at)); ?>

                                </p>
                              <?php endif; ?>

                              <?php if($car_content->year): ?>
                                <p style="white-space: nowrap;">
                                  <div style=" width: 5px; height:5px; background: #7A7575; border-radius: 100%;"></div>
                                  <?php echo e($car_content->year); ?>

                                </p>
                              <?php endif; ?>

                              <?php if($car_content->engineCapacity && $car_content->car_content->fuel_type ): ?>
                                <p style="white-space: nowrap;  ">
                                  <div style=" width: 5px; height:5px; background: #7A7575; border-radius: 100%;"></div>
                                  <?php echo e(roundEngineDisplacement($car_content)); ?>

                                </p> 
                              <?php endif; ?>

                              <?php if($car_content->car_content->fuel_type ): ?>
                                <p style="white-space: nowrap;  ">
                                  <div style=" width: 5px; height:5px; background: #7A7575; border-radius: 100%;"></div>
                                  <?php echo e($car_content->car_content->fuel_type->name); ?>

                                </p>
                              <?php endif; ?>
                              
                              <?php if($car_content->mileage): ?>
                                <p style="white-space: nowrap;  ">
                                  <div style=" width: 5px; height:5px; background: #7A7575; border-radius: 100%;"></div>
                                  <?php echo e(number_format( $car_content->mileage )); ?> mi
                                </p>
                              <?php endif; ?>
                              
                              <?php if($car_content->city): ?>
                                <p style="white-space: nowrap;  ">
                                  <div style=" width: 5px; height:5px; background: #7A7575; border-radius: 100%;"></div>
                                  <?php echo e(Ucfirst($car_content->city)); ?>

                                </p> 
                              <?php endif; ?>
  
                          </div>

                          <?php if(!empty($car_content->warranty_duration)): ?>
                          <div class="mt-20" 
                              style="display: inline-block; padding: 3px 5px;border-radius: 5px; background: #ebebeb; font-size: 12px;color: #525252;
                              border: 1px solid #d6d6d6;
                              /* box-shadow: 0px 0px 5px gray; */">
                              <svg width="24" height="24" fill="#F3F4F7" viewBox="0 0 24 24" color="GREEN">
                                <path fill="currentColor" fill-rule="evenodd" d="M17.469 5.747a.71.71 0 01.068 1l-6.074 6.969a.71.71 0 11-1.07-.932l6.075-6.969a.71.71 0 011-.068zm4.289 0a.71.71 0 01.067 1.001L11.819 18.183a.709.709 0 01-1.025.045l-5.956-5.716a.71.71 0 11.982-1.024l5.42 5.203 9.517-10.877a.71.71 0 011-.066zm-19.55 7.18a.71.71 0 011.003 0l4.288 4.288a.71.71 0 01-1.003 1.003L2.208 13.93a.71.71 0 010-1.003z" clip-rule="evenodd"></path>
                              </svg>
                              <?php echo e($car_content->warranty_duration); ?> Warranty
                          </div>
                          <?php endif; ?>

                          <?php if($car_content->manager_special  == 1): ?>
                          <div class="mt-20" 
                              style="display: inline-block; padding: 3px 5px;border-radius: 5px; background: #ebebeb; font-size: 12px;color: #525252;
                              border: 1px solid #d6d6d6;
                              /* box-shadow: 0px 0px 5px gray; */">
                              <!-- <svg width="24" height="24" fill="none" viewBox="0 0 24 24" color="GREEN"> -->
                                <!-- <path fill="currentColor" fill-rule="evenodd" d="M17.469 5.747a.71.71 0 01.068 1l-6.074 6.969a.71.71 0 11-1.07-.932l6.075-6.969a.71.71 0 011-.068zm4.289 0a.71.71 0 01.067 1.001L11.819 18.183a.709.709 0 01-1.025.045l-5.956-5.716a.71.71 0 11.982-1.024l5.42 5.203 9.517-10.877a.71.71 0 011-.066zm-19.55 7.18a.71.71 0 011.003 0l4.288 4.288a.71.71 0 01-1.003 1.003L2.208 13.93a.71.71 0 010-1.003z" clip-rule="evenodd"></path> -->
                              <!-- </svg> -->
                              Manage Special
                          </div>
                          <?php endif; ?>
                          
                          <!-- <?php if($car_content->is_sale == 1): ?>
                          <div class="mt-20" 
                              style="display: inline-block; padding: 3px 5px;border-radius: 5px; background: #ebebeb; font-size: 12px;color: #525252;
                              border: 1px solid #d6d6d6;
                              /* box-shadow: 0px 0px 5px gray; */">
                              Sale
                          </div>
                          <?php endif; ?> -->
                          
                          <?php if($car_content->reduce_price == 1): ?>
                          <div class="mt-20" 
                              style="display: inline-block; padding: 3px 5px;border-radius: 5px; background: #ebebeb; font-size: 12px;color: #525252;
                              border: 1px solid #d6d6d6;
                              /* box-shadow: 0px 0px 5px gray; */">
                              Reduced
                          </div>
                          <?php endif; ?>
                          
                        </div>
                          
                        <div class="w-100 mt-20 mt-sm-0 d-flex justify-content-between align-items-center">
                          <div class="w-100 d-flex gap-1">
                              <?php if($car_content->price != null): ?>
                              <div class="price-font" style="font-size: 32px;line-height: 40px; color: rgb(34, 40, 49);font-weight: 700;">
                                <?php if($car_content->previous_price && $car_content->previous_price < $car_content->price ): ?>
                                  <strike style="font-weight: 300;color: red;font-size: 14px;    float: left;"><?php echo e(symbolPrice($car_content->price)); ?></strike> 
                                  <div style="color:black;"> <?php echo e(symbolPrice($car_content->previous_price)); ?></div>
                                <?php else: ?>
                                  <?php echo e(symbolPrice($car_content->price)); ?>   
                                <?php endif; ?>
                              
                              </div>
                              <?php endif; ?>

                              <div class="pmon-font" 
                              style="font-size: 16px; line-height: 40px; color: rgb(34, 40, 49);font-weight: 400;padding-top:5px;">
                                <?php
                                  // Get loan amount data
                                  $loanAmount = calulcateloanamount(!empty($car_content->previous_price && $car_content->previous_price < $car_content->price) ? $car_content->previous_price : $car_content->price)[0];

                                  // Remove span tags and replace p/w, p/m with 'week' and 'month'
                                  $formattedLoanAmount = strip_tags($loanAmount);
                                  $formattedLoanAmount = str_replace(['p/w', 'p/m'], ['week', 'month'], $formattedLoanAmount);

                                  // Extract the number and the period (week/month) using regex or simple logic
                                  preg_match('/(\d+)\s*\/?(week|month)/', $formattedLoanAmount, $matches);
                                  $number = $matches[1] ?? ''; // The number (1, 2, etc.)
                                  $period = $matches[2] ?? ''; // The period ('week' or 'month')
                                ?>

                                <?php if($car_content->category_id == 44 || $car_content->category_id == 45 
                                || $car_content->parent_id == 24 || $car_content->main_category_id == 24): ?>

                                  <?php if($car_content->price>=5000): ?>

                                    
                                    <span class="text-18-categ-perWeek" style="color: black;">
                                      From <?php echo e(symbolPrice($number)); ?>

                                    </span>
                                  
                                    <span class="text-18-categ-perWeek" style="color: gray;">
                                        /<?php echo e($period); ?>

                                    </span>
                                    
                                  <?php endif; ?>
          
                                <?php endif; ?>
                            </div>
                          </div>
                          

                          <?php if(Auth::guard('vendor')->check()): ?>
                          <?php
                            $user_id = Auth::guard('vendor')->user()->id;
                            $checkWishList = checkWishList($car_content->id, $user_id);
                          ?>
                          <?php else: ?>
                            <?php
                              $checkWishList = false;
                            ?>
                          <?php endif; ?>
                          <div class="d-sm-block d-none">
                            <a  href="javascript:void(0);"
                                onclick="addToWishlist(<?php echo e($car_content->id); ?>)"
                                class="shadow" data-tooltip="tooltip"
                                data-bs-placement="right"
                                title="<?php echo e($checkWishList == false ? __('Save Ads') : __('Saved')); ?>"
                                style="border-radius:50%;height: 35px; width:35px; cursor: pointer;
                                      display: flex !important; justify-content: center !important; 
                                      align-items: center !important;">
                                <?php if($checkWishList == false): ?>
                                  <i class="fal fa-heart" style="color:#35373b !important;font-size:22px;"></i>
                                <?php else: ?>
                                  <i class="fal fa-heart"  aria-hidden="true" style="color:#35373b !important;font-size:22px;"></i>
                                <?php endif; ?>
                            </a>
                          </div>       
                        </div> 
                        
                      </div>
                    </div>   
                  </div>
                  <?php if($car_content->is_sale == 1 && $car_content->is_sold != 1): ?>
                  <img src="assets/img/saletag.svg" width="120px" style="position: absolute; width: 60px; top:-13px; right:10px;" alt="sale"></img>
                       <?php endif; ?>           
                </div>      
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
              <!-- Limited Pagination -->
              <div class="pagination us_pagination_filtered mb-40 justify-content-center" id="pagination">
    <?php if($car_contents->lastPage() > 1): ?>
        <ul class="pagination">
            <?php if($car_contents->currentPage() > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo e($car_contents->url(1)); ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php
                $halfVisiblePages = 2; // Maximum of 5 visible pages (2 before and 2 after current page)
                $start = max(1, $car_contents->currentPage() - $halfVisiblePages);
                $end = min($car_contents->lastPage(), $car_contents->currentPage() + $halfVisiblePages);
            ?>

            <?php for($page = $start; $page <= $end; $page++): ?>
                <li class="page-item <?php echo e($car_contents->currentPage() == $page ? 'active' : ''); ?>">
                    <a class="page-link" href="<?php echo e($car_contents->url($page)); ?>"><?php echo e($page); ?></a>
                </li>
            <?php endfor; ?>

            <?php if($car_contents->currentPage() < $car_contents->lastPage()): ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo e($car_contents->url($car_contents->currentPage() + 1)); ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>
</div>
<!-- end of pagination --->
      <?php endif; ?>
<?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/car/new_ads_card_list.blade.php ENDPATH**/ ?>