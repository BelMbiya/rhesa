<?php

namespace Database\Seeders;

use App\Models\hotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotels = [
            ['name' => 'HOTEL ILF MAURICE', 'city_id' => 68],
            ['name' => 'HOTEL MEMLING', 'city_id' => 59],
            ['name' => 'HOTEL KARIBU', 'city_id' => 18],
            ['name' => 'HOTEL DU FLEUVE', 'city_id' => 59],
            ['name' => 'HOTEL VICTORIA PALACE', 'city_id' => 60],
            ['name' => 'HOTEL LA RÉSIDENCE', 'city_id' => 59],
            ['name' => 'HOTEL SERENA', 'city_id' => 139],
            ['name' => 'HOTEL MIKENO', 'city_id' => 71],
            ['name' => 'HOTEL OKAPI', 'city_id' => 76],
            ['name' => 'HOTEL BLEU CIEL', 'city_id' => 67],
        ];

        foreach ($hotels as $key => $data) {
            $index = $key + 1;

            // Générer le slug
            $slug = Str::slug($data['name']);

            // Générer l'URL (ex: https://tonsite.com/hotel/hotel-ilf-maurice)
            $url = 'http://192.168.1.147:8000/enregistrement/'.$slug;
            // Générer le QR code avec l’URL
            $filename = 'qrcodes/' . $slug . '.png';
            $qrImage = QrCode::format('png')->size(300)->generate($url);
            Storage::disk('public')->put($filename, $qrImage);

            // Créer l’hôtel avec le slug et le chemin QR code
            Hotel::create([
                'name' => $data['name'],
                'slug' => $slug,
                'address' => 'Adresse fictive ' . $index,
                'phone' => '+24381000000' . $index,
                'email' => 'hotel' . $index . '@example.com',
                'rooms_number' => rand(30, 100),
                'status' => 'active',
                'manager' => 'Manager ' . $index,
                'geo_position' => '-4.3' . $index . ',15.3' . $index,
                'qr_code' => $filename,
                'city_id' => $data['city_id'],
            ]);
        }
    }
}
