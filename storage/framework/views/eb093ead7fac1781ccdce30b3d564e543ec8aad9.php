  <style>
.social-link {
  display: inline-block;
  margin: 0 10px;
}

.social-icon-new {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 50px;
  height: 50px;
  border-radius: 50%; /* Makes the icon round */
  background-color: white; /* White background */
  color: #007bff; /* Blue color for the icon */
  text-decoration: none;
  font-size: 18px; /* Adjust icon size */
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Optional shadow for better design */
  transition: background-color 0.3s ease, color 0.3s ease;
}

.social-icon-new:hover {
  background-color: #007bff; /* Blue background on hover */
  color: white; /* White icon color on hover */
}
.customFooteremail{
  border-radius: 120px;
  padding: 25px !important;
  height: 40px !important;
  width: 100%;
  border: 2px solid transparent;
}
.customFooteremailBtn
{border-radius: 100%; 
  /* width: 30px;
  height: 30px; */
}
.form-group, .form-check {
    margin-bottom: 0;
    padding: 0px !important;
}
.footer-area .newsletter-form .btn {
  top: 7.5px !important;
    right: 8px !important;
    height: 40px !important;
    width: 40px !important;
    position: absolute !important;
}
@media (max-width: 768px) {

  .social-link i {
    margin-top: 6px;
  } 
}

