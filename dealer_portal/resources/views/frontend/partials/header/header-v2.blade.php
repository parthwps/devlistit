@if ($basicInfo->preloader_status == 11)
  <!-- Preloader start -->
  <div id="preLoader">
    <img src="{{ asset('assets/img/' . $basicInfo->preloader) }}" alt="">
  </div>
@endif

<style>
    .footer-area .footer-widget h4 {
    text-transform: capitalize;
    margin-bottom: 25px;
    font-size: 18px !important;
    font-weight: 500;
}
</style>
<!-- Preloader end -->
<div class="request-loader">
  <img src="{{ asset('assets/img/loader.gif') }}" alt="loader">
</div>

<!-- Header-area start -->
<header class="header-area header-2 is-sticky">
  <!-- Start mobile menu -->
  <div class="mobile-menu">
    <div class="container">
      <div class="mobile-menu-wrapper"></div>
    </div>
  </div>
  <!-- End mobile menu -->

  <div class="main-responsive-nav">
    <div class="container">
      <!-- Mobile Logo -->
      <div class="logo">
        @if (!empty(getSetVal('dealer_logo')))
          <a href="javascript:void(0);">
            <img style="height: 70px;" src="{{ env('HOME_URL').'assets/img/' . getSetVal('dealer_logo') }} " alt="dealer_logo">
          </a>
        @endif
      </div>
      <!-- Menu toggle button -->
      <button class="menu-toggler" type="button">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>
  </div>

  <div class="main-navbar" style="padding:1rem; display:block !important;" >
    <div class="container-xxl custom-container">
      <nav class="navbar navbar-expand-lg" id="navbar_main">
        <!-- Logo -->
        @if (!empty(getSetVal('dealer_logo')))
          <a  href="javascript:void(0);" class="navbar-brand" >
            <img style="height: 70px;" src="{{ env('HOME_URL').'assets/img/' . getSetVal('dealer_logo') }}" alt="dealer_logo" class="us_logo">
          </a>
        @endif

        <!-- Navigation items -->
        <div class="collapse navbar-collapse">
         
        </div>

        <div class="more-option mobile-item">
         <div class="item" data-toggle="modal" data-target="#topSearch" role="button">
            </div>
          <div class="item">
            <div class="dropdown">
                 <a class="dropdown-item" href="{{ route('vendor.cars_management.create_car') }}"> 
                      <button class="btnCustom btn-primary  " type="button"  aria-expanded="false">
                            {{ __('Place Ad') }}
                      </button>
                 </a>
            </div>
          </div> 
         
          <div class="item">
               @if (!Auth::guard('vendor')->check())
              <div class="d-flex">
                    <a class="dropdown-item us_drop_item" href="{{ route('vendor.login') }}">  Login <i style="    margin-left: 0.3rem;" class="fa fa-list" aria-hidden="true"></i>  </a>
              </div>
               @else
            <div class="dropdown">
                
            <button class="btn btn-outline btn-md radius-sm dropdown-toggle us_toggle_btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-weight: bold;font-size: 17px;">
               @php
                        $vendor_info = App\Models\VendorInfo::where('vendor_id', Auth::guard('vendor')->user()->id)               
                        ->first();
                        $arusernamer = explode(' ', trim($vendor_info->name));
                        
                        $photoUrl = env('HOME_URL').'assets/admin/img/vendor-photo/' . Auth::guard('vendor')->user()->photo;
                        
                        if (file_exists(public_path('assets/admin/img/vendor-photo/' . Auth::guard('vendor')->user()->photo))) 
                        {
                            $photoUrl = asset('assets/admin/img/vendor-photo/' . Auth::guard('vendor')->user()->photo);
                        }
                        
                        if(empty(Auth::guard('vendor')->user()->photo))
                        {
                              $photoUrl = asset('assets/img/blank-user.jpg');
                        }
                        
                    
                    @endphp
                    
                     <img src="{{ $photoUrl }}" style="width: 35px;height: 35px;border-radius: 50%;border: 1px solid #525252;" alt="..."  class="uploaded-img us_object_fit">
                     
                <span id="username-display">
                  
                     
                    {{ Auth::guard('vendor')->user()->username }}
                </span>
            
            </button>
              
          <ul class="dropdown-menu radius-sm text-transform-normal us_normal_drop">
    @if (!Auth::guard('vendor')->check())
    <li><a class="dropdown-item" href="{{ route('vendor.login') }}"><i class="fa fa-sign-in-alt"></i> {{ __('Login') }}</a></li>
    <li><a class="dropdown-item" href="{{ route('vendor.signup') }}"><i class="fa fa-user-plus"></i> {{ __('Signup') }}</a></li>
    @else

    @if(Auth::guard('vendor')->check() && Auth::guard('vendor')->user()->vendor_type == 'dealer')

    <li>
        <a class="dropdown-item" style="color:#525252;" href="{{ route('vendor.car_management.myads', ['language' => 'en' , 'tab' => 'all-ads']) }}">
            <i class="fa fa-list" style="margin-right: 10px;"></i> My Ads
        </a>
    </li>
    <li>
        <a class="dropdown-item"  style="color:#525252;" href="{{ route('vendor.car_management.enquiry.preferences') }}">
            <i class="fa fa-user-plus" style="margin-right: 10px;" ></i> {{ __('Add User') }}
        </a>
    </li>

    <li>
        <a class="dropdown-item"  style="color:#525252;" href="javascript:void(0);" onclick="myaccount()">
            <i class="fa fa-user" style="margin-right: 10px;"></i> My Account
        </a>
    </li>

    <!--<li>-->
    <!--    <a class="dropdown-item" href="javascript:void(0);" onclick="buyExtra()">-->
    <!--        <i class="fa fa-cart-plus"></i> Buy Extras-->
    <!--    </a>-->
    <!--</li>-->

    <li>
        <a class="dropdown-item"  style="color:#525252;" href="javascript:void(0);" onclick="addBnneraccount()">
            <i class="fa fa-image" style="margin-right: 10px;"></i> Main banner
        </a>
    </li>

    <!--<li>-->
    <!--    <a class="dropdown-item" href="{{ route('vendor.wishlist') }}">-->
    <!--        <i class="fa fa-bookmark"></i> {{ __('Saved Ads') }}-->
    <!--    </a>-->
    <!--</li>-->

    <li>
        <a class="dropdown-item"  style="color:#525252;" href="{{ route('vendor.support_tickets') }}">
            <i class="fa fa-envelope" style="margin-right: 10px;"></i> Messages
        </a>
    </li>
    @else
    <li>
        <a class="dropdown-item"  style="color:#525252;" href="{{ route('vendor.dashboard') }}">
            <i class="fa fa-tachometer-alt" style="margin-right: 10px;"></i> {{ __('Dashboard') }}
        </a>
    </li>
    @endif

    <li>
        <a class="dropdown-item"  style="color:#525252;" href="{{ route('vendor.car_management.dealerAnalytics') }}">
            <i class="fa fa-chart-line" style="margin-right: 10px;"></i> My Analytics
        </a>
    </li>

    <!--<li>-->
    <!--    <a class="dropdown-item" href="{{ route('frontend.vendors') }}">-->
    <!--        <i class="fa fa-search"></i> Find a dealer-->
    <!--    </a>-->
    <!--</li>-->

    <li>
        <a class="dropdown-item"  style="color:#525252;" href="{{ route('vendor.payment_log') }}">
            <i class="fa fa-tag" style="margin-right: 10px;"></i> Invoices
        </a>
    </li>

    <!--<li>-->
    <!--    <a class="dropdown-item" href="javascript:void(0);" onclick="checkVehiclehistory()">-->
    <!--        <i class="fa fa-history"></i> {{ __('History') }}-->
    <!--    </a>-->
    <!--</li>-->
    
    <li>
       <hr style="margin-top: 7px;margin-bottom: 7px;border: 1px solid #d3d3d3;">
    </li>

    <li>
        <a class="dropdown-item"  style="color:#525252;" href="{{ route('vendor.edit.profile') }}">
            <i class="fa fa-edit" style="margin-right: 10px;" ></i> Edit profile
        </a>
    </li>

    <li>
        <a class="dropdown-item"  style="color:#525252;" href="{{ route('vendor.logout') }}">
            <i class="fa fa-sign-out-alt" style="margin-right: 10px;"></i> {{ __('Logout') }}
        </a>
    </li>
    @endif
</ul>

              
            </div>
            @endif
          </div>
      
          
        </div>
      </nav>
    </div>
  </div>
</header>
<!-- Header-area end -->