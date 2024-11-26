<?php $__env->startSection('pageHeading'); ?>
  <?php if(!empty($pageHeading)): ?>
    <?php echo e($pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('Signup')); ?>

  <?php else: ?>
    <?php echo e(__('Signup')); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('metaKeywords'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_keywords_vendor_signup); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaDescription'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_description_vendor_signup); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php if ($__env->exists('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Signup'),
  ])) echo $__env->make('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Signup'),
  ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="user-dashboard pt-20 pb-60">
    <div class="container">
      
  
      
  <div class="row gx-xl-5">
  
       <?php if ($__env->exists('vendors.partials.side-custom')) echo $__env->make('vendors.partials.side-custom', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   

    
    <div class="col-md-9">
  

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-12">
              <div class="card-title"><?php echo e(__('Edit Profile')); ?></div>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12 mx-auto">
              <?php
                   $vendor_info = App\Models\VendorInfo::where('vendor_id', $vendor->id)->where('language_id', $language->id)->first();
              ?>
              
              <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              
              <form id="ajaxEditForm" action="<?php echo e(route('vendor.update_profile')); ?>" method="post">
                <?php echo csrf_field(); ?>
                
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label for=""><?php echo e(__('Photo')); ?></label>
                      <br>
                      <div class="thumb-preview" id="image-preview">
                        <?php if($vendor->photo != null): ?>
                          <img src="<?php echo e(asset('assets/admin/img/vendor-photo/' . $vendor->photo)); ?>" alt="..."  class="uploaded-img">
                            
                            <a href="javascript:void(0);" onclick="removeImage(this)" style="    color: red;
                            position: absolute;
                            background: white;
                            padding: 3px;
                            top: 40px;
                            left: 0px;
                            height: 30px;
                            width: 30px;
                            border-radius: 50%;
                            text-align: center;
                            border: 1px solid #ff0000;">
                            <i class="fa fa-times" aria-hidden="true"></i></a>
                            
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
                  <div class="col-lg-12">
                  <div class="form-group">
                      <h5>I'm a:</h5>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input traderradio" type="radio" name="traderstatus" value="1" id="flexRadioDefault1" <?php if($vendor->trader == 1): ?> checked <?php endif; ?>>
                        <label class="form-check-label" for="flexRadioDefault1">
                          Trader
                        </label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input traderradio" type="radio" name="traderstatus" value="0" id="flexRadioDefault2"
                        <?php if($vendor->trader == 0): ?> checked <?php endif; ?>>
                        <label class="form-check-label" for="flexRadioDefault2">
                          Private Seller
                        </label>
                      </div>
                  </div>
                </div>
                
                <div class="col-lg-4 chkbox" <?php if($vendor->trader == 0): ?> style="display: none;" <?php endif; ?>>
                    <div class="form-group">
                      <label><?php echo e(__('Business Name')); ?></label>
                      <input type="text" value="<?php echo e($vendor_info->business_name); ?>" class="form-control" name="business_name">
                      <p id="editErr_business_name" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-4 chkbox" <?php if($vendor->trader == 0): ?> style="display: none;" <?php endif; ?>>
                    <div class="form-group">
                      <label><?php echo e(__('VAT Number (if applicable)')); ?></label>
                      <input type="text" value="<?php echo e($vendor_info->vat_number); ?>" class="form-control" name="vat_number">
                      <p id="editErr_vat_number" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-4 chkbox" <?php if($vendor->trader == 0): ?> style="display: none;" <?php endif; ?>>
                    <div class="form-group">
                      <label><?php echo e(__('Business Address')); ?></label>
                      <input type="text" value="<?php echo e($vendor_info->business_address); ?>" class="form-control" name="business_address">
                      <p id="editErr_business_address" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label><?php echo e(__('Name*')); ?></label>
                      <input type="text" value="<?php echo e(!empty($vendor_info) ? $vendor_info->name : ''); ?>"
                        class="form-control" name="name" placeholder="Enter Name" disabled>
                      <p id="editErr_<?php echo e($language->code); ?>_name" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label><?php echo e(__('Email*')); ?></label>
                      <input type="text" value="<?php echo e($vendor->email); ?>" class="form-control" name="email" disabled>
                      <p id="editErr_email" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <label style="margin-left:8px; font-size:1.2rem;color:black;"><?php echo e(__('Phone')); ?> </label>
                    <div class="form-group input-group">
                     
                     <div class="d-flex">
                        <div class="custom-select">
                        <div class="select-selected">
                            
                            <?php
                                $ct = $country_codes->firstWhere('country', 'United Kingdom');
                                
                                $flagUrl = $ct->flag_url;
                                $flagcode = $ct->code;
                                $s_code = $ct->short_code;
                                
                                if(!empty($vendor->country_code))
                                {
                                    $ct = $country_codes->firstWhere('code', $vendor->country_code);
                                    
                                    $flagUrl = $ct->flag_url;
                                    $flagcode = $ct->code;
                                    $s_code = $ct->short_code;
                                
                                }
                                
                            ?>
                        <img src="<?php echo e($flagUrl); ?>" alt="UK Flag" class="flag">
                        <span class="short_code"> <?php echo e($s_code); ?> </span> (<?php echo e($flagcode); ?>)
                        </div>
                        <div class="select-items select-hide">
                        <div class="search-box">
                        <input type="text" id="country-search" placeholder="Search country...">
                        </div>
                        <?php $__currentLoopData = $country_codes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="country-option" data-value="<?php echo e($country->code); ?>" data-flag="<?php echo e($country->flag_url); ?>">
                        <img src="<?php echo e($country->flag_url); ?>" alt="<?php echo e($country->country); ?>" class="flag">
                        <span  class="short_code">  <?php echo e($country->short_code); ?> </span> <span style="display:none;"><?php echo e($country->country); ?></span> (<?php echo e($country->code); ?>)
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        </div>
                        
                        <input type="hidden" name="c_code" id="c_code" value="<?php echo e(!empty(Auth::guard('vendor')->user()->country_code) ? Auth::guard('vendor')->user()->country_code : '+44'); ?>"/>
        
                        <input  type="number" value="<?php echo e($vendor->phone); ?>" style="height: 40px;margin-top: 10px;    margin-right: 5px;" class="form-control" name="phone" required> 
                      
                      
                       <?php if($vendor->phone_verified == 1): ?>
                        <button disabled   class="btn  btn-success2"  style="    height: 40px;
                        margin-top: 10px;
                        font-size: 25px;
                        padding-top: 5px;
                        width: 50px;
                        padding-left: 12px;
                        background: transparent;
                        color: #1b87f4;" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
                         <?php else: ?>
                        <button  id="verifyPhone" class="btn btn-outline-secondary"  style="height: 40px;
                        margin-top: 10px;
                        font-size: 25px;
                        padding-top: 5px;
                        width: 50px;
                        padding-left: 12px;
                        background: transparent;
                        color: #1b87f4;" type="button" title="verify"><i class='fas fa-fingerprint'></i></button>
                        <?php endif; ?>
                        
                        </div>
                     <small>Verify your phone number and help reduce fraud and scams on Listit</small>
                      <p id="editErr_phone" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  
                  <div class="col-lg-6">
                      <div class="form-group">
                        <label>Use Whatsapp Function?</label>
                        
                      <div class="d-flex">
                            <div style="display:flex;    margin-right: 70px;">
                            <span style="font-weight: bold;margin-right: 10px;">Yes </span> <input type="radio" name="also_whatsapp" <?= ($vendor->also_whatsapp == 1) ? 'checked' : '' ?>  />
                        </div>
                      
                      
                        <div style="display:flex;">
                            <span style="font-weight: bold;margin-right: 10px;">No </span> <input type="radio" name="also_whatsapp"  <?= ($vendor->also_whatsapp == 0) ? 'checked' : '' ?> />
                        </div>
                      </div>
                      
                      
                      </div>
                    </div>
                    
                    
                    
                  <div class="col-lg-6">
                      <div class="form-group">
                        <label><?php echo e(__('Country')); ?></label>
                        <input type="text"
                          value="Isle of Man"
                          class="form-control" name="<?php echo e($language->code); ?>_country"
                          placeholder="Enter Country" disabled >
                      
                        <p id="editErr_<?php echo e($language->code); ?>_country" class="mt-1 mb-0 text-danger em"></p>
                      </div>
                    </div>
                    
                    
                    <div class="col-lg-6">
                    <div class="form-group">
                    <label><?php echo e(__('City/Area')); ?></label>
                    <select name="<?php echo e($language->code); ?>_city" id="" class="form-control">
                    <option value="">Please select...</option>
                         <?php $__currentLoopData = $countryArea; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($area->slug); ?>" <?php echo e($area->slug == $vendor_info->city ? 'selected' : ''); ?>><?php echo e($area->name); ?></option>
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                       <!--  <input type="text" value="<?php echo e(!empty($vendor_info) ? $vendor_info->city : ''); ?>"
                          class="form-control" name="<?php echo e($language->code); ?>_city" placeholder="Enter City" required> -->
                        <p id="editErr_<?php echo e($language->code); ?>_city" class="mt-1 mb-0 text-danger em"></p>
                      </div>
                    </div>
                    
                    
                  
                    
                        
                  <div class="col-lg-12">
                    <div id="accordion" class="">
                      
                        <div class="version" style="border: 0px !important;">
                         
                          <div id="collapse<?php echo e($language->id); ?>"
                            class="collapse <?php echo e($language->is_default == 1 ? 'show' : ''); ?>"
                            aria-labelledby="heading<?php echo e($language->id); ?>" data-parent="#accordion">
                            <div class="version-body" >
                              <div class="row">
                                
                                
                               
                              </div>
                            </div>
                          </div>
                        </div>
                      
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" <?php echo e($vendor->show_email_addresss == 1 ? 'checked' : ''); ?>

                              name="show_email_addresss" class="custom-control-input" id="show_email_addresss">
                            <label class="custom-control-label"
                              for="show_email_addresss"><?php echo e(__('Show Email Address in Profile Page')); ?></label>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" <?php echo e($vendor->show_phone_number == 1 ? 'checked' : ''); ?>

                              name="show_phone_number" class="custom-control-input" id="show_phone_number">
                            <label class="custom-control-label"
                              for="show_phone_number"><?php echo e(__('Show Phone Number in Profile Page')); ?></label>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" <?php echo e($vendor->show_contact_form == 1 ? 'checked' : ''); ?>

                              name="show_contact_form" class="custom-control-input" id="show_contact_form">
                            <label class="custom-control-label"
                              for="show_contact_form"><?php echo e(__('Show  Contact Form')); ?></label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                
        <div class="row justify-content-center">
    <div class="col-12 col-lg-12 col-xl-12 mx-auto">
       
        <div class="my-4">
           
           
            
            
        <h4 class="mb-4 mt-5 ms-3">Notification Preferences</h4>
            
            <div class="list-group mb-5 ">
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col">
                            <strong class="mb-0">Listit News & Offers</strong>
                            <p class="text-muted mb-0">We'll send you members-only updates, news and offers.</p>
                        </div>
                        <div class="col-auto p-3">
                          <div class="custom-control  form-switch">
                            <input class="form-check-input" name="notification_news_offer" type="checkbox" role="switch" <?php echo e($vendor->notification_news_offer == 1 ? 'checked' : ''); ?>>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col">
                            <strong class="mb-0">Saved Searches</strong>
                            <p class="text-muted mb-0">We'll let you know when new ads are added to your saved searches. You can turn on/off alerts below or manage individual alerts here.</p>
                        </div>
                        <div class="col-auto p-3">
                          <div class="custom-control  form-switch">
                            <input name="notification_saved_search" class="form-check-input" type="checkbox" role="switch" <?php echo e($vendor->notification_saved_search == 1 ? 'checked' : ''); ?>>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col">
                            <strong class="mb-0">Selling Tips & Tools</strong>
                            <p class="text-muted mb-0">We'll send you stats on your ads performance, important reminders and selling tips..</p>
                        </div>
                        <div class="col-auto">
                          <div class="custom-control  form-switch">
                            <input name="notification_tips" class="form-check-input" type="checkbox" role="switch" <?php echo e($vendor->notification_tips == 1 ? 'checked' : ''); ?>>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col">
                            <strong class="mb-0">Recommendations</strong>
                            <p class="text-muted mb-0">We'll send you suggested ads you may like based on your searches</p>
                        </div>
                        <div class="col-auto">
                          <div class="custom-control  form-switch">
                            <input name="notification_recommendations" class="form-check-input" type="checkbox" role="switch" <?php echo e($vendor->notification_recommendations == 1 ? 'checked' : ''); ?>>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col">
                            <strong class="mb-0">Saved Ads</strong>
                            <p class="text-muted mb-0">We'll let you know when there are updates to your saved ads, like price changes.</p>
                        </div>
                        <div class="col-auto">
                          <div class="custom-control  form-switch">
                            <input name="notification_saved_ads" class="form-check-input" type="checkbox" role="switch" <?php echo e($vendor->notification_saved_ads == 1 ? 'checked' : ''); ?>>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

                </div>
              </form>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
  </div>
  
  </div>
</div>

  <?php $__env->stopSection(); ?>
  <?php
  $languages = App\Models\Language::get();
  $labels = '';
  $values = '';
  foreach ($languages as $language) {
      $label_name = $language->code . '_label[]';
      $value_name = $language->code . '_value[]';
      if ($language->direction == 1) {
          $direction = 'form-group rtl text-right';
      } else {
          $direction = 'form-group';
      }
  
      $labels .= "<div class='$direction'><input type='text' name='" . $label_name . "' class='form-control' placeholder='Label ($language->name)'></div>";
      $values .= "<div class='$direction'><input type='text' name='$value_name' class='form-control' placeholder='Value ($language->name)'></div>";
  }
?>

<?php $__env->startSection('script'); ?>

<link rel="stylesheet" href="<?php echo e(asset('assets/css/dropzone.min.css')); ?>">



<link rel="stylesheet" href="<?php echo e(asset('assets/css/select2.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/front/css/pages/inner-pages.css')); ?>">

<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin-main.css')); ?>">
<style type="">


        
        
  #carForm .form-control {
    display: block;
    width: 80%;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 14px !important;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out
}
 #carForm .btn-secondary{
  line-height: 13px !important;
 }
 .btn-success2 {
    background: #28a745 !important;
    border-color: #28a745 !important;
}
.list-group {
    display: flex;
    flex-direction: column;
    padding-left: 0;
    margin-bottom: 0;
    border-radius: 0.25rem;
}

