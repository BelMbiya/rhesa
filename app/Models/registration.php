<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class registration extends Model
{



    protected $fillable = [
        'stay_id',
        'hotel_id',
        'registration_date',
        'registration_time',
        'observations',
        'signature',
    ];

    public function stay()
    {
        return $this->belongsTo(Stay::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }


}
