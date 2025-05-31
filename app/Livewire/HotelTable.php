<?php

namespace App\Livewire;

use App\Models\hotel;
use Livewire\Component;

class HotelTable extends Component
{
    public function render()
    {
        $hotels = hotel::all();
        return view('livewire.hotel-table', [
            'hotels' => $hotels
        ]);
    }
}
