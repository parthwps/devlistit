<?php
    $verify =  App\Models\Vendor::where('id', Auth::guard('vendor')->user()->id)->first();
?>
    <?php if($verify->phone_verified != 1 && $verify->email_verified_at == NULL): ?>
        <div class="alert alert-warning text-dark">
            <?php echo e(__('Your profile is not completed, please complete profile.')); ?> <a href="<?php echo e(route('vendor.edit.profile')); ?>">
                        <strong style="color: red;"><?php echo e(__('Update profile')); ?></strong>
                      </a>
          </div>
    <?php endif; ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/vendors/verify.blade.php ENDPATH**/ ?>