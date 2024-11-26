<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
  use HasFactory;
  protected $fillable = [
    'user_id',
    'ad_id',
    'user_type',
    'email',
    'subject',
    'description',
    'attachment',
    'status',
    'last_message',
    'admin_id',
    'blocked_by',
  ];
  public function vendor()
  {
    return $this->belongsTo(Vendor::class, 'user_id', 'id');
  }
  
  public function ad()
  {
    return $this->belongsTo(Car::class, 'ad_id', 'id');
  }
  
  
  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }
  public function messages()
  {
    return $this->hasMany(Conversation::class);
  }

  public function admin()
  {
    return $this->belongsTo(Admin::class,  'admin_id', 'id');
  }
}
