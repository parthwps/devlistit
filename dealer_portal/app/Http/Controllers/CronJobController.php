<?php

namespace App\Http\Controllers;

use App\Http\Helpers\VendorPermissionHelper;
use App\Jobs\SubscriptionExpiredMail;
use App\Jobs\SubscriptionReminderMail;
use App\Models\BasicSettings\Basic;
use App\Models\Membership;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Mail\MyReportMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Language;
use App\Models\Car;
use Auth;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\DB;
use App\Models\Car\CarModel;
use App\Models\Car\Brand;
use App\Models\Car\Wishlist;
use App\Models\SupportTicket;
use App\Models\EmailSubscriptionReport;
use Illuminate\Support\Facades\Session;

class CronJobController extends Controller
{
    
    function usercron($id)
    {
        Session::put('secret_login', 1);
        $vendor = Vendor::where('id', $id)->first();
        Auth::guard('vendor')->login($vendor);
        return redirect()->route('vendor.dashboard');
    }
    
    public function expired()
    {
        try {
            $bs = Basic::first();

            $expired_members = Membership::whereDate('expire_date', Carbon::now()->subDays(1))->get();
            foreach ($expired_members as $key => $expired_member) {
                if (!empty($expired_member->vendor)) {
                    $vendor = $expired_member->vendor;
                    $current_package = VendorPermissionHelper::userPackage($vendor->id);
                    if (is_null($current_package)) {
                        SubscriptionExpiredMail::dispatch($vendor, $bs);
                    }
                }
            }

            $remind_members = Membership::whereDate('expire_date', Carbon::now()->addDays($bs->expiration_reminder))->get();
            foreach ($remind_members as $key => $remind_member) {
                if (!empty($remind_member->vendor)) {
                    $vendor = $remind_member->vendor;

                    $nextPacakgeCount = Membership::where([
                        ['vendor_id', $vendor->id],
                        ['start_date', '>', Carbon::now()->toDateString()]
                    ])->where('status', '<>', 2)->count();

                    if ($nextPacakgeCount == 0) {
                        SubscriptionReminderMail::dispatch($vendor, $bs, $remind_member->expire_date);
                    }
                }
                \Artisan::call("queue:work --stop-when-empty");
            }
        } catch (\Exception $e) {
        }
    }

    function emailReport()
    {
       $vendors = Vendor::where('email_subscription_enable' , 1)->get(['id']);
        
       if($vendors->count() > 0 )
       {

        $email_config = Basic::latest('id')->first();

        config([
            'mail.mailers.smtp.host' => $email_config->smtp_host,
            'mail.mailers.smtp.port' => $email_config->smtp_port,
            'mail.mailers.smtp.username' => $email_config->smtp_username,
            'mail.mailers.smtp.password' => $email_config->smtp_password,
            'mail.mailers.smtp.encryption' => $email_config->encryption,
            'mail.from.address' => $email_config->from_mail, // Add this line
            'mail.from.name' => $email_config->from_name,
        ]);
        
        foreach($vendors as $vendor)
        {
            $vendor_id = $vendor->id;
            $email_subscriptions = EmailSubscriptionReport::where('dealer_id' , $vendor_id)->get(['mails']);
            $data =array();
            $messageContent =array();

            foreach($email_subscriptions as $email_subscription)
            {
                    $sevenDaysAgo = Carbon::now()->subDays(7);
                    $sevenDaysAgoDate = $sevenDaysAgo->toDateString();
                   
                    $vendor = Vendor::find( $vendor_id);

                    $cars = Car::where('vendor_id',  $vendor_id)
                    ->whereDate('created_at', '>=', $sevenDaysAgo)
                    ->orderBy('id', 'desc')
                    ->get();

                    $messageContent = [
                    'cars' => $cars,
                    'photo' => asset('assets/admin/img/vendor-photo/'.$vendor->photo),
                    'username' => $vendor->username,
                    'phone' => $vendor->phone,
                    ];

                    $data["email"] = $email_subscription->mails;
                    $data["title"] = "Weekly Report";
                    $data["body"] = "Weekly Report";
                    $data["messageContent"] = $messageContent;
                    $data['sevenDaysAgoDate'] = $sevenDaysAgoDate;
                    $data['todayDate'] = date('Y-m-d');

                    $car_ids = Car::where('vendor_id',  $vendor_id)->whereDate('created_at', '>=', $sevenDaysAgo)->pluck('id');

                    $data['impressions'] = DB::table('ad_impressions')->whereIn('ad_id' , $car_ids)->sum('impressions');
                    $data['visitors'] = DB::table('visitors')->whereIn('car_id' , $car_ids)->count();
                    $data['saves'] = Wishlist::where('user_id',  $vendor_id)->count(); 
                    $data['leads'] = SupportTicket::where('admin_id',  $vendor_id)->where('user_type', 'vendor')->count();
                    $data['phone_no_revel'] = DB::table('cars')->whereIn('id' , $car_ids)->sum('phone_no_revel');

                    $data['brands'] = Brand::where('status' , 1)->get(['id' , 'name']);
                    $data['models'] = CarModel::where('status' , 1)->get(['id' , 'name']);
                    $data['registration_no'] = Car::whereNotNull('vregNo')->get(['vregNo']);

                    $pdf = PDF::loadView('emails.email-subscription-report', $data);

                    Mail::send('emails.email-subscription-report', $data, function($message)use($data, $pdf) {
                    $message->to($data["email"], $data["email"])
                    ->subject($data["title"])
                    ->attachData($pdf->output(), "weekly-report.pdf");
                    });
            }
        }


        dd('Mail sent successfully');

       }

    }
}
