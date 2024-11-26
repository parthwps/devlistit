<?php
  $version = $basicInfo->theme_version;
?>


<?php $__env->startSection('pageHeading'); ?>
  <?php echo e($pageInfo->title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaKeywords'); ?>
  <?php echo e($pageInfo->meta_keywords); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaDescription'); ?>
  <?php echo e($pageInfo->meta_description); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php if ($__env->exists('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => $pageInfo->title,
  ])) echo $__env->make('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => $pageInfo->title,
  ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <!--====== Start FAQ Section ======-->
  <section class="blog-area blog-1 ptb-100">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="tinymce-content">
            <?php echo $pageInfo->content; ?>

          </div>
        </div>
      </div>
      <?php if(!empty(showAd(3))): ?>
        <div class="text-center">
          <?php echo showAd(3); ?>

        </div>
      <?php endif; ?>
    </div>
  </section>
  <!--====== End FAQ Section ======-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make("frontend.layouts.layout-v$version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/custom-page.blade.php ENDPATH**/ ?>