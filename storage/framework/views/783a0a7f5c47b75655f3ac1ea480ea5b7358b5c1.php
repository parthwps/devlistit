<?php
  $version = $basicInfo->theme_version;
?>


<?php $__env->startSection('pageHeading'); ?>
  Find A Dealer
<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaKeywords'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_keywords_vendor_page); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaDescription'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_description_vendor_page); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php if ($__env->exists('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => 'Find A Dealer',
  ])) echo $__env->make('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => 'Find A Dealer',
  ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 <style>
        .author::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-size: cover;
            background-position: center center;
            filter: brightness(50%); /* Lower the brightness */
            border-top-right-radius: 10px;
            border-top-left-radius: 10px;
            z-index: 1;
        }

        .author a {
            position: relative;
            z-index: 2; /* Place text above the background */
            color: white;
        }

        .author strong, .author div {
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7); /* Add shadow to improve text readability */
        }
    </style>
  <!-- Vendor-area start -->
  <div class="vendor-area pt-20 pb-15" style="background: #eaeaea;">
    <div class="container">
      <div class="product-sort-area pb-20" data-aos="fade-up">
        <div class="row align-items-center" style="background: white;border-radius: 10px;box-shadow: 0px 0px 10px gray;">
          <div class="col-lg-4" style="margin-top: 0.5rem;padding-left: 2rem;">
            <h4 class=""><?php echo e(count($vendors)); ?>

               Dealers <?php echo e(__('Found')); ?></h4>
          </div>
          <div class="col-lg-8" style="margin-top: 1rem;">
            <form action="<?php echo e(route('frontend.vendors')); ?>" method="GET">
              <div class="row">
                <div class="col-lg-3 col-12">
                  <div class="form-group icon-start ">
                   
                    <input type="text" name="name" style="height: 40px;" value="<?php echo e(request()->input('name')); ?>"
                      class="form-control" placeholder="Search Dealer">
                  </div>
                </div>
                
                <div class="col-lg-4 col-12">
                  <div class="form-group icon-start ">
                    <select class="form-control" name="dealer_type" style="    height: 40px;">
                        <option value="">All dealers</option>
                        <option value="1" <?= (request()->input('dealer_type') == 1) ? 'selected' : '' ?> >Franchise dealers</option>
                        <option value="2" <?= (request()->input('dealer_type') ==2) ? 'selected' : '' ?> >Independent dealers</option>
                    </select>
                  </div>
                </div>
                
                <div class="col-lg-3 col-12">
                  <div class="form-group icon-start ">
                   
                    <input type="text" style="height: 40px;" name="location" class="form-control"
                      value="<?php echo e(request()->input('location')); ?>" placeholder="Search by location">
                  </div>
                </div>
                
                <div class="col-md-2 col-12">
                  <div class="form-group icon-start">
                    <button type="submit" style="height: 40px;" class="btn btn-icon bg-primary color-white btn-sm w-100">
                      <i class="fal fa-search"></i>
                      <span class="d-inline-block d-md-none">&nbsp;<?php echo e(__('Search')); ?></span>
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Products -->
      <div class="row" >
    <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    
    <?php
        $url = asset('assets/img/' . $bgImg->breadcrumb);
    ?>
    
    <?php if(!empty($vendor->banner_image)): ?> 
        <?php
            $url = env('SUBDOMAIN_APP_URL').'public/uploads/'.$vendor->banner_image;
        ?>
    <?php endif; ?>
  
    <div class="col-md-4 col-12" style="margin: 0.5rem 0rem;">
    <div class="card" style="background: #07072e; border-radius: 10px; display: flex; flex-direction: column; justify-content: space-between;">
    <div class="author us_parent_cls" style="padding: 1rem; border-top-right-radius: 10px; border-top-left-radius: 10px; position: relative; overflow: hidden;">
    
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url(<?php echo e($url); ?>); background-size: cover; background-position: center center; filter: brightness(65%); border-top-right-radius: 10px; border-top-left-radius: 10px;"></div>
    
    <a style="display: flex; position: relative; z-index: 1; color: white;" href="<?php echo e(route('frontend.vendor.details', ['id' => $vendor->id, 'username' => $vendor->username])); ?>" target="_self" title="<?php echo e($vendor->username); ?>">
        
        <?php if($vendor->photo): ?>
            <?php
                $maxWidth = '60px';
                $photoUrl = env('SUBDOMAIN_APP_URL') . 'assets/admin/img/vendor-photo/' . $vendor->photo;
                
                if (file_exists(public_path('assets/admin/img/vendor-photo/' . $vendor->photo))) {
                    $photoUrl = asset('assets/admin/img/vendor-photo/' . $vendor->photo);
                }
                
                list($width, $height) = getimagesize($photoUrl);
                $maxWidth = $height < 85 ? '80px' : '60px';
            ?>
            
            <img 
                style="border-radius: 10%; max-width: <?php echo e($maxWidth); ?>;"
                class="lazyload blur-up"
                src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>"
                data-src="<?php echo e($photoUrl); ?>"  
                alt="Vendor" 
                onerror="this.onerror=null; this.src='<?php echo e(asset('assets/img/blank-user.jpg')); ?>';">
        <?php else: ?>
            <img 
                style="border-radius: 10%; max-width: 60px;" 
                class="lazyload blur-up" 
                data-src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>" 
                alt="Image">
        <?php endif; ?>
        
        <span style="margin-left: 1rem;">
            <strong class="us_font_15" style="color: white; font-size: 20px;">
                <span> <?php echo e(!empty($vendor->vendor_info) ? \Str::limit($vendor->vendor_info->name, 20, '...') : 'deleted'); ?> </span>
                
                <?php if(!empty($vendor->est_year)): ?> 
                    <b>.</b> 
                    <span style="font-size: 15px; font-weight: bold; color: #ffffff;">Est <?php echo e($vendor->est_year); ?></span> 
                <?php endif; ?>
            </strong>
            
            <?php if(!empty($vendor->is_franchise_dealer) && $vendor->is_franchise_dealer == 1): ?>
                <div style="display: flex; color: white;">
                    Franchise Dealer
                </div>
            <?php else: ?>
                <div style="color: white;">Independent Dealer</div>
            <?php endif; ?>
        </span>
    </a>
