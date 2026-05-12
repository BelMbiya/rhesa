<?php

namespace App\Livewire\utilisateur;

use App\Models\Hotel;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class UserUpdate extends Component
{
    public User $user;
    public $name;
    public $email;
    public $status;
    public $hotel_id;
    public $password;
    public $password_confirmation;
    public $hotels = [];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->status = $user->status;
        $this->hotel_id = $user->hotel_id;
        $this->hotels = Hotel::all();
    }

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user->id)],
            'status' => ['required', 'string', Rule::in(['actif', 'inactif', 'suspendu'])],
            'hotel_id' => ['nullable', 'exists:hotels,id'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updateUser()
    {
        $validatedData = $this->validate();

        // Ne met à jour le mot de passe que s'il est fourni
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']); // Retirer le mot de passe du tableau s'il est vide
        }

        $this->user->update($validatedData);

        session()->flash('message', 'Utilisateur mis à jour avec succès !');

        return redirect()->route('users.show', $this->user);
    }

    public function render()
    {
        return view('livewire.utilisateur.user-update');
    }
}
