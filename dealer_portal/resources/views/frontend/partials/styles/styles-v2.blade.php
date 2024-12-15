<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('assets/front/css/vendors/bootstrap.min.css') }}">
<!-- Data Tables CSS -->
<link rel="stylesheet" href="{{ asset('assets/front/css/vendors/datatables.min.css') }}">
<!--<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">-->
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
<link rel="stylesheet" href="{{ asset('assets/front/css/style.css?v=0.1') }}">
<!-- Responsive CSS -->
<link rel="stylesheet" href="{{ asset('assets/front/css/responsive.css') }}">

{{-- dropzone css --}}
<link rel="stylesheet" href="{{ asset('assets/css/dropzone.min.css') }}">

{{-- atlantis css --}}
<link rel="stylesheet" href="{{ asset('assets/css/atlantis_custom.css') }}?v=0.1">
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
{{-- rtl css are goes here --}}
@if ($currentLanguageInfo->direction == 1)
  <link rel="stylesheet" href="{{ asset('assets/front/css/rtl.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/front/css/rtl-responsive.css') }}">
@endif
<style type="text/css">
    
    #imagePreview img
    {
            object-fit: cover;
    }
    
    .dropdown-menu[data-bs-popper] {
        right:0px;
    }
    
    .blur-up.ls-is-cached.lazyloaded
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

    .form-group label, .form-check label 
    {
         font-size:13.3px !important;   
         font-weight: bold !important;
         color: gray;
    }
    
    #_hj_feedback_container 
    {
        display: none !important;
    }
    
    .btnCustom
    {
        border-radius: 3px;
        padding: 5px 15px;
    }
    
    @media only screen and (max-width: 575.98px) 
    {
        .btnCustom
        {
            font-size:10px !important;
        }
        
        #username-display
        {
            position:relative;
            top:10px;
        }
        
        .dropdown-toggle::after 
        {
            position: relative;
            top: 5px;
        }
        
         #username-display {
             width: 55px !important;
         }
    } 
    
    
    .hidden-option 
    {
        display: none;
    }
    
    .dz-error-mark, .dz-error-mark svg {
        pointer-events: auto;
    }
    
    .form-control 
    {
        line-height: 1.5 !important;
    }

.select2-selection__rendered 
{
    line-height: 42px !important;
}

.select2-container .select2-selection--single 
{
    height: 45px !important;
}

.select2-selection__arrow 
{
    height: 44px !important;
}

table.fixedHeader-floating
{
    margin: 0 !important;
}

.hero-banner.hero-banner-2 {
 
  background-image:url("/assets/img/63c8f9ac5c631.jpg");

}

.margin-top-us
{
        margin-top: 100px;
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
    
    .btn-primary:hover {
        color: white !important;
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

    .page-title-area.has_header_2 {
        padding-top: 150px !important;
    }

.fa-twitter:before {
    content: "𝕏";
    font-size: 1.2em;
}

.select2-container {
    width: 100% !important;
}

.main-navbar
{
    display:block !important;
}
.dz-details
{
    display:none;
}
@media screen and (max-width: 650px) 
{
    
    #username-display {
            display: inline-block;
            width: 90px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        
    #navbar_main
    {
        margin-right: -1.3rem;
        margin-left: -1rem;
    }
    
    #search_btn
    {
        margin-right: 5px;
    }
    
 .header-area .more-option {
     gap: 7px;
 }
 .us_place_ad_btn
 {
     font-size: 12px;
    padding: 5px;
 }
 
 .us_logo
 {
     width: 110px;
 }
 .us_drop_item
 {
         font-size: 12px;
 }
 
 .us_toggle_btn
 {
     padding: 5px;
    font-size: 12px;
 }
 .us_normal_drop
 {
     left:-40% !important;
 }
}
.us_toggle_btn
{
     border: none;
}

</style>
@yield('style')



