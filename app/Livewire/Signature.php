<?php

namespace App\Livewire;

use Livewire\Component;

class Signature extends Component
{
    public $someId = 1;
        public $id;
    public function render()
    {
        return view('livewire.signature');
    }
}
