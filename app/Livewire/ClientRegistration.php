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
    public $identity_number, $origin, $Last_name, $First_name, $gender_id,
        $date_naissance, $lieu_naissance, $nationalite, $adresse;

    public function mount($id)
    {
        $this->client = client::findOrFail($id);
    }

    public function exportToPdf()
    {


        $data = $this->only([
            'identity_number',
            'origin',
            'Last_name',
            'First_name',
            'gender_id',
            'date_naissance',
            'lieu_naissance',
            'nationalite',
            'adresse',
            'telephone',
            'email',
            'father_name',
            'mother_name',
            'profession',
            'children_under_15',
            'date_arrivee',
            'date_depart',
            'motif',
            'lieu_sejour',
            'type_chambre',
            'nombre_personnes',
            'arrival_country_date',
            'departure_country_date',
            'next_destination',
            'date_enregistrement',
            'heure_enregistrement',
            'numero_enregistrement',
            'signature',
            'identity_image',
            'selfi'
        ]);

        $client = $this->client;
        if (!$client) {
            abort(404, 'Client introuvable');
        }

        $data['id'] = $client->id;
        $data['Last_name'] = $client->Last_name;
        $data['First_name'] = $client->First_name;
        $data['identity_image'] = 'storage/' . $client->identity_image;
        $data['selfi'] = 'storage/' . $client->selfi;
        $data['gender_name'] = \App\Models\Gender::find($this->gender_id)?->name;

        $pdf = Pdf::loadView('pdf.client-registration', [
            'data' => $data,
            'client' => $client,
        ]);

        $pdf = Pdf::loadView('pdf.client-registration', $data);
        return $pdf->download('invoice.pdf');
    }



    public function render()
    {
        return view('livewire.user.client-registration');
    }
}
