<?php

namespace App\Models;

use App\Models\Car\Brand;
use App\Models\Car\CarContent;
use App\Models\Car\CarImage;
use App\Models\Car\Wishlist;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'feature_image',
        'order_id',
        'vendor_id',
        'package_id',
        'delivery_available',
        'price',
        'sign',
        'previous_price',
        'city',
        'speed',
        'year',
        'youtube_video',
        'mileage',
        'ad_type',
        'vregNo',
        'engineCapacity',
        'doors',
        'seats',
        'power',
        'battery',
        'owners',
        'road_tax',
        'verification',
        'warranty',
        'valid_test',
        'is_featured',
        'status',
        'specification',
        'latitude',
        'longitude',
        'deleted_at',
        'phone_text',
        'message_center',
        'filters',
        'fil_sub_categories',
        'remove_option',
        'recommendation',
        'remove_remarks',
    ];

    //car_content
    public function car_content()
    {
        return $this->hasOne(CarContent::class);
    }

    public function galleries()
    {
        return $this->hasMany(CarImage::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function package()
    {
        return $this->belongsTo(PrivatePackage::class , 'package_id');
    }

    public function support_tickets()
    {
        return $this->hasMany(SupportTicket::class , 'ad_id');
    }


    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }


}