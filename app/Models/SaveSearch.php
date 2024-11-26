<?php

namespace App\Models;

use App\Models\RolePermission;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveSearch extends Model implements AuthenticatableContract
{
  use HasFactory, Authenticatable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'search_url',
    'save_search_name',
    'selectedAlertType',
    'last_save_date',
    'user_id'
  ];

 
 
 public function user()
  {
    return $this->belongsTo(Vendor::class , 'user_id');
  }
  
  
}
