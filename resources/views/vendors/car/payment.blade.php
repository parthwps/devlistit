@extends("frontend.layouts.layout-v$settings->theme_version")
@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('Order Summary') }}
  @else
    {{ __('Order Summary') }}
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
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => 123,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Order Summary'),
  ])
@php

if(Session::get('promo_status')==1){
  $totalPrice = $data->promo_price+$data->price;
}
else{
  $totalPrice = $data->price;
 }

@endphp
  <div class="user-dashboard pt-20 pb-60">
    <div class="container">
        
  <div class="row gx-xl-5">
  
       @includeIf('vendors.partials.side-custom')
   <div class="col-md-9">
    <div class="row">
    <div class="col-md-12">
    @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ $message }}</strong>
    </div>
  @endif
  @if (!empty($membership) && ($membership->package->term == 'lifetime' || $membership->is_trial == 1))
    <div class="alert bg-warning alert-warning text-white text-center">
      <h3>{{ __('If you purchase this package') }} <strong class="text-dark">({{ $package->title }})</strong>,
        {{ __('then your current package') }} <strong class="text-dark">({{ $membership->package->title }}@if ($membership->is_trial == 1)
            <span class="badge badge-secondary">{{ __('Trial') }}</span>
          @endif)</strong>
        {{ __('will be replaced immediately') }}
      </h3>
    </div>
  @endif
    <form id="my-checkout-form" action="{{ route('vendor.plan.checkoutsuccess') }}" method="post"
          enctype="multipart/form-data">
          @csrf
          
          <!--<input type="submit" value="test btn" name="testBTN" />-->
          
          <input type="hidden" name="title" value="{{$data->title}} Ad Listed for  {{$data->days_listing}} days">
          <input type="hidden" name="price" value="{{ $totalPrice }}">
          <input type="hidden" name="payment_method" value="PayPal">
          <input type="hidden" name="order_status" id ="order_status" value="">
          <input type="hidden" name="order_id" value="{{$ad_id->order_id}}">
          <input type="hidden" name="package_id" value="{{ $data->id }}">
          <input type="hidden" name="vendor_id" value="{{ auth()->id() }}">
          <input type="hidden" name="request_mode" value="web">
         
      <div class="card">
      <div class="overlay hidden"><div class="overlay-content">
        <img src="https://listit.im/assets/img/please_wait.gif" alt="logo"></div>
        </div>
        <div class="card-body">
         
        <div class="col-md-8 pr-md-0 mb-1">
              <div class="card">
              <div class="m-3 d-flex justify-content-between">
                  <h4 class="card-text">Summary </h4>
                  <input id ="packageId" type="hidden" name="id" value="">
                </div>
                   @if(Session::get('package_id')==1)
                    <div class="m-3 d-flex justify-content-between"  >
                   @else
                   <div class="m-3 d-flex justify-content-between"  style="border-bottom:2px solid #F1F1F1">
                   @endif
                    <div class=""><strong>{{$data->title}} Ad </strong>Listed for  {{$data->days_listing}} days</div>
                        <div ><strong>{{ symbolPrice($data->price) }}</strong> </div>
                    </div>
                    @if(Session::get('promo_status')==1)
                    <div class="m-4 d-flex justify-content-between"  style="border-bottom:2px solid #F1F1F1">
                        <div class=""></div>
                        <div ><strong> {{ symbolPrice($data->promo_price) }} </strong></div>
                    </div>
                    @endif

                <div class="m-3 d-flex justify-content-between" >
                  <div class=""><strong >Total</strong></div>
                        <div id="totalPrice"><strong> 
                           @if(Session::get('promo_status')==1)
                                
                                {{symbolPrice($data->promo_price+$data->price)}} 
                                @else 
                                {{symbolPrice($data->price)}}  
                            @endif </strong> </div>
                  </div>
                
               
              <div class="m-4 d-flex justify-content-between">
                  <h4 class="card-text">Pay By </h4>
                 
                </div>
                <div class="m-3 d-flex justify-content-between">
                <script src="{{env('PAYPAL_URL')}}/sdk/js?client-id={{env('CLIENT_ID')}}&currency={{env('CURRENCY')}}"></script>
                <div style="width:100%" id="paypal-button-container"></div>

    <script>
        // Render PayPal button
        // Sandbox  ASel7yYXF6phidnkRpBayY3xfU_5vepQCEnxTa2CsTiQ0eedYJyq5leCWB6Y4YVcFhP184tpyxF54Raw
        // liv  AUwaSwtha_TvttH-ILmATyDiykI-YfW8uJhcZM_cUAnOCyGI0EJdd1mjKF3GSjTnOTtZNYPakq8R6ZH5
        //
        paypal.Buttons({
          style: {
                    layout: 'vertical',
                    color: 'gold',
                    shape: 'rect',
                    label: 'pay',
                    height: 40,
                    
                },
            createOrder: function(data, actions) {
                // Set up the transaction
                return actions.order.create({
                    purchase_units: [{
                      description:"Listit ads",
                        amount: {
                          currency_code: 'GBP',
                            value: <?php echo $totalPrice; ?> // Change this to your amount
                        },
                       
                           
                        
                    }],
                    payment_source: {
                    "paypal": {
                    "experience_context": {
                        "payment_method_preference": "IMMEDIATE_PAYMENT_REQUIRED",
                        "brand_name": "EXAMPLE INC",
                        "locale": "en-GB",
                        "shipping_preference": "NO_SHIPPING",
                        "landing_page": "NO_PREFERENCE",
                        "user_action": "PAY_NOW"
                    }
                    }
                },
                payer: {
                  
                  email_address: '<?php echo $ad_id->vendor->email; ?>',
                  phone: {
                    phone_number: {
                        national_number: '<?= (!empty($ad_id->vendor->phone)) ? $ad_id->vendor->phone : '0393949499595'; ?>',
                    }
                  },
                  name: {
                    given_name: '<?php echo $ad_id->vendor->vendor_info->name; ?>',
                    
                  },
                  
                },
                
                });
            },
            onApprove: function(data, actions) 
            {
                // Capture the funds from the transaction
                return actions.order.capture().then(function(details) {
                    // Handle successful transaction
                    document.getElementById('order_status').value = details.status;
                    //document.getElementsByClassName(".overlay").remove("hidden");
                   // document.getElementsByClassName('card-body')[0].style.visibility = 'none';
                    //document.getElementById('cardgif').style.visibility = 'visible';
                    
                    document.getElementById("my-checkout-form").submit();
                    //console.log(details);
                    //alert('Transaction completed by ' + details.payer.name.given_name+details.status);
                });
            },
             onCancel: function(data) 
            {
                var ad_id = "{{$ad_id->id}}"
                // window.location.href="/paypal-response/error/"+ad_id+'?msg=Transaction canceled';
                    // Handle cancelation
                    alert('Transaction canceled');
                },
                onError: function(err) {
                    var ad_id = "{{$ad_id->id}}"
                    // window.location.href="/paypal-response/error/"+ad_id+'?msg=Error occurred, please try again.';
                    alert('Error occurred, please try again.');
                }
        }).render('#paypal-button-container');
    </script>
                  <!-- <div class=""> <img class="lazyload" src="{{ asset('assets/img/paypal.png') }}"  alt="Pay by PayPal"></div>
                  <div class=""><input checked value="1" style="top: .8rem; width: 1.55rem; height: 1.55rem;" type="radio" name="promoPrice"></div>
                --> 

              </div> 
                <!--  <button class="btn btn-primary btn-block m-3" type="submit"><b>Proceed to Payment</b></button> -->
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
