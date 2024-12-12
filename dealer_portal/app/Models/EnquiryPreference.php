<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquiryPreference extends Model
{
  use HasFactory;
  
  protected $fillable = [
    'name',
    'email',
    'phone_no',
    'vendor_id'
  ];
}
