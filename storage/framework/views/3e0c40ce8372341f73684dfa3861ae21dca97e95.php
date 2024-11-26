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
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Signup'),
  ])) echo $__env->make('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Signup'),
  ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <!-- Authentication-area start -->
  <div class="authentication-area ptb-60">
    <div class="container">
      <div class="auth-form border radius-md">
        <?php if(Session::has('success')): ?>
          <div class="alert alert-success"><?php echo e(__(Session::get('success'))); ?></div>
        <?php endif; ?>
        <form action="<?php echo e(route('vendor.signup_submit')); ?>" method="POST">
          <?php echo csrf_field(); ?>
          <div class="title">
            <h4 class="mb-15"><?php echo e(__('Signup')); ?></h4>
          </div>
          
          <!-- <div class="form-group">
            <h5>Are You a</h5>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="traderstatus" value="1" id="flexRadioDefault1">
              <label class="form-check-label" for="flexRadioDefault1">
                Trader
              </label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="traderstatus" value="0" id="flexRadioDefault2" checked>
              <label class="form-check-label" for="flexRadioDefault2">
                Private Seller
              </label>
            </div>
          </div> -->
          <div class="form-group mb-10">
            <input type="text" class="form-control" autocomplete="off" name="username" placeholder="Full Name" required>
            <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-danger mt-2"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          <div class="form-group mb-10">
            <input type="text" class="form-control" autocomplete="off" name="email" placeholder="<?php echo e(__('Email')); ?>" required>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-danger mt-2"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          <!-- <div class="form-group mb-20">
            <input type="text" class="form-control" name="phone" placeholder="<?php echo e(__('Phone No')); ?>" required>
            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-danger mt-2"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div> -->
          <div class="form-group mb-10">
            <div class="password-container">
            <input type="password" id="password" class="form-control" autocomplete="off" name="password" placeholder="<?php echo e(__('Password')); ?>" required>
            <span id="togglePassword" class="eye-icon">
            <i class="fa fa-eye"></i>
            </span>
            </div>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-danger mt-2"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
            <div class="form-group mb-20">
            <div class="password-container">
            <input type="password" id="password_confirmation" name="password_confirmation" value="<?php echo e(old('password_confirmation')); ?>"
            class="form-control" placeholder="<?php echo e(__('Confirm Password')); ?>" required>
            <span id="togglePasswordConfirmation" class="eye-icon">
            <i class="fa fa-eye"></i>
            </span>
            </div>
            <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-danger mt-2"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> 
          </div>
          
          <?php if($recaptchaInfo->google_recaptcha_status == 1): ?>
            <div class="form-group mb-15">
              <?php echo NoCaptcha::renderJs(); ?>

              <?php echo NoCaptcha::display(); ?>


              <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1 text-danger"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
          <?php endif; ?>
          <div class="form-group ">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="link">
              <p>To get the most from Listit. We will send you members only updates via email, push notification 
              and on site messsaging. You can update our prefrences at anytime from Your Listit account page.</p>
                
                </div>
              </div>
            </div>
            </div>  
          <div class="form-group">
            <div class="row align-items-center ">
              <div class="col-12">
                <div class="link">
              <input type = "checkbox"  name ="notification_allowed" style="width:1.2rem; height:1.2rem; padding-top:5px;" value="1" >  &nbsp; Yes I Agree</a>
                
                </div>
              </div>
            </div>
            </div>  

          <div class="row align-items-center mb-10">
            <div class="col-12">
              <div class="link">
               <?php echo e(__('Already have an account') . '?'); ?> <a
                  href="<?php echo e(route('vendor.login')); ?>"><?php echo e(__('Click Here')); ?></a>
                <?php echo e(__('to Login')); ?>

              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-lg btn-primary radius-md w-100"> <?php echo e(__('Signup')); ?> </button>
        </form>
      </div>
    </div>
  </div>
  <!-- Authentication-area end -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make("frontend.layouts.layout-v$settings->theme_version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/vendors/auth/register.blade.php ENDPATH**/ ?>