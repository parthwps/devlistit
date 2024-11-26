<?php $__env->startSection('pageHeading'); ?>
  <?php echo e(!empty($pageHeading) ? $pageHeading->vendor_login_page_title : __('Login to Listit')); ?>

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
      'title' => !empty($pageHeading) ? $pageHeading->vendor_login_page_title : __('Login to Listit'),
  ])) echo $__env->make('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_login_page_title : __('Login to Listit'),
  ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <!-- Authentication-area start -->
  <div class="authentication-area ptb-100">
    <div class="container">
    <div class="">   
      <div class="auth-form border radius-md">
        <?php if(Session::has('success')): ?>
          <div class="alert alert-success"><?php echo e(__(Session::get('success'))); ?></div>
        <?php endif; ?>
        <?php if(Session::has('error')): ?>
          <div class="alert alert-danger"><?php echo e(__(Session::get('error'))); ?></div>
        <?php endif; ?>
        
          <!--<div class="title">-->
          <!--  <h4 class="mb-20"><?php echo e(__('Verify your phone number')); ?></h4>-->
          <!--  <p>In order to protect the security of your account, please verify your phone number</p>-->
          <!--</div>-->
          <!--<form action="<?php echo e(route('vendor.send_code')); ?>" method="POST" class = "verifyopt-form">-->
          <!--<?php echo csrf_field(); ?>-->
          <!--<div id = "phonecode">-->
          <!--<label><?php echo e(__('Enter phone number')); ?></label>-->
          <!--<div class="form-group mb-30 d-flex flex-row">-->
          
          <!--<input type="text" class="form-control w-50" style = "margin-right:5px;" name="country_code"  value="+44" >-->
          <!--  <input type="text" class="form-control" name="phone_number"  required>-->
          <!--  <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>-->
          <!--    <p class="text-danger mt-2"><?php echo e($message); ?></p>-->
          <!--  <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>-->
          <!--</div>-->
          <!--<button type="submit" class="btn btn-lg btn-primary radius-md w-100"> <?php echo e(__('Send code')); ?> </button>-->
          <!--</div>-->
          <!--</form>-->
          <!--<form action="<?php echo e(route('vendor.verify_code')); ?>" method="POST" class = "verifyopt-code">-->
          <!--<?php echo csrf_field(); ?>-->
          <!--<div id = "verifycode">-->
          <!--<p class ="mycode">Enter the code via text to </p>-->
          <!--<div class="form-group mb-30 d-flex flex-row">-->
          
          <!-- <input type="text" class="form-control" name="code" >-->
           
             
            
          <!--</div>-->
          <!--<p class="text-danger-code text-danger mt-2"></p>-->
          <!--<button type="submit" class="btn btn-lg btn-primary radius-md w-100"> <?php echo e(__('Verify Phone')); ?> </button>-->
          <!--</div>-->
          <!--</form>-->
        
      </div>
      </div>
    </div>
  </div>
  <!-- Authentication-area end -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make("frontend.layouts.layout-v$settings->theme_version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/vendors/auth/otpverify.blade.php ENDPATH**/ ?>