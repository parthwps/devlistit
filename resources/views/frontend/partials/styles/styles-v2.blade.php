<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('assets/front/css/vendors/bootstrap.min.css') }}">
<!-- Data Tables CSS -->
<link rel="stylesheet" href="{{ asset('assets/front/css/vendors/datatables.min.css') }}">
<!-- Fontawesome Icon CSS -->
<link rel="stylesheet" href="{{ asset('assets/front/fonts/fontawesome/css/all.min.css') }}">
<!-- Icomoon Icon CSS -->
<link rel="stylesheet" href="{{ asset('assets/front/fonts/icomoon/style.css') }}">
<!-- NoUi Range Slider -->
<link rel="stylesheet" href="{{ asset('assets/front/css/vendors/nouislider.min.css') }}">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="{{ asset('assets/front/css/vendors/magnific-popup.min.css') }}">
<!-- Swiper Slider -->
<link rel="stylesheet" href="{{ asset('assets/front/css/vendors/swiper-bundle.min.css') }}">
<!-- Nice Select -->
<link rel="stylesheet" href="{{ asset('assets/front/css/vendors/nice-select.css') }}">
<!-- AOS Animation CSS -->
<link rel="stylesheet" href="{{ asset('assets/front/css/vendors/aos.min.css') }}">
<!-- Animate CSS -->
<link rel="stylesheet" href="{{ asset('assets/front/css/vendors/animate.min.css') }}">
{{-- whatsapp css --}}
<link rel="stylesheet" href="{{ asset('assets/css/floating-whatsapp.css') }}">
{{-- toast css --}}
<link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
{{-- tinymce-content custom css --}}
<link rel="stylesheet" href="{{ asset('assets/front/css/tinymce-content.css') }}">

<!-- Main Style CSS -->
<link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
<!-- Responsive CSS -->
<link rel="stylesheet" href="{{ asset('assets/front/css/responsive.css') }}">

{{-- dropzone css --}}
<link rel="stylesheet" href="{{ asset('assets/css/dropzone.min.css') }}">

{{-- atlantis css --}}
<link rel="stylesheet" href="{{ asset('assets/css/atlantis_custom.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
{{-- rtl css are goes here --}}

@if ($currentLanguageInfo->direction == 1)
  <link rel="stylesheet" href="{{ asset('assets/front/css/rtl.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/front/css/rtl-responsive.css') }}">
@endif

<style type="text/css">

.social-link i
{
    margin-top:10px;
}

.blur-up.ls-is-cached.lazyloaded
{
  object-fit: contain;    
}

.us_parent_cls .blur-up.lazyloaded
{
    object-fit: contain; 
}

.user-img .ls-is-cached.lazyloaded
{
    object-fit: contain; 
}

.us_object_fit
{
     object-fit: contain; 
}

.dz-error-mark, .dz-error-mark svg 
{
    pointer-events: auto;
}

.mfp-close-btn-in .mfp-close 
{
    top: 25px !important;
    right: -5px;
}

img.mfp-img 
{
    max-height: 500px !important;
}

.mfp-thumbnails 
{
    position: fixed; /* Fixed position to stay in view */
    bottom: 0; /* Stick to the bottom */
    right: 0; /* Align to the right */
    width: 100%; /* Full width for horizontal scrolling */
    height: 120px; /* Height of the thumbnails container */
    display: flex;
    flex-direction: row; /* Stack thumbnails horizontally */
    overflow-x: auto; /* Allow horizontal scrolling */
    overflow-y: hidden; /* Hide vertical overflow */
    padding: 10px 0;
    gap: 10px; /* Spacing between thumbnails */
    background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    z-index: 9999; /* Ensure it's on top of other elements */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Optional: add shadow */
}

.mfp-thumb {
    width: 100px; /* Fixed width for thumbnails */
    height: auto; /* Maintain aspect ratio */
    border: 1px solid #ccc; /* Border around thumbnails */
    padding: 5px; /* Padding inside the box */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Optional: add shadow */
    cursor: pointer;
    transition: transform 0.2s ease;
}

.mfp-thumb:hover {
    transform: scale(1.05); /* Slight zoom on hover */
    opacity: 0.8;
}

.mfp-img 
{
    max-width: calc(100% - 120px); /* Ensure the main image fits with the thumbnails */
    margin-right: 20px; /* Space between image and thumbnails */
}

