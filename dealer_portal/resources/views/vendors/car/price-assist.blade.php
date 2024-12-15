@extends("frontend.layouts.layout-v$settings->theme_version")
@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('Ads') }}
  @else
    {{ __('Ads') }}
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

<div class="user-dashboard pt-20 pb-60">
    <div class="container margin-top-us" >
      
      
  <div class="row gx-xl-5">
  
       @includeIf('vendors.partials.side-custom')
  <div class="col-md-9">      
  


  <div class="row">
    <div class="col-md-12">
    
        <div class="card">

        <div class="card-body">
        <div class="row">


              

                <div class="col-md-12">
                <strong>
                Price Assist <small class="beta-tags">Beta</small>
                <div style="font-size: 13px;font-weight: 300;margin-bottom: 0px;">
                Enter a car registration and get possible Valuations detail
                    </div>
                </strong>
                    <br>
                </div>


                <div class="col-lg-12">
                    <div class="form-group">
                      <label>Enter vehicle registration *</label>
                      <div style="display:flex;">
                      <input type="text" class="form-control validateTextBoxs"  style="border-top-right-radius:0px;border-bottom-right-radius:0px;" placeholder="Enter vehicle registration" id="vehicle_Valuationreg" >
                      <button class="btn btn-sm btn-success" type="button" onclick="getVehicleValuationData(this)" style="border-top-left-radius:0px;border-bottom-left-radius:0px;"><i class="fa fa-search" aria-hidden="true"></i></button>
                      </div>

                      <div id="result_status"></div>
                    </div>

                    <hr>
                  </div>

                    <div class="col-lg-12 ">
                    <label style="font-size: 16px !important;margin-bottom: 1.5rem;font-weight: 900;">Details </label>
                    </div>


                  <div class="col-lg-4 col-sm-6 col-6 mob_mt_1rem">
                    <label style="font-weight: 700;"> Vehicle Description</label>
                    <div id="VehicleDescription" style="        margin-bottom: 2rem;font-size: 12px;margin-top: 10px;"></div>
                </div>


                <div class="col-lg-4 col-sm-6 col-6 mob_mt_1rem">
                    <label style="font-weight: 700;"> Mileage</label>
                    <div id="Mileage" style="        margin-bottom: 2rem;font-size: 12px;margin-top: 10px;"></div>
                </div>


                <div class="col-lg-4 col-sm-6 col-6 mob_mt_1rem">
                    <label style="font-weight: 700;"> PlateYear</label>
                    <div id="PlateYear" style="        margin-bottom: 2rem;font-size: 12px;margin-top: 10px;"></div>
                </div>


                <div class="col-lg-4 col-sm-6 col-6 mob_mt_1rem">
                    <label style="font-weight: 700;"> OTR</label>
                    <div id="OTR" style="        margin-bottom: 2rem;font-size: 12px;margin-top: 10px;"></div>
                </div>


                <div class="col-lg-4 col-sm-6 col-6 mob_mt_1rem">
                    <label style="font-weight: 700;"> Dealer Fore court</label>
                    <div id="DealerForecourt" style="        margin-bottom: 2rem;font-size: 12px;margin-top: 10px;"></div>
                </div>


                <div class="col-lg-4 col-sm-6 col-6 mob_mt_1rem">
                    <label style="font-weight: 700;"> Trade Retail</label>
                    <div id="TradeRetail" style="        margin-bottom: 2rem;font-size: 12px;margin-top: 10px;"></div>
                </div>


                <div class="col-lg-4 col-sm-6 col-6 mob_mt_1rem">
                    <label style="font-weight: 700;"> Private Clean</label>
                    <div id="PrivateClean" style="        margin-bottom: 2rem;font-size: 12px;margin-top: 10px;"></div>
                </div>


                <div class="col-lg-4 col-sm-6 col-6 mob_mt_1rem">
                    <label style="font-weight: 700;">Private Average</label>
                    <div id="PrivateAverage" style="        margin-bottom: 2rem;font-size: 12px;margin-top: 10px;"></div>
                </div>


                <div class="col-lg-4 col-sm-6 col-6 mob_mt_1rem">
                    <label style="font-weight: 700;"> Part Exchange</label>
                    <div id="PartExchange" style="        margin-bottom: 2rem;font-size: 12px;margin-top: 10px;"></div>
                </div>


                <div class="col-lg-4 col-sm-6 col-6 mob_mt_1rem">
                    <label style="font-weight: 700;"> Auction</label>
                    <div id="Auction" style="        margin-bottom: 2rem;font-size: 12px;margin-top: 10px;"></div>
                </div>


                <div class="col-lg-4 col-sm-6 col-6 mob_mt_1rem">
                    <label style="font-weight: 700;">Trade Average</label>
                    <div id="TradeAverage" style="        margin-bottom: 2rem;font-size: 12px;margin-top: 10px;"></div>
                </div>


                <div class="col-lg-4 col-sm-6 col-6 mob_mt_1rem">
                    <label style="font-weight: 700;"> Trade Poor</label>
                    <div id="TradePoor" style="        margin-bottom: 2rem;font-size: 12px;margin-top: 10px;"></div>
                </div>


                </div>
              
        </div>
        </div>



      </div>







    </div>
  </div>
  
  </div>
  </div>
  </div>
  </div>
