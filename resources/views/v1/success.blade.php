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

  
    <form id="my-checkout-form" action="{{ route('vendor.plan.checkout') }}" method="post"
          enctype="multipart/form-data">
          @csrf
          
      <div class="card" style="margin-top:50px;">
      
      <div class="card-body">
        <div class="row successimg">
        <div class="col-lg-12 col-xs-4">
            <div class=" p-4 text-center">
            <img  class="lazyload text-center"
                        data-src="{{ asset('assets/img/ad-success.png') }}"
                        alt="">
            </div>
          </div>
          <div class="col-lg-12 mx-auto">
            <div class=" p-4 text-center">
              <div class="mb-3">
              @php
                $title = "";
              
                $title = route('frontend.car.details', ['cattitle' => catslug($ad_id->car_content->category_id),'slug' => $ad_id->car_content->slug, 'id' => $ad_id->id]) ;
                
                if(!$appUrl)
              {
                $appUrl = $title;
              }
              
              @endphp
              </div>
              <h4>{{ __('Success, your ad is listed') }}</h4>
              <label>{{ __('It may take a few minutes for your ad to appear on Listit.') }}</label>
              <div class="social-link style-2 mt-50">
                    <a data-tooltip="tooltip" data-bs-placement="top"
                        title="facebook" href="https://www.facebook.com/sharer/sharer.php?quote=Check Out this ad on List It&utm_source=facebook&utm_medium=social&u={{ urlencode($title) }}"
                      target="_blank"><i class="fab fa-facebook-f"></i></a>

                    <a data-tooltip="tooltip" data-bs-placement="top"
                        title="Twitter" href="//twitter.com/intent/tweet?text=Check Out this ad on List It&amp;url={{ urlencode($title) }}"
                      target="_blank"><i class="fab fa-twitter"></i></a>

                    <a data-tooltip="tooltip" data-bs-placement="top"
                        title="Whatsapp" href="//wa.me/?text=Check Out this ad on List it {{ urlencode($title) }}&amp;title= "
                      target="_blank"><i class="fab fa-whatsapp"></i></a>
                      <a data-tooltip="tooltip" data-bs-placement="top"
                        title="Linkedin" href="//www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode($title) }}&amp;title=Check Out this ad on List it"
                      target="_blank"><i class="fab fa-linkedin-in"></i></a>
                      <a data-tooltip="tooltip" data-bs-placement="top"
                        title="Email" href="mailto:?subject=Check Out this ad on List it&amp;body=Check Out this ad on List it {{ urlencode($title) }}&amp;title="
                      target="_blank"><i class="fas fa-envelope"></i></a>
                      <a data-tooltip="tooltip" data-bs-placement="top"
                        title="Copy Link" id = "copy_url" onclick="copy('{{ ($title) }}','#copy_url')" id="copy_button_1" href="javascript:void(0)"
                      ><i class="fas fa-link"></i></a>
                  </div>
                  <a href="{{$appUrl}}" class="btn btn-md btn-primary w-100 showLoader mt-40">Back To Home </a>
            </div>
            
          </div>
        </div>
      </div>
        </div>
       
      </form>
        <div class="card-footer">
          
        </div>
      </div>
    </div>
  </div>  </div>
  </div>
</div>
@endsection
@section('script')

  <script>
   
    function copy(text, target) {
      setTimeout(function() {
      //$('#copied_tip').remove();
      }, 800);
      
      var input = document.createElement('input');
input.setAttribute('value', text);
document.body.appendChild(input);
input.select();
var result = document.execCommand('copy');
document.body.removeChild(input)

      toastr["success"]("Ad Url copied successfully.")
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut ": 10000,
                "extendedTimeOut": 10000,
                "positionClass": "toast-top-right",
            }
            return result;
     
    }
  </script>
  <script src="{{ asset('assets/js/store-visitor.js') }}"></script>

@endsection

