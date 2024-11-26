<?php
  $version = $basicInfo->theme_version;
?>


<?php $__env->startSection('pageHeading'); ?>
  <?php if(!empty($pageHeading)): ?>
    <?php echo e($pageHeading->blog_page_title); ?>

  <?php else: ?>
    <?php echo e(__('Posts')); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaKeywords'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_keyword_blog); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaDescription'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_description_blog); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php if ($__env->exists('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->blog_page_title : __('Posts'),
  ])) echo $__env->make('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->blog_page_title : __('Posts'),
  ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <!--====== Start Blog Section ======-->
  <section class="blog-area blog-1 ptb-100">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <?php if(count($blogs) == 0): ?>
            <h3 class="text-center mt-3"><?php echo e(__('No Post Found') . '!'); ?></h3>
          <?php else: ?>
            <div class="row gx-xl-5 justify-content-center">
              <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                  <article class="card mb-30">
                    <div class="card-img fancy radius-0 mb-25">
                      <a href="<?php echo e(route('blog_details', ['slug' => $blog->slug])); ?>"
                        class="lazy-container ratio ratio-5-4">
                        <img class="lazyload" src="<?php echo e(asset('assets/front/images/placeholder.png')); ?>"
                          data-src="<?php echo e(asset('assets/img/blogs/' . $blog->image)); ?>" alt="Blog Image">
                      </a>
                    </div>
                    <div class="content">
                      <h4 class="card-title">
                        <a href="<?php echo e(route('blog_details', ['slug' => $blog->slug])); ?>">
                          <?php echo e(@$blog->title); ?>

                        </a>
                      </h4>
                      <p class="card-text">
                        <?php echo e(strlen(strip_tags($blog->content)) > 90 ? mb_substr(strip_tags($blog->content), 0, 90, 'UTF-8') . '...' : $blog->content); ?>

                      </p>
                      <div class="mt-20">
                        <a href="<?php echo e(route('blog_details', ['slug' => $blog->slug])); ?>"
                          class="btn btn-lg btn-primary"><?php echo e(__('Read More')); ?></a>
                      </div>
                    </div>
                  </article>
                </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          <?php endif; ?>
          <?php if(!empty(showAd(3))): ?>
            <div class="text-center mt-4">
              <?php echo showAd(3); ?>

            </div>
          <?php endif; ?>
        </div>
        <div class="pagination mt-20 justify-content-center" data-aos="fade-up">
          <?php echo e($blogs->links()); ?>

        </div>
      </div>
    </div>
  </section>
  <!--====== End Blog Section ======-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make("frontend.layouts.layout-v$version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/journal/blog.blade.php ENDPATH**/ ?>