@endsection


@section('script')
{{-- dropzone css --}}
<link rel="stylesheet" href="{{ asset('assets/css/dropzone.min.css') }}">

{{-- atlantis css --}}
<link rel="stylesheet" href="{{ asset('assets/css/atlantis_user.css') }}">
{{-- select2 css --}}
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/front/css/pages/inner-pages.css') }}">
{{-- admin-main css --}}
<link rel="stylesheet" href="{{ asset('assets/css/admin-main.css') }}">
<style type="">
    .chekbox
    {
        zoom:2;
    }
    
    .beta-tags
    {
        background: #b7b7b7;
    font-size: 12px;
    margin-left: 0.3rem;
    padding: 0.2rem;
    border-radius: 5px;
    color: white;
    font-weight: 500;
    }

  #carForm .form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 14px !important;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out
}
 #carForm .btn-secondary{
  line-height: 13px !important;
 }
 #result_status
 {
    margin-top:1rem;
 }
 .customRadio{
  width: 1.2em !important;
    height: 1.2em !important;
    border-color:#b1b1b1 !important;
    margin-right:4px !important;
 }
 .customRadiolabel{
  margin-top:3px !important;
  font-size: 14px;
  font-weight: 600;
 }
</style>
<script>




  'use strict';

  const baseUrl = "{{ url('/') }}";
</script>

{{-- core js files --}}



{{-- jQuery ui --}}
<script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.ui.touch-punch.min.js') }}"></script>

{{-- jQuery time-picker --}}
<script type="text/javascript" src="{{ asset('assets/js/jquery.timepicker.min.js') }}"></script>

{{-- jQuery scrollbar --}}
<script type="text/javascript" src="{{ asset('assets/js/jquery.scrollbar.min.js') }}"></script>

{{-- bootstrap notify --}}
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-notify.min.js') }}"></script>

{{-- sweet alert --}}
<script type="text/javascript" src="{{ asset('assets/js/sweet-alert.min.js') }}"></script>

{{-- bootstrap tags input --}}
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-tagsinput.min.js') }}"></script>

{{-- bootstrap date-picker --}}
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
{{-- js color --}}
<script type="text/javascript" src="{{ asset('assets/js/jscolor.min.js') }}"></script>

{{-- fontawesome icon picker js --}}
<script type="text/javascript" src="{{ asset('assets/js/fontawesome-iconpicker.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/js/tinymce/js/tinymce/tinymce.min.js') }}"></script>

{{-- datatables js --}}
<script type="text/javascript" src="{{ asset('assets/js/datatables-1.10.23.min.js') }}"></script>

{{-- datatables bootstrap js --}}
<script type="text/javascript" src="{{ asset('assets/js/datatables.bootstrap4.min.js') }}"></script>


{{-- dropzone js --}}
<script type="text/javascript" src="{{ asset('assets/js/dropzone.min.js') }}"></script>

{{-- atlantis js --}}
<script type="text/javascript" src="{{ asset('assets/js/atlantis.js') }}"></script>

{{-- fonts and icons script --}}
<script type="text/javascript" src="{{ asset('assets/js/webfont.min.js') }}"></script>

<!-- @if (session()->has('success'))
  <script>
    'use strict';
    var content = {};

    content.message = '{{ session('success') }}';
    content.title = 'Success';
    content.icon = 'fa fa-bell';

    $.notify(content, {
      type: 'success',
      placement: {
        from: 'top',
        align: 'right'
      },
      showProgressbar: true,
      time: 1000,
      delay: 4000
    });
  </script>
@endif -->

@if (session()->has('warning'))
  <script>
    'use strict';
    var content = {};

    content.message = '{{ session('warning') }}';
    content.title = 'Warning!';
    content.icon = 'fa fa-bell';

    $.notify(content, {
      type: 'warning',
      placement: {
        from: 'top',
        align: 'right'
      },
      showProgressbar: true,
      time: 1000,
      delay: 4000
    });
  </script>
@endif



{{-- select2 js --}}
<script type="text/javascript" src="{{ asset('assets/js/select2.min.js') }}"></script>

{{-- admin-main js --}}
<script type="text/javascript" src="{{ asset('assets/js/admin-main.js') }}"></script>

  <script>
    'use strict';
    var storeUrl = "{{ route('car.imagesstore') }}";
    var removeUrl = "{{ route('user.car.imagermv') }}";
    var getBrandUrl = "{{ route('user.get-car.brand.model') }}";
    const account_status = "{{ Auth::guard('vendor')->user()->status }}";
    const secret_login = "{{ Session::get('secret_login') }}";
  </script>

  <script src="{{ asset('assets/js/car.js') }}"></script>

  <script type="text/javascript" src="{{ asset('assets/js/admin-partial.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/admin-dropzone.js') }}"></script>
@endsection
