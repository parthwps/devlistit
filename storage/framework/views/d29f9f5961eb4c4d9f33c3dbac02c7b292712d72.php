<div class="row">
            <?php
              $car_contents = $related_cars;
              $admin = App\Models\Admin::first();
             
            ?>
            <?php $__currentLoopData = $car_contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car_content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

             <?php
         
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
           
            ?>
            
            <div class="col-xl-6 col-md-6" data-aos="fade-up">

            <?php if($car_content->is_sale == 1): ?>
            <div class="sale-tag" style="    border-top-left-radius: 10px;">Sale</div>
            <?php endif; ?>

            
            <?php if($car_content->is_featured == 1): ?>
            <div class="product-default border p-15 mb-25 us_custom_height" data-id="<?php echo e($car_content->id); ?>" style="box-shadow: 0px 0px 10px #b3b3b3;border-radius: 10px;border: 5px solid #ff9e02 !important;">
            
            <?php else: ?>
            <div class="product-default border p-15 mb-25 us_custom_height " data-id="<?php echo e($car_content->id); ?>" style="box-shadow: 0px 0px 10px #b3b3b3;border-radius: 10px;">
            
            <?php endif; ?>
                    
            <figure class="product-img mb-15">
            <a href="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id])); ?>"
            class="lazy-container ratio ratio-2-3">
            <img class="lazyload"
            data-src="<?php echo e((!empty($car_content->vendor->vendor_type) && $car_content->vendor->vendor_type == 'normal')  ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path); ?>"
            alt="<?php echo e(optional($car_content)->title); ?>" style="transform: rotate(<?php echo e($rotation); ?>deg);"  onerror="this.onerror=null;this.src='<?php echo e(asset('assets/img/noimage.jpg')); ?>';" >
            </a>

            <?php if($car_content->deposit_taken  == 1): ?>
            <div class="reduce-tag">DEPOSIT TAKEN</div>
            <?php endif; ?>


            </figure>

                  <div class="product-details" style="cursor:pointer;"   >
                
                  
                    <span class="product-category font-xsm">
                        
                           <h5 class="product-title mb-0">
                        <a href="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id])); ?>"
                          title="<?php echo e(optional($car_content)->title); ?>"><?php echo e(carBrand($car_content->brand_id)); ?>

                         <?php echo e(carModel($car_content->car_model_id)); ?> <?php echo e(optional($car_content)->title); ?></a>
                      </h5>
                      
                      
                        </span>
                    <div class="d-flex align-items-center justify-content-between mb-10">
                   
                      
                      
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
                      
                        <a href="javascript:void(0);"
                        onclick="addToWishlist(<?php echo e($car_content->id); ?>)"
                        class="btn btn-icon <?php echo e($checkWishList == false ? '' : 'wishlist-active'); ?>"
                        data-tooltip="tooltip" data-bs-placement="right"
                        title="<?php echo e($checkWishList == false ? __('Save Ads') : __('Saved')); ?>" style="background-color: transparent !important;
                        position: absolute;
                        bottom:15px;
                        z-index: 999;
                        border: none;
                        color: red !important;
                        font-size: 20px;
                        right: 0;">
                        	<?php if($checkWishList == false): ?>
                            <i class="fal fa-heart"></i>
                        <?php else: ?>
                            <i class="fa fa-heart" aria-hidden="true"></i>
                        <?php endif; ?>
                      </a>
                     
                     <a href="javascript:void(0);" onclick="openShareModal(this)" 
                        data-url="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id])); ?>"
                        style="background: transparent;
                        position: absolute;
                        right: 50px;
                        bottom:11px;
                        z-index: 999;
                        border: none;
                        color: #1b87f4;
                        font-size: 25px;" ><i class="fa fa-share-alt" aria-hidden="true"></i>
                        </a>
                        
                       
                    </div>
                    <div class="author mb-10 us_child_dv" style="cursor:pointer;" onclick="window.location='<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->category_id), 'slug' => $car_content->slug, 'id' => $car_content->id])); ?>'" >
                     
                         <span style="line-height: 20px;">
                             
                             <?php if($car_content->year): ?>
                                <?php echo e($car_content->year); ?> 
                             <?php endif; ?>
                             
                             <?php if($car_content->engineCapacity && $car_content->car_content->fuel_type ): ?>
                              <b class="us_dot"> - </b>   <?php echo e(roundEngineDisplacement($car_content)); ?> 
                             <?php endif; ?>
                             
                             <?php if($car_content->car_content->fuel_type ): ?>
                              <b class="us_dot"> - </b>   <?php echo e($car_content->car_content->fuel_type->name); ?> 
                             <?php endif; ?>
                             
                             <?php if($car_content->mileage): ?>
                               <b class="us_dot"> - </b>    <?php echo e(number_format( $car_content->mileage )); ?> mi 
                             <?php endif; ?>
                             
                             <?php if($car_content->created_at && $car_content->is_featured != 1): ?>
                                <b class="us_dot"> - </b> <?php echo e(calculate_datetime($car_content->created_at)); ?> 
                             <?php endif; ?>
                             
                             <?php if($car_content->city): ?>
                                <b class="us_dot"> - </b> <?php echo e(Ucfirst($car_content->city)); ?> 
                             <?php endif; ?>
                               
                        </span>
                    
                    </div>
                    
                    <div style="display:flex;margin-top: 0.5rem;margin-bottom: 0.5rem;">
                        
                        <?php if($car_content->manager_special  == 1): ?>
                        <div class="price-tag" style="padding: 3px 10px;border-radius:5px; background:#25d366;font-size: 8px;" > Manage Special</div>
                        <?php endif; ?>
                        
                        
                        <?php if($car_content->is_featured == 1): ?>
                        
                        <div class="price-tag" style="padding: 3px 10px;border-radius:5px;margin-left: 10px;background:#ff9e02;font-size: 8px;" >  Spotlight </span></div>
                        
                        <?php endif; ?>
                        
                        
                        <?php if($car_content->reduce_price == 1): ?>
                        
                        <div class="price-tag" style="padding: 3px 10px;border-radius:5px;margin-left: 10px;background:#ff4444;font-size: 8px;" >    Reduced </span></div>
                        
                        <?php endif; ?>
                    
                    </div>
                    
                   
                    <ul class="product-icon-list  list-unstyled d-flex align-items-center" style="position: absolute;bottom: 10px;">
                      
                    <?php if($car_content->price != null): ?>
                        <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                        title="Price">
                        <b style="color: gray;">Price</b>
                        <br>
                        <strong  class=" us_font_price" style="color: black;margin-left: 0;">
                        <?php if($car_content->previous_price && $car_content->previous_price < $car_content->price): ?>
                        <strike style="font-weight: 300;color: red;font-size: 14px;    float: left;"><?php echo e(symbolPrice($car_content->price)); ?></strike> <div> <?php echo e(symbolPrice($car_content->previous_price)); ?></div>
                        <?php else: ?>
                         <?php echo e(symbolPrice($car_content->price)); ?>

                        <?php endif; ?>
                        </strong>
                        </li>
                        <?php endif; ?>
                        
                        <?php if($car_content->price != null && $car_content->price >= 1000): ?>
                        <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                        title="">
                        <b style="color: gray;">From</b>
                        <br>
                        <strong style="color: black;" class="us_font_price">
                        
                        <?php echo calulcateloanamount(!empty($car_content->previous_price && $car_content->previous_price < $car_content->price ) ? $car_content->previous_price : $car_content->price)[0]; ?>

                        
                        </strong>
                        </li>
                        <?php endif; ?>
                      
                    </ul>
                  
                      
                     
                  </div>
                </div><!-- product-default -->
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
          
        <style>
            @media screen and (max-width: 480px) {
            .go-top {
            bottom: 70px !important;
            }
            .whatsapp-button 
            {
            bottom: 70px !important; 
            }
            }
        </style><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/car/related_ads.blade.php ENDPATH**/ ?>