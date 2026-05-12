<?php

namespace App\Livewire\utilisateur;

use App\Models\Hotel;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserRegistration extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $status = 'actif'; // Valeur par défaut
    public $hotel_id;
    public $hotels = [];

    public function mount()
    {
        $this->hotels = Hotel::all();
    }

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'status' => ['required', 'string', Rule::in(['actif', 'inactif', 'suspendu'])],
            'hotel_id' => ['nullable', 'exists:hotels,id'],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createUser()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'status' => $this->status,
            'hotel_id' => $this->hotel_id,
        ]);

        session()->flash('message', 'Utilisateur créé avec succès !');

        $this->reset(['name', 'email', 'password', 'password_confirmation', 'status', 'hotel_id']);

        return redirect()->route('users.index'); // Rediriger vers la liste des utilisateurs
    }

    public function render()
    {
        return view('livewire.utilisateur.user-registration');
    }
}
