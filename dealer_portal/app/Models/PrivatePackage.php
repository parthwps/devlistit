<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivatePackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'category_id',
        'days_listing',
        'photo_allowed',
        'ad_views',
        'number_of_bumps',
        'priority_placement',
        'promo_price',
        'status',
        
    ];

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }
}
