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
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Ads Management'),
  ])) echo $__env->make('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Ads Management'),
  ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="user-dashboard pt-20 pb-60">
    <div class="container">
      
  
      
  <div class="row gx-xl-5">
  
    <?php if ($__env->exists('vendors.partials.side-custom')) echo $__env->make('vendors.partials.side-custom', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   
    <div class="col-md-9">
        
  <?php
    $current_package = App\Http\Helpers\VendorPermissionHelper::packagePermission(Auth::guard('vendor')->user()->id);
  ?>
  <?php if($current_package != '[]'): ?>
    <?php if(vendorTotalAddedCar() > $current_package->number_of_car_add): ?>
      <?php
        $car_add = 'over';
      ?>
      <div class="mt-2 mb-4">
        <div class="alert alert-danger text-dark">
          <ul>
            <li><?php echo e(__('You have added total ') . vendorTotalAddedCar()); ?> <?php echo e(__(' cars.')); ?></li>
            <li><?php echo e(__('Your current package supports') . ' ' . $current_package->number_of_car_add . ' cars.'); ?> </li>
            <li><?php echo e(__('You have to remove ')); ?>

              <?php echo e(vendorTotalAddedCar() - $current_package->number_of_car_add . __(' cars  to enable car editing.')); ?></li>
          </ul>
        </div>
      </div>
    <?php else: ?>
      <?php
        $car_add = '';
      ?>
    <?php endif; ?>
    <?php if(vendorTotalFeaturedCar() > $current_package->number_of_car_featured): ?>
      <?php
        $car_featured = 'over';
      ?>
      <div class="mt-2 mb-4">
        <div class="alert alert-danger text-dark">
          <ul>
            <li><?php echo e(__('You have total  ') . vendorTotalFeaturedCar() . ' featured cars.'); ?></li>
            <li>
              <?php echo e(__('With your current package you can feature ') . $current_package->number_of_car_featured . __(' cars.')); ?>

            </li>
            <li><?php echo e(__('Your cars has been removed from featured cars section of our website.')); ?>

            </li>
            <li><?php echo e(__('You have to unfeature ')); ?>

              <?php echo e(vendorTotalFeaturedCar() - $current_package->number_of_car_featured . __(' cars  to show your cars in featured cars section of our website.')); ?>

            </li>
          </ul>

        </div>
      </div>
    <?php else: ?>
      <?php
        $car_featured = '';
      ?>
    <?php endif; ?>
  <?php else: ?>
    <?php
      $can_car_add = 0;
      $car_add = '';
      $car_featured = 'over';
      
      $pendingMemb = \App\Models\Membership::query()
          ->where([['vendor_id', '=', Auth::id()], ['status', 0]])
          ->whereYear('start_date', '<>', '9999')
          ->orderBy('id', 'DESC')
          ->first();
      $pendingPackage = isset($pendingMemb) ? \App\Models\Package::query()->findOrFail($pendingMemb->package_id) : null;
    ?>
    <?php if($pendingPackage): ?>
      <div class="alert alert-warning text-dark">
        <?php echo e(__('You have requested a package which needs an action (Approval / Rejection) by Admin. You will be notified via mail once an action is taken.')); ?>

      </div>
      <div class="alert alert-warning text-dark">
        <strong><?php echo e(__('Pending Package') . ':'); ?> </strong> <?php echo e($pendingPackage->title); ?>

        <span class="badge badge-secondary"><?php echo e($pendingPackage->term); ?></span>
        <span class="badge badge-warning"><?php echo e(__('Decision Pending')); ?></span>
      </div>
    <?php else: ?>
      <!-- <div class="alert alert-warning text-dark">
        <?php echo e(__('Your membership is expired. Please purchase a new package / extend the current package.')); ?>

      </div> -->
    <?php endif; ?>
    <?php if ($__env->exists('vendors.verify')) echo $__env->make('vendors.verify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <?php endif; ?>

  <div class="row">
    <div class="col-md-12">
    <div class="m-4">
    <ul class="nav nav-tabs nav-fill" style="justify-content:left !important;">
        <li class="nav-item">
            <a data-id="all" href="#" class="nav-link active">All Ads (<?php echo e(count($cars)); ?>)</a>
        </li>
        <li class="nav-item">
            <a data-id="1" href="#" class="nav-link">Listed (<?php echo e(countSaveAds(Auth::id(),1)); ?>)</a>
        </li>
        <li class="nav-item">
            <a data-id="2" href="#" class="nav-link"> Sold (<?php echo e(count($cars) - countSaveAds(Auth::id(),1)); ?>)</a>
        </li>
    </ul>
    
    <div class="us_com_heading">
        
        <?php echo e(count($cars)); ?> vehicles saved
        
        <small style="display:block" class="us_com_subheading">
            Compare upto 5 cars now
        </small>
        
    </div>
    
    <div class="d-flex us_com_flex" style="    margin-top: 1rem;">
        
        <select class="form-control" name="categories" id="categorires" style="height: 45px;margin-top: 5px;" onchange="applyfilter(this , 'categories')">
            <option value="">All Vehicles</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($category->id); ?>" <?= (request()->category_id == $category->id  )  ? 'selected' : '' ?> ><?php echo e($category->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        
         <select class="form-control" name="filter_type" id="filter_type" style="height: 45px;margin-left: 1rem;margin-top: 5px;" onchange="applyfilter(this , 'filter_type')" >
                <option value="recent" <?= (request()->filter_type == 'recent' )  ? 'selected' : '' ?> >Most Recent</option>
                <option value="lowest_price" <?= (request()->filter_type == 'lowest_price' )  ? 'selected' : '' ?>>Price (Lowest)</option>
                <option value="highest_price" <?= (request()->filter_type == 'highest_price' )  ? 'selected' : '' ?>>Price (Highest)</option>
        </select>
        
        <button type="button" class="btn btn-info btn-sm us_com_btun" id="comparebtn" onclick="getComparison('compareall')" style="min-width:150px;margin-left: 1rem;float: right;margin-top: 5px;display:none;">
            Compare 
                <span id="com_cal">
                    2
                </span> 
            ads now
        </button>
        
        <button type="button" class="btn btn-danger btn-outline btn-sm " id="removeBTN" onclick="getComparison('removeall')" style="background: transparent !important;
        margin-left: 1rem;
        float: right;
        margin-top: 5px;
        width: 315px;
        color: red;display:none;">
        <i class="fa fa-trash" aria-hidden="true" style="font-size: 13px;margin-right: 5px;"></i>   Delete all 
        </button>
    </div>
    </div>
  </div>
  </div>
  
  
<form method="get" action="<?php echo e(route('get_compare_car_data')); ?>" id="comparsim_form">
  <div class="row">
   <input type="hidden" name="request_type" id="request_type" value="compare" />
    <div class="col-md-12">
    
    <div class="container mt-2" id="fillwithAjax">
    <?php $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
   
      $car_content = $car->car_content;
      
      if (is_null($car_content)) 
      {
          $car_content = $car->car_content()->first();
      }
      
    ?>
      <?php if($car_content): ?>  
      
  <div class="card ">
      <div class="card-header">
      <div class="d-flex justify-content-between">
          
          
        <div class=" d-inline-block text-left">
            <?php
                $forExpired ="";
                $forExpired = noDaysLeftByAd($car->package_id,$car->created_at);
            ?>
            
            <?php if($car->is_sold == 1 || $car->status == 2 ): ?>
                <span class="text-warning">
                    <?php echo e('Sold'); ?>

                </span>
            <?php else: ?>
            
                <?php if($car->status==2): ?>
                    <?php echo e('Withdrawn'); ?> 
                <?php endif; ?>
                
                <?php if($car->status==0): ?>
                    Needs Payment (Not Listed)
                <?php elseif($car->status==1 || $car->status==4 ): ?>
                    <?php echo e(noDaysLeftByAd($car->package_id,$car->created_at)); ?>

                <?php endif; ?>
            
            <?php endif; ?>
        </div>
    
        <h5 class="text-right">
            <a style="color:#1572E8; font-weight:100; font-size:15px;position: relative;z-index: 10;" href = "<?php echo e(route('remove.wishlist', $car->wishlist_id)); ?>">
                Remove
            </a>
        </h5>
    
      </div>
      </div>
      
      
      <div class="card-body" style="padding:0px;">  
      
      <?php if($car->is_sold == 1): ?>
       <div class="overlay"></div>
      <?php endif; ?>
      
    <div class="row no-gutters">
      <div class="col-md-4 col-sm-*"> 
     <div class="image-container">
      <img class="  us_design"  src="<?php echo e($car->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$car->feature_image) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $car->feature_image); ?>" alt="Ad Image">
      </div>
       </div>
        <div class="col-md-8 col-sm-*">
        
        <label class="card-title us_mrg ">
        
        <a href="<?php echo e(route('frontend.car.details', [catslug($car_content->category_id), 'slug' => $car_content->slug, 'id' => $car->id])); ?>"
          target="_blank">
          <?php echo e(strlen(@$car_content->title) > 50 ? mb_substr(@$car_content->title, 0, 50, 'utf-8') . '...' : @$car_content->title); ?>

        </a></label>
        
        <div style="" class="us_absolut_position us_pro_mrg"> 
            <strong  class="us_mrg" style="color: black;font-size: 20px;">
                <?php if($car->previous_price && $car->previous_price < $car->price ): ?>
                    <strike style="font-weight: 300;color: gray;font-size: 14px;"><?php echo e(symbolPrice($car->price)); ?></strike> . <?php echo e(symbolPrice($car->previous_price)); ?>

                <?php else: ?>
                    <?php echo e(symbolPrice($car->price)); ?>

                <?php endif; ?>
            </strong>
        </div>
        
        <div style="right: 0%;" class="us_absolut_position us_footer_div">
             <span style="float:right;margin-right: 15px;font-size: 16px;color: #a7a7a7;" data-tooltip="tooltip" data-bs-placement="top" title="Compare Ad" >
                <i class="fa fa-compress" aria-hidden="true" style="font-size: 20px;"></i>  
                <input type="checkbox" style="zoom: 1.4;position: relative;top: 1.7px;margin-left: 1px;" class="compare_checkbox" onclick="compareCheckbox(this)" name="comparison[]" value="<?php echo e($car->id); ?>" /> 
            </span>
            
            <span style="float:right;    margin-right: 15px;font-size: 16px;color: #a7a7a7;" data-tooltip="tooltip" data-bs-placement="top" title="How many times Ad saved" >
                <i class="fa fa-heart" aria-hidden="true" style="font-size: 20px;"></i>  <?php echo e(($car->wishlists()->get()->count() > 0 ) ? $car->wishlists()->get()->count() : 'No'); ?> saves
            </span>
            
            <span style="float:right;    margin-right: 15px;font-size: 16px;color: #a7a7a7;" data-tooltip="tooltip" data-bs-placement="top" title="Total Views"  >
                <i class="fa fa-eye" aria-hidden="true" style="font-size: 20px;"></i>  <?php echo e(($car->visitors()->get()->count() > 0 ) ? $car->visitors()->get()->count() : 'No'); ?> views
            </span>
        </div>
                
        
        </div>
      </div>
    </div>
    
  
  </div>
  <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
  

      </div>
    </div>
</form>
    
  </div>
</div>
</div></div>
</div>




<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin-main.css')); ?>">
<script>

  $(".nav-link").click(function(){
      
      var category_id = "<?= request()->category_id ?>";
      var filter_type = "<?= request()->filter_type ?>";
      
    // Remove active class from all items
    $(".nav-link").removeClass("active");
    // Add active class to the clicked item
    $(this).addClass("active");
    var url = '/customer/ad-management/ajaxsaveads?status='+$(this).data("id");
    $.ajax({
      type: 'GET',
      url: url,
      data:{category_id:  category_id , filter_type:filter_type},
      success: function (response) {
       
       
          $('#fillwithAjax').html(response.data);
         
       
      }
    });
  });
  </script>
  <?php $__env->stopSection(); ?>

<?php echo $__env->make("frontend.layouts.layout-v$settings->theme_version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/vendors/wishlist.blade.php ENDPATH**/ ?>