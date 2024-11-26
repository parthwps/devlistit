<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo e(__('Receipt')); ?></title>
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/pdf.css')); ?>">
</head>

<body>
  <div class="main">
    <table class="heading">
      <tr>
        <td>
          <?php if(!empty($websiteInfo->logo)): ?>
            <img loading="lazy" src="<?php echo e(asset('assets/img/' . $websiteInfo->logo)); ?>" height="40"
              class="d-inline-block">
          <?php else: ?>
            <img loading="lazy" src="<?php echo e(asset('assets/admin/img/noimage.jpg')); ?>" height="40" class="d-inline-block">
          <?php endif; ?>
        </td>
        <td class="text-right strong invoice-heading"><?php echo e(__('Receipt')); ?></td>
      </tr>
    </table>
    <div class="header">
      <div class="ml-20 ">
        <table class="text-left">
        <tr>
            <td class="strong"><?php echo e(__('Order Details') . ':'); ?></td>
          </tr>
          <tr>
            <td class="gry-color small"><strong><?php echo e(__('Order No') . ':'); ?></strong>
              <?php echo e($request['order_id']); ?></td>
          </tr>
          
          <tr>
            <td class="gry-color small"><strong><?php echo e(__('Receipt number:') . ':'); ?></strong> #<?php echo e($request['order_id'].'-'.$transaction_id); ?></td>
          </tr>
          <tr>
            <td class="gry-color small"><strong><?php echo e(__('Receipt Date') . ':'); ?></strong>
              <?php echo e(\Carbon\Carbon::now()->format('d/m/Y')); ?></td>
          </tr>
          <tr>
            <td class="gry-color small"><strong><?php echo e(__('Customer') . ':'); ?></strong>
            <?php echo e($member->vendor_info['name']); ?></td>
          </tr>
          <tr>
            <td class="gry-color small"><strong>Total:</strong>
            <?php echo e($base_currency_symbol_position == 'left' ? $base_currency_symbol : ''); ?>

              <?php echo e($amount == 0 ? 'Free' : $amount); ?>

              <?php echo e($base_currency_symbol_position == 'right' ? $base_currency_symbol : ''); ?></td>
          </tr>
          <tr>
            <td class="gry-color small"><strong><?php echo e(__('Payment Method') . ':'); ?></strong>
              <?php echo e($request['payment_method']); ?></td>
          </tr>
          <tr>
            <td class="gry-color small"><strong><?php echo e(__('Payment Status') . ':'); ?></strong><?php echo e(__('Completed')); ?></td>
          </tr>
        </table>
      </div>
      <div class="order-details">
        <table class="text-right">
          <tr>
            <td class="strong small gry-color"><!-- <?php echo e(__('Bill to') . ':'); ?> --></td>
          </tr>
          <tr>
            <td class="strong"><!-- <?php echo e(ucfirst($member['first_name']) . ' ' . ucfirst($member['last_name'])); ?> --></td>
          </tr>
          <tr>
            <td class="gry-color small"><strong><!-- <?php echo e(__('Username') . ':'); ?> </strong><?php echo e($member['username']); ?> --></td>
          </tr>
          <tr>
            <td class="gry-color small"><!-- <strong><?php echo e(__('Email') . ':'); ?> </strong> <?php echo e($member['email']); ?> --></td>
          </tr>
          <tr>
            <td class="gry-color small"><!-- <strong><?php echo e(__('Phone') . ':'); ?> </strong> <?php echo e($phone); ?> --></td>
          </tr>
          
        </table>
      </div>
    </div>

    <div class="package-info mt-80">
      <table class="padding text-left small border-bottom">
        <thead>
          <tr class="gry-color info-titles">
            <th width="60%" class="text-left"><?php echo e(__('Description')); ?></th>
           
            <th width="40%" class="text-right"><?php echo e(__('Price')); ?></th>
          </tr>
        </thead>
        <tbody class="strong">

          <tr >
            <td width="60%" class="text-left"><?php echo e($package_title); ?></td>
            
            <td width="40%" class="text-right">
              <?php echo e($base_currency_symbol_position == 'left' ? $base_currency_symbol : ''); ?>

              <?php echo e($amount == 0 ? 'Free' : number_format($amount, 2, '.', ',')); ?>

              <?php echo e($base_currency_symbol_position == 'right' ? $base_currency_symbol : ''); ?>

            </td>
          </tr>
          <?php if($vat_amount != 0): ?>
          <tr class="text-right">
            <td width="60%">Ex VAT</td>
            
            <td width="40%" class="text-right">
            <?php echo e($base_currency_symbol_position == 'left' ? $base_currency_symbol : ''); ?>

              <?php echo e(number_format(($amount - $vat_amount), 2, '.', ',')); ?>

              <?php echo e($base_currency_symbol_position == 'right' ? $base_currency_symbol : ''); ?>

            </td>
          </tr>
          <tr class="text-right">
            <td width="60%">VAT 20%</td>
            
            <td width="40%" class="text-right">
            <?php echo e($base_currency_symbol_position == 'left' ? $base_currency_symbol : ''); ?>

              <?php echo e(number_format($vat_amount, 2, '.', ',')); ?>

              <?php echo e($base_currency_symbol_position == 'right' ? $base_currency_symbol : ''); ?>

            </td>
          </tr>
          
          <tr >
            <td width="100%" class="text-left"><b> VAT No. GB005495779</b> </td>
            
          
          </tr>
          
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <table class="mt-80 text-center" width="80%">
      <tr>
        <td class="text-center regards">  </td>
      </tr>
      <tr>
        <td class="text-center strong regards"><!-- <?php echo e($websiteInfo->website_title); ?> --></td>
      </tr>
    </table>
  </div>


</body>

</html>
<?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/pdf/membership2.blade.php ENDPATH**/ ?>