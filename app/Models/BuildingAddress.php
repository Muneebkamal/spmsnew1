<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buildingAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'building',
        'district',
        'address',
        'address_chinese',
        'usage',
        'year_of_completion',
        'property_type',
        'title',
        'management_company',
        'developers',
        'transportation',
        'floor',
        'floor_area',
        'height',
        'air_con_system',
        'lifts',
        'parking',
        'carpark'
    ];
}
