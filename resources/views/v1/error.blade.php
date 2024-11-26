@extends("frontend.layouts.layout-v2")
@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('Signup') }}
  @else
    {{ __('Signup') }}
  @endif
@endsection
@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keywords_vendor_signup }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_vendor_signup }}
  @endif
@endsection

@section('content')
  <style>
     .more-option.mobile-item
     {
          display:none !important;
     }
     
     .footer-area
     {
          display:none !important;
     }
 </style>
 
 
  <div class="user-dashboard pt-20 pb-60">
    <div class="container">
        
  <div class="row gx-xl-5">

      <div class="card" style="margin-top:50px;">
      
      <div class="card-body">
        <div class="row successimg">
            
        <div class="col-lg-12 col-xs-4">
            <div class=" p-4 text-center">
               <h1 style="color:red;font-size: 130px;"><i class="fa fa-times" aria-hidden="true"></i></h1> 
                <br>
                <h2>{{!empty($msg) ? $msg : 'Something went wrong'}}</h2>
                 <br>
                   <a href="{{$appUrl}}"  class="btn btn-md btn-primary w-100 showLoader mt-40">Back To Home </a>
            </div>
          </div>
        
        </div>
      </div>
        </div>
       
      </div>
    </div>
  </div>  

@endsection


