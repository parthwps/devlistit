<?php if(!empty($langs)): ?>
  <select name="language" class="form-control" onchange="window.location='<?php echo e(url()->current() . '?language='); ?>' + this.value">
    <option selected disabled><?php echo e(__('Select a Language')); ?></option>
    <?php $__currentLoopData = $langs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($lang->code); ?>" <?php echo e($lang->code == request()->input('language') ? 'selected' : ''); ?>>
        <?php echo e($lang->name); ?>

      </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>
<?php endif; ?>
<?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/backend/partials/languages.blade.php ENDPATH**/ ?>