.mfp-container {
    max-width: 100%; /* Fit container width to main image and thumbnails */
}



  .slider-navigation .slider-btn 
  {
   
    -webkit-backdrop-filter: blur(0px) !important;
    backdrop-filter: blur(0px)!important;
    
  }
    .us_list_downside
    {
        top: auto !important;
        bottom: 10px !important; 
    }
    
    @media screen and (max-width: 580px) 
    {
        .short_code 
        {
            display:none;
        }
        
        .us_filters_btns
        {
            margin-top:1rem;
        }
        #filter_btnn
        {
            display:block !important;
        }
        
        .us_hidden_by_default
        {
            display:none;
        }
    }
    
    .short_code
    {
        margin-right: 5px;
    }
    
    .custom-select 
    {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .custom-select select 
    {
        display: none; /* Hide default dropdown */
    }
    
    .select-selected 
    {
        font-size:13px;
        border-radius: 5px;
        margin-right: 5px;
        background-color: #ffffff;
        padding-right: 23px !important;
        padding: 10px;
        border: 1px solid #ccc;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

        .select-items {
            position: absolute;
            background-color: #fff;
            border: 1px solid #ddd;
            z-index: 99;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
        }

        .select-items div {
            padding: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .select-items div:hover {
            background-color: #f1f1f1;
        }

        .flag {
            width: 20px;
            height: auto;
            margin-right: 10px;
        }

        .search-box {
            padding: 10px;
        }

        .search-box input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .select-hide {
            display: none;
        }
        
        
     .password-container {
        position: relative;
        width: 100%;
    }
    
    .eye-icon {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #aaa;
    }
    
    .eye-icon i {
        font-size: 20px;
    }



    .us_share_icon
    {
       
        right: 60px !important;
    }
    
    .close
    {
        color: gray !important;
    }
    
       @media only screen and (max-width: 768px)
    {
        .us_grid_shared
        {
            right: 60px !important;
            bottom: 4% !important;
        }
        
        .us_share_icon
        {
            padding-right: 15px;
        }
        
        .product-column .btn-icon 
        {
            padding-right: 0px;
        }
    }
    
    .fal.fa-heart
    {
        color:#ccc !important;
            font-size: 25px;
    }
    
     .fa.fa-heart
    {
        font-size: 25px;
    }
    
    
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button 
    {
        -webkit-appearance: none;
        margin: 0;
    }
    
    /* Firefox */
    input[type="number"] 
    {
        -moz-appearance: textfield;
    }


    #_hj_feedback_container 
    {
        display: none !important;
    }

    .modal
    {
        background-color: rgba(0, 0, 0, 0.4);
    }

    .range_container 
    {
        text-align: center;
        color: #8d9498;
        font-size: 15px;
        margin: 5px;
    }
    .range-container {
        position: relative;
        width: 100%;
        margin: 0 auto;
    }
    .range-container input[type="range"] {
        width: 100%;
        margin: 0;
    }
    .range-container .number-labels {
        display: flex;
        justify-content: space-between;
        position: absolute;
        top: -20px;
        left: 0;
        right: 0;
    }
    .range-container .text-labels {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }
        
    .chat-app .chat-history 
    {
        height: auto !important;
    }
    
    .us_com_flexs 
    {
        background: white;
        position: -webkit-fixed;
        position: fixed;
        top: 65px;
        z-index: 1000;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0px 0px 10px gray;
    }

    /*.listing-single-area .product-single-gallery .slider-btn.slider-btn-prev */
    /*{*/
    /*    width: 20px;*/
    /*    font-size: 30px;*/
    /*    font-weight: bold;*/
    /*    background: none;*/
    /*    left: -45px;*/
    /*}*/
    
    /*.listing-single-area .product-single-gallery .slider-btn.slider-btn-next */
    /*{*/
    /*    background: none;*/
    /*    right: -25px;*/
    /*    width: 20px;*/
    /*    font-size: 30px;*/
    /*}*/
    
    .go-top
    {
        width: 45px;
        height: 45px;
        border-radius: 50%;
    }

    .whatsapp-popup {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 300px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            font-family: Arial, sans-serif;
            z-index: 1000;
            display: none;
        }
        .whatsapp-header {
            background-color: #25D366;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .whatsapp-header .title {
            font-size: 16px;
        }
        .whatsapp-header .close {
            cursor: pointer;
        }
        .whatsapp-body {
            background-color: #f0f0f0;
            padding: 10px;
            border-bottom:1px solid white;
        }
        .whatsapp-body .message {
            background-color: white;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .whatsapp-footer {
            padding: 10px;
            text-align: center;
                background: white;
        }
        
       
        
        .whatsapp-footer .start-chat {
            width: 100%;
            background-color: #25D366;
            color: white;
            padding: 5px 20px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
        }
        .whatsapp-button 
        {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #25D366;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            z-index: 1000;
        }
        .whatsapp-button img {
            width: 30px;
            height: 30px;
        }
        
        
    .modal-backdrop.show 
    {
        opacity: 0.5; /* Adjust the opacity to dim the background */
        background-color: black; /* Change the background color to black for dimming effect */
    }
    
    .btn-info 
    {
        background: var(--color-primary) !important;
        border-color: var(--color-primary)  !important;
    }

    .btn-success:hover, .btn-success:focus, .btn-success:disabled 
    {
        background: var(--color-primary) !important;
        border-color: var(--color-primary)  !important;
    }

    .btn-success 
    {
        background: var(--color-primary) !important;
        border-color: var(--color-primary)  !important;
    }

    .btn-primary 
    {
        background: var(--color-primary) !important;
        border-color: var(--color-primary)  !important;
    }
    
    .listing-single-area .btn-outline:hover 
    {
        background-color: var(--color-primary)  !important;
    }
    
    .btn-primary:hover, .btn-primary:focus, .btn-primary:disabled 
    {
        background: var(--color-primary)  !important;
        border-color: var(--color-primary)  !important;
    }
    
    .cumButton:hover 
    {
        border: 1px solid  var(--color-primary)  !important;
        color:  var(--color-primary)  !important;
    }

    .us_wishlist2
    {
        background: none !important;
        border: none !important;
        font-size: 20px !important;
        color: red !important;
    }
    
    .us_com_heading
    {
        color:#474747;
        font-size: 27px;
        margin-top: 22px;   
    }
    
    .us_com_subheading
    {
        font-size: 14px;
        display: block;
    }
    
    .custom-select 
    {
        position: relative;
        display: inline-block;
        width: 100%;
        margin-top: 10px;
        margin-bottom: 20px;
    }

    /* Hide the default dropdown arrow */
    .custom-select select 
    {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
        background-image: none;
    }

    /* Add a custom dropdown arrow */
    .custom-select::after 
    {
        content: '▼';
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        pointer-events: none;
        font-size: 13px;
        color: #a1a1a1;
    }

    /* Optional: styling to keep the select element aligned with the custom arrow */
    .custom-select select:focus 
    {
        outline: none;
        border-color: #007bff;
    }
        
    .overlay 
    {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(128, 128, 128, 0.5); 
        z-index: 2; 
    }
    
    .mfp-close
    {
       cursor:pointer !important; 
    }
    
    .ellipsis_n 
    {
        width: 200px; 
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 16px; 
        line-height: 1.2; 
    }

    .listing-single-area .product-thumb 
    {
        bottom: inherit;
        margin-top: 12px;
    }
    
    .us_username_deks
    {
        display:inline-block;
    }
    
    .us_username_mob
    {
        display:none;
    }
    
    .us_timings
    {
        MARGIN-LEFT: 2rem;
        color: gray; 
        font-weight: 200;
    }
    
    .us-card-width
    {
        width: 25rem;
    }
    
        .us_card_margin
        {
            margin-left:5rem;
        }
        
        .us_card_img
        {
            height:250px;
        }
        
        .product-single-slider {
        position: relative;
        overflow: hidden;
        }
        
        .slider-navigation {
        position: absolute;
        top: 50%;
        width: 100%;
        display: flex;
        justify-content: space-between;
        transform: translateY(-50%);
        z-index: 2; /* Ensure the buttons are on top of everything else */
        pointer-events: none; /* Prevent blocking interactions with the slider */
        }
        
        /* Button styles */
        .slider-btn {
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        font-size: 24px;
        padding: 10px;
        border: none;
        cursor: pointer;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        pointer-events: auto; /* Enable button clicks */
        z-index: 3; /* Ensure the button is clickable and on top */
        }
        
        .slider-btn-prev {
        position: absolute;
        left: -100px; /* Move it further outside */
        top: 50%;
        transform: translateY(-50%);
        }
        
        .slider-btn-next {
        position: absolute;
        right: -100px; /* Move it further outside */
        top: 50%;
        transform: translateY(-50%);
        }
        
        /* Keep slides behind the buttons */
        .swiper-slide {
        position: relative;
        z-index: 1; /* Ensure slides stay behind the buttons */
        }
        
        /* Wrapper should stay behind the buttons */
        .swiper-wrapper {
        position: relative;
        z-index: 1; /* Keep the slider behind the navigation */
        }
        
        /* Small screen adjustments */
        @media (max-width: 768px) {
        .slider-btn {
            font-size: 20px;
            width: 35px;
            height: 35px;
        }
        
        .slider-btn-prev {
            left: -70px; /* Adjust for smaller screens */
        }
        
        .slider-btn-next 
        {
            right: -70px; /* Adjust for smaller screens */
        }
        }
        
        .us_imgs_carosals
        {
            padding-right:30px;
            padding-left:30px;
            background:white;
        }
        
        .slider-btn
        {
            height:30px !important;
            width:30px !important;
            border-radius: 50% !important;
            font-size: 35px !important;
            color: gray !important;
            border: 1px solid #ffffff8a !important;
        }
                
    
    @media only screen and (min-width: 1200px) and (max-width: 1399px) 
    {
        .set_height
        {
            height:360px !important;
        }
        .us_wishlist
        {
            bottom:20% !important;
            font-size:20px !important;
        }
        
        .us_absolute_position
        {
            bottom: 2%;
            position: absolute;
        }
        
        .us_price_icon
        {
            line-height:20px;
        }
        .us_mr_15
        {
            margin-left:5px !important;
        }
        
        .us_front_ad
        {
            bottom: 28% !important;
        }
    }
    
    .us_set_height
    {
        height:360px;
    }
    
    
    .us_absolute_position_front
    {
        bottom: 2%;
        position: absolute;
    }
    
    .us_detail_heoght
    {
        height:150px !important;
    } 
    
    
    .image-container 
    {
        width: 100%; /* Adjust as needed */
        max-height: 250px; /* Set the desired fixed height */
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        background-color: #f0f0f0; /* Optional, for better visibility */
    }
    
    .image-container img 
    {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover; /* Maintains aspect ratio */
    }
    
    .us_dropzone
    {
        padding: 1px !important;
    }
        
     @media only screen and (min-width: 387px) and (max-width: 767px) 
    {
        
        
        #removeBTN
        {
            bottom: 45px !important;
        }
    }
    
    .us_recent_pro
    {
        padding: 3rem;
    }
    
    .steps-area
    {
        box-shadow: 0px 0px 10px gray;
        border-radius: 20px; 
    }
    
    .product-area
    {
        box-shadow: 0px 0px 10px gray;
        border-radius: 20px; 
    }
    
    .category-area
    {
        box-shadow: 0px 0px 10px gray;
        border-radius: 20px; 
    }
    
    .choose-area 
    {
        box-shadow: 0px 0px 10px gray;
        border-radius: 20px; 
        padding-bottom:0px !important;
        padding-top:40px !important;
    }
    
    .blog-area 
    {
        padding-top: 3rem;
        box-shadow: 0px 0px 10px gray;
        border-radius: 20px; 
    }
    
    .hero-banner
    {
        box-shadow: 0px 0px 10px gray;
        border-radius: 20px; 
    }
    
    .us_font_price
    {
        font-size:20px;
    }
      @media only screen and (max-width: 380px)
    {
        .us_card_parent
        {
            padding: 15px 5px 0px 5px !important;
        } 
        
          .us_custom_height
        {
            height:375px !important;
        }
        
        .us_font_price
    {
        font-size:14px !important;
    }
    
    }
    
      @media only screen and (min-width: 381px) and (max-width: 575px)
    {
          .us_custom_height
        {
            height:420px !important;
        }
        
            .us_font_price
    {
        font-size:16px !important;
    }
       
    }
    
    
   @media only screen and (min-width: 576px) and (max-width: 765px) {
    .us_custom_height {
        height: 475px !important;
    }
}


 @media only screen and (min-width: 767px) and (max-width: 991px) {
    .us_custom_height {
        height: 400px !important;
    }
    
           .us_font_price
    {
        font-size:16px !important;
    }
    
}

@media only screen and (min-width: 992px) and (max-width: 1199px) {
    .us_custom_height {
        height: 370px !important;
    }
    
           .us_font_price
    {
        font-size:16px !important;
    }
    
}


@media only screen and (min-width: 1200px) and (max-width: 1400px) {
    .us_custom_height {
        height: 400px !important;
    }
    
           .us_font_price
    {
        font-size:16px !important;
    }
    
}

    
    .us_card_parent
    {
        border-bottom: 1px solid #e9e9e9;
        padding: 15px 30px 0px 30px;
    }
    
     .us_custom_height
        {
            height:450px;
        }
        
        @media only screen and (min-width: 769px)
    {
            .choose-area 
        {
            margin: 2rem;
        }
    
        .category-area
        {
            margin: 2rem;
        }
        
        .hero-banner
        {
             margin: 2rem;
             margin-top: 7rem !important;
        }
        
       
        
        .us_absolut_position
        {
            position: absolute;
            bottom: 2%;
        }
        
      .us_absolut_position_with_boost
        {
            position: absolute;
            bottom: 50px;
        }
        
        .steps-area
        {
            margin: 2rem;
        }
        
        .product-area
        {
            margin: 2rem ;
        }
        
        .blog-area 
        {
            margin: 2rem;
        }
    
    }
    .us_socail_links
        {
            display:none;
        }
        
        .us_share_laptop_view
        {
             display:block; 
        }
        
    
       @media only screen and (max-width: 768px)
    {
        .social-link a {
    
            width: 30px !important;
            height: 30px !important;
            line-height: 30px !important;
        }
        
        .justify-content-end {
             margin-top: 1rem;
        }
        
        .us_socail_links
        {
            margin-right:1rem;
            display:block !important;
        }
        
        .us_share_laptop_view
        {
             display:none !important; 
        }
        
        .choose-area 
        {
            margin: 1rem !important;
        }
        
        .blog-area 
        {
            margin: 1rem !important;
        }
        
        .blog-area .title
        {
            text-align: center;
            font-size:25px;
        }
        
        .product-area
        {
            margin: 1rem !important;
        }
        
        .choose-area .title
        {
            text-align: center;
            font-size:25px;
        }
        
        
        .product-area .title
        {
            font-size:25px;
        }
        
         .product-area .title
        {
            font-size:25px;
        }
        
        .steps-area .card {
            margin-top : 25px !important;
        }
            
         .steps-area
        {
            margin: 1rem !important;
        }
        
        .steps-area .title
        {
            font-size:25px;
        }
        
        .category-title img
        {
            width: 50px;
            display: block;
            margin-bottom: 1rem;
        }
        
        .category-title
        {
                font-size: 15px;
        }
        
        .category-area
        {
            margin: 1rem !important;
        }
    
        .us_homeclmn
        {
            padding:0px !important;
        }
        
        .hero-banner-2 
        {
            
            margin: 6rem 1rem 2rem 1rem !important;
        }
        
        .us_recent_pro
        {
            padding: 2rem 0px !important;
        }
    
        #removeBTN
        {
            right: 0;
            position: absolute;
            margin-right: 2.4rem;
            width: auto !important;
            bottom: 0;
        }
        
            .us_com_heading
        {
            font-size: 20px !important;
        }
    
        .us_com_subheading
        {
            font-size: 11px !important;
        }

        .us_mrg
        {
          margin-left:1rem;  
        }
        
          .us_pro_mrg
        {
            margin-top: -15px;
        }
        .us_footer_div
        {
            float: left;
            margin-left: 1rem;
            margin-top: 10px;
            margin-bottom: 10px;
        }
         .us_wishlist2
        {
            top: -15px!important;
            position:relative !important;
            left:75%;
        }
        .us-card-width
        {
            width: 11rem;
            font-size: 12px;
        }
        .us_card_margin
        {
            margin-left:1rem;
        }
        .us_card_img
        {
            height:150px !important;
        }
        .us_card_title
        {
            font-size:14px;
        }
        .us_card_body
        {
            padding:10px !important;
        }
    } 
    
    .us_grid_width
        { 
            display: inline-block;
            min-width: 100%;
            width: 200px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        
     .us_grid_widths
        { 
            display: inline-block;
            min-width: 100%;
            width: 200px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        
        .us_trusted
        {
            margin-top:1rem;
        }
        
    @media only screen and (max-width: 575.98px) 
    {
            
        .us_trusted
        {
            margin-top: 0rem !important;
            position: absolute !important;
            margin-left: 5rem !important;
            top: 65px !important;
        } 
    
    .product-default .author img 
    {
        height: 70px !important;
    }
    
    .us_com_btun
    {
        margin-top: 62px !important;
         margin-left: 0px !important;
        position: absolute;
        width: 81%;
    }
    .us_com_flex
    {
            margin-bottom: 3rem;
    }
        
    .us_child_div
    {
        line-height: 16px !important;
    }
    
    .us_wishlist
    {
        bottom:5% !important;
    }
    
    .us_front_ad
    {
        bottom: 30% !important;
    } 
    .us_timings
    {
        FONT-SIZE: 12px;
    }
    
    .us_username_deks
    {
        display:none !important;
    }
    
    .us_username_mob
    {
        display:inline-block !important;
    }
    
    .us_hide_td
    {
        display:none;
    }
    
    .us_mrgn_td
    {
        margin-top:1rem !important;
    }
    
    .us_mrgn_btm_td
    {
        margin-bottom:1rem !important;
    }
    
    .us_img_cust
    {
        margin-left: 5px !important;
        height: 50px !important;
        width: 50px !important;
        border-radius: 50% !important;
        margin-top: -20px;
    }
    
    .us_td_img
    {
        width: 50px;
    }
    
    .us_removeboxes
    {
        position: absolute;
        margin-top: 20px;
        left: 10%;
    }
    
    /*.hero-banner .banner-filter-form .nav-tabs .nav-link */
    /*{*/
    /*    font-size: 12px;*/
    /*    margin-top: -2rem;*/
    /*    margin-bottom: 2rem;*/
    /*}*/
    
    .btnCustom
    {
        font-size:10px !important;
    }
    
    .us_checkbox_zoom
    {
        zoom: 1.3 !important;
    }
  
    .us_font_messge
    {
      font-size:12px;
    }
    
}

.us_checkbox_zoom
    {
        zoom: 1.5;
    }
    
  .card .card-footer, .card-light .card-footer 
    {
        border-top: 2px solid #ffffff !important;
    }
.product-column .btn-icon {
    z-index: 10;
}



@media screen and (max-width: 450px) 
{
    .us_hider
    {
        display:none;
    }
    .us_button_st
    {
        z-index: 10;
        bottom:2px !important;
        margin-right:10.5rem;
    }
    .us_sing_doub
    {
        z-index:10;
        left: 20px;
        width: 90% !important;
        right: 0px !important;
         position: fixed;
        bottom: 20px;
        padding: 10px 20px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    
    .go-top
    {
            bottom: 20px;
        left: 7%;
    }

   .sticky-button 
     {
        z-index:10;
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 10px 20px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    } 
    
}


 .original_text
    {
        display:block;
    }
    
    .mobile_icon
    {
        display:none;
    }
    
.us_design
{
    height: auto;
    width: 300px;
    max-width: 300px ;    
}

  .select2-selection__rendered 
  {
    line-height: 42px !important;
}
.select2-container .select2-selection--single {
    height: 45px !important;
}
.select2-selection__arrow {
    height: 44px !important;
}
.fa-twitter:before {
    content: "𝕏";
    font-size: 1.2em;
}

.dz-details
{
    display:none !important; 
}

.modal-backdrop.fade.show
{
  display: none !important;  
}

.usCumButton {
    font-size: 15px !important;
    border-radius: 3px !important;
    padding: 10.5px 18.5px !important;
    font-weight: 400 !important;
    letter-spacing: 0.05em !important;
    border: 1px solid #EE2C7B !important;
    color: #EE2C7B !important;
}
.us_mrg
{
    /*margin:10px;*/
}


@media (min-width: 768px) and (max-width: 1400px) {
    .us_mrg {
        margin: 0px;
                margin-left: 45px !important;
    }
}


.us-filter-reset
{
    background: transparent !important;
    color: black;
    border: none;
    float: right;
    border-color: white !important;
    box-shadow: none;
    font-size: 12px;
}

@media screen and (max-width: 768px) {
  .us_design
{
    height: auto !important;
    width: 100% !important;
    max-width: 500px !important ;    
}
  
}

@media screen and (max-width: 991px) {
  .us_filter_design
{
    box-shadow: none !important;
}



}

.us_filter_design
{
        background: white;
    box-shadow: 0px 0px 10px gray;
    padding: 1rem !important;
    border-radius: 10px;
    
}

</style>
@yield('style')

