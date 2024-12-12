<?php

namespace App\Models\Car;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngineSize extends Model
{
    use HasFactory;
   

    protected $fillable = [
        
        'name',
        'slug',
        'status',
       
    ];
}
