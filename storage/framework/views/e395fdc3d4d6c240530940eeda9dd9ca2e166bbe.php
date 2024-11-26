<?php $__env->startSection('pageHeading'); ?>
  <?php if(!empty($pageHeading)): ?>
    <?php echo e($pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('Signup')); ?>

  <?php else: ?>
    <?php echo e(__('Messages')); ?>

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
      'breadcrumb' => 123,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Messages'),
  ])) echo $__env->make('frontend.partials.breadcrumb', [
      'breadcrumb' => 123,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Messages'),
  ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="user-dashboard pt-20 pb-60">
    <div class="container">
        
  <div class="row gx-xl-5">
  
      
  <div class="col-md-8">
  <?php if($ticket->status == 3): ?> 
  <div class="row">
      <div class="col-md-12">
            <div class="alert alert-danger" role="alert">
              This conversation has been blocked.
            </div>
      </div>
</div>
<?php endif; ?>   

<?php $__env->startSection('style'); ?>

<style>
    .image-container {
            float: right;
            display: inline-block;
            height: 200px; /* Set a fixed height */
            width: auto;
            overflow: hidden; /* Hide the overflow */
        }

        .image-container img {
            height: 100%; /* Make the image fill the container's height */
            width: auto; /* Maintain aspect ratio */
            object-fit: cover; /* Optionally, cover the container */
        }
        
</style>

<?php $__env->stopSection(); ?>

     <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="card-title d-inline-block"><?php echo e(__('Message Details')); ?> </div>
                    </div>
                    <div class="col-lg-3 offset-lg-5 m mt-lg-0 text-right">
                      <a href="<?php echo e(route('vendor.support_tickets')); ?>" class="btn btn-primary btn-md"><?php echo e(__('Back')); ?></a>
                    </div>
                  </div>
                </div>
               
              </div>
            </div>

            <?php
                $carDetail = App\Models\Car::where('id', $ticket->ad_id)->first();
                $vendor = App\Models\Vendor::where('id', $ticket->user_id)->first();
                $admin = App\Models\Vendor::where('id', $ticket->admin_id)->first();
            ?>
                          
  </div>                       
  
<div class="row clearfix">

    <div class="col-lg-12">
        <div class="card chat-app">
            
            <div class="chat">
                <div class="chat-header clearfix">
                    <div class="row">
                        <div class="col-lg-8">
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                <img width="100" style="height: auto;" src="<?php echo e(asset('assets/admin/img/car-gallery/'. $carDetail->feature_image)); ?>" >
                            </a>
                          
                            <div class="chat-about">
                                <h6 class="m-b-0"><?php echo $ticket->subject; ?></h6>
                                
                                <small>
                                    <?php echo e($ticket->created_at->format('d-M-y')); ?>

                                    <?php echo e(date('h.i A', strtotime($ticket->created_at))); ?>

                                </small>
                                
                                <?php
                                 if(Auth::guard('vendor')->user()->id == $ticket->user_id)
                                 {
                                    $onlineStatus = isOnline($ticket->admin_id);
                                 }
                                 else
                                 {
                                    $onlineStatus = isOnline($ticket->user_id);
                                 }
                                ?>
                                
                                <?php if($onlineStatus[0]): ?>
                                <div style="font-size: 13px;margin-top: 8px;color: #0bd100;">Now Online</div>
                                <?php else: ?>
                                <div style="font-size: 13px;margin-top: 8px;color: #0176fc;">Last Seen : <?php echo e($onlineStatus[1]); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-lg-4 hidden-sm text-end">
                            
                        <h4 class="new-price color-primary">
                        <?php echo e(symbolPrice($carDetail->price)); ?>

                      </h4>
                        </div>
                    </div>
                </div>
                <div class="chat-history">
                    
                    
                    <ul class="m-b-0">
                   
                        <?php if(count($ticket->messages) > 0): ?>
                         <?php $__currentLoopData = $ticket->messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <?php
                         $ticketadmin = App\Models\VendorInfo::where('vendor_id', $reply->user_id)->first();
                         ?>
                         <?php if($reply->user_id ==Auth::guard('vendor')->user()->id): ?>
                         <li class="clearfix" >
                            <div class="message-data text-end">
                                <span class="message-data-time"><?php echo e($reply->created_at->format('d-M-y')); ?>

                                <?php echo e(date('h.i A', strtotime($reply->created_at))); ?></span>
                            </div>
                            <div class="message other-message float-right"><?php echo $reply->reply; ?>

                            <br>
                            <?php if($reply->file != null): ?>
                                <a href="<?php echo e(asset('assets/admin/img/support-ticket/' . $reply->file)); ?>" target="_blank"> 
                                    <img src="<?php echo e(asset('assets/admin/img/support-ticket/' . $reply->file)); ?>" class="img-thumbnail" style="width: 150px;height: auto;" alt="Cinque Terre"> 
                                </a>
                            <?php endif; ?>
                            </div>                                    
                        </li> 
                        <?php else: ?> 
                       
                        <li class="clearfix">
                            <div class="message-data">
                            <?php echo e($ticketadmin->name); ?>

                                <span class="message-data-time"><?php echo e($reply->created_at->format('d-M-y')); ?>

                                <?php echo e(date('h.i A', strtotime($reply->created_at))); ?></span>
                            </div>
                            <div class="message my-message"><?php echo $reply->reply; ?><br>
                            <?php if($reply->file != null): ?>
                            <img src="<?php echo e(asset('assets/admin/img/support-ticket/' . $reply->file)); ?>" class="img-thumbnail" alt="Cinque Terre">
                            <?php endif; ?>
                          </div>                                    
                        </li>
                        <?php endif; ?> 
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>                              
                       
                    </ul>
                </div>
                <?php if($ticket->status != 3): ?> 
                <?php if($carDetail->status != 2 && $carDetail->is_sold == 0 ): ?> 
               <div style="background-color:#F5F5F5; padding:20px;">
                    <div  class="chat-messassge clearfix">
                        
                        <div class="card-title fw-mediumbold mb-2" ><?php echo e(__('Reply to Message')); ?></div>
                        <form action="<?php echo e(route('vendor.support_ticket.reply', $ticket->id)); ?>" id="ajaxform" method="POST"
                            enctype="multipart/form-data"><?php echo csrf_field(); ?>
                            
                            <input type="hidden" name="car_id" value="<?php echo e($ticket->ad_id); ?>" />
                            <?php if($ticket->user_id == Auth::guard('vendor')->user()->id): ?>
                          <input type="hidden" name="message_to" value="<?php echo e($ticket->admin_id); ?>">
                          <?php else: ?>
                          <input type="hidden" name="message_to" value="<?php echo e($ticket->user_id); ?>">
                          <?php endif; ?> 
                                 <div class="input-group mb-0 w-60">
                                  <textarea name="reply" class="form-control" ></textarea>
                                  <p class="em text-danger mb-0" id="errreply"></p>                                   
                                 </div>
                                  <div class="input-group">
                                    <div class="custom-file mt-3" style="width:100%">
                                      <input type="file" name="file" id="imageInput" class="custom-file-input"
                                        data-href="<?php echo e(route('vendor.support_ticket.zip_file.upload')); ?>" name="file" id="zip_file" accept="image/*" >
                                       <div class="image-container" style="display:none;">
                                     <img id="imagePreview" src="#" alt="Your Image" style="display:none;float: right;">
                                     </div>
                                    </div>
                                  </div>  
                            <div class="form-group mt-2">
                              <button type="submit" class="btn btn-success"><?php echo e(__('Send')); ?></button>
                            </div>
                      </form>
                    </div>
                </div>
                <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                  <p class="em text-danger mb-0"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php endif; ?>
                <?php endif; ?>
                
                 <?php if($carDetail->is_sold == 1 || $carDetail->status == 2): ?>
                 
                <center style="padding: 1rem;background: #e6e6e6;">This item is now sold!</center>
              
                <?php else: ?>
                
                <div class="card-footer text-muted d-flex justify-content-between">
                <div>
                <form class="deleteForm"  action="<?php echo e(route('vendor.support_tickets.delete', $ticket->id)); ?>" method="post">
                                  <?php echo csrf_field(); ?>
                                        
                          <button type="submit" class="deleteBtn"><i class="fas fa-trash" style="color:#7a7575;"></i> Delete Conversation</button>
                </form>
                  </div>
                
                    <?php if(!empty($ticket->blocked_by) && $ticket->blocked_by == 'admin'): ?>
                    
                    <div class="text-danger">This conversation is blocked by admin.</div>
                    
                    <?php else: ?>
                    <div >
                    
                    <a href="javascript:void();" data-toggle="modal" data-target="#exampleModal" class="text-end"><i class="fas fa-flag" style="color:#7a7575;"></i> Report user</a>
                    <?php if($ticket->status == 2): ?>
                    <a href="<?php echo e(route('vendor.support_tickets.block', $ticket->id)); ?>" style="padding-left:15px; color:#7a7575;" class="text-end"><i class="fas fa-exclamation"></i> Block Conversation</a>
                    <?php elseif($ticket->status == 3): ?>
                    <a href="<?php echo e(route('vendor.support_tickets.unblock', $ticket->id)); ?>" style="padding-left:15px; color:#7a7575;" class="text-end"><i class="fas fa-exclamation"></i> Unblock Conversation</a>
                    <?php endif; ?>
                    
                    </div>
                    
                    <?php endif; ?>
                    
              </div>
             
             <?php endif; ?>
        </div>

    




  </div>
</div>
</div></div>
  <div class="col-md-4">
  <div class="row">
  <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-12" style="display:flex;">
                
                  <div class="user-img" style="max-width: 80px">
                    <div class="lazy-container ratio ratio-1-1 rounded-pill">
                      <?php if($admin->photo != null): ?>
                        <img class="lazyload"
                          data-src="<?php echo e($admin->vendor_type == 'normal' ? asset('assets/admin/img/vendor-photo/' . $admin->photo) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $admin->photo); ?>"
                          alt="">
                      <?php else: ?>
                        <img class="lazyload" data-src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>" alt="">
                      <?php endif; ?>
                    </div>
                  </div>
                  
              <h6 style="margin-left: 1rem;margin-top: 10px;font-weight: 100;color: gray;line-height: 23px;" class="us_font_messge"> 
              
                    <?php echo e($admin->vendor_info->name); ?>  
                    
                    <br> 
                        <span><?php echo e(ucfirst($admin->vendor_info->city)); ?></span> - <span><?php echo e(($admin->vendor_type == 'normal') ? 'Private Seller' : 'Dealer'); ?></span> 
                    <br>
                    
                    <?php if( (!empty($admin->phone_verified) && $admin->phone_verified == 1) || !empty($admin->email_verified_at) ): ?>
                       <span>Verified <i class="fa fa-check" style="color: #0ae00a;margin-right: 5px;" aria-hidden="true"></i> </span> 
                    <?php endif; ?>
                    
                    <?php if(!empty($admin->email_verified_at)): ?>
                    <span>Email <i class="fa fa-check" style="color: #0ae00a;margin-right: 5px;" aria-hidden="true"></i> </span> 
                    <?php endif; ?>
                    
                    <?php if(!empty($admin->phone_verified) && $admin->phone_verified == 1): ?>
                    <span>Phone <i class="fa fa-check" style="color: #0ae00a;margin-right: 5px;" aria-hidden="true"></i> </span>
                    <?php endif; ?>
                    
              </h6>
              
            </div>
            
            <?php if($admin->cars->where('status' , 1)->count() > 0 ): ?>
              <div class="col-lg-12" >
                  <a class="btn " style="width: 100%;background: transparent;margin-top: 2rem;color: #868181;border: 1px solid #c8c8c8;" href="<?php echo e(route('frontend.vendor.details',$admin->id, ['username' => $admin->username])); ?>">View All Ads (<?php echo e($admin->cars->where('status' , 1)->count()); ?>)</a>
                  
              </div>
            <?php endif; ?>
          </div>
        </div>
    </div>
    </div>  </div> </div>
    </div>
  </div>
  </div>
  </div>
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <form action="<?php echo e(route('vendor.support_ticket.report')); ?>" enctype="multipart/form-data" method="POST">
    <div class="modal-content">
      <div class="modal-header">
       Report This User
      
        <?php echo csrf_field(); ?>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           
            <div class="user mb-20">
               <div class="row">
              <div class="col-2">
                  
                </div> 
                 <div class="col-8"> 
                  <div class="user-info">
                   
                 
                  </div>
            </div>

            </div>
           <div class="row">
              <div class="col-10"> 
              <div class="form-group">
                <label for="exampleFormControlSelect1">Reason</label>
                <select class="form-control" id="exampleFormControlSelect1">
                  <option value="Inappropriate or offensive">Inappropriate or offensive</option>
                  <option value="Feels like spam">Feels like spam</option>
                  <option value="Other">Other</option>
              
                </select>
              </div> 
              <div class="form-group">
              <label for="exampleInputPassword1">Comment</label>
                  <textarea required id="en_description" class="form-control " name="description" data-height="150"></textarea>
            </div></div>
          </div> </div> 
      </div>
      <div class="modal-footer justify-content-between">
        
        <button type="submit" value="Submit" class="btn btn-primary">Send </button>
      </div>
    </div>
  </form>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
<!-- Popper JS -->
<script src="<?php echo e(asset('assets/js/popper.min.js')); ?>"></script>
<!-- Bootstrap JS -->
<script src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>
  

<?php $__env->stopSection(); ?>

<?php echo $__env->make("frontend.layouts.layout-v$settings->theme_version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/vendors/support_ticket/messages.blade.php ENDPATH**/ ?>