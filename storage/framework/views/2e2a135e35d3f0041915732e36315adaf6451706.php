<style>



.mainLogo img {
    width: 150px; 
    margin-right: 15px; 
} 

.search-bar-new {
    flex: 1;
    display: flex;
    align-items: center;
    padding-left: 6px;
}

.search-bar-new{
  width: 60px !important;
    padding-left: 70px !important;}
.search-form-new {
    display: flex;
    width: 100%;
    /* border: 1px solid red; */
    height: 40px;
    /* margin-left: 15px; */
}

.search-input-wrapper-new {
    display: flex;
    align-items: center;
    background-color: #F5F5F5; /* Gray background for the input field */
    /* border: 1px solid #ccc; */
    border-radius: 5px;
    padding: 4px 8px;
    width: 100%;
}

.search-icon {
    color: #5A5A5C; /* Gray color for the search icon */
    /* margin-right: 8px; */
    font-size: 14px;
    font-weight: lighter;
}

.search-input-new {
    border: none;
    background-color: transparent; /* Transparent background to match the wrapper */
    padding: 6px;
    flex: 1;
    outline: none;
    color: #5A5A5C; /* Text color */
    font-size: 14px;
}

.search-input-new::placeholder {
    color: #5A5A5C; /* Placeholder color */
}


.loginBtn{
  border: 1px solid #1D86F5;
  color:#1D86F5;
  border-radius:4px;
  width:70px;
  height:35px;
  padding: 5px;
} 

/* Responsive behavior */

@media (max-width: 1199px) {
  .search-bar-new {
    /* flex: 1; */
    display: flex;
    align-items: center;
    padding-left: 140px;
}
.search-bar-new{
  width: 40px !important;
    padding-left: 150px !important;}
    .search-input-new {
        font-size: 10px;
    }
  .search-form-new {
    width: 80%;
    /* border: 1px solid orange; */
  }

  .search-icon {
      font-size: 12px;
  }

  .search-input-new {
      font-size: 12px;
  }

  .loginBtn{
    width:55px;
    border-radius:3px;
    height:27px;
    padding: 2px;
  } 
  .dropdown-new{
    margin-left: -3rem;
  }


}
@media (max-width: 768px) {
  .search-bar-new {
    /* flex: 1; */
    display: flex;
    align-items: center;
    padding-left: 140px;
}
.search-bar-new{
  width: 40px !important;
    padding-left: 150px !important;}
    .search-input-new {
        font-size: 10px;
    }

    .search-icon {
        font-size: 10px;
    }

  .dropdown-new{
    margin-left: -3rem;
  }
}

@media (max-width: 575px) {
  
  .search-input-new{
    display: none;
  }
  .search-form-new {
    width: 0%;
    /* border: 1px solid orange; */
  }
  .search-input-wrapper-new {
    background-color: white;
  }
  
  .search-icon {
    font-size: 14px;
    font-weight: bold;
  }
  
  .loginLabel{
    display: none;
  }
  .dropdown-new{
    /* padding-top: 3rem; */
    margin-left: -9rem;
  }

  .search-bar-new{
    flex: 0;
  } 
  .mainLogo > img {
        width: 34%;
    }
    .us_username_mob {
        display: none !important;
    }
}





</style>







<?php if($basicInfo->whatsapp_status == 1): ?>
   <div class="whatsapp-popup" id="whatsappPopup">
        <div class="whatsapp-header">
            <span class="title">Message us</span>
            <span class="close" id="closePopup">×</span>
        </div>
        <div class="whatsapp-body">
            <div class="message">
                <strong><?php echo e($basicInfo->whatsapp_header_title); ?></strong><br>
                <?php echo nl2br($basicInfo->whatsapp_popup_message); ?>

            </div>
        </div>
        <div class="whatsapp-footer">
            <a href="https://api.whatsapp.com/send?phone=<?php echo e(preg_replace('/[^0-9]/', '', $basicInfo->whatsapp_number)); ?>&text=<?php echo nl2br($basicInfo->whatsapp_popup_message); ?>" target="_blank">
                <button class="start-chat">Start Chat</button>
            </a>
        </div>
    </div>
    
     <div class="whatsapp-button" id="whatsappButton">
        <img src="<?php echo e(asset('assets/img/whatsapp.svg')); ?>" alt="WhatsApp">
    </div>
    
