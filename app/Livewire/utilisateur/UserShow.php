<?php

namespace App\Livewire\utilisateur;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

#[Layout("layouts.app")]
class UserShow extends Component
{
    public User $user;
    public $allRoles;
    public $allPermissions;
    public function mount(User $user)
    {
        $this->user = $user;
        $this->allRoles = Role::orderBy('name')->get();
        $this->allPermissions = Permission::orderBy('name')->get();
    }

    public function assignRole(string $role): void
    {
        abort_unless(auth()->user()->can('assign roles'), 403);
        $this->user->assignRole($role);
        session()->flash('role_success', "Rôle « $role » assigné.");
        $this->user->refresh();
    }

    public function revokeRole(string $role): void
    {
        abort_unless(auth()->user()->can('revoke roles'), 403);
        // Empêcher l'auto-révocation du Super Admin
        if ($this->user->id === auth()->id() && $role === 'Super Admin') {
            session()->flash('role_error', 'Vous ne pouvez pas vous retirer le rôle Super Admin.');
            return;
        }
        $this->user->removeRole($role);
        session()->flash('role_success', "Rôle « $role » révoqué.");
        $this->user->refresh();
    }


    public function givePermission(string $permission): void
    {
        abort_unless(auth()->user()->can('assign roles'), 403);
        $this->user->givePermissionTo($permission);
        $this->user->refresh();
    }

    public function revokePermission(string $permission): void
    {
        abort_unless(auth()->user()->can('revoke roles'), 403);
        $this->user->revokePermissionTo($permission);
        $this->user->refresh();
    }

    public function render()
    {
        return view("livewire.utilisateur.user-show");
    }

    public function deleteUser()
    {
        $this->user->delete();
        session()->flash("message", "Utilisateur supprimé avec succès !");
        return redirect()->route("users.index");
    }
}
