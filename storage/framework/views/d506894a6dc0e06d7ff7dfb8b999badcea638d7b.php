<?php $__env->startSection('content'); ?>
  <div class="page-header">
    <h4 class="page-title"><?php echo e(__('Dealer Details')); ?></h4>
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
        <a href="#"><?php echo e(__('Dealer Management')); ?></a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="<?php echo e(route('admin.vendor_management.registered_vendor')); ?>"><?php echo e(__('Registered Dealer')); ?></a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#"><?php echo e(__('Dealer Details')); ?></a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="row">

        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <div class="h4 card-title"><?php echo e(__('Dealer Information')); ?></div>
              <h2 class="text-center">
                <?php if($vendor->photo != null): ?>
                        
                        <?php
                            $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $vendor->photo;
                            
                            if (file_exists(public_path('assets/admin/img/vendor-photo/' . $vendor->photo))) {
                           
                               $photoUrl = asset('assets/admin/img/vendor-photo/' . $vendor->photo);
                            }
                        ?>
                        
                        <img src="<?php echo e($photoUrl); ?>" alt="..." class="uploaded-img" style="    max-width: 100px;
                        border-radius: 10px;
                        margin: 15px;">
                        <?php else: ?>
                          <img src="<?php echo e(asset('assets/img/noimage.jpg')); ?>" alt="..." class="uploaded-img">
                        <?php endif; ?>

              </h2>
            </div>

            <div class="card-body">
              <div class="payment-information">

                <?php
                  $currPackage = \App\Http\Helpers\VendorPermissionHelper::currPackageOrPending($vendor->id);
                  $currMemb = \App\Http\Helpers\VendorPermissionHelper::currMembOrPending($vendor->id);
                ?>
                <div class="row mb-3">
                  <div class="col-lg-6">
                    <strong><?php echo e(__('Current Package:')); ?></strong>
                  </div>
                  <div class="col-lg-6">
                    <?php if($currPackage): ?>
                      <a target="_blank"
                        href="<?php echo e(route('admin.package.edit', $currPackage->id)); ?>"><?php echo e($currPackage->title); ?></a>
                      <span class="badge badge-secondary badge-xs mr-2"><?php echo e($currPackage->term); ?></span>
                    
                    <div style="margin-top: 10px;margin-bottom: 10px;    display: flex;">
                          <button type="submit" class="btn btn-xs btn-warning" style="width: 100%;margin-right: 10px;" data-toggle="modal" data-target="#editCurrentPackage"><i class="far fa-edit"></i></button>
                      <form action="<?php echo e(route('vendor.currPackage.remove')); ?>" style="width: 100%;" class="d-inline-block deleteForm"
                        method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="vendor_id" value="<?php echo e($vendor->id); ?>">
                        <button type="submit" style="width: 100%;" class="btn btn-xs btn-danger deleteBtn"><i class="fas fa-trash"></i></button>
                      </form>
                    </div>

                      <p class="mb-0">
                        <?php if($currMemb->is_trial == 1): ?>
                          (<?php echo e(__('Expire Date') . ':'); ?>

                          <?php echo e(Carbon\Carbon::parse($currMemb->expire_date)->format('M-d-Y')); ?>)
                          <span class="badge badge-primary"><?php echo e(__('Trial')); ?></span>
                        <?php else: ?>
                          (<?php echo e(__('Expire Date') . ':'); ?>

                          <?php echo e($currPackage->term === 'lifetime' ? 'Lifetime' : Carbon\Carbon::parse($currMemb->expire_date)->format('M-d-Y')); ?>)
                        <?php endif; ?>
                        <?php if($currMemb->status == 0): ?>
                          <form id="statusForm<?php echo e($currMemb->id); ?>" class="d-inline-block"
                            action="<?php echo e(route('admin.payment-log.update')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id" value="<?php echo e($currMemb->id); ?>">
                            <select class="form-control form-control-sm bg-warning" name="status"
                              onchange="document.getElementById('statusForm<?php echo e($currMemb->id); ?>').submit();">
                              <option value=0 selected><?php echo e(__('Pending')); ?></option>
                              <option value=1><?php echo e(__('Success')); ?></option>
                              <option value=2><?php echo e(__('Rejected')); ?></option>
                            </select>
                          </form>
                        <?php endif; ?>
                      </p>
                    <?php else: ?>
                      <a data-target="#addCurrentPackage" data-toggle="modal" class="btn btn-xs btn-primary text-white"><i
                          class="fas fa-plus"></i> <?php echo e(__('Add Package')); ?></a>
                    <?php endif; ?>
                  </div>
                </div>

                <?php
                  $nextPackage = \App\Http\Helpers\VendorPermissionHelper::nextPackage($vendor->id);
                  $nextMemb = \App\Http\Helpers\VendorPermissionHelper::nextMembership($vendor->id);
                ?>
                <div class="row mb-3">
                  <div class="col-lg-6">
                    <strong><?php echo e(__('Next Package:')); ?></strong>
                  </div>
                  <div class="col-lg-6">
                    <?php if($nextPackage): ?>
                      <a target="_blank"
                        href="<?php echo e(route('admin.package.edit', $nextPackage->id)); ?>"><?php echo e($nextPackage->title); ?></a>
                      <span class="badge badge-secondary badge-xs mr-2" ><?php echo e($nextPackage->term); ?></span>
                      
                     <div style="display:flex;">
                          <button type="button" class="btn btn-xs btn-warning" data-toggle="modal"
                        data-target="#editNextPackage"><i class="far fa-edit"></i></button>
                      <form action="<?php echo e(route('vendor.nextPackage.remove')); ?>" class="d-inline-block deleteForm"
                        method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="vendor_id" value="<?php echo e($vendor->id); ?>">
                        <button type="submit" class="btn btn-xs btn-danger deleteBtn"><i
                            class="fas fa-trash"></i></button>
                      </form>
                     </div>

                      <p class="mb-0">
                        <?php if($currPackage->term != 'lifetime' && $nextMemb->is_trial != 1): ?>
                          (
                          Activation Date:
                          <?php echo e(Carbon\Carbon::parse($nextMemb->start_date)->format('M-d-Y')); ?>,
                          Expire Date:
                          <?php echo e($nextPackage->term === 'lifetime' ? 'Lifetime' : Carbon\Carbon::parse($nextMemb->expire_date)->format('M-d-Y')); ?>)
                        <?php endif; ?>
                        <?php if($nextMemb->status == 0): ?>
                          <form id="statusForm<?php echo e($nextMemb->id); ?>" class="d-inline-block"
                            action="<?php echo e(route('admin.payment-log.update')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id" value="<?php echo e($nextMemb->id); ?>">
                            <select class="form-control form-control-sm bg-warning" name="status"
                              onchange="document.getElementById('statusForm<?php echo e($nextMemb->id); ?>').submit();">
                              <option value=0 selected><?php echo e(__('Pending')); ?></option>
                              <option value=1><?php echo e(__('Success')); ?></option>
                              <option value=2><?php echo e(__('Rejected')); ?></option>
                            </select>
                          </form>
                        <?php endif; ?>
                      </p>
                    <?php else: ?>
                      <?php if(!empty($currPackage)): ?>
                        <a class="btn btn-xs btn-primary text-white" data-toggle="modal"
                          data-target="#addNextPackage"><i class="fas fa-plus"></i> <?php echo e(__('Add  Package')); ?></a>
                      <?php else: ?>
                        -
                      <?php endif; ?>
                    <?php endif; ?>
                  </div>
                </div>

                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong><?php echo e(__('Name') . ' :'); ?></strong>
                  </div>
                  <div class="col-lg-8">
                    <?php echo e(@$vendor->vendor_info->name); ?>

                  </div>
                </div>

                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong><?php echo e(__('Username') . ' :'); ?></strong>
                  </div>
                  <div class="col-lg-8">
                    <?php echo e($vendor->username); ?>

                  </div>
                </div>
                

                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong><?php echo e(__('Email') . ' :'); ?></strong>
                  </div>
                  <div class="col-lg-8">
                    <?php echo e($vendor->email); ?>

                  </div>
                </div>

                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong><?php echo e(__('Phone') . ' :'); ?></strong>
                  </div>
                  <div class="col-lg-8">
                    <?php echo e($vendor->phone); ?>

                  </div>
                </div>

                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong><?php echo e(__('Country') . ' :'); ?></strong>
                  </div>
                  <div class="col-lg-8">
                    Isle of Man
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong><?php echo e(__('City') . ' :'); ?></strong>
                  </div>
                  <div class="col-lg-8">
                    <?php echo e(ucfirst( @$vendor->vendor_info->city)); ?>

                  </div>
                </div>
             
                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong><?php echo e(__('Address') . ' :'); ?></strong>
                  </div>
                  <div class="col-lg-8">
                    <?php echo e(@$vendor->vendor_info->address); ?>

                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong><?php echo e(__('About Us') . ' :'); ?></strong>
                  </div>
                  <div class="col-lg-8">
                    <?php echo e(@$vendor->vendor_info->details); ?>

                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-lg-4">
                  <div class="card-title d-inline-block"><?php echo e(__('All Cars')); ?></div>
                </div>

                <div class="col-lg-3">
                  <?php if ($__env->exists('backend.partials.languages')) echo $__env->make('backend.partials.languages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">

                  <button class="btn btn-danger btn-sm float-right mr-2 d-none bulk-delete"
                    data-href="<?php echo e(route('admin.car_management.bulk_delete.car')); ?>">
                    <i class="flaticon-interface-5"></i> <?php echo e(__('Delete')); ?>

                  </button>
                </div>
              </div>
            </div>

            <div class="card-body">
              <div class="col-lg-12">
                <?php if(count($cars) == 0): ?>
                  <h3 class="text-center mt-2"><?php echo e(__('NO CAR FOUND') . '!'); ?></h3>
                <?php else: ?>
                  <div class="table-responsive">
                    <table class="table table-striped mt-3" id="basic-datatables">
                      <thead>
                        <tr>
                          <th scope="col">
                            <input type="checkbox" class="bulk-check" data-val="all">
                          </th>
                          <th scope="col"><?php echo e(__('Title')); ?></th>
                          <th scope="col"><?php echo e(__('Brand')); ?></th>
                          <th scope="col"><?php echo e(__('Model')); ?></th>
                          <th scope="col"><?php echo e(__('Status')); ?></th>
                          <th scope="col"><?php echo e(__('Actions')); ?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr>
                            <td>
                              <input type="checkbox" class="bulk-check" data-val="<?php echo e($car->id); ?>">
                            </td>
                            <td>
                              <?php echo e(strlen(optional($car->car_content)->title) > 40 ? mb_substr(optional($car->car_content)->title, 0, 40, 'utf-8') . '...' : optional($car->car_content)->title); ?>

                            </td>
                            <td>
                              <?php
                                $brand = $car->car_content->brand()->first();
                              ?>
                              <?php echo e($brand != null ? $brand['name'] : ''); ?>

                            </td>
                            <td>
                              <?php
                                $model = $car->car_content->model()->first();
                              ?>
                              <?php echo e($model != null ? $model['name'] : ''); ?>

                            </td>

                            <td>
                              <form id="statusForm<?php echo e($car->id); ?>" class="d-inline-block"
                                action="<?php echo e(route('admin.cars_management.update_car_status')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="carId" value="<?php echo e($car->id); ?>">

                                <select
                                  class="form-control <?php echo e($car->status == 1 ? 'bg-success' : 'bg-danger'); ?> form-control-sm"
                                  name="status"
                                  onchange="document.getElementById('statusForm<?php echo e($car->id); ?>').submit();">
                                  <option value="1" <?php echo e($car->status == 1 ? 'selected' : ''); ?>>
                                    <?php echo e(__('Active')); ?>

                                  </option>
                                  <option value="0" <?php echo e($car->status == 0 ? 'selected' : ''); ?>>
                                    <?php echo e(__('Deactive')); ?>

                                  </option>
                                </select>
                              </form>
                            </td>

                            <td>
                              <a class="btn btn-secondary btn-sm mr-1 mb-1"
                                href="<?php echo e(route('admin.cars_management.edit_car', $car->id)); ?>">
                                <span class="btn-label">
                                  <i class="fas fa-edit" class="mar--3"></i>
                                </span>
                              </a>

                              <form class="deleteForm d-inline-block"
                                action="<?php echo e(route('admin.cars_management.delete_car')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="car_id" value="<?php echo e($car->id); ?>">

                                <button type="submit" class="btn btn-danger btn-sm deleteBtn  mb-1">
                                  <span class="btn-label">
                                    <i class="fas fa-trash" class="mar--3"></i>
                                  </span>
                                </button>
                              </form>
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
    <?php if ($__env->exists('backend.end-user.vendor.edit-current-package')) echo $__env->make('backend.end-user.vendor.edit-current-package', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if ($__env->exists('backend.end-user.vendor.add-current-package')) echo $__env->make('backend.end-user.vendor.add-current-package', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if ($__env->exists('backend.end-user.vendor.edit-next-package')) echo $__env->make('backend.end-user.vendor.edit-next-package', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if ($__env->exists('backend.end-user.vendor.add-next-package')) echo $__env->make('backend.end-user.vendor.add-next-package', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/backend/end-user/dealer/details.blade.php ENDPATH**/ ?>