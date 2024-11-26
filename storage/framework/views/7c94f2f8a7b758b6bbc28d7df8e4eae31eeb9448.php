<?php
  $version = $basicInfo->theme_version;
?>

<?php $__env->startSection('pageHeading'); ?>
  <?php echo e(__('Ads')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaKeywords'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_keyword_cars); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaDescription'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_description_cars); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
 


  <div class="listing-grid-area pt-40 pb-40">
    <div class="container">
      <div class="row gx-xl-5" style="margin-top: 3.5rem;">
          
          <div class="col-md-12 mb-30" style="padding-left: 13px;" >
              <h3>Listit Sitemap</h3>
          </div>
          
          <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-12 mb-30" style="padding-left: 13px;">
                 <b> <a href="<?php echo e(route('frontend.cars' , ['category' => $category->slug])); ?>"><?php echo e($category->name); ?></a></b>
            </div>
            
            <?php if($category->children): ?>
                <?php echo $__env->make('frontend.car.category-list', ['categories' => $category->children  ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  </div>
  
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>

  'use strict';

  const baseURL = "<?php echo e(url('/')); ?>";
  
  
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("frontend.layouts.layout-v$version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/car/sitemap.blade.php ENDPATH**/ ?>