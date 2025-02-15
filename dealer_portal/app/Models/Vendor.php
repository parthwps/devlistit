<?php

namespace App\Models;

use App\Models\Instrument\Equipment;
use App\Models\Instrument\EquipmentReview;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Vendor extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable;

    protected $fillable = [
        'photo',
        'email',
        'phone',
        'phone_verified',
        'username',
        'password',
        'trader',
        'status',
        'amount',
        'profile_completed',
        'facebook',
        'twitter',
        'linkedin',
        'avg_rating',
        'email_verified_at',
        'is_dealer',
        'show_email_addresss',
        'show_phone_number',
        'show_contact_form',
        'vendor_type',
        'email_subscription_enable',
        'bump',
        'spotlight',
        'history_check',
        'no_of_ads',
        'bump_used',
        'last_spotlight_used',
        'history_check_used',
        'no_of_ads_used',
        'google_review_id',
        'is_franchise_dealer',
        'website_link',
        'is_trusted',
        'est_year',
        'about_us',
        'finance_url'
    ];

    public function vendor_infos()
    {
        return $this->hasMany(VendorInfo::class);
    }
    public function vendor_info()
    {
        return $this->hasOne(VendorInfo::class);
    }

    //support ticket
    public function support_ticket()
    {
        return $this->hasMany(SupportTicket::class, 'vendor_id', 'id');
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }
    public function cars()
    {
        return $this->hasMany(Car::class, 'vendor_id', 'id');
    }
}