.list-group-item-action {
    width: 100%;
    color: #4d5154;
    text-align: inherit;
}
.list-group-item-action:hover,
.list-group-item-action:focus {
    z-index: 1;
    color: #4d5154;
    text-decoration: none;
    background-color: #f4f6f9;
}
.list-group-item-action:active {
    color: #8e9194;
    background-color: #eef0f3;
}

.list-group-item {
    position: relative;
    display: block;
    padding: 0.75rem 1.25rem;
    background-color: #ffffff;
    border: 1px solid #eef0f3;
}
.list-group-item p{
  font-size:14px;
}
.form-check-input[type=checkbox]{
  zoom:1.6;
  background-color:#CCCCCC;
  border-color:#CCCCCC !important;
  --bs-form-switch-bg:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e") !important;

}.form-check-input:checked[type=checkbox]{
  zoom:1.6;
  background-color:#31CE36;
  border-color:#31CE36 !important;

}


.list-group-item:first-child {
    border-top-left-radius: inherit;
    border-top-right-radius: inherit;
}
.list-group-item:last-child {
    border-bottom-right-radius: inherit;
    border-bottom-left-radius: inherit;
}
.list-group-item.disabled,
.list-group-item:disabled {
    color: #6d7174;
    pointer-events: none;
    background-color: #ffffff;
}
.list-group-item.active {
    z-index: 2;
    color: #ffffff;
    background-color: #1b68ff;
    border-color: #1b68ff;
}
.list-group-item + .list-group-item {
    border-top-width: 0;
}
.list-group-item + .list-group-item.active {
    margin-top: -1px;
    border-top-width: 1px;
}

