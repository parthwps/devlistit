<?php
  $version = $basicInfo->theme_version;
?>


<?php $__env->startSection('pageHeading'); ?>
  <?php echo e(!empty($pageHeading) ? $pageHeading->faq_page_title : __('FAQ')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaKeywords'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_keyword_faq); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaDescription'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_description_faq); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php if ($__env->exists('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->faq_page_title : __('FAQ'),
  ])) echo $__env->make('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->faq_page_title : __('FAQ'),
  ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <!-- Faq-area start -->
  <div class="faq-area pt-100 pb-75">
    <div class="container">
      <div class="accordion" id="faqAccordion">
        <div class="row justify-content-center">
          <div class="col-lg-8" data-aos="fade-up">
            <?php if(count($faqs) == 0): ?>
              <h3 class="text-center mt-3"><?php echo e(__('No Faq Found') . '!'); ?></h3>
            <?php else: ?>
              <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="accordion-item mb-30">
                  <h6 class="accordion-header" id="headingOne_<?php echo e($faq->id); ?>">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                      data-bs-target="#collapseOne_<?php echo e($faq->id); ?>" aria-expanded="true"
                      aria-controls="collapseOne_<?php echo e($faq->id); ?>">
                      <?php echo e($faq->question); ?>

                    </button>
                  </h6>
                  <div id="collapseOne_<?php echo e($faq->id); ?>"
                    class="accordion-collapse collapse <?php echo e($loop->iteration == 1 ? 'show' : ''); ?>"
                    aria-labelledby="headingOne_<?php echo e($faq->id); ?>" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                      <p>
                        <?php echo e($faq->answer); ?>

                      </p>
                    </div>
                  </div>
                </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <?php if(!empty(showAd(3))): ?>
              <div class="text-center mt-4 mb-25">
                <?php echo showAd(3); ?>

              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Faq-area end -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make("frontend.layouts.layout-v$version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/faq.blade.php ENDPATH**/ ?>