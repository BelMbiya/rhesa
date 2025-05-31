<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class hotel extends Model
{
    protected $fillable = [
        'name', 'address', 'phone', 'email', 'rooms_number', 'status',
        'manager', 'registration_date', 'geo_position', 'qr_code', 'city_id'
    ];
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
