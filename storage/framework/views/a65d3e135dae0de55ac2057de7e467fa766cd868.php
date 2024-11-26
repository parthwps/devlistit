<?php
  use App\Models\Language;
  $selLang = Language::where('code', request()->input('language'))->first();
?>
<?php if(!empty($selLang->language) && $selLang->language->rtl == 1): ?>
  <?php $__env->startSection('styles'); ?>
    <style>
      form input,
      form textarea,
      form select {
        direction: rtl;
      }

      form .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
      }
    </style>
  <?php $__env->stopSection(); ?>
<?php endif; ?>

<?php $__env->startSection('content'); ?>
  <div class="page-header">
    <h4 class="page-title"><?php echo e(__('Edit package')); ?></h4>
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
        <a href="#"><?php echo e(__('Packages')); ?></a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#"><?php echo e(__('Edit')); ?></a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block"><?php echo e(__('Edit package')); ?></div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="<?php echo e(route('admin.package.index')); ?>">
            <span class="btn-label">
              <i class="fas fa-backward"></i>
            </span>
            <?php echo e(__('Back')); ?>

          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">
              <form id="ajaxForm" class="" action="<?php echo e(route('admin.package.update')); ?>" method="post"
                enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="package_id" value="<?php echo e($package->id); ?>">
                <div class="form-group">
                  <label for="title"><?php echo e(__('Package title')); ?>*</label>
                  <input id="title" type="text" class="form-control" readonly name="title" value="<?php echo e($package->title); ?>"
                    placeholder="<?php echo e(__('Enter name')); ?>">
                  <p id="err_title" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group">
                  <label for="price"><?php echo e(__('Price')); ?> (<?php echo e($settings->base_currency_text); ?>)*</label>
                  <input id="price" type="number" class="form-control" name="price"
                    placeholder="<?php echo e(__('Enter Package price')); ?>" value="<?php echo e($package->price); ?>">
                  <p class="text-warning">
                    <small><?php echo e(__('If price is 0 , than it will appear as free')); ?></small>
                  </p>
                  <p id="err_price" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group">
                  <label for="plan_term"><?php echo e(__('Package term')); ?>*</label>
                  <select id="plan_term" name="term" class="form-control">
                    <option value="" selected disabled><?php echo e(__('Select a Term')); ?></option>
                    <option value="monthly" <?php echo e($package->term == 'monthly' ? 'selected' : ''); ?>>
                      <?php echo e(__('Monthly')); ?></option>
                    <option value="yearly" <?php echo e($package->term == 'yearly' ? 'selected' : ''); ?>>
                      <?php echo e(__('Yearly')); ?></option>
                    <option value="lifetime" <?php echo e($package->term == 'lifetime' ? 'selected' : ''); ?>>
                      <?php echo e('Lifetime'); ?></option>
                  </select>
                  <p id="err_term" class="mb-0 text-danger em"></p>
                </div>

                <div class="form-group">
                  <label class="form-label"><?php echo e(__('How many cars can the vendor add')); ?> *</label>
                  <input type="text" class="form-control" name="number_of_car_add"
                    placeholder="<?php echo e(__('Enter How many cars can the vendor add')); ?>"
                    value="<?php echo e($package->number_of_car_add); ?>">
                  <p id="err_number_of_car_add" class="mb-0 text-danger em"></p>
                </div>
                
                <div class="form-group" style="display:none;" >
                  <label class="form-label"><?php echo e(__('How many cars does the vendor make  featured')); ?> *</label>
                  <input type="text" name="number_of_car_featured" class="form-control"
                    placeholder="<?php echo e(__('Enter how many cars does the vendor make featured')); ?>"
                    value="<?php echo e($package->number_of_car_featured); ?>">
                  <p id="err_number_of_car_featured" class="mb-0 text-danger em"></p>
                </div>
                
                
                <div class="form-group">
                  <label class="form-label"><?php echo e(__('How many Bumps can the vendor use')); ?> *</label>
                  <input type="text" class="form-control" name="number_of_bumps"
                    placeholder="<?php echo e(__('How many Bumps can the vendor use')); ?>"
                    value="<?php echo e($package->number_of_bumps); ?>">
                  <p id="err_number_of_car_add" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group">
                  <label class="form-label"><?php echo e(__('Enter how many times vendor can check history')); ?> *</label>
                  <input type="text" name="number_of_historycheck" class="form-control"
                    placeholder="<?php echo e(__('Enter how many times vendor can check history')); ?>"
                    value="<?php echo e($package->number_of_historycheck); ?>">
                  <p id="err_number_of_car_featured" class="mb-0 text-danger em"></p>
                </div>
                
                
                <p id="err_trial_days" class="mb-0 text-danger em"></p>
                <div class="form-group">
                  <label for="status"><?php echo e(__('Status')); ?>*</label>
                  <select id="status" class="form-control ltr" name="status">
                    <option value="" selected disabled><?php echo e(__('Select a status')); ?></option>
                    <option value="1" <?php echo e($package->status == '1' ? 'selected' : ''); ?>>
                      <?php echo e(__('Active')); ?></option>
                    <option value="0" <?php echo e($package->status == '0' ? 'selected' : ''); ?>>
                      <?php echo e(__('Deactive')); ?></option>
                  </select>
                  <p id="err_status" class="mb-0 text-danger em"></p>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="form">
            <div class="form-group from-show-notify row">
              <div class="col-12 text-center">
                <button type="submit" id="submitBtn" class="btn btn-success"><?php echo e(__('Update')); ?></button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
  <script src="<?php echo e(asset('assets/js/packages.js')); ?>"></script>
  <script src="<?php echo e(asset('assets/admin/js/edit-package.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/backend/packages/edit.blade.php ENDPATH**/ ?>