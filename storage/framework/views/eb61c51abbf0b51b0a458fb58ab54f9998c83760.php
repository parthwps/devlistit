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
    <div class="col-md-12">
    <?php if($message = Session::get('error')): ?>
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong><?php echo e($message); ?></strong>
    </div>
  <?php endif; ?>
  
    <form id="my-checkout-form" action="<?php echo e(route('vendor.plan.checkout')); ?>" method="post"
          enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
          
          
         
          <div class="row">
            <?php if(count($data) > 0): ?>
            <h4 class="mb-5">Choose your ad option</h4>  
              <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
              <?php if($loop->index == 1): ?>      
                <div class="col-md-3 pr-md-0 mb-2">
              <?php else: ?>
              <div class="col-md-3 pr-md-0 mb-2 mt-4">
              <?php endif; ?>    
                <div class="card-pricing-vendor">
                    <?php if($loop->index == 1): ?>
                    <div class="price-rcomm">Boost</div>
                    
                    <?php endif; ?>
                    <div class="pricing-header">
                      <h4 class=" d-inline-block mt-4">
                      <?php echo e($data->title); ?>

                      </h4>
                    </div>
                    <div class="price-value">
                      <div class="value">
                          <h2><?php echo e(symbolPrice($data->price)); ?></h2>
                      </div>
                    </div>
                    <div class="px-3 clearfix">
                      <table class="table">
                          <thead>
                            <tr>
                                <td style="width: 5rem;"> Ad views </td>
                                <td>
                                <?php if($loop->index == 0): ?>  
                                  <div class="progress align-baseline">
                                      <div class="progress-bar bg-warning" role="progressbar" style="width: 33%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                      <div class="progress-bar bggrey" role="progressbar" style="width: 33%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                      <div class="progress-bar bggrey" role="progressbar" style="width: 33%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div>
                                  <?php endif; ?>
                                  <?php if($loop->index == 1): ?>  
                                  <div class="progress align-baseline">
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                      <div class="progress-bar bggrey" role="progressbar" style="width: 33%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div>
                                  <?php endif; ?>
                                  <?php if($loop->index == 2): ?>  
                                  <div class="progress align-baseline">
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div>
                                  <?php endif; ?>
                                </td>
                            </tr>
                          </thead>
                      </table>
                    </div>
                    <ul class="pricing-content p-2">
                     <?php if($data->days_listing > 0): ?>
                      <li><span class="c_check"><i class="fal fa-check"></i></span> &nbsp;<?php echo e($data->days_listing); ?> day listing</li>
                      <?php endif; ?>
                      <?php if($data->photo_allowed > 0): ?>
                      <li><span class="c_check"><i class="fal fa-check"></i></span> &nbsp;Up to <?php echo e($data->photo_allowed); ?> photos</li>
                      <?php endif; ?>
                      <?php if($data->ad_views > 0): ?>
                      <li><span class="c_check"><i class="fal fa-check"></i></span> &nbsp;<?php echo e($data->ad_views); ?>x more ad views</li>
                      <?php endif; ?>
                      <?php if($data->priority_placement > 0): ?>
                      <li><span class="c_check"><i class="fal fa-check"></i></span> &nbsp;Priority placement</li>
                      <?php endif; ?>
                    </ul>
                    
                    <div class="px-4 mt-3">
                      <a href="<?php echo e(route('vendor.package.boost_package',  [$data->id,request()->route('ad_id')])); ?>"
                          class="choosepackage btn btn-primary btn-block btn-lg mb-3 w-100" data-id = "<?php echo e($data->id); ?>"><?php echo e(__('Choose')); ?></a>
                    </div>
                </div>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            
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

<?php echo $__env->make("frontend.layouts.layout-v$settings->theme_version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/vendors/car/boost.blade.php ENDPATH**/ ?>