<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class stay extends Model
{


    protected $fillable = [
        'client_id',
        'room_number',
        'check_in',
        'check_out',
        'arrival_country_date',
        'departure_country_date',
        'purpose',
        'next_destination',
    ];

    public function hotel()
    {
        // Assurez-vous que votre table 'stays' a bien une colonne 'hotel_id'
        return $this->belongsTo(Hotel::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function registration()
    {
        return $this->hasOne(Registration::class);
    }

}
