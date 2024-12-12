<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'vendor_id',
        'status',
        'paid_at'
    ];
    
    public function history()
    {
        return $this->hasMany(Deposit::class , 'invoice_id' , 'id');
    }
    
    public function vendor()
    {
        return $this->belongsTo(Vendor::class , 'vendor_id' , 'id');
    }
    
    
}
