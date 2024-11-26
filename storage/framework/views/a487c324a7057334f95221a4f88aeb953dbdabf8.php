<?php $__env->startSection('content'); ?>
  <div class="page-header">
    <h4 class="page-title"><?php echo e(__('Change Password')); ?></h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="<?php echo e(route('admin.dashboard')); ?>">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#"><?php echo e(__('Password Settings')); ?></a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-12">
              <div class="card-title"><?php echo e(__('Change Password')); ?></div>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">
              <form id="ajaxEditForm" action="<?php echo e(route('admin.update_password')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                  <label><?php echo e(__('Current Password*')); ?></label>
                  <input type="password" class="form-control" name="current_password">
                  <p id="editErr_current_password" class="mt-1 mb-0 text-danger em"></p>
                </div>

                <div class="form-group">
                  <label><?php echo e(__('New Password*')); ?></label>
                  <input type="password" class="form-control" name="new_password">
                  <p id="editErr_new_password" class="mt-1 mb-0 text-danger em"></p>
                </div>

                <div class="form-group">
                  <label><?php echo e(__('Confirm New Password*')); ?></label>
                  <input type="password" class="form-control" name="new_password_confirmation">
                  <p id="editErr_new_password_confirmation" class="mt-1 mb-0 text-danger em"></p>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <div class="row">
            <div class="col-12 text-center">
              <button type="submit" id="updateBtn" class="btn btn-success">
                <?php echo e(__('Update')); ?>

              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?> 

<?php echo $__env->make('backend.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/backend/admin/change-password.blade.php ENDPATH**/ ?>