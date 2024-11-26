<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\BasicSettings\Basic;
use App\Http\Controllers\FrontEnd\MiscellaneousController;
use App\Models\BasicSettings\MailTemplate;
use App\Models\Car;
use App\Models\Car\Brand;
use App\Models\Car\CarCondition;
use App\Models\Car\CarContent;
use App\Models\Car\CarImage;
use App\Models\Car\CarModel;
use App\Models\Car\CarSpecification; 
use App\Models\Car\CarSpecificationContent;
use App\Models\Car\Category;
use App\Models\Car\FuelType;
use App\Models\Car\BodyType;
use App\Models\Car\TransmissionType;
use App\Models\Vendor;
use App\Models\Visitor;
use App\Models\CountryArea;
use App\Models\CarYear;
use App\Models\AdsPrice;
use Carbon\Carbon;
use App\Models\Car\EngineSize;
use App\Models\Car\CarPower;
use Config;
use App\Models\PrivatePackage;
use DB;
use App\Models\AdsMileage;
use App\Models\Car\CarColor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Car\Wishlist;
use App\Models\Car\FormFields;
use App\Models\Car\CustomerSearch;
use App\Http\Requests\Car\CarStoreRequest;
use Purifier;
use App\Models\Conversation;
use App\Models\SupportTicket;
use App\Models\SupportTicketStatus;
use Illuminate\Support\Facades\Response;

class ChatController extends Controller
{   
        public function __construct()
        {
                 
        }
        
        public function getChatByAd($id)
        {
            $s_status = SupportTicketStatus::first();
            
            if ($s_status->support_ticket_status != 'active') 
            {
                return response()->json(['error' => 'something went wrong.'], 500);
            }
            
            $ticket = SupportTicket::where('ad_id' , $id)->where('user_id' , request()->user()->id)->first();
            
            if($ticket == false)
            {
                 return response()->json(['error' => 'conversation not found.'], 404);   
            }
            
            Conversation::where('message_to', request()->user()->id)->where('support_ticket_id',$ticket->id)->update(['message_seen' => 1]);
           
           
           $featureImageUrl = $ticket->ad->vendor
            ? ($ticket->ad->vendor->vendor_type === 'normal'
            ? asset('assets/admin/img/car-gallery/' . $ticket->ad->feature_image)
            : env('SUBDOMAIN_APP_URL') . 'assets/admin/img/car-gallery/' . $ticket->ad->feature_image)
            : asset('assets/admin/img/default-photo.jpg');
            
            $chat_username = addUserName($ticket->user_id, $ticket->admin_id);
            
            $status = 'open';
            
            if ($ticket->ad->is_sold == 1 || $ticket->ad->status == 2) 
            {
                $status = 'sold'; 
            }
            
            if($ticket->status == 3)
            {
                 $status = 'block'; 
            }
            
            $vendorPhotoUrl = asset('assets/img/blank-user.jpg'); // Default to blank user image
            
            if (!empty($ticket->ad->vendor->photo)) 
            {
                $vendorPhotoUrl = $ticket->ad->vendor->vendor_type === 'dealer'
                ? env('SUBDOMAIN_APP_URL') . 'assets/admin/img/vendor-photo/' . $ticket->ad->vendor->photo
                : asset('assets/admin/img/vendor-photo/' . $ticket->ad->vendor->photo);
            }
            
            $effectivePrice = $ticket->ad->price;
                    
            if ($ticket->ad->previous_price && $ticket->ad->previous_price < $ticket->ad->price) 
            {
                $effectivePrice = $ticket->ad->previous_price;
            }
            
            $user_id = request()->user()->id;
            
            $messages = $ticket->messages->map(function ($message) use ($user_id , &$ticket) 
            {
                if($message->user_id == $user_id)
                {
                    $send_by = 'you';
                }
                else
                {
                   $send_by = Vendor::find($user_id)->vendor_info->name; 
                }
                
                $fileUrl = null;
                
                if ($message->file != null)
                {
                    $fileUrl = $ticket->ad->vendor->vendor_type === 'dealer'
                    ? env('SUBDOMAIN_APP_URL') . 'assets/admin/img/support-ticket/' . $message->file
                    : asset('assets/admin/img/support-ticket/' . $message->file);
                }
                
                return [
                    'id' => $message->id,
                    'reply' => $message->reply,
                    'image' => $fileUrl,
                    'send_by' => $send_by,
                    'created_at' => $message->created_at->format('d-M-y') . ' ' .date('h.i A', strtotime($message->created_at))
                ];
            });
            
            
            return [
            'id' => $ticket->id,
            'vendor_photo' => $vendorPhotoUrl,
            'chat_username' => $chat_username[0],
            'is_online' => isOnline($chat_username[1])[0],
            'last_seen' => isOnline($chat_username[1])[1],
            'feature_image' => $featureImageUrl,
            'price' => $effectivePrice,
            'title' => $ticket->ad->car_content->title,
            'created_at' => $ticket->ad->created_at,
            'status' => $status,
            'messages' => $messages
            
            ];
            
            
        }
        
        
         public function  block(Request $request)
    {
        
           $rules = [
            'id' => 'required',
        ];
        
        $messages = [
            'id.required' => 'The support id field is required.'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) 
        {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }
        
        $support_ticket = SupportTicket::where('id', $request->id)->first();
        
        if($support_ticket == false)
        {
           return response()->json(['error' => 'conversation not found.'], 404);    
        }
        
        if ($support_ticket) 
        {
            $in['status'] = ($request->status == 'block') ? 3: '1';
            $support_ticket->update($in);
        }
        
        return response()->json(['success' => 'Conversation status successfully updated..!' ] , 200 );
        
    }
    
    
    
        
        
