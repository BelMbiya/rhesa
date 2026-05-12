<?php

namespace App\Livewire\hotel;

use App\Models\hotel;
use Livewire\Component;

/**
 * Affiche un hotel
 */
class Hotelshow extends Component
{
    public string $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }
    public function render()
    {
       // dd($this->slug);
        $hotel = hotel::where('slug', $this->slug)->first();
        return view('livewire.hotel.hotelshow', [
            'hotel' => $hotel
        ]);
    }
}
