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
    use HasFactory , SoftDeletes ;

    protected $fillable = [
        'feature_image',
        'vendor_id',
        'price',
        'previous_price',
        'speed',
        'year',
        'youtube_video',
        'mileage',
        'ad_type',
        'vregNo',
        'engineCapacity',
        'doors',
        'seats',
        'is_featured',
        'featured_date',
        'specification',
        'latitude',
        'longitude',
        'status',
        'bettery_range',
        'current_area_regis',
        'history_checked',
        'delivery_available',
        'warranty_type',
        'warranty_duration',
        'what_type',
        'number_of_owners',
        'bump',
        'bump_date',
        'created_at',
        'phone_text',
        'message_center',
        'is_sale',
        'is_sold',
        'reduce_price',
        'manager_special',
        'deposit_taken',
        'enquiry_person_id',
        'frame_photo',
        'rotation_point',
        'package_id',
        'city',
        'battery',
        'owners',
        'road_tax',
        'verification',
        'warranty',
        'valid_test',
        'power',
        'order_id',
        'financing_dealer',
        'financing_url',
        'vat_status'
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
        return $this->belongsTo(Vendor::class);
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
