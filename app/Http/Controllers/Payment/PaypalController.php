<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\User\UserCheckoutController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Helpers\UserPermissionHelper;
use App\Models\PrivatePackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Vendor\VendorCheckoutController;
use App\Http\Helpers\MegaMailer;
use App\Http\Helpers\VendorPermissionHelper;
use App\Models\BasicSettings\Basic;
use App\Models\Language;
use App\Models\Membership;
use App\Models\Car;
use App\Models\VendorInfo;
use App\Models\PaymentGateway\OnlineGateway;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Illuminate\Support\Facades\Session;

class PaypalController extends Controller
{
    private $_api_context;

    public function __construct()
    {
        $data = OnlineGateway::where('keyword', 'paypal')->first();
        $paydata = $data->convertAutoData();
        $paypal_conf = Config::get('paypal');
        $paypal_conf['client_id'] = $paydata['client_id'];
        $paypal_conf['secret'] = $paydata['client_secret'];
        $paypal_conf['settings']['mode'] = $paydata['sandbox_status'] == 1 ? 'sandbox' : 'live';
        $this->_api_context = new ApiContext(
            new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret']
            )
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
    public function paywithcard()
    {
        $data = OnlineGateway::where('keyword', 'paypal')->first();
        $paydata = $data->convertAutoData();
        $client = new PayPalHttpClient(new SandboxEnvironment(config($paydata['client_id']), config($paydata['client_secret'])));
        
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => "USD",
                    "value" => "10.00" // or fetch dynamically from your request
                ]
            ]]
        ];

        try {
            $response = $client->execute($request);

            return redirect($response->result->links[1]->href); // Redirect user to PayPal for payment
        } catch (HttpException $ex) {
            return redirect()->back()->with('error', 'Payment processing error.');
        }
    }


    public function paymentProcess(Request $request, $_amount, $_title, $_success_url, $_cancel_url)
    {

        $title = $_title;
        $price = $_amount;
        $price = round($price, 2);
        $cancel_url = $_cancel_url;
        $success_url = $_success_url;

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName($title)
            /** item name **/
            ->setCurrency("USD")
            ->setQuantity(1)
            ->setPrice($price);
        /** unit price **/
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($price);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($title . ' Via Paypal');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl($success_url)
            /** Specify return URL **/
            ->setCancelUrl($cancel_url);
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        Session::put('request', $request->all());
        Session::put('amount', $_amount);
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        return redirect()->back()->with('error', 'Unknown error occurred');
    }

    public function successPaymentOld(Request $request)
    {
       
        $requestData = Session::get('request');
        $bs = Basic::first();

        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        $cancel_url = route('membership.paypal.cancel');
        
        if (empty($request['PayerID']) || empty($request['token'])) {
            return redirect($cancel_url);
        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request['PayerID']);
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            $information = [];
            Session::put('orderID', $requestData['order_id']);
            $paymentFor = Session::get('paymentFor');
            $response = json_decode($payment, true);
            $package = PrivatePackage::find($requestData['package_id']);
            $ptitle = $package->title.' Ad Listed for  '. $package->days_listing. ' days';
            $vendorinfo  = VendorInfo::where('vendor_id', $requestData['vendor_id'])->first();
            $carContent  = Car::where('order_id', $requestData['order_id'])->first();
            if($vendorinfo->vatVerified ==1){
                $amount =  number_format(round($requestData['price'] * ((100-20) / 100), 2), 2, '.', ',');
                $vat_amount =  number_format(round($requestData['price'] * ((100-20) / 100), 2), 2, '.', ',');              
            }else{
                    $amount = number_format($requestData['price'], 2, '.', ',');
                    $vat_amount = 0;
            }

            $transaction_id = VendorPermissionHelper::uniqidReal(8);
            $transaction_details = $payment;
            if ($paymentFor == "membership") {
                $amount = $requestData['price'];
                $password = $requestData['password'];
                $checkout = new VendorCheckoutController();

                $vendor = $checkout->store($requestData, $transaction_id, $transaction_details, $amount, $bs, $password);

                $lastMemb = $vendor->memberships()->orderBy('id', 'DESC')->first();

                $activation = Carbon::parse($lastMemb->start_date);
                $expire = Carbon::parse($lastMemb->expire_date);
                $file_name = $this->makeInvoice($requestData, "membership", $vendor, $amount, "Paypal", $requestData['phone'], $bs->base_currency_symbol_position, $bs->base_currency_symbol, $bs->base_currency_text, $transaction_id, $ptitle, $lastMemb);

                $mailer = new MegaMailer();
                $data = [
                    'toMail' => $vendor->email,
                    'toName' => $vendor->fname,
                    'username' => $vendor->username,
                    'package_title' => $ptitle,
                    'package_price' => ($bs->base_currency_text_position == 'left' ? $bs->base_currency_text . ' ' : '') . $amount . ($bs->base_currency_text_position == 'right' ? ' ' . $bs->base_currency_text : ''),
                    'vat_amount' => ($bs->base_currency_text_position == 'left' ? $bs->base_currency_text . ' ' : '') . $vat_amount . ($bs->base_currency_text_position == 'right' ? ' ' . $bs->base_currency_text : ''),
                    'discount' => ($bs->base_currency_text_position == 'left' ? $bs->base_currency_text . ' ' : '') . $lastMemb->discount . ($bs->base_currency_text_position == 'right' ? ' ' . $bs->base_currency_text : ''),
                    'total' => ($bs->base_currency_text_position == 'left' ? $bs->base_currency_text . ' ' : '') . $lastMemb->price . ($bs->base_currency_text_position == 'right' ? ' ' . $bs->base_currency_text : ''),
                    'activation_date' => $activation->toFormattedDateString(),
                    'expire_date' => Carbon::parse($expire->toFormattedDateString())->format('Y') == '9999' ? 'Lifetime' : $expire->toFormattedDateString(),
                    'membership_invoice' => $file_name,
                    'website_title' => $bs->website_title,
                    'templateType' => 'registration_with_premium_package',
                    'type' => 'registrationWithPremiumPackage'
                ];
                $mailer->mailFromAdmin($data);
               // @unlink(public_path('assets/front/invoices/' . $file_name));

                session()->flash('success', 'Your payment has been completed.');
                Session::forget('request');
                Session::forget('paymentFor');
                return redirect()->route('success.page');
            } elseif ($paymentFor == "extend") {

               
                $password = uniqid('qrcode');
                $checkout = new VendorCheckoutController();
                $amount = number_format($requestData['price'], 2, '.', ',');
                $vendor = $checkout->store($requestData, $transaction_id, $transaction_details, $amount, $vat_amount, $bs, $password);
                
                     

                $lastMemb = Membership::where('vendor_id', $vendor->id)->orderBy('id', 'DESC')->first();
                $activation = Carbon::parse($lastMemb->start_date);
                $expire = Carbon::parse($lastMemb->expire_date);

                $file_name = $this->makeInvoice($requestData, "extend", $vendor, $amount,$vat_amount, $requestData["payment_method"], $vendor->phone, $bs->base_currency_symbol_position, $bs->base_currency_symbol, $bs->base_currency_text, $transaction_id, $ptitle, $lastMemb);

                $mailer = new MegaMailer();
                $data = [
                    'toMail' => $vendor->email,
                    'toName' => $vendor->fname,
                    'username' => $vendor->vendor_info->name,
                    'package_title' => $ptitle,
                    'package_price' => $amount,
                    'vat_amount' => $vat_amount,
                    'currency_symbol' => $bs->base_currency_symbol,
                    'receipt_number' => $file_name,
                    'activation_date' => $activation->toFormattedDateString(),
                    'expire_date' => Carbon::parse($expire->toFormattedDateString())->format('Y') == '9999' ? 'Lifetime' : $expire->toFormattedDateString(),
                    'membership_invoice' => $file_name,
                    'website_title' => $bs->website_title,
                    'templateType' => 'membership_extend',
                    'mail_subject' => ''.$carContent->car_content->title.' - ad is Published',
                    'type' => 'membershipExtend'
                ];
                $mailer->mailFromAdmin($data);
               // @unlink(public_path('assets/front/invoices/' . $file_name));

                Session::forget('request');
                Session::forget('paymentFor');
                return redirect()->route('success.page');
            }
        }
        return redirect($cancel_url);
    }

    public function cancelPayment()
    {
        $requestData = Session::get('request');
        $paymentFor = Session::get('paymentFor');
        session()->flash('warning', __('cancel_payment'));
        if ($paymentFor == "membership") {
            return redirect()->route('front.register.view', ['status' => $requestData['package_type'], 'id' => $requestData['package_id']])->withInput($requestData);
        } else {
            return redirect()->route('vendor.plan.extend.checkout', ['package_id' => $requestData['package_id']])->withInput($requestData);
        }
    }

    public function successPayment(Request $request)
    {

        $bs = Basic::first();
        
          
        //   dd($request->all());

        if ($request['order_status'] == 'COMPLETED' || !empty($request->testBTN)) 
        {
                      
                $information = [];
                Session::put('orderID', $request['order_id']);
                $paymentFor = "extend";
                //$response = json_decode($payment, true);
                $package = PrivatePackage::find($request['package_id']);
                $ptitle = $package->title.' Ad Listed for  '. $package->days_listing. ' days';
                $vendorinfo  = VendorInfo::where('vendor_id', $request['vendor_id'])->first();
                $carContent  = Car::where('order_id', $request['order_id'])->first();
                // if($vendorinfo->vatVerified ==1){
                    $amount =  round($request['price'] * ((100-20) / 100), 2);
                    $vat_amount =  round($request['price'] - $amount,2);              
                // }else{
                //         $amount = $request['price'];
                //         $vat_amount = 0;
                // }
                $carContent->update(['status' => 1]);

                $transaction_id = VendorPermissionHelper::uniqidReal(8);
                $transaction_details = $request['order_status'];
           

               
                $password = uniqid('qrcode');
                $checkout = new VendorCheckoutController();
                $amount = $request['price'];
                $vendor = $checkout->store($request, $transaction_id, $transaction_details, $amount, $vat_amount, $bs, $password);
                
                    
                $lastMemb = Membership::where('vendor_id', $vendor->id)->orderBy('id', 'DESC')->first();
                $activation = Carbon::parse($lastMemb->start_date);
                $expire = Carbon::parse($lastMemb->expire_date);
            
            $url =  route('frontend.car.details', ['cattitle' => catslug($carContent->car_content->category_id), 'slug' => $carContent->car_content->slug, 'id' => $carContent->id]);
            $manageUrl = url('customer/ad-management?language=en');
            
             $image_path = $carContent->feature_image;
            
            $rotation = 0;
            
            if($carContent->rotation_point > 0 )
            {
                $rotation = $carContent->rotation_point;
            }
            
            if(!empty($image_path) && $carContent->rotation_point == 0 )
            {   
               $rotation = $carContent->galleries->where('image' , $image_path)->first();
               
               if($rotation == true)
               {
                    $rotation = $rotation->rotation_point;  
               }
               else
               {
                    $rotation = 0;   
               }
            }
            
            if(empty($carContent->feature_image))
            {
                $image_path = $carContent->galleries[0]->image;
                $rotation = $carContent->galleries[0]->rotation_point;
            }
            
            $imageUrl = $carContent->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path;
            
          
                $file_name = $this->makeInvoice($request, "extend", $vendor, $amount,$vat_amount, $request["payment_method"], $vendor->phone, $bs->base_currency_symbol_position, $bs->base_currency_symbol, $bs->base_currency_text, $transaction_id, $ptitle, $lastMemb);

                $mailer = new MegaMailer();
                $data = [
                    'toMail' => $vendor->email,
                    'toName' => $vendor->fname,
                    'username' => $vendor->vendor_info->name,
                    'package_title' => $ptitle,
                    'package_price' => $amount,
                    'vat_amount' => $vat_amount,
                    'currency_symbol' => $bs->base_currency_symbol,
                    'receipt_number' => $file_name,
                    'activation_date' => $activation->toFormattedDateString(),
                    'expire_date' => Carbon::parse($expire->toFormattedDateString())->format('Y') == '9999' ? 'Lifetime' : $expire->toFormattedDateString(),
                    'membership_invoice' => $file_name,
                    'website_title' => $bs->website_title,
                    'templateType' => 'membership_extend',
                    'mail_subject' => ''.$carContent->car_content->title.' - ad is Published',
                    'type' => 'membershipExtend'
                ];
                $mailer->mailFromAdmin($data);
               // @unlink(public_path('assets/front/invoices/' . $file_name));

                $addHtml = view('email.sendaddlive' ,  compact('carContent' , 'url' , 'manageUrl' , 'imageUrl' , 'rotation' ))->render();
                
                $data = ['recipient' => $vendor->email , 'subject' => 'Ad Published'  , 'body' => $addHtml ];
                
                \App\Http\Helpers\BasicMailer::sendMail($data); 
            
            if(!empty($request->request_mode) && $request->request_mode == 'apis')
            {
                 return redirect()->route('paypal.response' , ['success' , $carContent->id , 'appUrl' => session('appUrl') , 'msg' => 'Your Payment has been successfully done.'  ]); 
                
                 return response()->json(['success' => 'Your Payment has been successfully done.'] , 200 );
            }
            else
            {
                Session::forget('request');
                Session::forget('paymentFor');
                return redirect()->route('success.page'); 
            }
        }
        
        if(!empty($request->request_mode) && $request->request_mode == 'apis')
        {
             return redirect()->route('paypal.response' , ['error' , $carContent->id , 'appUrl' => session('appUrl') , 'msg' => 'something went wrong.' ]); 
             
             return response()->json(['error' => 'something went wrong.'] , 500 );
        }
        else
        {
            return redirect($cancel_url);
        }
    }
}
//Merchant ID : mtyf8srygvbryfbm
//Public Key: 4t4ty6ky57r9jspv
//Private Key :3a42d6f3291398a3038460dd08ce2bec
//https://listit.im/vendor/membership/paypal/success?paymentId=PAYID-MXW6PIQ6M531967KC907730H&token=EC-7A468988BU8143453&PayerID=PJRJ4YRRYU5TL