</div>

        
       <div class="container" style="border: 1px solid #bcbcbc; border-radius: 10px; box-shadow: 0px 0px 10px gray; background: white; border-top-left-radius: 0px; border-top-right-radius: 0px; height: 200px; overflow-y: auto;">
    <div class="row" style="padding: 10px 3px 0px;">
        <div class="col-md-12">
            <div class="flex" style="margin-bottom: 0.5rem;">
                <label style="font-weight: 800; font-size: 19px; color: #8a8a8a;">Location</label>
                <div><?php echo e(!empty($vendor->vendor_info) ? $vendor->vendor_info->address : ''); ?></div>
            </div>
            <div class="flex" style="display: flex;">
                <label style="font-weight: 800; font-size: 19px; color: #8a8a8a;">Stock</label>
                <div style="margin-left: 1rem;font-size: 19px;"><a style="color: black;" href=""><?php echo e(!empty($vendor->cars()) ? $vendor->cars()->count() : 0); ?></a></div>
            </div>
        </div>
        <div class="col-md-12" style="display: flex; position:absolute; bottom:0px;">
            <button id="userphonebutton" type="button" onclick="savePhoneView(this)" style="margin-right: 5px" data-phone-number="<?php echo e($vendor->country_code.$vendor->phone); ?>" class="btn btn-md btn-outline w-100 mb-3"><?php echo e(__('Show Phone ')); ?></button>
            <a class="btn btn-md btn-outline w-100 showLoader mb-3" style="margin-left: 5px" href="<?php echo e(route('frontend.vendor.details', [ $vendor->id , $vendor->username])); ?>">Visit Showroom</a>
        </div>
    </div>
</div>

        
        
        </div>
        </div>


        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <div class="pagination mt-20 mb-25 justify-content-center" data-aos="fade-up">
        <?php echo e($vendors->links()); ?>

      </div>

      <?php if(!empty(showAd(3))): ?>
        <div class="text-center mt-4">
          <?php echo showAd(3); ?>

        </div>
      <?php endif; ?>
    </div>
  </div>
  <!-- Vendor-area end -->
<?php $__env->stopSection(); ?>


<script>
    function savePhoneView(self)
    {
        
        var phoneNumber = document.getElementById('userphonebutton').getAttribute('data-phone-number');
        $(self).html(phoneNumber)
        return false;
    }
</script>
<?php echo $__env->make("frontend.layouts.layout-v$version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/vendor/index.blade.php ENDPATH**/ ?>