        public function delete($id)
    {
        
        $support_ticket = SupportTicket::find($id);
        
        if($support_ticket == false)
        {
           return response()->json(['error' => 'conversation not found.'], 404);    
        }
        
        if ($support_ticket) 
        {
            //delete conversation 
            $messages = $support_ticket->messages()->get();
            foreach ($messages as $message) 
            {
                @unlink(public_path('assets/admin/img/support-ticket/' . $message->file));
                $message->delete();
            }
            @unlink(public_path('assets/admin/img/support-ticket/attachment/') . $support_ticket->attachment);
            $support_ticket->delete();
        }
        
        return response()->json(['success' => 'Conversation deleted successfully..!' ] , 200 );
    }
    
    
        
        public function ticketreply(Request $request)
        {
            $rules = [
            'support_id' => 'required',
             'reply' => 'required',
        ];
        
        $messages = [
            'support_id.required' => 'The support id field is required.'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) 
        {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }
        
        $s_status = SupportTicketStatus::first();
        
        if ($s_status->support_ticket_status != 'active') 
        {
             return response()->json(['error' => 'something went wrong.'], 500);
        }
        
        $input = $request->all();
        
        $id = $request->support_id;
        
        $ticket = SupportTicket::findOrFail($request->support_id);
        
        if($ticket == false)
        {
           return response()->json(['error' => 'conversation not found.'], 404);  
        }
        
        if($ticket->user_id == request()->user()->id)
        {
           $message_to =  $ticket->admin_id;
        }
        else
        {
           $message_to =  $ticket->user_id;  
        }
                         
        $reply = str_replace(url('/') . '/assets/front/img/', "{base_url}/assets/front/img/", $request->reply);
        $input['reply'] = Purifier::clean($reply, 'youtube');
        $input['user_id'] = request()->user()->id;
        $input['type'] = 3;
        $input['message_seen'] = 0;
        $in['message_to'] = $message_to;

        $input['support_ticket_id'] = $request->support_id;
        
        if ($request->hasFile('file')) 
        {
            $file = $request->file('file');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/admin/img/support-ticket/'), $filename);
            $input['file'] = $filename;
        }

        $data = new Conversation();
        
        $data->create($input);
        
        $vendor = Vendor::find($message_to);
        
        if($vendor == true)
        {
            $vendor_email =  $vendor->email;
            
            $carContent = Car::find($ticket->ad->id);
            
            $description =  $input['reply'];
            
            $vendor = request()->user();
            
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
           
            $data = ['recipient' =>  $vendor_email  , 'subject' => 'New Message'  , 'body' => $HTML ];
            
            \App\Http\Helpers\BasicMailer::sendMail($data);
        }
        
        $files = glob('assets/front/temp/*');
        
        foreach ($files as $file) 
        {
            unlink($file);
        }

        SupportTicket::where('id', $id)->update([
            'last_message' => Carbon::now(),
        ]);

        return response()->json(['success' => 'Message sent successfully' ] , 200 );
    }
    
        
        function show($id)
        {
            $s_status = SupportTicketStatus::first();
            
            if ($s_status->support_ticket_status != 'active') 
            {
                return response()->json(['error' => 'something went wrong.'], 500);
            }
            
            $ticket = SupportTicket::findOrFail($id);
            
            Conversation::where('message_to', request()->user()->id)->where('support_ticket_id',$id)->update(['message_seen' => 1]);
           
           
           $featureImageUrl = $ticket->ad->vendor
            ? ($ticket->ad->vendor->vendor_type === 'normal'
            ? asset('assets/admin/img/car-gallery/' . $ticket->ad->feature_image)
            : env('SUBDOMAIN_APP_URL') . 'assets/admin/img/car-gallery/' . $ticket->ad->feature_image)
            : asset('assets/admin/img/default-photo.jpg');
            
            $chat_username = addUserName($ticket->user_id, $ticket->admin_id);
            
            $status = 'open';
            
            if ($ticket->ad->is_sold == 1 || $ticket->ad->status == 2) 
            {
                $status = 'sold'; 
            }
            
            if($ticket->status == 3)
            {
                 $status = 'block'; 
            }
            
            $vendorPhotoUrl = asset('assets/img/blank-user.jpg'); // Default to blank user image
            
            if (!empty($ticket->ad->vendor->photo)) 
            {
                $vendorPhotoUrl = $ticket->ad->vendor->vendor_type === 'dealer'
                ? env('SUBDOMAIN_APP_URL') . 'assets/admin/img/vendor-photo/' . $ticket->ad->vendor->photo
                : asset('assets/admin/img/vendor-photo/' . $ticket->ad->vendor->photo);
            }
            
            $effectivePrice = $ticket->ad->price;
                    
            if ($ticket->ad->previous_price && $ticket->ad->previous_price < $ticket->ad->price) 
            {
                $effectivePrice = $ticket->ad->previous_price;
            }
            
            $user_id = request()->user()->id;
            
            $messages = $ticket->messages->map(function ($message) use ($user_id , &$ticket) 
            {
                if($message->user_id == $user_id)
                {
                    $send_by = 'you';
                }
                else
                {
                   $send_by = Vendor::find($user_id)->vendor_info->name; 
                }
                
                $fileUrl = null;
                
                if ($message->file != null)
                {
                    $fileUrl = $ticket->ad->vendor->vendor_type === 'dealer'
                    ? env('SUBDOMAIN_APP_URL') . 'assets/admin/img/support-ticket/' . $message->file
                    : asset('assets/admin/img/support-ticket/' . $message->file);
                }
                
                return [
                    'id' => $message->id,
                    'reply' => $message->reply,
                    'image' => $fileUrl,
                    'send_by' => $send_by,
                    'created_at' => $message->created_at->format('d-M-y') . ' ' .date('h.i A', strtotime($message->created_at))
                ];
            });
            
            
            return [
            'id' => $ticket->id,
            'vendor_photo' => $vendorPhotoUrl,
            'chat_username' => $chat_username[0],
            'is_online' => isOnline($chat_username[1])[0],
            'last_seen' => isOnline($chat_username[1])[1],
            'feature_image' => $featureImageUrl,
            'price' => $effectivePrice,
            'title' => $ticket->ad->car_content->title,
            'created_at' => $ticket->ad->created_at,
            'status' => $status,
            'messages' => $messages
            
            ];
            
            
        }
        
