<?php $__env->startSection('pageHeading'); ?>
  <?php echo e(!empty($pageHeading) ? $pageHeading->vendor_login_page_title : __('Login')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('metaKeywords'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_keywords_vendor_login); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaDescription'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_description_vendor_login); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php if ($__env->exists('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => "Dealer Login",
  ])) echo $__env->make('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => "Dealer Login",
  ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <!-- Authentication-area start -->
  <div class="authentication-area ptb-100">
    <div class="container">
      <div class="auth-form border radius-md">
        <?php if(Session::has('success')): ?>
          <div class="alert alert-success"><?php echo e(__(Session::get('success'))); ?></div>
        <?php endif; ?>
        <?php if(Session::has('error')): ?>
          <div class="alert alert-danger"><?php echo e(__(Session::get('error'))); ?></div>
        <?php endif; ?>
         <div class="title">
            <h4 class="mb-20"><?php echo e(__('Login')); ?></h4>
          </div>
      
                        
                        
        <form action="<?php echo e(route('vendor.login_submit')); ?>" method="POST">
          <?php echo csrf_field(); ?>
          
          <div class="form-group mb-10">
              
        <a href="/login/google"  style="border: 1px solid #d7d7d7;
        background: #f4f4f4;
        border-radius: 5px;
        padding: 0.6rem;" class="social-login mt-20 p-10 text-center d-flex align-items-center justify-content-center">
            <img src="/google.svg" class="mr-auto" alt=" google svg">
            <span class="flex-grow-1">Login with Google account</span>
        </a>
        
        <div class="text-center mt-30">
                        <span class="badge badge-circle-gray300 text-secondary d-inline-flex align-items-center justify-content-center" style="font-size: 1.5rem;">OR</span>
                    </div>
        </div>
        
          <div class="form-group ">
            <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
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
          <div class="form-group mb-30">
            <input type="password" class="form-control" name="password" placeholder="<?php echo e(__('Password')); ?>" required>
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
          <?php if($bs->google_recaptcha_status == 1): ?>
            <div class="form-group mb-30">
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
          <div class="row align-items-center mb-20">
            <div class="col-4 col-xs-12">
              <div class="link">
                <a href="<?php echo e(route('vendor.forget.password')); ?>"><?php echo e(__('Forgot password') . '?'); ?></a>
              </div>
            </div>
            <div class="col-8 col-xs-12">
             <div class="link go-signup">
                <?php echo e(__("Don't have an account") . '?'); ?> <a
                  href="<?php echo e(route('vendor.signup')); ?>"><?php echo e(__('Click Here')); ?></a>
                <?php echo e(__('to Signup')); ?>

              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-lg btn-primary radius-md w-100"> <?php echo e(__('Login')); ?> </button>
        </form>
      </div>
    </div>
  </div>
  <!-- Authentication-area end -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make("frontend.layouts.layout-v$settings->theme_version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/vendors/auth/login.blade.php ENDPATH**/ ?>