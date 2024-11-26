    <?php
      $version = $basicInfo->theme_version;
    ?>
    
    <?php $__env->startSection('pageHeading'); ?>
      <?php echo e(__('Detail')); ?>

    <?php $__env->stopSection(); ?>
    
    <?php $__env->startSection('metaKeywords'); ?>
      <?php if($car->car_content): ?>
        <?php echo e($car->car_content->meta_keyword); ?>

      <?php endif; ?>
    
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('metatags'); ?>
    <meta property="og:title" content="<?php echo e(strlen(@$car->car_content->title) > 40 ? substr(@$car->car_content->title, 0, 40) . '...' : @$car->car_content->title); ?>">
    <meta property="og:description" content="<?php echo e(strlen(@$car->car_content->title) > 40 ? substr(@$car->car_content->title, 0, 40) . '...' : @$car->car_content->title); ?>">
    <meta property="og:image" content="<?php echo e($car->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' . $car->feature_image) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' .  $car->feature_image); ?>"> 
    <?php $__env->stopSection(); ?>
    
    <?php $__env->startSection('metaDescription'); ?>
      <?php if($car->car_content): ?>
        <?php echo e($car->car_content->meta_description); ?>

      <?php endif; ?>
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('content'); ?>
    
    
    <div class="page-title-area ptb-40 bg-img <?php echo e($basicInfo->theme_version == 2 || $basicInfo->theme_version == 3 ? 'has_header_2' : ''); ?>" 
    style="background-color:#FAFAFA; box-shadow:rgba(51, 51, 51, 0.24) 0px 1px 4px" >
        
    <div class="container">
      <div class="content">
        <ul class="list-unstyled pb-2">
          <li class="d-inline"><a href="<?php echo e(route('index')); ?>"><?php echo e(__('Home')); ?></a></li>
          <li class="d-inline">></li>
          <li class="d-inline active opacity-75"><?php echo e(@$car->car_content->category->name); ?></li>
        </ul>
        <h2>
          <?php echo e($car->car_content->title); ?>

        </h2>
      </div>
    </div>
    
    </div>
 
    <?php
    $car_ids = $car->id;
    $review_data = null;
    
    ?>
    <?php if($car->vendor->google_review_id > 0 ): ?>
    <?php
    $review_data = get_vendor_review_from_google($car->vendor->google_review_id , true);
    ?>
    <?php endif; ?>
    <style>
      body{
        background-color: rgb(34, 40, 49,.02) !important; 
      }
      .card{
      background-color: #ffffff !important;
      background-color: #ffffff;
      border: 1px solid #ffffff !important;
      }
      .card, .card-light {
    border-radius: 5px;
    margin-bottom: 30px;
    -webkit-box-shadow: none !important;
    -moz-box-shadow: none !important;
    box-shadow: none !important;
    background-color: #ffffff;
    border: 1px solid #ffffff !important;
}
        .over-flow-fade{
          position: absolute; 
          height: 25px; 
          width:100%; 
          bottom: 0px;
          background: linear-gradient(rgb(255, 255, 255) 0%, rgba(255, 255, 255, 0) 0.01%, rgb(255, 255, 255) 90%);
        }
        .partial-description {
            overflow: hidden;
            height:auto; 
            padding-Bottom: 6px;
            line-height: 14px; 
            transition: height 0.5s ease; 
        }
        .partial-description-min-height {
            overflow: hidden;
            height:60px; 
            line-height: 14px;
            transition: height 0.5s ease; 
        }


      .NotifyFont{
        font-size: 18px;
      }
      .Notify-font-right{
        font-size: 20px;
      }
      .offsetCol{
           position: absolute;bottom: 10px; right: 0px;
         }
          .us_mrg {
        margin: 0px;
        margin-left: 0px !important;
    }
    
    .product-icon-list li:not(:last-child) {
    -webkit-padding-end: 15px;
    padding-inline-end: 15px;
    -webkit-margin-end: 15px;
    margin-inline-end: 15px;
    border-inline-end: none !important;
}
    select.form-control 
    {
        appearance: auto;
        -webkit-appearance: auto;
        -moz-appearance: auto;
        padding-right: 2rem; 
        background: white url('data:image/svg+xml;base64,...') no-repeat right center; 
        background-size: 1rem;
    }

    @media only screen and (min-width: 991px) and (max-width: 1199px) 
    {
        #card_body 
        {
            <?php if($car->vendor->vendor_type == 'dealer'): ?>
             height: 550px;
            <?php else: ?>
            height: 480px;
            <?php endif; ?>
        }
    }
    
    @media only screen and (min-width: 1200px) and (max-width: 1399px) 
    {
         #card_body 
        {
             <?php if($car->vendor->vendor_type == 'dealer'): ?>
             height: 670px;
            <?php else: ?>
            height: 560px;
            <?php endif; ?>
        }
    }
    
     @media only screen and (min-width: 1400px) 
    {
        #card_body
        {
               <?php if($car->vendor->vendor_type == 'dealer'): ?>
             height: 720px;
            <?php else: ?>
            height: 650px;
            <?php endif; ?>
        }
    }
    
    
    @media screen and (max-width: 375px) 
    {
   
      .offsetCol{
           position: absolute;bottom: 10px; right: 0px;
         }
        }

     @media screen and (max-width: 450px) 
    {
   
      .offsetCol{
           position: absolute;bottom: 10px; right: 0px;
         }
     .sticky-button 
     {
         <?php if($car->phone_text == 1 && $car->vendor->also_whatsapp == 1): ?>  
         width:25% !important ;
         <?php else: ?>
         width:43% !important ;
         <?php endif; ?>
    } 
    
      <?php if($car->phone_text == 1 && $car->vendor->also_whatsapp == 1): ?>  
     
    .original_text
    {
        display:none !important;
    }
    
    .mobile_icon
    {
        display:block !important;
    }
    
    .us_wat_btn
    {
        z-index: 10;
        bottom:2px !important;
         margin-right:7rem;
    }
    
    .us_button_st
    {
        margin-right: 14rem !important;
    }
    
    <?php endif; ?>
}

        @media screen and (max-width: 768px) 
        {
            .us_socail_links 
            {
                display:none !important; 
            }
        }
        
        .btn-icon:hover
        {
            background:none;
        }
        
        
        #shareModal .modal-content {
         
            width: 100% !important;
        }

        /* Ensure the modal backdrop covers everything */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            z-index: 1040; /* Set a high z-index */
        }
        
        /* Modal container */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Fixed position */
            z-index: 1050; /* Set a higher z-index than the backdrop */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4); /* Semi-transparent background */
            transition: opacity 0.3s ease;
            opacity: 0; /* Start with the modal invisible */
        }
        
        /* Modal content */
        .modal-content {
            background-color: white;
            margin: 15% auto;
           
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }
        
        
        
        /* Close button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        
        /* Show the modal with fading effect */
        .modal.show {
            display: block;
            opacity: 1; /* Fully opaque when shown */
        }
        
        @media screen and (min-width: 580px) 
        {
           .us_parent_cls
            {
                display:flex;
            }
        }
        
        /* .partial-description {
            overflow: hidden;
            max-height:180px; 
            transition: max-height 0.5s ease; Smooth transition effect
        } */
        
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
        
            @media screen and (max-width: 777px) 
            {
                
                /* .partial-description {
                
                max-height:170px !important; 
                
                } */
        
                  .us_mrn
                  {
                     margin-top: 2rem;
                  }
                  
                  .author.align-items-start .image
                  {
                     display:none; 
                  }
            } 
</style>


  <!-- Listing-single-area start -->
  <div class="listing-single-area pt-40 pb-60">
    <div class="container">
      <?php
        $admin = App\Models\Admin::first();
        $car_id = $car->id;
        $carid = $car->id; 
        $ctitle = $car->car_content->title;
      ?>
      <?php if($car->vendor_id != 0): ?>
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <form action="<?php echo e(route('vendor.support_ticket.store')); ?>" enctype="multipart/form-data" method="POST">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo e($car->vendor->vendor_info->name); ?></h5>
        <input type="hidden" value="<?php echo e($carid); ?>" name="car_id">
        <input type="hidden" value="<?php echo e($ctitle); ?>" name="subject">
        <input type="hidden" value="<?php echo e($car->vendor_id); ?>" name="admin_id">
        <?php echo csrf_field(); ?>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
           
            <div class="user mb-20">
               <div class="row">
              <div class="col-2">
                  <div class="user-img" style="max-width: 80px">
                    <div class="lazy-container ratio ratio-1-1 rounded-pill">
                      <?php if($car->vendor->photo != null): ?>
                       
                        
                    <?php
                        $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $car->vendor->photo;
                        
                        if (file_exists(public_path('assets/admin/img/vendor-photo/' . $car->vendor->photo))) {
                        
                            $photoUrl = asset('assets/admin/img/vendor-photo/' . $car->vendor->photo);
                        }
                        
                        if(empty($car->vendor->photo))
                        {
                              $photoUrl = asset('assets/img/blank-user.jpg');
                        }
                    ?>
                    
                    <img 
                    class="lazyload "
                    src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>"
                    data-src="<?php echo e($photoUrl); ?>"  
                    alt="Vendor" 
                     
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
                      <a href="<?php echo e(route('frontend.vendor.details', ['id' => $car->vendor->id , 'username' => $car->vendor->username])); ?>"
                        title="<?php echo e($car->vendor->username); ?>"><?php echo e($car->vendor->vendor_info->name); ?></a>
                    </h6>
                    
                    <?php if($car->vendor->vendor_type == 'normal'): ?>
                    <?php if($car->vendor->trader==0): ?>
                        <p><?php echo e(Ucfirst(@$car->vendor->vendor_info->city)); ?> <?php if(!empty($car->vendor->vendor_info->city)): ?> . <?php endif; ?>  Private Seller, </p>
                    <?php else: ?>
                        <p><?php echo e(Ucfirst(@$car->vendor->vendor_info->city)); ?> <?php if(!empty($car->vendor->vendor_info->city)): ?> . <?php endif; ?>  Trader, </p>
                    <?php endif; ?>
                    <?php else: ?>
                        <p>Send an email to the dealer</p>
                    <?php endif; ?>
                    
                    <?php if(!empty($review_data) && $review_data['total_reviews'] > 0 && $review_data['total_ratings'] > 0): ?>
                    <div class="rating-container">
                    <?php echo $review_data['rating_stars']; ?> . <?php echo e($review_data['total_ratings']); ?>/5
                    </div>
                    
                    <div>  <a  target="_blank" style="color: #ee2c7b;" href="https://www.google.com/maps?q=<?php echo e(str_replace(' ' , '+' , $car->vendor->vendor_info->name)); ?>"> <?php echo e(number_format($review_data['total_reviews'] )); ?> google reviews </a> </div>
                    <?php endif; ?>
                        
                  </div>
            </div>

            </div>
            
            <?php if($car->vendor->vendor_type == 'dealer' && Auth::guard('vendor')->check()): ?>
              <div class="row">
                <div class="col-12 mb-3">  
                    <label style="font-size: 15px;">Your full name</label>
                    <input type="text" name="full_name" class="form-control mt-1" required value="<?php echo e(Auth::guard('vendor')->user()->vendor_info->name); ?>"/>
                </div>
                
                <div class="col-12 mb-3">  
                    <label style="font-size: 15px;" >Your phone number</label>
                    <input type="text" name="phone_no" class="form-control mt-1"  required  value="<?php echo e(Auth::guard('vendor')->user()->phone); ?>"/>
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
            <textarea id="en_description" class="form-control mt-1" name="description" data-height="200">Hi, is this still available? Is the price negotiable?
