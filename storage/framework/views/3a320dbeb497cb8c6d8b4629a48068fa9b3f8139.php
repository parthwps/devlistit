<?php
$version = $basicInfo->theme_version;
?>

<?php $__env->startSection('pageHeading'); ?>
<?php echo e(__('Ads')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('metaKeywords'); ?>
<?php if(!empty($seoInfo)): ?>
<?php echo e($seoInfo->meta_keyword_cars); ?>

<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('metaDescription'); ?>
<?php if(!empty($seoInfo)): ?>
<?php echo e($seoInfo->meta_description_cars); ?>

<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="page-title-area ptb-40 bg-img <?php echo e($basicInfo->theme_version == 2 || $basicInfo->theme_version == 3 ? 'has_header_2' : ''); ?>"
   style="background-color:#FAFAFA; box-shadow:rgba(51, 51, 51, 0.24) 0px 1px 4px" >
   <div class="container">
      <div class="content">
         <ul class="list-unstyled pb-2 topbreadcrumb">
            <li class="d-inline bigarrow"><i class="fal fa-angle-left fa-2x" ></i></li>
            <li class="d-inline" style ="margin-right:10px;"><a class = "font-sm" href="<?php echo e(URL::previous()); ?>"><?php echo e(__('Back')); ?></a></li>
            <li class="d-inline"><a class = "font-sm" href="<?php echo e(route('index')); ?>"><?php echo e(__('Home')); ?></a></li>
            <span id="categories_breadcrium">
               <?php if($breadcrumb): ?>
               <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <li class="d-inline">></li>
               <li class="d-inline active opacity-75">
                  <a class = "font-sm" href="<?php echo e(route('frontend.cars', ['category' => $key])); ?>">  
                  <?php echo e($val); ?>

                  </a>
               </li>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               <?php else: ?>
               <li class="d-inline">></li>
               <li class="d-inline active opacity-75">All Sections</li>
               <?php endif; ?>
            </span>
         </ul>
         <h2>
            <?php if(!empty(request()->input('category'))): ?>
            <?php echo e(ucwords(str_replace("-", " ", request()->input('category')))); ?>

            <?php else: ?>
            All Sections 
            <?php endif; ?>
         </h2>
      </div>
    </div>
  </div>
  
  
  
<style>
   .feater-dealer-title{
  color:rgb(255, 255, 255);
  /* border:1px solid red; */
  font-size:18px;
  font-weight: 100;
}
.loading-section{
   display: none !important;
}
.product-icon-list li:not(:last-child) {
    -webkit-padding-end: 15px;
    padding-inline-end: 5px;
    -webkit-margin-end: 15px;
    margin-inline-end: 15px !important;
    border-inline-end: 1px solid var(--border-color);
}
.filter-reset-link {
    font-size: 14px;
    line-height: 24px;
    font-weight: 600;
    color: rgb(43, 94, 222);
    cursor: pointer;
    display: block;
    padding: 0px;
    text-align: right;
}
  .save-search-btn {
    background-color: rgb(219, 223, 230) !important;
    box-shadow: none;
    border: none !important;
    cursor: not-allowed;
    color: rgb(158, 165, 178) !important;
}
  .us_filter_design {
    background: white;
    box-shadow: 0px 0px 0px transparent;
    padding: 0rem !important;
    border-radius: 10px;
}

.save-search-btn{
  background-color: rgb(219, 223, 230) !important;
    box-shadow: none;
    border: none !important;
    cursor: not-allowed;
    color: rgb(158, 165, 178) !important;
}  
.widget-area .accordion-button::after {

font-size: 30px !important;
font-weight: 100 !important;

}

.us_cat_cls2{
display: flex;
  -webkit-box-pack: justify;
  justify-content: space-between;
  padding: 0px 16px;
  font-size: 14px;
  line-height: 24px;
  color: rgb(34, 40, 49);
  height: 48px;
  -webkit-box-align: center;
  align-items: center;
  border-bottom: none;
  font-family: Lato, sans-serif;
  /* border: 1px solid red !important; */
}

.ads_header{
flex: 1 1 auto;
font-size: 16px;
line-height: 24px;
font-weight: normal;
word-break: break-word;
color: black;
}

.custom_col{
width: 49% !important;
}
.custom_btn{
width:95% !important;
font-size: 13px !important;
}

.custom_btn:hover{
font-size: 13px !important;
}


.widget-area .accordion-button::after {

  font-size: 30px !important;
  font-weight: 100 !important;
  
}
   .us_grid_width {
   display: inline-block;
   min-width: 100%;
   width: 200px;
   overflow: hidden;
   white-space: nowrap;
   text-overflow: ellipsis;
   font-size: 18px;
   }
   .us_loan
   {
   margin-left: 5px;
   margin-top: 5px;
   display: inline-block !important;
   color: #808080;
   }
   .lazy-container {
   position: relative;
   overflow: hidden;
   display: table;
   table-layout: fixed;
   width: 100%;
   background-color: var(--color-light);
   z-index: 0 !important;
   }
   .product-sort-area .nice-select .list {
   height: auto !important;
   overflow-y: hidden !important;
   }
   .us_dot
   {
   font-size: 25px;
   position: relative;
   margin-left: 5px;
   top: -3px;
   }
   .grid_card_price{
   color: #222831; font-size: 24px;
   }
   @media (min-width: 1200px){
   .paddingTop{
   padding-top: 28px !important;
   } 
   .dealer-product-card{
      width: 20%;
      /* border: 1px solid green !important; */
  }
   } 
   @media (max-width: 1399px){
   .paddingTop{
   padding-top: 28px !important;
   } 
   } 
   @media (max-width: 1025px){
   .paddingTop{
   padding-top: 0px !important;
   } 
   .dealer-product-card{
      /* border: 1px solid blue !important; */
      width: 22%;
  }
   } 
   @media (max-width: 991px) {
  .dealer-product-card{
    width: 33%;
    /* border: 1px solid purple !important; */
  }
  .custom-dealer-detail{
    width:50%;
    /* border:1px solid purple; */
  }
  
}
   @media (max-width: 768px){
   .paddingTop{
   padding-top: 0px !important;
   } 
   {
  .dealer-product-card{
    /* border: 1px solid orange !important; */
  }
  .custom-dealer-detail{
    width:100%;
    /* border:1px solid orange; */
  }
  #carFeature{
    margin: 0px !important;
  }
   } 
   @media (max-width: 375px){
   .grid_card_price{
   color: #222831; font-size: 32px;
   }
   
   }
</style>
<!-- Listing-grid-area start -->
<div class="listing-grid-area pt-70 pb-40">
<div class="container">
   <div class="row gx-xl-5">
      <div class="col-lg-4 col-xl-3">
         <div class="widget-offcanvas offcanvas-lg offcanvas-start" tabindex="-1" id="widgetOffcanvas"
            aria-labelledby="widgetOffcanvas">
            <div class="offcanvas-header px-20">
               <h4 class="offcanvas-title"><?php echo e(__('Filter')); ?></h4>
               <button type="button" class="btn-close us_btn_close" data-bs-dismiss="offcanvas" data-bs-target="#widgetOffcanvas"
                  aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-3 p-lg-0 us_filter_design">
               <form action="<?php echo e(route('frontend.cars')); ?>" method="get" id="searchForm" class="w-100">
                  <?php if(!empty(request()->input('category'))): ?>
                  <input type="hidden" name="category" value="<?php echo e(request()->input('category')); ?>">
                  <?php endif; ?>
                  <aside class="widget-area">
                     <div class="widget widget-select p-0 mb-20">
                        <div class="row">
                           <div class="col-12 pb-40">
                            <a href="<?php echo e(route('frontend.cars')); ?>" 
                            class="btn btn-lg btn-outline active icon-start w-100 save-search-btn" style="cursor: not-allowed;" ><i class="fal fa-star fa-lg" ></i><?php echo e(__('Save Search')); ?></a></div>
                           <div class="col-6">
                              <h4>Filters</h4>
                           </div>
                           <div class="col-6 text-right">
                              <div class="cta">
                                 <a href="<?php echo e(route('frontend.cars')); ?>" 
                                 class="filter-reset-link">
                                 <!-- <i class="fal fa-sync-alt"></i> -->
                                 <?php echo e(__('Reset All')); ?></a>
                              </div>
                           </div>
                           <hr/> 
                        </div>
                     </div>
                     <?php if( request()->get('category') != "carsuu" ): ?>
                     <?php if ($__env->exists('frontend.car.carfilter')) echo $__env->make('frontend.car.carfilter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                     <?php endif; ?>
                     <?php if(!empty(showAd(1))): ?>
                     <div class="text-center mt-40">
                        <?php echo showAd(1); ?>

                     </div>
                     <?php endif; ?>
                     <!-- Spacer -->
                     <div class="pb-40"></div>
                  </aside>
            </div>
         </div>
      </div>
      <div class="col-lg-8 col-xl-9" id="ajaxcall">
       <div class="product-sort-area">
      <div class="row align-items-center">
      <div class="col-lg-6">
      <h4 class="mb-20"  style="display: none;" id="total_counter_with_category"><?php echo e($total_cars); ?> <?php echo e($total_cars > 1 ? __('Ads') : __('Ads')); ?>

      <?php echo e(__('Found')); ?>

      <?php if(!empty(request()->input('category'))): ?>
      <?php echo e(__('in')); ?>  <?php echo e(ucwords(str_replace("-"," ",(request()->input('category'))))); ?>

      <?php endif; ?>
      </h4>
      </div>
      <div class="col-4 d-lg-none">
      <button class="btn btn-sm btn-outline icon-end radius-sm mb-20" type="button"
         data-bs-toggle="offcanvas" data-bs-target="#widgetOffcanvas" aria-controls="widgetOffcanvas">
      <?php echo e(__('Filter')); ?> <i class="fal fa-filter"></i>
      </button>
      </div>
      <div class="col-8 col-lg-6">
      <ul class="product-sort-list list-unstyled mb-20">
      <li class="item me-4">
      <div class="sort-item d-flex align-items-center">
      <label class="me-2 font-sm"><?php echo e(__('Sort By')); ?>:</label>
      <?php if(!empty(request()->input('title'))): ?>
      <input type="hidden" name="title" value="<?php echo e(request()->input('title')); ?>">
      <?php endif; ?>
      <?php if(!empty(request()->input('location'))): ?>
      <input type="hidden" name="location" value="<?php echo e(request()->input('location')); ?>">
      <?php endif; ?>
      <?php if(!empty(request()->input('brands'))): ?>
      <?php $__currentLoopData = request()->input('brands'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <input type="hidden" name="brands[]" value="<?php echo e($brand); ?>">
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endif; ?>
      <?php if(!empty(request()->input('models'))): ?>
      <?php $__currentLoopData = request()->input('models'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <input type="hidden" name="models[]" value="<?php echo e($model); ?>">
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endif; ?>
      <?php if(!empty(request()->input('fuel_type'))): ?>
      <input type="hidden" name="fuel_type" value="<?php echo e(request()->input('fuel_type')); ?>">
      <?php endif; ?>
      <?php if(!empty(request()->input('transmission'))): ?>
      <input type="hidden" name="transmission" value="<?php echo e(request()->input('transmission')); ?>">
      <?php endif; ?>
      <?php if(!empty(request()->input('condition'))): ?>
      <input type="hidden" name="condition" value="<?php echo e(request()->input('condition')); ?>">
      <?php endif; ?>
      <?php if(!empty(request()->input('min'))): ?>
      <input type="hidden" name="min" value="<?php echo e(request()->input('min')); ?>">
      <?php endif; ?>
      <?php if(!empty(request()->input('max'))): ?>
      <input type="hidden" name="max" value="<?php echo e(request()->input('max')); ?>">
      <?php endif; ?>
      <select name="sort" class="nice-select right color-dark" onchange="updateBySorting()">
      <option <?php echo e(request()->input('sort') == 'new' ? 'selected' : ''); ?> value="new">
      <?php echo e(__('Date : Newest')); ?>

      </option>
      <option <?php echo e(request()->input('sort') == 'old' ? 'selected' : ''); ?> value="old">
      <?php echo e(__('Date : Oldest')); ?>

      </option>
      <option <?php echo e(request()->input('sort') == 'high-to-low' ? 'selected' : ''); ?> value="high-to-low">
      <?php echo e(__(' Highest price')); ?></option>
      <option <?php echo e(request()->input('sort') == 'low-to-high' ? 'selected' : ''); ?> value="low-to-high">
      <?php echo e(__('Lowest Price')); ?></option>
      <?php if(request()->category && (request()->category  == 'cars' || request()->category  == 'cars-&-motors' ) ): ?>
      <option <?php echo e(request()->input('sort') == 'high-to-mileage' ? 'selected' : ''); ?> value="high-to-mileage">
      <?php echo e(__(' Highest  mileage')); ?></option>
      <option <?php echo e(request()->input('sort') == 'low-to-mileage' ? 'selected' : ''); ?> value="low-to-mileage">
      <?php echo e(__(' Lowest mileage')); ?></option>
      <?php endif; ?>
      </select>
      </form>
      </div>
      </li>
      <li class="item">
      <?php
      $queryParamsList = array_merge(request()->query(), ['type' => 'list']);
      ?>
      <a href="<?php echo e(route('frontend.cars', $queryParamsList)); ?>" class="btn-icon <?php if(empty(request()->type) || request()->type == 'list'): ?> active <?php endif; ?>" data-tooltip="tooltip" data-type='list'
         data-bs-placement="top" title="<?php echo e(__('List View')); ?>">
      <i class="fas fa-th-list"></i>
      </a>
      </li>
      <li class="item">
      <?php
      $queryParamsGrid = array_merge(request()->query(), ['type' => 'grid']);
      ?>
      <a href="<?php echo e(route('frontend.cars', $queryParamsGrid)); ?>" class="btn-icon <?php if(!empty(request()->type) && request()->type == 'grid'): ?> active <?php endif; ?>" data-tooltip="tooltip" data-type="grid"
         data-bs-placement="top" title="<?php echo e(__('Grid View')); ?>">
      <i class="fas fa-th-large"></i>
      </a>
      </li>
      </ul>
      </div>
      </div>
      </div>
      <?php echo $__env->make('frontend/car/dataloader-grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo $__env->make('frontend/car/dataloader-grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo $__env->make('frontend/car/dataloader-grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row" id="ajaxListing" style="display:none;">
      <?php if($car_contents->count() == 0): ?>
      <div class="col-12"> <center> <h4>Sorry, No Posts Matched Your Criteria</h4> </center> </div>
      <?php else: ?>
      <?php
      $admin = App\Models\Admin::first();
      ?>
      <?php $__currentLoopData = $car_contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $car_content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php
      $image_path = $car_content->feature_image;
      $rotation = 0;
      if($car_content->rotation_point > 0 )
      {
      $rotation = $car_content->rotation_point;
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
      <?php if( $key == 6 || $key == 12 ): ?>
      <div class="widget-banner" style="margin-bottom: 1rem;">
      <?php if(!empty(showAd(1))): ?>
      <div class="text-center">
      <?php echo showAd(1); ?>

      </div>
      <?php endif; ?>
      <?php if(!empty(showAd(2))): ?>
      <div class="text-center">
      <?php echo showAd(2); ?>

      </div>
      <?php endif; ?>
      </div>
      <?php endif; ?>
      <div class="col-xl-4 col-md-6 position-relative">
      <?php if($car_content->is_featured == 1): ?>
      <div class="sale-tag" style="border-top-left-radius: 10px;background:#ff9e02;">Spotlight</div>
      <?php endif; ?>
      <?php echo $__env->make('frontend/car/dataloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php if($car_content->is_featured == 1): ?>
      <div class="product-default set_height border position-relative  mb-25" 
         data-id="<?php echo e($car_content->id); ?>" style="border-radius: 10px;">
      <?php else: ?>
      <div class="product-default border set_height position-relative  mb-25" 
         data-id="<?php echo e($car_content->id); ?>" style="border-radius: 10px;">
      <?php endif; ?>
      <figure class="product-img mb-15 position-relative" >
      <a href="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id])); ?>"
         class="lazy-container ratio ratio-2-3">
      <img class="lazyload"
         data-src="<?php echo e($car_content->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path); ?>"
         alt="<?php echo e(optional($car_content)->title); ?>" style="z-index:-1; transform: rotate(<?php echo e($rotation); ?>deg);" >
      </a>
      <?php if($car_content->deposit_taken  == 1): ?>
      <div class="reduce-tag">DEPOSIT TAKEN</div>
      <?php endif; ?>
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
      <?php if($car_content->is_sold == 1): ?>
      <div href="javascript:void(0);"
         onclick="addToWishlist(<?php echo e($car_content->id); ?>)"
         class="us_wishlist"
         data-tooltip="tooltip" data-bs-placement="right"
         title="<?php echo e($checkWishList == false ? __('Save Ad') : __('Saved')); ?>"
         style="position: absolute;
         right: 10px;
         bottom: 10px;
         cursor: pointer;
         background:white;
         color:red !important;
         z-index: 0 !important; /* Adjusted z-index */
         border: none;
         border-radius: 50%;
         padding: 6px;
         width: 40px;
         height:40px;
         display: flex;
         justify-content: center;
         align-items: center;">
      <?php if($checkWishList == false): ?>
      <i class="fal fa-heart" style="color:#35373b !important;font-size:20px;"></i>
      <?php else: ?>
      <i class="fa fa-heart" style="color:#35373b !important;font-size:20px;" aria-hidden="true"></i>
      <?php endif; ?>
      </div>
      <?php else: ?>
      <div href="javascript:void(0);"
         onclick="addToWishlist(<?php echo e($car_content->id); ?>)"
         class="us_wishlist"
         data-tooltip="tooltip" data-bs-placement="right"
         title="<?php echo e($checkWishList == false ? __('Save Ad') : __('Saved')); ?>"
         style="position: absolute;
         right: 10px;
         bottom: 10px;
         cursor: pointer;
         background:white;
         color:red !important;
         z-index: 1 important; /* Adjusted z-index */
         border: none;
         border-radius: 50%;
         padding: 6px;
         width: 40px;
         height:40px;
         display: flex;
         justify-content: center;
         align-items: center;">
      <?php if($checkWishList == false): ?>
      <i class="fal fa-heart" style="color:#35373b !important;font-size:20px;"></i>
      <?php else: ?>
      <i class="fa fa-heart" style="color:#35373b !important;font-size:20px;" aria-hidden="true"></i>
      <?php endif; ?>
      </div>
      <?php endif; ?>
      <!-- <a href="javascript:void(0);"  class="us_grid_shared" onclick="openShareModal(this)" 
         data-url="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id])); ?>"
         style="background: transparent;
         position: absolute;
         right: 10px;
         bottom: 5%;
         z-index: 999;
         border: none;
         color: #1b87f4;
         font-size: 25px;" ><i class="fa fa-share-alt" aria-hidden="true"></i>
         </a> -->
      </figure>
      <div class="product-details pt-2 px-2" style="cursor:pointer;"   >
      <span class="product-category font-xsm" onclick="window.location='<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->category_id), 'slug' => $car_content->slug, 'id' => $car_content->id])); ?>'">
      <h5 class="product-title ">
      <a href="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car_content->id])); ?>"
         title="<?php echo e(optional($car_content)->title); ?>" class="us_grid_width">
      <?php echo e(carBrand($car_content->brand_id)); ?>

      <?php echo e(carModel($car_content->car_model_id)); ?> <?php echo e(optional($car_content)->title); ?>

      </a>
      </h5>
      </span>
      <div class="author us_child_dv" style="cursor:pointer; height: 41px;" onclick="window.location='<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->category_id), 'slug' => $car_content->slug, 'id' => $car_content->id])); ?>'" >
      <span style="line-height: 15px;font-size: 14px;">
      <?php if($car_content->year): ?>
      <?php echo e($car_content->year); ?> 
      <?php endif; ?>
      <?php if($car_content->engineCapacity && $car_content->car_content->fuel_type ): ?>
      <b class="us_dot"> . </b>   <?php echo e(roundEngineDisplacement($car_content)); ?> 
      <?php endif; ?>
      <?php if($car_content->car_content->fuel_type ): ?>
      <b class="us_dot"> . </b>   <?php echo e($car_content->car_content->fuel_type->name); ?> 
      <?php endif; ?>
      <?php if($car_content->mileage): ?>
      <b class="us_dot"> . </b>    <?php echo e(number_format( $car_content->mileage )); ?> mi 
      <?php endif; ?>
      <?php if($car_content->created_at && $car_content->is_featured != 1): ?>
      <b class="us_dot"> . </b> <?php echo e(calculate_datetime($car_content->created_at)); ?> 
      <?php endif; ?>
      <?php if($car_content->city): ?>
      <b class="us_dot"> . </b> <?php echo e(Ucfirst($car_content->city)); ?> 
      <?php endif; ?>
      </span>
      </div>
      <?php if(!$car_content->year && !$car_content->mileage && !$car_content->engineCapacity): ?>
      <div style="display:flex;padding-top: 5px;">
      <?php if($car_content->manager_special  == 1): ?>
      <div class="price-tag" style="padding: 3px 10px;border-radius:5px; background:#25d366;font-size: 10px;" > Manage Special</div>
      <?php endif; ?>
      <!-- <?php if($car_content->is_sale == 1): ?>
         <div class="price-tag" style="padding: 3px 10px;border-radius:5px;margin-left: 10px;background: #434d89;font-size: 10px;" > 
            Sale </span></div>
         
         <?php endif; ?> -->
      <?php if($car_content->reduce_price == 1): ?>
      <div class="price-tag" style="padding: 3px 10px;border-radius:5px;margin-left: 10px;background:#ff4444;font-size: 10px;" >    Reduced </span></div>
      <?php endif; ?>
      </div>
      <?php endif; ?> 
      <!-- <ul class="product-icon-list  list-unstyled d-flex align-items-center us_absolute_position" style="margin-top: 10px;"  onclick="window.location='<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car_content->category_id), 'slug' => $car_content->slug, 'id' => $car_content->id])); ?>'"  >
         <?php if($car_content->price != null): ?>
         <li class="icon-start us_price_icon" data-tooltip="tooltip" data-bs-placement="top"
         title="Price">
         <b style="color: gray;float: left;">Price</b>
         
         <strong  class="us_mrg" style="color: black;font-size: 20px;">
         <?php if($car_content->previous_price && $car_content->previous_price < $car_content->price): ?>
         <strike style="font-weight: 300;color: red;font-size: 14px;float: left;" class="us_mr_15"><?php echo e(symbolPrice($car_content->price)); ?></strike> 
         
         <div> <?php echo e(symbolPrice($car_content->previous_price)); ?></div>
         <?php else: ?>
         <strike style="font-weight: 300;color: white;font-size: 14px;    float: left;">  </strike> <div>  <?php echo e(symbolPrice($car_content->price)); ?>  </div> 
         <?php endif; ?>
         </strong>
         </li>
         <?php endif; ?>
         
         <?php if($car_content->price != null && $car_content->price >= 1000): ?>
         <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
         title="">
         <b style="color: gray;">From</b>
         
         <strong style="color: black;font-size: 20px;">
         
         <?php echo calulcateloanamount(!empty($car_content->previous_price && $car_content->previous_price < $car_content->price) ? $car_content->previous_price : $car_content->price)[0]; ?>

         
         </strong>
         </li>
         <?php endif; ?>
         </ul> -->
      <div class="d-flex paddingTop pt-0 pt-xl-5 justify-content-start align-items-end gap-3 ">
      <?php if($car_content->price != null): ?>
      <div class="icon-start us_price_icon " data-tooltip="tooltip" data-bs-placement="top"
         title="Price">
      <strong  class="us_mrg grid_card_price" style="color: black;">
      <?php if($car_content->previous_price && $car_content->previous_price < $car_content->price): ?>
      <strike style="font-weight: 700;color: red;font-size: 14px;padding-top:16px;float: left;" class="us_mr_15"><?php echo e(symbolPrice($car_content->price)); ?></strike> 
      <div  class="grid_card_price"> <?php echo e(symbolPrice($car_content->previous_price)); ?></div>
      <?php else: ?>
      <strike style="font-weight: 300;color: white;font-size: 14px;    float: left;">  </strike> 
      <div class="grid_card_price">  <?php echo e(symbolPrice($car_content->price)); ?>  </div> 
      <?php endif; ?>
      </strong>
      </div>
      <?php endif; ?>
      <?php if($car_content->price != null && $car_content->price >= 1000): ?>
      <li class="icon-start pb-1" data-tooltip="tooltip" data-bs-placement="top"
         title="" style="list-style: none;">
      <b style="color: #000000;font-size:14px; font-weight: 300px;">From</b>
      <strong style="color: black;font-size: 14px; font-weight: 300px;">
      £<?php echo calulcateloanamount(!empty($car_content->previous_price && $car_content->previous_price < $car_content->price) ? $car_content->previous_price : $car_content->price)[0]; ?>

      </strong>
      </li>
      <?php endif; ?>
      </div> 
      </div>
      <?php if($car_content->is_sold == 1 ): ?>
      <div style="position: absolute; top:0px; width: 100%; z-index: -1px; height: 100%; background: rgba(0,0,0,0.3)"></div>
      <img src="assets/img/Sold.png"  alt="sold out" style="position: absolute;  left:0px; right:0px; width: 45%; z-index: 1px; top:30%;" class="mx-auto" ></img>
      <?php endif; ?>
      </div>
      <?php if($car_content->is_sale == 1): ?>
      <img src="assets/img/saletag.svg" width="120px" style="<?php echo e($car_content->is_sold == 1 ? 'display: none !important;' : 'position: absolute; width: 60px; 
      top:0px; right:5px;'); ?>

      " alt="sale"></img>
      
      
      <?php endif; ?>
      </div>
      <!-- product-default     £-->
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <!-- <div class="pagination us_pagination_default mb-40 justify-content-center " data-aos="fade-up">
         <?php echo e($car_contents->links()); ?>

         </div> -->
      <!-- Limited Pagination -->
      <div class="pagination us_pagination_filtered mb-40 mt-20 justify-content-center" id="pagination">
      <?php if($car_contents->lastPage() > 1): ?>
      <ul class="pagination">
      <?php if($car_contents->currentPage() > 1): ?>
      <li class="page-item">
      <a class="page-link" href="<?php echo e($car_contents->url(1)); ?>" aria-label="Previous">
      <span aria-hidden="true">&laquo;</span>
      </a>
      </li>
      <?php endif; ?>
      <?php
      $halfVisiblePages = 2; // Maximum of 5 visible pages (2 before and 2 after current page)
      $start = max(1, $car_contents->currentPage() - $halfVisiblePages);
      $end = min($car_contents->lastPage(), $car_contents->currentPage() + $halfVisiblePages);
      ?>
      <?php for($page = $start; $page <= $end; $page++): ?>
      <li class="page-item <?php echo e($car_contents->currentPage() == $page ? 'active' : ''); ?>">
      <a class="page-link" href="<?php echo e($car_contents->url($page)); ?>"><?php echo e($page); ?></a>
      </li>
      <?php endfor; ?>
      <?php if($car_contents->currentPage() < $car_contents->lastPage()): ?>
      <li class="page-item">
      <a class="page-link" href="<?php echo e($car_contents->url($car_contents->currentPage() + 1)); ?>" aria-label="Next">
      <span aria-hidden="true">&raquo;</span>
      </a>
      </li>
      <?php endif; ?>
      </ul>
      <?php endif; ?>
      </div>
      </div>
      <?php endif; ?> </div>
      <?php if(!empty(showAd(3))): ?>
      <div class="text-center mt-4 mb-40">
      <?php echo showAd(3); ?>

      </div>
      <?php endif; ?>
      </div>
   </div>
</div>

    <!-- featured section start -->
    <?php if( !empty($getFeaturedVendors->cars)): ?>
    <section class="product-area pt-30 pb-30" 
    style="background: rgb(0, 19, 52);margin:0px;border-bottom:4px solid rgb(221, 64, 69);display:none;box-shadow: 0px 0px 0px;border-radius: 0px;" id="carFeature">
      <div class="container">
        <div class="row">
          <div class="col-12" >
            <div class="section-title title-inline mb-10" >
              <h2 class="feater-dealer-title">
                Featured Car Dealer
              </h2>
             
            </div>
          </div> 
        
          <?php $__currentLoopData = $getFeaturedVendors->cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featureads): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php
            
            $image_path = $featureads->feature_image;
            
            $rotation = 0;
            
            if($featureads->rotation_point > 0 )
            {
                 $rotation = $featureads->rotation_point;
            }
            
            if(!empty($image_path) && $featureads->rotation_point == 0 )
            {   
               $rotation = $featureads->galleries->where('image' , $image_path)->first();
               
               if($rotation == true)
               {
                    $rotation = $rotation->rotation_point;  
               }
               else
               {
                    $rotation = 0;   
               }
            }
            
            if(empty($featureads->feature_image))
            {
                $imng = $featureads->galleries->sortBy('priority')->first();
                
                $image_path = $imng->image;
                $rotation = $imng->rotation_point;
            } 
           
           
            ?>
            
            
            <div class="col-12 col-md-2 dealer-product-card" >

              <div class="product-default p-15 set_heigh" style="padding: 0px !important;box-shadow: 0px 0px 0px;border-radius: 4px;margin:-6px;" data-id="<?php echo e($featureads->id); ?>">
                <figure class="product-img">
                  <a href="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($featureads->car_content->category_id),'slug' => $featureads->car_content->slug, 'id' => $featureads->id])); ?>"
                     class="lazy-container ratio ratio-2-3">
                    <img class="lazyload"
                         data-src="<?php echo e($featureads->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path); ?>"
                         alt="<?php echo e(optional($featureads)->title); ?>" style="transform: rotate(<?php echo e($rotation); ?>deg);" >
                  </a>

                </figure>
            
                  <div class="product-details" style="padding: 7px !important;padding-left: 15px !important;">
                
                    <span class="product-category font-xsm">
                        
                        <h5 class="product-title custom-product-title mb-0" style="overflow: hidden;text-overflow: ellipsis;vertical-align: top;">
                            <a href="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($featureads->car_content->category_id),'slug' => $featureads->car_content->slug, 'id' => $featureads->id])); ?>"
                            title="<?php echo e(optional($featureads)->title); ?>">
                            <?php echo e(carBrand($featureads->car_content->brand_id)); ?>

                            <?php echo e(carModel($featureads->car_content->car_model_id)); ?> <?php echo e(optional($featureads->car_content)->title); ?>

                        </a>
                        </h5>
                      
                    </span>
                    
                    <div class="d-flex align-items-center justify-content-between ">
                   
                      <?php if(Auth::guard('vendor')->check()): ?>
                        <?php
                          $user_id = Auth::guard('vendor')->user()->id;
                          $checkWishList = checkWishList($featureads->id, $user_id);
                        ?>
                      <?php else: ?>
                        <?php
                          $checkWishList = false;
                        ?>
                      <?php endif; ?>
                      
                        <!-- <a href="javascript:void(0);"
                        onclick="addToWishlist(<?php echo e($featureads->id); ?>)"
                        class="btn us_wishlist btn-icon "
                        data-tooltip="tooltip" data-bs-placement="right"
                        title="<?php echo e($checkWishList == false ? __('Save Ad') : __('Saved')); ?>" style="position: absolute;
                        right: 0px;
                        bottom: 10px;
                        background:white;
                        color:red !important;
                        z-index: 10;
                        border: none;
                        color: white;
                        font-size: 25px;">
                        <?php if($checkWishList == false): ?>
                            <i class="fal fa-heart"></i>
                        <?php else: ?>
                            <i class="fa fa-heart" aria-hidden="true"></i>
                        <?php endif; ?>
                      </a> -->
                     
                      <!-- <a href="javascript:void(0);"  class="us_grid_shared" onclick="openShareModal(this)" 
                        data-url="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($featureads->car_content->category_id),'slug' => $featureads->car_content->slug, 'id' => $featureads->id])); ?>"
                        style="background: transparent;
                        position: absolute;
                        right: 60px;
                        bottom: 5px;
                        z-index: 999;
                        border: none;
                        color: #1b87f4;
                        font-size: 25px;" ><i class="fa fa-share-alt" aria-hidden="true"></i>
                        </a> -->
                        
                       
                    </div>
                    
                    
                    
                    
                                        
                    <ul class="product-icon-list custom-product-icon list-unstyled d-flex align-items-center pt-2"  style="position:relative;">
                      <?php if($featureads->price != null): ?>
                          <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                            title="Price">
                              <b style="color: gray;font-weight:100;">Price</b>
                              <br>
                              <strong  class="us_mr" style="color: black;font-size: 18px;font-weight:600;    margin-left: 0;">
                                    <?php if($featureads->previous_price && $featureads->previous_price < $featureads->price): ?>
                                    <strike style="font-weight: 300;color: red;font-size: 14px;    float: left;"><?php echo e(symbolPrice($featureads->price)); ?></strike> 
                                    
                                    <div style="color:black;"> 
                                        <?php echo e(symbolPrice($featureads->previous_price)); ?>

                                    </div>
                                    <?php else: ?>
                                        <?php echo e(symbolPrice($featureads->price)); ?>   
                                    <?php endif; ?>
                            </strong>
                          </li>
                      <?php endif; ?>
                      
                       <?php if($featureads->price != null && $featureads->price >= 1000): ?>
                        <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top" title="">
                          <strong style="color: black;font-size: 18px;font-weight:600">
                              <?php
                                  // Get the loan amount output from the function and clean it up
                                  $loanAmountOutput = calulcateloanamount(!empty($featureads->previous_price && $featureads->previous_price < $featureads->price) ? $featureads->previous_price : $featureads->price)[0];

                                  // Strip any HTML tags in case there are span tags in the function output
                                  $loanAmountOutputClean = strip_tags($loanAmountOutput);

                                  // Use a regular expression to separate the numeric part and the dynamic text (like p/m or p/w)
                                  preg_match('/(\d+)(\D+)/', $loanAmountOutputClean, $matches);

                                  // Ensure we have both parts; default to empty strings if not
                                  $loanAmount = $matches[1] ?? '';
                                  $loanPeriod = $matches[2] ?? '';
                              ?>
                              <b style="color: gray;font-size:14px;font-weight:100">From</b><br>
                              <?php echo e($loanAmount); ?>

                              <span style="font-size: 10px; color: black;font-weight:100;"><?php echo e($loanPeriod); ?></span>
                          </strong>
                        </li>

                      <?php endif; ?>
                      
                    </ul>
                  </div>
              </div>
            </div>
              
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            
              <div class="col-12 col-md-4 custom-dealer-detail" data-aos="">
                 
                <div class="mt-3" style="color:rgb(219, 223, 230);">
                  <h4 style="color:white;font-size: 24px;font-weight:100;margin-bottom:0px;"><?php echo e($getFeaturedVendors->vendor_info->name); ?></h4>
                    <span style="display: flex;margin-bottom: 3px;font-size:14px;"> 
                      <div>
                        <?php echo e(($getFeaturedVendors->is_franchise_dealer == 1) ? 'Franchise' : 'Independent'); ?> Dealer
                      </div>  <b style="margin: 0px 5px;"> . </b> 
                      <div>Total stock: <?php echo e($getFeaturedVendors->cars_count); ?> Ads</div>
                    
                    </span>
                 
                 <a href="<?php echo e(route('frontend.vendor.details', ['id' => $getFeaturedVendors->id ,  'username' => ( $getFeaturedVendors->username)])); ?>" style="color: rgb(219, 223, 230);text-decoration: underline;font-size:14px;">See Showroom</a>
                 
                  <div style="width: 65px;
                    padding: 2px;
                    background: rgb(229, 105, 16);
                    border-radius: 3px;
                    font-size:12px;
                    color: (255, 255, 255);
                    /* font-weight: 700; */
                    margin-top: 0.5rem;">FEATURED</div>
                 
                  <br>
                 
                 
                   <?php
                    $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $getFeaturedVendors->photo;
                    
                    if (file_exists(public_path('assets/admin/img/vendor-photo/' . $getFeaturedVendors->photo))) 
                    {
                    
                        $photoUrl = asset('assets/admin/img/vendor-photo/' . $getFeaturedVendors->photo);
                    }
                    ?>
                    
                    
                  <img 
                    style="border-radius: 1%; width: 160px;height:80px;margin-top:-12px;" 
                    class="lazyload blur-up"
                    src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>"
                    data-src="<?php echo e($photoUrl); ?>"  
                    alt="Vendor" 
                    onload="handleImageLoad(this)"
                    onerror="<?php echo e(asset('assets/img/blank-user.jpg')); ?>" >
                 
                </div>
                    
              </div>
         
        </div>
      </div>
    </section>
  <?php endif; ?>
  <!-- featured section end -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
   'use strict';
   
   const baseURL = "<?php echo e(url('/')); ?>";
   
   setTimeout(function() {
        $('.skeleton').hide(); // Hide skeletons
      //   $('.loading-section').fadeIn()
        $('.loading-section').removeClass('loading-section');
        
    }, 1000);
    function openPopModal(self , price)
   {
       var type = 'Monthly Price';
      var text =  $(self).data("text")
       if(price < 5000)
       {
           var type = 'Weekly Price';
       }
       $('#textHTML').html('<br>'+text)
       $('#financeModal').modal('show')
   }

   if (sessionStorage.getItem('tabCategory')) {
    
    if (sessionStorage.getItem('tabCategory') == 'all'){
        updateUrl(1,'all');
        // updateUrl(1);
    }else{
        updateUrl(1,sessionStorage.getItem('tabCategory'));
    }
    
  }else{
    updateUrl(1,'cars-&-motors');
  }
   
   
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("frontend.layouts.layout-v$version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/car/cars_grid.blade.php ENDPATH**/ ?>