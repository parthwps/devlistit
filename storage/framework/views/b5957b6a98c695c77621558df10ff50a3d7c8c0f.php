<script>
  <?php if(Session::has('message')): ?>

    var type = "<?php echo e(Session::get('alert-type')); ?>";
    if (type) {
      type = type
    } else {
      var type = "<?php echo e(Session::get('alert-type', 'info')); ?>";
    }
    switch (type) {
      case 'info':
        toastr.options = {
          "closeButton": true,
          "progressBar": true,
          "timeOut": 10000,
          "extendedTimeOut": 10000,
          "positionClass": "toast-top-right",
        }
        toastr.info("<?php echo e(Session::get('message')); ?>");
        break;
      case 'success':
        toastr.options = {
          "closeButton": true,
          "progressBar": true,
          "timeOut ": 10000,
          "extendedTimeOut": 10000,
          "positionClass": "toast-top-right",
        }
        toastr.success("<?php echo e(Session::get('message')); ?>");
        break;
      case 'warning':
        toastr.options = {
          "closeButton": true,
          "progressBar": true,
          "timeOut ": 10000,
          "extendedTimeOut": 10000,
          "positionClass": "toast-top-right",
        }
        toastr.warning("<?php echo e(Session::get('message')); ?>");
        break;
      case 'error':
        toastr.options = {
          "closeButton": true,
          "progressBar": true,
          "timeOut ": 10000,
          "extendedTimeOut": 10000,
          "positionClass": "toast-top-right",
        }
        toastr.error("<?php echo e(Session::get('message')); ?>");
        break;
    }
  <?php endif; ?>
</script>
<?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/partials/toastr.blade.php ENDPATH**/ ?>