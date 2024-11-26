<?php $__env->startSection('content'); ?>
  <div class="page-header">
    <h4 class="page-title">Ad Reports</h4>
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
        <a href="#">Ad Reports</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Ad Reports</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <div class="card-title d-inline-block">Ad Reports</div>
            </div>
            <div class="col-lg-3">
            </div>
            <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0 justify-content-end">
              <form action="<?php echo e(url()->current()); ?>" class="d-inline-block d-flex">
               
                <!--<input class="form-control" type="text" name="username" placeholder="<?php echo e(__('Search by Username')); ?>"-->
                <!--  value="<?php echo e(request()->input('username') ? request()->input('username') : ''); ?>">-->
                <!--<button class="dis-none" type="submit"></button>-->
              </form>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <?php if(count($reports) == 0): ?>
                <h3 class="text-center"><?php echo e(__('NO Ad Reports')); ?></h3>
              <?php else: ?>
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">Sr#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Reported Ad</th>
                        <th scope="col">Reason</th>
                        <th scope="col">Explaination</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            
                          <td>
                            <?php echo e($key = 1); ?>

                          </td>
                          
                            <td>
                                <a href="<?php echo e(route('frontend.vendor.details', ['id' => $report->vendor->id ,  'username' => $report->vendor->username])); ?>" title="<?php echo e($report->vendor->username); ?>" target="_blank">
                                    <?php echo e($report->vendor->vendor_info->name); ?>

                                </a>
                            </td>
                          
                          <td>
                              <a href="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($report->car->car_content->category_id),'slug' => $report->car->car_content->slug, 'id' => $report->car->id])); ?>" target="_blank" >
                                  <?php echo e($report->car->car_content->title); ?>

                              </a>
                          </td>
                         
                          <td><?php echo e($report->reason); ?></td>
                          <td>
                           <?php echo e($report->explaination); ?>

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
          <div class="row">
            <div class="d-inline-block mx-auto">
              <?php echo e($reports->appends(['search' => request()->input('search'), 'username' => request()->input('username')])->links()); ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/backend/payment_log/ad-reports.blade.php ENDPATH**/ ?>