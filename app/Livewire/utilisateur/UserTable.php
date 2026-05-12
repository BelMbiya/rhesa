<?php

namespace App\Livewire\utilisateur;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class UserTable extends Component
{
    public function render()
    {
        return view('livewire.utilisateur.user-table');
    }
}
