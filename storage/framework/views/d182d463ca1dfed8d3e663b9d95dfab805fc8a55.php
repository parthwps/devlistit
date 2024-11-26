<?php
  $version = $basicInfo->theme_version;
?>


<?php $__env->startSection('pageHeading'); ?>
  <?php echo e($vendor->username); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('metaKeywords'); ?>
  <?php echo e($vendor->username); ?>, <?php echo e(!request()->filled('admin') ? @$vendorInfo->name : ''); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaDescription'); ?>
  <?php echo e(!request()->filled('admin') ? @$vendorInfo->details : ''); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<?php

$review_data = null;

?>

<?php if($vendor->google_review_id > 0 ): ?>
    <?php
        $review_data = get_vendor_review_from_google($vendor->google_review_id , true);
    ?>
<?php endif; ?>
                                
<style>

@media screen and (min-width: 580px) 
{
   .us_parent_cls
    {
        display:flex;
    }
}

@media screen and (max-width: 580px) 
{
.us_trusted
    {
        float:right;
        margin-top:1rem;
        margin-bottom:1rem;
    } 
    
    .us_font_15
    {
        font-size:15px !important;
    }
}

   
</style>   
     <?php
        $url = asset('assets/img/' . $bgImg->breadcrumb);
      ?>
      
   <?php if( !empty($vendor->banner_image)): ?> 
      <?php
        $url = env('SUBDOMAIN_APP_URL').'public/uploads/'.$vendor->banner_image;
      ?>
  <?php endif; ?>
  


  <div
    class="page-title-area ptb-100 bg-img <?php echo e($basicInfo->theme_version == 2 || $basicInfo->theme_version == 3 ? 'has_header_2' : ''); ?>"
    <?php if(!empty($bgImg)): ?> data-bg-image="<?php echo e($url); ?>" <?php endif; ?>
    src="<?php echo e(asset('assets/front/images/placeholder.png')); ?>" style="height:450px;    filter: brightness(85%);">
      
    <div class="container">
      <div class="content" style="margin-top: 85px;">
          
        <ul class="list-unstyled">
          <li class="d-inline"><a href="<?php echo e(route('index')); ?>" style="color:white;"><?php echo e(__('Home')); ?></a></li>
          <li class="d-inline" style="color:white;">/</li>
          <li class="d-inline "><a href="<?php echo e(route('frontend.vendors')); ?>" style="color:white;">All Dealers</a></li>
          <li class="d-inline" style="color:white;">/</li>
          <li class="d-inline active opacity-75"><a href="<?php echo e(route('frontend.vendor.details' , ['id' => $vendor->id , 'username' => $vendor->username])); ?>" style="color:white;"><?php echo e($vendor->vendor_info->name); ?></a></li>
        </ul>
        
        
        <div class="vendor " style="margin-top:2%;margin-bottom:-30px;">
            
          <figure class="vendor-img">
            <a href="javaScript:void(0)" class="lazy-container ratio ratio-1-1" style="border-radius: 10px;">
              <?php if($vendor->photo != null): ?>
              
                <?php
                $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $vendor->photo;
                
                if (file_exists(public_path('assets/admin/img/vendor-photo/' . $vendor->photo))) {
                
                   $photoUrl = asset('assets/admin/img/vendor-photo/' . $vendor->photo);
                }
                ?>
                        
                <img 
                style="border-radius: 10%; max-width: 60px;" 
                class="lazyload blur-up"
                src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>"
                data-src="<?php echo e($photoUrl); ?>"  
                alt="Vendor" 
                onload="handleImageLoad(this)"
                onerror="<?php echo e(asset('assets/img/blank-user.jpg')); ?>" >
                
              <?php else: ?>
                <img class="lazyload" src="assets/images/placeholder.png"
                  data-src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>" alt="Vendor">
              <?php endif; ?>
            </a>
          </figure>
          
          <div class="vendor-info">
            <h4 class="mb-2 color-white"><?php echo e($vendor->vendor_info->name); ?></h4>
            <span class="text-light">
               <?php echo e('Member Since'); ?> 
            
               <?php echo e(date('Y' , strtotime($vendor->created_at))); ?>   
                
            </span>
               
                
            <span class="text-light d-block mt-2" style="display: flex !important;">Listings : 
              <?php if(request()->filled('admin')): ?>
                <?php
                  $total_cars = App\Models\Car::where('vendor_id', 0)
                      ->get()
                      ->count();
                ?>
                <?php echo e($total_cars); ?>

              <?php else: ?>
                <?php echo e(count($vendor->cars()->get())); ?>

              <?php endif; ?>
              
              <?php if(!empty($review_data['total_ratings'])): ?>
                &nbsp;. <span> 
                <div class="rating-container" style="font-size: 15px;margin-top: -0.5rem;margin-left: 0.5rem;">
                <span class="star on"></span>  <?php echo e($review_data['total_ratings']); ?>/5
                </div>
                </span>
                  <?php endif; ?>          
            </span>
          </div>
        </div>
      
      </div>
    </div>
  </div>
  <!-- Page title end-->

  <!-- Vendor-area start -->
  <div class="vendor-area pt-40 pb-60">
    <div class="container">
      <div class="row gx-xl-5">
        <div class="<?php if( $vendor->vendor_type == 'dealer' ): ?> col-lg-8 <?php else: ?>  col-lg-12 <?php endif; ?> ">
         
          <div class="tabs-navigation tabs-navigation-2 mb-20">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <button class="nav-link active btn-md" data-bs-toggle="tab" data-bs-target="#tab_all"
                  type="button"> <?php if( $vendor->vendor_type == 'dealer' ): ?> Our Stock <?php else: ?> All Ads <?php endif; ?></button>
              </li>
              <?php
                if (request()->filled('admin')) {
                    $vendor_id = 0;
                } else {
                    $vendor_id = $vendor->id;
                }
                
                $disabled = '';
                
                if(count($all_cars) == 0 )
                {
                   $disabled = 'disabled'; 
                }
                
              ?>
              
              <?php if( $vendor->vendor_type == 'dealer' ): ?>
              <?php if(Auth::guard('vendor')->check() ): ?> 
                <li class="nav-item" <?php if($disabled == 'disabled'): ?> style="border-radius: 0px;background: #dadada;cursor: not-allowed;"  <?php endif; ?>>
                    <button class="nav-link btn-md" data-bs-toggle="modal"  <?php if($disabled == 'disabled'): ?>  style="color: white;"  <?php endif; ?> data-bs-target="#contactModal" <?php echo e($disabled); ?> type="button">Contact us</button>
                </li>
                  <?php else: ?>
                  
                  <?php if($disabled == 'disabled'): ?>
                        <li class="nav-item"  style="border-radius: 0px;background: #dadada;cursor: not-allowed;" >
                      
                        <button class="nav-link btn-md" style="color: white;"  type="button"  <?php echo e($disabled); ?> >Contact us </button> 
                  </li>
                  
                  <?php else: ?>
                  
                  <li class="nav-item">
                  
                    <a class="nav-link btn-md" href="<?php echo e(route('vendor.login')); ?>"   >Contact us</a>
                  </li>
                  <?php endif; ?>
                  
                  <?php endif; ?>
                  
                <li class="nav-item" style="border-radius: 0px;background: #dadada;cursor: not-allowed;" >
                    <button class="nav-link btn-md" style="color: white;" disabled data-bs-toggle="tab" data-bs-target="#tab_review"
                    type="button">Review</button>
                </li>
                
               <?php endif; ?> 
            </ul>
          </div>
          <div class="tab-content" data-aos="fade-up">
            <div class="tab-pane fade show active" id="tab_all">
              <div class="row">
                  
                 
                  
                <?php if(count($all_cars) > 0): ?>
                
                <?php if($vendor->vendor_type == 'dealer'): ?>
                
                <form method="post" onsubmit="return filterFormSubmission(this)" id="filterFormsssss" >
                    <?php echo csrf_field(); ?>
                    
                    <input type="hidden" name="vendor_id" value="<?php echo e($vendor->id); ?>" /> 
                    
                        <div class="col-12" style="margin-bottom: 2rem;">
                        <div class="row">
                        <div class="col-lg-9 col-12">
                          <input type="text" class="form-control" name="search_query" placeholder="Search by title" />
                        </div>
                        
                        <div class="col-lg-3 col-12 d-flex us_filters_btns" id="buttonRows" >
                           
                           <button type="submit" class="btn btn-primary" style="margin-right: 10px;width: 100%;font-size: 20px;padding: 0px;"  id="serachBTN" title="Search" >
                               <i class="fal fa-search" aria-hidden="true"></i></button>
                           <button type="button" class="btn btn-primary" id="filter_btnn" onclick="showFilterSection()" style="width: 100%;font-size: 20px;padding: 0px; display:none;" title="Filters"><i class="fal fa-filter" aria-hidden="true"></i></button>
                        
                        </div>
                        
                        </div>
                        
                        
                        <div class="row us_hidden_by_default" style="margin-top:20px;">
                        <div class="col-lg-4 col-12">
                            <label style="font-size: 15px;margin-bottom: 5px;">Price</label>
                            <div class="d-flex">
                                <select class="form-control" name="min_price" onchange="applyFilter()">
                                    <option value="">Min Price</option>
                                    <?php $__currentLoopData = $price_ranges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($price); ?>"><?php echo e(symbolPrice($price)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                
                                
                                 <select class="form-control" name="max_price" onchange="applyFilter()" >
                                    <option value="">Max Price</option>
                                    <?php $__currentLoopData = $price_ranges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($price); ?>"><?php echo e(symbolPrice($price)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-12 us_filters_btns">
                          <label style="font-size: 15px;margin-bottom: 5px;">Section</label>
                          
                            <select class="form-control" name="category"  onchange="applyFilter()">
                                    <option value="">Select Category</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($categoryData['category']->id); ?>">
                                        <?php echo e($categoryData['category']->name); ?> (<?php echo e($categoryData['count']); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                                
                        </div>
                        
                        
                        <div class="col-lg-4 col-12 us_filters_btns">
                          <label style="font-size: 15px;margin-bottom: 5px;">Sort by: <span>Newest</span></label>
                          
                            <select class="form-control" name="sort_by"  onchange="applyFilter()">
                                    <option value="newest">Newest</option>
                                     <option value="oldest">Oldest</option>
                                      <option value="lowest_price">Lowest Price</option>
                                       <option value="higest_price">Higest Price</option>
                            </select>
                                
                        </div>
                        
                        
                        </div>
                        
                        
                        </div>
                  </form>
                  <?php endif; ?>
                  
                  
                  <div class="col-12" style="margin-bottom: 40px;">
                      <div>
                         <b id="car_counter"><?php echo e(count($all_cars)); ?> </b> ads from    <b><?php echo e(@$vendorInfo->name); ?>   </b>
                      </div>
                  </div>
                  
                  <?php $__currentLoopData = $all_cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car_content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                   <?php
            
            $image_path = $car_content->feature_image;
            
            $rotation = 0;
            
            if($car_content->rotation_point > 0 )
            {
                 $rotation =    $car_content->rotation_point;
            }
            
            if(!empty($image_path) && $car_content->rotation_point == 0 )
            {   
               $rotation = $car_content->galleries->where('image' , $image_path)->first();
               
               if($rotation == true)
               {
                    $rotation = $rotation->rotation_point;  
               }
               else
               {
                    $rotation = 0;   
               }
            }
            
            if(empty($car_content->feature_image))
            {
            $imng = $car_content->galleries->sortBy('priority')->first();
            
            $image_path = $imng->image;
            $rotation = $imng->rotation_point;
            } 
           
            ?>
            
            <span id="appendFilterListing">
             <div class="col-12" data-aos="fade-up" >
                  
                  <?php if($car_content->is_featured == 1): ?>
                    <div class="row g-0 product-default product-column border mb-30 align-items-center p-15" style="<?= ( $car_content->vendor->vendor_type == 'normal' ) ? 'border-top: 5px solid #ff9e02 !important;' : '' ?> padding: 0px !important;transform: translateY(-5px);box-shadow: 0px 0px 20px gray; border-radius:5px;" data-id="<?php echo e($car_content->id); ?>">
                    <?php else: ?>
                        <div class="row g-0 product-default product-column border mb-30 align-items-center p-15" style="padding: 0px !important;transform: translateY(-5px);box-shadow: 0px 0px 20px gray; border-radius:5px;"  data-id="<?php echo e($car_content->id); ?>">
                    <?php endif; ?>
                    
                    <?php if($car_content->vendor_id != 0): ?>   
                    <?php if($car_content->vendor->vendor_type == 'dealer'): ?>
                    
                    <?php if($car_content->is_featured == 1): ?>
                        <div class="col-md-12" style="border-bottom: 5px solid #ff9e02;">
                    <?php else: ?>
                        <div class="col-md-12" style="border-bottom: 1px solid #e9e9e9;">
                    <?php endif; ?>
                    
                        <div class="author mb-15 us_parent_cls" >
                        
                            <a style="padding-top: 1rem;display: flex;padding-left: 1rem;" class="color-medium"
                            href="<?php echo e(route('frontend.vendor.details', ['id' =>$car_content->vendor->id , 'username' => (@$car_content->vendor->username)])); ?>"
                            target="_self" title="<?php echo e(@$car_content->vendor->username); ?>">
                            <?php if($car_content->vendor->photo != null): ?>
                        
                        
                            <?php
                            $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $car_content->vendor->photo;
                            
                            if (file_exists(public_path('assets/admin/img/vendor-photo/' . $car_content->vendor->photo))) {
                            
                            $photoUrl = asset('assets/admin/img/vendor-photo/' . $car_content->vendor->photo);
                            }
                            ?>
                            
                            <img 
                            style="border-radius: 10%; max-width: 60px;" 
                            class="lazyload blur-up"
                            src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>"
                            data-src="<?php echo e($photoUrl); ?>"  
                            alt="Vendor" 
                            onload="handleImageLoad(this)"
                            onerror="<?php echo e(asset('assets/img/blank-user.jpg')); ?>" >
                
                        
                            <?php else: ?>
                            <img style="border-radius: 10%;max-width: 60px;" class="lazyload blur-up" data-src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>"
                            alt="Image">
                            <?php endif; ?>
                            <span>
                             
                             <strong class="us_font_15" style="color: black;font-size: 20px;"><?php echo e($car_content->vendor->vendor_info->name); ?> </strong>
                            
                                 <?php if($car_content->vendor->is_franchise_dealer == 1): ?>
                            
                                    <?php
                                    
                                    $review_data = null;
                                    
                                    ?>
                            
                                <?php if($car_content->vendor->google_review_id > 0 ): ?>
                                    <?php
                                        $review_data = get_vendor_review_from_google($car_content->vendor->google_review_id , true);
                                    ?>
                                <?php endif; ?>
    
                             <div style="display: flex;">Franchise Dealer 
                             
                             
                              <?php if(!empty($review_data) && $review_data['total_reviews'] > 0 && $review_data['total_ratings'] > 0): ?>
                            . <span> 
                            <div class="rating-container" style="font-size: 15px;margin-top: -0.4rem;">
                            <span class="star on"></span>  <?php echo e($review_data['total_ratings']); ?>/5
                            </div>
                            </span>
                        <?php endif; ?>
                        </div>
                        
                        <?php else: ?>
                        
                        <div>Independent Dealer</div> 
                            <?php endif; ?>
                            
                            
                            </span>
                            </a>
                            
                            
                        <?php if($car_content->vendor->is_trusted == 1): ?>
                              <div class="us_trusted">  <span style="background: #0fbd0f;color: white;padding: 1px 10px;border-radius: 20px;font-size: 12px;margin-left: 0.5rem;"><i class="fa fa-check" aria-hidden="true"></i> Trusted Dealer </span></div>
                          <?php endif; ?> 
                          
                             <?php if($car_content->is_sold == 1): ?>
                           <div class="us_trusted">  <span style="background: #ff2f00; margin-left:5px;color: white;padding: 1px 10px;border-radius: 20px;font-size: 12px;"><i class="fa fa-check" aria-hidden="true"></i> Sold </span></div>
                        <?php endif; ?>
                        
                      
                        </div>
                        
                    </div>
                     <?php endif; ?>
                    <?php endif; ?>
            
                  <figure class="product-img col-xl-4 col-lg-5 col-md-6 col-sm-12">
                      
                    <?php if($car_content->is_featured == 1): ?>
                     <div class="sale-tag" style="border-bottom-right-radius: 0px;background: #ff9e02;">Spotlight</div>
                    <?php endif; ?>
                  
                    <a href="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id),'slug' => $car_content->car_content->slug, 'id' => $car_content->id])); ?>"
                      class="lazy-container ratio ratio-2-3">
                      <img class="lazyload"
                        data-src=" <?php echo e($car_content->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path); ?>  " alt="Product" style="transform: rotate(<?php echo e($rotation); ?>deg);" onerror="this.onerror=null;this.src='<?php echo e(asset('assets/img/noimage.jpg')); ?>';">
                    </a>
                    
                    <?php if($car_content->deposit_taken  == 1): ?>
                        <div class="reduce-tag">DEPOSIT TAKEN</div>
                    <?php endif; ?>
            
                  </figure>
                  
                   <div class="product-details col-xl-8 col-lg-7 col-md-6 col-sm-12 border-lg-end pe-lg-2" style="margin-top:0.5rem;cursor:pointer;padding-left: 15px;"  onclick="window.location='<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id), 'slug' => $car_content->car_content->slug, 'id' => $car_content->id])); ?>'" >
                        
                    <span class="product-category font-sm " style=" display: flex;"  >
                        
                    <h5 class="product-title "><a
                        href="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id),'slug' => $car_content->car_content->slug, 'id' => $car_content->id])); ?>"><?php echo e(carBrand($car_content->car_content->brand_id)); ?> <?php echo e(carModel($car_content->car_content->car_model_id)); ?> <?php echo e($car_content->car_content->title); ?></a>
                    </h5>
                    
                    </span>
                    
                    <div class="author mb-10 us_child_dv"   >
                     
                         <span>
                             
                             <?php if($car_content->year): ?>
                                <?php echo e($car_content->year); ?> 
                             <?php endif; ?>
                             
                             <?php if($car_content->engineCapacity && $car_content->car_content->fuel_type ): ?>
                              <b class="us_dot"> - </b>   <?php echo e(roundEngineDisplacement($car_content)); ?> 
                             <?php endif; ?>
                             
                             <?php if($car_content->car_content->fuel_type ): ?>
                              <b class="us_dot"> - </b>   <?php echo e($car_content->car_content->fuel_type->name); ?> 
                             <?php endif; ?>
                             
                             
                             <?php if($car_content->mileage): ?>
                               <b class="us_dot"> - </b>    <?php echo e(number_format( $car_content->mileage )); ?> mi 
                             <?php endif; ?>
                             
                             <?php if($car_content->created_at && $car_content->is_featured != 1): ?>
                                <b class="us_dot"> - </b> <?php echo e(calculate_datetime($car_content->created_at)); ?> 
                             <?php endif; ?>
                             
                             <?php if($car_content->city): ?>
                                <b class="us_dot"> - </b> <?php echo e(Ucfirst($car_content->city)); ?> 
                             <?php endif; ?>
                               
                        </span>
                    
                    </div>
                    
                    <div style="display:flex;margin-top: 1rem;margin-bottom: 1.5rem;">
                        
                        <?php if($car_content->manager_special  == 1): ?>
                        <div class="price-tag" style="padding: 3px 5px;border-radius:5px; background:#25d366;font-size: 10.5px;" > Manage Special</div>
                        <?php endif; ?>
                        
                        <?php if($car_content->is_sale == 1): ?>
                        
                        <div class="price-tag" style="padding: 3px 5px;border-radius:5px;margin-left: 10px;background:#434d89;font-size: 10.5px;" >  Sale </span></div>
                        
                        <?php endif; ?>
                        
                        <?php if($car_content->reduce_price == 1): ?>
                        
                        <div class="price-tag" style="padding: 3px 5px;border-radius:5px;margin-left: 10px;background:#ff4444;font-size: 10.5px;" >  Reduced </span></div>
                        
                        <?php endif; ?>
                        
                        
                         <?php if(!empty($car_content->warranty_duration)): ?>
                            <div class="price-tag" style="padding: 3px 5px;border-radius: 5px;margin-left: 10px;background: #ebebeb;font-size: 10.5px;color: #525252;border: 1px solid #d6d6d6;box-shadow: 0px 0px 5px gray;" > <?php echo e($car_content->warranty_duration); ?> Warranty</span></div>
                        <?php endif; ?>
                        
                    
                    </div>
                    
                    
                    <ul class="product-icon-list  list-unstyled d-flex align-items-center" style="position:relative; bottom:10px;">
                      
                 
                       <?php if($car_content->price != null): ?>
                          <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                            title="Price">
                              <b style="color: gray;">Price</b>
                              <br>
                              <strong  class="us_mrg" style="color: black;font-size: 20px;    margin-left: 0;">
                                    <?php if($car_content->previous_price && $car_content->previous_price < $car_content->price): ?>
                                    <strike style="font-weight: 300;color: red;font-size: 14px;    float: left;"><?php echo e(symbolPrice($car_content->price)); ?></strike> 
                                    
                                    <div style="color:black;"> 
                                        <?php echo e(symbolPrice($car_content->previous_price)); ?>

                                    </div>
                                    <?php else: ?>
                                        <?php echo e(symbolPrice($car_content->price)); ?>   
                                    <?php endif; ?>
                            </strong>
                          </li>
                      <?php endif; ?>
                      
                       <?php if($car_content->price != null && $car_content->price >= 1000): ?>
                          <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                            title="">
                              <b style="color: gray;">From</b>
                              <br>
                            <strong style="color: black;font-size: 20px;"><?php echo calulcateloanamount(!empty($car_content->previous_price && $car_content->previous_price < $car_content->price ) ? $car_content->previous_price : $car_content->price)[0]; ?></strong>
                          </li>
                      <?php endif; ?>
                      
                    </ul>
                   
                  </div>
                  
            
                  <?php if(Auth::guard('vendor')->check()): ?>
                    <?php
                      $user_id = Auth::guard('vendor')->user()->id;
                      $checkWishList = checkWishList($car_content->id, $user_id);
                    ?>
                  <?php else: ?>
                    <?php
                      $checkWishList = false;
                    ?>
                  <?php endif; ?>
                  
                  <a href="javascript:void(0);"
                        onclick="addToWishlist(<?php echo e($car_content->id); ?>)"
                    class="btn btn-icon us_wishlist2 " data-tooltip="tooltip"
                    data-bs-placement="right"
                    title="<?php echo e($checkWishList == false ? __('Save Ads') : __('Saved')); ?>">
                    <?php if($checkWishList == false): ?>
                    <i class="fal fa-heart" style="color:red;" ></i>
                    <?php else: ?>
                    <i class="fa fa-heart" aria-hidden="true" style="color:red;"></i>
                    <?php endif; ?>
                  </a>
                  
                  <a href="javascript:void(0);" class="us_wishlist2 btn-icon  us_share_icon" style=" color: #1b87f4 !important;" onclick="openShareModal(this)" 
                    data-url="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id),'slug' => $car_content->car_content->slug, 'id' => $car_content->id])); ?>"
                    style="
                    color: #1b87f4;
                    " ><i class="fa fa-share-alt" aria-hidden="true"></i>
                    </a>
                        
                        
                </div><!-- product-default -->
              </div>
              
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                  <h4 class="text-center mt-4 mb-4"><?php echo e(__('No Ads Found')); ?></h4>
                <?php endif; ?>
              </div>
            </div>
           
           </span>
           
           
          <div class="tab-pane fade " id="tab_review">
				     
					<div class="card-body">
						<div class="product-desc">
						  <h4 class="mb-20">
						    
						  
						  <?php if(!empty($review_data) &&  $review_data['total_reviews'] > 0 && $review_data['total_ratings'] > 0): ?>
						  <?php echo e(request()->input('admin') == true ? @$car_content->vendor->first_name : @$vendorInfo->name); ?>

                            <div class="rating-container" style="font-size: 13px;font-weight: 500;">
                            <?php echo $review_data['rating_stars']; ?>  <b><?php echo e($review_data['total_ratings']); ?></b>/5 .   <a target="_blank" style="color: #ee2c7b;" href="https://www.google.com/maps?q=<?php echo e(str_replace(' ' , '+' , $vendorInfo->name)); ?>"> <?php echo e(number_format($review_data['total_reviews'] )); ?> google reviews </a>
                            </div>

                        <?php endif; ?>
						  </h4>
						  <div class="tinymce-content">
						      <?php if(!empty($review_data) &&  $review_data['total_reviews'] > 0 && $review_data['total_ratings'] > 0): ?>
						    	<?php echo $review_data['reviews_outout']; ?>

							  <?php endif; ?>
						  </div>
						</div>
					</div>
				</div>
           
           
          </div>

          <?php if(!empty(showAd(3))): ?>
            <div class="text-center mt-4">
              <?php echo showAd(3); ?>

            </div>
          <?php endif; ?>
        </div>
        
        
        <div class="col-lg-4">
        <?php if($vendor->vendor_type == 'dealer'): ?>
          <aside class="widget-area" data-aos="fade-up">
            <div class="widget-vendor mb-40 border p-20">
              <div class="vendor mb-20 text-center">
                <figure class="vendor-img mx-auto mb-15">
                  <div class="lazy-container ratio ratio-1-1" style="border-radius:10px;">
                    <?php if(!empty($vendor->photo)): ?>
               
                    <?php
                    $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $vendor->photo;
                    
                    if (file_exists(public_path('assets/admin/img/vendor-photo/' . $vendor->photo))) {
                    
                    $photoUrl = asset('assets/admin/img/vendor-photo/' . $vendor->photo);
                    }
                    ?>
                    
                    <img 
                    style="border-radius: 10%; max-width: 60px;" 
                    class="lazyload blur-up"
                    src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>"
                    data-src="<?php echo e($photoUrl); ?>"  
                    alt="Vendor" 
                    onload="handleImageLoad(this)"
                    onerror="<?php echo e(asset('assets/img/blank-user.jpg')); ?>" >
                            
                            
                    <?php else: ?>
                      <img class="lazyload" data-src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>" alt="Vendor">
                    <?php endif; ?>
                  </div>
                </figure>
                <div class="vendor-info">
                  <span class="verification">
                    <?php echo e(request()->input('admin') == true ? @$car_content->vendor->first_name : @$vendorInfo->name); ?>

                  </span>
                  <br>
                    <?php if(!empty($review_data['total_ratings'])): ?>
                 <span> 
                <div class="rating-container" style="font-size: 15px;">
                <span class="star on"></span>  <?php echo e($review_data['total_ratings']); ?>/5
                </div>
                </span>
                  <?php endif; ?> 
                </div>
              </div>
              <!-- about text -->
              <?php if(request()->input('admin') == true): ?>
                <?php if(!is_null($car_content->vendor->details)): ?>
                  <div class="font-sm">
                    <div class="click-show">
                      <p class="text">
                        <span class="color-dark"><b><?php echo e(__('About') . ':'); ?></b></span>
                        <?php echo e($car_content->vendor->details); ?>

                      </p>
                    </div>
                    <div class="read-more-btn"><span><?php echo e(__('Read more')); ?></span></div>
                  </div>
                <?php endif; ?>
              <?php else: ?>
                <?php if(!is_null(@$vendorInfo->details)): ?>
                  <div class="font-sm">
                    <div class="click-show">
                      <p class="text">
                        <span class="color-dark"><b><?php echo e(__('About') . ':'); ?></b></span>
                        <?php echo e(@$vendorInfo->details); ?>

                      </p>
                    </div>
                    <div class="read-more-btn"><span><?php echo e(__('Read more')); ?></span></div>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
              <hr>
              
              <ul class="toggle-list list-unstyled mt-15" id="toggleList" data-toggle-show="6">
                <li>
                  <span class="first"><?php echo e(__('Stock')); ?></span>
                  <span
                    class="last"><?php echo e(request()->input('admin') == true? $total_cars: $vendor->cars()->get()->count()); ?></span>
                </li>

                <?php if($vendor->show_phone_number == 1): ?>
                  <li>
                    <span class="first"><?php echo e(__('Phone')); ?></span>
                    <span class="last"><a href="tel:<?php echo e($vendor->country_code.$vendor->phone); ?>"><?php echo e($vendor->country_code.$vendor->phone); ?></a></span>
                  </li>
                <?php endif; ?>

                <?php if(request()->input('admin') != true): ?>
                  <?php if(!is_null(@$vendorInfo->city)): ?>
                    <li>
                      <span class="first">Location</span>
                      <span class="last"><?php echo e(Ucfirst(@$vendorInfo->city)); ?></span>
                    </li>
                  <?php endif; ?>

              <?php endif; ?>
                
                  <?php if(request()->input('admin') != true): ?>
                  <li>
                    <span class="first"><?php echo e(__('Member since') . ':'); ?></span>
                    <span class="last font-sm"><?php echo e(\Carbon\Carbon::parse($vendor->created_at)->format('Y')); ?></span>
                  </li>
                  
                  <?php if(!empty($vendor->est_year)): ?>
                             <li>
                    <span class="first">Est year</span>
                    <span class="last font-sm"><?php echo e(!empty($vendor->est_year) ? $vendor->est_year : date('Y')); ?></span>
                  </li>
                            <?php endif; ?>
                <?php endif; ?>
                
                <?php if($vendor->website_link): ?>
                  <li>
                    <span class="first">Website</span>
                    <span class="last text-primary" ><a href="<?php echo e($vendor->website_link); ?>"  style="color: #1b87f4 !important;" target="_blank" >Visit</a></span>
                  </li>
                <?php endif; ?>
                
                
                <?php if(request()->input('admin') == true ): ?>
                  <li>
                    <span class="first"><?php echo e(__('Location') . ' : '); ?></span>
                    <span class="last"><?php echo e($vendor->address != null ? $vendor->address : '-'); ?></span>
                  </li>
                <?php else: ?>
                  <li>
                    <span class="first"><?php echo e(__('Location') . ' : '); ?></span>
                    <span class="last"><?php echo e(@$vendorInfo->address != null ? @$vendorInfo->address : '-'); ?></span>
                  </li>
                <?php endif; ?>
                
               <div class="flex" style="margin-bottom:  1.5rem;cursor:pointer; display:none;" onclick="openHours(this)" id="append_dropdown"></div>
                            
                            
                                <?php $__currentLoopData = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $dayKey = ucfirst($day);
                                    $openingHour = $openingHours[$dayKey] ?? null;
                                    $status = '';
                                    $timeRange = '';
                                    $labelColor = '';
                                    
                                    $p_label = '';
                                    $p_status = '';
                                    $p_timeRange = '';
                                    
                                    if ($openingHour) 
                                    {
                                        if ($openingHour->holiday) 
                                        {
                                            $status = 'Closed';
                                            $labelColor = 'red';
                                        } 
                                        else 
                                        {
                                            $openTime = \Carbon\Carbon::createFromFormat('H:i:s', $openingHour->open_time)->format('h:i A');
                                            $closeTime = \Carbon\Carbon::createFromFormat('H:i:s', $openingHour->close_time)->format('h:i A');
                                            $currentDateTime = \Carbon\Carbon::createFromFormat('H:i', $currentTime);
                            
                                            $openingDateTime = \Carbon\Carbon::createFromFormat('H:i:s', $openingHour->open_time);
                                            $closingDateTime = \Carbon\Carbon::createFromFormat('H:i:s', $openingHour->close_time);
                                                
                                                
                                            $timeRange = " $openTime to $closeTime";
                                           
                                            if ($currentDay === $dayKey) 
                                            {
                                           
                                                $labelColor = '#1b87f4';
                                            
                                                if ($currentDateTime->between($openingDateTime, $closingDateTime)) 
                                                {
                                                    $p_status = 'Opened Now';
                                                    $p_label = '#1b87f4';
                                                } 
                                                else 
                                                {
                                                    $p_status = 'Closed Now';
                                                    $p_label = 'red';
                                                }
                                                
                                                 $p_timeRange = 'See Opening Hours';
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $status = 'Closed';
                                        $labelColor = 'red';
                                    }
                                 
                                ?>
                                
                                <?php if(!empty($p_status)): ?>
                              
                                <div class="flex" style="margin-bottom: 0.5rem;cursor:pointer; display:none;" onclick="openHours(this)">
                                    <label style="font-size: 15px; color: <?php echo e($p_label); ?>"><?php echo e($p_status); ?></label>
                                        <div style="float:right; color: black">
                                        <?php echo e($p_timeRange); ?> <i class="fa fa-caret-down" style="position: relative;
                                        margin-left: 10px;
                                        font-size: 20px;
                                        top: 1px;" aria-hidden="true"></i> 
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <div class="flex us_open_hours" style="margin-bottom:  0.5rem;">
                                    <label style="font-size: 15px; color: <?php echo e($labelColor); ?>"><?php echo e($day); ?></label>
                                    <div style="float:right; color: <?php echo e($labelColor); ?>">
                                        <?php echo e($status); ?> <?php echo e($timeRange); ?>

                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            
                
              </ul>
             
            
            </div>

            <?php if(!empty(showAd(1))): ?>
              <div class="text-center mb-40">
                <?php echo showAd(1); ?>

              </div>
            <?php endif; ?>

            <?php if(!empty(showAd(2))): ?>
              <div class="text-center mb-40">
                <?php echo showAd(2); ?>

              </div>
            <?php endif; ?>
          </aside>
             <?php endif; ?>
             
        </div>
      
         
      </div>
    </div>
  </div>
  <!-- Vendor-area end -->

  <!-- Contact Modal -->
  <div class="modal contact-modal fade" id="contactModal" style="background-color: rgba(0, 0, 0, 0.4);" tabindex="-1" aria-labelledby="contactModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title mb-0" id="contactModalLabel"><?php echo e(__('Contact Now')); ?></h1>
            <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close">X</button>
        </div>
          <form action="<?php echo e(route('vendor.contact.message')); ?>" method="POST" id="vendorContactForm">
            <?php echo csrf_field(); ?>
           <div class="modal-body">
           <input type="hidden" name="vendor_email" value="<?php echo e($vendor->email); ?>" />
            <div class="user mb-20">
               <div class="row">
              <div class="col-2">
                  <div class="user-img" style="max-width: 80px">
                    <div class="lazy-container ratio ratio-1-1 rounded-pill">
                      <?php if($vendor->photo != null): ?>
                  
                
                <?php
                    $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $vendor->photo;
                    
                    if (file_exists(public_path('assets/admin/img/vendor-photo/' . $vendor->photo))) {
                    
                    $photoUrl = asset('assets/admin/img/vendor-photo/' . $vendor->photo);
                    }
                    ?>
                    
                    <img 
                    style="border-radius: 10%; max-width: 60px;" 
                    class="lazyload blur-up"
                    src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>"
                    data-src="<?php echo e($photoUrl); ?>"  
                    alt="Vendor" 
                    onload="handleImageLoad(this)"
                    onerror="<?php echo e(asset('assets/img/blank-user.jpg')); ?>" >
                    
                      <?php else: ?>
                        <img class="lazyload" data-src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>" alt="">
                      <?php endif; ?>
                    </div>
                  </div>
                </div> 
                 <div class="col-8"> 
                  <div class="user-info">
                    <h6 class="mb-1">
                      <a href="<?php echo e(route('frontend.vendor.details', ['id' => $vendor->id , 'username' => $vendor->username] )); ?>"
                        title="<?php echo e($vendor->username); ?>"><?php echo e($vendor->vendor_info->name); ?></a>
                    </h6>
                    
                    <?php if($vendor->vendor_type == 'normal'): ?>
                    <?php if($vendor->trader==0): ?>
                        <p><?php echo e(Ucfirst(@$vendor->vendor_info->city)); ?> <?php if(!empty($vendor->vendor_info->city)): ?> . <?php endif; ?>  Private Seller, </p>
                    <?php else: ?>
                        <p><?php echo e(Ucfirst(@$vendor->vendor_info->city)); ?> <?php if(!empty($vendor->vendor_info->city)): ?> . <?php endif; ?>  Trader, </p>
                    <?php endif; ?>
                    <?php else: ?>
                        <p>Send an email to the dealer </p>
                    <?php endif; ?>
                    
                    <?php if(!empty($review_data) && $review_data['total_reviews'] > 0 && $review_data['total_ratings'] > 0): ?>
                    <div class="rating-container">
                    <?php echo $review_data['rating_stars']; ?> . <?php echo e($review_data['total_ratings']); ?>/5
                    </div>
                    
                    <div>  <a  target="_blank" style="color: #ee2c7b;" href="https://www.google.com/maps?q=<?php echo e(str_replace(' ' , '+' , $vendor->vendor_info->name)); ?>"> <?php echo e(number_format($review_data['total_reviews'] )); ?> google reviews </a> </div>
                    <?php endif; ?>
                        
                  </div>
            </div>

            </div>
            
            <?php if($vendor->vendor_type == 'dealer' && Auth::guard('vendor')->check()): ?>
              <div class="row" style="margin-top: 1rem;">
                <div class="col-12 mb-3">  
                    <label style="font-size: 15px;">Your full name</label>
                    <input type="text" name="name" class="form-control mt-1" required value="<?php echo e(Auth::guard('vendor')->user()->vendor_info->name); ?>"/>
                </div>
                
                <div class="col-12 mb-3">  
                    <label style="font-size: 15px;" >Email</label>
                    <input type="text" name="email" class="form-control mt-1"  required readonly  value="<?php echo e(Auth::guard('vendor')->user()->email); ?>"/>
                </div>
                
                
                <div class="col-12 mb-3">  
                    <label style="font-size: 15px;" >Your phone number</label>
                    <input type="text" name="phone_no" class="form-control mt-1"  required  value="<?php echo e(Auth::guard('vendor')->user()->country_code.Auth::guard('vendor')->user()->phone); ?>"/>
                </div>
                
                <div class="col-12 mb-4">  
                    <label style="font-size: 15px;"  class="mb-3">I'm interested in ...</label>
                    <div style="display:flex;" class="mb-2">
                        <input type="checkbox" name="field_name[]" class=" mt-1" style="display:block;zoom: 1.5;" value="financing"/> <span style="margin-left: 10px;margin-top: 5px;">Financing this vehicle</span>
                    </div>
                      <div style="display:flex;" class="mb-2">
                    <input type="checkbox" name="field_name[]" class=" mt-1"  style="display:block;zoom: 1.5;" value="scheduling"/> <span style="margin-left: 10px;margin-top: 5px;">Scheduling test drive</span>
                     </div>
                      <div style="display:flex;" class="mb-2">
                    <input type="checkbox" name="field_name[]" class=" mt-1"  style="display:block;zoom: 1.5;" value="trading"/> <span style="margin-left: 10px;margin-top: 5px;">Trading in my current vehicle</span>
                     </div>
                      <div style="display:flex;" class="mb-2">
                    <input type="checkbox" name="field_name[]" class=" mt-1"  style="display:block;zoom: 1.5;" value="conditions"/> <span style="margin-left: 10px;margin-top: 5px;" >More about condition</span>
                     </div>
                </div>
                
              </div> 
            <?php endif; ?> 
            
           <div class="row">
              <div class="col-12">  
               <label style="font-size: 15px;" >Your message</label>
            <textarea id="en_description" class="form-control mt-1" name="description" data-height="200">Hi, Please Connect Call..</textarea>
            </div>
          </div> </div> 
         </div>
      
              <div class="col-lg-12 text-center">
                <button class="btn btn-lg btn-primary" id="vendorSubmitBtn" type="submit"
                  aria-label="button" style="    width: 95%;margin: 1rem 10px 1rem 10px;">
                    <?php if($vendor->vendor_type == 'normal'): ?>
                    <?php echo e(__('Send message')); ?>

                    <?php else: ?>
                     Enquire now
                    <?php endif; ?>
                   
                    
                    </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("frontend.layouts.layout-v$version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/vendor/details.blade.php ENDPATH**/ ?>