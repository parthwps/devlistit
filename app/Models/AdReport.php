<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdReport extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'ad_id',
        'user_id',
        'reason',
        'explaination',
    ];
    
    public function car()
    {
        return $this->belongsTo(Car::class , 'ad_id' , 'id');
    }
    
    public function vendor()
    {
        return $this->belongsTo(Vendor::class , 'user_id' , 'id');
    }
}
