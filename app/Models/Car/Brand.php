<?php

namespace App\Models\Car;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'language_id',
        'name',
        'slug',
        'status',
        'cat_id',
        'serial_number',
    ];

    public function models()
    {
        return $this->hasMany(CarModel::class);
    }

    public function cars()
    {
        return $this->hasMany(CarContent::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class , 'cat_id');
    }
    

    public function availabel_cars($language_id)
    {
        return $this->cars()->where('language_id', $language_id)->get();
    }
}