Thanks</textarea>
            </div>
          </div> </div> 
      </div>
      <div class="modal-footer justify-content-between">
        
        <button type="submit" value="Submit" class="btn btn-primary">Send </button>
      </div>
    </div>
  </form>
  </div>
</div>
 <?php endif; ?>
 
 
      <div class="row gx-xl-5">
        <div class="col-lg-8">
			
			<div class="card">
				<div class="card-body" id="card_body" style="    padding: 0;">
				    
				    
                    <div class="col-md-12 us_card_parent" style="">
                        
    
                     
                 <?php if($car->vendor_id != 0 && $car->vendor->vendor_type == 'dealer'): ?>  
                 
                    <div id="numberSlides" style="float: right;font-family: monospace;position: relative;top: 65px;">
                            0/0 <i class="fa fa-camera" aria-hidden="true"></i>
                        </div>
                        
                        <div class="author mb-15 us_parent_cls" >
                        
                            <a style="display:flex;" class="color-medium"
                            href="<?php echo e(route('frontend.vendor.details', ['id' => $car->vendor->id , 'username' => ($vendor = @$car->vendor->username)])); ?>"
                            target="_self" title="<?php echo e($vendor = @$car->vendor->username); ?>">
                            <?php if($car->vendor->photo != null): ?>
                             
                            <?php
                            $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $car->vendor->photo;
                            
                            if (file_exists(public_path('assets/admin/img/vendor-photo/' . $car->vendor->photo))) 
                            {
                                $photoUrl = asset('assets/admin/img/vendor-photo/' . $car->vendor->photo);
                            }
                            
                            if(empty($car->vendor->photo))
                            {
                                $photoUrl = asset('assets/img/blank-user.jpg');
                            }
                        
                            ?>
                            
                            <img 
                            style="border-radius: 10%; max-width: 80px;height:80px;"
                            class="lazyload blur-up"
                            src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>"
                            data-src="<?php echo e($photoUrl); ?>"  
                            alt="Vendor" 
                             
                            onerror="<?php echo e(asset('assets/img/blank-user.jpg')); ?>" >

                            <?php else: ?>
                            <img style="border-radius: 10%;max-width: 80px;" class="lazyload blur-up" data-src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>"
                            alt="Image">
                            <?php endif; ?>
                            <span style="    margin-left: 1rem;">
                             
                            <strong class="us_font_15" style="color: black;font-size: 20px;"><?php echo e($car->vendor->vendor_info->name); ?> <?php if(!empty($car->vendor->est_year)): ?> <b>.</b> <span style="font-size: 15px;font-weight: normal;color: gray;">Est <?php echo e($car->vendor->est_year); ?></span> <?php endif; ?></strong>
                            
                            <?php if($car->vendor->is_franchise_dealer == 1): ?>
                            
                                <?php
                                
                                $review_data = null;
                                
                                ?>
                            
                                <?php if($car->vendor->google_review_id > 0 ): ?>
                                    <?php
                                
                                        $review_data = get_vendor_review_from_google($car->vendor->google_review_id , true);
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
                        
                        <?php if($car->vendor->is_trusted == 1): ?>
                           <div class="">  <span style="background: #0fbd0f;color: white;padding: 1px 10px;border-radius: 20px;font-size: 12px;"><i class="fa fa-check" aria-hidden="true"></i> Trusted Dealer </span></div>
                        <?php endif; ?>
                        
                        <?php else: ?>
                        
                        <div>Independent Dealer</div> 
                            <?php endif; ?>
                            </span>
                            </a>
                        </div>
                        <?php else: ?>
                        
                        <div id="numberSlides" style="text-align: right;margin-bottom: 1rem;font-family: monospace;">
                            0/0 <i class="fa fa-camera" aria-hidden="true"></i>
                        </div>
                        <?php endif; ?>
                    </div>
                  
                    <?php if($car->is_featured == 1): ?>
                            <div class="sale-tag" style="border-radius:0px;background:#ff9e02;">Spotlight</div>
                    <?php endif; ?>
                  					
					<div class="product-single-gallery mb-40"<?php if($car->is_featured == 1): ?>  style="border-top: 5px solid #ff9e02;"  <?php endif; ?>>
					
						<div class="swiper product-single-slider">
						    
						  <div class="swiper-wrapper" >
						   
						      
						      
                            <?php
                            $sortedGalleries = $car->galleries->sortBy('priority');
                            ?>
                            <?php $__currentLoopData = $sortedGalleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         
                          
                            
                            
						      <?php if(!empty($car->youtube_video) && $key == 1): ?>
						      <div class="swiper-slide" >
								<figure class="lazy-container ratio ratio-5-3">
								  
								         <iframe width="560" height="315" src="<?php echo e(youtube_embed_link($car->youtube_video)); ?>" frameborder="0" allowfullscreen></iframe>

								</figure>
							  </div>
							  <?php else: ?>
							      <div class="swiper-slide">
                            <figure class="lazy-container ratio ratio-5-3">
                                <?php if($car->is_sold == 1 || $car->status == 2 ): ?>
                                    <div class="sold-badge">
                                        <span class="sold-text">Sold</span>
                                        <span class="sold-text">Sold</span>
                                        <span class="sold-text">Sold</span>
                                    </div>
                                <?php endif; ?>
                            
                              <a href="<?php echo e($car->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' . $gallery->image) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' .  $gallery->image); ?>" class="lightbox-single">
                                  
                            	<img class="lazyload us_imgs_carosals" data-src="<?php echo e($car->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' . $gallery->image) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' .  $gallery->image); ?>"
                            	  alt="product image" style="transform: rotate(<?php echo e($gallery->rotation_point); ?>deg);"   onerror="this.onerror=null;this.src='<?php echo e(asset('assets/img/Image_not_available.png')); ?>';"  />
                              </a>
                            </figure>
                            </div>
						      <?php endif; ?>
						      
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							
					
        
						  </div>
						  
						  		
                        <div class="slider-navigation">
                            <button type="button" title="Slide prev" class="slider-btn slider-btn-prev radius-0">
                                <i class="fal fa-angle-left"></i>
                            </button>
                            <button type="button" title="Slide next" class="slider-btn slider-btn-next radius-0">
                                <i class="fal fa-angle-right"></i>
                            </button>
                        </div>

        
        
						</div>

						<div class="product-thumb">
						  <div class="swiper slider-thumbnails">
							<div class="swiper-wrapper">
    							  <?php $__currentLoopData = $sortedGalleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        							  
            								<div class="swiper-slide">
            								  <div class="thumbnail-img lazy-container ratio ratio-5-3">
            									<img class="lazyload " data-src="<?php echo e($car->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' . $gallery->image) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' .  $gallery->image); ?>"
            									  alt="product image"  style="transform: rotate(<?php echo e($gallery->rotation_point); ?>deg);"  onerror="this.onerror=null;this.src='<?php echo e(asset('assets/img/Image_not_available.png')); ?>';"  />
            								  </div>
            								</div>
        						
    							  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						  </div>
						 
						
						</div>
					  </div>
					  
				</div>
			</div>
			
          
		  
          <div class="product-single-details">
			
			<div class="card">
				<div class="card-body">
					<div class="row">
					  <div class="col-md-8">
						<h5 class="product-title mb-0"><?php echo e(@$car->car_content->title); ?></h5>
						<ul class="dotted-inlinelist list-inline mb-3">
							<li class="list-inline-item">
								<a href="<?php echo e(route('frontend.cars', ['category' => @$car->car_content->category->slug])); ?>" class="small text-secondary"><?php echo e(@$car->car_content->category->name); ?></a>
                <li class="list-inline-item">
								<span class="small text-secondary">
								 - <?php echo e($car->visitors()->get()->count()); ?> Views
								</span>
							</li>
                <li class="list-inline-item">
                  <span class="small text-secondary">
                   - 	<?php echo e(calculate_datetime($car->created_at)); ?>

                  </span>
                </li>
							</li>
							
							 
						</ul>
						
                        <?php if($car->is_sold == 0): ?>
                        
                            <div style="display:flex;margin-top: 1rem;">
                            
                                <?php if($car->manager_special  == 1): ?>
                                <div class="price-tag" style="padding: 3px 10px;border-radius:5px; background:#25d366;font-size: 9px;margin-bottom:15px;" > Manage Special</div>
                                <?php endif; ?>
                            
                                <?php if($car->is_sale == 1): ?>
                                <div class="price-tag" style="padding: 3px 10px;border-radius:5px;margin-left: 7px;background: #434d89;font-size: 9px;margin-bottom:15px;" >  Sale </span></div>
                                <?php endif; ?>
                                
                                <?php if($car->reduce_price == 1): ?>
                                <div class="price-tag" style="padding: 3px 10px;border-radius:5px;margin-left: 7px;background:#ff4444;font-size: 9px;margin-bottom:15px;" >    Reduced </span></div>
                                <?php endif; ?>
                                
                                <?php if($car->deposit_taken == 1): ?>
                                <div class="price-tag" style="padding: 3px 10px;border-radius:5px;margin-left: 7px;background:#32a1be;font-size: 9px;margin-bottom:15px;" >  Deposit Taken </span></div>
                                <?php endif; ?>
                                
                                <?php if(!empty($car->warranty_duration)): ?>
                                <div class="price-tag" style="padding: 3px 10px;border-radius: 5px;margin-left: 10px; margin-bottom:15px;background: #ebebeb;font-size: 11.5px;color: #525252;border: 1px solid #d6d6d6;box-shadow: 0px 0px 5px gray;" > <?php echo e($car->warranty_duration); ?> Warranty</span></div>
                                <?php endif; ?>
                        
                            </div>
                            
                        <?php endif; ?>
						
					    <ul class="product-icon-list  list-unstyled d-flex justify-content-start align-items-end" >
                      
                       <?php if($car->price != null): ?>
                      <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                        title="Price">
                           <!--<b style="color: gray;">Price</b> 
                          <br>--->
                          <strong  class="us_mrg priceFormat" style="color: black;font-size: 26px;    margin-left: 0;"
                          data-price="<?php echo e($car->price); ?>">
                       <?php if($car->previous_price && $car->previous_price < $car->price): ?>
                         <strike style="font-weight: 300;color: gray;font-size: 14px; float: left;" 
                         class="priceFormat" data-price="<?php echo e($car->price); ?>"
                         >
                         <?php echo e(symbolPrice($car->price)); ?></strike> <br>
                          <div style="color:black;" class="priceFormat" data-price="<?php echo e($car->previous_price); ?>"> <?php echo e(symbolPrice($car->previous_price)); ?></div>
                          <?php else: ?>
                         <?php echo e(symbolPrice($car->price)); ?>   
                        
                        <?php endif; ?>
                        </strong>
                      </li>
                      <?php endif; ?>
                      
                       <?php if($car->price != null && $car->price >= 1000): ?>
                          <li class="icon-start" style="border-bottom: 2px solid #00000;" data-tooltip="tooltip" data-bs-placement="top"
                            title="">
                              <b style="color: gray;">From</b>
                              
                            <strong style="color: black;font-size: 20px;" class="priceFormat" data-price="<?php echo e(calulcateloanamount(!empty($car->previous_price && $car->previous_price < $car->price) ?
                              $car->previous_price : $car->price)[0]); ?>">
                            <?php echo calulcateloanamount(!empty($car->previous_price && $car->previous_price < $car->price) ?
                               $car->previous_price : $car->price)[0]; ?>

                               </strong>
                          </li>
                      <?php endif; ?>
                      
                    </ul>
                    
                    
                    <?php
                        $financing_url = '';
                        $financing_dealer = '';
                    ?>
                     
                    <?php if($car->price != null && $car->price >= 1000): ?>
                      <a href="javascript:void(0);" style="color:#00b1f5; font-size:14px;" data-text="<?php echo calulcateloanamount($car->price)[1]; ?>" onclick="return openPopModal(this , <?php echo e($car->price); ?>)">
                          <?php if(!empty($car->financing_dealer) && !empty($car->financing_url) ): ?>
                            <?php echo e($car->financing_dealer); ?>

                            
                            <?php
                                $financing_url = $car->financing_url;
                                $financing_dealer = $car->financing_dealer;
                            ?>
                            
                          <?php else: ?>
                            Get Finance Approval
                          <?php endif; ?>
                          </a>
                      <?php endif; ?>
                      
					  </div>
					  
					  
					  <div class="col-md-4 d-flex align-items-end pb-2 offsetCol" 
            >
                        <?php if(Auth::guard('vendor')->check()): ?>
                        <?php
                            $user_id = Auth::guard('vendor')->user()->id;
                            $checkWishList = checkWishList($car->id, $user_id);
                        ?>
                        <?php else: ?>
                        <?php
                            $checkWishList = false;
                        ?>
                        <?php endif; ?>
                  
						<div class="d-flex justify-content-between align-items-center" style="width:140px ; margin-left:auto;">
                <a href="javascript:void(0);" class="btn2" style=" color: #1b87f4 !important; display: inline-block;
                      font-size: 16px;" onclick="openShareModal(this)" 
                data-url="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car->car_content->category_id), 'slug' => $car->car_content->slug, 'id' => $car->id])); ?>"
                style="color: #1b87f4;" >
                <i class="fa fa-share-alt" aria-hidden="true"></i> Share
                </a>
                <a href="javascript:void(0);"
                      onclick="addToWishlist(<?php echo e($car->id); ?>)"
								class="btn2  " style="display: inline-block;"
								data-tooltip="tooltip" data-bs-placement="right"
								title="<?php echo e($checkWishList == false ? __('Save Ads') : __('Saved')); ?>">
                <?php if($checkWishList == false): ?>
                            <i class="fal fa-heart" style="font-size: 16px; color:red;padding-right: 2px;" ></i>Save
                        <?php else: ?>
                            <i class="fa fa-heart" aria-hidden="true" style="font-size: 16px; color:red;padding-right: 2px;"></i>Save
                        <?php endif; ?>
							  </a>
						 
						 
                    
                    
						</div>
					  </div>
					  
					</div>
				</div>
			</div>
			
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                         
                        <?php if($car->car_content->main_category_id && $car->car_content->main_category_id == 24): ?>      
                        <div class="col-12 col-md-6">
                        <div class="d-flex border-bottom py-3 justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                        <i class="fal fa-calendar" style="font-size: 19px;color: #1b87f4;"></i></div>
                                        
                                        <div class="NotifyFont" >Mileage</div>
                                        
                                    </div>
                                    <div class="fw-bolder Notify-font-right">
                                    <?php echo e(number_format($car->mileage ? $car->mileage : 0)); ?>

                                    </div>
                                </div>
                        </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex border-bottom py-3 justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                        <i class="fal fa-tachometer" style="font-size: 19px;color: #1b87f4;"></i></div>
                                        <div class="NotifyFont" >Year</div>
                                    </div>
                                    <div class="fw-bolder Notify-font-right">
                                    <?php echo e($car->year ? $car->year : 0); ?>

                                    </div>
                                  
                                </div>
                        </div>
                        
                        <div class="col-12 col-md-6">
                        <div class="d-flex border-bottom py-3 justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                        <i class="fal fa-wrench"" style="font-size: 19px;color: #1b87f4;"></i></div>
                                        <div class="NotifyFont" >Engine Capacity
                                        </div>
                                    </div>
                                    <div class="fw-bolder Notify-font-right">
                                    <?php echo e(roundEngineDisplacement($car) ? roundEngineDisplacement($car) : ''); ?>

                                    </div>
                                </div>
                        </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex border-bottom py-3 justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                        <i class="fal fa-cogs" style="font-size: 19px;color: #1b87f4;"></i></div>
                                        <div class="NotifyFont" >Transmission Type</div>
                                    </div>
                                    <div class="fw-bolder Notify-font-right">
                                    <?php echo e(optional($car->car_content->transmission_type)->name ? optional($car->car_content->transmission_type)->name : ''); ?>

                                    </div>
                                </div>
                        </div>
                        <?php endif; ?>
                       
                        <div class="<?php echo e($car->vendor->vendor_type == 'dealer' ? 'col-12 col-md-6' : 'col-12'); ?>">
                        <div class="d-flex border-bottom py-3 justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                        <i class="fal fa-shipping-fast"" style="font-size: 19px;color: #1b87f4;"></i></div>
                                        <div class="NotifyFont" >Delivery available

                                        </div>
                                    </div>
                                    <div class="fw-bolder Notify-font-right">
                                    Yes
                                    </div>
                                </div>
                        </div>
                        <?php if($car->car_content->main_category_id && $car->car_content->main_category_id == 24): ?>
                            <div class="col-12 col-md-6">
                                <div class="d-flex border-bottom py-3 justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                        <i class="fal fa-users" style="font-size: 19px;color: #1b87f4;"></i></div>
                                        <div class="NotifyFont" >Total Owner</div>
                                    </div>
                                    <div class="fw-bolder Notify-font-right">
                                    <?php echo e((!empty($car->number_of_owners)) ? $car->number_of_owners : $car->owners); ?>

                                    </div>
                                </div>
                        </div>
                        <?php endif; ?>
