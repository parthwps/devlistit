<?php if ($__env->exists('backend.partials.rtl_style')) echo $__env->make('backend.partials.rtl_style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>
  <div class="page-header">
    <h4 class="page-title"><?php echo e(__('Cars')); ?></h4>
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
        <a href="#"><?php echo e(__('Cars Management')); ?></a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#"><?php echo e(__('Cars')); ?></a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-3">
              <div class="card-title d-inline-block"><?php echo e(__('Cars')); ?></div>
            </div>

            <div class="col-lg-6">
              <form action="<?php echo e(route('admin.car_management.car')); ?>" method="get" id="carSearchForm">
                <div class="row">
                    
                <input type="hidden" name="status" value="<?php echo e(request()->status); ?>" />
                
                <div class="<?php if(!empty(request()->status)): ?> col-lg-4 <?php else: ?> col-lg-6  <?php endif; ?>">
                <select name="vendor_id" id="" class="select2"
                  onchange="document.getElementById('carSearchForm').submit()">
                    <option value="" disabled>Choose vendor</option>
                  <option value="" ><?php echo e(__('All')); ?></option>
                  <option value="admin" <?php if(request()->input('vendor_id') == 'admin'): echo 'selected'; endif; ?>><?php echo e(__('Admin')); ?></option>
                  <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php if($vendor->id == request()->input('vendor_id')): echo 'selected'; endif; ?> value="<?php echo e($vendor->id); ?>"><?php echo e($vendor->username); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                </div>
                
                <?php if(!empty(request()->status)): ?>
                
                <div class="col-lg-4">
                <select name="rating" id="" class="select2"
                  onchange="document.getElementById('carSearchForm').submit()">
                  <option value="" selected>Choose rating</option>
                  <?php for($i=1; $i<=10; $i++): ?>
                    <option <?php if($i == request()->input('rating')): echo 'selected'; endif; ?> value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                  <?php endfor; ?>
                </select>
                </div>
                
                <?php endif; ?>
                
                <div class="<?php if(!empty(request()->status)): ?> col-lg-4 <?php else: ?> col-lg-6  <?php endif; ?>">
                <input type="text" name="title" value="<?php echo e(request()->input('title')); ?>" class="form-control"  placeholder="Title">
                </div>
                  
                </div>
              </form>
            </div>

            <div class="col-lg-3 mt-2 mt-lg-0">
              <a href="<?php echo e(route('admin.cars_management.create_car')); ?>" class="btn btn-primary btn-sm float-right"><i
                  class="fas fa-plus"></i> <?php echo e(__('Add Car')); ?></a>

              <button class="btn btn-danger btn-sm float-right mr-2 d-none bulk-delete"
                data-href="<?php echo e(route('admin.car_management.bulk_delete.car')); ?>"><i class="flaticon-interface-5"></i>
                <?php echo e(__('Delete')); ?></button>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <?php if(count($cars) == 0): ?>
                <h3 class="text-center"><?php echo e((empty(request()->status)) ?  __('NO CARS ARE FOUND!') : __('NO REVIEWS FOUND!')); ?></h3>
              <?php else: ?>
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">
                          <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col"><?php echo e(__('Title')); ?></th>
                        <th scope="col"><?php echo e(__('Vendor')); ?></th>
                        <th scope="col"><?php echo e(__('Brand')); ?></th>
                        <th scope="col"><?php echo e(__('Model')); ?></th>
                        <th scope="col"><?php echo e(__('Featured')); ?></th>
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
                            <?php
                              $car_content = $car->car_content;
                              if (is_null($car_content)) {
                                  $car_content = $car->car_content()->first();
                              }
                            ?>
                            <?php if(!empty($car_content)): ?>
                              <a href=" <?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car->id])); ?>"
                                target="_blank">
                                <?php echo e(strlen(@$car_content->title) > 50 ? mb_substr(@$car_content->title, 0, 50, 'utf-8') . '...' : @$car_content->title); ?>

                              </a>
                            <?php endif; ?>
                          </td>
                          <td>
                              <?php if($car->vendor): ?>
                              
                            <?php if($car->vendor_id != 0): ?>
                              <a
                                href="<?php echo e(route('admin.vendor_management.vendor_details', ['id' => @$car->vendor->id, 'language' => $defaultLang->code])); ?>"><?php echo e(@$car->vendor->username); ?></a>
                            <?php else: ?>
                              <span class="badge badge-success"><?php echo e(__('Admin')); ?></span>
                            <?php endif; ?>
                            
                            <?php else: ?>
                             Deleted
                            <?php endif; ?>
                          </td>
                          <td>
                            <?php
                              if ($car->car_content) {
                                  $brand = $car->car_content->brand()->first();
                              } else {
                                  $brand = null;
                              }
                            ?>
                            <?php echo e($brand != null ? $brand['name'] : '-'); ?>

                          </td>
                          <td>
                            <?php
                              if ($car->car_content) {
                                  $model = $car->car_content->model()->first();
                              } else {
                                  $model = null;
                              }
                            ?>
                            <?php echo e($model != null ? $model['name'] : '-'); ?>

                          </td>
                          <td>
                            <?php if($car->vendor_id == 0): ?>
                              <form id="featureForm<?php echo e($car->id); ?>" class="d-inline-block"
                                action="<?php echo e(route('admin.cars_management.update_featured_car')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="carId" value="<?php echo e($car->id); ?>">

                                <select
                                  class="form-control <?php echo e($car->is_featured == 1 ? 'bg-success' : 'bg-danger'); ?> form-control-sm"
                                  name="is_featured"
                                  onchange="document.getElementById('featureForm<?php echo e($car->id); ?>').submit();">
                                  <option value="1" <?php echo e($car->is_featured == 1 ? 'selected' : ''); ?>>
                                    <?php echo e(__('Yes')); ?>

                                  </option>
                                  <option value="0" <?php echo e($car->is_featured == 0 ? 'selected' : ''); ?>>
                                    <?php echo e(__('No')); ?>

                                  </option>
                                </select>
                              </form>
                            <?php else: ?>
                              <?php echo e('-'); ?>

                            <?php endif; ?>
                          </td>

                          <td>
                            
                            <?php if(request()->status === 'sold'): ?>
                            <span class="text-info">Sold</span>
                            <?php elseif(request()->input('status') === 'removed'): ?>
                            <span class="text-warning">Removed</span>
                            <?php else: ?>

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
                            
                            <?php endif; ?>
                            
                          </td>

                          <td>
                              <?php if(empty(request()->input('status'))): ?>
                              
                              <?php if($car->support_tickets->count() > 0 ): ?>
                              <a class="btn btn-info  mt-1 btn-sm mr-1"
                              href="<?php echo e(route('admin.support_tickets', ['ad_id' => $car->id])); ?>">
                              <span class="btn-label">
                                <i class="fas fa-file"></i>
                              </span>
                            </a>
                              <?php endif; ?>
                              
                            <a class="btn btn-secondary  mt-1 btn-sm mr-1"
                              href="<?php echo e(route('admin.cars_management.edit_car', $car->id)); ?>">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                            </a>
                            
                            <?php else: ?>
                            
                            <a class="btn btn-info  mt-1 btn-sm mr-1" href="javascript:void(0);" title="Read user Remarks" data-remark="<?php echo e($car->remove_option); ?>" data-recommendation="<?php echo e($car->recommendation); ?>" data-remove_remarks="<?php echo e($car->remove_remarks); ?>" onclick="remarksRead(this)">
                              <span class="btn-label">
                                <i class="fas fa-file"></i>
                              </span>
                            </a>
                            
                            <?php endif; ?>

                            <form class="deleteForm d-inline-block"
                              action="<?php echo e(route('admin.cars_management.delete_car')); ?>" method="post">
                              <?php echo csrf_field(); ?>
                              <input type="hidden" name="car_id" value="<?php echo e($car->id); ?>">

                              <button type="submit" class="btn btn-danger  mt-1 btn-sm deleteBtn">
                                <span class="btn-label">
                                  <i class="fas fa-trash"></i>
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

        <div class="card-footer">
          <?php echo e($cars->appends([
                  'vendor_id' => request()->input('vendor_id'),
                  'title' => request()->input('title'),
                  'status' => request()->input('status'),
                  'language' => request()->input('language'),
              ])->links()); ?>

        </div>

      </div>
    </div>
  </div>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/backend/car/index.blade.php ENDPATH**/ ?>