<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'amount',
        'vendor_id',
        'deposit_type',
        'short_des',
        'invoice_id'
    ];
    
     public function vendor()
    {
        return $this->belongsTo(Vendor::class , 'vendor_id');
    }
    
     public function invoice()
    {
        return $this->belongsTo(Invoice::class , 'invoice_id' , 'id');
    }
}