        function index(Request $request)
        {
            $s_status = SupportTicketStatus::first();
            
            if ($s_status->support_ticket_status != 'active') 
            {
                return response()->json(['error' => 'something went wrong.'], 500);
            }
            
            $vendorId = request()->user()->id;
            $searchQuery = request()->input('search_query'); // Capture search input
            
            $collection = SupportTicket::with('messages')
            ->leftJoin('conversations', 'support_tickets.id', '=', 'conversations.support_ticket_id')
            ->leftJoin('cars', function($join) 
            {
            $join->on('support_tickets.ad_id', '=', 'cars.id')
             ->whereNull('cars.deleted_at'); // Add condition to check if car is not soft-deleted
            })
            ->where(function ($query) use ($vendorId) {
            $query->where([['support_tickets.user_id', $vendorId], ['support_tickets.user_type', 'vendor']])
              ->orWhere('support_tickets.admin_id', $vendorId);
            })
            ->whereNotNull('cars.id') // Ensure that the ticket is related to a car
            ->orderByRaw(
            '(SELECT MAX(conversations.created_at) FROM conversations 
            WHERE conversations.support_ticket_id = support_tickets.id 
            AND (conversations.message_to = ? OR conversations.user_id = ?)
            ) DESC, support_tickets.id DESC',
            [$vendorId, $vendorId]
            )
            ->distinct('support_tickets.ad_id') // Group by support_tickets.id
            ->select('support_tickets.*') // Ensure this matches the GROUP BY
            ->paginate(10);
            
