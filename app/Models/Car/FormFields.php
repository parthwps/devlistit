<?php

namespace App\Models\Car;

use App\Models\Car;
use App\Models\Car\formOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormFields extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "form_fields";
    protected $primaryKey = "form_field_id";
    protected $fillable = ['label','type','category_field_id'];
    
     public function form_options()
    {
        return $this->hasMany(formOptions::class , 'form_fields_id');
    }

}
