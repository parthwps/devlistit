<?php if($data->promo_price > 0): ?>
            <div class="col-md-12 pr-md-0 mb-1">
              <div class="card">
              <div class="m-3 d-flex justify-content-between">
                  <h4 class="card-text">Select Add-Ons </h4>
                 
                </div>
                <div class="m-3 d-flex justify-content-between">
                  <div class=""><strong>Spotlight for <?php echo e(symbolPrice($data->promo_price)); ?> </strong>
                <br>
               <small> Rotate in top promo spot for 5 days</small></div>
                  <div class=""><input <?php if(request()->get('promo') == 1): echo 'checked'; endif; ?>  data-id = "<?php echo e($data->id); ?>" class = "choosepromo" value="1" style=" top: .8rem; width: 1.55rem; height: 1.55rem;" type="checkbox" name="promoPrice"></div>
                </div> 
                
                </div>
            </div>  
        <?php endif; ?>
        <div class="col-md-12 pr-md-0 mb-3">
              <div class="card">
              <div class="m-2 d-flex justify-content-between">
                  <h4 class="card-text">Summary </h4>
                  <input id ="packageId" type="hidden" name="id" value="<?php echo e($data->id); ?>">
                </div>
                <?php if( request()->get('promo')==1 ): ?>
                <div class="m-3 d-flex justify-content-between"  >
                <?php else: ?>
                <div class="m-3 d-flex justify-content-between"  style="border-bottom:2px solid #F1F1F1">
                <?php endif; ?>
                  <div class=""><strong><?php echo e($data->title); ?> Ad </strong>Listed for <?php echo e($data->days_listing); ?> days</div>
                        <div ><strong><?php if($data->price == 0): ?>
                              <?php echo e(__('Free')); ?>

                            <?php else: ?> <?php echo e(symbolPrice($data->price)); ?>  <?php endif; ?></strong>
                        </div>
                       
                       
                </div>
               
                <?php if( request()->get('promo')==1 ): ?>
                <div class="m-3 d-flex justify-content-between"  style="border-bottom:2px solid #F1F1F1">
                        <div class=""></div>
                        <div ><strong> <?php echo e(symbolPrice($data->promo_price)); ?> </strong>
                        </div>
                        </div>
                <?php endif; ?>

                <div class="m-3 d-flex justify-content-between" >
                  <div class=""><strong >Total</strong></div>
                        <div id="totalPrice"><strong>
                                <?php if( request()->get('promo')==1 ): ?>
                                
                                <?php echo e(symbolPrice($data->promo_price+$data->price)); ?> 
                                <?php else: ?> 
                                <?php if($data->price == 0): ?>
                              <?php echo e(__('Free')); ?>

                            <?php else: ?> <?php echo e(symbolPrice($data->price)); ?>  <?php endif; ?>
                            <?php endif; ?>
                        </strong>
                        </div>
                </div>
                
              </div>
        </div>    <?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/vendors/car/packageselected.blade.php ENDPATH**/ ?>