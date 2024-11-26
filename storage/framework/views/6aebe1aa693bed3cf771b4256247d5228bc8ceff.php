<div class="col-lg-3 sidebar22">
 <aside class="widget-area mb-40">
    <div class="widget radius-md">
      <ul class="links">
        
        
        <!--<li class=" <?php if(request()->routeIs('vendor.dashboard')): ?> active <?php endif; ?>">-->
        <!--  <a href="<?php echo e(route('vendor.dashboard')); ?>">-->
           
        <!--   <?php echo e(__('Dashboard')); ?>-->
        <!--  </a>-->
        <!--</li>-->

        <li class=" <?php echo e(request()->routeIs('vendor.cars_management.create_car') ? 'active' : ''); ?>">
          <a href="<?php echo e(route('vendor.cars_management.create_car', ['language' => $defaultLang->code])); ?>">
            
            <?php echo e(__('Place an Ad')); ?>

          </a>
        </li>

        <li
          class=" <?php if(request()->routeIs('vendor.car_management.car')): ?> active  
            <?php elseif(request()->routeIs('vendor.cars_management.edit_car')): ?> active <?php endif; ?>">
          <a href="<?php echo e(route('vendor.car_management.car', ['language' => $defaultLang->code])); ?>">
           
            <?php echo e(__('Manage Ads')); ?>

          </a>
        </li>

        <?php
          $support_status = DB::table('support_ticket_statuses')->first();
        ?>
        <?php if($support_status->support_ticket_status == 'active'): ?>
          
         <!--  <li
            class="<?php if(request()->routeIs('vendor.support_tickets')): ?> active
            <?php elseif(request()->routeIs('vendor.support_tickets.message')): ?> active
            <?php elseif(request()->routeIs('vendor.support_ticket.create')): ?> active <?php endif; ?>">
            <a data-toggle="collapse" href="#support_ticket">
            
              <?php echo e(__('Support Tickets')); ?>

              <span class="caret"></span>
            </a>

            <div id="support_ticket"
              class="collapse
              <?php if(request()->routeIs('vendor.support_tickets')): ?> show
              <?php elseif(request()->routeIs('vendor.support_tickets.message')): ?> show
              <?php elseif(request()->routeIs('vendor.support_ticket.create')): ?> show <?php endif; ?>">
              <ul class="nav nav-collapse">

                <li
                  class="<?php echo e(request()->routeIs('vendor.support_tickets') && empty(request()->input('status')) ? 'active' : ''); ?>">
                  <a href="<?php echo e(route('vendor.support_tickets')); ?>">
                    <span class="sub-item"><?php echo e(__('All Tickets')); ?></span>
                  </a>
                </li>
                <li class="<?php echo e(request()->routeIs('vendor.support_ticket.create') ? 'active' : ''); ?>">
                  <a href="<?php echo e(route('vendor.support_ticket.create')); ?>">
                    <span class="sub-item"><?php echo e(__('Add a Ticket')); ?></span>
                  </a>
                </li>
              </ul>
            </div>
          </li> -->
          <li class="<?php echo e(request()->routeIs('vendor.support_ticket') ? 'active' : ''); ?>">
                  <a href="<?php echo e(route('vendor.support_tickets')); ?>">
                    <span class="sub-item"><?php echo e(__('Messages')); ?></span> <?php if(contactNotification(Auth::guard('vendor')->user()->id) > 0): ?> <span style="background-color:#dc3545 !important; color:#fff;" class="badge bg-danger rounded-pill"><?php echo e(contactNotification(Auth::guard('vendor')->user()->id)); ?></span><?php endif; ?>
                  </a>
                  
                </li>
        <?php endif; ?>
        

        <?php if(Session::get('is_dealer')==1): ?>
        <li
          class="nav-item 
        <?php if(request()->routeIs('vendor.plan.extend.index')): ?> active 
        <?php elseif(request()->routeIs('vendor.plan.extend.checkout')): ?> active <?php endif; ?>">
          <a href="<?php echo e(route('vendor.plan.extend.index')); ?>">
          
            <?php echo e(__('Buy Plan')); ?>

          </a>
        </li>

        <li class="nav-item <?php if(request()->routeIs('vendor.payment_log')): ?> active <?php endif; ?>">
          <a href="<?php echo e(route('vendor.payment_log')); ?>">
            
            <?php echo e(__('Payment Logs')); ?>

          </a>
        </li>
        <?php endif; ?>
        <li class="nav-item <?php if(request()->routeIs('vendor.wishlist')): ?> active <?php endif; ?>">
          <a href="<?php echo e(route('vendor.wishlist')); ?>">
            
            <?php echo e(__('Saved Ads')); ?>

          </a>
        </li>
        <li class="nav-item <?php if(request()->routeIs('vendor.payment_log')): ?> active <?php endif; ?>">
          <a href="<?php echo e(route('vendor.recently.viewed')); ?>">
            
            Browsing History
          </a>
        </li>
        <li class="nav-item <?php if(request()->routeIs('vendor.payment_log')): ?> active <?php endif; ?>">
          <a href="<?php echo e(route('vendor.payment_log')); ?>">
            
            <?php echo e(__('Paymemt History')); ?>

          </a>
        </li>
        <li class="nav-item <?php if(request()->routeIs('vendor.edit.profile')): ?> active <?php endif; ?>">
          <a href="<?php echo e(route('vendor.edit.profile')); ?>">
            
            <?php echo e(__('Edit Profile')); ?>

          </a>
        </li>
       <!--  <li class="nav-item <?php if(request()->routeIs('vendor.change_password')): ?> active <?php endif; ?>">
          <a href="<?php echo e(route('vendor.change_password')); ?>">
           
           <?php echo e(__('Change Password')); ?>

          </a>
        </li> -->

        <li class="nav-item <?php if(request()->routeIs('vendor.logout')): ?> active <?php endif; ?>">
          <a href="<?php echo e(route('vendor.logout')); ?>">
          
            <?php echo e(__('Logout')); ?>

          </a>
        </li>
        </ul>
    
  </aside>
  </div><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/vendors/partials/side-custom.blade.php ENDPATH**/ ?>