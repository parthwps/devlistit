<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'term',
        'is_trial',
        'trial_days',
        'status',
        'number_of_car_featured',
        'number_of_car_add',
        'number_of_bumps',
        'number_of_historycheck',
    ];

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }
}
