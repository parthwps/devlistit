<?php

namespace App\Http\Controllers;

use App\Models\BasicSettings\Basic;
use Config;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Mail\Message;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Mail;
use PDF;
use PHPMailer\PHPMailer\PHPMailer;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function getCurrencyInfo()
  {
    $baseCurrencyInfo = Basic::select('base_currency_symbol', 'base_currency_symbol_position', 'base_currency_text', 'base_currency_text_position', 'base_currency_rate')
      ->firstOrFail();

    return $baseCurrencyInfo;
  }

  public function makeInvoice($request ,  $key, $member, $password, $amount,  $payment_method, $phone, $base_currency_symbol_position, $base_currency_symbol, $base_currency_text, $transaction_id, $package_title, $membership)
  {
   
    if (empty($request['order_id'])) 
    {
        $request['order_id'] = rand(0000, 9999);
    }
  
    
    if(empty($vat_amount))
    {
        $request_price = !empty($request['price']) ? $request['price'] : $amount;
        $price =  round($request_price * ((100-20) / 100), 2);
        $vat_amount =  round($request_price  - $price,2); 
    }
    
    $file_name = $request['order_id'].'-'.$transaction_id. ".pdf";
    $amount = $price+$vat_amount;
     
    
    $pdf = PDF::loadView('pdf.membership2', compact('request', 'member', 'password', 'amount','vat_amount', 'payment_method', 'phone', 'base_currency_symbol_position', 'base_currency_symbol', 'base_currency_text', 'transaction_id', 'package_title', 'membership'));
    $output = $pdf->output();
    @mkdir(public_path('assets/front/invoices/'), 0775, true);
    file_put_contents(public_path('assets/front/invoices/') . $file_name, $output);
    return $file_name;
    
  }

  public function sendMailWithPhpMailer($request, $file_name, $bs, $subject, $body, $email, $name)
  {
    //larave facade mail
    if ($bs->smtp_status == 1) {
      try {
        $smtp = [
          'transport' => 'smtp',
          'host' => $bs->smtp_host,
          'port' => $bs->smtp_port,
          'encryption' => $bs->encryption,
          'username' => $bs->smtp_username,
          'password' => $bs->smtp_password,
          'timeout' => null,
          'auth_mode' => null,
        ];
        Config::set('mail.mailers.smtp', $smtp);
      } catch (\Exception $e) {
        session()->flash('error', $e->getMessage());
        return back();
      }
    }

    $data = [
      'to' => $email,
      'subject' => $subject,
      'body' => $body,
      'file_name' => public_path('assets/front/invoices/') . $file_name,
    ];
    try {
      Mail::send([], [], function (Message $message) use ($data, $bs) {
        $fromMail = $bs->from_mail;
        $fromName = $bs->from_name;
        $message->to($data['to'])
          ->subject($data['subject'])
          ->from($fromMail, $fromName)
          ->html($data['body'], 'text/html');

        $message->attach($data['file_name'], [
          'as' => 'Attachment',
          'mime' => 'application/pdf',
        ]);
      });
      return;
    } catch (\Exception $e) {
      Session::flash('error', 'Something went wrong.');
      return back();
    }
    //larave facade mail end
  }
}
