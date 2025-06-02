<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Client;
use App\Models\Stay;
use App\Models\Registration;;
use Illuminate\Support\Facades\DB;


class FormStepper extends Component
{
    
    use WithFileUploads;

    public $currentStep = 1;
    public $genres_id = [];
    public $gender_id;
    public string $slug;

    // Champs Client
    public $First_name, $prenom, $date_naissance, $lieu_naissance,
        $nationalite, $adresse, $telephone, $email, $selfi, $father_name,
        $mother_name, $etat_civil, $profession, $children_under_15, $origin,
        $identity_image, $identity_number;
    public $Last_name;

    // Champs Séjour ~ Stay
    public $client_id, $date_arrivee, $date_depart, $motif,
        $lieu_sejour, $num_chambre, $nombre_personnes, $arrival_country_date, $departure_country_date;

    // Champs Inscription ~ Registration
    public $date_enregistrement, $numero_enregistrement, $hotel_id, $id, $heure_enregistrement, $observations, $signature, $next_destination;


    public function mount($slug)
    {
        $this->slug = $slug;
        $this->genres_id = \App\Models\Gender::all();
    }

    public function render()
    {
        return view('livewire.user.form-stepper');
    }

    protected function rules()
    {
        return match ($this->currentStep) {
            1 => [
                'identity_number' => 'required|string|max:50|unique:clients,identity_number',
                'selfi' => 'required|image|max:2048', // max 2MB
                'identity_image' => 'required|image|max:2048',
                'origin' => 'required|in:Manuel,Autre',

            ],
            2 => [
                'First_name' => 'nullable|string|max:30',
                'Last_name' => 'nullable|string|max:30',
                'prenom' => 'nullable|string|max:30',
                'gender_id' => 'required|exists:genders,id',
                'date_naissance' => 'required|date|before:today',
                'lieu_naissance' => 'required|string|max:50',
                'nationalite' => 'required|in:Congolaise,Autre',
                'adresse' => 'required|string|max:255',
                'telephone' => 'required|string|max:15',
                'email' => 'required|email|max:100',
                'father_name' => 'required|string|max:30',
                'mother_name' => 'required|string|max:30',
                'profession' => 'nullable|string|max:50',
                'children_under_15' => 'nullable|integer|min:0|max:20',

            ],
            3 => [
                'num_chambre'            => 'required|string|max:50',      // correspond à room_number
                'date_arrivee' => 'required|date_format:Y-m-d',
                'date_depart'  => 'nullable|date_format:Y-m-d|after_or_equal:date_arrivee', // correspond à check_out (nullable)
                'arrival_country_date'    => 'nullable|date',
                'departure_country_date'  => 'nullable|date|after_or_equal:arrival_country_date',
                'motif'                   => 'nullable|string|max:255',     // correspond à purpose
                'next_destination'         => 'nullable|string|max:255',
            ],
            default => [],
        };
    }

    public function updated($propertyName)
    {
        // Étape 1 : ne valider que les champs actuels
        if (in_array($propertyName, ['selfi', 'identity_image'])) {
            $this->validateOnly($propertyName, [
                'selfi' => 'required|image|max:2048',          // capture directe
                'identity_image' => 'required|image|max:2048', // capture directe
            ]);
        }
    }

    public function updatedNationalite($value)
    {
        if ($value !== 'Autre') {
            $this->arrival_country_date = null;
            $this->departure_country_date = null;
        }
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

    public function updatedIdentity_image()
    {
        $this->validate(['identity_image' => 'image|max:2048']);
    }

    public function submit()
    {
        //dd($this->Last_name, $this->First_name);
        // Créer le client
        $client = Client::create([
            'last_name' => $this->Last_name,
            'first_name' => $this->First_name,
            'gender_id' => $this->gender_id,
            'birth_date' => $this->date_naissance,
            'birth_place' => $this->lieu_naissance,
            'nationality' => $this->nationalite,
            'permanent_address' => $this->adresse,
            'identity_number' => $this->identity_number,
            'identity_image' => $this->identity_image ? $this->identity_image->store('images/cartes_identites', 'public') : null,
            'selfi' => $this->selfi ? $this->selfi->store('images/clients', 'public') : null,
            'phone' => $this->telephone,
            'profession' => $this->profession,
            'children_under_15' => $this->children_under_15,
            'email' => $this->email,
            'origin' => $this->origin,
            'father_name' => $this->father_name,
            'mother_name' => $this->mother_name,
            'identity_id' => $this->identity_id ?? null,
        ]);

        // Stocker l'ID du client créé
        $this->client_id = $client->id;

        // $check_in = $this->date_arrivee && preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->date_arrivee)
        //     ? $this->date_arrivee . ' ' . date("H:i:s")
        //     : null;

        // $check_out = $this->date_depart && preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->date_depart)
        //     ? $this->date_depart . ' 00:00:00'
        //     : null;

        // Créer le séjour
        $stay = Stay::create([
            'client_id' => $client->id,
            'room_number' => $this->num_chambre,
            'check_in' => date('Y-m-d H:i:s'),
            'check_out' => $check_out,
            'purpose' => $this->motif,
            'arrival_country_date' => $this->arrival_country_date,
            'departure_country_date' => $this->departure_country_date,
            'next_destination' => $this->next_destination

        ]);
        return redirect()->route('client-registration', ['id' => $client->id]);
    }
}
