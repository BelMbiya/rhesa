<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Locked;
use App\Models\Client;
use App\Models\Stay;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Lazy;
use Illuminate\Support\Carbon;

#[Lazy]
class FormStepper extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $genres_id = [];
    public $hotel = [];
    public $hotel_name;
    public $gender_id;
    public string $slug;

    // Champs Step 1
    public $identity_number;
    public $selfi;
    public $identity_image;
    public $origin;

    // Champs Step 2
    public $First_name;
    public $Last_name;
    public $prenom;
    public $date_naissance;
    public $lieu_naissance;
    public $nationalite;
    public $adresse;
    public $telephone;
    public $email;
    public $father_name;
    public $mother_name;
    public $etat_civil;
    public $profession;
    public $children_under_15;

    // Champs Step 3
    public $num_chambre;
    public $arrival_country_date;
    public $departure_country_date;
    public $motif;
    public $next_destination;
    public $signature;

    // Champs Registration/Stay
    public $client_id;
    public $date_arrivee;
    public $date_depart;
    public $lieu_sejour;
    public $nombre_personnes;
    public $date_enregistrement;
    public $numero_enregistrement;
    public $hotel_id;
    public $id;
    public $heure_enregistrement;
    public $observations;

    // Propriétés verrouillées
    #[Locked] public $locked_identity_number   = null;
    #[Locked] public $locked_origin            = null;
    #[Locked] public $locked_First_name        = null;
    #[Locked] public $locked_Last_name         = null;
    #[Locked] public $locked_prenom            = null;
    #[Locked] public $locked_gender_id         = null;
    #[Locked] public $locked_date_naissance    = null;
    #[Locked] public $locked_lieu_naissance    = null;
    #[Locked] public $locked_nationalite       = null;
    #[Locked] public $locked_adresse           = null;
    #[Locked] public $locked_telephone         = null;
    #[Locked] public $locked_email             = null;
    #[Locked] public $locked_father_name       = null;
    #[Locked] public $locked_mother_name       = null;
    #[Locked] public $locked_profession        = null;
    #[Locked] public $locked_children_under_15 = null;

    public function mount($slug)
    {
        $hotel = \App\Models\Hotel::where('slug', $slug)->first();
        abort_unless($hotel, 404, 'Page introuvable');

        $this->slug       = $slug;
        $this->hotel_id   = $hotel->id;
        $this->hotel_name = $hotel->name;
        $this->hotel      = \App\Models\Hotel::all();
        $this->genres_id  = \App\Models\Gender::all();
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
                'selfi'           => 'required|image|max:2048',
                'identity_image'  => 'required|image|max:2048',
                'origin'          => 'nullable|in:Manuel,Autre',
            ],
            2 => [
                'First_name'        => 'nullable|string|max:30',
                'Last_name'         => 'nullable|string|max:30',
                'prenom'            => 'nullable|string|max:30',
                'gender_id'         => 'required|exists:genders,id',
                'date_naissance'    => ['required', 'date_format:Y-m-d', 'before:today', 'after:1900-01-01'],
                'lieu_naissance'    => 'required|string|max:50',
                'nationalite'       => 'required|in:Congolaise,Etrangere',
                'adresse'           => 'required|string|max:255',
                'telephone'         => 'required|string|max:15',
                'email'             => 'required|email|max:100',
                'father_name'       => 'required|string|max:30',
                'mother_name'       => 'required|string|max:30',
                'profession'        => 'nullable|string|max:50',
                'children_under_15' => 'nullable|integer|min:0|max:20',
            ],
            3 => [
                'num_chambre'            => 'required|string|max:50',
                'arrival_country_date'   => 'nullable|date',
                'departure_country_date' => 'nullable|date|after_or_equal:arrival_country_date',
                'motif'                  => 'nullable|string|max:255',
                'next_destination'       => 'nullable|string|max:255',
                'signature'              => 'nullable|image|max:2048',
            ],
            default => [],
        };
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['selfi', 'identity_image', 'signature'])) {
            $this->validateOnly($propertyName, [
                'selfi'          => 'image|max:2048',
                'identity_image' => 'image|max:2048',
                'signature'      => 'image|max:2048',
            ]);
        }
    }

    public function updatedNationalite($value)
    {
        // ✅ Remplacé 'Autre' par 'Etrangere'
        if ($value !== 'Etrangere') {
            $this->arrival_country_date   = null;
            $this->departure_country_date = null;
        }
    }

    public function increaseStep()
    {
        $this->validate($this->rules());

        if ($this->currentStep === 1) {
            $this->locked_identity_number = $this->identity_number;
            $this->locked_origin          = $this->origin;
        }

        if ($this->currentStep === 2) {
            $this->locked_First_name        = $this->First_name;
            $this->locked_Last_name         = $this->Last_name;
            $this->locked_prenom            = $this->prenom;
            $this->locked_gender_id         = $this->gender_id;
            $this->locked_date_naissance    = $this->date_naissance;
            $this->locked_lieu_naissance    = $this->lieu_naissance;
            $this->locked_nationalite       = $this->nationalite;
            $this->locked_adresse           = $this->adresse;
            $this->locked_telephone         = $this->telephone;
            $this->locked_email             = $this->email;
            $this->locked_father_name       = $this->father_name;
            $this->locked_mother_name       = $this->mother_name;
            $this->locked_profession        = $this->profession;
            $this->locked_children_under_15 = $this->children_under_15;
        }

        $this->resetValidation();

        if ($this->currentStep < 3) {
            $this->currentStep++;
        }
    }

    public function decreaseStep()
    {
        $this->resetValidation();
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function submit()
    {
        $this->validate($this->rules());

        try {
            $formattedBirthDate = Carbon::parse($this->locked_date_naissance)->format('Y-m-d');
        } catch (\Exception $e) {
            $this->addError('date_naissance', 'Format de date invalide.');
            return;
        }

        DB::transaction(function () use ($formattedBirthDate) {

            $client = Client::create([
                'last_name'         => $this->locked_Last_name,
                'first_name'        => $this->locked_First_name,
                'gender_id'         => $this->locked_gender_id,
                'birth_date'        => $formattedBirthDate,
                'birth_place'       => $this->locked_lieu_naissance,
                'nationality'       => $this->locked_nationalite,
                'permanent_address' => $this->locked_adresse,
                'identity_number'   => $this->locked_identity_number,
                'identity_image'    => $this->identity_image
                    ? $this->identity_image->store('images/cartes_identites', 'public')
                    : null,
                'selfi'             => $this->selfi
                    ? $this->selfi->store('images/clients', 'public')
                    : null,
                'phone'             => $this->locked_telephone,
                'profession'        => $this->locked_profession,
                'children_under_15' => $this->locked_children_under_15 ?? 0,
                'email'             => $this->locked_email,
                'origin'            => $this->locked_origin,
                'father_name'       => $this->locked_father_name,
                'mother_name'       => $this->locked_mother_name,
                'identity_id'       => $this->identity_id ?? null,
            ]);

            $this->client_id = $client->id;

            $stay = Stay::create([
                'client_id'              => $client->id,
                'room_number'            => $this->num_chambre,
                'check_in'               => now(),
                'check_out'              => now(),
                'purpose'                => $this->motif,
                'arrival_country_date'   => $this->arrival_country_date ?: null,
                'departure_country_date' => $this->departure_country_date ?: null,
                'next_destination'       => $this->next_destination ?: null,
            ]);

            Registration::create([
                'stay_id'           => $stay->id,
                'hotel_id'          => $this->hotel_id,
                'signature'         => $this->signature
                    ? $this->signature->store('images/signatures', 'public')
                    : null,
                'registration_date' => now()->toDateString(),
                'registration_time' => now()->format('H:i:s'),
                'status'            => 'pending',
            ]);
        });

        return redirect()->route('client-registration', ['id' => $this->client_id]);
    }
}