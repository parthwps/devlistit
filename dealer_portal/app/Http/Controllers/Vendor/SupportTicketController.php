<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\SupportTicket;
use App\Models\SupportTicketStatus;
use Carbon\Carbon;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mews\Purifier\Facades\Purifier;
use App\Models\EnquiryPreference;
use App\Models\BasicSettings\Basic;
use App\Models\Car;
use Illuminate\Support\Facades\Mail;

class SupportTicketController extends Controller
{
    //index
    public function index(Request $request)
    {
        
        $s_status = SupportTicketStatus::first();
        if ($s_status->support_ticket_status != 'active') {
            return redirect()->route('vendor.dashboard');
        }

        $status = null;
        if ($request->filled('status')) {
            $status = $request['status'];
        }

        $collection = SupportTicket::where(function($query) {
            $query->where('user_id', Auth::guard('vendor')->user()->id)
                ->where('user_type', 'vendor')
                ->orWhere('admin_id', Auth::guard('vendor')->user()->id); // Assuming admin_id is a field in your SupportTicket model
        })
        ->when($status, function ($query, $status) {
            return $query->where('status', $status);
        })
        ->orderByDesc('id')
        ->paginate(10);

        return view('vendors.support_ticket.index', compact('collection'));
    }


    //create
    public function create()
    {
        $s_status = SupportTicketStatus::first();
        if ($s_status->support_ticket_status != 'active') {
            return redirect()->route('vendor.dashboard');
        }
        return view('vendors.support_ticket.create');
    }


    //store
    public function store(Request $request)
    {
        $rules = [
            //'email' => 'required',
            //'subject' => 'required',
        ];

        $file = $request->file('attachment');
        $allowedExts = array('zip');
        $rules['attachment'] = [
            function ($attribute, $value, $fail) use ($file, $allowedExts) {
                $ext = $file->getClientOriginalExtension();
                if (!in_array($ext, $allowedExts)) {
                    return $fail("Only zip file supported");
                }
            },
            'max:20000'
        ];

        $messages = [
            'attachment.max' => 'Attachment may not be greater than 20 MB',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $in = $request->all();
        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $filename = uniqid() . '.' . $attachment->getClientOriginalExtension();
            $attachment->move(public_path('assets/admin/img/support-ticket/attachment/'), $filename);
            $in['attachment'] = $filename;
        }
        
        $ad = Car::find($request->car_id);
        
        $in['user_id'] = Auth::guard('vendor')->user()->id;
        $in['user_type'] = 'vendor';
        $in['car_id'] = $request->car_id;
        $in['admin_id'] = $ad->vendor_id;
        $in['description'] = Purifier::clean($request->description, 'youtube');
        
        SupportTicket::create($in);
        

        if(!empty( $ad->enquiry_person_id))
        {
            $enqueiry_mail = EnquiryPreference::find($ad->enquiry_person_id);

            if($enqueiry_mail == true)
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


                $data = [
                    'email' => $enqueiry_mail->email,
                    'title' => 'New Enquiry From Customer',
                    'body' =>  '<b>Name :</b> ' . Auth::guard('vendor')->user()->username . '<br>' .
                                '<b>Email :</b> ' . Auth::guard('vendor')->user()->email . '<br>' .
                                '<b>Phone :</b> ' . Auth::guard('vendor')->user()->phone . '<br>' .
                                '<b>Enquiry :</b> ' . $in['description'],
                ];
                
                Mail::send([], [], function ($message) use ($data) {
                    $message->to($data['email'])
                        ->subject($data['title'])
                        ->html($data['body']);
                });
                
            }
        }

