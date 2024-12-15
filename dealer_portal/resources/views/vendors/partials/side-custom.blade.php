<div class="col-lg-3 sidebar22">
 <aside class="widget-area mb-40">
    <div class="widget rounded-2">
      <ul class="links">
        
        {{-- dashboard --}}
        <li class=" @if (request()->routeIs('vendor.dashboard')) active @endif">
          <a href="{{ route('vendor.dashboard') }}" class="link-dark">
           
           {{ __('Dashboard') }}
          </a>
        </li>

        <li class=" {{ request()->routeIs('vendor.cars_management.create_car') ? 'active' : '' }}">
          <a href="{{ route('vendor.cars_management.create_car', ['language' => $defaultLang->code]) }}" class="link-dark">
            
            {{ __('Place an Ad') }}
          </a>
        </li>

        <li
          class=" @if (request()->routeIs('vendor.car_management.car')) active  
            @elseif (request()->routeIs('vendor.cars_management.edit_car')) active @endif">
          <a href="{{ route('vendor.car_management.car', ['language' => $defaultLang->code , 'tab' => 'publish']) }}" class="link-dark">
           
            {{ __('Manage Ads') }}
          </a>
        </li>

        @php
          $support_status = DB::table('support_ticket_statuses')->first();
        @endphp
        @if ($support_status->support_ticket_status == 'active')
          {{-- Support Ticket --}}
       
          <li class="{{ request()->routeIs('vendor.support_ticket') ? 'active' : '' }}">
                  <a href="{{ route('vendor.support_tickets') }}" class="link-dark">
                    <span class="sub-item">{{ __('Messages') }}</span>
                  </a>
                </li>
        @endif
        {{-- dashboard --}}

        <li class="nav-item @if (request()->routeIs('vendor.payment_log')) active @endif">
          <a href="{{ route('vendor.payment_log') }}" class="link-dark">
                Invoices
          </a>
        </li>
        
        <!--<li class="nav-item @if (request()->routeIs('vendor.wishlist')) active @endif">-->
        <!--  <a href="{{ route('vendor.wishlist') }}" class="link-dark">-->
            
        <!--    {{ __('Saved Ads') }}-->
        <!--  </a>-->
        <!--</li>-->
        <li class="nav-item @if (request()->routeIs('vendor.edit.profile')) active @endif">
          <a href="{{ route('vendor.edit.profile') }}" class="link-dark">
            
            {{ __('Edit Profile') }}
          </a>
        </li>
        <li class="nav-item @if (request()->routeIs('vendor.change_password')) active @endif">
          <a href="{{ route('vendor.change_password') }}" class="link-dark">
           
           {{ __('Change Password') }}
          </a>
        </li>

        <li class="nav-item @if (request()->routeIs('vendor.logout')) active @endif">
          <a href="{{ route('vendor.logout') }}" class="link-dark">
          
            {{ __('Logout') }}
          </a>
        </li>
        </ul>
    
  </aside>
  </div>