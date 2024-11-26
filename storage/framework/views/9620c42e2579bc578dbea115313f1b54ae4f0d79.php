<?php $__env->startSection('content'); ?>
  <div class="page-header">
    <h4 class="page-title"><?php echo e(__('Add Dealer')); ?></h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="<?php echo e(route('admin.dashboard')); ?>">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#"><?php echo e(__('Dealer Management')); ?></a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#"><?php echo e(__('Add Dealer')); ?></a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-12">
              <div class="card-title"><?php echo e(__('Add Dealer')); ?></div>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-10 mx-auto">
              <form id="ajaxEditForm" action="<?php echo e(route('admin.vendor_management.save-vendor')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label for=""><?php echo e(__('Photo')); ?></label>
                      <br>
                      <div class="thumb-preview">
                        <img src="<?php echo e(asset('assets/img/noimage.jpg')); ?>" alt="..." class="uploaded-img">
                      </div>
                      <div class="mt-3">
                        <div role="button" class="btn btn-primary btn-sm upload-btn">
                          <?php echo e(__('Choose Photo')); ?>

                          <input type="file" class="img-input" name="photo">
                        </div>
                        <p id="editErr_photo" class="mt-1 mb-0 text-danger em"></p>
                      </div>
                    </div>
                  </div>

                <input type="hidden" name="vendor_type" value="dealer" />
              
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label><?php echo e(__('Username*')); ?></label>
                      <input type="text" value="" class="form-control"  autocomplete="new-username" name="username"
                        placeholder="<?php echo e(__('Enter Username')); ?>">
                      <p id="editErr_username" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label><?php echo e(__('Password *')); ?></label>
                      <input type="password" value="" class="form-control"  autocomplete="new-password" name="password"
                        placeholder="<?php echo e(__('Enter Password')); ?> ">
                      <p id="editErr_password" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label><?php echo e(__('Email*')); ?></label>
                      <input type="text" value="" class="form-control"  autocomplete="new-email" name="email"
                        placeholder="<?php echo e(__('Enter Email')); ?>">
                      <p id="editErr_email" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label><?php echo e(__('Phone')); ?></label>
                      <input type="tel" value="" class="form-control"  name="phone"
                        placeholder="<?php echo e(__('Enter Phone')); ?>">
                      <p id="editErr_phone" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>

                </div>
                
                
                <div class="col-lg-12">
                        <div class="form-group">
                                <label style="width: 100%;
                                background: #9f9b9b;
                                padding: 15px;
                                text-align: center;
                                color: white !important;
                                border-radius: 5px;
                                margin-bottom: 2rem;">
                                    Opening Hours
                                </label>
                            
                            <table style='width: 100%;'>
                                    <tr>
                                        <th>Day</th>
                                        <th>Opening Time</th>
                                        <th>Closing Time</th>
                                        <th>Closed</th>
                                    </tr>
                                <?php $__currentLoopData = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td style="margin-right:150px;"><?php echo e($day); ?></td>
                                        <td>
                                        <input type="time" name="opening_hours[<?php echo e(strtolower($day)); ?>][open_time]" value="" style="margin-top: 1rem;" class="form-control" required>
                                        </td>
                                        <td>
                                        <input type="time" name="opening_hours[<?php echo e(strtolower($day)); ?>][close_time]" value="" style="margin-top: 1rem;    margin-left: 1rem;"  class="form-control" required>
                                        </td>
                                        <td>
                                        <input type="checkbox" name="opening_hours[<?php echo e(strtolower($day)); ?>][holiday]"   style="margin-top: 10px;margin-left: 1rem;zoom: 2;"  value="1">
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </table>
                        
                        
                        </div>
                    </div>
                    
                    
                    
                <div id="accordion" class="mt-5">
                  <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="version">
                      <div class="version-header" id="heading<?php echo e($language->id); ?>">
                        <h5 class="mb-0">
                          <button type="button"
                            class="btn btn-link <?php echo e($language->direction == 1 ? 'rtl text-right' : ''); ?>"
                            data-toggle="collapse" data-target="#collapse<?php echo e($language->id); ?>"
                            aria-expanded="<?php echo e($language->is_default == 1 ? 'true' : 'false'); ?>"
                            aria-controls="collapse<?php echo e($language->id); ?>">
                            <?php echo e($language->name . __(' Language')); ?> <?php echo e($language->is_default == 1 ? '(Default)' : ''); ?>

                          </button>
                        </h5>
                      </div>

                      <div id="collapse<?php echo e($language->id); ?>"
                        class="collapse <?php echo e($language->is_default == 1 ? 'show' : ''); ?>"
                        aria-labelledby="heading<?php echo e($language->id); ?>" data-parent="#accordion">
                        <div class="version-body">
                          <div class="row">
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label><?php echo e(__('Name*')); ?></label>
                                <input type="text" value="" class="form-control"
                                  name="<?php echo e($language->code); ?>_name" placeholder="<?php echo e(__('Enter Name')); ?>">
                                <p id="editErr_<?php echo e($language->code); ?>_name" class="mt-1 mb-0 text-danger em"></p>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label><?php echo e(__('Country')); ?></label>
                                <input type="text"  class="form-control"
                                  name="<?php echo e($language->code); ?>_country" readonly value="Isle of Man" placeholder="<?php echo e(__('Enter Country')); ?>">
                                <p id="editErr_<?php echo e($language->code); ?>_country" class="mt-1 mb-0 text-danger em"></p>
                              </div>
                            </div>
                             <div class="col-lg-4">
                              <div class="form-group">
                                <label>Area</label>
                                
                                    <select name="<?php echo e($language->code); ?>_city" id="" class="form-control">
                                        <option value="">Please select...</option>
                                        <?php $__currentLoopData = $countryArea; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($area->slug); ?>" ><?php echo e($area->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    
                                <p id="editErr_<?php echo e($language->code); ?>_city" class="mt-1 mb-0 text-danger em"></p>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label>Established Year</label>
                                
                                   <select name="est_year" class="form-control" id="yearpicker" ></select>
                                    
                                <p id="est_year" class="mt-1 mb-0 text-danger em"></p>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label>Website Url</label>
                                <input type="text" value="" class="form-control"
                                  name="website_link" placeholder="<?php echo e(__('Enter Website Url')); ?>">
                                <p id="website_link" class="mt-1 mb-0 text-danger em"></p>
                              </div>
                            </div>
                            
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label>Customer ID For Google Review</label>
                                <input type="text" value="" class="form-control"
                                  name="google_review_id" placeholder="<?php echo e(__('Enter Customer ID For Google Review')); ?>">
                              </div>
                            </div>
                            
                            
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label><?php echo e(__('Address')); ?></label>
                                <textarea name="<?php echo e($language->code); ?>_address" class="form-control" placeholder="<?php echo e(__('Enter Address')); ?>"></textarea>
                                <p id="editErr_<?php echo e($language->code); ?>_email" class="mt-1 mb-0 text-danger em"></p>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label><?php echo e(__('About Us')); ?></label>
                                <textarea name="<?php echo e($language->code); ?>_details" class="form-control" rows="5"
                                  placeholder="<?php echo e(__('Enter Details')); ?>"></textarea>
                                <p id="editErr_<?php echo e($language->code); ?>_details" class="mt-1 mb-0 text-danger em"></p>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-lg-12">
                              <?php $currLang = $language; ?>

                              <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($language->id == $currLang->id) continue; ?>

                                <div class="form-check py-0">
                                  <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox"
                                      onchange="cloneInput('collapse<?php echo e($currLang->id); ?>', 'collapse<?php echo e($language->id); ?>', event)">
                                    <span class="form-check-sign"><?php echo e(__('Clone for')); ?> <strong
                                        class="text-capitalize text-secondary"><?php echo e($language->name); ?></strong>
                                      <?php echo e(__('language')); ?></span>
                                  </label>
                                </div>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <div class="row">
            <div class="col-12 text-center">
              <button type="submit" id="updateBtn" class="btn btn-success">
                <?php echo e(__('Update')); ?>

              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/backend/end-user/dealer/create.blade.php ENDPATH**/ ?>