.list-group-horizontal {
    flex-direction: row;
}
.list-group-horizontal > .list-group-item:first-child {
    border-bottom-left-radius: 0.25rem;
    border-top-right-radius: 0;
}
.list-group-horizontal > .list-group-item:last-child {
    border-top-right-radius: 0.25rem;
    border-bottom-left-radius: 0;
}
.list-group-horizontal > .list-group-item.active {
    margin-top: 0;
}
.list-group-horizontal > .list-group-item + .list-group-item {
    border-top-width: 1px;
    border-left-width: 0;
}
.list-group-horizontal > .list-group-item + .list-group-item.active {
    margin-left: -1px;
    border-left-width: 1px;
}

@media (min-width: 576px) {
    .list-group-horizontal-sm {
        flex-direction: row;
    }
    .list-group-horizontal-sm > .list-group-item:first-child {
        border-bottom-left-radius: 0.25rem;
        border-top-right-radius: 0;
    }
    .list-group-horizontal-sm > .list-group-item:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-left-radius: 0;
    }
    .list-group-horizontal-sm > .list-group-item.active {
        margin-top: 0;
    }
    .list-group-horizontal-sm > .list-group-item + .list-group-item {
        border-top-width: 1px;
        border-left-width: 0;
    }
    .list-group-horizontal-sm > .list-group-item + .list-group-item.active {
        margin-left: -1px;
        border-left-width: 1px;
    }
}

