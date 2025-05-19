<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provincesWithTerritories = [
            'Bas-Uele' => [
                'Aketi', 'Ango', 'Bambesa', 'Bondo', 'Buta', 'Poko'
            ],
            'Équateur' => [
                'Basankusu', 'Bikoro', 'Bolomba', 'Bomongo', 'Ingende', 'Lukolela', 'Makanza', 'Mbandaka', 'Mushie'
            ],
            'Haut-Katanga' => [
                'Kambove', 'Kasenga', 'Kipushi', 'Lubumbashi', 'Mitwaba', 'Pweto', 'Sakania'
            ],
            'Haut-Lomami' => [
                'Bukama', 'Kabongo', 'Kamina', 'Kaniama', 'Malemba-Nkulu'
            ],
            'Haut-Uele' => [
                'Dungu', 'Faradje', 'Niangara', 'Rungu', 'Wamba', 'Watsa'
            ],
            'Ituri' => [
                'Aru', 'Djugu', 'Irumu', 'Mahagi', 'Mambasa'
            ],
            'Kasaï' => [
                'Dibaya', 'Dimbelenge', 'Ilebo', 'Luebo', 'Mweka'
            ],
            'Kasaï Central' => [
                'Demba', 'Kananga', 'Kazumba', 'Luiza'
            ],
            'Kasaï Oriental' => [
                'Kabeya-Kamwanga', 'Katanda', 'Lupatapata', 'Mbuji-Mayi', 'Miabi', 'Tshilenge'
            ],
            'Kinshasa' => [
                'Bandalungwa', 'Barumbu', 'Bumbu', 'Gombe', 'Kalamu', 'Kasa-Vubu', 'Kimbanseke', 
                'Kinshasa', 'Kintambo', 'Kisenso', 'Lemba', 'Limete', 'Lingwala', 'Makala', 
                'Maluku', 'Masina', 'Matete', 'Mont-Ngafula', 'Ndjili', 'Ngaba', 'Ngaliema', 
                'Ngiri-Ngiri', 'Nsele', 'Selembao'
            ],
            'Kongo Central' => [
                'Boma', 'Kasangulu', 'Kimvula', 'Lukula', 'Luozi', 'Madimba', 'Matadi', 'Mbanza-Ngungu', 'Moanda', 'Seke-Banza', 'Songololo', 'Tshela'
            ],
            'Kwango' => [
                'Feshi', 'Kahemba', 'Kasongo-Lunda', 'Kenge', 'Popokabaka'
            ],
            'Kwilu' => [
                'Bagata', 'Bandundu', 'Bulungu', 'Gungu', 'Idiofa', 'Mangai', 'Masi-Manimba'
            ],
            'Lomami' => [
                'Kabinda', 'Kamiji', 'Lubao', 'Luilu', 'Ngandajika'
            ],
            'Lualaba' => [
                'Dilolo', 'Kapanga', 'Kolwezi', 'Lubudi', 'Mutshatsha', 'Sandoa'
            ],
            'Mai-Ndombe' => [
                'Bolobo', 'Inongo', 'Kiri', 'Kutu', 'Kwamouth', 'Oshwe', 'Yumbi'
            ],
            'Maniema' => [
                'Kabambare', 'Kailo', 'Kasongo', 'Kibombo', 'Kindu', 'Lubutu', 'Pangi', 'Punia'
            ],
            'Mongala' => [
                'Bongandanga', 'Bumba', 'Lisala'
            ],
            'Nord-Kivu' => [
                'Beni', 'Butembo', 'Goma', 'Lubero', 'Masisi', 'Nyiragongo', 'Rutshuru', 'Walikale'
            ],
            'Nord-Ubangi' => [
                'Bosobolo', 'Businga', 'Gbadolite', 'Mobayi-Mbongo', 'Yakoma'
            ],
            'Sankuru' => [
                'Kole', 'Lodja', 'Lomela', 'Lubefu', 'Lusambo'
            ],
            'Sud-Kivu' => [
                'Bukavu', 'Fizi', 'Idjwi', 'Kabale', 'Kalehe', 'Mwenga', 'Shabunda', 'Uvira', 'Walungu'
            ],
            'Sud-Ubangi' => [
                'Budjala', 'Gemena', 'Kungu', 'Libenge'
            ],
            'Tanganyika' => [
                'Kabalo', 'Kalemie', 'Kongolo', 'Manono', 'Moba', 'Nyunzu'
            ],
            'Tshopo' => [
                'Bafwasende', 'Banalia', 'Basoko', 'Isangi', 'Kisangani', 'Opala', 'Ubundu', 'Yahuma'
            ],
            'Tshuapa' => [
                'Befale', 'Boende', 'Bokungu', 'Djolu', 'Ikela', 'Monkoto'
            ],
        ];

        
        foreach ($provincesWithTerritories as $provinceName => $territories) {
            // Insert province and get its ID
            $provinceId = DB::table('provinces')->insertGetId([
                'name' => $provinceName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert territories for this province
            

            foreach ($territories as $territoryName) {
                DB::table('cities')->insert([
                    'name' => $territoryName,
                    'province_id' => $provinceId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
