<!-- Modal -->
<div class="modal fade" id="addNextPackage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Add Next Package')); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addNextPackageForm" action="<?php echo e(route('vendor.nextPackage.add')); ?>" method="POST">
          <?php echo csrf_field(); ?>
          <input type="hidden" name="vendor_id" value="<?php echo e($vendor->id); ?>">
          <div class="form-group">
            <label for=""><?php echo e(__('Package')); ?> **</label>
            <select name="package_id" id="" class="form-control" required>
              <option value="" selected disabled><?php echo e(__('Select a Package')); ?></option>
              <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($package->id); ?>"
                  <?php echo e(!empty($nextPackage) && $nextPackage->id == $package->id ? 'selected' : ''); ?>><?php echo e($package->title); ?>

                  (<?php echo e($package->term); ?>)
                </option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
          <!--<div class="form-group">-->
          <!--  <label for=""><?php echo e(__('Payment Method')); ?></label>-->
          <!--  <select name="payment_method" class="form-control">-->
          <!--    <option value="" selected disabled><?php echo e(__('Select a Payment Method')); ?></option>-->
          <!--    <?php $__currentLoopData = $gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gateway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>-->
          <!--      <option value="<?php echo e($gateway->name); ?>"><?php echo e($gateway->name); ?></option>-->
          <!--    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>-->
          <!--  </select>-->
          <!--</div>-->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
        <button type="submit" form="addNextPackageForm" class="btn btn-primary"><?php echo e(__('Add')); ?></button>
      </div>
    </div>
  </div>
</div>
<?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/backend/end-user/vendor/add-next-package.blade.php ENDPATH**/ ?>