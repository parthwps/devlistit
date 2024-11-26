<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Edit Car Category')); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form id="ajaxEditForm" class="modal-form" action="<?php echo e(route('admin.car_specification.update_category')); ?>"
          method="post" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
          <input type="hidden" id="in_id" name="id">

          <div class="form-group">
            <label for=""><?php echo e(__('Image') . '*'); ?></label>
            <br>
            <div class="thumb-preview">
              <img src="<?php echo e(asset('assets/img/noimage.jpg')); ?>" alt="..." class="uploaded-img in_image">
            </div>

            <div class="mt-3">
              <div role="button" class="btn btn-primary btn-sm upload-btn">
                <?php echo e(__('Choose Image')); ?>

                <input type="file" class="img-input" name="image">
              </div>
            </div>
            <?php if($settings->theme_version == 1): ?>
              <p class="text-warning mb-0"><?php echo e(__('Image Size : 360x160')); ?></p>
            <?php elseif($settings->theme_version == 2): ?>
              <p class="text-warning mb-0"><?php echo e(__('Image Size : 290x158')); ?></p>
            <?php elseif($settings->theme_version == 3): ?>
              <p class="text-warning mb-0"><?php echo e(__('Image Size : 245x185')); ?></p>
            <?php endif; ?>
            <p id="editErr_image" class="mb-0 text-danger em"></p>
          </div>

          <div class="form-group">
            <label for=""><?php echo e(__('Name') . '*'); ?></label>
            <input type="text" id="in_name" class="form-control" name="name" placeholder="Enter Category Name">
            <p id="editErr_name" class="mt-2 mb-0 text-danger em"></p>
          </div>

          <div class="form-group">
            <label for=""><?php echo e(__('Status') . '*'); ?></label>
            <select name="status" id="in_status" class="form-control">
              <option disabled><?php echo e(__('Select Category Status')); ?></option>
              <option value="1"><?php echo e(__('Active')); ?></option>
              <option value="0"><?php echo e(__('Deactive')); ?></option>
            </select>
            <p id="editErr_status" class="mt-2 mb-0 text-danger em"></p>
          </div>

          <div class="form-group">
            <label for=""><?php echo e(__('Serial Number') . '*'); ?></label>
            <input type="number" id="in_serial_number" class="form-control ltr" name="serial_number"
              placeholder="Enter Category Serial Number">
            <p id="editErr_serial_number" class="mt-2 mb-0 text-danger em"></p>
            <p class="text-warning mt-2 mb-0">
              <small><?php echo e(__('The higher the serial number is, the later the category will be shown.')); ?></small>
            </p>
          </div>
          <div class="form-group"">
          <button type="button" class="btn btn-primary btn-sm populatefilter">Populate filters</button>
          </div>
          <div class="form-group" id="filterarea">
          
         <!--  <?php $__currentLoopData = $searchfilter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="form-check-inline " style=" width: 30%!important">
              <input class="form-check-input filterschk"  type="checkbox"   value="<?php echo e($val->slug); ?>" name="filters[]"><?php echo e($val->name); ?>

            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> -->
        
          </div>  
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
          <?php echo e(__('Close')); ?>

        </button>
        <button id="updateBtn" type="button" class="btn btn-primary btn-sm">
          <?php echo e(__('Update')); ?>

        </button>
      </div>
    </div>
  </div>
</div>
<?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/backend/car/category/edit.blade.php ENDPATH**/ ?>