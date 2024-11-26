<div class="col-xl-4 col-md-6" data-aos="fade-up">
    <div class="product-default border p-15 mb-25">
     
        <a href="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($ad_id->car_content->category_id),'slug' => $ad_id->car_content->slug, 'id' => $ad_id->id])); ?>"
          class="lazy-container ratio ratio-2-3">
          <img class="lazyload"
            src="https://listit.im/assets/admin/img/car-gallery/<?php echo e($ad_id->feature_image); ?>"
            alt="<?php echo e(optional($ad_id)->title); ?>">
        </a>
     
      <div class="product-details">
        
        <div class="d-flex align-items-center justify-content-between mb-10">
          <h5 class="product-title mb-0">
            <a href="https://listit.im/<?php echo e(route('frontend.car.details', ['cattitle' => catslug($ad_id->car_content->category_id),'slug' => $ad_id->car_content->slug, 'id' => $ad_id->id])); ?>"
              title="<?php echo e(optional($ad_id->car_content)->title); ?>"><p style="color:#455056; font-size:16px; font-weight:bold; line-height:24px; margin:0; font-family:'Rubik',sans-serif; "><?php echo e(optional($ad_id->car_content)->title); ?></p></a>
          </h5>
        </div>
       
        <div class="product-price mb-10">
          <h6 style="color:#455056; font-size:14px;line-height:24px; margin:0; font-family:'Rubik',sans-serif; ">
            <?php echo e(symbolPrice($ad_id->price)); ?>

          </h6>
          <?php if(!is_null($ad_id->previous_price)): ?>
            <span class="old-price font-sm">
              <?php echo e(symbolPrice($ad_id->previous_price)); ?></span>
          <?php endif; ?>
        </div>
      </div>
    </div>
</div><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/email/ads/newad.blade.php ENDPATH**/ ?>