@media (min-width: 768px) {
    .list-group-horizontal-md {
        flex-direction: row;
    }
    .list-group-horizontal-md > .list-group-item:first-child {
        border-bottom-left-radius: 0.25rem;
        border-top-right-radius: 0;
    }
    .list-group-horizontal-md > .list-group-item:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-left-radius: 0;
    }
    .list-group-horizontal-md > .list-group-item.active {
        margin-top: 0;
    }
    .list-group-horizontal-md > .list-group-item + .list-group-item {
        border-top-width: 1px;
        border-left-width: 0;
    }
    .list-group-horizontal-md > .list-group-item + .list-group-item.active {
        margin-left: -1px;
        border-left-width: 1px;
    }
}

@media (min-width: 992px) {
    .list-group-horizontal-lg {
        flex-direction: row;
    }
    .list-group-horizontal-lg > .list-group-item:first-child {
        border-bottom-left-radius: 0.25rem;
        border-top-right-radius: 0;
    }
    .list-group-horizontal-lg > .list-group-item:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-left-radius: 0;
    }
    .list-group-horizontal-lg > .list-group-item.active {
        margin-top: 0;
    }
    .list-group-horizontal-lg > .list-group-item + .list-group-item {
        border-top-width: 1px;
        border-left-width: 0;
    }
    .list-group-horizontal-lg > .list-group-item + .list-group-item.active {
        margin-left: -1px;
        border-left-width: 1px;
    }
}

