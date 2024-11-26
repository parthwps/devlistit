<?php
  $basicInfo = App\Models\BasicSettings\Basic::select('breadcrumb', 'theme_version')->firstOrFail();
  $version = $basicInfo->theme_version;
?>


<?php $__env->startSection('pageHeading'); ?>
  <?php echo e(__('404')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
  <?php if ($__env->exists('frontend.partials.breadcrumb', [
      'breadcrumb' => $basicInfo->breadcrumb,
      'title' => __('404'),
  ])) echo $__env->make('frontend.partials.breadcrumb', [
      'breadcrumb' => $basicInfo->breadcrumb,
      'title' => __('404'),
  ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <!--====== Start Error Section ======-->
  <section class="error-area ptb-100 text-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="not-found">
            <svg data-src="<?php echo e(asset('assets/front/images/404.svg')); ?>" data-unique-ids="disabled"
              data-cache="disabled"></svg>
          </div>
          <div class="error-txt">
            <h2><?php echo e(__('404 not found')); ?></h2>
            <p class="mx-auto">
              <?php echo e(__('The page you are looking for might have been moved, renamed, or might never existed.')); ?></p>
            <a href="<?php echo e(route('index')); ?>" class="btn btn-lg btn-primary"><?php echo e(__('Back to Home')); ?></a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--====== End Error Section ======-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make("frontend.layouts.layout-v$version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/errors/404.blade.php ENDPATH**/ ?>