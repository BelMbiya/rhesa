<?php

namespace App\Livewire;

use App\Models\client;
use Livewire\Component;
use Livewire\WithFileUploads;
use Barryvdh\DomPDF\Facade\Pdf;

class ClientRegistration extends Component
{

    use WithFileUploads;
    public client $client;
    public $client_id;
    public $data;
    // public $identity_number, $origin, $Last_name, $First_name, $gender_id,
    //     $date_naissance, $lieu_naissance, $nationalite, $adresse;
    // public $telephone, $email, $father_name, $mother_name, $profession, $children_under_15,
    //     $date_arrivee, $date_depart, $motif, $lieu_sejour, $type_chambre, $nombre_personnes,
    //     $arrival_country_date, $departure_country_date, $next_destination, $date_enregistrement,
    //     $heure_enregistrement, $numero_enregistrement, $signature, $identity_image, $selfi;

    public function mount($id)
    {
        $this->client = client::findOrFail($id);
        $this->data = [
            'identity_number' => $this->client->identity_number,
            'origin' => $this->client->origin,
            'Last_name' => $this->client->last_name,
            'First_name' => $this->client->first_name,
            'gender_id' => $this->client->gender_id,
            'date_naissance' => $this->client->birth_date,
            'lieu_naissance' => $this->client->birth_place,
            'nationalite' => $this->client->nationality,
            'adresse' => $this->client->permanent_address,
            'telephone' => $this->client->phone,
            'email' => $this->client->email,
            'father_name' => $this->client->father_name,
            'mother_name' => $this->client->mother_name,
            'profession' => $this->client->profession,
            'children_under_15' => $this->client->children_under_15,
            // 'date_arrivee' => $this->client->check_in,
            // 'date_depart' => $this->client->check_in,
            // 'motif' => $this->client->motif,
            // 'lieu_sejour' => $this->client->lieu_sejour,
            // 'type_chambre' => $this->client->type_chambre,
            // 'nombre_personnes' => $this->client->nombre_personnes,
            // 'arrival_country_date' => $this->client->arrival_country_date,
            // 'departure_country_date' => $this->client->departure_country_date,
            // 'next_destination' => $this->client->next_destination,
            // 'date_enregistrement' => $this->client->date_enregistrement,
            // 'heure_enregistrement' => $this->client->heure_enregistrement,
            // 'numero_enregistrement' => $this->client->numero_enregistrement,
            // 'signature' => $this->client->signature,
            'identity_image' => $this->client->identity_image,
            'selfi' => $this->client->selfi,
        ];
        
    }


    public function exportToPdf()
    {
        //dd($this->data);
        $client = $this->client;
        if (!$client) {
            abort(404, 'Client introuvable');
        }

        $data['id'] = $client->id;
        // $data['Last_name'] = $client->Last_name;
        // $data['First_name'] = $client->First_name;
        //$data['identity_image'] = 'storage/' . $this->client->identity_image;
        //$data['selfi'] = 'storage/' . $this->client->selfi;
        // $data['gender_name'] = \App\Models\Gender::find($this->gender_id)?->name;
        //ini_set('display_errors', 1);
        //error_reporting(E_ALL);

        $pdf = Pdf::loadView('pdf.client-registration', [
              'data' => $this->data,
              'client' => $this->client,
        ]);

        //$pdf = Pdf::loadView('pdf.client-registration', $this->data);
        return $pdf->download('fiche-client.pdf');
    }



    public function render()
    {
        return view('livewire.user.client-registration');
    }
}
