<?php $__env->startSection('pageHeading'); ?>
  <?php if(!empty($pageHeading)): ?>
    <?php echo e($pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('Payment History')); ?>

  <?php else: ?>
    <?php echo e(__('Payment History')); ?>

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
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Payment History'),
  ])) echo $__env->make('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Payment History'),
  ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="user-dashboard pt-20 pb-60">
    <div class="container">
      
  
      
  <div class="row gx-xl-5">
  
       <?php if ($__env->exists('vendors.partials.side-custom')) echo $__env->make('vendors.partials.side-custom', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   

    
    <div class="col-md-9">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <div class="card-title d-inline-block"><?php echo e(__('Payment Log')); ?></div>
            </div>
            <div class="col-lg-3">
            </div>
            <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
              <form action="<?php echo e(url()->current()); ?>" class="d-inline-block float-right">
                <input class="form-control" type="text" name="search"
                  placeholder="<?php echo e(__('Search by Transaction ID')); ?>"
                  value="<?php echo e(request()->input('search') ? request()->input('search') : ''); ?>">
              </form>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <?php if(count($memberships) == 0): ?>
                <h3 class="text-center"><?php echo e(__('No Record Found')); ?></h3>
              <?php else: ?>
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                      <th scope="col"><?php echo e(__('Title')); ?></th>
                        <th scope="col"><?php echo e(__('Transaction Id')); ?></th>
                        <th scope="col"><?php echo e(__('Amount')); ?></th>
                        <th scope="col"><?php echo e(__('Payment Status')); ?></th>
                        
                        <th scope="col"><?php echo e(__('Download Receipt')); ?></th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $memberships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $membership): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php
                            $tranTitle = App\Models\Car::where('order_id', $membership->order_id)->first();
                          ?>
                        <?php if($tranTitle): ?>
                        <tr>
                        <td>
                          
                        <b><?php echo e($tranTitle->car_content->title); ?></b><br>
                       
                        <?php echo e(format_price($tranTitle->price)); ?>

                        </td>
                          <td>
                            
                            <?php echo e(strlen($membership->transaction_id) > 30 ? mb_substr($membership->transaction_id, 0, 30, 'UTF-8') . '...' : $membership->transaction_id); ?>

                          </td>
                          <?php
                            $bex = json_decode($membership->settings);
                          ?>
                          <td>
                            <?php if($membership->price == 0): ?>
                              <?php echo e(__('Free')); ?>

                            <?php else: ?>
                              <?php echo e(format_price($membership->price)); ?>

                            <?php endif; ?>
                          </td>
                          <td>
                            <?php if($membership->status == 1): ?>
                              <h3 class="d-inline-block badge badge-success"><?php echo e(__('Success')); ?></h3>
                            <?php elseif($membership->status == 0): ?>
                              <h3 class="d-inline-block badge badge-warning"><?php echo e(__('Pending')); ?></h3>
                            <?php elseif($membership->status == 2): ?>
                              <h3 class="d-inline-block badge badge-danger"><?php echo e(__('Rejected')); ?></h3>
                            <?php endif; ?>
                          </td>
                          
                          <td>
                            
                              <a class="btn btn-sm btn-info" href="<?php echo e(asset('assets/front/invoices/')); ?>/<?php echo e($membership->order_id); ?>-<?php echo e($membership->transaction_id); ?>.pdf" download><?php echo e(__('Download')); ?></a>
                         
                          </td>
                         <!--  <td>
                            <?php if(!empty($membership->name !== 'anonymous')): ?>
                              <a class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                data-target="#detailsModal<?php echo e($membership->id); ?>"><?php echo e(__('Detail')); ?></a>
                            <?php else: ?>
                              -
                            <?php endif; ?>
                          </td> -->
                        </tr>
                        <?php endif; ?>
                        <div class="modal fade" id="receiptModal<?php echo e($membership->id); ?>" tabindex="-1" role="dialog"
                          aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Receipt Image')); ?>

                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <?php if(!empty($membership->receipt)): ?>
                                  <img src="<?php echo e(asset('assets/front/img/membership/receipt/' . $membership->receipt)); ?>"
                                    alt="Receipt" width="100%">
                                <?php endif; ?>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?>

                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal fade" id="detailsModal<?php echo e($membership->id); ?>" tabindex="-1" role="dialog"
                          aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Owner Details')); ?>

                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <h3 class="text-warning"><?php echo e(__('Member details')); ?></h3>
                                <label><?php echo e(__('Name')); ?></label>
                                <p><?php echo e($membership->vendor->first_name . ' ' . $membership->vendor->last_name); ?></p>
                                <label><?php echo e(__('Email')); ?></label>
                                <p><?php echo e($membership->vendor->email); ?></p>
                                <label><?php echo e(__('Phone')); ?></label>
                                <p><?php echo e($membership->vendor->phone_number); ?></p>
                                <h3 class="text-warning"><?php echo e(__('Payment details')); ?></h3>
                                <p><strong><?php echo e(__('Package Price')); ?>: </strong> <?php echo e($membership->price); ?>

                                </p>
                                <p><strong><?php echo e(__('Currency')); ?>: </strong> <?php echo e($membership->currency); ?>

                                </p>
                                <p><strong><?php echo e(__('Method')); ?>: </strong> <?php echo e($membership->payment_method); ?>

                                </p>
                                <h3 class="text-warning"><?php echo e(__('Package Details')); ?></h3>
                                <p><strong><?php echo e(__('Title')); ?>:
                                  </strong><?php echo e(!empty($membership->package) ? $membership->package->title : ''); ?>

                                </p>
                               
                                <p><strong><?php echo e(__('Start Date')); ?>: </strong>
                                  <?php if(\Illuminate\Support\Carbon::parse($membership->start_date)->format('Y') == '9999'): ?>
                                    <span class="badge badge-danger"><?php echo e(__('Never Activated')); ?></span>
                                  <?php else: ?>
                                    <?php echo e(\Illuminate\Support\Carbon::parse($membership->start_date)->format('M-d-Y')); ?>

                                  <?php endif; ?>
                                </p>
                               
                                <p>
                                  <strong><?php echo e(__('Purchase Type')); ?>: </strong>
                                  <?php if($membership->is_trial == 1): ?>
                                    <?php echo e(__('Trial')); ?>

                                  <?php else: ?>
                                    <?php echo e($membership->price == 0 ? 'Free' : 'Regular'); ?>

                                  <?php endif; ?>
                                </p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                  <?php echo e(__('Close')); ?>

                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
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
              <?php echo e($memberships->links()); ?>

            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("frontend.layouts.layout-v$settings->theme_version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/vendors/payment_log.blade.php ENDPATH**/ ?>