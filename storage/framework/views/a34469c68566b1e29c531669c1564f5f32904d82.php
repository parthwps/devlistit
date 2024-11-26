<?php $__env->startSection('pageHeading'); ?>
  <?php if(!empty($pageHeading)): ?>
    <?php echo e($pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('Signup')); ?>

  <?php else: ?>
    <?php echo e(__('Signup')); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('metaKeywords'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_keywords_vendor_signup); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaDescription'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_description_vendor_signup); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php if ($__env->exists('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Ads Management'),
  ])) echo $__env->make('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Ads Management'),
  ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="user-dashboard pt-20 pb-60">
    <div class="container">
      
  
      
  <div class="row gx-xl-5">
  
       <?php if ($__env->exists('vendors.partials.side-custom')) echo $__env->make('vendors.partials.side-custom', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   
    <div class="col-md-9">
  <?php
    $current_package = App\Http\Helpers\VendorPermissionHelper::packagePermission(Auth::guard('vendor')->user()->id);
  ?>
  <?php if($current_package != '[]'): ?>
    <?php if(vendorTotalAddedCar() > $current_package->number_of_car_add): ?>
      <?php
        $car_add = 'over';
      ?>
      <div class="mt-2 mb-4">
        <div class="alert alert-danger text-dark">
          <ul>
            <li><?php echo e(__('You have added total ') . vendorTotalAddedCar()); ?> <?php echo e(__(' cars.')); ?></li>
            <li><?php echo e(__('Your current package supports') . ' ' . $current_package->number_of_car_add . ' cars.'); ?> </li>
            <li><?php echo e(__('You have to remove ')); ?>

              <?php echo e(vendorTotalAddedCar() - $current_package->number_of_car_add . __(' cars  to enable car editing.')); ?></li>
          </ul>
        </div>
      </div>
    <?php else: ?>
      <?php
        $car_add = '';
      ?>
    <?php endif; ?>
    <?php if(vendorTotalFeaturedCar() > $current_package->number_of_car_featured): ?>
      <?php
        $car_featured = 'over';
      ?>
      <div class="mt-2 mb-4">
        <div class="alert alert-danger text-dark">
          <ul>
            <li><?php echo e(__('You have total  ') . vendorTotalFeaturedCar() . ' featured cars.'); ?></li>
            <li>
              <?php echo e(__('With your current package you can feature ') . $current_package->number_of_car_featured . __(' cars.')); ?>

            </li>
            <li><?php echo e(__('Your cars has been removed from featured cars section of our website.')); ?>

            </li>
            <li><?php echo e(__('You have to unfeature ')); ?>

              <?php echo e(vendorTotalFeaturedCar() - $current_package->number_of_car_featured . __(' cars  to show your cars in featured cars section of our website.')); ?>

            </li>
          </ul>

        </div>
      </div>
    <?php else: ?>
      <?php
        $car_featured = '';
      ?>
    <?php endif; ?>
  <?php else: ?>
    <?php
      $can_car_add = 0;
      $car_add = '';
      $car_featured = 'over';
      
      $pendingMemb = \App\Models\Membership::query()
          ->where([['vendor_id', '=', Auth::id()], ['status', 0]])
          ->whereYear('start_date', '<>', '9999')
          ->orderBy('id', 'DESC')
          ->first();
      $pendingPackage = isset($pendingMemb) ? \App\Models\Package::query()->findOrFail($pendingMemb->package_id) : null;
    ?>
    <?php if($pendingPackage): ?>
      <div class="alert alert-warning text-dark">
        <?php echo e(__('You have requested a package which needs an action (Approval / Rejection) by Admin. You will be notified via mail once an action is taken.')); ?>

      </div>
      <div class="alert alert-warning text-dark">
        <strong><?php echo e(__('Pending Package') . ':'); ?> </strong> <?php echo e($pendingPackage->title); ?>

        <span class="badge badge-secondary"><?php echo e($pendingPackage->term); ?></span>
        <span class="badge badge-warning"><?php echo e(__('Decision Pending')); ?></span>
      </div>
    <?php else: ?>
      <!-- <div class="alert alert-warning text-dark">
        <?php echo e(__('Your membership is expired. Please purchase a new package / extend the current package.')); ?>

      </div> -->
    <?php endif; ?>
    <?php if ($__env->exists('vendors.verify')) echo $__env->make('vendors.verify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <?php endif; ?>




  <div class="row">
    <div class="col-md-12">
    <div class="m-4">
    <h4>Recently Viewed Ads</h4>
</div>
  </div>
  </div>

  <div class="row">
      <?php
        $car_contents = $cars;
      ?>
    
    
     <?php if(empty($car_contents)): ?>
                <div class="col-12" data-aos="fade-up"> <center> <h4>No browsing history</h4> </center> </div>
            <?php else: ?>
            
<?php
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
                $image_path = $car_content->galleries[0]->image;
                $rotation = $car_content->galleries[0]->rotation_point;
            }
           
            ?>
            
            <div class="col-xl-4 col-md-6" data-aos="fade-up">


           
            <div class="product-default us_set_height set_height border p-15 mb-25" data-id="<?php echo e($car_content->id); ?>" style="box-shadow: 0px 0px 10px #b3b3b3;border-radius: 10px;">
            
           
                    
               
         <?php if($car_content->is_sold == 1): ?>
       <div class="overlay"></div>
      <?php endif; ?>     
                
                
            <figure class="product-img mb-15">
            <a href="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id),'slug' => $car_content->car_content->slug, 'id' => $car_content->id])); ?>"
            class="lazy-container ratio ratio-2-3">
            <img class="lazyload"
            data-src="<?php echo e($car_content->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path); ?>"
            alt="<?php echo e(optional($car_content)->title); ?>" style="transform: rotate(<?php echo e($rotation); ?>deg);" >
            </a>

         

            </figure>

            
                 <div class="product-details" style="cursor:pointer;"   >
                
                  
                    <span class="product-category font-xsm" onclick="window.location='<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id), 'slug' => $car_content->car_content->slug, 'id' => $car_content->id])); ?>'">
                        
                           <h5 class="product-title mb-0">
                        <a href="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id),'slug' => $car_content->car_content->slug, 'id' => $car_content->id])); ?>"
                          title="<?php echo e(optional($car_content)->title); ?>" class="us_grid_widths">
                            <?php echo e(carBrand($car_content->car_content->brand_id)); ?>

                         <?php echo e(carModel($car_content->car_content->car_model_id)); ?> <?php echo e(optional($car_content->car_content)->title); ?>

                         </a>
                      </h5>
                      
                      
                        </span>
                        
                        <div class="d-flex align-items-center justify-content-between ">
                   
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
                        class="btn us_wishlist btn-icon "
                        data-tooltip="tooltip" data-bs-placement="right"
                        title="<?php echo e($checkWishList == false ? __('Save Ad') : __('Saved')); ?>" style="position: absolute;
                        right: 0px;
                        bottom: 15%;
                        background:white;
                        color:red !important;
                        z-index: 10;
                        border: none;
                        color: white;
                        font-size: 25px;">
                        <?php if($checkWishList == false): ?>
                            <i class="fal fa-heart"></i>
                        <?php else: ?>
                            <i class="fa fa-heart" aria-hidden="true"></i>
                        <?php endif; ?>
                      </a>
                     
                      <a href="javascript:void(0);"  class="us_grid_shared" onclick="openShareModal(this)" 
                        data-url="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id), 'slug' => $car_content->car_content->slug, 'id' => $car_content->id])); ?>"
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
                    
                    <div class="author us_child_div" style="cursor:pointer;" onclick="window.location='<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id), 'slug' => $car_content->car_content->slug, 'id' => $car_content->id])); ?>'" >
                     
                         <span style="line-height: 15px;font-size: 14px;">
                             
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
                    
                    <?php if(!$car_content->year && !$car_content->mileage && !$car_content->engineCapacity): ?>
                    
                    <div style="display:flex;margin-top: 1.5rem;">
                        
                        <!--<?php if($car_content->manager_special  == 1): ?>-->
                        <!--<div class="price-tag" style="padding: 3px 10px;border-radius:5px; background:#25d366;font-size: 10px;" > Manage Special</div>-->
                        <!--<?php endif; ?>-->
                        
                        
                        <!--<?php if($car_content->is_sale == 1): ?>-->
                        
                        <!--<div class="price-tag" style="padding: 3px 10px;border-radius:5px;margin-left: 10px;background: #434d89;font-size: 10px;" >  Sale </span></div>-->
                        
                        <!--<?php endif; ?>-->
                        
                        
                        <!--<?php if($car_content->reduce_price == 1): ?>-->
                        
                        <!--<div class="price-tag" style="padding: 3px 10px;border-radius:5px;margin-left: 10px;background:#ff4444;font-size: 10px;" >    Reduced </span></div>-->
                        
                        <!--<?php endif; ?>-->
                    
                    </div>
                    
                    <?php endif; ?> 
                    
                     <ul class="product-icon-list us_absolute_position_front list-unstyled d-flex align-items-center us_absolute_position" style="margin-top: 10px;"   onclick="window.location='<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id), 'slug' => $car_content->car_content->slug, 'id' => $car_content->id])); ?>'" >
                      
                        <?php if($car_content->price != null): ?>
                        <li class="icon-start us_price_icon" data-tooltip="tooltip" data-bs-placement="top"
                        title="Price">
                        <b style="color: gray;float: left;">Price</b>
                       
                        <strong  class="us_mrg" style="color: black;font-size: 20px;">
                        <?php if($car_content->previous_price && $car_content->previous_price < $car_content->price): ?>
                        <strike style="font-weight: 300;color: red;font-size: 14px;margin-left: 15px;float: left;" class="us_mr_15"><?php echo e(symbolPrice($car_content->price)); ?></strike> 
                        
                        <div> <?php echo e(symbolPrice($car_content->previous_price)); ?></div>
                        <?php else: ?>
                        <strike style="font-weight: 300;color: white;font-size: 14px;    float: left;">  </strike> <div>  <?php echo e(symbolPrice($car_content->price)); ?>  </div> 
                        <?php endif; ?>
                        </strong>
                        </li>
                        <?php endif; ?>
                        
                        <?php if($car_content->price != null && $car_content->price >= 1000): ?>
                        <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                        title="">
                        <b style="color: gray;">From</b>
                       
                        <strong style="color: black;font-size: 20px;">
                        
                        <?php echo calulcateloanamount(!empty($car_content->previous_price && $car_content->previous_price < $car_content->price) ? $car_content->previous_price : $car_content->price)[0]; ?>

                        
                        </strong>
                        </li>
                        <?php endif; ?>
                      
                    </ul>
                  
                  </div>
                </div><!-- product-default -->
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
             <div class="pagination us_pagination_filtered mb-40 justify-content-center" data-aos="fade-up">
            <?php echo e($car_contents->links()); ?>

          </div>
          
          
          </div>
        
        </div>
        <?php endif; ?>
        
        
        
    </div>
    
    
  </div>
</div>
</div></div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin-main.css')); ?>">
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
  <?php $__env->stopSection(); ?>

<?php echo $__env->make("frontend.layouts.layout-v$settings->theme_version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/vendors/recently-view.blade.php ENDPATH**/ ?>