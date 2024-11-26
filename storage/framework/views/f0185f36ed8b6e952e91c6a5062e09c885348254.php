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
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Dashboard'),
  ])) echo $__env->make('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Dashboard'),
  ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="user-dashboard pt-20 pb-60">
    <div class="container">
      
  
      
  <div class="row gx-xl-5">
  
       <?php if ($__env->exists('vendors.partials.side-custom')) echo $__env->make('vendors.partials.side-custom', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   

    
    <div class="col-md-9">
  <div class="mt-2 mb-4">
    <h2 class="pb-2"><?php echo e(__('Welcome back,')); ?> <?php echo e(ucwords($userinfo->name) . '!'); ?></h2>
  </div>
  <?php if(Auth::guard('vendor')->user()->status == 0 && $admin_setting->vendor_admin_approval == 1): ?>
    <div class="mt-2 mb-4">
      <div class="alert alert-danger text-dark">
        <?php echo e($admin_setting->admin_approval_notice != null ? $admin_setting->admin_approval_notice : 'Your account is deactive!'); ?>

      </div>
    </div>
  <?php endif; ?>

  <?php
  
    $vendor = Auth::guard('vendor')->user();
    $package = \App\Http\Helpers\VendorPermissionHelper::currentPackagePermission($vendor->id);
  ?>

  <?php if(is_null($package)): ?>
    <?php
      $pendingMemb = \App\Models\Membership::query()
          ->where([['vendor_id', '=', Auth::id()], ['status', 0]])
          ->whereYear('start_date', '<>', '9999')
          ->orderBy('id', 'DESC')
          ->first();
      $pendingPackage = isset($pendingMemb) ? \App\Models\Package::query()->findOrFail($pendingMemb->package_id) : null;
    ?>

    <?php if ($__env->exists('vendors.verify')) echo $__env->make('vendors.verify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if($pendingPackage): ?>
      <!-- <div class="alert alert-warning text-dark">
        <?php echo e(__('You have requested a package which needs an action (Approval / Rejection) by Admin. You will be notified via mail once an action is taken.')); ?>

      </div>
      <div class="alert alert-warning text-dark">
        <strong><?php echo e(__('Pending Package') . ':'); ?> </strong> <?php echo e($pendingPackage->title); ?>

        <span class="badge badge-secondary"><?php echo e($pendingPackage->term); ?></span>
        <span class="badge badge-warning"><?php echo e(__('Decision Pending')); ?></span>
      </div> -->
    <?php else: ?>
      <!-- <div class="alert alert-warning text-dark">
        <?php echo e(__('Your membership is expired. Please purchase a new package / extend the current package.')); ?>

      </div> -->
    <?php endif; ?>
  <?php else: ?>
   <!--  <div class="row justify-content-center align-items-center mb-1">
      <div class="col-12">
        <div class="alert border-left border-primary text-dark">
          <?php if($package_count >= 2 && $next_membership): ?>
            <?php if($next_membership->status == 0): ?>
              <strong
                class="text-danger"><?php echo e(__('You have requested a package which needs an action (Approval / Rejection) by Admin. You will be notified via mail once an action is taken.')); ?></strong><br>
            <?php elseif($next_membership->status == 1): ?>
              <strong
                class="text-danger"><?php echo e(__('You have another package to activate after the current package expires. You cannot purchase / extend any package, until the next package is activated')); ?></strong><br>
            <?php endif; ?>
          <?php endif; ?>

          <strong><?php echo e(__('Current Package') . ':'); ?> </strong> <?php echo e($current_package->title); ?>

          <span class="badge badge-secondary"><?php echo e($current_package->term); ?></span>
          <?php if($current_membership->is_trial == 1): ?>
            (<?php echo e(__('Expire Date') . ':'); ?>

            <?php echo e(Carbon\Carbon::parse($current_membership->expire_date)->format('M-d-Y')); ?>)
            <span class="badge badge-primary"><?php echo e(__('Trial')); ?></span>
          <?php else: ?>
            (<?php echo e(__('Expire Date') . ':'); ?>

            <?php echo e($current_package->term === 'lifetime' ? 'Lifetime' : Carbon\Carbon::parse($current_membership->expire_date)->format('M-d-Y')); ?>)
          <?php endif; ?>

          <?php if($package_count >= 2 && $next_package): ?>
            <div>
              <strong><?php echo e(__('Next Package To Activate') . ':'); ?> </strong> <?php echo e($next_package->title); ?> <span
                class="badge badge-secondary"><?php echo e($next_package->term); ?></span>
              <?php if($current_package->term != 'lifetime' && $current_membership->is_trial != 1): ?>
                (
                <?php echo e(__('Activation Date') . ':'); ?>

                <?php echo e(Carbon\Carbon::parse($next_membership->start_date)->format('M-d-Y')); ?>,
                <?php echo e(__('Expire Date') . ':'); ?>

                <?php echo e($next_package->term === 'lifetime' ? 'Lifetime' : Carbon\Carbon::parse($next_membership->expire_date)->format('M-d-Y')); ?>)
              <?php endif; ?>
              <?php if($next_membership->status == 0): ?>
                <span class="badge badge-warning"><?php echo e(__('Decision Pending')); ?></span>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div> -->
  <?php endif; ?>

  
  <div class="row dashboard-items">
    <div class="col-sm-6 col-md-4">
      <a href="<?php echo e(route('vendor.car_management.car', ['language' => $defaultLang->code])); ?>">
        <div class="card card-stats card-success card-round">
          <div class="card-body">
            <div class="row">
              <div class="col-5">
                <div class="icon-big text-center">
                  <i class="far fa-car"></i>
                </div>
              </div>

              <div class="col-7 col-stats">
                <div class="numbers">
                  <p class="card-category"><?php echo e(__('Ads')); ?></p>
                  <h4 class="card-title"><?php echo e($totalCars); ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
    <?php if($support_status->support_ticket_status == 'acti2ve'): ?>
      <div class="col-sm-6 col-md-4">
        <a href="<?php echo e(route('vendor.support_tickets')); ?>">
          <div class="card card-stats card-secondary card-round">
            <div class="card-body">
              <div class="row">
                <div class="col-5">
                  <div class="icon-big text-center">
                    <i class="far fa-ticket"></i>
                  </div>
                </div>

                <div class="col-7 col-stats">
                  <div class="numbers">
                    <p class="card-category"><?php echo e(__('Support Tickets')); ?></p>
                    <h4 class="card-title"><?php echo e($total_support_tickets); ?></h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>
    <?php endif; ?>
    <?php if($current_package != '[]'): ?>
      <!-- <div class="col-sm-6 col-md-4">
        <a href="<?php echo e(route('vendor.payment_log')); ?>">
          <div class="card card-stats card-info card-round">
            <div class="card-body">
              <div class="row">
                <div class="col-5">
                  <div class="icon-big text-center">
                    <i class="fal fa-lightbulb-dollar"></i>
                  </div>
                </div>

                <div class="col-7 col-stats">
                  <div class="numbers">
                    <p class="card-category"><?php echo e(__('Payment Logs')); ?></p>
                    <h4 class="card-title"><?php echo e($payment_logs); ?></h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div> -->
    <?php endif; ?>

    <!-- <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <div class="card-title"><?php echo e(__('Monthly Ads Posts')); ?> (<?php echo e(date('Y')); ?>)</div>
        </div>

        <div class="card-body">
          <div class="chart-container">
            <canvas id="CarChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <div class="card-title"><?php echo e(__('Monthly Visitors')); ?> (<?php echo e(date('Y')); ?>)</div>
        </div>

        <div class="card-body">
          <div class="chart-container">
            <canvas id="visitorChart"></canvas>
          </div>
        </div>
      </div>
    </div> -->

  </div>
  </div>
  </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
  
  <script type="text/javascript" src="<?php echo e(asset('assets/js/chart.min.js')); ?>"></script>

  <script>
    "use strict";
    const monthArr = <?php echo json_encode($monthArr) ?>;
    const totalCarsArr = <?php echo json_encode($totalCarsArr) ?>;
    const visitorArr = <?php echo json_encode($visitorArr) ?>;
  </script>

  <script type="text/javascript" src="<?php echo e(asset('assets/js/vendor-chart-init.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("frontend.layouts.layout-v$settings->theme_version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/vendors/index.blade.php ENDPATH**/ ?>