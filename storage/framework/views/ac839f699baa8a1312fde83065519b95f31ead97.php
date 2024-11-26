    <!-- Page title start-->
    <div class="page-title-area pt-100 bg-img <?php echo e($basicInfo->theme_version == 2 || $basicInfo->theme_version == 3 ? 'has_header_2' : ''); ?>"
      <?php if(!empty($breadcrumb)): ?> data-bg-image="<?php echo e(asset('assets/img/' . $breadcrumb)); ?>" <?php endif; ?>
      src="<?php echo e(asset('assets/front/imagesplaceholder.png')); ?>">
      <div class="container">
        <div class="content pb-20">
          <h2>
            <?php echo e(!empty($title) ? $title : ''); ?>

          </h2>
          <ul class="list-unstyled">
            <li class="d-inline"><a href="<?php echo e(route('index')); ?>"><?php echo e(__('Home')); ?></a></li>
            <li class="d-inline">/</li>
            <li class="d-inline active opacity-75"><?php echo e(!empty($title) ? $title : ''); ?></li>
          </ul>
        </div>
      </div>
    </div>
    <!-- Page title end-->
<?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/partials/breadcrumb.blade.php ENDPATH**/ ?>