@media (min-width: 1200px) {
    .list-group-horizontal-xl {
        flex-direction: row;
    }
    .list-group-horizontal-xl > .list-group-item:first-child {
        border-bottom-left-radius: 0.25rem;
        border-top-right-radius: 0;
    }
    .list-group-horizontal-xl > .list-group-item:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-left-radius: 0;
    }
    .list-group-horizontal-xl > .list-group-item.active {
        margin-top: 0;
    }
    .list-group-horizontal-xl > .list-group-item + .list-group-item {
        border-top-width: 1px;
        border-left-width: 0;
    }
    .list-group-horizontal-xl > .list-group-item + .list-group-item.active {
        margin-left: -1px;
        border-left-width: 1px;
    }
}

.list-group-flush {
    border-radius: 0;
}
.list-group-flush > .list-group-item {
    border-width: 0 0 1px;
}
.list-group-flush > .list-group-item:last-child {
    border-bottom-width: 0;
}

.list-group-item-primary {
    color: #0e3685;
    background-color: #bfd5ff;
}
.list-group-item-primary.list-group-item-action:hover,
.list-group-item-primary.list-group-item-action:focus {
    color: #0e3685;
    background-color: #a6c4ff;
}
.list-group-item-primary.list-group-item-action.active {
    color: #ffffff;
    background-color: #0e3685;
    border-color: #0e3685;
}

.list-group-item-secondary {
    color: #0a395d;
    background-color: #bdd6ea;
}
.list-group-item-secondary.list-group-item-action:hover,
.list-group-item-secondary.list-group-item-action:focus {
    color: #0a395d;
    background-color: #aacae4;
}
.list-group-item-secondary.list-group-item-action.active {
    color: #ffffff;
    background-color: #0a395d;
    border-color: #0a395d;
}

.list-group-item-success {
    color: #107259;
    background-color: #c0f5e8;
}
.list-group-item-success.list-group-item-action:hover,
.list-group-item-success.list-group-item-action:focus {
    color: #107259;
    background-color: #aaf2e0;
}
.list-group-item-success.list-group-item-action.active {
    color: #ffffff;
    background-color: #107259;
    border-color: #107259;
}

.list-group-item-info {
    color: #005d83;
    background-color: #b8eafe;
}
.list-group-item-info.list-group-item-action:hover,
.list-group-item-info.list-group-item-action:focus {
    color: #005d83;
    background-color: #9fe3fe;
}
.list-group-item-info.list-group-item-action.active {
    color: #ffffff;
    background-color: #005d83;
    border-color: #005d83;
}

