
    <?php $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
      $car_content = $car->car_content;
      if (is_null($car_content)) {
          $car_content = $car->car_content()->first();
      }
     
    ?>
    <?php if($car_content): ?>                        
  <div class="card ">
      <div class="card-header">
      <div class="d-flex justify-content-between">
      <div class=" d-inline-block text-left">
      <?php
      $forExpired ="";
      $forExpired = noDaysLeftByAd($car->package_id,$car->created_at);
       
      ?>
      <?php if($car->is_sold == 1 || $car->status == 2 ): ?>
      <span class="text-warning"><?php echo e('Sold'); ?></span>
      <?php else: ?>
      
      <?php if($car->status==3): ?>
      <?php echo e('Withdraw'); ?> 
      <?php endif; ?>
      
      <?php if($car->status==0): ?>
        Needs Payment (Not Listed)
      <?php elseif($car->status==1 || $car->status==4 ): ?>
      <?php echo e(noDaysLeftByAd($car->package_id,$car->created_at)); ?>

     <?php endif; ?>
     <?php endif; ?>
    </div>
        <h5 class="text-right">
        <?php if($car->is_sold == 0 && $car->status != 2 ): ?>
        <div class="dropdown">
        <a style="color:#1572E8; font-weight:100; font-size:15px;" class=" dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Manage
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <?php if($car->status==0 && $forExpired !="Expired"): ?>
        <a class="dropdown-item mb-2" href = "<?php echo e(route('vendor.package.payment_method',  $car->id)); ?>">Pay Now</a>
        <?php endif; ?>
        <?php if($car->status==1 || $car->status==4 && $forExpired !="Expired"): ?>
        <a class="dropdown-item mb-2" href = "<?php echo e(route('vendor.cars_management.ad_status', ['withdraw',$car->id])); ?>">Withdraw</a>
        <?php endif; ?>
        <?php if( $forExpired=="Expired"  && ( !empty($car->package_id) && in_array($car->status , [0,1,4]) && $car->is_sold != 1 ) ): ?>
        <a class="dropdown-item mb-2"  href = "<?php echo e(route('vendor.package.payment_boost',  [$car->car_content->main_category_id,$car->id])); ?>">Republish</a>
        <?php endif; ?>
        
        <?php if( $forExpired != "Expired" && !in_array($car->status , [0,1,4])  && $car->status == 3  && $car->is_sold != 1  ): ?>
            <a class="dropdown-item mb-2"  href = "<?php echo e(route('vendor.cars_management.ad_status', ['relist',$car->id])); ?>">Relist</a>
        <?php endif; ?>
                    
        <?php if($forExpired!="Expired"): ?>
        <a class="dropdown-item mb-2" href="<?php echo e(route('vendor.cars_management.edit_car', $car->id)); ?>">Edit</a>
        <?php endif; ?>   
        
        <?php if($car->status!=0): ?>
            <?php if($car->is_sold == 0): ?>
                <a class="dropdown-item mb-2" href="javascript:void(0);"   onclick="removeThisAd( 'sold' , <?php echo e($car->id); ?> )">Mark as sold</a>
            <?php endif; ?>
        <?php endif; ?>
        
        <a class="dropdown-item mb-2" href="javascript:void(0);"   onclick="removeThisAd( 'removed' , <?php echo e($car->id); ?> )">Remove</a>
        
        
        </div>
        </div>
        <?php endif; ?>
        
  </h5>
      </div>
      </div>
      <div class="card-body" style="padding: 0;">  
    <div class="row no-gutters">
      <div class="col-md-4 col-sm-*"> 
      <div class="image-container">
      <img class=" us_design"  src="<?php echo e($car->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$car->feature_image) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $car->feature_image); ?>" alt="Ad Image">
      </div>
       </div>
       <div class="col-md-8 col-sm-*">
        
        <label class="card-title us_mrg" >
            <?php
              $car_content = $car->car_content;
              
              if (is_null($car_content)) 
              {
                  $car_content = $car->car_content()->first();
              }
              
            ?>
            <a href="<?php echo e(route('frontend.car.details', [catslug($car_content->category_id), 'slug' => $car_content->slug, 'id' => $car->id])); ?>"
              target="_blank">
              <?php echo e(strlen(@$car_content->title) > 50 ? mb_substr(@$car_content->title, 0, 50, 'utf-8') . '...' : @$car_content->title); ?>

            </a>
        </label>
          
          
           <div style="" class="<?php if( !empty($car->package_id) && in_array($car->status , [0,1]) && $car->is_sold != 1 ): ?> us_absolut_position_with_boost <?php else: ?> us_absolut_position <?php endif; ?> us_pro_mrg"> 
            <strong  class="us_mrg" style="color: black;font-size: 20px;">
                <?php if($car->previous_price && $car->previous_price < $car->price ): ?>
                    <strike style="font-weight: 300;color: gray;font-size: 14px;"><?php echo e(symbolPrice($car->price)); ?></strike> . <?php echo e(symbolPrice($car->previous_price)); ?>

                <?php else: ?>
                    <?php echo e(symbolPrice($car->price)); ?>

                <?php endif; ?>
            </strong>
        </div>
        
        <div style="right: 0%;" class="<?php if( !empty($car->package_id) && in_array($car->status , [0,1,4]) && $car->is_sold != 1 ): ?> us_absolut_position_with_boost <?php else: ?> us_absolut_position <?php endif; ?> us_footer_div">
          
            
            <span style="float:right;    margin-right: 15px;font-size: 16px;color: #a7a7a7;" data-tooltip="tooltip" data-bs-placement="top" title="How many times Ad saved" >
                <i class="fa fa-heart" aria-hidden="true" style="font-size: 20px;"></i>  <?php echo e(($car->wishlists()->get()->count() > 0 ) ? $car->wishlists()->get()->count() : 'No'); ?> saves
            </span>
            
            <span style="float:right;    margin-right: 15px;font-size: 16px;color: #a7a7a7;" data-tooltip="tooltip" data-bs-placement="top" title="Total Views"  >
                <i class="fa fa-eye" aria-hidden="true" style="font-size: 20px;"></i>  <?php echo e(($car->visitors()->get()->count() > 0 ) ? $car->visitors()->get()->count() : 'No'); ?> views
            </span>
        </div>
            
            
        </div>
      </div>
    </div>
    
     <?php if( !empty($car->package_id) && in_array($car->status , [0,1,4]) && $car->is_sold !=1 ): ?>
        <div style="text-align:right; border-top: 1px solid #ebe8e8 !important;" class="card-footer text-right">
        <?php if($car->status==0): ?>
        <a href = "<?php echo e(route('vendor.package.payment_method',  $car->id)); ?>" style="color:#1572E8; font-weight:300; font-size:17px; margin-right:20px;">Pay Now</a>
        <?php endif; ?> 
        <?php if($car->status==1 || $car->status==4 ): ?>
        <a href = "<?php echo e(route('vendor.package.payment_boost',  [$car->car_content->main_category_id,$car->id])); ?>" style="color:#EE2C7B; font-weight:400; font-size:17px; margin-right:30px;">
            <i class="fal fa-paper-plane"></i> Boost</a>
        <?php endif; ?>
        </div> 
     <?php endif; ?>  
  
  </div>
  <?php endif; ?>  
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/vendors/car/indexajax.blade.php ENDPATH**/ ?>