<?php
  use App\Models\Language;
  $selLang = Language::where('code', request()->input('language'))->first();
?>
<?php if(!empty($selLang) && $selLang->rtl == 1): ?>
  <?php $__env->startSection('styles'); ?>
    <style>
      form:not(.modal-form) input,
      form:not(.modal-form) textarea,
      form:not(.modal-form) select,
      select[name='language'] {
        direction: rtl;
      }

      form:not(.modal-form) .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
      }
    </style>
  <?php $__env->stopSection(); ?>
<?php endif; ?>

<?php $__env->startSection('content'); ?>
  <div class="page-header">
    <h4 class="page-title"><?php echo e(__('Packages')); ?></h4>
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
        <a href="#"><?php echo e(__('Packages Management')); ?></a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#"><?php echo e(__('Packages')); ?></a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <div class="card-title d-inline-block"><?php echo e(__('Package Page')); ?></div>
            </div>
            <div class="col-lg-4 offset-lg-4 mt-2 mt-lg-0">
              <!--<a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal"-->
              <!--  data-target="#createModal"><i class="fas fa-plus"></i>-->
              <!--  <?php echo e(__('Add Package')); ?></a>-->
              <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete"
                data-href="<?php echo e(route('admin.package.bulk.delete')); ?>"><i class="flaticon-interface-5"></i>
                <?php echo e(__('Delete')); ?>

              </button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <?php if(count($packages) == 0): ?>
                <h3 class="text-center"><?php echo e(__('NO PACKAGE FOUND YET')); ?></h3>
              <?php else: ?>
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="basic-datatables">
                    <thead>
                      <tr>
                        <th scope="col">
                          <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col"><?php echo e(__('Title')); ?></th>
                        <th scope="col"><?php echo e(__('Cost')); ?></th>
                        <th scope="col"><?php echo e(__('Status')); ?></th>
                        <th scope="col"><?php echo e(__('Actions')); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="<?php echo e($package->id); ?>">
                          </td>
                          <td>
                            <strong><?php echo e(strlen($package->title) > 30 ? mb_substr($package->title, 0, 30, 'UTF-8') . '...' : $package->title); ?></strong> <?php if($package->term == 'monthly'): ?>
                              <small class="badge badge-primary"><?php echo e(__('Monthly')); ?></small>
                            <?php elseif($package->term == 'yearly'): ?>
                              <small class="badge badge-info"><?php echo e(__('Yearly')); ?></small>
                            <?php elseif($package->term == 'lifetime'): ?>
                              <small class="badge badge-secondary"><?php echo e(__('Lifetime')); ?></small>
                            <?php endif; ?> 
                            

                          </td>
                          <td>
                            <?php if($package->price == 0): ?>
                              <?php echo e(__('Free')); ?>

                            <?php else: ?>
                              <?php echo e(format_price($package->price)); ?>

                            <?php endif; ?>

                          </td>
                          <td>
                            <?php if($package->status == 1): ?>
                              <h2 class="d-inline-block">
                                <span class="badge badge-success"><?php echo e(__('Active')); ?></span>
                              </h2>
                            <?php else: ?>
                              <h2 class="d-inline-block">
                                <span class="badge badge-danger"><?php echo e(__('Deactive')); ?></span>
                              </h2>
                            <?php endif; ?>
                          </td>
                          <td>
                            <a class="btn btn-secondary btn-sm mt-1"
                              href="<?php echo e(route('admin.package.edit', $package->id) . '?language=' . request()->input('language')); ?>">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                            </a>
                            <!--<form class="packageDeleteForm d-inline-block" action="<?php echo e(route('admin.package.delete')); ?>"-->
                            <!--  method="post">-->
                            <!--  <?php echo csrf_field(); ?>-->
                            <!--  <input type="hidden" name="package_id" value="<?php echo e($package->id); ?>">-->
                            <!--  <button type="submit" class="btn btn-danger btn-sm  mt-1 packageDeleteBtn">-->
                            <!--    <span class="btn-label">-->
                            <!--      <i class="fas fa-trash"></i>-->
                            <!--    </span>-->
                            <!--  </button>-->
                            <!--</form>-->
                          </td>
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Create Blog Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"><?php echo e(__('Add Package')); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <form id="ajaxForm" enctype="multipart/form-data" class="modal-form"
            action="<?php echo e(route('admin.package.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
              <label for="title"><?php echo e(__('Package title')); ?>*</label>
              <input id="title" type="text" class="form-control" name="title"
                placeholder="<?php echo e(__('Enter Package title')); ?>" value="">
              <p id="err_title" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="price"><?php echo e(__('Price')); ?> (<?php echo e($settings->base_currency_text); ?>)*</label>
              <input id="price" type="number" class="form-control" name="price"
                placeholder="<?php echo e(__('Enter Package price')); ?>" value="">
              <p class="text-warning">
                <small><?php echo e(__('If price is 0 , than it will appear as free')); ?></small>
              </p>
              <p id="err_price" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="term"><?php echo e(__('Package term')); ?>*</label>
              <select id="term" name="term" class="form-control" required>
                <option value="" selected disabled><?php echo e(__('Choose a Package term')); ?></option>
                <option value="monthly"><?php echo e(__('monthly')); ?></option>
                <option value="yearly"><?php echo e(__('yearly')); ?></option>
                <option value="lifetime"><?php echo e(__('lifetime')); ?></option>
              </select>
              <p id="err_term" class="mb-0 text-danger em"></p>
            </div>

            <div class="form-group">
              <label class="form-label"><?php echo e(__('How many Adds can the Sellers add')); ?> *</label>
              <input type="text" class="form-control" name="number_of_car_add"
                placeholder="<?php echo e(__('Enter How many cars can the vendor add')); ?>">
              <p id="err_number_of_car_add" class="mb-0 text-danger em"></p>
            </div>
            
            <div class="form-group" style="display:none;" >
              <label class="form-label"><?php echo e(__('How many Adds does the sellers make  featured')); ?> *</label>
              <input type="text" value="0" name="number_of_car_featured" class="form-control"
                placeholder="<?php echo e(__('Enter how many cars does the vendor make featured')); ?>">
              <p id="err_number_of_car_featured" class="mb-0 text-danger em"></p>
            </div>
            
            
            <div class="form-group">
              <label class="form-label"><?php echo e(__('How many Bumps can the vendor use')); ?> *</label>
              <input type="text" class="form-control" name="number_of_bumps"
                placeholder="<?php echo e(__('How many Bumps can the vendor use')); ?>">
              <p id="err_number_of_car_add" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label class="form-label"><?php echo e(__('Enter how many times vendor can check history')); ?> *</label>
              <input type="text" name="number_of_historycheck" class="form-control"
                placeholder="<?php echo e(__('Enter how many times vendor can check history')); ?>">
              <p id="err_number_of_car_featured" class="mb-0 text-danger em"></p>
            </div>
            

            <div class="form-group">
              <label for="status"><?php echo e(__('Status')); ?>*</label>
              <select id="status" class="form-control ltr" name="status">
                <option value="" selected disabled><?php echo e(__('Select a status')); ?></option>
                <option value="1"><?php echo e(__('Active')); ?></option>
                <option value="0"><?php echo e(__('Deactive')); ?></option>
              </select>
              <p id="err_status" class="mb-0 text-danger em"></p>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
          <button id="submitBtn" type="button" class="btn btn-primary"><?php echo e(__('Submit')); ?></button>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
  <script src="<?php echo e(asset('assets/js/packages.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/backend/packages/index.blade.php ENDPATH**/ ?>