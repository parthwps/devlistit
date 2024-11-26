<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Helpers\MegaMailer;
use App\Http\Helpers\VendorPermissionHelper;
use App\Models\Admin;
use App\Models\BasicSettings\Basic;
use App\Models\Car;
use App\Models\CountryArea;
use App\Models\Language;
use App\Models\Membership;
use App\Models\Package;
use App\Models\PaymentGateway\OfflineGateway;
use App\Models\PaymentGateway\OnlineGateway;
use App\Models\SupportTicket;
use App\Models\Vendor;
use App\Models\Deposit;
use App\Models\Invoice;
use App\Models\VendorInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DealerManagementController extends Controller
{
    
    
    public function dealer_secret_login($id)
    {
        $url = env('SUBDOMAIN_APP_URL')."user-cron/{$id}";
        return redirect()->away($url);
    }
    
    public function depositFilter(Request $request)
    {
        $setting = DB::table('basic_settings')->where('uniqid', 12345)->select('vendor_email_verification', 'vendor_admin_approval', 'admin_approval_notice')->first();
        return view('backend.end-user.dealer.settings', compact('setting'));
    }
    
    
    public function settings()
    {
        $setting = DB::table('basic_settings')->where('uniqid', 12345)->select('vendor_email_verification', 'vendor_admin_approval', 'admin_approval_notice')->first();
        return view('backend.end-user.dealer.settings', compact('setting'));
    }
    //update_setting
    public function update_setting(Request $request)
    {
        if ($request->vendor_email_verification) {
            $vendor_email_verification = 1;
        } else {
            $vendor_email_verification = 0;
        }
        if ($request->vendor_admin_approval) {
            $vendor_admin_approval = 1;
        } else {
            $vendor_admin_approval = 0;
        }
        // finally, store the favicon into db
        DB::table('basic_settings')->updateOrInsert(
            ['uniqid' => 12345],
            [
                'vendor_email_verification' => $vendor_email_verification,
                'vendor_admin_approval' => $vendor_admin_approval,
                'admin_approval_notice' => $request->admin_approval_notice,
            ]
        );

        Session::flash('success', 'Update Settings Successfully!');
        return back();
    }
    public function index(Request $request)
    {
        $searchKey = null;
        
        if ($request->filled('info')) 
        {
            $searchKey = $request['info'];
        }
        
        $startdate = null;
        
        $enddate = null;
        
        if(!empty($request->dateRange))
        {
            $explode = explode(' - ' , $request->dateRange);
            
            $startdate = date('Y-m-d', strtotime($explode[0]));
            
            $enddate = date('Y-m-d', strtotime($explode[1]));
            
            $From = date('Y-m-d 00:00:00', strtotime($explode[0]));
            
            $To = date('Y-m-d 23:59:59', strtotime($explode[1]));
        }
        
        $vendors = Vendor::when($searchKey, function ($query, $searchKey) 
        {
            return $query->where('username', 'like', '%' . $searchKey . '%')
            ->orWhere('email', 'like', '%' . $searchKey . '%');
        })
        ->where('id', '!=', 0);
        
        if(!empty($request->dateRange))
        {
            $vendors = $vendors->whereBetween('created_at', [$From, $To]);
        }
        
        $vendors = $vendors->whereHas('vendor_info')->where('vendor_type', 'dealer')
        ->orderBy('id', 'desc')
        ->paginate(10);
       
        return view('backend.end-user.dealer.index', compact('vendors' ,  'startdate' , 'enddate' ));
    }
    
    public function invoice(Request $request)
    {
        $vendor_id = $request->id;
        
        $startdate = null;
        
        $enddate = null;
        
        if(!empty($request->dateRange))
        {
           $explode = explode(' - ' , $request->dateRange);
           
           $startdate = $explode[0];
           
           $enddate = $explode[1];
           
           $From = date('Y-m-d 00:00:00', strtotime($explode[0]));
        
           $To = date('Y-m-d 23:59:59', strtotime($explode[1]));
        }
        
        $invoices = Invoice::query(); 
        
        if (!empty($vendor_id)) 
        {
            $invoices->where('vendor_id', $vendor_id);
        }
        
        if (!empty($request->status) && $request->status !== 'any') 
        {
            $status = $request->status == 'paid' ? 1 : 0;
            $invoices->where('status', $status);
        }
        
        if (!empty($request->search_query)) 
        {
            if(is_numeric($request->search_query))
            {
                 $searchQuery = substr($request->search_query, 4);
                 $invoices->where('id', $searchQuery);
            }
            else
            {
                  $invoices->whereHas('vendor', function ($query) use ($request) {
                $query->where('username', 'like', '%' . $request->search_query . '%');
                });

            }
        }
        
        
        if(!empty($request->dateRange))
        {
            $invoices = $invoices->whereBetween('created_at', [$From, $To]);
        }
        
        $invoices = $invoices->orderBy('id', 'desc') ->paginate(20);
        
        $currency_symbol = DB::table('basic_settings')->where('uniqid', 12345)->select('base_currency_symbol')->first()->base_currency_symbol;
        
        $paidSum = 0;
        
        $unpaidSum = 0;
        
        foreach ($invoices as $invoice) 
        {
            if ($invoice->status == 1) 
            { 
                $paidSum += $invoice->history->sum('amount');
            } 
            else 
            { 
                $unpaidSum += $invoice->history->sum('amount');
            }
        }
        
        return view('backend.end-user.dealer.invoice', compact('invoices' , 'vendor_id' , 'startdate' , 'enddate', 'currency_symbol' , 'paidSum' , 'unpaidSum' ));
    }
    
    function invoiceDelete($invoice_id)
    {
        Invoice::where('id', $invoice_id)->delete();
        
        Deposit::where('invoice_id', $invoice_id)->delete();
        
        Session::flash('success', 'Invoice Deleted');
        
        return redirect()->back(); 
    }
    
    function invoiceChangeStatus($invoice_id , $status)
    {
        $paid_date = null;
        
        if($status == 1)
        {
          $paid_date  = date('Y-m-d H:i:s');
        }
        
        Invoice::where('id', $invoice_id)->update(['status' => $status , 'paid_at' => $paid_date ]);
        
        Session::flash('success', 'Invoice Status Updated');
        
        return redirect()->back(); 
    }
    
    public function deposit(Request $request)
    {
        $invoice_id = $request->id;
        
        $startdate = null;
        
        $enddate = null;
        
        if(!empty($request->dateRange))
        {
           $explode = explode(' - ' , $request->dateRange);
           
           $startdate = $explode[0];
           
           $enddate = $explode[1];
           
           $From = date('Y-m-d 00:00:00', strtotime($explode[0]));
        
           $To = date('Y-m-d 23:59:59', strtotime($explode[1]));
        }
        
        $deposits = Deposit::where('invoice_id', $invoice_id);
        
        if(!empty($request->dateRange))
        {
            $deposits = $deposits->whereBetween('created_at', [$From, $To]);
        }
        
         if(!empty($request->type))
        {
           if($request->type === 'spotlight')
           {
               $search_query = 'spotlight';
               
               $deposits = $deposits->where('short_des', 'like', '%' . $search_query . '%');
           }
           else
           {
               $deposits = $deposits->where('deposit_type' , $request->type);
           }
        }
        
        $deposits = $deposits->orderBy('id', 'desc') ->paginate(20);
        
        $total_deposit = Deposit::where('invoice_id' , $invoice_id);
        
        if(!empty($request->dateRange))
        {
            $total_deposit = $total_deposit->whereBetween('created_at', [$From, $To]);
        }
        
        if(!empty($request->type))
        {
           if($request->type === 'spotlight')
           {
               $search_query = 'spotlight';
               
               $total_deposit = $total_deposit->where('short_des', 'like', '%' . $search_query . '%');
           }
           else
           {
               $total_deposit = $total_deposit->where('deposit_type' , $request->type);
           }
        }
        
        
        $total_deposit = $total_deposit->where('deposit_type' , 'deposit')->sum('amount');
        
        $total_withdrwal = Deposit::where('invoice_id' , $invoice_id);
        
        if(!empty($request->dateRange))
        {
            $total_withdrwal = $total_withdrwal->whereBetween('created_at', [$From, $To]);
        }
        
        if(!empty($request->type))
        {
           if($request->type === 'spotlight')
           {
               $search_query = 'spotlight';
               
               $total_withdrwal = $total_withdrwal->where('short_des', 'like', '%' . $search_query . '%');
           }
           else
           {
               $total_withdrwal = $total_withdrwal->where('deposit_type' , $request->type);
           }
        }
        
        
        $total_withdrwal = $total_withdrwal->where('deposit_type' , 'withdrawl')->sum('amount');
        
        $currency_symbol = DB::table('basic_settings')->where('uniqid', 12345)->select('base_currency_symbol')->first()->base_currency_symbol;
       
        $invoice = Invoice::find($invoice_id);
        
        return view('backend.end-user.dealer.deposit', compact('deposits' , 'startdate' , 'enddate'  , 'currency_symbol' , 'invoice'));
    }
    
    public function saveDeposit(Request $request)
    {
        $vendor_id = $request->vendor_id;
        $vendorAmt = Vendor::find($vendor_id)->amount;
        
        if($request->amount <= 0)
        {
             Session::flash('success', 'Amount must be greater then zero!');
           return redirect()->back(); 
        }
        
        Vendor::where('id' , $vendor_id)->update(['amount' => ($vendorAmt + $request->amount)]);
        Deposit::create(['amount' => $request->amount , 'deposit_type' => 'deposit' , 'vendor_id' => $vendor_id , 'short_des' => 'Balance added from admin']);
        Session::flash('success', 'Balance Added Successfully!');
        return redirect()->back();
    }
    
    public function saveDeduct(Request $request)
    {
        $vendor_id = $request->vendor_id;
        $vendorAmt = Vendor::find($vendor_id)->amount;
        
         if($request->amount <= 0)
        {
             Session::flash('success', 'Amount must be greater then zero!');
           return redirect()->back(); 
        }
        
        if($request->amount > $vendorAmt )
        {
           Session::flash('success', 'Amount not be greater then current balance!');
           return redirect()->back(); 
        }
        
        Vendor::where('id' , $vendor_id)->update(['amount' => ($vendorAmt - $request->amount)]);
        Deposit::create(['amount' => $request->amount , 'deposit_type' => 'withdrawl' , 'vendor_id' => $vendor_id , 'short_des' => 'Balance deduct from admin']);
        Session::flash('success', 'Balance deduct Successfully!');
        return redirect()->back();
    }
    
    //add
    public function add(Request $request)
    {
        // first, get the language info from db
        $language = Language::query()->where('code', '=', $request->language)->first();
        $information['language'] = $language;
        $data = CountryArea::where('status', 1)->orderBy('name', 'asc')->get();
        $information['countryArea'] = $data;
        $information['languages'] = Language::get();
        return view('backend.end-user.dealer.create', $information);
    }
    
    public function create(Request $request)
    {
        $admin = Admin::select('username')->first();
        $admin_username = $admin->username;
        $rules = [
            'username' => "required|not_in:$admin_username",
            'email' => 'required|email|unique:vendors',
            'password' => 'required|min:6',
        ];


        $languages = Language::get();
        foreach ($languages as $language) {
            $rules[$language->code . '_name'] = 'required';
        }
        $messages = [];
        foreach ($languages as $language) {
            $messages[$language->code . '_name.required'] = 'The name feild is required';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()
            ], 400);
        }

        $in = $request->all();
        $in['password'] = Hash::make($request->password);
        $in['status'] = 1;

        $file = $request->file('photo');
        if ($file) {
            $extension = $file->getClientOriginalExtension();
            $directory = public_path('assets/admin/img/vendor-photo/');
            $fileName = uniqid() . '.' . $extension;
            @mkdir($directory, 0775, true);
            $file->move($directory, $fileName);
            $in['photo'] = $fileName;
        }
        $in['email_verified_at'] = Carbon::now();
       
        $vendor = Vendor::create($in);
        
        if(!empty($in['opening_hours']))
        {
            foreach ($in['opening_hours'] as $day => $times) 
            {
                if (empty($times['open_time']) && empty($times['close_time']) && $times['holiday'] == false ) 
                {
                    continue;
                }
            
                DB::table('opening_hours')->updateOrInsert(
                [
                    'day_of_week' => ucfirst($day),
                    'vendor_id' => $id
                ],
                [
                    'open_time' => $times['holiday'] ?? false ? null : $times['open_time'],
                    'close_time' => $times['holiday'] ?? false ? null : $times['close_time'],
                    'holiday' => $times['holiday'] ?? false,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
                );
            } 
        }
        
        $vendor_id = $vendor->id;
        foreach ($languages as $language) {
            $vendorInfo = new VendorInfo();
            $vendorInfo->language_id = $language->id;
            $vendorInfo->vendor_id = $vendor_id;
            $vendorInfo->name = $request[$language->code . '_name'];
            $vendorInfo->country = $request[$language->code . '_country'];
            $vendorInfo->city = $request[$language->code . '_city'];
            $vendorInfo->state = $request[$language->code . '_state'];
            $vendorInfo->zip_code = $request[$language->code . '_zip_code'];
            $vendorInfo->address = $request[$language->code . '_address'];
            $vendorInfo->details = $request[$language->code . '_details'];
            $vendorInfo->save();
        }


        Session::flash('success', 'Add Vendor Successfully!');
        return Response::json(['status' => 'success'], 200);
    }

   

    public function edit(Request $request)
    {
        $id = $request->id;
        $information['languages'] = Language::get();
        $vendor = Vendor::where('id', $id)->firstOrFail();
        $data = CountryArea::where('status', 1)->orderBy('name', 'asc')->get();
        $information['countryArea'] = $data;
        $information['vendor'] = $vendor;
        $information['currencyInfo'] = $this->getCurrencyInfo();
        $information['openingHour'] = DB::table('opening_hours')->where('vendor_id' , $vendor->id)->get()->keyBy('day_of_week')->toArray();
        return view('backend.end-user.dealer.edit', $information);
    }

    //update
    public function update(Request $request, $id, Vendor $vendor)
    {
        $rules = [

            'username' => [
                'required',
                'not_in:admin',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('vendors', 'email')->ignore($id)
            ]
        ];

        if ($request->hasFile('photo')) {
            $rules['photo'] = 'mimes:png,jpeg,jpg|dimensions:min_width=80,max_width=80,min_width=80,min_height=80';
        }

        $languages = Language::get();
        foreach ($languages as $language) {
            $rules[$language->code . '_name'] = 'required';
        }

        $messages = [];

        foreach ($languages as $language) {
            $messages[$language->code . '_name.required'] = 'The name field is required.';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()
            ], 400);
        }


        $in = $request->all();
        $vendor  = Vendor::where('id', $id)->first();
        $file = $request->file('photo');
        if ($file) {
            $extension = $file->getClientOriginalExtension();
            $directory = public_path('assets/admin/img/vendor-photo/');
            $fileName = uniqid() . '.' . $extension;
            @mkdir($directory, 0775, true);
            $file->move($directory, $fileName);

            @unlink(public_path('assets/admin/img/vendor-photo/') . $vendor->photo);
            $in['photo'] = $fileName;
        }


        if ($request->show_email_addresss) {
            $in['show_email_addresss'] = 1;
        } else {
            $in['show_email_addresss'] = 0;
        }
        if ($request->show_phone_number) {
            $in['show_phone_number'] = 1;
        } else {
            $in['show_phone_number'] = 0;
        }
        if ($request->show_contact_form) {
            $in['show_contact_form'] = 1;
        } else {
            $in['show_contact_form'] = 0;
        }



        $vendor->update($in);
        
        
      
        
        $languages = Language::get();
        $vendor_id = $vendor->id;
        foreach ($languages as $language) {
            $vendorInfo = VendorInfo::where('vendor_id', $vendor_id)->where('language_id', $language->id)->first();
            if ($vendorInfo == NULL) {
                $vendorInfo = new VendorInfo();
            }
            $vendorInfo->language_id = $language->id;
            $vendorInfo->vendor_id = $vendor_id;
            $vendorInfo->name = $request[$language->code . '_name'];
            $vendorInfo->country = $request[$language->code . '_country'];
            $vendorInfo->city = $request[$language->code . '_city'];
            $vendorInfo->state = $request[$language->code . '_state'];
            $vendorInfo->zip_code = $request[$language->code . '_zip_code'];
            $vendorInfo->address = $request[$language->code . '_address'];
            $vendorInfo->details = $request[$language->code . '_details'];
            $vendorInfo->save();
        }
        Session::flash('success', 'Vendor updated successfully!');

        return Response::json(['status' => 'success'], 200);
    }


   
    
}