.list-group-item-warning {
    color: #855701;
    background-color: #ffe7b8;
}
.list-group-item-warning.list-group-item-action:hover,
.list-group-item-warning.list-group-item-action:focus {
    color: #855701;
    background-color: #ffde9f;
}
.list-group-item-warning.list-group-item-action.active {
    color: #ffffff;
    background-color: #855701;
    border-color: #855701;
}

.list-group-item-danger {
    color: #721c24;
    background-color: #f5c6cb;
}
.list-group-item-danger.list-group-item-action:hover,
.list-group-item-danger.list-group-item-action:focus {
    color: #721c24;
    background-color: #f1b0b7;
}
.list-group-item-danger.list-group-item-action.active {
    color: #ffffff;
    background-color: #721c24;
    border-color: #721c24;
}

.list-group-item-light {
    color: #7f8081;
    background-color: #fcfcfd;
}
.list-group-item-light.list-group-item-action:hover,
.list-group-item-light.list-group-item-action:focus {
    color: #7f8081;
    background-color: #ededf3;
}
.list-group-item-light.list-group-item-action.active {
    color: #ffffff;
    background-color: #7f8081;
    border-color: #7f8081;
}

.list-group-item-dark {
    color: #17191c;
    background-color: #c4c5c6;
}
.list-group-item-dark.list-group-item-action:hover,
.list-group-item-dark.list-group-item-action:focus {
    color: #17191c;
    background-color: #b7b8b9;
}
.list-group-item-dark.list-group-item-action.active {
    color: #ffffff;
    background-color: #17191c;
    border-color: #17191c;
}
</style>
<script>
  'use strict';

  const baseUrl = "<?php echo e(url('/')); ?>";
</script>






<script type="text/javascript" src="<?php echo e(asset('assets/js/jquery-ui.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/js/jquery.ui.touch-punch.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/jquery.timepicker.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/jquery.scrollbar.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/bootstrap-notify.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/sweet-alert.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/bootstrap-tagsinput.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/bootstrap-datepicker.min.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('assets/js/jscolor.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/fontawesome-iconpicker.min.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('assets/js/tinymce/js/tinymce/tinymce.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/datatables-1.10.23.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/datatables.bootstrap4.min.js')); ?>"></script>



<script type="text/javascript" src="<?php echo e(asset('assets/js/dropzone.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/atlantis.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/webfont.min.js')); ?>"></script>
<!-- 
<?php if(session()->has('success')): ?>
  <script>
    'use strict';
    var content = {};

    content.message = '<?php echo e(session('success')); ?>';
    content.title = 'Success';
    content.icon = 'fa fa-bell';

    $.notify(content, {
      type: 'success',
      placement: {
        from: 'top',
        align: 'right'
      },
      showProgressbar: true,
      time: 1000,
      delay: 4000
    });
  </script>
<?php endif; ?>

<?php if(session()->has('warning')): ?>
  <script>
    'use strict';
    var content = {};

    content.message = '<?php echo e(session('warning')); ?>';
    content.title = 'Warning!';
    content.icon = 'fa fa-bell';

    $.notify(content, {
      type: 'warning',
      placement: {
        from: 'top',
        align: 'right'
      },
      showProgressbar: true,
      time: 1000,
      delay: 4000
    });
  </script>
<?php endif; ?>
 -->



<script type="text/javascript" src="<?php echo e(asset('assets/js/select2.min.js')); ?>"></script>


<script type="text/javascript" src="<?php echo e(asset('assets/js/admin-main.js')); ?>?v=0.5"></script>

  <script>
    'use strict';
    var storeUrl = "<?php echo e(route('car.imagesstore')); ?>";
    var removeUrl = "<?php echo e(route('user.car.imagermv')); ?>";
    var getBrandUrl = "<?php echo e(route('user.get-car.brand.model')); ?>";
    const account_status = "<?php echo e(Auth::guard('vendor')->user()->status); ?>";
    const secret_login = "<?php echo e(Session::get('secret_login')); ?>";
    
  </script>

  
  <script>
    var labels = "<?php echo $labels; ?>";
    var values = "<?php echo $values; ?>";
  </script>
  
  
<?php $__env->stopSection(); ?>

<?php echo $__env->make("frontend.layouts.layout-v$settings->theme_version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/vendors/auth/edit-profile.blade.php ENDPATH**/ ?>