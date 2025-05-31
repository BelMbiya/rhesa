<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class stay extends Model
{
    
    
    protected $fillable = [
        'client_id',
        //'date_arrivee',
        //'date_depart',
        'room_number',
        'check_in',
        'check_out',
        'arrival_country_date',
        'departure_country_date',
        //'lieu_sejour',
        // 'num_chambre',
        'purpose',
        'next_destination',
    ];

    
}
