@if ($basicInfo->preloader_status == 1)
  <div id="preLoader">
        <img src="{{ asset('assets/img/' . $basicInfo->preloader) }}?v=0.3" alt="">
  </div>
@endif

@if($basicInfo->whatsapp_status == 1)
   <div class="whatsapp-popup" id="whatsappPopup">
        <div class="whatsapp-header">
            <span class="title">Message us</span>
            <span class="close" id="closePopup">×</span>
        </div>
        <div class="whatsapp-body">
            <div class="message">
                <strong>{{ $basicInfo->whatsapp_header_title }}</strong><br>
                {!! nl2br($basicInfo->whatsapp_popup_message) !!}
            </div>
        </div>
        <div class="whatsapp-footer">
            <a href="https://api.whatsapp.com/send?phone={{ preg_replace('/[^0-9]/', '', $basicInfo->whatsapp_number) }}&text={!! nl2br($basicInfo->whatsapp_popup_message) !!}" target="_blank">
                <button class="start-chat">Start Chat</button>
            </a>
        </div>
    </div>
    
     <div class="whatsapp-button" id="whatsappButton">
        <img src="{{ asset('assets/img/whatsapp.svg') }}" alt="WhatsApp">
    </div>
    
@endif

<!-- Preloader end -->
<div class="request-loader">
  <img src="{{ asset('assets/img/loader.gif') }}" alt="loader">
</div>

