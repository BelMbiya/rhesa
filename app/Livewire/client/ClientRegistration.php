<?php

namespace App\Livewire\client;

use App\Models\client;
use App\Models\hotel;
use Livewire\Component;
use Livewire\WithFileUploads;
use Barryvdh\DomPDF\Facade\Pdf;
//use Spatie\Browsershot\Browsershot;

/**
 * S'occupe d'afficher un client dans un hotel
 */
class ClientRegistration extends Component
{

    use WithFileUploads;
    public client $client;
    public $client_id;
    public $data;

    public $hotel_name;
    public $reg_time;
    public $reg_date;
    // public $identity_number, $origin, $Last_name, $First_name, $gender_id,
    //     $date_naissance, $lieu_naissance, $nationalite, $adresse;
    // public $telephone, $email, $father_name, $mother_name, $profession, $children_under_15,
    //     $date_arrivee, $date_depart, $motif, $lieu_sejour, $type_chambre, $nombre_personnes,
    //     $arrival_country_date, $departure_country_date, $next_destination, $date_enregistrement,
    //     $heure_enregistrement, $numero_enregistrement, $signature, $identity_image, $selfi;

    public function mount($id)
    {
        $this->client = client::findOrFail($id);
        $this->hotel_name = Hotel::findOrFail(
            optional($this->client->stays()->latest()->first()?->registration)->hotel_id
        )?->name;
        $this->reg_time = optional($this->client->stays()->latest()->first()?->registration)->registration_time;
        $this->reg_date = optional($this->client->stays()->latest()->first()?->registration)->registration_date;
    }


    /**
     * Exporte un enregistrement de client en PDF
     * @return \Illuminate\Http\Response
     */
    public function exportToPdf()
    {
        //dd($this->hotel_name);

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
            'hotel_name' => $this->hotel_name,
            'reg_time' => $this->reg_time,
            'reg_date' => $this->reg_date,
        ];
        //dd($this->data);

        $client = $this->client;
        if (!$client) {
            abort(404, 'Client introuvable');
        }

        //     $data['id'] = $client->id;
        //     Pdf::view('pdfs.invoice', ['invoice' => $invoice])
        // ->format('a4')
        // ->save('invoice.pdf');
        //ini_set('memory_limit', '512M');
        $pdf = Pdf::loadView('pdf.client-registration', [
            'data' => $this->data,
            'client' => $this->client,
            'hotel_name' => $this->hotel_name,
            'reg_time' => $this->reg_time,
            'reg_date' => $this->reg_date,
            'isPdf' => true,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('client-registration.pdf');

        //$pdf = Pdf::loadView('pdf.client-registration', $this->data
        //return $pdf->download('client-registration.pdf');
        //return Browsershot::url(route('client-registration', $client->id))->save('example.pdf');
    }



    public function render()
    {
        return view('livewire.user.client-registration');
    }
}
