  <!-- Footer-area start -->
  @if ($footerSectionStatus == 1)

    <footer class="footer-area bg-img" style="background-color:rgb(51, 51, 51)">
      <div class="overlay opacity-70"></div>
      <div class="footer-top pt-70 pb-50">
        <div class="container">
          <div class="row justify-content-between">
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
              <div class="footer-widget" data-aos="fade-up">
                <div class="navbar-brand">
                  @if (!empty($basicInfo->footer_logo))
                    <a href="{{ route('index') }}">
                      <img src="{{ asset('assets/img/' . $basicInfo->footer_logo) }}" alt="Logo">
                    </a>
                  @endif
                </div>
                <p>{{ !empty($footerInfo) ? $footerInfo->about_company : '' }}</p>
                <div class="social-link">
                  @if (count($socialMediaInfos) > 0)
                    @foreach ($socialMediaInfos as $socialMediaInfo)
                      <a href="{{ $socialMediaInfo->url }}" target="_blank"><i
                          class="{{ $socialMediaInfo->icon }}"></i></a>
                    @endforeach
                  @endif
                </div>
              </div>
            </div> 
            <div class="col-xl-2 col-lg-3 col-md-3 col-sm-5">
              <div class="footer-widget" data-aos="fade-up">
                <h4 style="    font-size: 16px !important;">{{ __('Explore') }}</h4>
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
            <div class="col-xl-2 col-lg-3 col-md-3 col-sm-5">
              <div class="footer-widget" data-aos="fade-up">
                <h4 style="    font-size: 16px !important;">{{ __('Customer Satisfaction') }}</h4>
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
             <div class="col-xl-2 col-lg-4 col-md-5 col-sm-7">
              <div class="footer-widget" data-aos="fade-up">
              <h4 style="    font-size: 16px !important;">{{ __('About Us') }}</h4>
              @if (count($quickLinkInfos) == 0)
                  <h6 class="text-light">{{ __('No Link Found') . '!' }}</h6>
                @else
                  <ul class="footer-links">
                    @foreach ($quickLinkInfos as $quickLinkInfo)
                    @if ($quickLinkInfo->section == 'about-us')
                      <li>
                        <a href="{{ $quickLinkInfo->url }}">{{ $quickLinkInfo->title }}</a>
                      </li>
                      @endif
                    @endforeach
                  </ul>
                @endif
              </div>
            </div> 
            <div class="col-xl-3 col-lg-6 col-md-7 col-sm-12">
              <div class="footer-widget" data-aos="fade-up">
              <h4 style="    font-size: 16px !important;" >{{ __('Contact Us') }}</h4>
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
                <h4>{{ __('Subscribe') }}</h4>
                <p class="lh-1 mb-20">{{ __('Subscribe and stay up to date with our latest news and events') . '!' }}</p>
                <div class="newsletter-form">
                  <form id="newsletterForm" class="subscription-form" action="{{ route('store_subscriber') }}"
                    method="POST">
                    @csrf
                    <div class="form-group">
                      <input class="form-control radius-0" placeholder="{{ __('Enter email') }}" type="text"
                        name="email_id" required="" autocomplete="off">
                      <button class="btn btn-md btn-primary" type="submit">{{ __('Subscribe') }}</button>
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
          </div> </div> 
      </div>
      
    </div>
  </form>
  </div>
</div>