<!-- end of milage and  -->

                            <div class="col-12 mt-3">
                            <div class="alert alert-success" role="alert" id="alertSuccess" style="display:none;">
                                We have just saved your interest will notify you once any match found.
                            </div>
                            </div>
                            <div class="col-lg-6 ">
                                <div class="col-md-12  clearfix ">
                                    <div class="float-start "><p> <b>Get notified when similar ads are posted</b> <br>
                                         <small>Save this search to get notifications for ads like this</small> </p></div>
                                   </div>
                             </div>
                         <div class="col-lg-6 d-flex justify-content-center">
                            <div class="col-12 col-md-12 mt-2 clearfix">
                                <div class="">
                                    <?php if(Auth::guard('vendor')->check() ): ?> 
                                    
                                    
                                    <a class="btn btn-lg btn-outline active  w-100"  href="javascript:void(0);" data-name="<?php echo e(@$car->car_content->title); ?>" data-category_slug="<?php echo e($car->car_content->category_slug); ?>"  data-transmissiontype="<?php echo e(optional($car->car_content->transmission_type)->slug); ?>" data-fueltype="<?php echo e(optional($car->car_content->fuel_type)->slug); ?>"   data-model="<?php echo e(optional($car->car_content->model)->slug); ?>"  data-brand="<?php echo e(optional($car->car_content->brand)->slug); ?>" data-year="<?php echo e($car->year); ?>" onclick="notifyMe(this)">
                                    Notify Me</a>
                                    
                                    <?php else: ?>
                                    
                                    <a class="btn btn-lg btn-outline active  w-100"  href="<?php echo e(route('vendor.login')); ?>" >
                                    Notify Me</a>
                                    
                                    <?php endif; ?>
                                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if(!empty($car->filters) && empty($car->year)): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            
                            <h4 class="mb-20" onclick="openDropdown(this)" style="cursor:pointer;" >
						        <?php echo e(__('Specifications')); ?> 
						        <span style="float: right;font-size: 1.5rem;" ><i class="fa fa-caret-down" aria-hidden="true"></i></span> 
						  </h4>
						  
                            <div class="row us_open_row">
                                    <?php
                                       $filters = json_decode($car->filters , true);
                                    ?>
                                    
                                    <?php $__currentLoopData = $filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    
                                    <?php if(strpos($key, 'select') !== false): ?>
                                        <div class="col-md-6" style="display: flex; margin-bottom: 1rem;">
                                            <h5><?php echo e(ucwords(strtolower(str_replace('select', '', str_replace('_', ' ', $key))))); ?></h5>
                                            <div style="margin-left: 1rem; font-size: 15px;"><?php echo e($filter); ?></div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if(strpos($key, 'radio') !== false): ?>
                                        <div class="col-md-6" style="display: flex; margin-bottom: 1rem;">
                                            <h5><?php echo e(ucwords(strtolower(trim(str_replace('radio', '', str_replace('_', ' ', $key)))))); ?></h5>
                                            <div style="margin-left: 1rem; font-size: 15px;"><?php echo e($filter); ?></div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if(strpos($key, 'input') !== false): ?>
                                        <div class="col-md-6" style="margin-bottom: 1rem;">
                                            <h5><?php echo e(ucwords(strtolower(trim(str_replace('input', '', str_replace('_', ' ', $key)))))); ?></h5>
                                            <div>
                                                 <?php if($car->car_content->main_category_id == '233' && ($key == 'input_pay_maximum' || $key == 'input_pay_minimum' )): ?>
                                                   <b>£</b> 
                                                 <?php endif; ?>
                                                 
                                                <?php echo e(str_replace('_', ' ', $filter)); ?>

                                                
                                                </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if(strpos($key, 'textarea') !== false): ?>
                                        <div class="col-md-6" style="margin-bottom: 1rem;">
                                            <h5><?php echo e(ucwords(strtolower(trim(str_replace('textarea', '', str_replace('_', ' ', $key)))))); ?></h5>
                                            <div>
                                                    <?php if($car->car_content->main_category_id == '233'): ?>
                                                    <?php
                                                        $explode = explode(',', $filter);
                                                        
                                                        if(count($explode) > 0) 
                                                        {
                                                            foreach($explode as $skill) 
                                                            {
                                                                echo '<span style="background: #c4c4c4;color: white;padding: 2px 10px 3px;margin: 5px;border-radius: 5px;font-size: 13px;display: inline-block;border: 1px solid #b3b3b3;">' . ucfirst($skill) . '</span>';
                                                            }
                                                        } 
                                                        else 
                                                        {
                                                            echo $filter; 
                                                        }
                                                    
                                                    ?>
                                                    
                                                    <?php else: ?>
                                                        <?php echo e($filter); ?>

                                                    <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if(strpos($key, 'checkbox') !== false && $filter): ?> 
                                    
                                        <div class="col-md-6"  style="display: flex;margin-bottom: 1rem;">
                                        <h5><?php echo e(ucwords(strtolower(trim(str_replace('checkbox', '', str_replace('_', ' ', $key)))))); ?></h5>
    
                                        
                                            <?php $__currentLoopData = $filter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div style="margin-left: 1rem;font-size: 15px;" >
                                                      <i class="fa fa-check-square text-primary" aria-hidden="true" style="margin-right: 5px;"></i>  <?php echo e($list); ?> 
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                        </div>
                                    
                                    <?php endif; ?>
                                        
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="row">

              <div class="col-lg-12">
				<?php if($car->year != null): ?>
				<!-- Product specification -->
				<div class="card">
					<div class="card-body">
						<div class="product-spec">
						    
						  <h4 class="mb-20" onclick="openDropdown(this)" style="cursor:pointer;" >
						        <?php echo e(__('Specifications')); ?> 
						        <span style="float: right;font-size: 1.5rem;" ><i class="fa fa-caret-down" aria-hidden="true"></i></span> 
						  </h4>
						  
						  <div class="row us_open_row">
							<?php if($car->what_type != null): ?>
						<div class=" col-6 col-md-3 mb-20 d-flex" >
							    <i class="fal fa-info-circle" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
							        <div>
							  <h6 class="mb-1"><?php echo e(__('Condition')); ?></h6>
							  <span><?php echo e(ucwords(str_replace('_' , ' ' , $car->what_type ))); ?></span>
							</div>
							</div>
							<?php endif; ?>
							
							<?php if($car->year != null): ?>
							<div class=" col-6 col-md-3 mb-20 d-flex" >
							    <i class="fal fa-calendar" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
							        <div>
							            <h6 class="mb-1">  <?php echo e(__('Model Year')); ?></h6>
							            <span><?php echo e($car->year); ?></span> 
							        </div>
							</div>
							<?php endif; ?>
							
							<?php if($car->mileage != null): ?>
							<div class="col-6 col-md-3 mb-20 d-flex">
							     <i class="fal fa-tachometer" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
                                <div>
                                    <h6 class="mb-1"><?php echo e(__('Mileage')); ?></h6>
                                    <span><?php echo e(number_format($car->mileage)); ?></span>
                                </div>
							</div>
							<?php endif; ?>
							
							
							<?php if($car->car_content->brand != null): ?>
							<div class="col-6 col-md-3 mb-20 d-flex">
							     <i class="fal fa-taxi" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
							     <div>
							        <h6 class="mb-1">Make</h6>
							        <span><?php echo e(optional($car->car_content->brand)->name); ?></span>
							    </div>
							</div>
							<?php endif; ?>
							
							 <?php if($car->car_content->model != null): ?>
							<div class="col-6 col-md-3 mb-20 d-flex">
							    <i class="fal fa-car" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
							    <div>
							        <h6 class="mb-1"><?php echo e(__('Model')); ?></h6>
							        <span><?php echo e(optional($car->car_content->model)->name); ?></span>
							   </div>
							</div>
							<?php endif; ?>
							
							<?php if($car->car_content->fuel_type != null ): ?>
							<div class="col-6 col-md-3 mb-20 d-flex">
							    
							    <i class="fal fa-gas-pump" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
							    
							   <div> 
							        <h6 class="mb-1"><?php echo e(__('Fuel Type')); ?></h6>
							        <span><?php echo e(optional($car->car_content->fuel_type)->name); ?></span>
							   </div>
							</div>
							<?php endif; ?>
							
							<?php if($car->car_content->transmission_type != null): ?>
							<div class="col-6 col-md-3 mb-20 d-flex">
							    
							    <i class="fal fa-cogs" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
							    
                                <div> 
                                    <h6 class="mb-1"><?php echo e(__('Transmission Type')); ?></h6>
                                    <span><?php echo e(optional($car->car_content->transmission_type)->name); ?></span>
                                </div>
							
							</div>
							<?php endif; ?>

							<?php if($car->engineCapacity != null): ?>
							<div class="col-6 col-md-3 mb-20 d-flex">
							    
                                <i class="fal fa-wrench" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
                                
                                <div> 
                                <h6 class="mb-1"><?php echo e(__('Engine Capacity')); ?></h6>
                                <span> <?php echo e(roundEngineDisplacement($car)); ?> </span>
                                </div>
							 </div>
							<?php endif; ?>
							
							<?php if($car->doors != null): ?>
							<div class="col-6 col-md-3 mb-20 d-flex">
							    
                                <img src="<?php echo e(asset('car.png')); ?>" style="margin-right: 1rem;height: 30px;" /> 
                                <div> 
							  <h6 class="mb-1"><?php echo e(__('Doors')); ?></h6>
							  <span><?php echo e($car->doors); ?></span>
							</div>
							</div>
							<?php endif; ?>
							
							<?php if($car->seats != null): ?>
							<div class="col-6 col-md-3 mb-20 d-flex">
							    
                               <img src="<?php echo e(asset('seat.png')); ?>" style="margin-right: 1rem;height: 30px;" /> 
                                
                                <div>
							  <h6 class="mb-1"><?php echo e(__('Seats')); ?></h6>
							  <span><?php echo e($car->seats); ?></span>
							  	</div>
							</div>
							<?php endif; ?>
							
							
								
							<?php if($car->number_of_owners != null || $car->owners != null ): ?>
								<div class="col-6 col-md-3 mb-20 d-flex">
							    
                                <i class="fal fa-users" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
                                
                                <div>
							  <h6 class="mb-1"><?php echo e(__('Number of owners')); ?></h6>
							  <span><?php echo e((!empty($car->number_of_owners)) ? $car->number_of_owners : $car->owners); ?></span>
							</div>
							</div>
							<?php endif; ?>
							
							
                            <?php if($car->road_tax != null): ?>
                            <div class="col-6 col-md-3 mb-20 d-flex">
                            
                                <i class="fal fa-file-invoice-dollar" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
                                
                                <div>
                                    <h6 class="mb-1"><?php echo e(__('Road Tax')); ?></h6>
                                    <span><?php echo e($car->road_tax); ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                             <?php if($car->vat_status != null): ?>
                            <div class="col-6 col-md-3 mb-20 d-flex">
                            
                                 <img src="<?php echo e(asset('tax.png')); ?>" style="margin-right: 1rem;height: 30px;" /> 
                                
                                <div> 
                                    <h6 class="mb-1">VAT Status</h6>
                                    <span><?php echo e($car->vat_status); ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                            
							
							
                            <?php if($car->power != null): ?>
                            <div class="col-6 col-md-3 mb-20 d-flex">
                            
                            <i class="fal fa-power-off" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
                            
                            <div>
                            <h6 class="mb-1"><?php echo e(__('Power')); ?></h6>
                            <span><?php echo e($car->power); ?> BHP</span>
                            </div>
                            </div>
                            <?php endif; ?>
							
							
							
							
							<?php if($car->bettery_range != null || $car->battery != null  && in_array(optional($car->car_content->fuel_type)->name , ['Electric' , 'Hybrid']) ): ?>
							<div class="col-6 col-md-3 mb-20 d-flex">
                            
                            <i class="fal fa-battery-full" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
                            
                            <div>
							  <h6 class="mb-1"><?php echo e(__('Bettery Range')); ?></h6>
							  <span><?php echo e((!empty($car->bettery_range)) ? $car->bettery_range : $car->battery. '+ M'); ?></span>
							</div>
							 </div>
							<?php endif; ?>
							
							
							<?php if($car->history_checked > 0): ?>
								<div class="col-6 col-md-3 mb-20 d-flex">
                            
                            <i class="fal fa-history" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
                            
                            <div>
							  <h6 class="mb-1"><?php echo e(__('History checked')); ?></h6>
							  <span>Yes</span>
							</div>
							</div>
							
							<?php endif; ?>

							<?php if($car->delivery_available > 0): ?>
							<div class="col-6 col-md-3 mb-20 d-flex">
                            
                            <i class="fal fa-shipping-fast" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
                            
                            <div>
							  <h6 class="mb-1"><?php echo e(__('Delivery available')); ?></h6>
							  <span>Yes</span>
							</div>
								</div>
							<?php endif; ?>
							
							<?php if($car->warranty_type != null): ?>
						<div class="col-6 col-md-3 mb-20 d-flex">
                            
                            <i class="fal fa-check" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
                            
                            <div>
							  <h6 class="mb-1"><?php echo e(__('Warranty Type')); ?></h6>
							  <span><?php echo e($car->warranty_type); ?></span>
							</div>
							</div>
							<?php endif; ?>

							<?php if($car->warranty_duration != null || $car->warranty != null ): ?>
								<div class="col-6 col-md-3 mb-20 d-flex">
                            
                            <i class="fal fa-clock" aria-hidden="true" style="font-size: 25px;margin-right: 1rem;color: #1b87f4;"></i>
                            
                            <div>
							  <h6 class="mb-1"><?php echo e(__('Warranty duration')); ?></h6>
							  <span><?php echo e((!empty($car->warranty_duration)) ? $car->warranty_duration : $car->warranty); ?></span>
							</div>
							</div>
							<?php endif; ?>
							
						  </div>
						  
                                    <?php if(!empty($car->filters)): ?>
                                    <?php
                                    $filters = json_decode($car->filters , true);
                                    ?>
                                    
                                    <div class="row">
                                        
                                    
								<div class="col-12 mb-20" style="font-size: 25px;font-weight: bold;color: #1b87f4;">
						           <i class="fa fa-info-circle" style="font-size:24px"></i> Additional Specifications
							    </div>
							    
							    
                                    <?php $__currentLoopData = $filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    
                                    <?php if(strpos($key, 'select') !== false): ?>
                                    <div class="col-md-6" style="display: flex; margin-bottom: 1rem;">
                                        <h5><?php echo e(ucwords(strtolower(str_replace('select', '', str_replace('_', ' ', $key))))); ?></h5>
                                        <div style="margin-left: 1rem; font-size: 15px;"><?php echo e($filter); ?></div>
                                    </div>
                                    <?php endif; ?>


            
                                    <?php if(strpos($key, 'radio') !== false): ?>
                                    <div class="col-md-6" style="display: flex; margin-bottom: 1rem;">
                                        <h5><?php echo e(ucwords(strtolower(trim(str_replace('radio', '', str_replace('_', ' ', $key)))))); ?></h5>
                                        <div style="margin-left: 1rem; font-size: 15px;"><?php echo e($filter); ?></div>
                                    </div>
                                    <?php endif; ?>

                                        
                                        
                                    <?php if(strpos($key, 'input') !== false): ?>
                                    <div class="col-md-6" style="margin-bottom: 1rem;">
                                        <h5><?php echo e(ucwords(strtolower(trim(str_replace('input', '', str_replace('_', ' ', $key)))))); ?></h5>
                                        <div><?php echo e(str_replace('_', ' ', $filter)); ?></div>
                                    </div>
                                    <?php endif; ?>

                                        
                                    <?php if(strpos($key, 'textarea') !== false): ?>
                                    <div class="col-md-6" style="margin-bottom: 1rem;">
                                        <h5><?php echo e(ucwords(strtolower(trim(str_replace('textarea', '', str_replace('_', ' ', $key)))))); ?></h5>
                                        <div><?php echo e($filter); ?></div>
                                    </div>
                                    <?php endif; ?>

                                      
                                    <?php if(strpos($key, 'checkbox') !== false && $filter): ?> 
                                    
                                        <div class="col-md-6"  style="display: flex;margin-bottom: 1rem;">
                                        <h5><?php echo e(ucwords(strtolower(trim(str_replace('checkbox', '', str_replace('_', ' ', $key)))))); ?></h5>
    
                                        
                                            <?php $__currentLoopData = $filter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div style="margin-left: 1rem;font-size: 15px;" >
                                                      <i class="fa fa-check-square text-primary" aria-hidden="true" style="margin-right: 5px;"></i>  <?php echo e($list); ?> 
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                        </div>
                                    
                                    <?php endif; ?>
                                        
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                    </div>
                                    
                                    
                                    <?php endif; ?>
						</div>
					</div>
				</div>
				<?php endif; ?>
				
				
				<?php if($car->vendor->vendor_type == 'dealer' && $specification_pluck->count() > 0 && $specifications->count() > 0): ?>
				<div class="card">
					<div class="card-body">
						<h4 class="mb-40 mt-20" onclick="openDropdown(this)" style="cursor:pointer;"  >
						    <?php echo e(__('  Vehicle Features')); ?>

						    
						    <span style="float: right;font-size: 1.5rem;" ><i class="fa fa-caret-down" aria-hidden="true"></i></span>
						</h4>
						
						<div class="row us_open_row" style="display:none;">
						<?php $__currentLoopData = $specification_pluck; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $speci_pluck): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="col-lg-12 col-sm-12 col-md-12 mb-20">
								<h6 class="mb-1"><?php echo e(str_replace('_N_' , ' & ' ,  strtoupper($speci_pluck ))); ?></h6>
							</div>
							<?php $__currentLoopData = $specifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							   
								<?php if($specification->parent_name === $speci_pluck): ?>
								<div class="col-lg-4 col-sm-4 col-md-4 mb-20">
								  <span> <i class="fal fa-circle" style="font-size: 14px;margin-right: 5px;"></i> <?php echo e(str_replace('_' , ' ' ,  ucfirst($specification->value ))); ?></span>
								</div>
								<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
					</div>
				</div>
				<?php endif; ?>
				
			
				<div class="card">
					<div class="card-body">
						<div class="product-desc">
						  <h4 class="mb-20"><?php echo e(__('Description')); ?>  </h4>
                                <div class="tinymce-content us_open_row" >
                                <div id="car-description" class="partial-description" style="position: relative;">
                                       <?php echo optional($car->car_content)->description; ?>

                                       <div id="over-flow-fade"></div>
                                       </div>
                                <button id="read-more" style="margin-left: -3px;color: #00278c; z-index: 1;">
                                    Read More
                                </button>
                                <button id="read-less" style="margin-left: -3px;color: #00278c;z-index: 1;">
                                    Read Less
                                </button>
                                </div>
						</div>
					</div>
				</div>
    
    
                
				<div class="card">
				     
				     
				       <?php if($car->vendor_id != 0): ?>   
                    <div class="col-md-12" style=" margin: 1rem;">
                    
                        <div class="author mb-15 us_parent_cls" >
                        
                            <a style="display:flex;" class="color-medium"
                            href="<?php echo e(route('frontend.vendor.details', ['id' => $car->vendor->id , 'username' => ($vendor = @$car->vendor->username)])); ?>"
                            target="_self" title="<?php echo e($vendor = @$car->vendor->username); ?>">
                            <?php if($car->vendor->photo != null): ?>
                           
                            <?php
                            $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $car->vendor->photo;
                            
                            if (file_exists(public_path('assets/admin/img/vendor-photo/' . $car->vendor->photo))) {
                            
                            $photoUrl = asset('assets/admin/img/vendor-photo/' . $car->vendor->photo);
                            }
                            
                            if(empty($car->vendor->photo))
                            {
                                $photoUrl = asset('assets/img/blank-user.jpg');
                            }
                            
                            ?>
                            
                            <img 
                            style="border-radius: 10%; max-width: 60px;"
                            class="lazyload blur-up"
                            src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>"
                            data-src="<?php echo e($photoUrl); ?>"  
                            alt="Vendor" 
                             
                            onerror="<?php echo e(asset('assets/img/blank-user.jpg')); ?>" >
                            
                            
                            <?php else: ?>
                            <img style="border-radius: 10%;max-width: 60px;" class="lazyload blur-up" data-src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>"
                            alt="Image">
                            <?php endif; ?>
                            <span style="    margin-left: 1rem;">
                             
                             <strong class="us_font_15" style="color: black;font-size: 20px;"><?php echo e($car->vendor->vendor_info->name); ?> 
                             <?php if(!empty($car->vendor->est_year)): ?> <b>.</b> <span style="font-size: 15px;font-weight: normal;color: gray;">Est <?php echo e($car->vendor->est_year); ?></span> <?php endif; ?> </strong>
                            
                                <?php
                                
                                $review_data = null;
                                
                                ?>
                            
                                    <?php if($car->vendor->google_review_id > 0 ): ?>
                                        <?php
                                            $review_data = get_vendor_review_from_google($car->vendor->google_review_id , true);
                                        ?>
                                    <?php endif; ?>
    
                                    <?php if($car->vendor->vendor_type == 'dealer'): ?>
                                    
                                        <?php if($car->vendor->is_franchise_dealer == '1'): ?>
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
                                    <?php else: ?>
                                    
                                    
                                <?php if($car->vendor->trader==0): ?>
                                <div><?php echo e(Ucfirst(@$car->vendor->vendor_info->city)); ?> <?php if(!empty($car->vendor->vendor_info->city)): ?> . <?php endif; ?> Private Seller </div>
                                <?php else: ?>
                                <div><?php echo e(Ucfirst(@$car->vendor->vendor_info->city)); ?> <?php if(!empty($car->vendor->vendor_info->city)): ?> . <?php endif; ?>  Trader </div>
                                <?php endif; ?>
                    
                                        
                                    <?php endif; ?>     
                            </span>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($car->vendor->banner_image): ?>
                    
                    <img src=" <?php echo e($car->vendor->vendor_type == 'normal' ? asset('public/uploads/'.$car->vendor->banner_image) :  env('SUBDOMAIN_APP_URL').'public/uploads/' . $car->vendor->banner_image); ?> " style="height:400px;    object-fit: cover;" alt="banner" />
                    
                    <?php endif; ?>
                    
                    <div class="container">
                        <div class="row" style="margin-top: 1rem;">
                            
                        <div class="col-md-6">
                                
                                
                        <?php if(Auth::guard('vendor')->check() && $car->vendor->id == Auth::guard('vendor')->user()->id ): ?>
                           
                         <?php if( !empty($car->package_id) && in_array($car->status , [0,1]) && $car->is_sold != 1 ): ?>
                        
                            <?php if($car->status==0): ?>
                                <a href = "<?php echo e(route('vendor.package.payment_method',  $car->id)); ?>"  class="btn btn-md  w-100 showLoader mb-3 us_hider" style="color:white;background-color: #007BFF;padding-top: 0.8rem;padding-bottom: 0.8rem;margin-bottom: 0px !important;" >
                                <i class="fal fa-money"></i> Pay Now
                                </a> 
                            <?php endif; ?> 
                            
                            <?php if($car->status==1): ?>
                                <a href = "<?php echo e(route('vendor.package.payment_boost',  [$car->car_content->main_category_id,$car->id])); ?>"  class="btn btn-md  w-100 showLoader mb-3 us_hider" style="color:white;padding-top: 0.8rem;padding-bottom: 0.8rem;margin-bottom: 0px !important;background-color: #007BFF;" >
                                <i class="fal fa-paper-plane"></i> Boost
                                </a> 
                            <?php endif; ?>
                            
                        <?php endif; ?> 
                        
                        <a href="<?php echo e(route('vendor.cars_management.edit_car', $car->id)); ?>"  class="btn btn-md btn-primary w-100 showLoader mt-3 mb-3 us_hider" > 
                        <i class="fa fa-pencil" aria-hidden="true"></i>  Edit
                        </a> 
                        
                        <?php else: ?>
                
                        <?php if($car->vendor->show_contact_form == 1 && $car->message_center == 1): ?>
                            
                            <?php if(Auth::guard('vendor')->check() ): ?>  
                                <button type="button" class="btn btn-md  w-100 us_hider " style="color:white;background-color: #007BFF;padding-top: 0.8rem;padding-bottom: 0.8rem;margin-bottom: 0px !important;" data-toggle="modal" data-target="#exampleModal">
                                     <?php if($car->vendor->vendor_type == 'normal'): ?>
                    <?php echo e(__('Send message')); ?>

                    <?php else: ?>
                     <?php echo e(__('Make  Enquiry')); ?>

                    <?php endif; ?>
                                </button>
                            <?php else: ?>
                                <a href="<?php echo e(route('vendor.login')); ?>"> 
                                    <button type="submit" id="showform2ee"  class="btn btn-md  w-100 showLoader mb-3 us_hider" style="color:white;background-color: #007BFF;padding-top: 0.8rem;padding-bottom: 0.8rem;margin-bottom: 0px !important;">
                                          <?php if($car->vendor->vendor_type == 'normal'): ?>
                    <?php echo e(__('Send message')); ?>

                    <?php else: ?>
                     <?php echo e(__('Make  Enquiry')); ?>

                    <?php endif; ?>
                                    </button> 
                                </a>
                            <?php endif; ?>
                            
                            
                        <?php endif; ?>
                        
                            <?php if($car->phone_text == 1): ?>
                             
                                <a href="tel:<?php echo e($car->vendor->country_code.$car->vendor->phone); ?>" id="userphonebutton" style="margin-top:1rem;" onclick="savePhoneView(<?php echo e(@$car->id); ?> , this)"  class="btn btn-md btn-primary w-100 showLoader mb-3 us_hider" data-phone_number="<?php echo e($car->vendor->country_code.$car->vendor->phone); ?>">Call Now</a>
                               
                                <?php if($car->vendor->also_whatsapp == 1): ?>
                                <a href="https://api.whatsapp.com/send?phone=<?php echo e($car->vendor->country_code.$car->vendor->phone); ?>&text=I'm%20interested%20in%20this%20item%3A%20<?php echo e(urlencode(route('frontend.car.details', ['cattitle' => catslug($car->car_content->category_id), 'slug' => $car->car_content->slug, 'id' => $car->id]))); ?>" 
                                class="btn btn-md btn-primary w-100 showLoader mb-3 us_hider" target="_blank">
                                WhatsApp Now
                                </a>
                                <?php endif; ?>
                
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <a class="btn btn-md btn-outline w-100 showLoader mb-3 <?php if($car->phone_text == 0): ?> mt-3 <?php endif; ?>" href="<?php echo e(route('frontend.vendor.details' , ['id' => $car->vendor->id , 'username' => $car->vendor->username])); ?>">
                        <?php if($car->vendor->vendor_type == 'dealer'): ?>
                        Visit Showroom
                        <?php else: ?>
                        View All Ads
                        <?php endif; ?>
                        </a>
                        
                        </div>
                            
                            <div class="col-md-6">
                                <?php
                                
                                $totl_per = 'N/A';
                                
                                $totalSupportTicket = \App\Models\SupportTicket::where('admin_id', $car->vendor->id)->count();
                                
                                if($totalSupportTicket > 0 )
                                {
                                     $totalSupportTicketWithMessages = \App\Models\SupportTicket::where('admin_id', $car->vendor->id)
                                    ->has('messages')
                                    ->count();
                                    $responseRate = ($totalSupportTicketWithMessages / $totalSupportTicket) * 100;
                                    
                                   $totl_per =  round($responseRate, 2) . "%";
                                }
                               
                                
                                ?>
                            <div class="flex" style="margin-bottom:  0.5rem;">
                                <label style="font-size: 15px;">Avg. Response Rate</label>
                                <div style="float:right"><?php echo e($totl_per); ?></div>
                            </div>
                            
                             <div class="flex" style="margin-bottom:  0.5rem;">
                                <label style="font-size: 15px;">Location</label>
                                <div style="float:right"><?php echo e(!empty($car->vendor->vendor_info) ? ucfirst($car->vendor->vendor_info->city) : 'none'); ?></div>
                            </div>
                            
                             <div class="flex" style="margin-bottom:  0.5rem;">
                                <label style="font-size: 15px;">Member since</label>
                                <div style="float:right"><?php echo e(!empty($car->vendor->created_at) ? date('Y' , strtotime($car->vendor->created_at)) : date('Y')); ?></div>
                            </div>
                            
                            <?php if(!empty($car->vendor->est_year)): ?>
                             <div class="flex" style="margin-bottom:  0.5rem;">
                                <label style="font-size: 15px;">Est year</label>
                                <div style="float:right"><?php echo e(!empty($car->vendor->est_year) ? $car->vendor->est_year : date('Y')); ?></div>
                            </div>
                            <?php endif; ?>
                            
                             <div class="flex" style="margin-bottom:  0.5rem;">
                                <label style="font-size: 15px;">Active Ads</label>
                                <div style="float:right"><?php echo e(!empty($car->vendor->cars) ? $car->vendor->cars->where('status' , 1)->count() : '0'); ?></div>
                            </div>
                            
                            <?php if($car->vendor->vendor_type == 'normal'): ?>
                             <div class="flex" style="margin-bottom:  0.5rem;">
                                <label style="font-size: 15px;">Life time Ads</label>
                                <div style="float:right"><?php echo e(!empty($car->vendor->cars) ? $car->vendor->carsWithTrashed->count() : '0'); ?></div>
                            </div>
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
                                <div class="flex" style="margin-bottom: 0.5rem;cursor:pointer;" onclick="openHours(this)">
                                    <label style="font-size: 15px; color: <?php echo e($p_label); ?>"><?php echo e($p_status); ?></label>
                                        <div style="float:right; color: black">
                                        <?php echo e($p_timeRange); ?> <i class="fa fa-caret-down" style="position: relative;
                                        margin-left: 10px;
                                        font-size: 20px;
                                        top: 1px;" aria-hidden="true"></i> 
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <div class="flex us_open_hours" style="margin-bottom:  0.5rem; display:none;">
                                    <label style="font-size: 15px; color: <?php echo e($labelColor); ?>"><?php echo e($day); ?></label>
                                    <div style="float:right; color: <?php echo e($labelColor); ?>">
                                        <?php echo e($status); ?> <?php echo e($timeRange); ?>

                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                            
                            
                            <?php if(!empty($car->vendor->about_us)): ?>
                            <div class="col-md-12">
                                
                                <h4>About Us</h4>
                                
                                <p style="font-size: 14px;line-height: 1.6;">
                                    
                                    <?php echo e($car->vendor->about_us); ?>

                                    
                                </p>
                                
                            </div>
                            <?php endif; ?>
                            
                            <div class="col-md-12">
                            
                            <hr>
                            </div>
                            
                            <div style="font-size: 13px;color: #6d6b6b;">
                                All information in this ad is provided by third parties and ListIt are not in a position to offer any warranty or guarantee in relation to the content.
                             <span style="display:none;"  id="showDisTxt">
                                 <br>
                                 <br>
                                    Both buyer and seller should confirm all information in relation to the vehicle before committing to the sale. We disclaim all liability arising out of or in connection with any reliance placed on the above content. We accept no responsibility for keeping the content and information accurate, up to date or complete.
                             </span>
                             
                             <br><span id="readBtn">
                                    <a href="javascript:void(0);" style="color: #0063fc;" onclick="showmore(1 , this)">read more</a>
                                </span>
                                
                                
                            </div>
                       
                     
                       
                      
                       
                       
                        </div>
                    </div>
                    
                    
					<div class="card-body" style="    padding-top: 0;">
						<div class="product-desc">
						  <h4 class="mb-20">
						    
						  <?php if(!empty($review_data) &&  $review_data['total_reviews'] > 0 && $review_data['total_ratings'] > 0): ?>
						       <?php echo e($car->vendor->vendor_info->name); ?>

                            <div class="rating-container" style="font-size: 13px;font-weight: 500;">
                            <?php echo $review_data['rating_stars']; ?>  <b><?php echo e($review_data['total_ratings']); ?></b>/5 .   <a target="_blank" style="color: #ee2c7b;" href="https://www.google.com/maps?q=<?php echo e(str_replace(' ' , '+' , $car->vendor->vendor_info->name)); ?>"> <?php echo e(number_format($review_data['total_reviews'] )); ?> google reviews </a>
                            </div>

                        <?php endif; ?>
						  </h4>
						  <div class="tinymce-content">
						      <?php if(!empty($review_data) && $review_data['total_reviews'] > 0 ): ?>
						    	<?php echo $review_data['reviews_output']; ?>

							  <?php endif; ?>
						  </div>
						  
						  
						   <div>
						         <hr>
						         
                           <a href="javascript:void(0);" style="color: gray;">
                             <i class="fa fa-flag" aria-hidden="true"></i>  <span style="font-size: 14px;margin-left: 5px;" onclick="reportModal()">Report This Ad</span>
                           </a>
                       </div>
                       
                       
						</div>
					</div>
				</div>
             
				
                
              </div>
              <?php if(!empty(showAd(3))): ?>
                <div class="text-center mb-3 mt-3">
                  <?php echo showAd(3); ?>

                </div>
              <?php endif; ?>
            </div>
			  <!--Related Product-area start -->
            <?php if(count($related_cars) > 0): ?>
            
              <div class="product-area pt-60" style="padding:2rem;">
                <div class="section-title title-inline mb-30">
                  <h3 class="title mb-20">
                      <?php if($car->vendor->vendor_type == 'normal' ): ?>
                      <?php echo e(__('Related Cars')); ?>

                      <?php else: ?>
                      <?php echo e(__('Our Stock')); ?>

                      <?php endif; ?>
                </h3>
                
                <div class="slider-navigations mb-20">
                    <a href="<?php echo e(route('frontend.vendor.details', ['id' => $car->vendor->id , 'username' => ($vendor = @$car->vendor->username)])); ?>">View All</a>
                  </div>
                  
                </div>
                
                <?php echo $__env->make('frontend/car/related_ads', ['related_cars' => $related_cars], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
              </div>
            
              <?php if(!empty(showAd(3))): ?>
                <div class="text-center mb-40">
                  <?php echo showAd(3); ?>

                </div>
              <?php endif; ?>
              
              <!-- Product-area end -->
            <?php endif; ?>
          </div>
        </div>
        <div class="col-lg-4">
          <aside class="widget-area">
            <!-- Widget form -->
            <div class="widget widget-form card">
              <?php if(Session::has('success')): ?>
                <div class="alert alert-success"><?php echo e(__(Session::get('success'))); ?></div>
              <?php endif; ?>
              <?php if(Session::has('error')): ?>
                <div class="alert alert-success"><?php echo e(__(Session::get('error'))); ?></div>
              <?php endif; ?>
              <h5 class="title mb-20">
                  <?php if($car->vendor->vendor_type == 'dealer'): ?>
                <?php echo e(__('Contact Dealer')); ?>

                <?php else: ?>
                Contact Seller
                <?php endif; ?>
              </h5>
              <?php if($car->vendor_id != 0): ?>
                <div class="user mb-20">
                  <div class="user-img">
                    <div class="lazy-container ratio ratio-1-1 rounded-pill">
                      <?php if($car->vendor->photo != null): ?>
                     
                        <?php
                            $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $car->vendor->photo;
                            
                            if (file_exists(public_path('assets/admin/img/vendor-photo/' . $car->vendor->photo))) {
                            
                            $photoUrl = asset('assets/admin/img/vendor-photo/' . $car->vendor->photo);
                            }
                            
                            if(empty($car->vendor->photo))
                            {
                                $photoUrl = asset('assets/img/blank-user.jpg');
                            }
                            
                            ?>
                            
                            <img 
                            class="lazyload "
                            src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>"
                            data-src="<?php echo e($photoUrl); ?>"  
                            alt="Vendor" 
                             
                            onerror="<?php echo e(asset('assets/img/blank-user.jpg')); ?>" >
                            
                        
                        
                      <?php else: ?>
                        <img class="lazyload" data-src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>" alt="">
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="user-info">
                    <h6 class="mb-1">
                      <a href="<?php echo e(route('frontend.vendor.details', ['id' => $car->vendor->id , 'username' => $car->vendor->username])); ?>"
                        title="<?php echo e($car->vendor->username); ?>"><?php echo e($car->vendor->vendor_info->name); ?></a>
                    </h6>
                    <?php echo e(Ucfirst(@$car->vendor->vendor_info->city)); ?>  <?php if(!empty($car->vendor->vendor_info->city)): ?> . <?php endif; ?>
                    
                    
                        <?php if($car->vendor->vendor_type == 'normal'): ?>
                        
                        <?php if($car->vendor->trader==0): ?>
                        <div> Private Seller </div>
                        <?php else: ?>
                        <div>  Trader </div>
                        <?php endif; ?>
                        <?php else: ?>
                        
                        <?php if($car->vendor->is_franchise_dealer == 1): ?>
                           Dealer 
                          <?php else: ?>
                            Dealer 
                          <?php endif; ?>
                             
                        <?php endif; ?>
                      
                  
                        <?php if(!empty($review_data) &&  $review_data['total_reviews'] > 0 && $review_data['total_ratings'] > 0): ?>
                            <div class="rating-container">
                            <?php echo $review_data['rating_stars']; ?> . <?php echo e($review_data['total_ratings']); ?>/5
                            </div>

                        <div >  <a target="_blank" style="color: #ee2c7b;" href="https://www.google.com/maps?q=<?php echo e(str_replace(' ' , '+' , $car->vendor->vendor_info->name)); ?>">  <?php echo e(number_format($review_data['total_reviews'] )); ?> google reviews  </a></div>
                        <?php endif; ?>
              
                  </div>
                </div>
              <?php else: ?>
                <div class="user mb-20">
                  <div class="user-img">
                    <div class="lazy-container ratio ratio-1-1 rounded-pill">
                      <img class="lazyload" data-src="<?php echo e(asset('assets/img/admins/' . $admin->image)); ?>" alt="">
                    </div>
                  </div>
                  <div class="user-info">
                    <h6 class="mb-1"><a
                        href="<?php echo e(route('frontend.vendor.details', ['username' => $admin->username, 'admin' => 'true'])); ?>"><?php echo e($admin->username); ?></a>
                    </h6>
                    <a href="tel:123456789"><?php echo e($admin->phone); ?></a>
                    <br>
                    <!-- <a href="mailto:<?php echo e($admin->email); ?>"><?php echo e($admin->email); ?></a> -->
                  </div>
                </div>
              <?php endif; ?>
              <input type="hidden" name="userphone" value="<?php echo e($car->vendor->country_code.$car->vendor->phone); ?>">
              
                <?php if(Auth::guard('vendor')->check() && $car->vendor->id == Auth::guard('vendor')->user()->id ): ?>
                
                 <?php if( !empty($car->package_id) && in_array($car->status , [0,1]) && $car->is_sold != 1 ): ?>
                
                    <?php if($car->status==0): ?>
                        <a href = "<?php echo e(route('vendor.package.payment_method',  $car->id)); ?>" class="btn btn-md btn-outline w-100 showLoader mb-3 sticky-button us_button_st" >
                        <i class="fal fa-money"></i> Pay Now
                        </a>
                    <?php endif; ?> 
                    
                    <?php if($car->status==1): ?>
                        <a href = "<?php echo e(route('vendor.package.payment_boost',  [$car->car_content->main_category_id,$car->id])); ?>" class="btn btn-md btn-outline w-100 showLoader mb-3 sticky-button us_button_st" >
                        <i class="fal fa-paper-plane"></i> Boost
                        </a>
                    <?php endif; ?>
                
                <?php endif; ?> 
                
                <a href="<?php echo e(route('vendor.cars_management.edit_car', $car->id)); ?>" class="btn btn-md btn-primary w-100 showLoader sticky-button" > 
                    <i class="fa fa-pencil" aria-hidden="true"></i>  Edit
                </a>
                
                <?php else: ?>
                
                <?php if($car->phone_text == 1): ?>
                    <a href="tel:<?php echo e($car->vendor->country_code.$car->vendor->phone); ?>" id="userphonebutton"  onclick="savePhoneView(<?php echo e(@$car->id); ?> , this)" 
                    class="btn btn-md btn-outline w-100 showLoader mb-3  us_button_st  <?php if($car->phone_text == 1 && $car->message_center == 0): ?> us_sing_doub <?php else: ?> sticky-button <?php endif; ?> " data-phone_number="<?php echo e($car->vendor->country_code.$car->vendor->phone); ?>">
                        <span class="original_text">Call Now</span>  <span class="mobile_icon" style="display:none;"> <i class="fa fa-phone"></i></span>
                    </a>
                    
                <?php if($car->vendor->also_whatsapp == 1): ?>
                <a href="https://api.whatsapp.com/send?phone=<?php echo e($car->vendor->country_code.$car->vendor->phone); ?>&text=I'm%20interested%20in%20this%20item%3A%20<?php echo e(urlencode(route('frontend.car.details', ['cattitle' => catslug($car->car_content->category_id), 'slug' => $car->car_content->slug, 'id' => $car->id]))); ?>" 
                class="btn btn-md btn-outline w-100 showLoader mb-3  us_wat_btn <?php if($car->phone_text == 1 && $car->message_center == 0): ?> us_sing_doub <?php else: ?> sticky-button <?php endif; ?>" target="_blank">
                <span class="original_text"> WhatsApp Now </span>   <span class="mobile_icon" style="display:none;"><i class='fab fa-whatsapp'></i></span>
                </a>
                <?php endif; ?>

                 
                <?php endif; ?>
                
                <?php if($car->vendor->show_contact_form == 1 && $car->message_center == 1 ): ?>
                
                    <?php if(Auth::guard('vendor')->check()): ?>  
                        <button type="button" class="btn btn-md btn-primary w-100  us_open_modal  <?php if($car->phone_text == 0 && $car->message_center == 1): ?> us_sing_doub <?php else: ?> sticky-button <?php endif; ?> " data-toggle="modal" data-target="#exampleModal">
                            <span class="original_text">
                                <?php if($car->vendor->vendor_type == 'normal'): ?>
                                <?php echo e(__('Send message')); ?>

                                <?php else: ?>
                                <?php echo e(__('Make  Enquiry')); ?>

                                <?php endif; ?>
                                </span>
                                
                                 <span class="mobile_icon" style="display:none;"> <i class="fa fa-envelope" aria-hidden="true"></i> </span>
                                 
                        </button>
                    <?php else: ?>
                        <a href="<?php echo e(route('vendor.login')); ?>"> 
                            <button type="submit" id="showform2ee" class="btn btn-md btn-primary w-100 showLoader <?php if($car->phone_text == 0 && $car->message_center == 1): ?> us_sing_doub <?php else: ?> sticky-button <?php endif; ?> ">
                                <span class="original_text">
                                    <?php if($car->vendor->vendor_type == 'normal'): ?>
                                        <?php echo e(__('Send message')); ?>

                                    <?php else: ?>
                                        <?php echo e(__('Make  Enquiry')); ?>

                                    <?php endif; ?>
                                </span>
                                
                                 <span class="mobile_icon" style="display:none;"> <i class="fa fa-envelope" aria-hidden="true"></i> </span>
                            </button>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
                        
                <?php endif; ?>
                 
              <form class="contactForm" style="display: none;" action="<?php echo e(route('frontend.car.contact_message')); ?>" method="POST">
                <?php echo csrf_field(); ?>    
                <div class="row" >
                  <input type="hidden" name="car_id" value="<?php echo e($car->id); ?>">

                  <div class="col-12">
                    <div class="form-group mb-20">
                      <input type="text" class="form-control" name="name"
                        placeholder="<?php echo e(__('Name') . ' *'); ?>" required>
                      <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-danger"><?php echo e($message); ?></p>
                      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group mb-20">
                      <input type="email" name="email" class="form-control"
                        placeholder="<?php echo e(__('Email Address') . ' *'); ?>" required>
                      <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-danger"><?php echo e($message); ?></p>
                      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group mb-20">
                      <input type="number" name="phone" class="form-control"
                        placeholder="<?php echo e(__('Phone Number') . ' *'); ?>">
                      <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-danger"><?php echo e($message); ?></p>
                      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group mb-20">
                      <textarea name="message" id="message" class="form-control" cols="30" rows="8"
                        data-error="Please enter your message" placeholder="<?php echo e(__('Message') . '...'); ?>"></textarea>
                      <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-danger"><?php echo e($message); ?></p>
                      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <?php if($info->google_recaptcha_status == 1): ?>
                  <div class="col-12">
                    <div class="form-group captcha mb-20">
                      <?php echo NoCaptcha::renderJs(); ?>

                      <?php echo NoCaptcha::display(); ?>

                      <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="help-block with-errors text-danger"><?php echo e($message); ?></div>
                      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                  </div>
                <?php endif; ?>
                <button  type="submit"
                  class="btn btn-md btn-primary w-100 showLoader">  <?php if($car->vendor->vendor_type == 'normal'): ?>
                    <?php echo e(__('Send message')); ?>

                    <?php else: ?>
                     <?php echo e(__('Make  Enquiry')); ?>

                    <?php endif; ?></button>
              </form>
            </div>
            <!-- Widget share -->
            <div class="widget widget-share card us_share_laptop_view">
              <h5 class="title">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#share"
                  aria-expanded="true" aria-controls="share">
                  <?php echo e(__('Share Now')); ?>

                </button>
              </h5>
              <div id="share" class="collapse show">
                <div class="accordion-body">
                  <div class="social-link style-2 mb-20 ">
                    <a data-tooltip="tooltip" data-bs-placement="top"
                        title="facebook" href="https://www.facebook.com/sharer/sharer.php?quote=Check Out this ad on List It&utm_source=facebook&utm_medium=social&u=<?php echo e(urlencode(url()->current())); ?>"
                      target="_blank"><i class="fab fa-facebook-f"></i></a>

                    <a data-tooltip="tooltip" data-bs-placement="top"
                        title="Twitter" href="//twitter.com/intent/tweet?text=Check Out this ad on List It&amp;url=<?php echo e(urlencode(url()->current())); ?>"
                      target="_blank"><i class="fab fa-twitter"></i></a>

                    <a data-tooltip="tooltip" data-bs-placement="top"
                        title="Whatsapp" href="//wa.me/?text=Check Out this ad on List it <?php echo e(urlencode(url()->current())); ?>&amp;title= "
                      target="_blank"><i class="fab fa-whatsapp"></i></a>
                      <a data-tooltip="tooltip" data-bs-placement="top"
                        title="Linkedin" href="//www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo e(urlencode(url()->current())); ?>&amp;title=Check Out this ad on List it"
                      target="_blank"><i class="fab fa-linkedin-in"></i></a>
                      <a data-tooltip="tooltip" data-bs-placement="top"
                        title="Email" href="mailto:?subject=Check Out this ad on List it&amp;body=Check Out this ad on List it <?php echo e(urlencode(url()->current())); ?>&amp;title="
                      target="_blank"><i class="fas fa-envelope"></i></a>
                      <a data-tooltip="tooltip" data-bs-placement="top"
                        title="Copy Link" id = "copy_url" onclick="copy('<?php echo e((url()->current())); ?>','#copy_url')" id="copy_button_1" href="javascript:void(0)"
                      ><i class="fas fa-link"></i></a>
                  </div>
                </div>
              </div>
            </div>
            <!-- widget product -->
            <div class="widget widget-product card">
              <h5 class="title pb-0">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#products">
                  <?php echo e(__('Latest Cars')); ?>

                </button>
              </h5>
              <div id="products" class="collapse show mt-3">
                <div class="accordion-body">
                  <?php $__currentLoopData = $latest_cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  
                  
                    <?php
                    
                        $image_path = $car->feature_image;
                        
                        $rotation = 0;
                        
                        if($car->rotation_point > 0 )
                        {
                            $rotation =    $car->rotation_point;
                        }
                        
                        if(!empty($image_path) && $car->rotation_point == 0 )
                        {   
                            $rotation = $car->galleries->where('image' , $image_path)->first();
                        
                            if($rotation == true)
                            {
                                $rotation = $rotation->rotation_point;  
                            }
                            else
                            {
                                $rotation = 0;   
                            }
                        }
                        
                        if(empty($car->feature_image))
                        {
                            $imng = $car->galleries->sortBy('priority')->first();
                            
                            $image_path = $imng->image;
                            $rotation = $imng->rotation_point;
                        } 
                    
                    ?>
            
            
                    <div class="product-default product-inline" data-id="<?php echo e($car->id); ?>">
                      <figure class="product-img">
                          
                        <a href="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car->car_content->category_id),'slug' => $car->car_content->slug, 'id' => $car->id])); ?>"
                          class="lazy-container ratio ratio-1-1">
                            
                          <img class="lazyload" data-src=" <?php echo e($car->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' . $image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path); ?>"
                            alt="Product" style="transform: rotate(<?php echo e($rotation); ?>deg);" onerror="this.onerror=null;this.src='<?php echo e(asset('assets/img/Image_not_available.png')); ?>';" >
                            
                        </a>
                      </figure>
                      
                      
                     <div class="product-details" style="cursor:pointer;" onclick="window.location.href='<?php echo e(route('frontend.car.details', ['cattitle' => catslug($car->category_id), 'slug' => $car->slug, 'id' => $car->id])); ?>'">

                        <h6 class="product-title mb-1 ellipsis_n">
                          <?php echo e(@$car->title); ?>

                        </h6>
                        <div class="author mb-2">
                          <span style="line-height: 15px;font-size: 12px;">
                             
                             <?php if($car->year): ?>
                             <?php echo e($car->year); ?> <b class="us_dot"> - </b> 
                             <?php endif; ?>
                             
                               <?php if($car->engineCapacity && $car->car_content->fuel_type ): ?>
                             <?php echo e(roundEngineDisplacement($car)); ?> <?php echo e($car->car_content->fuel_type->name); ?> <b class="us_dot"> - </b> 
                             <?php endif; ?>
                             
                             <?php if($car->mileage): ?>
                             <?php echo e(number_format( $car->mileage )); ?> mi <b class="us_dot"> - </b> 
                             <?php endif; ?>
                             
                              <?php if($car->created_at): ?>
                             <?php echo e(calculate_datetime($car->created_at)); ?> 
                             <?php endif; ?>
                             
                              <?php if($car->city): ?>
                             <b class="us_dot"> - </b> <?php echo e(Ucfirst($car->city)); ?> 
                             <?php endif; ?>
                               
                        </span>
                        </div>
                        
                        
                        <ul class="product-icon-list  list-unstyled d-flex align-items-center" style="margin-bottom:0.5rem;">
                    
                            <?php if($car->price != null): ?>
                            <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                            title="Price">
                            <b style="color: gray;font-size: 12px;">Price</b>
                            <br>
                            <strong  class="us_mrg" style="color: black;font-size: 12px;margin-left: 0;">
                            <?php if($car->previous_price && $car->previous_price < $car->price): ?>
                            <strike style="font-weight: 300;color: gray;font-size: 12px;float: left;"><?php echo e(symbolPrice($car->price)); ?></strike> <br> <div style="color:black;"> <?php echo e(symbolPrice($car->previous_price)); ?></div>
                            <?php else: ?>
                            <?php echo e(symbolPrice($car->price)); ?>   
                            
                            <?php endif; ?>
                            </strong>
                            </li>
                            <?php endif; ?>
                            
                            <?php if($car->price != null && $car->price >= 1000): ?>
                            <li class="icon-start" data-tooltip="tooltip" data-bs-placement="top"
                            title="">
                            <b style="color: gray;font-size: 12px;">From</b>
                            <br>
                            <strong style="color: black;font-size: 12px;"><?php echo calulcateloanamount(!empty($car->previous_price && $car->previous_price < $car->price ) ? $car->previous_price : $car->price)[0]; ?></strong>
                            </li>
                            <?php endif; ?>
                      
                        </ul>
                    
                    
                      </div>
                    </div><!-- product-default -->
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
              </div>
            </div>
            <!-- Widget banner -->
            <div class="widget-banner">
              <?php if(!empty(showAd(1))): ?>
                <div class="text-center mb-4">
                  <?php echo showAd(1); ?>

                </div>
              <?php endif; ?>
              <?php if(!empty(showAd(2))): ?>
                <div class="text-center">
                  <?php echo showAd(2); ?>

                </div>
              <?php endif; ?>
            </div>
            <!-- Spacer -->
            <div class="pb-40"></div>
          </aside>
        </div>
      </div>
    </div>
    </div>
    </div>

  
  
    <div class="modal fade" id="financeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header" style="padding-bottom: 0;border: none;">
    <h5 class="modal-title" id="exampleModalLabel" style="color:white;">.</h5>
    <button type="button" class="close" style="z-index: 10;" onclick="closeModal()">
      <span aria-hidden="true">&times;</span>
    </button>
    </div>
      <div class="modal-body" style="padding-top: 0;margin-top: -2rem;">
           <center> <b style="color: #04de04;font-size: 2rem;">£</b><br>
            <b style="font-size: 2rem;" id="eventTag">Monthly Price</b><br>
            <p style="margin-top: 10px;" id="textHTML">
            </p></center>
           
                            
                 <?php if(!empty($financing_dealer) && !empty($financing_url) ): ?>
                           <a href="<?php echo e($financing_url); ?>" class="btn btn-info" style="width: 100%;color: white;">   <?php echo e($financing_dealer); ?>

                          <?php else: ?>
                             <a href="<?php echo e(getSetVal('finance_url')); ?>" class="btn btn-info" style="width: 100%;color: white;"> Get Finance Approval
                          <?php endif; ?>
                </a>
      </div>
    </div>
    </div>
    </div>
    
    
    <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" style="border: none;">
            <h5 class="modal-title" id="exampleModalLabel" style="display:flex;">
                
                <i class="fa fa-flag" aria-hidden="true" style="font-size: 25px;color: red;"></i> 
                    
                <div style="margin-left:10px">
                     <span style="font-size: 12px;color: gray;">Report Ad </span> 
                     <!--<br>-->
                     <!--<small>Help us to understand the reason.</small>-->
                </div>
            </h5>
            <button type="button" class="close" onclick="closeReportModal()">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
          
              <form method="GET" onsubmit="return reportAd()">
                  
              <div class="modal-body">
              
                <div class="alert alert-success" role="alert" style="display:none;" id="successMessage">
                    Your message was sent.
                </div>
    
            
                        <select name="report_reason" class="form-control" style="    margin-bottom: 1rem;" required id="reasonOption">
                            <option value=""></option>
                            <option value="Animal Welfare Concern">Animal Welfare Concern</option>
                            <option value="Breach of T&C's">Breach of T&C's</option>
                            <option value="Suspected Fraud">Suspected Fraud</option>
                            <option value="Suspected Stolen Goods">Suspected Stolen Goods</option>
                            <option value="Suspected Counterfeit Goods">Suspected Counterfeit Goods</option>
                            <option value="Can't contact seller">Can't contact seller</option>
                            <option value="others">others</option>
                        </select>
          
            
                <label>
                        Comment
                </label>
                
                <input type="hidden" id="ad_id" value="<?php echo e($car_ids); ?>" /> 
                
                <textarea class="form-control mt-2" placeholder="Please Describe To Us" required   id="explaination" ></textarea>
                
                <button class="btn btn-primary" type="submit" style="width: 100%;margin-top: 20px;" id="submtBtn">Report Ad</button>
                
                </div>
          </form>
        </div>
      </div>
    </div>


  <!-- Listing-single-area start -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
<!-- Popper JS -->
<script src="<?php echo e(asset('assets/js/popper.min.js')); ?>"></script>
<!-- Bootstrap JS -->
<script src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>
  <script>
    var visitor_store_url = "<?php echo e(route('frontend.store_visitor')); ?>";
    var car_id = "<?php echo e($car_id); ?>";
    
    function closeModal()
    {
        $('#financeModal').modal('hide')
    }
    
    function openDropdown(self)
    {
        $(self).closest('.card-body').find('.us_open_row').toggle('slow')
    }
    
     function openPopModal(self , price)
  {
      var type = 'Monthly Price';
      var text =  $(self).data("text")
    
      if(parseInt(price) < 5000)
      {
          var type = 'Weekly Price';
      }
      
      $('#eventTag').html(type)
      $('#textHTML').html(text)
      $('#financeModal').modal('show')
  }
  
  
     function copy(text, target) {
      setTimeout(function() {
      //$('#copied_tip').remove();
      }, 800);
      
        var input = document.createElement('input');
        input.setAttribute('value', text);
        document.body.appendChild(input);
        input.select();
        var result = document.execCommand('copy');
        document.body.removeChild(input)

      toastr["success"]("Ad Url copied successfully.")
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut ": 10000,
                "extendedTimeOut": 10000,
                "positionClass": "toast-top-right",
            }
            return result;
     
    }
    
    
    
  </script>
  <script src="<?php echo e(asset('assets/js/store-visitor.js')); ?>"></script>


  <script>
  setTimeout(()=>{
      function formatCurrency(number) {
    return '£' + new Intl.NumberFormat('en-GB', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(number);
    }
    $(".priceFormat").each(function(){
      var priceElement = $(this);
      var price = parseFloat(priceElement.data('price'))
       priceElement.text(formatCurrency(price))
    })
    },2000);
    

    document.addEventListener("DOMContentLoaded", function() 
    {
        
        const carDescription = document.getElementById('car-description');
        const readMoreBtn = document.getElementById('read-more');
        const readLessBtn = document.getElementById('read-less');
        const overflowFade = document.getElementById('over-flow-fade');
        readLessBtn.style.display = 'none';
        carDescription.classList.add('partial-description-min-height');
        overflowFade.classList.add('over-flow-fade')
        readMoreBtn.addEventListener('click', function() 
        {
          carDescription.classList.add('partial-description');
          carDescription.classList.remove('partial-description-min-height');
          overflowFade.classList.remove('over-flow-fade')
            readMoreBtn.style.display = 'none';
            readLessBtn.style.display = 'block';
        });
        readLessBtn.addEventListener('click', function() 
        {
          carDescription.classList.remove('partial-description');
            carDescription.classList.add('partial-description-min-height');
            overflowFade.classList.add('over-flow-fade')
            readMoreBtn.style.display = 'block';
            readLessBtn.style.display = 'none';
        });
    });


    function savePhoneView(car_id , self)
    {
        var phone = $(self).data("phone_number");
        console.log(phone)
      $.ajax({
                url: '<?php echo e(route("phone.reavel.count")); ?>',
                method: 'GET',
                data: {car_id : car_id },
                success: function (response) 
                {
                   $(self).html(phone)
                },
                error: function (xhr, status, error) 
                {
                    console.error(xhr.responseText);
                }
            });
    }

  

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("frontend.layouts.layout-v$version", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/car/details.blade.php ENDPATH**/ ?>