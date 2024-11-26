<?php
  $version = $basicInfo->theme_version;
?>


<?php $__env->startSection('pageHeading'); ?>
  <?php echo e(!empty($pageHeading) ? $pageHeading->contact_page_title : __('Contact')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaKeywords'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_keyword_contact); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaDescription'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_description_contact); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php if ($__env->exists('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->contact_page_title : __('Contact'),
  ])) echo $__env->make('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->contact_page_title : __('Contact'),
  ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <!--====================================================-->
  <!--============== Start Contact Section ===============-->
  <!--====================================================-->
  <div class="contact-area ptb-100">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6">
          <div class="card mb-30 color-1" data-aos="fade-up" data-aos-delay="100">
            <div class="icon">
              <i class="fal fa-phone-plus"></i>
            </div>
            <div class="card-text">
              <?php if(!empty($info->contact_number)): ?>
                <p><a href="tel:<?php echo e($info->contact_number); ?>"><?php echo e($info->contact_number); ?></a></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="card mb-30 color-2" data-aos="fade-up" data-aos-delay="200">
            <div class="icon">
              <i class="fal fa-envelope"></i>
            </div>
            <div class="card-text">
              <?php if(!empty($info->address)): ?>
                <p><a href="javascript:void(0)"><?php echo e($info->address); ?></a></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="card mb-30 color-3" data-aos="fade-up" data-aos-delay="300">
            <div class="icon">
              <i class="fal fa-map-marker-alt"></i>
            </div>
            <div class="card-text">
              <?php if(!empty($info->email_address)): ?>
                <p><a href="mailTo:<?php echo e($info->email_address); ?>"><?php echo e($info->email_address); ?></a></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

      <div class="pb-70"></div>

      <div class="row gx-xl-5">
        <div class="col-lg-6 mb-30" data-aos="fade-left">
          <?php if(!empty($info->latitude) && !empty($info->longitude)): ?>
            <iframe width="100%" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
              src="//maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=<?php echo e($info->latitude); ?>,%20<?php echo e($info->longitude); ?>+(<?php echo e($websiteInfo->website_title); ?>)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
          <?php endif; ?>
        </div>
        <div class="col-lg-6 mb-30 order-lg-first" data-aos="fade-right">
          <?php if(Session::has('success')): ?>
            <div class="alert alert-success"><?php echo e(__(Session::get('success'))); ?></div>
          <?php endif; ?>
          <?php if(Session::has('error')): ?>
            <div class="alert alert-success"><?php echo e(__(Session::get('error'))); ?></div>
          <?php endif; ?>
          <form id="contactForm" action="<?php echo e(route('contact.send_mail')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-20">
                  <input type="text" name="name" class="form-control" id="name"
                    placeholder="<?php echo e(__('Enter Your Full Name')); ?>" />
                  <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="help-block with-errors text-danger"><?php echo e($message); ?></div>
                  <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group mb-20">
                  <input type="email" name="email" class="form-control" id="email" required
                    data-error="Enter your email" placeholder="<?php echo e(__('Enter Your Email')); ?>" />
                  <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="help-block with-errors text-danger"><?php echo e($message); ?></div>
                  <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group mb-20">
                  <input type="text" name="subject" class="form-control" id="" required
                    placeholder="<?php echo e(__('Enter Email Subject')); ?>" />
                  <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="help-block with-errors text-danger"><?php echo e($message); ?></div>
                  <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group mb-20">
                  <textarea name="message" id="message" class="form-control" cols="30" rows="8" required
                    placeholder="<?php echo e(__('Write Your Message')); ?>"></textarea>
                  <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="help-block with-errors text-danger"><?php echo e($message); ?></div>
                  <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
              </div>
              <?php if($info->google_recaptcha_status == 1): ?>
                <div class="col-md-12">
                  <div class="form-group mb-20">
                    <?php echo NoCaptcha::renderJs(); ?>

                    <?php echo NoCaptcha::display(); ?>

                    <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                      <div class="help-block with-errors text-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
                </div>
              <?php endif; ?>

              <div class="col-md-12">
                <button type="submit" class="btn btn-lg btn-primary"
                  title="<?php echo e(__('Send message')); ?>"><?php echo e(__('Send')); ?></button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="pb-70"></div>
    </div>

    <?php if(!empty(showAd(3))): ?>
      <div class="text-center">
        <?php echo showAd(3); ?>

      </div>
    <?php endif; ?>
  </div>
  <!--============ End Contact Section =============-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make("frontend.layouts.layout-v$version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/contact.blade.php ENDPATH**/ ?>