<?php
  $version = $basicInfo->theme_version;
?>


<?php $__env->startSection('pageHeading'); ?>
  <?php echo e(!empty($pageHeading) ? $pageHeading->about_us_title : __('About Us')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaKeywords'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_keywords_about_page); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaDescription'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_description_about_page); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php if ($__env->exists('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->about_us_title : __('About Us'),
  ])) echo $__env->make('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->about_us_title : __('About Us'),
  ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <!-- counter area start -->
  <?php if($secInfo->counter_section_status == 1): ?>
    <section class="choose-area pt-100 pb-60">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-7" data-aos="slide-<?php echo e($currentLanguageInfo->direction == 1 ? 'left' : 'right'); ?>"
            data-aos-duration="1000">
            <div class="image mb-40">
              <img class="lazyload blur-up"
                <?php if(!empty($counterSectionImage)): ?> data-src="<?php echo e(asset('assets/img/' . $counterSectionImage)); ?>" <?php endif; ?>
                alt="Image">
            </div>
          </div>
          <div class="col-lg-5" data-aos="fade-up">
            <div class="content-title mb-40">
              <h2 class="title mb-20">
                <?php echo e(@$counterSectionInfo->title); ?>

              </h2>
              <p><?php echo e(@$counterSectionInfo->subtitle); ?></p>
              <div class="info-list mt-30">
                <div class="row align-items-center pb-30">
                  <?php $__currentLoopData = $counters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-sm-6">
                      <div class="card mt-30">
                        <div class="d-flex align-items-center">
                          <div class="card-icon"><i class="<?php echo e($counter->icon); ?>"></i></div>
                          <div class="card-content">
                            <span class="h3 mb-1"><span class="counter"><?php echo e($counter->amount); ?></span>+</span>
                            <p class="card-text"><?php echo e($counter->title); ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="shape">
        <img class="lazyload blur-up" data-src="<?php echo e(asset('assets/front/images/dark-bg.png')); ?>" alt="Image">
      </div>
    </section>
  <?php endif; ?>
  <!-- counter area end -->

  <!-- Steps-area start -->
  <?php if($secInfo->work_process_section_status == 1): ?>
    <section class="steps-area pb-70">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title title-center mb-50" data-aos="fade-up">
              <span class="subtitle mb-10"><?php echo e(@$workProcessSecInfo->title); ?></span>
              <h2 class="title"><?php echo e(@$workProcessSecInfo->subtitle); ?></span></h2>
            </div>
          </div>
          <div class="col-12">
            <div class="row">
              <?php $__currentLoopData = $processes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $process): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                  <div class="card align-items-center text-center radius-md p-25 mb-30">
                    <div class="card-icon radius-md mb-25">
                      <i class="<?php echo e($process->icon); ?>"></i>
                    </div>
                    <div class="card-content">
                      <h4 class="card-title mb-20"><?php echo e($process->title); ?></h4>
                      <p class="card-text lc-3">
                        <?php echo e($process->text); ?>

                      </p>
                    </div>
                    <span class="text-stroke h2">0<?php echo e($loop->iteration); ?></span>
                  </div>
                </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
        </div>
        <?php if(!empty(showAd(3))): ?>
          <div class="text-center mt-4">
            <?php echo showAd(3); ?>

          </div>
        <?php endif; ?>
      </div>
    </section>
  <?php endif; ?>
  <!-- Steps-area end -->


  <!-- Testimonial-area start -->
  <?php if($secInfo->testimonial_section_status == 1): ?>
    <section class="testimonial-area testimonial-1 pb-100">
      <div class="container">
        <div class="content">
          <div class="row gx-xl-5 align-items-center">
            <div class="col-md-6 col-lg-5 border-end border-sm-0" data-aos="fade-up">
              <h2 class="title mb-20"><?php echo e(!empty($testimonialSecInfo->title) ? $testimonialSecInfo->title : ''); ?></h2>
            </div>
            <div class="col-md-6 col-lg-5" data-aos="fade-up" data-aos-delay="100">
              <p class="text mb-20"><?php echo e(!empty($testimonialSecInfo->subtitle) ? $testimonialSecInfo->subtitle : ''); ?>

              </p>
            </div>
            <div class="col-lg-2" data-aos="fade-up" data-aos-delay="150">
              <!-- Slider navigation buttons -->
              <div class="slider-navigation text-end mb-20">
                <button type="button" title="Slide prev" class="slider-btn radius-0" id="testimonial-slider-btn-prev">
                  <i class="fal fa-angle-left"></i>
                </button>
                <button type="button" title="Slide next" class="slider-btn radius-0" id="testimonial-slider-btn-next">
                  <i class="fal fa-angle-right"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="row align-items-center" data-aos="fade-up">
          <div class="col-lg-9">
            <div class="swiper pt-30 mb-15" id="testimonial-slider-1">
              <div class="swiper-wrapper">
                <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="swiper-slide pb-25" data-aos="fade-up">
                    <div class="slider-item">
                      <div class="client mb-25">
                        <div class="client-info d-flex align-items-center">
                          <div class="client-img">
                            <div class="lazy-container rounded-pill ratio ratio-1-1">
                              <?php if(is_null($testimonial->image)): ?>
                                <img data-src="<?php echo e(asset('assets/img/profile.jpg')); ?>" alt="image" class="lazyload">
                              <?php else: ?>
                                <img class="lazyload" data-src="<?php echo e(asset('assets/img/clients/' . $testimonial->image)); ?>"
                                  alt="Person Image">
                              <?php endif; ?>
                            </div>
                          </div>
                          <div class="content">
                            <h6 class="name"><?php echo e($testimonial->name); ?></h6>
                            <span class="designation"><?php echo e($testimonial->occupation); ?></span>
                          </div>
                        </div>
                        <div class="ratings">
                          <div class="rate">
                            <div class="rating-icon" style="width: <?php echo e($testimonial->rating * 20); ?>%"></div>
                          </div>
                          <span class="ratings-total"><?php echo e($testimonial->rating); ?> <?php echo e(__('star')); ?></span>
                        </div>
                      </div>
                      <div class="quote mb-25">
                        <span class="icon"><i class="fal fa-quote-right"></i></span>
                        <p class="text mb-0">
                          <?php echo e($testimonial->comment); ?>

                        </p>
                      </div>
                    </div>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
            <div class="clients d-flex align-items-center" data-aos="fade-up">
              <div class="client-img">
                <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($loop->iteration < 5): ?>
                    <?php if(is_null($testimonial->image)): ?>
                      <img data-src="<?php echo e(asset('assets/img/profile.jpg')); ?>" alt="image" class="lazyload">
                    <?php else: ?>
                      <img class="lazyload" data-src="<?php echo e(asset('assets/img/clients/' . $testimonial->image)); ?>"
                        alt="Person Image">
                    <?php endif; ?>
                  <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
              <span><?php echo e(@$testimonialSecInfo->clients); ?></span>
            </div>
          </div>
        </div>
      </div>
      <div class="img-content d-none d-lg-block" data-aos="fade-left">
        <div class="img">
          <img class="lazyload blur-up" data-src="<?php echo e(asset('assets/img/' . $testimonialSecImage)); ?>" alt="Image">
        </div>
      </div>
      <!-- Shape -->
      <div class="shape"></div>
    </section>
    <?php if(!empty(showAd(3))): ?>
      <div class="text-center mt-4">
        <?php echo showAd(3); ?>

      </div>
      
      <div class="pb-100"></div>
    <?php endif; ?>
  <?php endif; ?>
  <!-- Testimonial-area end -->


<?php $__env->stopSection(); ?>

<?php echo $__env->make("frontend.layouts.layout-v$version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/about.blade.php ENDPATH**/ ?>