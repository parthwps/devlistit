            <?php if(count($data) > 0): ?>
            <h4 class="mb-5">Choose your ad option</h4>  
              <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
              <?php if($loop->index == 1): ?>      
                <div class="col-lg-4 col-md-4 col-sm-12 pr-md-0 mb-2 custom-col-ad">
              <?php else: ?>
              <div class="col-lg-4 col-md-4 col-sm-12 pr-md-0 mb-2 mt-4 custom-col-ad">
              <?php endif; ?>    
                <div class="card-pricing-vendor">
                    <?php if($loop->index == 1): ?>
                    <div class="price-rcomm">Recommended</div>
                    
                    <?php endif; ?>
                    <div class="pricing-header">
                      <h4 class=" d-inline-block mt-4">
                      <?php echo e($data->title); ?>

                      </h4>
                    </div>
                    <div class="price-value">
                      <div class="value">
                          <h2><?php echo e(symbolPrice($data->price)); ?></h2>
                      </div>
                    </div>
                    <?php if($loop->index == 1): ?>
                     <div class="px-3 clearfix" style="margin-top: -7px;">
                    <?php else: ?>
                    <div class="px-3 clearfix">
                        <?php endif; ?>
                      <table class="table">
                          <thead>
                            <tr>
                                <td style="width: 5rem;"> Ad views </td>
                                <td>
                                <?php if($loop->index == 0): ?>  
                                  <div class="progress align-baseline">
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                      <div class="progress-bar bggrey" role="progressbar" style="width: 33%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                      <div class="progress-bar bggrey" role="progressbar" style="width: 33%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div>
                                  <?php endif; ?>
                                  <?php if($loop->index == 1): ?>  
                                  <div class="progress align-baseline">
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                      <div class="progress-bar bggrey" role="progressbar" style="width: 33%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div>
                                  <?php endif; ?>
                                  <?php if($loop->index == 2): ?>  
                                  <div class="progress align-baseline">
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div>
                                  <?php endif; ?>
                                </td>
                            </tr>
                          </thead>
                      </table>
                    </div>
                    <?php if($loop->index == 0 || $loop->index == 2): ?>
                    <ul class="pricing-content p-2">
                    <?php endif; ?>
                    <?php if($loop->index == 1): ?>
                    <ul class="pricing-content p-2">
                    <?php endif; ?>
                    
                     <?php if($data->days_listing > 0): ?>
                      <li><span class="c_check"><i class="fal fa-check"></i></span> &nbsp;<?php echo e($data->days_listing); ?> day listing</li>
                      <?php endif; ?>
                      <?php if($data->photo_allowed > 0): ?>
                      <li><span class="c_check"><i class="fal fa-check"></i></span> &nbsp;Up to <?php echo e($data->photo_allowed); ?> photos</li>
                      <?php endif; ?>
                      <?php if($data->ad_views > 0): ?>
                      <li><span class="c_check"><i class="fal fa-check"></i></span> &nbsp;<?php echo e($data->ad_views); ?>x more ad views</li>
                      <?php endif; ?>
                      <?php if($data->priority_placement > 0): ?>
                      <li><span class="c_check"><i class="fal fa-check"></i></span> &nbsp;Priority placement</li>
                      <?php endif; ?>
                    </ul>
                     <?php if($loop->index == 0 ): ?>
                      <div class="px-4  mt-4"> 
                      <?php elseif($loop->index == 1): ?>
                      <div class="px-4" style="margin-top: 15px !important;"> 
                     <?php else: ?>
                    <div class="px-4  mt-3">
                        <?php endif; ?>
                      <a href="javascript:void(0)"
                          class="choosepackage btn btn-primary btn-block btn-lg mb-3 w-100" data-id = "<?php echo e($data->id); ?>" onclick="scroll_to_bottom()"><?php echo e(__('Choose')); ?></a>
                    </div>
                </div>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            <?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/vendors/car/paymentoptions.blade.php ENDPATH**/ ?>