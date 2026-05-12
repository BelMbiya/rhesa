<?php

namespace App\Livewire\hotel;

use Livewire\Component;

/**
 * S'occupe de la creation d'un hotel
 */
class HotelRegistration extends Component
{

    public $name;
    public $address;
    public $phone;
    public $email;
    public $rooms_number;
    public $status;
    public $manager;
    public $geo_position;
    public $qr_code;
    public $city_id;
    public $slug;

    public $cities = [];

    public function mount()
    {
        $this->cities = \App\Models\City::all();
    }

    /**
     * La fonction de la creation d'un hotel
     * @return void
     */
    public function register()
    {

        $this->validate(
            [
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'required|email|max:255|unique:hotels,email',
                'rooms_number' => 'required|integer|min:1',
                'status' => 'required|string|in:actif,inactif,en_attente,suspendu,fermé_definitivement,en_maintenance,archive,en_construction,refusé,en_test',
                'manager' => 'required|string|max:255',
                'geo_position' => 'nullable|string|max:255',
                //'slug' => 'nullable|string|max:255',
                'qr_code' => 'nullable|string|max:255',
                'city_id' => 'required|exists:cities,id',
            ]
        );

        $this->slug = \Illuminate\Support\Str::slug($this->name);
        $url = 'http://192.168.1.147:8000/enregistrement/' . $this->slug;
        $filename = 'qrcodes/' . $this->slug . '.png';
        $qrImage = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(300)->generate($url);
        \Illuminate\Support\Facades\Storage::disk('public')->put($filename, $qrImage);
        \App\Models\Hotel::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'rooms_number' => $this->rooms_number,
            'status' => $this->status,
            'manager' => $this->manager,
            'geo_position' => $this->geo_position,
            'qr_code' => $filename,
            'city_id' => $this->city_id,
        ]);

        $this->redirect(route('hotels'));
    }

    public function render()
    {
        return view('livewire.hotel.hotel-registration');
    }
}
