<?php if(count($popupInfos) > 0): ?>
  <?php $__currentLoopData = $popupInfos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $popupInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php  $type = $popupInfo->type;  ?>

    <?php if($type == 1): ?>
      <div data-popup_delay="<?php echo e($popupInfo->delay); ?>" data-popup_id="<?php echo e($popupInfo->id); ?>" data-priority="<?php echo e($popupInfo->serial_number); ?>"
        id="modal-popup-<?php echo e($popupInfo->id); ?>" class="popup-wrapper">
        <div>
          <img class="lazyload" data-src="<?php echo e(asset('assets/img/popups/' . $popupInfo->image)); ?>" class="lazy" alt="Popup Image"
            width="100%">
        </div>
      </div>
    <?php elseif($type == 2): ?>
      <div data-popup_delay="<?php echo e($popupInfo->delay); ?>" data-popup_id="<?php echo e($popupInfo->id); ?>" data-priority="<?php echo e($popupInfo->serial_number); ?>"
        id="modal-popup-<?php echo e($popupInfo->id); ?>" class="popup-wrapper">
        <div class="popup-one bg-img bg-cover" data-bg-image="<?php echo e(asset('assets/img/popups/' . $popupInfo->image)); ?>">
          <div class="popup_main-content"
            style="background-color: <?php echo e('#' . $popupInfo->background_color); ?>; opacity: <?php echo e($popupInfo->background_color_opacity); ?>;padding: 10px 10px;margin-top: 100%;">
            <h1><?php echo e($popupInfo->title); ?></h1>
            <p><?php echo e($popupInfo->text); ?></p>
            <a href="<?php echo e($popupInfo->button_url); ?>" class="popup-main-btn"
              style="background-color: <?php echo e('#' . $popupInfo->button_color); ?>;  padding: 10px 20px;
          text-decoration: none;
          display: inline-block;
          margin-top: 20px;"><?php echo e($popupInfo->button_text); ?></a>
          </div>
        </div>
      </div>
    <?php elseif($type == 3): ?>
      <div data-popup_delay="<?php echo e($popupInfo->delay); ?>" data-popup_id="<?php echo e($popupInfo->id); ?>" data-priority="<?php echo e($popupInfo->serial_number); ?>"
        id="modal-popup-<?php echo e($popupInfo->id); ?>" class="popup-wrapper">
        <div class="popup-two bg-img bg-cover" data-bg-image="<?php echo e(asset('assets/img/popups/' . $popupInfo->image)); ?>">
          <div class="popup_main-content"
            style="background-color: <?php echo e('#' . $popupInfo->background_color); ?>; opacity: <?php echo e($popupInfo->background_color_opacity); ?>;">
            <h1><?php echo e($popupInfo->title); ?></h1>
            <p><?php echo e($popupInfo->text); ?></p>

            <div class="subscribe-form">
              <form class="subscriptionForm" action="<?php echo e(route('store_subscriber')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form_group">
                  <input type="email" class="form_control" placeholder="<?php echo e(__('Enter Your Email Address')); ?>"
                    name="email_id">
                </div>

                <div class="form_group">
                  <button type="submit" class="popup-main-btn"
                    style="background-color: <?php echo e('#' . $popupInfo->button_color); ?>;">
                    <?php echo e($popupInfo->button_text); ?>

                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php elseif($type == 4): ?>
      <div data-popup_delay="<?php echo e($popupInfo->delay); ?>" data-popup_id="<?php echo e($popupInfo->id); ?>" data-priority="<?php echo e($popupInfo->serial_number); ?>"
        id="modal-popup-<?php echo e($popupInfo->id); ?>" class="popup-wrapper">
        <div class="popup-three">
          <div class="popup_main-content">
            <div class="left-bg bg-img bg-cover" data-bg-image="<?php echo e(asset('assets/img/popups/' . $popupInfo->image)); ?>">
            </div>
            <div class="right-content">
              <h1><?php echo e($popupInfo->title); ?></h1>
              <p><?php echo e($popupInfo->text); ?></p>
              <a href="<?php echo e($popupInfo->button_url); ?>" class="popup-main-btn"
                style="background-color: <?php echo e('#' . $popupInfo->button_color); ?>;"><?php echo e($popupInfo->button_text); ?></a>
            </div>
          </div>
        </div>
      </div>
    <?php elseif($type == 5): ?>
      <div data-popup_delay="<?php echo e($popupInfo->delay); ?>" data-popup_id="<?php echo e($popupInfo->id); ?>" data-priority="<?php echo e($popupInfo->serial_number); ?>"
        id="modal-popup-<?php echo e($popupInfo->id); ?>" class="popup-wrapper">
        <div class="popup-four">
          <div class="popup_main-content">
            <div class="left-bg bg-img bg-cover" data-bg-image="<?php echo e(asset('assets/img/popups/' . $popupInfo->image)); ?>">
            </div>
            <div class="right-content">
              <h1><?php echo e($popupInfo->title); ?></h1>
              <p><?php echo e($popupInfo->text); ?></p>

              <div class="subscribe-form">
                <form class="subscriptionForm" action="<?php echo e(route('store_subscriber')); ?>" method="POST">
                  <?php echo csrf_field(); ?>
                  <div class="form_group">
                    <input type="email" class="form_control" placeholder="<?php echo e(__('Enter Your Email Address')); ?>"
                      name="email_id">
                  </div>

                  <div class="form_group">
                    <button type="submit" class="popup-main-btn"
                      style="background-color: <?php echo e('#' . $popupInfo->button_color); ?>;">
                      <?php echo e($popupInfo->button_text); ?>

                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php elseif($type == 6): ?>
      <div data-popup_delay="<?php echo e($popupInfo->delay); ?>" data-popup_id="<?php echo e($popupInfo->id); ?>" data-priority="<?php echo e($popupInfo->serial_number); ?>"
        id="modal-popup-<?php echo e($popupInfo->id); ?>" class="popup-wrapper">
        <div class="popup-five bg-img bg-cover" data-bg-image="<?php echo e(asset('assets/img/popups/' . $popupInfo->image)); ?>">
          <div class="popup_main-content">
            <h1><?php echo e($popupInfo->title); ?></h1>
            <h4><?php echo e($popupInfo->text); ?></h4>

            <div class="offer-timer" data-end_date="<?php echo e($popupInfo->end_date); ?>"
              data-end_time="<?php echo e($popupInfo->end_time); ?>"></div>

            <a href="<?php echo e($popupInfo->button_url); ?>" class="popup-main-btn"
              style="background-color: <?php echo e('#' . $popupInfo->button_color); ?>;"><?php echo e($popupInfo->button_text); ?></a>
          </div>
        </div>
      </div>
    <?php else: ?>
      <div data-popup_delay="<?php echo e($popupInfo->delay); ?>" data-popup_id="<?php echo e($popupInfo->id); ?>" data-priority="<?php echo e($popupInfo->serial_number); ?>"
        id="modal-popup-<?php echo e($popupInfo->id); ?>" class="popup-wrapper">
        <div class="popup-six">
          <div class="popup_main-content">
            <div class="left-bg bg-img bg-cover" data-bg-image="<?php echo e(asset('assets/img/popups/' . $popupInfo->image)); ?>">
            </div>

            <div class="right-content bg_cover"
              style="background-color: <?php echo e('#' . $popupInfo->background_color); ?>; background-image: url(<?php echo e(asset('assets/img/popups/right-bg.png')); ?>);">
              <h1><?php echo e($popupInfo->title); ?></h1>
              <h4><?php echo e($popupInfo->text); ?></h4>

              <div class="offer-timer" data-end_date="<?php echo e($popupInfo->end_date); ?>"
                data-end_time="<?php echo e($popupInfo->end_time); ?>"></div>

              <a href="<?php echo e($popupInfo->button_url); ?>" class="popup-main-btn"
                style="background-color: <?php echo e('#' . $popupInfo->button_color); ?>;"><?php echo e($popupInfo->button_text); ?></a>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/partials/popups.blade.php ENDPATH**/ ?>