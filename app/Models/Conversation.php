<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
  use HasFactory;
  protected $fillable = [
    'user_id',
    'type',
    'support_ticket_id',
    'message_to',
    'message_seen',
    'reply',
    'file',
  ];
  
    public function support_ticket()
    {
        return $this->belongsTo(SupportTicket::class , 'support_ticket_id' , 'id');
    }
    
    
}
