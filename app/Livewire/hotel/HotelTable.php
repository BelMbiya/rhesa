<?php

namespace App\Livewire\hotel;

use App\Models\hotel;
use Livewire\Component;

class HotelTable extends Component
{
    public function render()
    {
        $hotels = hotel::all();
        return view('livewire.hotel.hotel-table', [
            'hotels' => $hotels
        ]);
    }
}
