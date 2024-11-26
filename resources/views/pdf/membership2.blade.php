<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ __('Receipt') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/pdf.css') }}">
</head>

<body>
  <div class="main">
    <table class="heading">
      <tr>
        <td>
          @if (!empty($websiteInfo->logo))
            <img loading="lazy" src="{{ asset('assets/img/' . $websiteInfo->logo) }}" height="40"
              class="d-inline-block">
          @else
            <img loading="lazy" src="{{ asset('assets/admin/img/noimage.jpg') }}" height="40" class="d-inline-block">
          @endif
        </td>
        <td class="text-right strong invoice-heading">{{ __('Receipt') }}</td>
      </tr>
    </table>
    <div class="header">
      <div class="ml-20 ">
        <table class="text-left">
        <tr>
            <td class="strong">{{ __('Order Details') . ':' }}</td>
          </tr>
          <tr>
            <td class="gry-color small"><strong>{{ __('Order No') . ':' }}</strong>
              {{ $request['order_id'] }}</td>
          </tr>
          
          <tr>
            <td class="gry-color small"><strong>{{ __('Receipt number:') . ':' }}</strong> #{{ $request['order_id'].'-'.$transaction_id }}</td>
          </tr>
          <tr>
            <td class="gry-color small"><strong>{{ __('Receipt Date') . ':' }}</strong>
              {{ \Carbon\Carbon::now()->format('d/m/Y') }}</td>
          </tr>
          <tr>
            <td class="gry-color small"><strong>{{ __('Customer') . ':' }}</strong>
            {{ $member->vendor_info['name'] }}</td>
          </tr>
          <tr>
            <td class="gry-color small"><strong>Total:</strong>
            {{ $base_currency_symbol_position == 'left' ? $base_currency_symbol : '' }}
              {{ $amount == 0 ? 'Free' : $amount }}
              {{ $base_currency_symbol_position == 'right' ? $base_currency_symbol : '' }}</td>
          </tr>
          <tr>
            <td class="gry-color small"><strong>{{ __('Payment Method') . ':' }}</strong>
              {{ $request['payment_method'] }}</td>
          </tr>
          <tr>
            <td class="gry-color small"><strong>{{ __('Payment Status') . ':' }}</strong>{{ __('Completed') }}</td>
          </tr>
        </table>
      </div>
      <div class="order-details">
        <table class="text-right">
          <tr>
            <td class="strong small gry-color"><!-- {{ __('Bill to') . ':' }} --></td>
          </tr>
          <tr>
            <td class="strong"><!-- {{ ucfirst($member['first_name']) . ' ' . ucfirst($member['last_name']) }} --></td>
          </tr>
          <tr>
            <td class="gry-color small"><strong><!-- {{ __('Username') . ':' }} </strong>{{ $member['username'] }} --></td>
          </tr>
          <tr>
            <td class="gry-color small"><!-- <strong>{{ __('Email') . ':' }} </strong> {{ $member['email'] }} --></td>
          </tr>
          <tr>
            <td class="gry-color small"><!-- <strong>{{ __('Phone') . ':' }} </strong> {{ $phone }} --></td>
          </tr>
          
        </table>
      </div>
    </div>

    <div class="package-info mt-80">
      <table class="padding text-left small border-bottom">
        <thead>
          <tr class="gry-color info-titles">
            <th width="60%" class="text-left">{{ __('Description') }}</th>
           
            <th width="40%" class="text-right">{{ __('Price') }}</th>
          </tr>
        </thead>
        <tbody class="strong">

          <tr >
            <td width="60%" class="text-left">{{ $package_title }}</td>
            
            <td width="40%" class="text-right">
              {{ $base_currency_symbol_position == 'left' ? $base_currency_symbol : '' }}
              {{ $amount == 0 ? 'Free' : number_format($amount, 2, '.', ',')  }}
              {{ $base_currency_symbol_position == 'right' ? $base_currency_symbol : '' }}
            </td>
          </tr>
          @if($vat_amount != 0)
          <tr class="text-right">
            <td width="60%">Ex VAT</td>
            
            <td width="40%" class="text-right">
            {{ $base_currency_symbol_position == 'left' ? $base_currency_symbol : '' }}
              {{ number_format(($amount - $vat_amount), 2, '.', ',')}}
              {{ $base_currency_symbol_position == 'right' ? $base_currency_symbol : '' }}
            </td>
          </tr>
          <tr class="text-right">
            <td width="60%">VAT 20%</td>
            
            <td width="40%" class="text-right">
            {{ $base_currency_symbol_position == 'left' ? $base_currency_symbol : '' }}
              {{ number_format($vat_amount, 2, '.', ',') }}
              {{ $base_currency_symbol_position == 'right' ? $base_currency_symbol : '' }}
            </td>
          </tr>
          
          <tr >
            <td width="100%" class="text-left"><b> VAT No. GB005495779</b> </td>
            
          
          </tr>
          
          @endif
        </tbody>
      </table>
    </div>
    <table class="mt-80 text-center" width="80%">
      <tr>
        <td class="text-center regards">  </td>
      </tr>
      <tr>
        <td class="text-center strong regards"><!-- {{ $websiteInfo->website_title }} --></td>
      </tr>
    </table>
  </div>


</body>

</html>
