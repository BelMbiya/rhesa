<?php

namespace App\Livewire\client;

use App\Models\Client;
use App\Models\Hotel;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout("layouts.app")]
class ClientDetail extends Component
{
    public Client $client;
    public $registration;
    public $stay;
    public $hotel_name;
    public $reg_date;
    public $reg_time;

    public function mount(int $id)
    {
        $this->client       = Client::findOrFail($id);
        $this->stay         = $this->client->stays()->latest()->first();
        $this->registration = $this->stay?->registration;
        $this->hotel_name   = $this->registration
            ? Hotel::find($this->registration->hotel_id)?->name
            : null;
        $this->reg_date = $this->registration?->registration_date;
        $this->reg_time = $this->registration?->registration_time;
    }

    public function render()
    {
        return view('livewire.client-detail');
    }
}