@media (max-width: 575px) {

  .footer-row{
    margin: 0px !important;
  }  
}



  </style>
  
  <!-- Footer-area start -->
  <?php if($footerSectionStatus == 1): ?>

    <footer class="footer-area bg-img" style="background-color:#001334">
      <div class="overlays opacity-70"></div>
      <div class="footer-top pt-70 pb-50">
        <div class="container-fluid">
          <div class="row justify-content-between m-4 footer-row">
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12">
              <div class="footer-widget" data-aos="">
                <div class="navbar-brand">
                  <?php if(!empty($basicInfo->footer_logo)): ?>
                    <a href="<?php echo e(route('index')); ?>">
                      <img src="<?php echo e(asset('assets/img/' . $basicInfo->footer_logo)); ?>" alt="Logo" style="width:150px;height:auto;">
                    </a>
                  <?php endif; ?>
                </div>
                <p class="p-2"><?php echo e(!empty($footerInfo) ? $footerInfo->about_company : ''); ?></p>
                <div class="social-link">
                  <!-- <?php if(count($socialMediaInfos) > 0): ?>
                    <?php $__currentLoopData = $socialMediaInfos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $socialMediaInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <a href="<?php echo e($socialMediaInfo->url); ?>" target="_blank"><i
                          class="<?php echo e($socialMediaInfo->icon); ?>"></i></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?> -->
                  <a href="<?php echo e($socialMediaInfo->url); ?>" target="_blank" class="social-icon-new"><i
                          class="<?php echo e($socialMediaInfo->icon); ?>"></i>
                  </a>
                   <!-- LinkedIn -->
                  <a href="#" target="_blank" class="social-icon-new">
                    <i class="fab fa-linkedin"></i>
                  </a>

                  <!-- Twitter -->
                  <a href="#" target="_blank" class="social-icon-new">
                    <i class="fab fa-twitter"></i>
                  </a>
                </div>
              </div>
            </div> 
            <div class="col-xl-2 col-lg-3 col-md-3 col-sm-5">
              <div class="footer-widget" data-aos="">
                <h4 style="font-size: 17px !important;font-weight:bold"><?php echo e(__('Explore')); ?></h4>
                <?php if(count($quickLinkInfos) == 0): ?>
                  <h6 class="text-light"><?php echo e(__('No Link Found') . '!'); ?></h6>
                <?php else: ?>
                  <ul class="footer-links">
                    <?php $__currentLoopData = $quickLinkInfos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quickLinkInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if($quickLinkInfo->section == 'explore'): ?>
                      <li>
                        <a href="<?php echo e($quickLinkInfo->url); ?>"><?php echo e($quickLinkInfo->title); ?></a>
                      </li>
                      <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
                <?php endif; ?>
              </div>
            </div>
            <div class="col-xl-2 col-lg-4 col-md-3 col-sm-5">
              <div class="footer-widget" data-aos="">
                <h4 style="font-size: 17px !important;font-weight:bold"><?php echo e(__('Customer Satisfaction')); ?></h4>
                <?php if(count($quickLinkInfos) == 0): ?>
                  <h6 class="text-light"><?php echo e(__('No Link Found') . '!'); ?></h6>
                <?php else: ?>
                  <ul class="footer-links">
                    <?php $__currentLoopData = $quickLinkInfos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quickLinkInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($quickLinkInfo->section == 'customer'): ?>
                      <li>
                        <a href="<?php echo e($quickLinkInfo->url); ?>"><?php echo e($quickLinkInfo->title); ?></a>
                      </li>
                      <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
                <?php endif; ?>
              </div>
            </div>
             <div class="col-xl-2 col-lg-3 col-md-5 col-sm-5">
              <div class="footer-widget" data-aos="">
              <h4 style="font-size: 17px !important;font-weight:bold"><?php echo e(__('Contact Us')); ?></h4>
                <ul class="info-list mb-4">
                    <li>
                      <i class="fal fa-map-marker-alt"></i>
                      <?php if(!empty($basicInfo->address)): ?>
                        <span><?php echo e($basicInfo->address); ?></span>
                      <?php endif; ?>
                    </li>
                    <?php if(!empty($basicInfo->contact_number)): ?>
                      <li>
                        <i class="fal fa-phone-plus"></i>
                        <a href="tel:<?php echo e($basicInfo->contact_number); ?>"><?php echo e($basicInfo->contact_number); ?></a>
                      </li>
                    <?php endif; ?>
                    <?php if(!empty($basicInfo->email_address)): ?>
                      <li>
                        <i class="fal fa-envelope"></i>
                        <a href="mailto:<?php echo e($basicInfo->email_address); ?>"><?php echo e($basicInfo->email_address); ?></a>
                      </li>
                    <?php endif; ?>
                  </ul>
              </div>
            </div> 
            <div class="col-xl-3 col-lg-6 col-md-7 col-sm-5">
              <div class="footer-widget" data-aos="">
              <h4 style="font-size: 17px !important;font-weight:bold" ><?php echo e(__('Subscribe')); ?></h4>
                <p class="lh-1 mb-20"><?php echo e(__('Subscribe and stay up to date with our latest news and events') . '!'); ?></p>
                <div class="newsletter-form">
                  <form id="newsletterForm" class="subscription-form" action="<?php echo e(route('store_subscriber')); ?>"
                    method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                      <input  class="form-control customFooteremail" placeholder="<?php echo e(__('Your  email')); ?>" type="text"
                        name="email_id" required="" autocomplete="off">
                      <button 
                      
                      class="btn btn-sm  btn-primary customFooteremailBtn" type="submit">
                        <img src="/assets/img/footerEmailIcon.png" width="15px" height="15px" alt="footer"/>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="copy-right-area border-top">
        <div class="container">
          <div class="copy-right-content">
            <span><?php echo @$footerInfo->copyright_text; ?></span>
          </div>
        </div>
      </div>
    </footer>
  <?php endif; ?>
  <!-- Footer-area end-->

  <!-- Go to Top -->
  <div class="go-top"><i class="fal fa-angle-up"></i></div>
  <!-- Go to Top -->
