<?php


namespace App\Livewire\hotel;

use Livewire\Component;
use App\Models\Hotel;
use App\Models\City;

class HotelUpdate extends Component
{
    public $hotelId;

    public $name, $address, $phone, $email, $rooms_number, $city_id, $status, $manager, $geo_position, $slug, $qr_code;

    public $cities = [];

    public function mount($id)
    {
        $this->hotelId = $id;
        $hotel = Hotel::findOrFail($this->hotelId);

        $this->name = $hotel->name;
        $this->address = $hotel->address;
        $this->phone = $hotel->phone;
        $this->email = $hotel->email;
        $this->rooms_number = $hotel->rooms_number;
        $this->city_id = $hotel->city_id;
        $this->status = $hotel->status;
        $this->manager = $hotel->manager;
        $this->geo_position = $hotel->geo_position;
        $this->cities = City::all();
    }

    public function update()
    {
        
        $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:hotels,email,' . $this->hotelId,
            'rooms_number' => 'required|integer|min:1',
            'status' => 'required|string|in:actif,inactif,en_attente,suspendu,fermé_definitivement,en_maintenance,archive,en_construction,refusé,en_test',
            'manager' => 'required|string|max:255',
            'geo_position' => 'nullable|string|max:255',
            'qr_code' => 'nullable|string|max:255',
            'city_id' => 'required|exists:cities,id',
        ]);

        $this->slug = \Illuminate\Support\Str::slug($this->name);
        $url = 'http://192.168.1.147:8000/enregistrement/' . $this->slug;
        $filename = 'qrcodes/' . $this->slug . '.png';
        $qrImage = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(300)->generate($url);
        \Illuminate\Support\Facades\Storage::disk('public')->put($filename, $qrImage);

        $hotel = Hotel::findOrFail($this->hotelId);
        $hotel->update([
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'rooms_number' => $this->rooms_number,
            'city_id' => $this->city_id,
            'status' => $this->status,
            'slug' => $this->slug,
            'qr_code' => $filename, // 🔁 ici on passe le nom du fichier à la base de données
            'manager' => $this->manager,
            'geo_position' => $this->geo_position,
        ]);

        session()->flash('success', 'Hôtel mis à jour avec succès.');
        return redirect()->route('hotels');
    }

    public function render()
    {
        return view('livewire.hotel.hotel-update', [
            'cities' => $this->cities, // 🔁 ici on passe la variable à la vue
        ]);
    }
}
