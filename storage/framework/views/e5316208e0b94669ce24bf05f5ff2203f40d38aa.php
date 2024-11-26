<?php if($language->direction == 1): ?>
  <?php $__env->startSection('style'); ?>
    <style>
      form:not(.modal-form.create) input, 
      form:not(.modal-form.create) textarea, 
      form:not(.modal-form.create) select {
        direction: rtl;
      }

      form:not(.modal-form.create) .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
      }
    </style>
  <?php $__env->stopSection(); ?>
<?php endif; ?>
<?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/backend/partials/rtl-style.blade.php ENDPATH**/ ?>