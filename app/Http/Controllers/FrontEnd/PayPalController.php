<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;

use App\Http\Controllers\User\UserCheckoutController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Helpers\UserPermissionHelper;
use App\Models\PrivatePackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Vendor\VendorCheckoutController;
use App\Http\Helpers\MegaMailer;
use App\Http\Helpers\VendorPermissionHelper;
use App\Models\BasicSettings\Basic;
use App\Models\Language;
use App\Models\Membership;
use App\Models\PaymentGateway\OnlineGateway;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use PayPal\Api\CreditCard;
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
use PayPal\Api\FundingInstrument;


class PayPalController extends Controller
{
    private $_api_context;

    public function __construct()
    {
        $data = OnlineGateway::where('keyword', 'paypal')->first();
        $paydata = $data->convertAutoData();
        $paypal_conf = Config::get('paypal');
        $paypal_conf['client_id'] = $paydata['client_id'];
        $paypal_conf['secret'] = $paydata['client_secret'];

        $paypalClientId = $paydata['client_id'];
        $paypalClientSecret = $paydata['client_secret'];

        $this->_api_context = new ApiContext(
            new OAuthTokenCredential($paypalClientId, $paypalClientSecret)
        );

        $this->_api_context->setConfig([
            'mode' => 'sandbox', // Change to 'live' for production
        ]);
    }
    public function createOrder(Request $request)
    {
         $clientId = $paypalClientId;
        $clientSecret = $paypalClientSecret;
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.sandbox.paypal.com/v2/checkout/orders');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"intent\":\"CAPTURE\",\"purchase_units\":[{\"amount\":{\"currency_code\":\"USD\",\"value\":\"10.00\"}}]}");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($clientId . ':' . $clientSecret)
        ));

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return response()->json(['error' => curl_error($ch)], 500);
        }
        curl_close($ch);
        
        $resultArray = json_decode($result, true);
        return response()->json($resultArray); 
    }

    public function makePayment(Request $request)
    {
       

        $creditCard = new CreditCard();
        $creditCard->setType($request->input('card_type'));
        $creditCard->setNumber($request->input('card_number'));
        $creditCard->setExpireMonth($request->input('card_expiry_month'));
        $creditCard->setExpireYear($request->input('card_expiry_year'));
        $creditCard->setCvv2($request->input('card_cvv'));
        $creditCard->setFirstName($request->input('first_name'));
        $creditCard->setLastName($request->input('last_name'));
        //echo "<pre>";
        // print_r($creditCard);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $payer->setFundingInstruments(array($creditCard));

        $amount = new Amount();
        $amount->setCurrency('GBP');
        $amount->setTotal('10');

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription('Payment description');

        $payment = new Payment();
        $payment->setIntent('sale');
        $payment->setPayer($payer);
        $payment->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
            return response()->json(['success' => true, 'message' => 'Payment successful']);
        } catch (\Exception $ex) {
            return response()->json(['success' => false, 'message' => $ex->getMessage(), "detail" => json_decode($ex->getData())]);
        }
    }
    public function paynow()
    {
        $misc = new MiscellaneousController();

        $language = $misc->getLanguage();

        $queryResult['seoInfo'] = $language->seoInfo()->select('meta_keyword_faq', 'meta_description_faq')->first();

        $queryResult['pageHeading'] = $misc->getPageHeading($language);

        $queryResult['bgImg'] = $misc->getBreadcrumb();
        return view('frontend.car.paynow', $queryResult);
    }
}
