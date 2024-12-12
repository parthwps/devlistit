<?php

namespace App\Models\Car;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarPower extends Model
{
    use HasFactory;
   

    protected $fillable = [
        
        'name',
        'slug',
        'status',
       
    ];
}
