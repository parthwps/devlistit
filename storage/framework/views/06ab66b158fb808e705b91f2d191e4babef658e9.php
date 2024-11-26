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
      'breadcrumb' => 123,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Signup'),
  ])) echo $__env->make('frontend.partials.breadcrumb', [
      'breadcrumb' => 123,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Signup'),
  ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <div class="user-dashboard pt-20 pb-60">
    <div class="container">
        
  <div class="row gx-xl-5">
  
       <?php if ($__env->exists('vendors.partials.side-custom')) echo $__env->make('vendors.partials.side-custom', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <div class="col-md-9">
    <div class="row">
    <div class="col-md-10">
    <?php if($message = Session::get('error')): ?>
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong><?php echo e($message); ?></strong>
    </div>
  <?php endif; ?>
  
    <form id="my-checkout-form" action="<?php echo e(route('vendor.plan.checkout')); ?>" method="post"
          enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
          
          
         
      <div class="card">
      
      <div class="card-body">
        <div class="row successimg">
        <div class="col-lg-6 col-xs-4">
            <div class=" p-4 text-center">
            <img  class="lazyload text-center"
                        data-src="<?php echo e(asset('assets/img/ad-success.png')); ?>"
                        alt="">
            </div>
          </div>
          <div class="col-lg-6 mx-auto">
            <div class=" p-4 text-center">
              <div class="mb-3">
              <?php
              $title = ""; 
             $title = route('frontend.car.details', ['cattitle' => catslug($ad_id->car_content->category_id),'slug' => $ad_id->car_content->slug, 'id' => $ad_id->id]) ;
              ?>
              </div>
              <h4><?php echo e(__('Success, your ad is listed')); ?></h4>
              <label><?php echo e(__('It may take a few minutes for your ad to appear on Listit.')); ?></label>
              <div class="social-link style-2 mt-50">
                    <a data-tooltip="tooltip" data-bs-placement="top"
                        title="facebook" href="https://www.facebook.com/sharer/sharer.php?quote=Check Out this ad on List It&utm_source=facebook&utm_medium=social&u=<?php echo e(urlencode($title)); ?>"
                      target="_blank"><i class="fab fa-facebook-f"></i></a>

                    <a data-tooltip="tooltip" data-bs-placement="top"
                        title="Twitter" href="//twitter.com/intent/tweet?text=Check Out this ad on List It&amp;url=<?php echo e(urlencode($title)); ?>"
                      target="_blank"><i class="fab fa-twitter"></i></a>

                    <a data-tooltip="tooltip" data-bs-placement="top"
                        title="Whatsapp" href="//wa.me/?text=Check Out this ad on List it <?php echo e(urlencode($title)); ?>&amp;title= "
                      target="_blank"><i class="fab fa-whatsapp"></i></a>
                      <a data-tooltip="tooltip" data-bs-placement="top"
                        title="Linkedin" href="//www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo e(urlencode($title)); ?>&amp;title=Check Out this ad on List it"
                      target="_blank"><i class="fab fa-linkedin-in"></i></a>
                      <a data-tooltip="tooltip" data-bs-placement="top"
                        title="Email" href="mailto:?subject=Check Out this ad on List it&amp;body=Check Out this ad on List it <?php echo e(urlencode($title)); ?>&amp;title="
                      target="_blank"><i class="fas fa-envelope"></i></a>
                      <a data-tooltip="tooltip" data-bs-placement="top"
                        title="Copy Link" id = "copy_url" onclick="copy('<?php echo e(($title)); ?>','#copy_url')" id="copy_button_1" href="javascript:void(0)"
                      ><i class="fas fa-link"></i></a>
                  </div>
                  <a href="<?php echo e(($title)); ?>" target = "_blank"
                  class="btn btn-md btn-primary w-100 showLoader mt-40"><?php echo e(__('View Ad')); ?> </a>
            </div>
            
          </div>
        </div>
      </div>
        </div>
       
      </form>
        <div class="card-footer">
          
        </div>
      </div>
    </div>
  </div>  </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

  <script>
   
    function copy(text, target) {
      setTimeout(function() {
      //$('#copied_tip').remove();
      }, 800);
      
      var input = document.createElement('input');
input.setAttribute('value', text);
document.body.appendChild(input);
input.select();
var result = document.execCommand('copy');
document.body.removeChild(input)

      toastr["success"]("Ad Url copied successfully.")
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut ": 10000,
                "extendedTimeOut": 10000,
                "positionClass": "toast-top-right",
            }
            return result;
     
    }
  </script>
  <script src="<?php echo e(asset('assets/js/store-visitor.js')); ?>"></script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make("frontend.layouts.layout-v$settings->theme_version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/vendors/car/success.blade.php ENDPATH**/ ?>