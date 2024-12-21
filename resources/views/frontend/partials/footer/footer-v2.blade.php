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
  @if ($footerSectionStatus == 1)

    <footer class="footer-area bg-img" style="background-color:#001334">
      <div class="overlays opacity-70"></div>
      <div class="footer-top pt-70 pb-50">
        <div class="container-fluid">
          <div class="row justify-content-between m-4 footer-row">
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12">
              <div class="footer-widget" data-aos="">
                <div class="navbar-brand">
                  @if (!empty($basicInfo->footer_logo))
                    <a href="{{ route('index') }}">
                      <img src="{{ asset('assets/img/' . $basicInfo->footer_logo) }}" alt="Logo" style="width:150px;height:auto;">
                    </a>
                  @endif
                </div>
                <p class="p-2">{{ !empty($footerInfo) ? $footerInfo->about_company : '' }}</p>
                <div class="social-link">
                  <!-- @if (count($socialMediaInfos) > 0)
                    @foreach ($socialMediaInfos as $socialMediaInfo)
                      <a href="{{ $socialMediaInfo->url }}" target="_blank"><i
                          class="{{ $socialMediaInfo->icon }}"></i></a>
                    @endforeach
                  @endif -->
                  <a href="{{ $socialMediaInfo->url }}" target="_blank" class="social-icon-new"><i
                          class="{{ $socialMediaInfo->icon }}"></i>
                  </a>
                   <!-- LinkedIn -->
                  {{-- <a href="#" target="_blank" class="social-icon-new">
                    <i class="fab fa-linkedin"></i>
                  </a>

                  <!-- Twitter -->
                  <a href="#" target="_blank" class="social-icon-new">
                    <i class="fab fa-twitter"></i> --}}
                  </a>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-3 col-sm-5">
              <div class="footer-widget" data-aos="">
                <h4 style="font-size: 17px !important;font-weight:bold">{{ __('Explore') }}</h4>
                @if (count($quickLinkInfos) == 0)
                  <h6 class="text-light">{{ __('No Link Found') . '!' }}</h6>
                @else
                  <ul class="footer-links">
                    @foreach ($quickLinkInfos as $quickLinkInfo)
                      @if ($quickLinkInfo->section == 'explore')
                      <li>
                        <a href="{{ $quickLinkInfo->url }}">{{ $quickLinkInfo->title }}</a>
                      </li>
                      @endif
                    @endforeach
                  </ul>
                @endif
              </div>
            </div>
            <div class="col-xl-2 col-lg-4 col-md-3 col-sm-5">
              <div class="footer-widget" data-aos="">
                <h4 style="font-size: 17px !important;font-weight:bold">{{ __('Customer Satisfaction') }}</h4>
                @if (count($quickLinkInfos) == 0)
                  <h6 class="text-light">{{ __('No Link Found') . '!' }}</h6>
                @else
                  <ul class="footer-links">
                    @foreach ($quickLinkInfos as $quickLinkInfo)
                    @if ($quickLinkInfo->section == 'customer')
                      <li>
                        <a href="{{ $quickLinkInfo->url }}">{{ $quickLinkInfo->title }}</a>
                      </li>
                      @endif
                    @endforeach
                  </ul>
                @endif
              </div>
            </div>
             <div class="col-xl-2 col-lg-3 col-md-5 col-sm-5">
              <div class="footer-widget" data-aos="">
              <h4 style="font-size: 17px !important;font-weight:bold">{{ __('Contact Us') }}</h4>
                <ul class="info-list mb-4">
                    <li>
                      <i class="fal fa-map-marker-alt"></i>
                      @if (!empty($basicInfo->address))
                        <span>{{ $basicInfo->address }}</span>
                      @endif
                    </li>
                    @if (!empty($basicInfo->contact_number))
                      <li>
                        <i class="fal fa-phone-plus"></i>
                        <a href="tel:{{ $basicInfo->contact_number }}">{{ $basicInfo->contact_number }}</a>
                      </li>
                    @endif
                    @if (!empty($basicInfo->email_address))
                      <li>
                        <i class="fal fa-envelope"></i>
                        <a href="mailto:{{ $basicInfo->email_address }}">{{ $basicInfo->email_address }}</a>
                      </li>
                    @endif
                  </ul>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-7 col-sm-5">
              <div class="footer-widget" data-aos="">
              <h4 style="font-size: 17px !important;font-weight:bold" >{{ __('Subscribe') }}</h4>
                <p class="lh-1 mb-20">{{ __('Subscribe and stay up to date with our latest news and events') . '!' }}</p>
                <div class="newsletter-form">
                  <form id="newsletterForm" class="subscription-form" action="{{ route('store_subscriber') }}"
                    method="POST">
                    @csrf
                    <div class="form-group">
                      <input  class="form-control customFooteremail" placeholder="{{ __('Your  email') }}" type="text"
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
            <span>{!! @$footerInfo->copyright_text !!}</span>
          </div>
        </div>
      </div>
    </footer>
  @endif
  <!-- Footer-area end-->

  <!-- Go to Top -->
  <div class="go-top"><i class="fal fa-angle-up"></i></div>
  <!-- Go to Top -->
