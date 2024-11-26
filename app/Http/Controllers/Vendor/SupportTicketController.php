<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\SupportTicket;
use App\Models\Vendor;
use App\Models\Car;
use App\Models\SupportTicketStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mews\Purifier\Facades\Purifier;
use DB;

class SupportTicketController extends Controller
{
  
    public function index(Request $request)
    {
        
        $s_status = SupportTicketStatus::first();
        
        if ($s_status->support_ticket_status != 'active') 
        {
            return redirect()->route('vendor.dashboard');
        }

        $status = null;
        
        if ($request->filled('status')) 
        {
            $status = $request['status'];
        }
        
        $vendorId = Auth::guard('vendor')->user()->id;
        
        
        $collection = SupportTicket::with('messages')
        ->leftJoin('conversations', 'support_tickets.id', '=', 'conversations.support_ticket_id')
        ->leftJoin('cars', function($join) {
            $join->on('support_tickets.ad_id', '=', 'cars.id')
                 ->whereNull('cars.deleted_at'); // Add condition to check if car is not soft-deleted
            })
            ->where(function ($query) use ($vendorId) {
            $query->where([['support_tickets.user_id', $vendorId], ['support_tickets.user_type', 'vendor']])
                  ->orWhere('support_tickets.admin_id', $vendorId);
            })
            ->whereRaw('support_tickets.user_id != support_tickets.admin_id')
            ->when($status, function ($query, $status) {
            return $query->where('support_tickets.status', $status);
            })
            ->whereNotNull('cars.id') // Ensure that the ticket is related to a car
            ->orderByRaw(
            '(SELECT MAX(conversations.created_at) FROM conversations 
            WHERE conversations.support_ticket_id = support_tickets.id 
            AND (conversations.message_to = ? OR conversations.user_id = ?)
            ) DESC, support_tickets.id DESC',
            [$vendorId, $vendorId]
            )
        ->orderByDesc('support_tickets.id')
        ->distinct('support_tickets.ad_id') // Group by support_tickets.id
        ->select('support_tickets.*') // Ensure this matches the GROUP BY
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
        $allowedExts = array('zip','jpg', 'png', 'jpeg');
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

        if ($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator->errors());
        }
        
        $in = $request->all();
        
        if ($request->hasFile('attachment')) 
        {
            $attachment = $request->file('attachment');
            $filename = uniqid() . '.' . $attachment->getClientOriginalExtension();
            $attachment->move(public_path('assets/admin/img/support-ticket/attachment/'), $filename);
            $in['attachment'] = $filename;
        }
        
        $message = 'Name : '.$request->full_name. '<br>Phone : '.$request->phone_no ;
        
        if(!empty($request->field_name) && count($request->field_name) > 0 )
        {
             $message .= '<br><br>Iam interested in ... <br><br>';
             
            foreach($request->field_name as $list)
            {
               if($list == 'trading')
               {
                   $message .= 'Trading in my current vehicle <br>';
               }
               else if($list == 'conditions')
               {
                   $message .= 'More about condition <br>';
               }
                else if($list == 'scheduling')
               {
                   $message .= 'Scheduling test drive <br>';
               }
                else if($list == 'financing')
               {
                   $message .= 'Financing this vehicle <br>';
               }
            }
        }
        
        $message .=  '<br>'.Purifier::clean($request->description, 'youtube');
         
        $in['user_id'] = Auth::guard('vendor')->user()->id;
        $in['user_type'] = 'vendor';
        $in['ad_id'] = $request->car_id;
        $in['description'] = (!empty($request->full_name)) ? $message : Purifier::clean($request->description, 'youtube');
       
        $lattId= SupportTicket::create($in);

        $in['message_to'] = $request->admin_id; 
        $in['support_ticket_id'] = $lattId->id; 
        $in['reply'] =  (!empty($request->full_name)) ? $message : Purifier::clean($request->description, 'youtube');

        $data = new Conversation();
        $data->create($in);
        
        $vendor = Vendor::find($request->admin_id);
      
        if($vendor == true)
        {
              $vendor_email =  $vendor->email;
            $carContent = Car::find( $request->car_id);
            $description =  $in['description'];
            $vendor = Auth::guard('vendor')->user();
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
            
            $chat_url = url('customer/support/message/'. $lattId->id );
            
            $HTML =  view('email.new-message', compact('carContent' , 'description' , 'vendor' , 'imageUrl' , 'rotation' , 'chat_url'))->render();
            // return $HTML;
            $data = ['recipient' => $vendor_email  , 'subject' => 'New Message'  , 'body' => $HTML ];
            
            \App\Http\Helpers\BasicMailer::sendMail($data);  
            
            
             if(!empty($carContent->enquiry_person_id))
            {
                $jsonArry = json_decode($carContent->enquiry_person_id , true);
                
                foreach($jsonArry as $data)
                {
                    $enquiry_email = DB::table('enquiry_preferences')->where('id' , $data)->first();
                    
                    if($enquiry_email == true)
                    {
                        $name = $enquiry_email->name;
                        
                        $HTML =  view('email.new-message', compact('carContent' , 'description' , 'vendor' , 'imageUrl' , 'rotation' , 'chat_url' , 'name'))->render();
                        
                        $email = $enquiry_email->email;
                        
                        $data = ['recipient' => $email  , 'subject' => 'New Message'  , 'body' => $HTML ];
                        
                        \App\Http\Helpers\BasicMailer::sendMail($data);  
                    }
                }
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
        
         $update = Conversation::where('message_to', Auth::guard('vendor')->user()->id)->where('support_ticket_id',$id)->update(['message_seen' => 1]);
        if ($ticket->user_type == 'vendor' && $ticket->user_id != Auth::guard('vendor')->user()->id) {
           // return redirect()->route('vendor.dashboard');
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
        $allowedExts = array('zip','jpg', 'png', 'jpeg');
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
        $input['message_seen'] = 0;
        $in['message_to'] = $request->message_to;

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
            $vendor_email =  $vendor->email;
            $carContent = Car::find( $request->car_id);
            $description =  $input['reply'];
            $vendor = Auth::guard('vendor')->user();
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
            
            $chat_url = url('customer/support/message/'. $id );
            
            $HTML =  view('email.new-message', compact('carContent' , 'description' , 'vendor' , 'imageUrl' , 'rotation' , 'chat_url'))->render();
            // return $HTML;
            $data = ['recipient' =>  $vendor_email  , 'subject' => 'New Message'  , 'body' => $HTML ];
            
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
        return redirect()->route('vendor.support_tickets');
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
        Session::flash('success', 'Conversation deleted successfully..!');
        //return back();
        return redirect()->route('vendor.support_tickets');
        
    }
    
    
    //delete multi
    public function deleteMulti(Request $request)
    {
        if(empty($request->removemesages))
        {
           Session::flash('error', 'Please select some options');
              
            return redirect()->route('vendor.support_tickets');  
        }
        
        foreach($request->removemesages as $id)
        {
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
        }
        
         Session::flash('success', 'Conversations deleted successfully..!');
        //return back();
        return redirect()->route('vendor.support_tickets');
        
        
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
    public function  report(Request $request)
    {
        //delete all support ticket
        
       
        Session::flash('success', 'Report submitted successfully..!');
        //return back();
        return redirect()->route('vendor.support_tickets');
        
    }
}
