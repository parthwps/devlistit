<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo e(__('Offline')); ?></title>
  <!-- Main css -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/front/css/style.css')); ?>">
</head>

<body>
  <!--    Error section start   -->
  <div class="error-area">
    <div>
      <div class="offline">
        <img src="<?php echo e(asset('assets/img/offline.png')); ?>" alt="">
      </div>
      <div class="text-center">
        <h2><?php echo e(__('Sorry, you are offline') . '...'); ?></h2>
      </div>
    </div>
  </div>
  <!--    Error section end   -->
</body>

</html>
<?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/offline.blade.php ENDPATH**/ ?>