<div class="modal fade modal-lg" id="topSearch" tabindex="-1" role="dialog" aria-labelledby="topSearchLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('frontend.cars') }}" enctype="multipart/form-data" method="GET" id = "topSearchForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title w-100" id="topSearchLabel">
            <div class="form-group has-search">
              <span class="fa fa-search form-control-feedback" role="button" onclick="document.getElementById('topSearchForm').submit();"></span>
              <input type="text" name ="title" id="searchByTitleTop" class="form-control input-lg" placeholder="Search Listit" style="padding: 15px;">
            </div>
          </h5>

          @csrf
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
                        @php
                          $lSearch = array();
                          if (Auth::guard('vendor')->check()){
                              $lastSearch = App\Models\Car\CustomerSearch::where('customer_id', Auth::guard('vendor')->user()->id)->first();
                              if($lastSearch){
                              $lSearch = $lastSearch->customer_filters;
                              }
                          } elseif(session()->has('lastSearch')) {
                              $lSearch = Session::get('lastSearch');
                          }
                      @endphp
                      @if(!empty($lSearch))

                      <a style="font-size:11px;" href="ads?{{ http_build_query(json_decode($lSearch)) }}">
                                    @foreach (json_decode($lSearch) as $key=>$value)
                                    @if($key!='_token')
                                    @if(!is_array($value))
                                      {{ Str::slug($value, ' ') }} <small style="font-size:9px;">-></small>
                                      @endif
                                      @endif
                                    @endforeach
                                  </a>
                      @endif
                  </div>
                  <div class="autocomplete-suggestion pt-2 pb-2"> Suggested searches</div>
                  <div class="autocomplete-suggestion pt-2 pb-2"><a href="{{route('frontend.cars', ['category'=>'cars'])}}"><i class="fal fa-check"></i> &nbsp;Cars from Trusted Dealerships  <b>in Cars</b></a></div>
                  <div class="autocomplete-suggestion pt-2 pb-2"><a href="{{route('frontend.cars', ['category'=>'cars'])}}"><i class="fal fa-check"></i> &nbsp;Cars with a Warranty  <b>in Cars</b></a></div>
                  <div class="autocomplete-suggestion pt-2 pb-2"><a href="{{route('frontend.cars', ['category'=>'cars'])}}"><i class="fal fa-check"></i> &nbsp;Cars with Greenlight History Check  <b>in Cars</b></a></div>
                  <div class="autocomplete-suggestion pt-2 pb-2"> <a href="{{route('frontend.cars', ['category'=>'cars'])}}"><i class="fal fa-check"></i> &nbsp;Cars with Finance  <b>in Cars</b></a></div>
                  <div class="autocomplete-suggestion pt-2 pb-2"><a href="{{route('frontend.cars', ['category'=>'cars'])}}"><i class="fal fa-check"></i> &nbsp; New Cars  <b>in Cars</b></a></div>

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
    <form action="{{ route('vendor.verify_code') }}" method="POST" class = "verifyoptProfile-code">
            @csrf
      <div class="modal-content" style="width: 100% !important;">
        <div class="modal-header">
          <div class="row">
            <h4 class="modal-title w-100" id="topSearchLabel">
              <img src = "">
              <img src="{{ asset('assets/img/mobile-id-verification.png') }}" alt="verification" width= "60">
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
                    <button type="submit" class="btn btn-lg btn-primary radius-md w-100"> {{ __('Verify Phone') }} </button>
                  </div>

              </div>

            </div>
          </div>
        </div>

      </div>
    </form>
  </div>
</div>