<?php endif; ?>

<!-- Preloader end -->
<!-- <div class="request-loader">
  <img src="<?php echo e(asset('assets/img/loader.gif')); ?>" alt="loader">
</div> -->

<!-- Header-area start -->
<header class="header-area header-2 is-sticky" data-aos="">
  <!-- Start mobile menu -->
  
  <!-- End mobile menu -->
  
  <div class="main-navbar" >
    <div class="container custom-container">
      <nav class="navbar navbar-expand-lg">
        <!-- Logo -->
        <!-- <?php if(!empty($websiteInfo->logo)): ?> -->
          <a href="<?php echo e(route('index')); ?>" class="navbar-brand mainLogo">
            <img src="<?php echo e(asset('assets/img/66850560990ca.png')); ?>" 
            class="high-quality-logo" 
            alt="logo"> 
           <!-- to do ---> 
            <?php if(!empty(request()->category) && (request()->category == 'cars' || request()->category == 'cars-&-motors') ): ?>
            <span class="us_top_badges">Motor Mall</span>
            <?php endif; ?>
          </a>
        <!-- <?php endif; ?> -->

        <!-- <div class="item" data-toggle="modal" data-target="#topSearch" role="button">
            <i class="fal fa-search fa-lg"></i> <span class="hidemobile"> Search</span> </div> -->

      <div class="search-bar-new d-sm-block d-none" data-toggle="modal" data-target="#topSearch" role="button">
          <form class="search-form-new">
              <div class="search-input-wrapper-new ">
                  <i class="fa fa-search search-icon"></i> <!-- Search icon -->
                  <input type="text" class="search-input-new" placeholder="Search">
              </div>
          </form>
      </div>   
      
      
        
        <div class="collapse navbar-collapse">
          <?php $menuDatas = json_decode($menuInfos);  ?>
          <ul id="mainMenu" class="navbar-nav mobile-item mx-auto">
            <?php $__currentLoopData = $menuDatas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php $href = get_href($menuData); ?>
              <?php if(!property_exists($menuData, 'children')): ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo e($href); ?>"><?php echo e($menuData->text); ?></a>
                </li>
              <?php else: ?>
                <li class="nav-item">
                  <a class="nav-link toggle" href="<?php echo e($href); ?>"><?php echo e($menuData->text); ?><i
                      class="fal fa-plus"></i></a>
                  <ul class="menu-dropdown">
                    <?php $childMenuDatas = $menuData->children; ?>
                    <?php $__currentLoopData = $childMenuDatas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childMenuData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php $child_href = get_href($childMenuData); ?>
                      <li class="nav-item">
                        <a class="nav-link" href="<?php echo e($child_href); ?>"><?php echo e($childMenuData->text); ?></a>
                      </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
                </li>
              <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>

        <div class="more-option mobile-item">
        <div class="d-block d-sm-none pr-4 " data-toggle="modal" data-target="#topSearch" role="button">
      <i class="fa fa-search search-icon"></i>
      </div>
          <!-- <div class="item" data-toggle="modal" data-target="#topSearch" role="button">
            <i class="fal fa-search fa-lg"></i> <span class="hidemobile"> Search</span> </div> -->
          <div class="item">
            <div class="dropdown">
                 <a class="dropdown-item" href="<?php echo e(route('vendor.cars_management.create_car')); ?>"> 
                      <button class="btnCustom btn-primary  " type="button"  aria-expanded="false">
                            <?php echo e(__('Place Ad')); ?>

                      </button>
                 </a>
            </div>
          </div> 
          
          <div class="item">
              
              <?php if(!Auth::guard('vendor')->check() && !empty(session('dealer_loggedin'))): ?>
              
              <a class="dropdown-item" href="javascript:void(0);" onclick="open_drop_downdash()"> <i class="fal fa-user"></i> <?php echo e(session('dealer_loggedin')); ?> </a>
               
              <div style="position: absolute;background: white;border-radius: 5px;width: 10rem;padding: 0px 10px;margin-top: 1.5rem;display:none;" id="open_drop_downdash">
                     <p style="margin-top: 10px;" > <i class="fal fa-tachometer"></i><a class="topnavlabel" href="<?php echo e(env('SUBDOMAIN_APP_URL').'vendor/car-management?language=en&tab=publish'); ?>">Dashboard</a></p>
                   <p style="margin-top: 10px;margin-bottom: 10px;display: flex;" > <i style="padding-right: 1rem;" class="fal fa-user"></i>  <a style="color: black;position: relative;bottom: 5px;" class="dropdown-item" href="<?php echo e(route('expire_session')); ?>" > Logout </a> 
                   </p>
              </div>
              
              <?php else: ?>
              <label class = "loginLabel" >
                <?php if(!Auth::guard('vendor')->check()): ?>
                <a class="dropdown-item bg-white text-center loginBtn" href="<?php echo e(route('vendor.login')); ?>" onclick=""><?php echo e(__('Login')); ?> </a>
                <?php else: ?>
                <?php if(contactNotification(Auth::guard('vendor')->user()->id) > 0): ?> <span style="background-color:#dc3545 !important; color:#fff;" class="position-absolute top-0 start-100 translate-middle badgeTop rounded-pill bg-danger">
                <?php echo e(contactNotification(Auth::guard('vendor')->user()->id)); ?>

                <span class="visually-hidden">unread messages</span>
                </span><?php endif; ?>
                    <?php
                        $vendor_info = App\Models\VendorInfo::where('vendor_id', Auth::guard('vendor')->user()->id)               
                            ->first();
                            $arusernamer = explode(' ', trim($vendor_info->name));
                        ?>
                    <?php endif; ?>
              </label>
            <div class="dropdown dropdown-new">
              
              
              <ul class=" mt-3 mt-sm-1 dropdown-menu radius-sm text-transform-normal dropdown-menu-right">
                  
                <li class="topnavitem" onclick="window.location.href='<?php echo e(route('vendor.edit.profile')); ?>'" style="cursor: pointer;">
                    <i class="fal fa-user"></i>
                    <span style="padding-left: 5px;" class="topnavlabel"><?php echo e(__('Profile')); ?></span>
                </li>
                
                <li class="topnavitem" onclick="window.location.href='<?php echo e(route('vendor.car_management.car', ['language' => 'en'])); ?>'" style="cursor: pointer;">
                    <i class="far fa-file-alt"></i>
                    <span style="padding-left: 11px;" class="topnavlabel"><?php echo e(__('My Ads')); ?></span>
                </li>
                
                <li class="topnavitem" onclick="window.location.href='<?php echo e(route('vendor.support_tickets')); ?>'" style="cursor: pointer;">
                    <i class="fal fa-envelope"></i>
                    <span class="topnavlabel" style="padding-left: 5px;">
                        <?php echo e(__('Messages')); ?>

                        <?php if(Auth::guard('vendor')->check()): ?>  
                        <?php if(contactNotification(Auth::guard('vendor')->user()->id) > 0): ?> 
                            <span style="background-color:#dc3545 !important; color:#fff;" class="badge bg-danger rounded-pill">
                                <?php echo e(contactNotification(Auth::guard('vendor')->user()->id)); ?>

                            </span>
                        <?php endif; ?> 
                        <?php endif; ?>
                    </span>
                </li>
                
                <li class="topnavitem" onclick="window.location.href='<?php echo e(route('vendor.wishlist')); ?>'" style="cursor: pointer;">
                    <i class="fal fa-heart" style="color: #5c5c5c !important;font-size: 20px;"></i>
                    <span style="padding-left: 3px;" class="topnavlabel"><?php echo e(__('Saved Ads')); ?></span>
                </li>
                
                <li class="topnavitem" onclick="window.location.href='<?php echo e(route('vendor.save.searches')); ?>'" style="cursor: pointer;">
                    <i class="fal fa-star fa-lg" style="font-size: 17px;"></i>
                    <span style="padding-left: 5px;"><?php echo e(__('Saved Searches')); ?></span>
                </li>
                
                <li class="topnavitem" onclick="window.location.href='<?php echo e(route('vendor.recently.viewed')); ?>'" style="cursor: pointer;">
                    <i class="fal fa-history"></i>
                    <span style="padding-left: 5px;">Browsing History</span>
                </li>
                
                <li class="topnavitem" style="margin-bottom: 1rem; cursor: pointer;" onclick="window.location.href='<?php echo e(route('vendor.payment_log')); ?>'">
                    <i class="fal fa-money-bill"></i>
                    <span style="padding-left: 5px;"><?php echo e(__('Payment Logs')); ?></span>
                </li>
                
                <li class="topnavitem" style="margin-right: 1rem; margin-left: 1rem; border-top: 1px solid silver; padding-left: 0px; cursor: pointer;" onclick="window.location.href='help'">
                    <span style="padding-left: 5px;">Help</span>
                </li>
                
                <?php if(!Auth::guard('vendor')->check()): ?>
                <li class="topnavitem" style="cursor: pointer;" onclick="window.location.href='<?php echo e(route('vendor.login')); ?>'">
                    <span class="topnavlabel"><?php echo e(__('Login')); ?></span>
                </li>
                <?php else: ?>
                <li class="topnavitem" style="cursor: pointer;" onclick="window.location.href='<?php echo e(route('vendor.logout')); ?>'">
                    <span class="topnavlabel"><?php echo e(__('Logout')); ?></span>
                </li>
                <?php endif; ?>

              </ul> 
            </div>
            <?php endif; ?>
          </div>
          
          
          
          <?php if(!Auth::guard('vendor')->check()): ?>
                
                
                <?php else: ?>
                <?php if(contactNotification(Auth::guard('vendor')->user()->id) > 0): ?> <span style="background-color:#dc3545 !important; color:#fff;" class="position-absolute top-0 start-100 translate-middle badgeTop rounded-pill bg-danger">
                <?php echo e(contactNotification(Auth::guard('vendor')->user()->id)); ?>

                     <span class="visually-hidden">unread messages</span>
                </span><?php endif; ?>
                
                    <?php
                        $vendor_info = App\Models\VendorInfo::where('vendor_id', Auth::guard('vendor')->user()->id)               
                        ->first();
                        $arusernamer = explode(' ', trim($vendor_info->name));
                        
                        $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . Auth::guard('vendor')->user()->photo;
                        
                        if (file_exists(public_path('assets/admin/img/vendor-photo/' . Auth::guard('vendor')->user()->photo))) 
                        {
                            $photoUrl = asset('assets/admin/img/vendor-photo/' . Auth::guard('vendor')->user()->photo);
                        }
                        
                        if(empty(Auth::guard('vendor')->user()->photo))
                        {
                              $photoUrl = asset('assets/img/blank-user.jpg');
                        }
                        
                    ?>
                  
                    
                  <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> 
                 <img src="<?php echo e($photoUrl); ?>" style="width: 35px;height: 35px;border-radius: 50%;border: 1px solid gray;" alt="..."  class="uploaded-img us_object_fit">
                 <span class="us_username_mob" style="font-size:17px; color: #949494; font-weight:300;">
                     <?php echo e(substr($arusernamer[0] , 0, 4)); ?>...
                 </span>
                 
                 
                  <span class="us_username_deks" style="font-size:17px; color: #949494; font-weight:300;">
                     <?php echo e($arusernamer[0]); ?>

                 </span>
                  
                 </a>
                
                <?php endif; ?>
                
                
              <?php if(!Auth::guard('vendor')->check() && empty(session('dealer_loggedin'))): ?>
              <button class="menu-toggler"  data-bs-toggle="dropdown"
                aria-expanded="false" type="button">
                <span></span>
                <span></span>
                <span></span>
              </button>
              <?php endif; ?>
         
          
        </div>
      </nav>
    </div>
  </div>
</header>
<!-- Header-area end -->
<?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/partials/header/header-v2.blade.php ENDPATH**/ ?>