<!-- Header-area start -->
<header class="header-area header-2 is-sticky" data-aos="slide-down">
  <!-- Start mobile menu -->
  
  <!-- End mobile menu -->

  <div class="main-navbar" >
    <div class="container custom-container">
      <nav class="navbar navbar-expand-lg">
        <!-- Logo -->
        @if (!empty($websiteInfo->logo))
          <a href="{{ route('index') }}" class="navbar-brand mainLogo">
            <img src="{{ asset('assets/img/' . $websiteInfo->logo) }}" alt="logo"> 
            
            @if(!empty(request()->category) && (request()->category == 'cars' || request()->category == 'cars-&-motors') )
            <span class="us_top_badges">Motor Mall</span>
            @endif
          </a>
        @endif
      
        
        <div class="collapse navbar-collapse">
          @php $menuDatas = json_decode($menuInfos);  @endphp
          <ul id="mainMenu" class="navbar-nav mobile-item mx-auto">
            @foreach ($menuDatas as $menuData)
              @php $href = get_href($menuData); @endphp
              @if (!property_exists($menuData, 'children'))
                <li class="nav-item">
                  <a class="nav-link" href="{{ $href }}">{{ $menuData->text }}</a>
                </li>
              @else
                <li class="nav-item">
                  <a class="nav-link toggle" href="{{ $href }}">{{ $menuData->text }}<i
                      class="fal fa-plus"></i></a>
                  <ul class="menu-dropdown">
                    @php $childMenuDatas = $menuData->children; @endphp
                    @foreach ($childMenuDatas as $childMenuData)
                      @php $child_href = get_href($childMenuData); @endphp
                      <li class="nav-item">
                        <a class="nav-link" href="{{ $child_href }}">{{ $childMenuData->text }}</a>
                      </li>
                    @endforeach
                  </ul>
                </li>
              @endif
            @endforeach
          </ul>
        </div>

        <div class="more-option mobile-item">
      
          <div class="item" data-toggle="modal" data-target="#topSearch" role="button">
            <i class="fal fa-search fa-lg"></i> <span class="hidemobile"> Search</span> </div>
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
              
              @if(!Auth::guard('vendor')->check() && !empty(session('dealer_loggedin')))
              
              <a class="dropdown-item" href="javascript:void(0);" onclick="open_drop_downdash()"> <i class="fal fa-user"></i> {{ session('dealer_loggedin') }} </a>
               
              <div style="position: absolute;background: white;border-radius: 5px;width: 10rem;padding: 0px 10px;margin-top: 1.5rem;display:none;" id="open_drop_downdash">
                     <p style="margin-top: 10px;" > <i class="fal fa-tachometer"></i><a class="topnavlabel" href="{{ env('SUBDOMAIN_APP_URL').'vendor/car-management?language=en&tab=publish' }}">Dashboard</a></p>
                   <p style="margin-top: 10px;margin-bottom: 10px;display: flex;" > <i style="padding-right: 1rem;" class="fal fa-user"></i>  <a style="color: black;position: relative;bottom: 5px;" class="dropdown-item" href="{{route('expire_session')}}" > Logout </a> 
                   </p>
              </div>
              
              @else
              <label class = "loginLabel" >
                @if (!Auth::guard('vendor')->check())
                <a class="dropdown-item" href="{{ route('vendor.login') }}" onclick="">{{ __('Login2') }} </a>
                @else
                @if(contactNotification(Auth::guard('vendor')->user()->id) > 0) <span style="background-color:#dc3545 !important; color:#fff;" class="position-absolute top-0 start-100 translate-middle badgeTop rounded-pill bg-danger">
                {{contactNotification(Auth::guard('vendor')->user()->id)}}
                <span class="visually-hidden">unread messages</span>
                </span>@endif
                    @php
                        $vendor_info = App\Models\VendorInfo::where('vendor_id', Auth::guard('vendor')->user()->id)               
                            ->first();
                            $arusernamer = explode(' ', trim($vendor_info->name));
                        @endphp
                    @endif
              </label>
            <div class="dropdown">
              
              
              <ul class="dropdown-menu radius-sm text-transform-normal dropdown-menu-right">
                  
                <li class="topnavitem" onclick="window.location.href='{{ route('vendor.edit.profile') }}'" style="cursor: pointer;">
                    <i class="fal fa-user"></i>
                    <span style="padding-left: 5px;" class="topnavlabel">{{ __('Profile') }}</span>
                </li>
                
                <li class="topnavitem" onclick="window.location.href='{{ route('vendor.car_management.car', ['language' => 'en']) }}'" style="cursor: pointer;">
                    <i class="far fa-file-alt"></i>
                    <span style="padding-left: 11px;" class="topnavlabel">{{ __('My Ads') }}</span>
                </li>
                
                <li class="topnavitem" onclick="window.location.href='{{ route('vendor.support_tickets') }}'" style="cursor: pointer;">
                    <i class="fal fa-envelope"></i>
                    <span class="topnavlabel" style="padding-left: 5px;">
                        {{ __('Messages') }}
                        @if (Auth::guard('vendor')->check())  
                        @if(contactNotification(Auth::guard('vendor')->user()->id) > 0) 
                            <span style="background-color:#dc3545 !important; color:#fff;" class="badge bg-danger rounded-pill">
                                {{contactNotification(Auth::guard('vendor')->user()->id)}}
                            </span>
                        @endif 
                        @endif
                    </span>
                </li>
                
                <li class="topnavitem" onclick="window.location.href='{{ route('vendor.wishlist') }}'" style="cursor: pointer;">
                    <i class="fal fa-heart" style="color: #5c5c5c !important;font-size: 20px;"></i>
                    <span style="padding-left: 3px;" class="topnavlabel">{{ __('Saved Ads') }}</span>
                </li>
                
                <li class="topnavitem" onclick="window.location.href='{{ route('vendor.save.searches') }}'" style="cursor: pointer;">
                    <i class="fal fa-star fa-lg" style="font-size: 17px;"></i>
                    <span style="padding-left: 5px;">{{ __('Saved Searches') }}</span>
                </li>
                
                <li class="topnavitem" onclick="window.location.href='{{ route('vendor.recently.viewed') }}'" style="cursor: pointer;">
                    <i class="fal fa-history"></i>
                    <span style="padding-left: 5px;">Browsing History</span>
                </li>
                
                <li class="topnavitem" style="margin-bottom: 1rem; cursor: pointer;" onclick="window.location.href='{{ route('vendor.payment_log') }}'">
                    <i class="fal fa-money-bill"></i>
                    <span style="padding-left: 5px;">{{ __('Payment Logs') }}</span>
                </li>
                
                <li class="topnavitem" style="margin-right: 1rem; margin-left: 1rem; border-top: 1px solid silver; padding-left: 0px; cursor: pointer;" onclick="window.location.href='help'">
                    <span style="padding-left: 5px;">Help</span>
                </li>
                
                @if (!Auth::guard('vendor')->check())
                <li class="topnavitem" style="cursor: pointer;" onclick="window.location.href='{{ route('vendor.login') }}'">
                    <span class="topnavlabel">{{ __('Login2') }}</span>
                </li>
                @else
                <li class="topnavitem" style="cursor: pointer;" onclick="window.location.href='{{ route('vendor.logout') }}'">
                    <span class="topnavlabel">{{ __('Logout') }}</span>
                </li>
                @endif

              </ul> 
            </div>
            @endif
          </div>
          
          
          
          @if (!Auth::guard('vendor')->check())
                
                
                @else
                @if(contactNotification(Auth::guard('vendor')->user()->id) > 0) <span style="background-color:#dc3545 !important; color:#fff;" class="position-absolute top-0 start-100 translate-middle badgeTop rounded-pill bg-danger">
                {{contactNotification(Auth::guard('vendor')->user()->id)}}
                     <span class="visually-hidden">unread messages</span>
                </span>@endif
                
                    @php
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
                        
                    @endphp
                  
                    
                  <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> 
                 <img src="{{ $photoUrl }}" style="width: 35px;height: 35px;border-radius: 50%;border: 1px solid gray;" alt="..."  class="uploaded-img us_object_fit">
                 <span class="us_username_mob" style="font-size:17px; color: #949494; font-weight:300;">
                     {{   substr($arusernamer[0] , 0, 4) }}...
                 </span>
                 
                 
                  <span class="us_username_deks" style="font-size:17px; color: #949494; font-weight:300;">
                     {{ $arusernamer[0]  }}
                 </span>
                  
                 </a>
                
                @endif
                
                
              @if(!Auth::guard('vendor')->check() && empty(session('dealer_loggedin')))
              <button class="menu-toggler"  data-bs-toggle="dropdown"
                aria-expanded="false" type="button">
                <span></span>
                <span></span>
                <span></span>
              </button>
              @endif
         
          
        </div>
      </nav>
    </div>
  </div>
</header>
<!-- Header-area end -->