        Session::flash('success', 'Message successfully sent..!');
        return back();
    }
    //message
    public function message($id)
    {
        $s_status = SupportTicketStatus::first();
        if ($s_status->support_ticket_status != 'active') {
            return redirect()->route('vendor.dashboard');
        }
        $ticket = SupportTicket::findOrFail($id);

        if ($ticket->user_type == 'vendor' && ($ticket->admin_id != Auth::guard('vendor')->user()->id && $ticket->user_id != Auth::guard('vendor')->user()->id))
        {
            return redirect()->route('vendor.dashboard');
        }

        return view('vendors.support_ticket.messages', compact('ticket'));
    }
    public function zip_file_upload(Request $request)
    {
        $file = $request->file('file');
        $allowedExts = array('zip');
        $rules = [
            'file' => [
                function ($attribute, $value, $fail) use ($file, $allowedExts) {
                    $ext = $file->getClientOriginalExtension();
                    if (!in_array($ext, $allowedExts)) {
                        return $fail("Only zip file supported");
                    }
                },
                'max:5000'
            ],
        ];

        $messages = [
            'file.max' => ' zip file may not be greater than 5 MB',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/front/temp/'), $filename);
            $input['file'] = $filename;
        }

        return response()->json(['data' => 1]);
    }
    public function ticketreply(Request $request, $id)
    {
        $s_status = SupportTicketStatus::first();
        if ($s_status->support_ticket_status != 'active') {
            return redirect()->route('vendor.dashboard');
        }
        $file = $request->file('file');
        $allowedExts = array('zip');
        $rules = [
            'reply' => 'required',
            'file' => [
                function ($attribute, $value, $fail) use ($file, $allowedExts) {

                    $ext = $file->getClientOriginalExtension();
                    if (!in_array($ext, $allowedExts)) {
                        return $fail("Only zip file supported");
                    }
                },
                'max:20000'
            ],
        ];

        $messages = [
            'file.max' => ' Zip file may not be greater than 20 MB',
        ];

        $request->validate($rules, $messages);
        $input = $request->all();

        $reply = str_replace(url('/') . '/assets/front/img/', "{base_url}/assets/front/img/", $request->reply);
        $input['reply'] = Purifier::clean($reply, 'youtube');
        $input['user_id'] = Auth::guard('vendor')->user()->id;
        $input['type'] = 3;

        $input['support_ticket_id'] = $id;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/admin/img/support-ticket/'), $filename);
            $input['file'] = $filename;
        }

        $data = new Conversation();
        $data->create($input);
        
        $vendor = Vendor::find($request->message_to);
        
        if($vendor == true)
        {
            $newMmesasgeCount = contactNotification($vendor->id);
            
            $message = 'Hi ' . $vendor->vendor_info->name . "\n\nYou have $newMmesasgeCount new messages. Please login and respond back.\n\n\nThanks & Regards";
            $message = nl2br($message);
            
            
            $data = ['recipient' => $vendor->email , 'subject' => 'New Message'  , 'body' => $message ];
            
          \App\Http\Helpers\BasicMailer::sendMail($data);  
        }
        
        
        $files = glob('assets/front/temp/*');
        foreach ($files as $file) {
            unlink($file);
        }

        SupportTicket::where('id', $id)->update([
            'last_message' => Carbon::now(),
        ]);

        Session::flash('success', 'Message sent successfully');
        return back();
    }

    //delete
    public function delete($id)
    {
        //delete all support ticket
        $support_ticket = SupportTicket::find($id);
        if ($support_ticket) {
            //delete conversation 
            $messages = $support_ticket->messages()->get();
            foreach ($messages as $message) {
                @unlink(public_path('assets/admin/img/support-ticket/' . $message->file));
                $message->delete();
            }
            @unlink(public_path('assets/admin/img/support-ticket/attachment/') . $support_ticket->attachment);
            $support_ticket->delete();
        }
        Session::flash('success', 'Message deleted successfully..!');
        return back();
    }
    
     public function  block(Request $request)
    {
        //delete all support ticket
        
        $support_ticket = SupportTicket::where('id', $request->id)->first();
        if ($support_ticket) {
            //delete conversation 
            $in['status'] = 3;
            $support_ticket->update($in);
                        
        }
        Session::flash('success', 'Conversation blocked successfully..!');
        return back();
        //return redirect()->route('vendor.support_tickets');
        
    }
    public function  unblock(Request $request)
    {
        //delete all support ticket
        
        $support_ticket = SupportTicket::where('id', $request->id)->first();
        if ($support_ticket) {
            //delete conversation 
            $in['status'] = 2;
            $support_ticket->update($in);
                        
        }
        Session::flash('success', 'Conversation Unblocked successfully..!');
        return back();
        //return redirect()->route('vendor.support_tickets');
        
    }
    
    
    
}