<div class="modal fade modal-lg" id="topSearch" tabindex="-1" role="dialog" aria-labelledby="topSearchLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="<?php echo e(route('frontend.cars')); ?>" enctype="multipart/form-data" method="GET" id = "topSearchForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title w-100" id="topSearchLabel">
            <div class="form-group has-search">
              <span class="fa fa-search form-control-feedback" role="button" onclick="document.getElementById('topSearchForm').submit();"></span>
              <input type="text" name ="title" id="searchByTitleTop" class="form-control input-lg" placeholder="Search Listit" style="padding: 15px;">
            </div>
          </h5>
        
          <?php echo csrf_field(); ?>
          <a class="close" data-dismiss="modal" role="button">
            <span aria-hidden="true">&nbsp;&nbsp;Cancel</span>
          </a>
        </div>
        <div class="modal-body">
            
          <div class="user mb-20">
              
            <div class="row">
              <div class="col-12">  
                <div class="autocomplete-suggestions suggestionbox">
                  <div class="autocomplete-suggestion pt-2 pb-2"><strong> My Last Search</strong><br>
                        <?php
                          $lSearch = array();
                          if (Auth::guard('vendor')->check()){
                              $lastSearch = App\Models\Car\CustomerSearch::where('customer_id', Auth::guard('vendor')->user()->id)->first();
                              if($lastSearch){
                              $lSearch = $lastSearch->customer_filters;
                              }
                          } elseif(session()->has('lastSearch')) { 
                              $lSearch = Session::get('lastSearch');
                          }
                      ?>
                      <?php if(!empty($lSearch)): ?>
                      
                      <a style="font-size:11px;" href="ads?<?php echo e(http_build_query(json_decode($lSearch))); ?>">
                                    <?php $__currentLoopData = json_decode($lSearch); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($key!='_token'): ?>
                                    <?php if(!is_array($value)): ?>
                                      <?php echo e(Str::slug($value, ' ')); ?> <small style="font-size:9px;">-></small>
                                      <?php endif; ?>
                                      <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  </a>
                      <?php endif; ?>             
                  </div>
                  <div class="autocomplete-suggestion pt-2 pb-2"> Suggested searches</div>
                  <div class="autocomplete-suggestion pt-2 pb-2"><a href="<?php echo e(route('frontend.cars', ['category'=>'cars'])); ?>"><i class="fal fa-check"></i> &nbsp;Cars from Trusted Dealerships  <b>in Cars</b></a></div>
                  <div class="autocomplete-suggestion pt-2 pb-2"><a href="<?php echo e(route('frontend.cars', ['category'=>'cars'])); ?>"><i class="fal fa-check"></i> &nbsp;Cars with a Warranty  <b>in Cars</b></a></div>
                  <div class="autocomplete-suggestion pt-2 pb-2"><a href="<?php echo e(route('frontend.cars', ['category'=>'cars'])); ?>"><i class="fal fa-check"></i> &nbsp;Cars with Greenlight History Check  <b>in Cars</b></a></div>
                  <div class="autocomplete-suggestion pt-2 pb-2"> <a href="<?php echo e(route('frontend.cars', ['category'=>'cars'])); ?>"><i class="fal fa-check"></i> &nbsp;Cars with Finance  <b>in Cars</b></a></div>
                  <div class="autocomplete-suggestion pt-2 pb-2"><a href="<?php echo e(route('frontend.cars', ['category'=>'cars'])); ?>"><i class="fal fa-check"></i> &nbsp; New Cars  <b>in Cars</b></a></div>

                </div>
              </div>
            </div> 
          </div> 
        </div>
        
      </div>
  </form>
  </div>
</div>

<div class="modal fade" id="verifyProfilePhone" tabindex="-1" role="dialog" aria-labelledby="topSearchLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="<?php echo e(route('vendor.verify_code')); ?>" method="POST" class = "verifyoptProfile-code">
            <?php echo csrf_field(); ?>
      <div class="modal-content" style="width: 100% !important;">
        <div class="modal-header">
          <div class="row">
            <h4 class="modal-title w-100" id="topSearchLabel">
              <img src = "">
              <img src="<?php echo e(asset('assets/img/mobile-id-verification.png')); ?>" alt="verification" width= "60">
            Verify your number <br> 
            </h4>
          </div>
        
          <a class="close" data-dismiss="modal" onclick="closemodal()">
            <span aria-hidden="true">X</span>
          </a>
        </div>
        <div class="modal-body">
            
          <div class="user mb-20">
              
            <div class="row">
                <div class="col-12">  
                <p class ="mycode"> </p>
              </div>
              <div class="col-12">  
                <div class="form-group">
                <label for="exampleInputPassword1">Enter the code you received via text</label>
                <input name="code" type="text" class="form-control" id="verifyProfileCode" placeholder="Enter verification code">
                <input type="hidden" name ="profileverify" value="1">
                </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-lg btn-primary radius-md w-100"> <?php echo e(__('Verify Phone')); ?> </button>
                  </div>
                
              </div>
              
            </div> 
          </div> 
        </div>
        
      </div>
    </form>
  </div>
</div>
<?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/partials/footer/footer-v2.blade.php ENDPATH**/ ?>