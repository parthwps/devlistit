<?php

namespace App\Models\Car;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSearch extends Model
{
    use HasFactory;
   

    protected $fillable = [
        
        'customer_id',
        'title',
        'customer_filters',
       
    ];
}
