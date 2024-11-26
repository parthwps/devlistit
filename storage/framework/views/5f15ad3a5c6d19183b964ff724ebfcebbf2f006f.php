<?php
  $version = $basicInfo->theme_version;
?>


<?php $__env->startSection('pageHeading'); ?>
  <?php echo e(__('Listit | Isle of Man\'s Largest  Classifieds Marketplace')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaKeywords'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_keyword_home); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('metaDescription'); ?>
  <?php if(!empty($seoInfo)): ?>
    <?php echo e($seoInfo->meta_description_home); ?>

  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('frontend/home/browserlifeStyle', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<style>
.product-default .product-title {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    max-width: calc(100% - 10px) !important;
}
    .us_loan
    {
        margin-left: 5px;
        margin-top: 5px;
    }

    * {
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none;  /* IE and Edge */
    }

    ::-webkit-scrollbar {
        display: none;  /* Chrome, Safari */
    }


    .hero-banner-2{
      margin-top: 0px !important;
    }

    .font-type{
      font-weight: 600;   
    }
    .font-500{
      font-weight: 500;   

    }

    /* Set the color to blue when the li has the active class */
    .nav-item.active .nav-link {
        color: #348ceb;
        border-bottom: 2px solid #1D86F5;
    }

    .nextprevbtn {
      z-index: 999; /* Higher z-index to make the buttons visible above other content */
    }
    
    .loading-section{
      display: none !important;
    }

    /* General card container styling */
.card-container {
    padding: 25px;
    text-align: center;
}

/* Styling for the icon container (blue circle with white icon inside) */
.card-icon-container {
    background-color: #007bff; /* Blue background */
    color: #ffffff; /* White icon color */
    width: 100px; /* Set width and height to make the icon round */
    height: 100px;
    border-radius: 50%; /* Make the icon container a circle */
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto; /* Center the icon in the card */
    font-size: 40px; /* Adjust icon size */
}

/* Card title (heading) */
.card-title {
    font-size: 20px;
    color: #000000; /* Black color for heading */
    margin-bottom: 20px;
    font-weight: bold;
}

.card-title2 {
    font-size: 14px;
    color: #000000; /* Black color for heading */
    margin-bottom: 20px;
    font-weight: bold;
}

/* Subtitle or text below the heading */
.card-text {
    font-size: 13px;
    color: #a0a0a0; /* Light gray color for text */
    line-height: 1.5;
}

.vendor-info-container {
  display: flex;
  flex-direction: column;
  background-color: white; /* Background color for the container */
  padding: 15px;
  border-radius: 10px;
  color: black;
  max-width: 100%; 
  height: 320px;
}
.featured-stock-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 10px !important;
    padding-bottom: 10px !important;
}
.vendor-info {
  display: flex;
  align-items: center;
  margin-bottom: 15px;
}
.showroom-button, .blog-button {
    display: inline-block;
    background-color: #1D86F5;
    color: white;
    padding: 10px 20px;
    margin-top: 20px;
    margin-top: 5px !important;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    font-size: 16px;
    width: 100%;
    text-align: center;
}

.vendor-info img {
  border-radius: 10%; /* Rounded corners */
  width: 100px; /* Increase the width as needed */
  height: 100px; /* Increase the height as needed */
  /* margin-right: 15px; Space between image and vendor details */
}

.vendor-details h1 {
  margin: 0;
  font-size: 28px;
}

.dealer-info {
  font-size: 22px;
  margin-top: 5px;
  color: #74787a;
}

.vendor-title{
  font-size: 20px;
  /* margin-top: 5px; */

}

.stock-ads {
  margin-top: 5px;
  font-size: 14px;
  color: #74787a;
}

/* Flexbox for the featured tag and stock ads */
.featured-stock-info {
  display: flex;
  justify-content: space-between; /* Align featured tag to left and stock ads to right */
  align-items: center;
  /* margin-top: 10px; */
}

.featured-tag {
  background-color: #E7F2FF; 
  border: 2px solid #1D86F5; 
  color: #1D86F5;
  padding: 5px 10px;
  border-radius: 5px;
  font-size: 14px;
  /* font-weight: bold; Make the text bold if desired */
}

.stock-ads-right {
  font-size: 16px;
  color: #74787a;
}

.showroom-button,.blog-button {
  display: inline-block;
  background-color: #1D86F5;
  color: white;
  padding: 10px 20px; /* Padding for a form control look */
  margin-top: 20px;
  /* margin-bottom: 5px; */
  border: none;
  border-radius: 5px;
  text-decoration: none;
  font-size: 16px;
  width: 100%; /* Make the button stretch like a form control */
  text-align: center; /* Center the text */
}

.showroom-button:hover {
  background-color: #0056b3; /* Darker blue on hover */
  color:white;
}

.dealer-card {
  margin-left: 5%;
}
.text-28px{
  font-size: 22px !important;
  font-weight: 700;
}
.text-28px-product{
  font-size: 22px !important;
  font-weight: 700;
}
.text-20px{
  font-size: 20px !important;
  font-weight: 500;
}
.text-18px{
  font-size: 18px !important;
  font-weight: 700;
}

.text-16px{
  font-size: 16px !important;
  font-weight: 700;
}
.text-60px{
  font-size: 30px !important;
  font-size: 30px !important;
  font-weight: 700;
}
.text-mobile{
  font-size: 30px !important;
  font-size: 30px !important;
  font-weight: 700;
}
.text-30px{
  font-size: 26px !important;
  font-weight: 700;
}
.text-30px-blog 
{font-size: 18px !important;
font-weight: 700;}

.text-18px-500-blog{
  font-size: 16px !important;
  font-weight: 500;
}
.shareIcon{
  font-size: 25px;
}
.shareHeart{
    position: absolute; 
    right: 10px; 
    top: 10px; 
    z-index: 1; 
    background: white; 
    border-radius: 10px; 
    padding: 5px;
  }
  .simpleText{
    font-size: 30px;
  }
  .featured-stock-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.catImg{
  width: 16% !important;
}
.catImgText{
  font-size: 15px;
}

@media (max-width: 2560px) {
  .text-30px-blog{
    font-size: 45px !important;
    font-weight: 700;
  }
  .text-18px-500-blog{
    font-size: 22px !important;
    font-weight: 500;
    line-height: 28px;
  }
}
@media (max-width: 2000px) {

  .vendor-info {
    /* border: 1px solid orange; */
  }

  .vendor-info-container{
    height: 380px !important;
  }

  .showroom-button{
    margin-top: 100px !important;
  }

  .text-30px-blog{
    font-size: 32px !important;
    font-weight: 700;
  }
  .text-18px-500-blog{
    font-size: 18px !important;
    font-weight: 500;
    line-height: 20px;
  }
}
@media (max-width: 1600px) {

  .text-30px-blog{
    font-size: 27px !important;
    font-weight: 700;
  }
  .text-18px-500-blog{
    font-size: 18px !important;
    font-weight: 500;
    line-height: 20px;
  }
  .text-28px{
  font-size: 32px !important;
  font-weight: 700;
}
}
@media (max-width: 1540px) {
  .offSetLeft:first-child{
    margin-left: 200px !important;
    /* border:1px solid gray; */
  }

  .vendor-info {
    /* border: 1px solid black; */
  }
  .showroom-button {
    margin-top: 50px !important;
  }

  .vendor-info-container{
    height: 327px !important;
  }
}
@media (max-width: 1440px) {
  .offSetLeft:first-child{
    margin-left: 140px !important;
    /* border:1px solid orange; */
  }
  .vendor-info {
    /* border: 1px solid yellow; */
  }


  .text-30px-blog{
    font-size: 19px !important;
    font-weight: 700;
  }
  .text-18px-500-blog{
    font-size: 16px !important;
    font-weight: 500;
    line-height: 28px;
  }
  .text-28px{
  font-size: 28px !important;
  font-weight: 700;
  max-width: 280px;
}
.featured-stock-info {
  display: flex;
  justify-content: space-between; /* Align featured tag to left and stock ads to right */
  align-items: center;
  margin-top: 10px;
}
.showroom-button, .blog-button {
    display: inline-block;
    background-color: #1D86F5;
    color: white;
    padding: 10px 20px;
    margin-top: 38px !important;
    /* margin-bottom: 5px; */
    border: none;
    border-radius: 5px;
    text-decoration: none;
    font-size: 16px;
    width: 100%;
    text-align: center;
}
}

@media (max-width: 1380px) {
  .showroom-button {
    /* margin-top: 50px !important; */
  }

  .vendor-info-container{
    height: 320px !important;

  }

  .vendor-info {
    /* border: 1px solid red; */
  }
  
}

@media (max-width: 1280px) {
  .offSetLeft:first-child{
    margin-left: 305px !important;
    /* border:1px solid red; */
  }
  .vendor-info-container{
    height: 305px !important;
  }

  .vendor-info {
    /* border: 1px solid blue; */
  }

  .featured-stock-info {
  display: flex;
  justify-content: space-between; /* Align featured tag to left and stock ads to right */
  align-items: center;
  margin-top: 10px;
}
.showroom-button, .blog-button {
    display: inline-block;
    background-color: #1D86F5;
    color: white;
    padding: 10px 20px;
    margin-top: 25px !important;
    /* margin-bottom: 5px; */
    border: none;
    border-radius: 5px;
    text-decoration: none;
    font-size: 16px;
    width: 100%;
    text-align: center;
}
  .text-30px-blog{
    font-size: 20px !important;
    font-weight: 700;
  }
  .text-18px-500-blog{
    font-size: 15px !important;
    font-weight: 500;
    line-height: 28px;
  }
  .text-28px{
  font-size: 22px !important;
  font-weight: 700;
}
.text-18-categ{
  font-size: 16px !important;
  font-weight: 700;
}
.text-18-categ-perWeek{
  font-size: 16px !important;
  font-weight: 700;
}
.featured-stock-info {
  display: flex;
  justify-content: space-between; /* Align featured tag to left and stock ads to right */
  align-items: center;
  margin-top: 10px;
}
}
@media (max-width: 1200px) {
  .offSetLeft:first-child{
    margin-left: 345px !important;
    /* border: 1px solid blue; */
  }

  .vendor-info-container{
    height: 270px !important;
  }

  .vendor-info {
    /* border: 1px solid orange; */
  }

  .vendor-title{
    font-size: 20px !important;
  }

  .dealer-info{
    font-size: 15px;
  }

  .featured-tag{
    font-size: 12px !important;
  }
  .stock-ads-right{
    font-size: 14px;
  }
  .showroom-button{
    margin-top: 0px !important;
    padding:5px 20px !important;
  }

}
@media (max-width: 1024px) {
  .row{
        --bs-gutter-x: 0.5rem !important;
  }
  .offSetLeft:first-child{
    margin-left: 550px !important;
    /* border: 1px solid purple; */
  }

  .vendor-info-container{
    height: 265px !important;
  }

  .vendor-info {
    /* border: 1px solid black; */
  }
  .vendor-title{
    font-size: 20px !important;
  }
  .dealer-info{
    font-size: 14px;
  }
  .featured-tag{
    font-size: 12px !important;
  }
  .stock-ads-right{
    font-size: 14px;
  }
  .showroom-button{
    margin-top: 0px !important;
    padding:5px 20px !important;
  }


  .text-30px-blog{
    font-size: 15px !important;
    font-weight: 700;
  }
  .text-18px-500-blog{
    font-size: 12px !important;
    font-weight: 500;
    line-height: 18px;
  }
  .text-28px{
  font-size: 18px !important;
  font-weight: 700;
}
.text-18-categ{
  font-size: 15px !important;
  font-weight: 700;
}
.text-18-categ-perWeek{
  font-size: 15px !important;
  font-weight: 700;
}
.text-18-categ-perWeekBottom{
  font-size: 12px !important;
  font-weight: 700;
}
.dealer-card {
  /* margin-left: 0%; */
}

}

@media (max-width: 991px) {

  .offSetLeft:first-child{
    margin-left: 690px !important;
    /* border: 1px solid green; */
  }

  .vendor-info-container{
    height: 265px !important;
  }

  .vendor-info {
    /* border: 1px solid purple; */
  }
  .vendor-details h1 {
    margin: 0;
    font-size: 24px !important;
}
  .vendor-title{
  font-size: 20px;
}
.dealer-info{
  font-size: 17px;
}
.simpleText{
    font-size: 28px;
  }
  .text-30px-blog{
    font-size: 19px !important;
    font-weight: 700;
  }
  .text-18px-500-blog{
    font-size: 13px !important;
    font-weight: 500;
    line-height: 16px;
  }
  .text-28px{
  font-size: 20px !important;
  font-weight: 700;
}

.dealer-card {
  margin-left: 0%;
}
}


@media (max-width: 768px) {

  .vendor-info {
    /* border: 1px solid green; */
  }
}
@media (max-width: 575px) {
  .offSetLeft:first-child{
    margin-left: 930px !important;
    /* border: 1px solid yellow; */
  }
  .responsiveFonts{
    font-size: clamp(12px, 1.48vh, 24px)
  }
  .shareHeart{
    position: absolute; 
    right: 10px; 
    top: 10px; 
    z-index: 1; 
    background: rgba(255,255,255,0.8); 
    border-radius: 10px; 
    padding: 5px;

  }
  .product-area {
    margin: 0px !important;
  }
  .shareIcon{
  font-size: 18px;
}
  .dealer-card {
    margin-left: 0%;
}
  .text-18px-500-blog{
  font-size: 14px !important;
  font-weight: 500;
}
  .text-30px-blog{
    font-size: 16px !important;
    font-weight: 700;
  }
  .text-18px-500{
  font-size: 14px !important;
  font-weight: 500;
}
  .text-30px{
  font-size: 20px !important;
  font-weight: 500;
}
  .text-60px{
  font-size: 20px !important;
  font-weight: 700;
}
.text-mobile{
  font-size: 27px !important;
  font-weight: 700;
}
.text-28px{
  font-size: 16px !important;
  font-weight: 700;
  width: 80%;
}
.text-28px-product{
  font-size: 14px !important;
  font-weight: 700;
  width: 80%;
}
.text-20px{
  font-size: 16px !important;
  font-weight: 500;
}
.text-18px{
  font-size: 17px !important;
  font-weight: 700;
}
.text-18-categ{
  font-size: 13px !important;
  font-weight: 700;
}
.text-18-categ-perWeek{
  font-size: 13px !important;
  font-weight: 700;
}
.text-16px{
  font-size: 12px !important;
}

.vendor-title{
  font-size: 20px;
}
.dealer-info{
  font-size: 17px;
}
.whishList_img{
    width: 30px !important;
  }
  .text-mobile{
  font-size: 20px !important;
  font-weight: 700;
}
  .simpleText{
    font-size: 20px;
  }
  .catImg{
  min-width: 35% !important;
}
.catImgText{
  font-size: 12px !important;
}
  .text-mobile{
  font-size: 20px !important;
  font-weight: 700;
}
  .simpleText{
    font-size: 20px;
  }
}
@media (max-width: 375px) {
  .row{
        --bs-gutter-x: 0.5rem !important;
  }
  .catImg, {
  min-width: 35% !important;
}
.catImgText{
  font-size: 12px !important;
}
  .text-60px{
  font-size: 20px !important;
  font-weight: 700;
}
  .text-mobile{
  font-size: 20px !important;
  font-weight: 700;
}
  .simpleText{
    font-size: 20px;
  }
  .offSetLeft:first-child{
    margin-left: 990px !important;
    /* border: 1px solid black; */
  }
  .text-18px-500-blog{
  font-size: 10px !important;
  font-weight: 500;
}
  .text-30px-blog{
    font-size: 13px !important;
    font-weight: 800;
  }
  .btn-icon{
    min-width: 1.25rem !important;
  }
  .whishList_img{
    width: 30px !important;
  }
}
</style>
  <!-- Home-area start icon set-->
  <section  class="hero-banner hero-banner-2" style="margin:0;border-radius:0px;box-shadow: 0px 0px 0px;">
    <div class="container-fluid">
      <div class="row justify-content-center ">
        <div class="col-lg-6">
          <div class="swiper home-slider" id="home-slider-2" data-aos="">
          </div>
        </div>
        <div class="col-12">
        
        </div>
        <div class="col-lg-8 col-xl-6 us_homeclmn px-1">
          <div class="banner-filter-form mw-60" data-aos="">
            <ul class="nav nav-tabs border-0 m-3 bg-white" style="border-radius: 10px;">
             
                  <li class="nav-item active">
                    <button class="nav-link car-button removeFilter  car_condition font-type tab-category"
                     data-image = "newbanner.png" data-id="24" data-bs-toggle="tab" data-cars-filter="1"
                      data-bs-target="#all" type="button" style="color:#1D86F5">
                            
                      <i class="fas fa-car fa-fw me-2" style="color:#1D86F5"></i>
                      Cars
                    </button>
                  </li>
                   <li class="nav-item">
                    <button class="nav-link car_condition show_only_browse_style font-type tab-category" data-image = "market.jpg"
                     data-id="0" data-bs-toggle="tab" 
                      data-bs-target="#all" type="button" style="color:black">
                            
                       <i class="fas fa-store fa-fw me-2" style="color:gray"></i>
                       <!-- <i class="fas fa-shopping-cart back-cart" style="color: blue;"></i> -->
                        Marketplace 
                    </button>
                  </li>
                   <li class="nav-item">
                    <button class="nav-link car_condition show_only_browse_style font-type tab-category" data-image = "property.jpg" 
                     data-id="39" data-bs-toggle="tab" 
                      data-bs-target="#all" type="button" style="color:black">

                      <i class="fas fa-building fa-fw me-2" style="color:gray"></i>
                        Property
                    </button>
                  </li>
                  
                  <li class="nav-item">
                    <button class="nav-link car_condition show_only_browse_style font-type tab-category" data-image = "farming.png"  
                    data-id="28" data-bs-toggle="tab" 
                      data-bs-target="#all" type="button" style="color:black">

                      <i class="fas fa-tractor" style="color:gray"></i>
                        Farming
                    </button>
                  </li>
                  
                
             
            </ul>
            <div class="tab-content form-wrapper shadow-lg p-20">
              <div class="tab-pane fade active show" id="all">
                <input type="hidden" name="getModel" id="getModel" value="<?php echo e(route('fronted.get-car.brand.model')); ?>">
                <form action="<?php echo e(route('frontend.cars')); ?>" method="GET" id= "homesearchform">
                <input class="form-control" type="hidden" value="cars-&-motors" name ="category" id="tabsCat">
                  <div class="row align-items-center gx-xl-3">
                    <div class="col-lg-12">
                      <div class="row ">
                       
                        <div class="col-md col-sm-6 carform">
                          <div class="mb-20">
                            <select class="form-control js-example-basic-single1 font-500" id="car_brand" name="brands[]">
                            <option value=""><?php echo e(__('All Makes')); ?></option>
                            <option disabled>-- Popular Brands --</option>
                            <?php $__currentLoopData = $brands->sortBy('name'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($brand->slug); ?>"><?php echo e($brand->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <option disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-- Other Makes --</option>
                            <?php if(false): ?>
                              <?php $__currentLoopData = $otherBrands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($brand->slug); ?>"><?php echo e($brand->name); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md col-sm-6 carform">
                          <div class="mb-20">
                            <select class="form-select form-control js-example-basic-single1 font-500" id="model" name="models[]">
                              <option value=""><?php echo e(__('All Models')); ?></option>
                            </select>
                          </div>
                        </div>
                      </div>
                        <div class="row ">
                       <div class="col-6 col-sm-3 carform">
                          <div class="mb-20">
                            <select class="form-select form-control js-example-basic-single1 font-500" id="year_min" name="year_min">
                              <option value=""><?php echo e(__('Min Year')); ?></option>
                              <?php $__currentLoopData = $caryear; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option 
                                    value="<?php echo e($year->name); ?>"><?php echo e($year->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-6 col-sm-3 carform">
                          <div class="mb-20">
                            <select class="form-select form-control js-example-basic-single1 font-500" id="year_max" name="year_max">
                              <option value=""><?php echo e(__('Max Year')); ?></option>
                               <?php $__currentLoopData = $caryear; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option 
                                    value="<?php echo e($year->name); ?>"><?php echo e($year->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-6 col-sm-3 carform">
                          <div class="mb-20">
                          
                            <select class="form-select form-control js-example-basic-single1 font-500" id="min" name="min">
                              <option value=""><?php echo e(__('Min Price')); ?></option>
                               <?php $__currentLoopData = $adsprices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prices): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option 
                                    value="<?php echo e($prices->name); ?>"><?php echo e(symbolPrice($prices->name)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-6 col-sm-3 carform">
                          <div class="mb-20">
                            <select class="form-select form-control js-example-basic-single1 font-500" id="max" name="max">
                              <option value=""><?php echo e(__('Max Price')); ?></option>
                              <?php $__currentLoopData = $adsprices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prices): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option 
                                    value="<?php echo e($prices->name); ?>"><?php echo e(symbolPrice($prices->name)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                          </div>
                        </div>
                      </div>

                        <div class="col-12 carformtxt"  style="display: none;">
                          <div class="form-groupSearch">
                           <input type="text" class="form-control" id="searchByTitle"  name="title" value="" placeholder="Search By Title">
                           <div id="suggesstion-box" class="col-12 p-3 bg-white" style="display: none;"></div>
                          </div>
                        </div>

                        <input class="form-control" type="hidden" value="<?php echo e($min); ?>" id="o_min">
                        <input class="form-control" type="hidden" value="<?php echo e($max); ?>" id="o_max">
                        <input type="hidden" id="currency_symbol" value="<?php echo e($currencyInfo->base_currency_symbol); ?>">
                      
                    </div>
                     <div class="col-lg-12 text-md-end">
                      <button type="button" onclick="updateUrlHome()" class="btn btn-primary bg-primary color-white w-100 searchNow">
                        <?php echo e(__('Search Now')); ?></span>
                      </button>
                    </div> 
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Home-area end -->

  <!-- latest add section start -->
    <?php if($car_contents->count() > 0 ): ?>
        
    <section class="product-area pt-40 pb-20 us_recent_pro" style="border-radius:0px;box-shadow: 0px 0px 0px;margin-bottom: 1rem;">
      <div class="container-fluid">
            <div class="section-title title-inline mb-sm-30 mb-20" >
                  <h2 class="title  text-mobile " >
                    Recent Ads
                  </h2>  
                      <!-- <a href="ads?sort=new" class="fw-bold" style="font-size: 27px; text-decoration: none;color:#1D86F5;font-size:20px;">See All ></a> -->
                    <a href="ads?type=list" class="fw-bold" style="font-size: 27px; text-decoration: none;color:#1D86F5;font-size:20px;">See All ></a>
          </div>
      </div> 
      <div class="d-flex align-items-center justify-content-center position-relative">
            <div class="w-100 gap-2 gap-md-3 d-flex align-items-center justify-content-center" 
            style="overflow-x: auto; white-space: nowrap;  " id="recent_all_ads">
            <?php echo $__env->make('frontend/home/recent-ads-copy', ['car_contents' => $car_contents], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
              <?php
                  $lastindex = count($car_contents) - 1;
              ?>

              </div>
             <input type="hidden" id="leftside" value="<?php echo e($car_contents[0]->id); ?>" />
                  <input type="hidden" id="rightside" value="<?php echo e($car_contents[$lastindex]->id); ?>" />
                  <!-- Left (Previous) Button -->
                  <button type="button" class="nextprevbtn position-absolute d-none " value="1" style="top: 50%; left: -10px; transform: translateY(-50%); background: white; box-shadow: 0px 0px 20px 0px rgba(76, 87, 125, 0.1);border-color: transparent; padding: 5px; height: 50px; width: 50px; border-radius: 50%; font-size: 30px; color: #A6A6A6;">
                          <i class="fa fa-angle-left" aria-hidden="true"></i>
                  </button>
                  <!-- Right (Next) Button -->
              <button type="button" class="nextprevbtn position-absolute d-none" value="2" 
              style="top: 50%; right: -10px; transform: translateY(-50%); background: white; white; box-shadow: 0px 0px 20px 0px rgba(76, 87, 125, 0.1);border-color: transparent; padding: 5px; height: 50px; width: 50px; border-radius: 50%; font-size: 30px; color: #A6A6A6;">
                  <i class="fa fa-angle-right" aria-hidden="true"></i>
              </button>
      </div>
    </div>
 </section>
     
    <?php endif; ?>      
  <!-- latest add  section end -->

   <!-- Steps-area start 3-->

    <section class="steps-area pt-20 pb-20  font-500" style="border-radius:0px; box-shadow: 0px 0px 0px; background:#F4F9FF;">
      <div class="container-fluid">
        <div class="row m-sm-4 m-0">
        <!-- <div class="col-1"></div> -->
          <div class="d-flex flex-sm-row flex-column justify-content-between pb-2 pb-sm-0">
            <div class="section-title title" data-aos="" >
              <h2 class=" text-center text-sm-start simpleText fw-bold">
                
                It's As Simple As List It
              </h2>
            </div>
        
            <div class="section-title title-center " data-aos="">
              <h4 class="fw-bold text-center simpleText text-sm-end" style="color: #4a9dd9;">
                
                Simple, Safe, Secure
              </h4>
            </div>
          </div>
          <div class="col-12 mb-20">
            <div class="row mt-4 ">
              <!-- Card 1 -->
              <div class="col-lg-3 col-md-6" data-aos="">
                <div class="card-container align-items-center text-center radius-md p-0 p-sm-25">
                  <div class="card-icon-container mb-25">
                    <i class="fas fa-search"></i>
                  </div>
                  <div class="card-content mb-4 mb-sm-0">
                    <h5 class="card-title2 mb-20">
                      Search for it on List It Classifieds ISLE OF MAN
                    </h5>
                    <p class="card-text lc-3 ">
                      Search and discover almost anything you can think of for sale, in one place.
                    </p>
                  </div>
                </div>
              </div>
              <!-- Card 2 -->
              <div class="col-lg-3 col-md-6" data-aos="">
                <div class="card-container align-items-center text-center radius-md p-0 p-sm-25">
                  <div class="card-icon-container mb-25">
                    <i class="fas fa-file-invoice-dollar"></i>
                  </div>
                  <div class="card-content mb-4 mb-sm-0">
                    <h5 class="card-title2 mb-20">
                      Browse your favorite sections
                    </h5>
                    <p class="card-text lc-3 ">
                      View a range of ads from the hundreds of listing currently online.
                    </p>
                  </div>
                </div>
              </div>
              <!-- Card 3 -->
              <div class="col-lg-3 col-md-6" data-aos="">
                <div class="card-container align-items-center text-center radius-md p-0 p-sm-25">
                  <div class="card-icon-container mb-25">
                    <i class="fas fa-headphones-alt"></i>
                  </div>
                  <div class="card-content mb-4 mb-sm-0">
                    <h5 class="card-title2 mb-20">
                      Make Contact with the Seller
                    </h5>
                    <p class="card-text lc-3 ">
                      Contacting local sellers is simple, safe and efficient. You may choose to call or message.
                    </p>
                  </div>
                </div>
              </div>
              <!-- Card 4 -->
              <div class="col-lg-3 col-md-6" data-aos="">
                <div class="card-container align-items-center text-center radius-md p-0 p-sm-25">
                  <div class="card-icon-container mb-25">
                    <i class="fas fa-gavel"></i>
                  </div>
                  <div class="card-content mb-4 mb-sm-0">
                    <h5 class="card-title2 mb-20">
                      Consider it SOLD on List It!
                    </h5>
                    <p class="card-text lc-3 ">
                      You can consider it SOLD! If its not listed on List it its not for sale!!!
                    </p>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>
  <!-- Steps-area end -->
    
  <!-- START BROWSE CARS --->
   <div class="w-100"  id="browse_style_home">
    <?php if($browse_by_lifestyle): ?>
      <?php echo $__env->make('frontend/home/browseBycars', [$browse_by_lifestyle], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
</div>
  <!-- END BROWSE CARS --->




<!-- Category-area start 3 -->
  <?php if($secInfo->category_section_status == 1): ?>
  <section class="category-area category-1 pt-20 pb-20 font-type" 
    style="margin: 0px;border-radius:0px;box-shadow: 0px 0px 0px #afafaf;">
      <div class="container-fluid">
        <div class="row m-sm-4">
          <div class="col-12">
            <div class="section-title title-inline mb-10 mb-sm-50 px-1 px-sm-4" data-aos="">
              <h2 class="title mb-0 text-center text-sm-start simpleText"><?php echo e(@$catgorySecInfo->title); ?> </h2>
            </div>
          </div>
          <div class="col-12">
            <?php echo $__env->make('frontend/home/dataloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="row m-sm-4 tabsHtmlData loading-section">
              
            <?php $__currentLoopData = $car_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-6 col-lg-3" data-aos="">
                  <a href="<?php echo e(route('frontend.cars', ['category' => $category->slug])); ?>" class="category_icon_link" data-cat="<?php echo e($category->slug); ?>">
                     
                    <div class="category-item ">
                      <div class="d-flex border rounded pt-4 ps-sm-4 pe-sm-4 px-4 mb-10">
                        <h6 class="category-title urbanistFonts mb-10 w-100">
                          <div class="w-100  d-flex  justify-content-start justify-content-sm-center 
                          align-items-center gap-1">
                            <div class="catImg w-25 w-sm-50 w-md-50 w-lg-50 w-xl-50  w-xxl-50 d-flex justify-content-end align-items-center">
                            <img class=" w-100 lazyload blur-up category-icon" 
                          style="    filter: brightness(0) saturate(100%) invert(72%) sepia(72%) saturate(6798%) hue-rotate(193deg)
                           brightness(95%) contrast(101%);" 
                              data-src="<?php echo e(asset('assets/admin/img/car-category/' . ($category->image === '/66cb39304409cColor.png' ? '/66cb39304409c.jpg' : $category->image))); ?>?v=0.3"  
                              alt="img 
                              title="<?php echo e($category->name); ?>"
                              id="filterCSS<?php echo e($key); ?>" >
                            </div>
                            <div class="catImgText w-25 w-sm-50 w-md-50 w-lg-50 w-xl-50  w-xxl-50  ">
                            <?php echo e($category->name === 'Commercials' ? 'Commercials' : $category->name); ?>

                            </div>
                          </div>
                        </h6>
                      </div>
                    </div>
                  </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
          </div>
          </div>
        </div>
      </div>
  </section>
  <?php endif; ?>
  <!-- Category-area end -->
 
  <!-- featured section start 4-->
  <?php if($secInfo->feature_section_status == 1 && !empty($getFeaturedVendors->cars)): ?>
  <section class="product-area pt-20 pb-20 font-type" 
    style="border-radius:0px;background:rgb(34, 40, 49);box-shadow: 0px 0px 0px 0px;margin:0px;"  id="carFeaterHomepage">
      <div class="container-fluid" >
        <div class="row m-sm-4" style="padding: 0px 0px !important;">
          <div class="col-12" data-aos="">
            <div class="section-title title-inline mb-20 dealer-car px-0 px-sm-4" data-aos="" style="margin-left: %;">
              <h1 class="text-60px text-center text-sm-start " style="color:white;">
                Featured Car Dealer
              </h1>
            </div>
          </div>
          
          <div class="col-12  col-lg-4 mb-3 mx-auto"  data-aos="" > 
            <?php echo $__env->make('frontend/home/dataloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>   
            <div class="vendor-info-container dealer-card loading-section" 
            style="box-shadow: 0px 0px 20px 0px rgba(76, 87, 125, 0.1);border-color: transparent;">
              <?php
                $photoUrl = env('SUBDOMAIN_APP_URL').'assets/admin/img/vendor-photo/' . $getFeaturedVendors->photo;
                
                if (file_exists(public_path('assets/admin/img/vendor-photo/' . $getFeaturedVendors->photo))) {
                  $photoUrl = asset('assets/admin/img/vendor-photo/' . $getFeaturedVendors->photo);
                }
              ?>
              
              <div class="vendor-info">
                <img  
                  class="lazyload blur-up"
                  src="<?php echo e(asset('assets/img/blank-user.jpg')); ?>"
                  data-src="<?php echo e($photoUrl); ?>"  
                  alt="Vendor" 
                  onload="handleImageLoad(this)"
                  onerror="this.onerror=null;this.src='<?php echo e(asset('assets/img/blank-user.jpg')); ?>';" 
                >  
                <div class="vendor-details ps-1">
                  <h1 class="vendor-title text-dark"><?php echo e($getFeaturedVendors->vendor_info->name); ?></h1>
                  <span class="dealer-info">
                    <?php echo e(($getFeaturedVendors->is_franchise_dealer == 1) ? 'Franchise' : 'Independent'); ?> Dealer
                  </span>
                </div>
              </div>
              <div class="featured-stock-info">
                <div class="featured-tag">
                  Featured
                </div>
                <div class="d-flex gap-3 stock-ads-right ">

                <img src="/assets/front/images/carDealer.png" width="60px" alt="car"/>
                 <div> Total Stock <br style="margin-top: -10px;"/>
                  <span style="font-weight: bold;color:black;"><?php echo e($getFeaturedVendors->cars_count); ?> Ads</span>
              </div>
                </div>
              </div>
              <a 
              href="<?php echo e(route('frontend.vendor.details', [ 'id' => $getFeaturedVendors->id ,  'username' => ( $getFeaturedVendors->username)])); ?>" 
              class="showroom-button ">
              See Showroom</a>
            </div>
          </div>
          <div class="col-12  col-lg-8" data-aos="" style="border: 0px solid orange;"> 
            <div class="row pe-sm-5 "  >     
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
   
              <!-- ------------------------------------------------- -->
              <div class="col-6 col-md-4">
              <?php echo $__env->make('frontend/home/dataloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="product-default p-1 p-sm-15 mb-10 loading-section" 
                style="padding: 0px !important;box-shadow: 0px 0px 20px 0px rgba(76, 87, 125, 0.1);
                border-color: transparent;border-radius: 10px;" data-id="<?php echo e($featureads->id); ?>">

                    <figure class="product-img mb-15">
                      <a href="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($featureads->car_content->category_id),'slug' => $featureads->car_content->slug, 'id' => $featureads->id])); ?>"
                      class="lazy-container ratio ratio-2-3">
                        <img class="lazyload"
                        data-src="<?php echo e($featureads->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path); ?>"
                        alt="<?php echo e(optional($featureads)->title); ?>" style="transform: rotate(<?php echo e($rotation); ?>deg);" >
                      </a>

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
                      <a href="javascript:void(0);" 
                        onclick="addToWishlist(<?php echo e($featureads->id); ?>)" 
                        class=" us_front_ad"
                        data-tooltip="tooltip" 
                        data-bs-placement="right"
                        title="<?php echo e($checkWishList == false ? __('Saved')  : __('Save Ad')); ?>" 
                        style="position: absolute; right: 5px; top: 5px; z-index: 100;">
                        <img src="assets/img/heart_dislike.svg"  class="whishList_img" alt="hear"></img>
                          
                      </a>
                    </figure>
                
                      <div class="product-details" style="padding: 7px !important;padding-left: 15px !important;">
                    
                        <span class="product-category font-xsm">
                            
                            <h5 class="product-title mb-0" style="font-size: clamp(12px, calc(14px + 1.5vh), 18px); 
                            display: inline-block;white-space: nowrap;
                            overflow: hidden;text-overflow: ellipsis;vertical-align: top;">
                              <a href="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($featureads->car_content->category_id),'slug' => $featureads->car_content->slug, 'id' => $featureads->id])); ?>"
                                title="<?php echo e(optional($featureads)->title); ?>">
                                <?php echo e(carModel($featureads->car_content->car_model_id)); ?> <?php echo e(optional($featureads->car_content)->title); ?>

                                <!-- <?php echo e(\Illuminate\Support\Str::limit(optional($featureads->car_content)->title, 12)); ?>                                -->
                              </a>
                            </h5>
                          
                        </span>
                      
                        <div class="d-flex align-items-center justify-content-between mt-3">
                          <div class="author us_child_dv" style="cursor:pointer;" 
                          onclick="window.location='<?php echo e(route('frontend.car.details', ['cattitle' => catslug($featureads->car_content->category_id),'slug' => $featureads->car_content->slug, 'id' => $featureads->id])); ?>'" >
                            <span class="text-20px">
                                
                                <!-- <?php if($featureads->year): ?>
                                    <?php echo e($featureads->year); ?> 
                                <?php endif; ?>
                                
                                <?php if($featureads->engineCapacity && $featureads->car_content->fuel_type ): ?>
                                  <b class="us_dot"> - </b>   <?php echo e(roundEngineDisplacement($featureads)); ?> 
                                <?php endif; ?> -->
                                
                                <!-- <?php if($featureads->car_content->fuel_type ): ?>
                                  <b class="us_dot"> - </b>   <?php echo e($featureads->car_content->fuel_type->name); ?> 
                                <?php endif; ?>
                                
                                
                                <?php if($featureads->mileage): ?>
                                  <b class="us_dot"> - </b>    <?php echo e(number_format( $featureads->mileage )); ?> mi 
                                <?php endif; ?> -->
                                
                                <?php if($featureads->created_at && $featureads->is_featured != 1): ?>
                                    <!-- <b class="us_dot text-20px"> - </b>  -->
                                    <?php echo e(calculate_datetime($featureads->created_at)); ?> 
                                <?php endif; ?>
                                
                                <!-- <?php if($featureads->city): ?>
                                    <b class="us_dot"> - </b> <?php echo e(Ucfirst($featureads->city)); ?> 
                                <?php endif; ?> -->
                                  
                            </span>
                        
                          </div>
                        
                          <?php if(!$featureads->year && !$featureads->mileage && !$featureads->engineCapacity): ?>
                          
                            <div style="display:flex;">
                            </div>
                          
                          <?php endif; ?> 

                            <a href="javascript:void(0);" onclick="openShareModal(this)" 
                               data-url="<?php echo e(route('frontend.car.details', ['cattitle' => catslug($featureads->car_content->category_id),'slug' => $featureads->car_content->slug, 'id' => $featureads->id])); ?>"
                              style="background: transparent; border: none; color: #1D86F5; font-size: 23px;">
                                <i class="fa fa-share-alt pe-1" aria-hidden="true"></i>
                            </a>
                        </div>
                                                
                        <div class="d-flex align-items-center justify-content-between mt-3 mb-2" >
                          <div class="author">
                              
                              <?php if($featureads->previous_price && $featureads->previous_price < $featureads->price ): ?>
                                  <strike style="font-weight: 300;color: red;font-size: 14px;float: left;"><?php echo e(symbolPrice($featureads->price)); ?></strike> 
                                  <!-- <div> <?php echo e(symbolPrice($featureads->previous_price)); ?></div> -->
                                  <span style="color: #1D86F5;" class="text-18px text-18-categ poundPrice" data-price="<?php echo e($featureads->previous_price); ?>">
                                    <?php echo e(symbolPrice($featureads->previous_price)); ?></span>
                                <?php else: ?>
                                  <span style="color: #1D86F5;" class="text-18px text-18-categ poundPrice" data-price="<?php echo e($featureads->price); ?>">
                                    <?php echo e(symbolPrice($featureads->price)); ?></span>
                                <?php endif; ?>
                          </div>
                          <div>
                            <!-- <?php echo calulcateloanamount(!empty($featureads->previous_price && $featureads->previous_price < $featureads->price  ) ? $featureads->previous_price : $featureads->price)[0]; ?> -->
                           
                            <?php
                                // Get loan amount data
                                $loanAmount = calulcateloanamount(!empty($featureads->previous_price && $featureads->previous_price < $featureads->price) ? $featureads->previous_price : $featureads->price)[0];

                                // Remove span tags and replace p/w, p/m with 'week' and 'month'
                                $formattedLoanAmount = strip_tags($loanAmount);
                                $formattedLoanAmount = str_replace(['p/w', 'p/m'], ['week', 'month'], $formattedLoanAmount);

                                // Extract the number and the period (week/month) using regex or simple logic
                                preg_match('/(\d+)\s*\/?(week|month)/', $formattedLoanAmount, $matches);
                                $number = $matches[1] ?? ''; // The number (1, 2, etc.)
                                $period = $matches[2] ?? ''; // The period ('week' or 'month')
                            ?>

                            <?php if($featureads->price>=5000): ?>

                                
                                <span class="text-18-categ-perWeek text-18-categ-perWeekBottom" style=" color: black;">
                                    <?php echo e(symbolPrice($number)); ?>

                                </span>
                              
                                <span class="text-18-categ-perWeek text-18-categ-perWeekBottom" style=" color: gray;">
                                    /<?php echo e($period); ?>

                                </span>
                            <?php endif; ?>
                          </div>
                        </div>


                      </div>
                </div>
              </div>
              
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
          </div>             
        </div>
      </div>
    </section>
  <?php endif; ?>
  <!-- featured section end -->

       
    
  <!-- counter section start -->
  
    <section class="choose-area choose-2 pt-20 pb-20" style="margin: 0px;border-radius:0px;box-shadow: 0px 0px 0px 0px">
      <div class="container-fluid mb-40">
        <div class="row justify-content-center m-sm-4">
          <div class="col-lg-6 order-2 order-md-1" data-aos="" style="border-radius:10px 0px 0px 10px;box-shadow: 1px 0px 10px 0px rgba(76, 87, 125, 0.1);border-color: transparent">
              

            <div class="content-title text-center ">
              <div class="w-lg-40">
                <!-- <h2 class="title mb-20 mt-0"><?php echo e(@$counterSectionInfo->title); ?></h2> -->
                
                <h3 class=" text-center  mt-4 text-60px">Download our mobile app!</h3>
                <!-- <p><?php echo e(@$counterSectionInfo->subtitle); ?></p> -->
                <div class="image ">
                  <img class="lazyload blur-up" data-src="<?php echo e(asset('assets/img/comingsoon.svg')); ?>"
                    alt="Image" style="width: 300px;height:250px;">
                </div>
                <p style="font-size: 18px;font-weight:bold;color:#000000">on</p>
                <div class="small-images">
                  <img src="<?php echo e(asset('assets/img/appstore.svg')); ?>" alt="App Store" 
                  style="width: 180px; height: auto;">
                  <img src="<?php echo e(asset('assets/img/playstore.svg')); ?>" alt="Play Store" 
                  style="width: 180px; height: auto;">
                </div>
              </div>
              <div class="info-list">
                <div class="row align-items-center">
                  <?php $__currentLoopData = $counters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-sm-6">
                      <div class="card mt-30">
                        <div class="d-flex align-items-center">
                          <div class="card-icon radius-md bg-primary-light"><i class="<?php echo e($counter->icon); ?>"></i>
                          </div>
                          <div class="card-content">
                            <span class="h3 mb-1"><span class="counter"><?php echo e($counter->amount); ?></span>+</span>
                            <p class="card-text"><?php echo e($counter->title); ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 order-1 order-md-2" 
          style="background-color:#B4D6FF;border-radius:0px 10px 10px 0px; 
          ">
            <div class="image d-flex justify-content-center align-items-center rounded ">
              <img class="lazyload blur-up" data-src="<?php echo e(asset('assets/img/12345678900.png')); ?>"
                alt="Image">
            </div>
          </div>
        </div>
      </div>
    </section>
  
  <!-- counter section end -->

  <!-- Testimonial-area start 5-->
  <?php if($secInfo->testimonial_section_status == 1): ?>
    <section class="testimonial-area testimonial-2 pt-20 pb-20">
    <section class="testimonial-area testimonial-2 pt-20 pb-20">
      <div class="container">
        <div class="section-title title-inline mb-30" data-aos="">
          <div class="col-lg-5">
            <span class="subtitle"><?php echo e(!empty($testimonialSecInfo->title) ? $testimonialSecInfo->title : ''); ?></span>
            <h2 class="title mb-20 mt-0">
              <?php echo e(!empty($testimonialSecInfo->subtitle) ? $testimonialSecInfo->subtitle : ''); ?></h2>
          </div>
          <div class="col-lg-6">
            <!-- Slider navigation buttons -->
            <div class="slider-navigation text-end mb-20">
              <button type="button" title="Slide prev" class="slider-btn" id="testimonial-slider-btn-prev">
                <i class="fal fa-angle-left"></i>
              </button>
              <button type="button" title="Slide next" class="slider-btn" id="testimonial-slider-btn-next">
                <i class="fal fa-angle-right"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="row align-items-center justify-content-end" data-aos="">
          <div class="col-lg-9">
            <div class="swiper pt-xl-5" id="testimonial-slider-1">
              <div class="swiper-wrapper">
                <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="swiper-slide pb-25">
                    <div class="slider-item radius-md">
                      <div class="quote">
                        <span class="icon"><i class="fal fa-quote-right"></i></span>
                        <p class="text mb-0">
                          <?php echo e($testimonial->comment); ?>

                        </p>
                      </div>
                      <div class="client">
                        <div class="client-info d-flex align-items-center">
                          <div class="client-img">
                            <div class="lazy-container rounded-pill ratio ratio-1-1">

                              <?php if(is_null($testimonial->image)): ?>
                                <img class="lazyload" data-src="<?php echo e(asset('assets/front/images/avatar-1.jpg')); ?>"
                                  alt="Person Image">
                              <?php else: ?>
                                <img class="lazyload"
                                  data-src="<?php echo e(asset('assets/img/clients/' . $testimonial->image)); ?>"
                                  alt="Person Image">
                              <?php endif; ?>
                            </div>
                          </div>
                          <div class="content">
                            <h6 class="name"><?php echo e($testimonial->name); ?></h6>
                            <span class="designation"><?php echo e($testimonial->occupation); ?></span>
                          </div>
                        </div>
                        <div class="ratings">
                          <div class="rate">
                            <div class="rating-icon" style="width: <?php echo e($testimonial->rating * 20); ?>%"></div>
                          </div>
                          <span class="ratings-total"><?php echo e($testimonial->rating); ?> <?php echo e(__('star')); ?></span>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="img-content d-none d-lg-block"
        data-aos="fade-<?php echo e($currentLanguageInfo->direction == 1 ? 'left' : 'right'); ?>">
        <div class="img">
          <img class="lazyload blur-up" data-src="<?php echo e(asset('assets/img/' . $testimonialSecImage)); ?>" alt="Image">
        </div>
      </div>
    </section>
  <?php endif; ?>
  <!-- Testimonial-area end -->

  <!-- call to action section start -->
  <?php if($secInfo->call_to_action_section_status == 1): ?>
    <section class="video-banner pt-20 pb-20 bg-img"
      data-bg-image="<?php echo e(asset('assets/img/' . $callToActionSectionImage)); ?>">
      <!-- Bg overlay -->
      <div class="overlay opacity-50"></div>

      <div class="container">
        <div class="row align-items-center gx-xl-5">
          <div class="col-lg-5 col-md-7" data-aos="">
            <div class="content-title mb-40">
              <span class="subtitle color-light mb-10"><?php echo e(@$callToActionSecInfo->title); ?></span>
              <h2 class="title color-white mb-20 mt-0"><?php echo e(@$callToActionSecInfo->subtitle); ?></h2>
              <p class="text color-light"><?php echo e(@$callToActionSecInfo->text); ?></p>
              <div class="cta-btn mt-30">
                <?php if(!empty($callToActionSecInfo)): ?>
                  <?php if(!is_null($callToActionSecInfo->button_url)): ?>
                    <a href="<?php echo e(@$callToActionSecInfo->button_url); ?>" class="btn btn-lg radius-md btn-primary"
                      title="<?php echo e(@$callToActionSecInfo->button_name); ?>"
                      target="_self"><?php echo e(@$callToActionSecInfo->button_name); ?></a>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="col-lg-7 col-md-5" data-aos="">
            <div class="d-flex align-items-center justify-content-center justify-content-md-end mb-40">
              <?php if(!empty($callToActionSecInfo)): ?>
                <?php if(!is_null($callToActionSecInfo->video_url)): ?>
                  <a href="<?php echo e(@$callToActionSecInfo->video_url); ?>" class="video-btn youtube-popup">
                    <i class="fas fa-play"></i>
                  </a>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php endif; ?>
  <!-- call to action section end -->

  <!-- Blog-area start -->
  <?php if($secInfo->blog_section_status == 1): ?>
    <section class="blog-area blog-2 pt-20 pb-20 font-type" style="margin: 0px;border-radius:0px;box-shadow: 0px 0px 0px;">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12" data-aos="">
              <div class=" mb-20" data-aos="">
                  <h2 class="text-center mb-0 mt-0 text-60px"><?php echo e(!empty($blogSecInfo->title) ? $blogSecInfo->title : ''); ?></h2>
              </div>
          </div>
          <div class="col-12">
        <div class="row justify-content-center g-2 g-sm-3 m-sm-4">
            <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-6 col-sm-6 col-lg-3" data-aos="">
              <article class="card mb-30">
                <?php echo $__env->make('frontend/home/dataloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  <!-- Real Content (hidden initially) -->
                  <div class="content loading-section">
                    <div class="card-img  radius-0 mb-25">
                        <a href="<?php echo e(route('blog_details', ['slug' => $blog->slug])); ?>" class="lazy-container radius-md ratio">
                            <img class="lazyload" data-src="<?php echo e(asset('assets/img/blogs/' . $blog->image)); ?>" alt="Blog Image">
                        </a>
                    </div>
                    <div  class="p-sm-4 px-1">  
                      <h4  style="color: #000000;font-size: clamp(12px, calc(14px + 1vh), 18px);">
                          <a class="" href="<?php echo e(route('blog_details', ['slug' => $blog->slug])); ?>">
                              <?php echo e(strlen(strip_tags($blog->title)) > 20 ? mb_substr(strip_tags($blog->title), 0, 20, 'UTF-8') . '...' : $blog->title); ?>

                          </a>
                      </h4>
                      <p class=" text-18px-500-blog mt-3" style="color: #616161;">
                          <?php echo e(strlen(strip_tags($blog->content)) > 120 ? mb_substr(strip_tags($blog->content), 0, 120, 'UTF-8') . '...' : $blog->content); ?>

                      </p>
                      <div class="mt-10">
                          <a href="<?php echo e(route('blog_details', ['slug' => $blog->slug])); ?>" class="text-white form-control text-center blog-button"><?php echo e(__('Read More')); ?></a>
                      </div>
                    </div>
                  </div>
              </article>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

</div>
    </section>
  <?php endif; ?>
  <!-- Blog-area end -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>
  'use strict';
  // console.log(brands,"brands")
    const baseURL = "<?php echo e(url('/')); ?>";

    
const selectElement =document.getElementById('car_brand');

const carBrands=["A.e.c.",
"Abarth",
"Abc",
"ABEL",
"ABI ",
"AC",
"Ac cars",
"Access",
"ACE ",
"ACE ",
"Adly",
"Adria ",
"Adria ",
"Advanced",
"Aebi",
"Aec",
"Aeon",
"Aermacchi",
"AHP",
"Airstream ",
"Aixam",
"AJP",
"AJS",
"Alfa Romeo",
"Allis chalmers",
"Alpine",
"Alvis",
"Ambassador",
"Amc",
"Ammann",
"ANDOVER",
"Antonio carraro",
"Apache",
"Applied sweeper",
"Aprilia",
"ARB",
"Arctic cat ",
"Ariel",
"Ariens",
"Armstrong",
"Arronbrook ",
"Artic cat",
"Artisan",
"Asia",
"Askoll",
"Aston Martin",
"Atala",
"Atlas ",
"Atul",
"Auburn",
"Audi",
"Ausa",
"Austin",
"Austin morris",
"Austinhealey",
"Auto Campers ",
"Auto Union",
"Autocruise ",
"Auto-explore ",
"Autohaus ",
"Autohomes ",
"Autosleeper",
"Auto-sleepers ",
"Auto-sleepers ",
"Autostar ",
"Auto-trail ",
"Aveling & porter",
"Aveling barford",
"Avondale ",
"Avondale ",
"Awd",
"Aws",
"Axon",
"B & i",
"B+i",
"Babboe",
"Bad Island Toyz",
"Bailey ",
"Bailey ",
"Bajaj",
"Bamby",
"Bamford",
"Baotian",
"Barford",
"Barossa",
"Bashan",
"Basis",
"Batavus",
"Bateman",
"Batribike",
"Bavaria ",
"Beameo",
"Beauford",
"BEDFORD",
"Bedford ",
"Bela ",
"Belarus",
"BENALU",
"Benelli",
"Benford",
"Benimar ",
"Benno Boost",
"Bentley",
"Bentley ",
"Bergamont",
"Berkeley",
"Bessacarr ",
"Bessacarr ",
"Beta",
"Better",
"Bianchi",
"Big Dog",
"Bigbear",
"Bilbos ",
"Bimota",
"Bitelli",
"Bk Bluebird ",
"Blaw knox",
"Bluroc Motorcycles",
"Bmc",
"BMI",
"BMW",
"BMW",
"BMW",
"Bob cat",
"Bobcat",
"Bolinder",
"Bollinger-munktells",
"Bomag",
"Bombardier",
"Bond",
"Boom",
"Borgward",
"Borum",
"Boss",
"Boss Hoss",
"BOUGHTON",
"Bova",
"Bradford",
"Bradshaw",
"Branford",
"Branson",
"Bridgestone",
"Briggs and stratton",
"Bristol",
"Bristol (blmc)",
"Britax",
"British trackstar",
"Brixton",
"Brockhurst",
"Brompton",
"BROSHUIS",
"Brough Superior",
"Brp",
"BSA",
"Bsa/triumph",
"Buccaneer ",
"Buccaneer ",
"Buckler",
"Buell",
"Bugatti",
"Buick",
"Bullit",
"Bullit Motorcycles",
"Bultaco",
"Bumblebee",
"Burlington",
"Burstner ",
"Butchers & Bicycles",
"BYD",
"C s special",
"C.v.s.",
"Cadillac",
"Cagiva",
"Calder Leisure ",
"Camper King ",
"Campervan Warehouse ",
"Camp-let ",
"Can-Am",
"Cannondale",
"Cannondale Cycles",
"Caofen",
"Carado ",
"Caravelair ",
"Carbodies",
"Caretta ",
"Carmichael",
"Carnaby ",
"Carthago ",
"CARTWRIGHT",
"Carver",
"Case",
"Case international",
"Case poclain",
"Caterham",
"Caterpillar",
"CCM",
"Ccs",
"Cectek",
"Celco profil",
"Cf moto",
"CFMOTO",
"Ch racing",
"Challenger ",
"Champ",
"Chang jiang",
"Chausson ",
"CHEREAU",
"Chesil",
"Chevrolet",
"Chevrolet ",
"Chevrolet ",
"Chevrolet gmc",
"CHIEFTAIN",
"Chituma",
"Chrysler",
"Chunlan",
"CI ",
"Ci motorhome",
"Citroen",
"Citroen ",
"Citroen ",
"Citymaster",
"Claas",
"Clark",
"Claud Butler",
"Clayson",
"CLAYTON",
"Club car",
"Coachman ",
"Coachman ",
"Coachmen",
"Cobra",
"Coles",
"Colnago",
"COLSON",
"Colt",
"Commander",
"Commer",
"Compass ",
"Compass ",
"CONCEPT",
"Concorde ",
"Conveyancer",
"Conway ",
"Corratec",
"CORUS",
"Corvette",
"Cosalt ",
"Cosmos",
"Cossack",
"Cotton",
"Countax",
"County comm cars",
"Coventry climax",
"Coventry eagle",
"Cox",
"CPI",
"CRANE FRUEHAUF",
"CROSSLAND",
"Cub",
"CUBE",
"Cupra",
"Cyclemaster",
"Cz",
"D.h. special",
"D.m.w.",
"Dacia",
"Dacia ",
"Daelim",
"Daewoo",
"DAF",
"DAF ",
"Daihatsu",
"Daihatsu ",
"Daimler",
"Dajiang",
"Dallian",
"Dallingridge",
"Damon ",
"Danbury ",
"Datsun",
"David brown",
"Dawes",
"Dax",
"Dayang",
"Dayun",
"De tomaso",
"DEKER",
"Delage",
"Delta ",
"Demag",
"Denby ",
"Dennis",
"DENNIS EAGLE",
"DENNISON",
"Derbi",
"Desiknio",
"Desperate dan",
"Dethleffs ",
"Deutz fahr",
"Devon ",
"DFSK",
"DFSK ",
"Di blasi",
"Di blassi",
"Diamond",
"Di-Blasi",
"Dieci",
"Direct Bike",
"Direct bikes",
"Dirt force",
"Dirt pro",
"Dkw",
"Dmw",
"Dodge",
"Dodge ",
"Dodge ",
"Dodge (usa)",
"Domino",
"DON-BUR",
"Dong feng",
"Donkervoort",
"Doosan",
"Dormobile ",
"Dot",
"Douglas",
"Dreamer ",
"Ds",
"DS Automobiles",
"Ducati",
"Ducati Cycles",
"Ducato",
"Dunelt",
"Dutton",
"Dynapac",
"Eagle",
"Easy Caravanning ",
"Easy rider",
"EAV",
"EBCO",
"Ebr",
"E-City Wheels",
"Ecooter",
"Elddis ",
"Elddis ",
"Electra",
"Electric Motion",
"Electric motorsport",
"Elnagh ",
"Emax",
"Emu",
"Energica",
"Enfield",
"Eovolt",
"Ep equipment",
"Epc",
"ERF",
"Eriba ",
"Eriba ",
"E-Rider",
"Eskuta",
"Esoro",
"Essex",
"Estarli",
"Eton",
"Etrusco ",
"Eura Mobil ",
"European Caravans ",
"EUROTRAILER",
"Evari",
"Excalibur",
"Excelisor",
"Excelsior",
"Explorer",
"Fabrique",
"Factory",
"Falcon",
"Fantic",
"Fantic Cycles",
"Fantic motor",
"FAYMONVILLE",
"FB Mondial",
"FELDBINDER",
"Fendt ",
"Fendt ",
"Ferguson",
"Fermec",
"Ferrari",
"Fiat",
"Fiat ",
"Fiat ",
"Fiatagri",
"Field marshall",
"Fifth Wheel ",
"Fleetwood ",
"Fleetwood ",
"Fleurette ",
"Florium ",
"Fn",
"Focus",
"FODEN",
"Ford",
"Ford ",
"Ford ",
"Ford roller team",
"Fordson",
"Fordsonmajor",
"Forest River ",
"Forme",
"Foster",
"Foton",
"Francisbarne",
"Francis-barnett",
"Frankia ",
"Fraser",
"Frazer nash",
"Frazier",
"Freedom ",
"Freestyle ",
"Freight rover",
"Freightliner ",
"FRUEHAUF",
"FSM",
"Fso cars",
"FUSO",
"FUSO ",
"Fym",
"Gardner douglas",
"Garelli",
"Garia ",
"Gas Gas",
"Gas Gas Cycles",
"GAZ ",
"Gazelle",
"Geist ",
"Gem",
"GENERAL TRAILER",
"GENERAL TRAILERS",
"GEOFF BURSE",
"Giantco",
"Gilera",
"GILESKIPS",
"GILESKIPS MANUFACTURERS LTD",
"Gillet",
"Gillet-herstal",
"Ginetta",
"Giott/line",
"Giottiline ",
"Globe car",
"Globecamper ",
"Globecar ",
"Globestar ",
"Globe-traveller ",
"Glutton",
"Gmc",
"Go Pod ",
"Gobur ",
"Gocycle",
"Going Uk ",
"Go-kart",
"GOLDHOFER",
"Go-pod ",
"Govecs",
"Gpx",
"GPX Moto",
"Grasshopper",
"GRAY & ADAMS",
"Great Wall ",
"Green machine",
"Greeves",
"Grinnall",
"Grove",
"Grove coles",
"GRW",
"Gsm",
"Gulfstream ",
"GURLESENYIL",
"Guy",
"H.r.d.",
"Haibike",
"Hako",
"Hamm",
"Hanway",
"Haotian",
"Harley-Davidson",
"Harris",
"HENRED FREUHAUF",
"Her che",
"Her chee",
"Herald",
"Herald Motor Co",
"Herald motor company",
"Hesketh",
"Hillman",
"Hillside Leisure ",
"Himiway",
"HINO",
"Hitachi",
"Hi-trac",
"Hm moto",
"Hobby ",
"Hobby ",
"Holden",
"Holdsworth ",
"Holeshot ",
"Homecar ",
"Honbike",
"Honda",
"Honda",
"Honda ",
"Honda ",
"Hongdou",
"Honley",
"Horizon ",
"Horwin",
"Hotchkiss",
"Hotomobil ",
"HOUGHTON PARKHOUSE",
"Howard",
"Hsun",
"Humber",
"Hummer",
"HUMVEE",
"Huoniao",
"Husaberg",
"Husqvarna",
"Hydrema",
"Hydrocon",
"Hymer ",
"Hymer ",
"Hyosung",
"Hyster",
"Hyundai",
"Hyundai ",
"Hyundai ",
"Ibis",
"Ideal",
"Ifa multicar",
"Ifamulticar",
"IFOR WILLIAMS",
"Ih Motorhomes ",
"Imt",
"Indian",
"INDOX",
"INEOS ",
"Infiniti",
"Inos ",
"Internationa",
"International",
"Iris.bus",
"Irizar",
"Iseki",
"Isuzu",
"ISUZU",
"Isuzu ",
"Isuzu trucks",
"Italjet",
"Itineo ",
"Iturri",
"IVECO",
"Iveco ",
"Iveco ",
"Iveco ford",
"J.c.",
"Jack allen",
"Jago",
"Jaguar",
"James",
"James comet",
"Japauto",
"Jawa",
"Jayco ",
"Jba",
"Jcb",
"Jeep",
"Jeep ",
"Jensen",
"Jialing",
"Jianshe",
"Jincheng",
"Jinling",
"Jinlun",
"Jinma",
"Jlg",
"Joa-camp ",
"John allen",
"John deere",
"John fowler",
"Johnson",
"JOHNSTON",
"Joint ",
"Jonway",
"Jotagas",
"Jowett",
"Joyner",
"Jumbo",
"Jzr",
"Kaisar",
"Kalkhoff",
"Kalmar",
"Kangda",
"Karcher",
"Karrier",
"KASSBOHRER",
"Kato",
"Kawasaki",
"Kazuma",
"Keen",
"Keeway",
"KEL-BERG",
"Kia",
"Kiden",
"KING",
"King long",
"Kingday",
"Kinroad",
"Kioti",
"Knaus ",
"Knaus ",
"Kockums",
"Kove",
"Kramer",
"Kramerallrad",
"KRONE",
"KSR Moto",
"KTM",
"KTM Cycles",
"Kuberg",
"Kubota",
"Kuma Bikes",
"Kurz",
"Kymco",
"Kynoch",
"La Mancelle ",
"La Strada ",
"Lada",
"LAG",
"Lagonda",
"Laika ",
"LAMBERET",
"Lambert",
"Lamborghini",
"Lambretta",
"Lancer",
"Lanchester",
"Lancia",
"Land Rover ",
"Landini",
"Landrover",
"LANGENDORF",
"Lansing bagnall",
"Lansing linde",
"Lansingbagna",
"Lanz bulldog",
"Lapierre",
"Larry vs Harry Bullitt",
"Laverda",
"LAWRENCE DAVID",
"LDV ",
"LDV ",
"Le Voyageur ",
"Leeway",
"LEGRAS",
"Leisuredrive ",
"LEVC",
"LEVC ",
"Levis",
"Lexmoto",
"Lexus",
"Leyland",
"Leyland aec",
"LEYLAND DAF",
"Leyland national",
"Lhy",
"Liebherr",
"Lifan",
"Lifton",
"Lincoln",
"Linde",
"Liner",
"Linhai",
"Lion Caravans ",
"Liv",
"LMC ",
"LMC ",
"LML",
"Locust",
"Lomax",
"Loncin",
"London taxis int",
"Longjia",
"Lonsdale",
"Lorain",
"Lotus",
"Lunar ",
"Lunar ",
"Lvneng",
"Lvtong",
"M & G",
"MAC",
"Machzone ",
"Maeving",
"Magirus deutz",
"Magni",
"MAGYAR",
"Mahindra",
"Maico",
"MAKES",
"Malaguti",
"Malibu ",
"MAN",
"MAN ",
"MAN ",
"Man/vw",
"Manet puch",
"Manitou",
"Manttx",
"Manx norton",
"Marcos",
"Marin",
"Marlin",
"Marquis ",
"Marshall",
"Martin conquest",
"Masai",
"Maserati",
"Mash",
"Mash Motorcycles",
"MASSEY",
"Massey ferguson",
"Massey-harris",
"Matador",
"Matbro",
"Matchless",
"Mathieu",
"MAXUS",
"MAXUS ",
"Mazda",
"Mazda ",
"Mazda ",
"Mbk",
"MBP",
"Mcc",
"MCCAULEY",
"Mccormick",
"Mccormick international",
"Mccoy",
"McLaren ",
"Mclellan",
"Mclouis ",
"Mcw",
"Mecalac",
"Meccanica",
"Megelli",
"MELTON",
"Mercedes",
"Mercedes-Benz",
"Mercedes-Benz",
"MERCEDES-BENZ",
"Mercedes-Benz ",
"Mercury",
"Merida",
"Merlo",
"METALLIX",
"Meteorite",
"Metrocab",
"Mev",
"Mf industria",
"Mf industrial",
"MG",
"MG ",
"MGB",
"Micro",
"Microcar",
"Midas",
"Mig",
"Miller ",
"Mini",
"MINI ",
"Mini otter",
"MiRider",
"Mitsubishi",
"MITSUBISHI",
"Mitsubishi ",
"Mitsubishi ",
"Mitsubishi fuso",
"Mk",
"Mobilvetta ",
"Mobylette",
"Modenas",
"Moke",
"Moncayo ",
"Mondial",
"Mondraker",
"Montesa",
"Montesa honda",
"MONTRACON",
"Mooveo ",
"Morelo ",
"Morgan",
"Morgan 3 wheeler",
"Morini",
"Morooka",
"Morris",
"Moss",
"Moto Guzzi",
"Moto Morini",
"Moto roma",
"Moto villa",
"Motobecane",
"Motoconfort",
"Motorini",
"Moto-trek ",
"Moustache",
"Moxy",
"MULDOON",
"Multione",
"Murvi ",
"Mutt",
"Muz",
"MV Agusta",
"Mz",
"Nanfang",
"Necht",
"Neco",
"Neoplan",
"Neval",
"New holland",
"New hudson",
"New imperial",
"New orleans",
"Newbot",
"Newbot storm 1",
"Nfm",
"Ng",
"Niesmann + bischoff",
"Niesmann And Bischoff ",
"Ninja",
"Nippi",
"Nissan",
"Nissan ",
"Nissan ",
"NIU",
"Noble",
"NOOTEBOOM",
"Norco",
"Norton",
"Norton villiers",
"Nostalgia cars",
"Nsu",
"Nu Venture ",
"Nubodi",
"Nuffield",
"Nutfield",
"Ok supreme",
"OLDBURY",
"Oldsmobile",
"Omar ",
"Opel",
"Optare",
"Opus ",
"Ora",
"Orbea",
"Orion ",
"OSET",
"Oshkosh",
"Ossa",
"Other ",
"Other ",
"Other Cars",
"Ovaobike",
"OZGUL",
"P+m",
"Packard",
"Panama ",
"PANELTEX",
"Panther",
"Paton",
"Paxster ",
"Peel",
"Pemberton ",
"Pembleton",
"Penman",
"Pennine Leisure ",
"Perodua",
"Peugeot",
"Peugeot",
"Peugeot",
"Peugeot ",
"Peugeot ",
"Pfautec",
"Pgo",
"Phoenix ",
"Piaggio",
"Piaggio ",
"Piktou",
"Pilgrim",
"Pilote ",
"Pinguely",
"Pioneer ",
"PLA ",
"Platinum Wave ",
"PLOWMAN",
"Poclain",
"Polaris",
"Polestar",
"Polski-fiat",
"Pontiac",
"Por",
"Porsche",
"Ppm",
"Proteus",
"Proton",
"Puch",
"Pulse",
"Pure",
"Pursang",
"Puzey",
"Pyrene",
"Qingqi",
"Quadski",
"Quadzilla",
"Quantum",
"Quasar",
"Raleigh",
"RALFO",
"Randger ",
"Ransomes jacobsen",
"Rapido ",
"Rau",
"Raw",
"Raynal",
"Rc Motorhomes ",
"Reform",
"Reformwerke",
"Regal ",
"Regent",
"Reimo Cmc ",
"Reliant",
"Renault",
"RENAULT",
"Renault ",
"Renault ",
"Renault ",
"Renault Trucks ",
"Renegade",
"Retreat ",
"Reva",
"Rewaco",
"RFN",
"RGNT",
"Rhon",
"Rickman",
"Ridgeback",
"Rieju",
"Riese & Muller",
"Riley",
"Rimor ",
"RMB ",
"Robin hood",
"Rocky Mountain",
"Rolba",
"ROLFO",
"Roller Team ",
"Rolling Homes ",
"Rolls Royce",
"Rolls/transit",
"Rolls-royce",
"Romahome ",
"Romet",
"Rooder m1",
"ROTHDEAN",
"Rover",
"Royal",
"Royal Alloy",
"Royal Enfield",
"Royale",
"RS ",
"Rudge",
"Ruston",
"R-vision ",
"S And L Motorhomes ",
"Saab",
"Sachs",
"Safari ",
"Saic",
"Saiting",
"Sakura",
"Same",
"Sampo",
"Samsung",
"Sanderson",
"Santana",
"Sanya",
"Sanyang",
"Sao",
"Sarolea",
"Sarolea manx",
"Scammell",
"SCANIA",
"SCARAB",
"Schaffer",
"SCHMIDT",
"SCHMITZ",
"Scomadi",
"Scorpa",
"Scott",
"SDC",
"SEA ",
"SEAT",
"SEAT",
"Secma",
"Seddon/atkinson",
"Segway",
"Setra",
"Shansu",
"Shelvoke",
"Shelvoke & drewry",
"Sherco",
"Shineray",
"Shire Conversions ",
"Shire Homes ",
"Siamoto",
"Silence",
"Silk",
"Simca",
"Simplon",
"Simson",
"Singer",
"Sinnis",
"Siromer",
"Skoda",
"Skygo",
"Skyteam",
"Slam",
"Slingshot",
"Smart",
"Smc",
"Solis",
"Sommer",
"Sonik",
"SOR",
"Sparta ",
"Specialized",
"SPITZER",
"Sporttec ",
"Sprite ",
"Sprite ",
"Spy racing",
"SsangYong",
"SsangYong ",
"Standard",
"Stark",
"Stark varg",
"STAS",
"Sterling ",
"Sterling ",
"Stewart",
"Steyr",
"Stirling eco",
"Stomp",
"Stothert and pitt",
"Stuart",
"Subaru",
"Suffolk",
"Sukida",
"Sumitomo",
"Sun Living ",
"Sunbeam",
"Sunbeam-talbot",
"Sunlight ",
"Sunra",
"Super",
"Super Soco",
"Superbyke",
"Surge",
"Surron",
"Suzuki",
"Suzuki",
"Suzuki ",
"Swift ",
"Swift ",
"Swm",
"SWM Motorcycles",
"Sym",
"T.m.c.",
"T.y.m",
"TAB ",
"Tabbert ",
"Tadano",
"Tafe",
"Taiwan golden bee",
"Talaria",
"Talbot ",
"Talbot ",
"Talus",
"Tamoretti",
"Tasker",
"Tata",
"Tbm",
"TCL",
"Teahupoo ",
"TEC ",
"TEC ",
"Temsa",
"Tenaci-Wong",
"Terberg",
"Terex",
"Tern",
"Terrot",
"Tesla",
"TGB",
"Tgs",
"Thelmoco",
"Thok",
"THOMPSON",
"Thor Motor Coach ",
"Thornycroft",
"Thumpstar",
"Thwaites",
"Tiffin Motorhomes ",
"TIGER",
"TIGER TRAILERS",
"Timberland ",
"Tinbot",
"Tingdene ",
"TITAN",
"TM",
"Tm racing",
"Tomos",
"Tong yang",
"Toro",
"Torrot",
"Toyota",
"Toyota ",
"Toyota ",
"Trabant",
"Tracgrip",
"Transcamper ",
"Trek",
"Tribute ",
"Trigano ",
"Trigano ",
"Trikeshop",
"Tri-tech",
"Triton",
"Triumph",
"Trojan",
"Tromox",
"TRS",
"Trsi trs",
"TRUCKMATE",
"Tula",
"Turner-miesse",
"Tvr",
"Tym",
"Ultima",
"Ultra",
"UM",
"Unimog",
"Universal",
"Unknown",
"Uqi",
"Ural",
"Urban",
"Urban Arrow",
"Ursus",
"UTILITY",
"VALLELY",
"Valmet",
"Valtra",
"VAN HOOL",
"Vanden plas",
"Vanmaster ",
"Vantage ",
"Vanworx ",
"Vauxhall",
"Vauxhall ",
"Vauxhall ",
"Vectrix",
"Velimotor",
"Velocette",
"Veloe",
"Velosolex",
"Velsar ",
"Venture",
"Verteci",
"Vertigo",
"Vespa",
"Vespa (douglas)",
"Victory",
"Victory ",
"Viking",
"Vincent",
"Vmoto",
"Voge",
"Vogele",
"Volkswagen",
"Volkswagen ",
"Volkswagen ",
"Volkswagen ",
"Volt",
"Volvo",
"VOLVO",
"Volvo ",
"Vor",
"Vulcan",
"Waaijenberg",
"Wacker neuson",
"Walker",
"Walker mower",
"Wasp",
"Weatherill",
"Weidemann",
"WEIGHTMASTER",
"Weinsberg ",
"Weinsberg ",
"Wellhouse ",
"Westfalia ",
"Westfield",
"Westwood",
"WHALE",
"WHEELBASE",
"Wheelhome ",
"White",
"White knuckle",
"Whitlock bros",
"WILCOX",
"Wildax ",
"Willerby ",
"Willys",
"WILSON",
"Wingamm ",
"Wingamm ",
"Winget",
"Winnebago ",
"Wirtgen",
"Wirtgen hamm",
"Wisper",
"WK Bikes",
"Wolseley",
"Wraith",
"Wrightbus",
"Xingyue",
"Xinling",
"Xiongtai",
"X-sport",
"Yadea",
"Yale",
"Yamaha",
"Yamaha Cycles",
"Yamasaki",
"Yanmar",
"Yucon ",
"Zastava",
"Zero",
"Zeths",
"Zetor",
"Zhenhua",
"Zhongneng",
"Znen",
"Zongshen",
"Zontes",
"Zundapp",
]
const carBrandsModified = carBrands.map(a=>({"name": a, "slug": a.toLowerCase()}));

if (true) {
  carBrandsModified.forEach(function(brand){
    const option = document.createElement('option');
    option.value= brand.slug
    option.textContent = brand.name
    selectElement.appendChild(option);
  });
}


  $(document).ready(function() {
  

  sessionStorage.setItem('tabCategory', 'cars-&-motors');
  $(document).ready(function() {
    // Loop through each category item
    $('[id^="filterCSS"]').each(function(index, element) {
        var $element = $(element);
        var filterValue = $element.css('filter');  // Get current filter value
        if (index === 0) {  // Modify condition as needed
            $element.css('filter', '');  
        }
        else if (index === 14){
          $element.css('filter', '');  
        }
        else if (index === 10){
          $element.css('filter', '');  
        }
        else if (index === 23){
          $element.css('filter', '');  
        }
    });
});
  



// Simulating data loading
   setTimeout(function() {
        $('.skeleton').hide(); // Hide skeletons
        // $('.loading-section').fadeIn()
        $('.loading-section').removeClass('loading-section');
        
    }, 2000); // Adjust the timeout according to your actual data loading time
    // Toggle active class on click
    $('.nav-link').on('click', function() {

      $('.nav-item').removeClass('active');
      $('.nav-link').css('border', '0px');
      
      $('.nav-link').css('color', 'black');
      $('.nav-link i').css('color', 'gray');
     
      let current_obj = $(this); 
      current_obj.css('color', '#1D86F5');
      current_obj.find('i').css('color', '#1D86F5');
  });



  // Function to adjust the tab heights
  function adjustTabHeight() {
    let maxHeight = 0;

    // Find the maximum height of the tab panes
    $('.tab-pane').each(function() {
      const thisHeight = $(this).outerHeight();

      if (thisHeight > maxHeight) {
        maxHeight = thisHeight;
      }
    });

    // Set the same height for all tab panes
    $('.tab-pane').css('min-height', maxHeight + 'px');
  }

  // Call the adjustTabHeight function when the document loads
    adjustTabHeight();

  // Call adjustTabHeight on tab change
  $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function() {
    adjustTabHeight(); // Adjust the height after a new tab is 
    
  });

  var popups = [];
  var stopLoop = false; // This flag will control whether to stop the loop.

  // Collect all popup data into the array
  $('.popup-wrapper').each(function() {
    var delay = $(this).data('popup_delay');   // Get delay attribute
    var popupId = $(this).data('popup_id');    // Get id attribute
    var priority = $(this).data('popup_priority'); // Get priority attribute

    // Push the popup data into the array
    popups.push({ delay: delay, popupId: popupId, priority: priority });
  });

  // Sort the popups array by priority (ascending order)
  popups.sort(function(a, b) {
    return a.priority - b.priority;
  });

  // Recursive function to loop through the modals and start over
  function showPopups(index) {
    if (index >= popups.length) {
      // Once all modals have been shown, start over
      index = 0;
    }

    // Stop the loop if flag is true
    if (stopLoop) return;

    var popup = popups[index];
    var popupElement = $('#modal-popup-' + popup.popupId);

    // Check if the popup element exists in the DOM
    if (popupElement.length > 0) {
      // Set timeout based on delay and show the modal
      setTimeout(function() {
        // Stop the loop if flag is true
        if (stopLoop) return;

        // Get the content of the popup with the corresponding id
        var popupContent = popupElement.html();

        // Insert the content into the modal body
        $('#popup_body').html(popupContent);

        // Show the modal
        $('#popupModals').modal('show');

        // When the modal is fully hidden, stop the loop
        $('#popupModals').on('hidden.bs.modal', function() {
          stopLoop = true; // Stop the loop when the modal is closed
        });

        // Move to the next modal after the current one is displayed
        showPopups(index + 1);

      }, popup.delay * 1000); // Multiply by 1000 to convert delay from seconds to milliseconds
    } else {
      // If the popup doesn't exist, move to the next one immediately
      showPopups(index + 1);
    }
  }

  // Start the modal display process
  showPopups(0);
});

setTimeout(() => {
  
  function formatCurrency(number) {
    return '£' + new Intl.NumberFormat('en-GB', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(number);
}

function formatAllPrices() {
    $('.poundPrice').each(function() { // Use class selector instead of ID
        var priceElement = $(this);
        var price = parseFloat(priceElement.data('price'));
        priceElement.text(formatCurrency(price));
      });
    }
    
    formatAllPrices();
  }, 2000);


$(document).ready(function() {
    // Store all the original options of max year dropdown
    var $yearMax = $('#year_max');
    var originalOptions = $yearMax.find('option').clone();

    $('#year_min').change(function() {
        var selectedMinYear = parseInt($(this).val());

        // Reset max year dropdown
        $yearMax.empty().append('<option value=""><?php echo e(__("Max Year")); ?></option>');

        // Filter and add options greater than the selected min year
        originalOptions.filter(function() {
            var yearValue = parseInt($(this).val());
            return yearValue === "" || yearValue > selectedMinYear;
        }).appendTo($yearMax);

        // Trigger change event on max year dropdown to update any dependent elements
        $yearMax.trigger('change');
    });
});
$(document).ready(function() {
    // Function to format number as currency without symbol
    function formatCurrency(number) {
        return new Intl.NumberFormat('en-GB', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(number);
    }

    // Store all the original options of max price dropdown
    var $priceMax = $('#max');
    var originalOptions = $priceMax.find('option').clone();

    // Format initial options
    $('#min option, #max option').each(function() {
        var value = $(this).val();
        if (value !== "") {
            $(this).text(formatCurrency(parseInt(value)));
        }
    });

    $('#min').change(function() {
        var selectedMinPrice = parseInt($(this).val());
        $priceMax.empty().append('<option value=""><?php echo e(__('Max Price')); ?></option>');
        originalOptions.filter(function() {
            var priceValue = parseInt($(this).val());
            return priceValue === "" || priceValue > selectedMinPrice;
        }).each(function() {
            var $option = $(this).clone();
            if ($option.val() !== "") {
                $option.text(formatCurrency(parseInt($option.val())));
            }
            $option.appendTo($priceMax);
        });
        $priceMax.trigger('change');
    });
});

</script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('frontend.layouts.layout-v' . $version, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/home/index-v2.blade.php ENDPATH**/ ?>