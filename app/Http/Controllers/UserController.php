<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Livewire\utilisateur\UserShow;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    
    public function show(User $user)
    {
        // Retourne directement le composant Livewire UserShow
        return UserShow::class; 
    }
    public function edit(User $user)
    {
        // Vous devrez créer un composant Livewire ou une vue pour l'édition
        // Pour l'instant, nous allons simplement rediriger ou afficher un message
        return view('users.edit', compact('user'));
    }

    /**
     * Supprime un utilisateur.
     */
    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('message', 'Utilisateur supprimé avec succès !');
        return redirect()->route('users.index');
    }
}
