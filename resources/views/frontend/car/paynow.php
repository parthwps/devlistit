@extends("frontend.layouts.layout-v$settings->theme_version")
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
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => 123,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Signup'),
  ])
    <form id="payment-form"  method="POST" enctype="multipart/form-data" action ="https://listit.im/paypal/make-payment">
        @csrf
        <label for="card_type">Card Type:</label>
        <input type="text" id="card_type" name="card_type" required><br><br>
        <label for="card_number">Card Number:</label>
        <input type="text" id="card_number" name="card_number" required><br><br>
        <label for="card_expiry_month">Expiry Month:</label>
        <input type="text" id="card_expiry_month" name="card_expiry_month" required><br><br>
        <label for="card_expiry_year">Expiry Year:</label>
        <input type="text" id="card_expiry_year" name="card_expiry_year" required><br><br>
        <label for="card_cvv">CVV:</label>
        <input type="text" id="card_cvv" name="card_cvv" required><br><br>
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required><br><br>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br><br>
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" required><br><br>
        <button type="submit">Submit Payment</button>
    </form>

   
</body>
</html>