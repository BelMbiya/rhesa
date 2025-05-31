<?php

namespace App\Livewire;

use App\Models\hotel;
use Livewire\Component;

class Hotelshow extends Component
{
    public string $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }
    public function render()
    {

        $hotel = hotel::where('slug', $this->slug)->first();
        return view('livewire.hotelshow', [
            'hotel' => $hotel
        ]);
    }
}
