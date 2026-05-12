<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class hotel extends Model
{
    protected $fillable = [
        'name', 'address', 'phone', 'email', 'rooms_number', 'status',
        'manager', 'registration_date', 'geo_position', 'qr_code', 'slug', 'city_id'
    ];
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

}
