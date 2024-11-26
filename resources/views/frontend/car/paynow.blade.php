@php
  $version = $basicInfo->theme_version;
@endphp
@extends("frontend.layouts.layout-v$version")

@section('pageHeading')
  {{ !empty($pageHeading) ? $pageHeading->faq_page_title : __('FAQ') }}
@endsection

@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keyword_faq }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_faq }}
  @endif
@endsection

@section('content')
 
  <div class="faq-area pt-100 pb-75">
    <div class="container">
    <div class="row justify-content-center">
          <div class="col-lg-6" data-aos="fade-up">
          <div class="form-group ">
    <!-- <form id="payment-form"  method="POST" enctype="multipart/form-data" action ="https://listit.im/paypal/make-payment">
        @csrf
        <label for="card_type">Card Type:</label>
        <input type="text" id="card_type" name="card_type" class="form-control" required>
        <label for="card_number">Card Number:</label>
        <input type="text" id="card_number" name="card_number" class="form-control" required>
        <label for="card_expiry_month">Expiry Month:</label>
        <input type="text" id="card_expiry_month" name="card_expiry_month" class="form-control" required>>
        <label for="card_expiry_year">Expiry Year:</label>
        <input type="text" id="card_expiry_year" name="card_expiry_year" class="form-control" required>
        <label for="card_cvv">CVV:</label>
        <input type="text" id="card_cvv" name="card_cvv"  class="form-control" required>
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" class="form-control" required>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" class="form-control" required>
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount"  class="form-control" required></br>
        <button type="submit" class="btn btn-primary">Submit Payment</button>
    </form> -->
    <script src="https://www.paypal.com/sdk/js?client-id=ASel7yYXF6phidnkRpBayY3xfU_5vepQCEnxTa2CsTiQ0eedYJyq5leCWB6Y4YVcFhP184tpyxF54Raw"></script>

 <!--  <div class="panel">
    <div class="overlay hidden"><div class="overlay-content"><img src="css/loading.gif" alt="Processing..."/></div></div>

    <div class="panel-heading">
        <h3 class="panel-title">Charge 34 with PayPal</h3>
        
        
        <p><b>Item Name:</b> <?php echo "test product" ?></p>
        <p><b>Price:</b> <?php echo '$ 50 usd' ?></p>
    </div>
    <div class="panel-body">
       
        <div id="paymentResponse" class="hidden"></div>
        
      
        <div id="checkout-form">
            <div id="card-name-field-container"></div>
            <div id="card-number-field-container"></div>
            <div id="card-expiry-field-container"></div>
            <div id="card-cvv-field-container"></div>
            <button id="card-field-submit-button" type="button">
                Pay Now
            </button>
        </div>
    </div>
</div> -->
<div id="paypal-button-container"></div>

    <script>
        // Render PayPal button
        paypal.Buttons({
            createOrder: function(data, actions) {
                // Set up the transaction
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: <?php echo "25"; ?> // Change this to your amount
                        },
                       
                           
                        
                    }],
                    payment_source: {
                    "paypal": {
                    "experience_context": {
                        "payment_method_preference": "IMMEDIATE_PAYMENT_REQUIRED",
                        "brand_name": "EXAMPLE INC",
                        "locale": "en-US",
                        "shipping_preference": "NO_SHIPPING",
                        "landing_page": "NO_PREFERENCE",
                        "user_action": "PAY_NOW"
                    }
                    }
                },
                payer: {
                  
                  email_address: 'customer@domain.com',
                  phone: {
                    phone_number: {
                        national_number: '4543433243',
                    }
                  },
                  name: {
                    given_name: 'Ijaz',
                    surname: 'Ahmed',
                  },
                  
                },
                
                });
            },
            onApprove: function(data, actions) {
                // Capture the funds from the transaction
                return actions.order.capture().then(function(details) {
                    // Handle successful transaction
                    console.log(details);
                    alert('Transaction completed by ' + details.payer.name.given_name);
                });
            },
            onCancel: function(data) {
                    // Handle cancelation
                    alert('Transaction canceled');
                },
                onError: function(err) {
                    // Handle errors
                    console.error('Error:', err);
                    alert('Error occurred, please try again.');
                },
                style: {
                    layout: 'vertical',
                    color: 'gold',
                    shape: 'rect',
                    label: 'paypal',
                    height: 40,
                    disable: 'billing,shipping' // Disable billing and shipping addresses
                }
        }).render('#paypal-button-container');
    </script>
 
    </div>
    </div>
      </div>
    </div>
  </div>
  @endsection
  
  
    @section('script')
    <script>
// Create the Card Fields Component and define callbacks
const cardField = paypal.CardFields({
    createOrder: function (data) {
        setProcessing(true);
        
        var postData = {request_type: 'create_order', payment_source: data.paymentSource};
        return fetch("paypal_checkout_init.php", {
            method: "POST",
            headers: {'Accept': 'application/json'},
            body: encodeFormData(postData)
        })
        .then((res) => {
            return res.json();
        })
        .then((result) => {
            setProcessing(false);
            if(result.status == 1){
                return result.data.id;
            }else{
                resultMessage(result.msg);
                return false;
            }
        });
    },
    onApprove: function (data) {
        setProcessing(true);

        const { orderID } = data;
        var postData = {request_type: 'capture_order', order_id: orderID};
        return fetch('paypal_checkout_init.php', {
            method: "POST",
            headers: {'Accept': 'application/json'},
            body: encodeFormData(postData)
        })
        .then((res) => {
            return res.json();
        })
        .then((result) => {
            // Redirect to success page
            if(result.status == 1){
                window.location.href = "payment-status.php?checkout_ref_id="+result.ref_id;
            }else{
                resultMessage(result.msg);
            }
            setProcessing(false);
        });
    },
    onError: function (error) {
        // Do something with the error from the SDK
    },
});

// Render each field after checking for eligibility
if (cardField.isEligible()) {
    const nameField = cardField.NameField();
    nameField.render("#card-name-field-container");

    const numberField = cardField.NumberField();
    numberField.render("#card-number-field-container");

    const cvvField = cardField.CVVField();
    cvvField.render("#card-cvv-field-container");

    const expiryField = cardField.ExpiryField();
    expiryField.render("#card-expiry-field-container");

    // Add click listener to submit button and call the submit function on the CardField component
    document
    .getElementById("card-field-submit-button")
    .addEventListener("click", () => {
        cardField.submit().then(() => {
            // submit successful
        })
        .catch((error) => {
            resultMessage(`Sorry, your transaction could not be processed... >>> ${error}`);
        });
    });
} else {
    // Hides card fields if the merchant isn't eligible
    document.querySelector("#checkout-form").style = "display: none";
}

const encodeFormData = (data) => {
    var form_data = new FormData();

    for ( var key in data ) {
        form_data.append(key, data[key]);
    }
    return form_data;   
}

// Show a loader on payment form processing
const setProcessing = (isProcessing) => {
    if (isProcessing) {
        document.querySelector(".overlay").classList.remove("hidden");
    } else {
        document.querySelector(".overlay").classList.add("hidden");
    }
}

// Display status message
const resultMessage = (msg_txt) => {
    const messageContainer = document.querySelector("#paymentResponse");

    messageContainer.classList.remove("hidden");
    messageContainer.textContent = msg_txt;
    
    setTimeout(function () {
        messageContainer.classList.add("hidden");
        messageContainer.textContent = "";
    }, 5000);
}
</script>
    @endsection