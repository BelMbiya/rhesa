<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class client extends Model
{


    protected $fillable = [
        'first_name',
        'last_name',
        'gender_id',
        'birth_date',
        'birth_place',
        'nationality',
        'permanent_address',
        'phone',
        'email',
        'profession',
        'children_under_15',
        'origin',
        'father_name',
        'mother_name',
        'selfi',
        'identity_image',
        'identity_number',
        'identity_id',
    ];
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }
    public function stays()
    {
        return $this->hasMany(Stay::class);
    }



}
