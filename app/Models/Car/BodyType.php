<?php

namespace App\Models\Car;
use App\Models\Car\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodyType extends Model
{
    use HasFactory;
   

    protected $fillable = [
        'language_id',
        'name',
        'slug',
        'status',
        'cat_id',
        'serial_number',
        'image'
    ];
    
    
    public function category()
  {
    return $this->belongsTo(Category::class , 'cat_id');
  }
  
  
}
