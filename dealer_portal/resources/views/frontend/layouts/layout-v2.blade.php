<!DOCTYPE html>
<html lang="xxx" dir="{{ $currentLanguageInfo->direction == 1 ? 'rtl' : '' }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="KreativDev">

  <meta name="keywords" content="@yield('metaKeywords')">
  <meta name="description" content="@yield('metaDescription')">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="manifest" crossorigin="use-credentials" href="{{ asset('manifest.json') }}">

  {{-- title --}}
  <title>@yield('pageHeading') {{ '| ' . $websiteInfo->website_title }}</title>
  {{-- fav icon --}}
  <link rel="shortcut icon" type="image/png" href="{{ env('HOME_URL').'assets/img/' . getSetVal('favicon') }}">
  <link rel="apple-touch-icon" href="{{ env('HOME_URL').'assets/img/' . getSetVal('favicon') }}">

  @php
    $primaryColor = $basicInfo->primary_color;
    // check, whether color has '#' or not, will return 0 or 1
    
    if (!function_exists('checkColorCode')) {
    
    function checkColorCode($color)
    {
        return preg_match('/^#[a-f0-9]{6}/i', $color);
    }
    }
    
    // if, primary color value does not contain '#', then add '#' before color value
    if (isset($primaryColor) && checkColorCode($primaryColor) == 0) {
        $primaryColor = '#' . $primaryColor;
    }
    
    // change decimal point into hex value for opacity
     if (!function_exists('rgb')) {
    function rgb($color = null)
    {
        if (!$color) {
            echo '';
        }
        $hex = htmlspecialchars($color);
        [$r, $g, $b] = sscanf($hex, '#%02x%02x%02x');
        echo "$r, $g, $b";
    }
    }
  @endphp
  @includeIf('frontend.partials.styles.styles-v2')
  <style>
      
.footer-area .newsletter-form input {
   
    height: 43px !important;
}

.footer-area .newsletter-form .btn {
    top: 10px !important;
    height: auto !important;
}

/* Add this CSS to your stylesheet */
.sold-badge {
   
    justify-content: center;
      position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    align-items: center;
    z-index:999;
    background-color:rgb(182 124 124 / 70%); /* Faded red background */
    padding: 5px;
    border-radius: 5px;
    
    
}

.sold-text {
    font-size:100px;
    color: white; /* White text color */
    font-weight: normal;
    margin: 20px; /* Optional: Adjust margin as needed */
}


  .star {
    font-size: x-large;
    width: 20px;
    display: inline-block;
    color: gray;
}
.star:last-child {
    margin-right: 0;
}
.star:before {
    content:'\2605';
}
.star.on {
    color: gold;
}
.star.half:after {
    content:'\2605';
    color: gold;
    position: absolute;
    margin-left: -20px;
    width: 10px;
    overflow: hidden;
}
    :root {
      --color-primary: {{ $primaryColor }};
      --color-primary-rgb: {{ rgb(htmlspecialchars($primaryColor)) }};
    }

    .sale-tag
    {
        z-index: 9999;
        position: absolute;
        background: #ee2c7b;
        color: white;
        padding: 0.2rem;
        border-bottom-right-radius: 10px;
    }
/* Add the styles for the new tag */
.reduce-tag {
  background: #ee2c7b;
    color: white;
    padding: 0px 5px;
}

.red-tag2
{
  margin-left:189px;
  z-index: 9999;
        position: absolute;
        background: red;
        color: white;
        padding: 0.2rem;
        border-bottom-left-radius: 10px;
}
.red-tag2.red-tag-right{
	margin-left:0;
	right: 0;
}

.red-tag
{
  margin-left:225px;
  z-index: 9999;
        position: absolute;
        background: red;
        color: white;
        padding: 0.2rem;
        border-bottom-left-radius: 10px;
}
    .price-tag{
      font-size: 12px;
    background: #ee2c7b;
    padding: 0px 5px 0px 5px;
    color: white;
    border-radius: 20px;
    }

    .product-price {
  display: flex;
  justify-content: space-between;
}

.left-side {
  flex-grow: 1; /* Takes up remaining space */
}

.right-side {
  margin-left: 10px; /* Adjust the margin as needed */
}

@media screen and (max-width: 580px) {
  .mob_mt_1rem
  {
      margin-top:1rem;
  }
  
  .mob_mr_display
  {
      display:flex;
  }
  .mob_mr_left
  {
      margin-left:5rem;
  }
}
  </style>

<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:3795072,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>


</head>

<body dir="{{ $currentLanguageInfo->direction == 1 ? 'rtl' : '' }}">

  @includeIf('frontend.partials.header.header-v2')

  @yield('content')

  @includeIf('frontend.partials.popups')

  {{-- cookie alert --}}
  @if (!is_null($cookieAlertInfo) && $cookieAlertInfo->cookie_alert_status == 1)
    @include('cookie-consent::index')
  @endif
  {{-- WhatsApp Chat Button --}}
  <div id="WAButton"></div>

  @if ($basicInfo->shop_status == 1)
    <!-- Floating Cart Button -->
    <div id="cartIconWrapper" class="cartIconWrapper">
      @php
        $position = $basicInfo->base_currency_symbol_position;
        $symbol = $basicInfo->base_currency_symbol;
        $totalPrice = 0;
        if (session()->has('productCart')) {
            $productCarts = session()->get('productCart');
            foreach ($productCarts as $key => $product) {
                $totalPrice += $product['price'];
            }
        }
        $totalPrice = number_format($totalPrice);
        $productCartQuantity = 0;
        if (session()->has('productCart')) {
            foreach (session()->get('productCart') as $value) {
                $productCartQuantity = $productCartQuantity + $value['quantity'];
            }
        }
      @endphp
      <a href="{{ route('shop.cart') }} " class="d-block" id="cartIcon">
        <div class="cart-length">
          <i class="fal fa-shopping-bag"></i>
          <span class="length totalItems">
            {{ $productCartQuantity }} {{ __('Items') }}
          </span>
        </div>
        <div class="cart-total">
          {{ $position == 'left' ? $symbol : '' }}<span
            class="totalPrice">{{ $totalPrice }}</span>{{ $position == 'right' ? $symbol : '' }}
        </div>
      </a>
    </div>
    <!-- Floating Cart Button End-->
  @endif


  @includeIf('frontend.partials.scripts.scripts-v2')
  @includeIf('frontend.partials.toastr')
</body>

</html>