            // Transform the collection and apply search on chat_username after transformation
            $collection->getCollection()->transform(function ($conversation) use ($vendorId) 
            {
            $featureImageUrl = $conversation->ad->vendor
            ? ($conversation->ad->vendor->vendor_type === 'normal'
            ? asset('assets/admin/img/car-gallery/' . $conversation->ad->feature_image)
            : env('SUBDOMAIN_APP_URL') . 'assets/admin/img/car-gallery/' . $conversation->ad->feature_image)
            : asset('assets/admin/img/default-photo.jpg');
            
            $chat_username = addUserName($conversation->user_id, $conversation->admin_id);
            
            $status = 'open';
            
            if ($conversation->ad->is_sold == 1 || $conversation->ad->status == 2) 
            {
                $status = 'sold'; 
            }
            
            if($conversation->status == 3)
            {
                 $status = 'block'; 
            }
            
            
            $vendorPhotoUrl = asset('assets/img/blank-user.jpg'); // Default to blank user image
            
            if (!empty($conversation->ad->vendor->photo)) 
            {
                $vendorPhotoUrl = $conversation->ad->vendor->vendor_type === 'dealer'
                ? env('SUBDOMAIN_APP_URL') . 'assets/admin/img/vendor-photo/' . $conversation->ad->vendor->photo
                : asset('assets/admin/img/vendor-photo/' . $conversation->ad->vendor->photo);
            }
            
            return [
            'id' => $conversation->id,
            'feature_image' => $featureImageUrl,
            'username' => $chat_username[0],
            'vendorPhotoUrl' => $vendorPhotoUrl,
            'datetime' => date('d F h:i a', strtotime($conversation->messages()->latest()->first()->created_at)),
            'subject' => $conversation->subject,
            'latest_reply' => $conversation->messages()->latest()->first()->reply ?? 'No messages found',
            'status' => $status,
            'is_new' => ($conversation->messages->where('message_seen', 0)->where('message_to', $vendorId)->count() > 0) ? 'new' : 'old',
            'is_online' => isOnline($chat_username[1])[0],
            'chat_username' => $chat_username[0], // Include chat_username in the returned data
            ];
            });
            
            // After transforming, filter based on chat_username
            if (!empty($searchQuery)) {
            $filtered = $collection->filter(function ($item) use ($searchQuery) {
            return stripos($item['chat_username'], $searchQuery) !== false || stripos($item['subject'], $searchQuery) !== false;
            });
            } else {
            $filtered = $collection;
            }
            
            // Paginate the filtered results
            $paginatedFiltered = new \Illuminate\Pagination\LengthAwarePaginator(
            $filtered->forPage($collection->currentPage(), $collection->perPage()),
            $filtered->count(),
            $collection->perPage(),
            $collection->currentPage()
            );
            
            return response()->json($paginatedFiltered);

        }
        
}
