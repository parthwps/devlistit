<?php $__env->startSection('pageHeading'); ?>
  <?php if(!empty($pageHeading)): ?>
    <?php echo e($pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('Signup')); ?>

  <?php else: ?>
    <?php echo e(__('Signup')); ?>

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

        <div class="user-dashboard pt-20 pb-60" style="margin-top: 5rem;">
        <div class="container">
        <div class="row gx-xl-5">
        <?php if ($__env->exists('vendors.partials.side-custom')) echo $__env->make('vendors.partials.side-custom', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="col-12 col-lg-9">
        <div class="row">
        <div class="col-md-12"  style="padding:0px;">
        <div class="card">
        <div class="card-header">
        <div class="row">
        <div class="col-lg-12"  style="padding:0px;">
        <div class="card-title d-inline-block" style="    width: 100%;">
        <span style="font-size: 15px;font-weight: 600;"> <?php echo e(__('Messages')); ?></span>
        <button class="btn btn-info btn-sm" onclick="submitFormBtn()" style="padding: 10px 20px;float:right;">Remove</button>
        <span class="us_checkbox_zoom" style="background: white;display: flex;padding: 5px;border-radius: 2px;border: 1px solid lightgrey;float:right;    margin-right: 5px;">
        <input type="checkbox"  id="parentCheckbox"/> 
        <div style="font-size: 8px;margin-left: 5px;">Select All</div>
        </span> 
        </div>
        </div>
        </div>
        </div>

        <div class="card-body" style="padding:0px;">
          <div class="row">
            <div class="col-lg-12">

              <?php if(session()->has('course_status_warning')): ?>
                <div class="alert alert-warning">
                  <p class="text-dark mb-0"><?php echo e(session()->get('course_status_warning')); ?></p>
                </div>
              <?php endif; ?>

              <?php if(count($collection) == 0): ?>
                 <h3 class="text-center mt-2">
                     <i class='far fa-comments' style='font-size: 10rem;color: gray;'></i> <br> <span style="color: gray;font-size: 14px;font-weight: 200;">You have no new messges at the moment.</span> <br> <b style="font-size: 14px;">Why not contact a seller?</b></h3> 
                     
                 <center><a href="<?php echo e(url('ads')); ?>" class="btn btn-info mt-3">Browse ads</a></center>
              <?php else: ?>

                <?php
                 $counter = 0;
                ?>
                
                <div class="table-responsive">
                  <table class="table  "style="border-collapse: separate; " >
                   
                    <tbody>
                       
                        <form method="get" id="submitForm" action="<?php echo e(route('vendor.support_tickets.multi.delete')); ?>">
                            <?php $__currentLoopData = $collection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $carDetail = App\Models\Car::find($item->ad_id);
                            ?>
                            
                            <?php if($carDetail): ?>
                            <tr style="padding:10px; cursor:pointer;" >
                                
                            <td class="" style=" padding-right: 0px !important;padding-left: 10px !important;" >
                                <input type="checkbox" value="<?php echo e($item->id); ?>" name="removemesages[]" class="us_removeboxes"/>
                            </td>
                            
                              <td  class="us_td_img" style=" padding-right: 0px !important;padding-left: 0px !important;" onclick="window.location.href='<?php echo e(route('vendor.support_tickets.message', $item->id)); ?>'">
                              <?php if($carDetail->feature_image != null): ?>
                              <img class = "mb-1 img-thumbnail us_img_cust" style="height: 70px;width: 70px;border-radius: 50%;" width="70" src="<?php echo e(asset('assets/admin/img/car-gallery/'. $carDetail->feature_image)); ?>" >
                              <?php endif; ?>
                              
                            
                            </td>
                              <td   style="padding-left: 10px !important;"  onclick="window.location.href='<?php echo e(route('vendor.support_tickets.message', $item->id)); ?>'">
                                  
                                <h5  class="us_mrgn_td" >
                                 <?php
                                  $vedr = addUserName($item->user_id , $item->admin_id);
                                 ?>
                                     <span style="font-size: 15px;">  <?php echo e($vedr[0]); ?></span>
                                  <span class="us_timings"> <?php echo e(date('d F h:i a' , strtotime($item->messages()->latest()->first()->created_at))); ?> </span>
                                    </h5>
                                      <div>
                                      <a class="" href="<?php echo e(route('vendor.support_tickets.message', $item->id)); ?>" class="dropdown-item" style="font-weight: bold;color: gray;font-size: 13px;">
                                          
                                        <?php if(isOnline($vedr[1])[0] ): ?>
                                            <i class="fa fa-circle" aria-hidden="true" title="online" style="margin-right: 5px;font-size: 12px;color: #08c27d;"></i>   
                                        <?php else: ?>
                                            <i class="fa fa-circle" aria-hidden="true" title="offline" style="margin-right: 5px;font-size: 12px;color: gray;" ></i>
                                        <?php endif; ?>
                                   
                                        <?php echo e($item->subject); ?>   
                                        
                                        <?php if($item->messages->where('message_seen' , 0)->where('message_to' , Auth::guard('vendor')->user()->id )->count() > 0): ?>
                                            <span style="background: #ca00ca;
                                            color: white;
                                            padding: 1px 10px 3px;
                                            border-radius: 10px;
                                            font-family: sans-serif;
                                            margin-left: 5px;"> new </span> 
                                        <?php endif; ?>
                                    </a> 
                                     
                                     </div>
                                <div class="us_mrgn_btm_td"  style="margin-top: 3px;">
                                <?php echo $item->messages()->latest()->first()->reply ?? 'No messages found'; ?>  <br>
                                
                                </div>
                              </td>
                             
                              <td  class="us_hide_td" onclick="window.location.href='<?php echo e(route('vendor.support_tickets.message', $item->id)); ?>'" >
                               <?php if($carDetail->is_sold == 1 || $carDetail->status == 2 ): ?>
                               <a href="<?php echo e(route('vendor.support_tickets.message', $item->id)); ?>" style="color: orange;font-size: 17px;">Sold</a>
                               <?php else: ?>
                                <a href="<?php echo e(route('vendor.support_tickets.message', $item->id)); ?>" style="color: #3838c1;" > Reply <i class="fa fa-paper-plane" aria-hidden="true"></i></a>
                               <?php endif; ?>
                              </td>
                            </tr>
                            
                            <?php
                             $counter ++;
                            ?>
                            
                            <?php endif; ?>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </form>
                      
                    </tbody>
                  </table>
                </div>
                
                
                <?php if($counter == 0): ?>
                  <h3 class="text-center mt-2">
                     <i class='far fa-comments' style='font-size: 10rem;color: gray;'></i> <br> <span style="color: gray;font-size: 14px;font-weight: 200;">You have no new messges at the moment.</span> <br> <b style="font-size: 14px;">Why not contact a seller?</b>
                  </h3> 
                 <center><a href="<?php echo e(url('ads')); ?>" class="btn btn-info mt-3">Browse ads</a></center>
                <?php endif; ?>
                
                
              <?php endif; ?>

             
            </div>
          </div>
        </div>

        <div class="card-footer">
          <?php echo e($collection->links()); ?>

        </div>
      </div>
    </div>
  </div>  </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("frontend.layouts.layout-v$settings->theme_version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/vendors/support_ticket/index.blade.php ENDPATH**/ ?>