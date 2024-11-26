<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<?php $__env->startSection('content'); ?>
  <div class="page-header">
    <h4 class="page-title"><?php echo e(__('Registered Sellers')); ?></h4>
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
        <a href="#"><?php echo e(__('Sellers Management')); ?></a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#"><?php echo e(__('Registered Sellers')); ?></a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <div class="card-title"><?php echo e(__('All Sellers')); ?></div>
            </div>

            <div class="col-lg-8">
              <button class="btn btn-danger btn-sm float-right d-none bulk-delete mr-2 ml-3 mt-1"
                data-href="<?php echo e(route('admin.vendor_management.bulk_delete_vendor')); ?>">
                <i class="flaticon-interface-5"></i> <?php echo e(__('Delete')); ?>

              </button>

              <form class="float-right" style="display: flex;width: 100%;" action="<?php echo e(route('admin.vendor_management.registered_vendor')); ?>" method="GET">
                  
                <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;border-radius: 0;">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
                <input type="hidden" name="dateRange" id="dateRange"/>
                &nbsp;&nbsp;&nbsp;
                <input name="info" type="text" class="form-control min-230"
                  placeholder="Search By Username or Email ID"
                  value="<?php echo e(!empty(request()->input('info')) ? request()->input('info') : ''); ?>">
                  
                 &nbsp; &nbsp;&nbsp;<input type="submit" class="btn btn-success"  value="Search"/>
              </form>
            </div>
            
            
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <?php if(count($vendors) == 0): ?>
                <h3 class="text-center"><?php echo e(__('NO Sellers FOUND') . '!'); ?></h3>
              <?php else: ?>
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">
                          <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">Name</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">Phone Number</th>
                         <th scope="col">Account Created</th>
                        <th scope="col"><?php echo e(__('Account Status')); ?></th>
                        <th scope="col"><?php echo e(__('Email Status')); ?></th>
                        <th scope="col"><?php echo e(__('Actions')); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="<?php echo e($vendor->id); ?>">
                          </td>
                          <td><?php echo e(ucwords($vendor->username)); ?></td>
                          <td><?php echo e(ucwords($vendor->email)); ?></td>
                          <td><?php echo e(empty($vendor->phone) ? '-' : $vendor->phone); ?></td>
                          <td style="width: 150px;"><?php echo e(date('d F,Y' , strtotime($vendor->created_at))); ?></td>
                          <td>
                            <form id="accountStatusForm-<?php echo e($vendor->id); ?>" class="d-inline-block"
                              action="<?php echo e(route('admin.vendor_management.vendor.update_account_status', ['id' => $vendor->id])); ?>"
                              method="post">
                              <?php echo csrf_field(); ?>
                              <select
                                class="form-control form-control-sm <?php echo e($vendor->status == 1 ? 'bg-success' : 'bg-danger'); ?>"
                                name="account_status"
                                onchange="document.getElementById('accountStatusForm-<?php echo e($vendor->id); ?>').submit()">
                                <option value="1" <?php echo e($vendor->status == 1 ? 'selected' : ''); ?>>
                                  <?php echo e(__('Active')); ?>

                                </option>
                                <option value="0" <?php echo e($vendor->status == 0 ? 'selected' : ''); ?>>
                                  <?php echo e(__('Deactive')); ?>

                                </option>
                              </select>
                            </form>
                          </td>
                          <td>
                            <form id="emailStatusForm-<?php echo e($vendor->id); ?>" class="d-inline-block"
                              action="<?php echo e(route('admin.vendor_management.vendor.update_email_status', ['id' => $vendor->id])); ?>"
                              method="post">
                              <?php echo csrf_field(); ?>
                              <select
                                class="form-control form-control-sm <?php echo e($vendor->email_verified_at != null ? 'bg-success' : 'bg-danger'); ?>"
                                name="email_status"
                                onchange="document.getElementById('emailStatusForm-<?php echo e($vendor->id); ?>').submit()">
                                <option value="1" <?php echo e($vendor->email_verified_at != null ? 'selected' : ''); ?>>
                                  <?php echo e(__('Verified')); ?>

                                </option>
                                <option value="0" <?php echo e($vendor->email_verified_at == null ? 'selected' : ''); ?>>
                                  <?php echo e(__('Unverified')); ?>

                                </option>
                              </select>
                            </form>
                          </td>
                          <td>
                            <div class="dropdown">
                              <button class="btn btn-secondary dropdown-toggle btn-sm" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo e(__('Select')); ?>

                              </button>

                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="<?php echo e(route('admin.vendor_management.vendor_details', ['id' => $vendor->id, 'language' => $defaultLang->code])); ?>"
                                  class="dropdown-item">
                                  <?php echo e(__('Details & Package')); ?>

                                </a>

                                <a href="<?php echo e(route('admin.edit_management.vendor_edit', ['id' => $vendor->id])); ?>"
                                  class="dropdown-item">
                                  <?php echo e(__('Edit')); ?>

                                </a>

                                <a href="<?php echo e(route('admin.vendor_management.vendor.change_password', ['id' => $vendor->id])); ?>"
                                  class="dropdown-item">
                                  <?php echo e(__('Change Password')); ?>

                                </a>

                                <form class="deleteForm d-block"
                                  action="<?php echo e(route('admin.vendor_management.vendor.delete', ['id' => $vendor->id])); ?>"
                                  method="post">
                                  <?php echo csrf_field(); ?>
                                  <button type="submit" class="deleteBtn">
                                    <?php echo e(__('Delete')); ?>

                                  </button>
                                </form>
                                <a target="_blank"
                                  href="<?php echo e(route('admin.vendor_management.vendor.secret_login', ['id' => $vendor->id])); ?>"
                                  class="dropdown-item">
                                  <?php echo e(__('Secret Login')); ?>

                                </a>
                              </div>
                            </div>
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
              <?php echo e($vendors->appends(['info' => request()->input('info')])->links()); ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
    
<?php if(!empty(request()->dateRange)): ?>
<input type="hidden" value="<?php echo e($startdate); ?>" id="startdate" /> 
<input type="hidden" value="<?php echo e($enddate); ?>" id="enddate" /> 
<?php endif; ?>


<?php $__env->stopSection(); ?>



<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>

<script type="text/javascript">

$(function() {
    
    var startDate = $('#startdate').val();
    var endDate = $('#enddate').val();

    // Default format for start and end dates
    var dateFormat = 'YYYY-MM-DD'; // Format from PHP

    // Ensure valid dates
    if (!startDate || !moment(startDate, dateFormat, true).isValid()) {
        startDate = moment().subtract(29, 'days');
    } else {
        startDate = moment(startDate, dateFormat);
    }

    if (!endDate || !moment(endDate, dateFormat, true).isValid()) {
        endDate = moment();
    } else {
        endDate = moment(endDate, dateFormat);
    }

  
    function cb(selectedStart, selectedEnd) {
        $('#reportrange span').html(selectedStart.format('MMMM D, YYYY') + ' - ' + selectedEnd.format('MMMM D, YYYY'));
        $('#dateRange').val(selectedStart.format('MMMM D, YYYY') + ' - ' + selectedEnd.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: startDate,
        endDate: endDate,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, function(selectedStart, selectedEnd) {
        cb(selectedStart, selectedEnd);
    });

    cb(moment(startDate), moment(endDate));

});



</script>


<?php echo $__env->make('backend.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/backend/end-user/vendor/index.blade.php ENDPATH**/ ?>