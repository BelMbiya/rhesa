<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Client;
use App\Models\Stay;
use App\Models\Registration;

class FormStepper extends Component
{
    use WithFileUploads;

    public $currentStep = 1;

    // Champs Client
    public $name, $postnom, $prenom, $genre, $date_naissance, $lieu_naissance,
        $nationalite, $adresse, $telephone, $email, $selfi, $father_name,
        $mother_name, $etat_civil, $profession, $children_under_15, $origin,
        $identity_image;

    // Champs Séjour ~ Stay
    public $client_id, $date_arrivee, $date_depart, $motif,
        $lieu_sejour, $type_chambre, $nombre_personnes;

    // Champs Inscription ~ Registration
    public $date_enregistrement, $numero_enregistrement, $observations;

    protected function rules()
    {
        return match($this->currentStep) {
            1 => [
                'name' => 'required|string|max:100',
                'postnom' => 'nullable|string|max:100',
                'prenom' => 'nullable|string|max:100',
                'genre' => 'required|in:Masculin,Féminin,Autre',
                'date_naissance' => 'required|date|before:today',
                'lieu_naissance' => 'nullable|string|max:150',
                'nationalite' => 'required|in:Congolaise,Autre',
                'adresse' => 'nullable|string|max:255',
                'telephone' => 'required|string|max:15',
                'email' => 'required|email|max:100',
                'etat_civil' => 'nullable|in:Célibataire,Marié(e),Divorcé(e),Veuf(ve),Séparé(e),Pacsé(e),Union libre',
                'selfi' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'father_name' => 'required|string|max:30',
                'mother_name' => 'required|string|max:30',
                'profession' => 'nullable|string|max:50',
                'children_under_15' => 'nullable|integer|min:0|max:20',
                'origin' => 'required|in:Manuel,Autre',
                'identity_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ],
            2 => [
                'date_arrivee' => 'required|date|before_or_equal:date_depart',
                'date_depart' => 'required|date|after_or_equal:date_arrivee',
                'motif' => 'nullable|string|max:255',
                'lieu_sejour' => 'required|string|max:150',
                'type_chambre' => 'required|string|max:50',
                'nombre_personnes' => 'required|integer|min:1|max:20',
            ],
            3 => [
                'date_enregistrement' => 'required|date|before_or_equal:today',
                'numero_enregistrement' => 'required|string|max:50|unique:registrations,numero_enregistrement',
                'observations' => 'nullable|string|max:500',
            ],
            default => [],
        };
    }

    public function render()
    {
        return view('livewire.user.form-stepper');
    }

    public function increaseStep()
    {
        $this->validate($this->rules());
        if ($this->currentStep < 3) {
            $this->currentStep++;
        }
    }

    public function decreaseStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function updatedSelfi()
    {
        $this->validate(['selfi' => 'image|max:2048']);
    }

    public function removeSelfi()
    {
        $this->selfi = null;
    }

    public function updatedIdentity_image()
    {
        $this->validate(['identity_image' => 'image|max:2048']);
    }

    public function removeIdentity_image()
    {
        $this->identity_image = null;
    }

    public function submit()
    {
        $client = Client::create([
            'name' => $this->name,
            'postnom' => $this->postnom,
            'prenom' => $this->prenom,
            'genre' => $this->genre,
            'date_naissance' => $this->date_naissance,
            'lieu_naissance' => $this->lieu_naissance,
            'nationalite' => $this->nationalite,
            'adresse' => $this->adresse,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'etat_civil' => $this->etat_civil,
            'profession' => $this->profession,
            'children_under_15' => $this->children_under_15,
            'origin' => $this->origin,
            'father_name' => $this->father_name,
            'mother_name' => $this->mother_name,
            'selfi' => $this->selfi->store('images/clients', 'public'),
            'identity_image' => $this->identity_image->store('images/clients', 'public'),
        ]);

        $stay = Stay::create([
            'client_id' => $client->id,
            'date_arrivee' => $this->date_arrivee,
            'date_depart' => $this->date_depart,
            'motif' => $this->motif,
            'lieu_sejour' => $this->lieu_sejour,
            'type_chambre' => $this->type_chambre,
            'nombre_personnes' => $this->nombre_personnes,
        ]);

        Registration::create([
            'stay_id' => $stay->id,
            'date_enregistrement' => $this->date_enregistrement,
            'numero_enregistrement' => $this->numero_enregistrement,
            'observations' => $this->observations,
        ]);

        session()->flash('message', 'Formulaire soumis avec succès !');
        $this->reset();
        $this->currentStep = 1;
    }
}
