<?php $__env->startSection('content'); ?>
  <div class="page-header">
    <h4 class="page-title"><?php echo e(__('Edit Dealer')); ?></h4>
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
        <a href="<?php echo e(route('admin.vendor_management.registered_vendor')); ?>"><?php echo e(__('Registered Dealer')); ?></a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#"><?php echo e(__('Edit Dealer')); ?></a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-12">
              <div class="card-title"><?php echo e(__('Edit Dealer')); ?></div>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-10 mx-auto">
              <form id="ajaxEditForm"
                action="<?php echo e(route('admin.vendor_management.vendor.update_vendor', ['id' => $vendor->id])); ?>"
                method="post">
                <?php echo csrf_field(); ?>
                <h2>Details</h2>
                <hr>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label for=""><?php echo e(__('Photo')); ?></label>
                      <br>
                       <div class="thumb-preview">
                        <?php if($vendor->photo != null): ?>
                        
                        <?php
                            // Set the default photo URL as the subdomain URL
                            $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $vendor->photo;
                            
                            // Check if the file exists in the local server storage
                            if (file_exists(public_path('assets/admin/img/vendor-photo/' . $vendor->photo))) {
                            // If the file exists locally, use the local asset path
                            $photoUrl = asset('assets/admin/img/vendor-photo/' . $vendor->photo);
                            }
                        ?>
                        
                        <img src="<?php echo e($photoUrl); ?>" alt="..." class="uploaded-img">
                        <?php else: ?>
                          <img src="<?php echo e(asset('assets/img/noimage.jpg')); ?>" alt="..." class="uploaded-img">
                        <?php endif; ?>

                      </div>

                      <div class="mt-3">
                        <div role="button" class="btn btn-primary btn-sm upload-btn">
                          <?php echo e(__('Choose Photo')); ?>

                          <input type="file" class="img-input" name="photo">
                        </div>
                        <p id="editErr_photo" class="mt-1 mb-0 text-danger em"></p>
                        <p class="mt-2 mb-0 text-warning"><?php echo e(__('Image Size 80x80')); ?></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label><?php echo e(__('Username*')); ?></label>
                      <input type="text" value="<?php echo e($vendor->username); ?>" class="form-control" name="username">
                      <p id="editErr_username" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label><?php echo e(__('Email*')); ?></label>
                      <input type="text" value="<?php echo e($vendor->email); ?>" class="form-control" name="email">
                      <p id="editErr_email" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label><?php echo e(__('Phone')); ?></label>
                      <input type="tel" value="<?php echo e($vendor->phone); ?>" class="form-control" name="phone">
                      <p id="editErr_phone" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>

                  <div class="col-lg-12">
                    <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" <?php echo e($vendor->show_email_addresss == 1 ? 'checked' : ''); ?>

                              name="show_email_addresss" class="custom-control-input" id="show_email_addresss">
                            <label class="custom-control-label"
                              for="show_email_addresss"><?php echo e(__('Show Email Address in Profile Page')); ?></label>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" <?php echo e($vendor->show_phone_number == 1 ? 'checked' : ''); ?>

                              name="show_phone_number" class="custom-control-input" id="show_phone_number">
                            <label class="custom-control-label"
                              for="show_phone_number"><?php echo e(__('Show Phone Number in Profile Page')); ?></label>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" <?php echo e($vendor->show_contact_form == 1 ? 'checked' : ''); ?>

                              name="show_contact_form" class="custom-control-input" id="show_contact_form">
                            <label class="custom-control-label"
                              for="show_contact_form"><?php echo e(__('Show Contact Form')); ?></label>
                          </div>
                        </div>
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
                                        <input type="time" name="opening_hours[<?php echo e(strtolower($day)); ?>][open_time]" value="<?php echo e(!empty($openingHour[$day]) ? $openingHour[$day]->open_time : ''); ?>" style="margin-top: 1rem;" class="form-control" required>
                                        </td>
                                        <td>
                                        <input type="time" name="opening_hours[<?php echo e(strtolower($day)); ?>][close_time]" value="<?php echo e(!empty($openingHour[$day]) ? $openingHour[$day]->close_time : ''); ?>" style="margin-top: 1rem;    margin-left: 1rem;"  class="form-control" required>
                                        </td>
                                        <td>
                                        <input type="checkbox" name="opening_hours[<?php echo e(strtolower($day)); ?>][holiday]"  <?php echo e(!empty($openingHour[$day]) && $openingHour[$day]->holiday ? 'checked' : ''); ?>  style="margin-top: 10px;margin-left: 1rem;zoom: 2;"  value="1">
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </table>
                        
                        
                        </div>
                    </div>
                    

                  <div class="col-lg-12">
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
                                <?php echo e($language->name . __(' Language')); ?>

                                <?php echo e($language->is_default == 1 ? '(Default)' : ''); ?>

                              </button>
                            </h5>
                          </div>

                          <?php
                            $vendor_info = App\Models\VendorInfo::where('vendor_id', $vendor->id)
                                ->where('language_id', $language->id)
                                ->first();
                          ?>

                          <div id="collapse<?php echo e($language->id); ?>"
                            class="collapse <?php echo e($language->is_default == 1 ? 'show' : ''); ?>"
                            aria-labelledby="heading<?php echo e($language->id); ?>" data-parent="#accordion">
                            <div class="version-body">
                              <div class="row">
                                <div class="col-lg-4">
                                  <div class="form-group">
                                    <label><?php echo e(__('Name*')); ?></label>
                                    <input type="text" value="<?php echo e(!empty($vendor_info) ? $vendor_info->name : ''); ?>"
                                      class="form-control" name="<?php echo e($language->code); ?>_name"
                                      placeholder="<?php echo e(__('Enter Name')); ?>">
                                    <p id="editErr_<?php echo e($language->code); ?>_name" class="mt-1 mb-0 text-danger em"></p>
                                  </div>
                                </div>
                                <div class="col-lg-4">
                                  <div class="form-group">
                                    <label><?php echo e(__('Country')); ?></label>
                                    <input type="text"
                                      value="Isle of Man"
                                      class="form-control" readonly name="<?php echo e($language->code); ?>_country"
                                      placeholder="<?php echo e(__('Enter Country')); ?>">
                                    <p id="editErr_<?php echo e($language->code); ?>_country" class="mt-1 mb-0 text-danger em"></p>
                                  </div>
                                </div>
                                <div class="col-lg-4">
                                  <div class="form-group">
                                    <label><?php echo e(__('Area')); ?></label>
                                  
                                      
                                       <select name="<?php echo e($language->code); ?>_city" id="" class="form-control">
                                        <option value="">Please select...</option>
                                        <?php $__currentLoopData = $countryArea; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($area->slug); ?>" <?php echo e($area->slug == $vendor_info->city ? 'selected' : ''); ?>><?php echo e($area->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    
                                    
                                    <p id="editErr_<?php echo e($language->code); ?>_city" class="mt-1 mb-0 text-danger em"></p>
                                  </div>
                                </div>
                                <div class="col-lg-4">
                                  <div class="form-group">
                                    <label>Established Year</label>
                                    <input type="hidden" value="<?php echo e(!empty($vendor) ? $vendor->est_year : ''); ?>" id="selected_value">
                                      
                                      <select name="est_year" class="form-control" id="yearpicker" ></select>
                                      
                                    <p id="est_year" class="mt-1 mb-0 text-danger em"></p>
                                  </div>
                                </div>
                                <div class="col-lg-4">
                              <div class="form-group">
                                <label>Website Url</label>
                                <input type="text" value="<?php echo e(!empty($vendor) ? $vendor->website_link : ''); ?>" class="form-control"
                                  name="website_link" placeholder="<?php echo e(__('Enter Website Url')); ?>">
                                <p id="website_link" class="mt-1 mb-0 text-danger em"></p>
                              </div>
                            </div>
                                
                                <div class="col-lg-4">
                                  <div class="form-group">
                                    <label>Customer ID For Google Review</label>
                                    <input type="text"
                                      value="<?php echo e($vendor->google_review_id); ?>"
                                      class="form-control" name="google_review_id"
                                      placeholder="<?php echo e(__('Enter Customer ID For Google Review')); ?>">
                                    </p>
                                  </div>
                                </div>
                                
                                
                                <div class="col-lg-12">
                                  <div class="form-group">
                                    <label><?php echo e(__('Address')); ?></label>
                                    <textarea name="<?php echo e($language->code); ?>_address" class="form-control" placeholder="<?php echo e(__('Enter Address')); ?>"><?php echo e(!empty($vendor_info) ? $vendor_info->address : ''); ?></textarea>
                                    <p id="editErr_<?php echo e($language->code); ?>_email" class="mt-1 mb-0 text-danger em"></p>
                                  </div>
                                </div>
                                <div class="col-lg-12">
                                  <div class="form-group">
                                    <label><?php echo e(__('About Us')); ?></label>
                                    <textarea name="<?php echo e($language->code); ?>_details" class="form-control" rows="5"
                                      placeholder="<?php echo e(__('Enter Details')); ?>"><?php echo e(!empty($vendor_info) ? $vendor_info->details : ''); ?></textarea>
                                    <p id="editErr_<?php echo e($language->code); ?>_details" class="mt-1 mb-0 text-danger em"></p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                  </div>

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
  <?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/backend/end-user/dealer/edit.blade.php ENDPATH**/ ?>