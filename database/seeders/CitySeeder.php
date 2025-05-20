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
        $cities = [
            // Bas-Uele (province_id: 1)
            ['name' => 'Ango', 'province_id' => 1],
            ['name' => 'Bambesa', 'province_id' => 1],
            ['name' => 'Bondo', 'province_id' => 1],
            ['name' => 'Buta', 'province_id' => 1],
            ['name' => 'Poko', 'province_id' => 1],

            // Équateur (province_id: 2)
            ['name' => 'Basankusu', 'province_id' => 2],
            ['name' => 'Bikoro', 'province_id' => 2],
            ['name' => 'Bomongo', 'province_id' => 2],
            ['name' => 'Bolomba', 'province_id' => 2],
            ['name' => 'Ingende', 'province_id' => 2],
            ['name' => 'Lukolela', 'province_id' => 2],
            ['name' => 'Makanza', 'province_id' => 2],
            ['name' => 'Mbandaka', 'province_id' => 2],

            // Haut-Katanga (province_id: 3)
            ['name' => 'Kambove', 'province_id' => 3],
            ['name' => 'Kasenga', 'province_id' => 3],
            ['name' => 'Kipushi', 'province_id' => 3],
            ['name' => 'Likasi', 'province_id' => 3],
            ['name' => 'Lubumbashi', 'province_id' => 3],
            ['name' => 'Mitwaba', 'province_id' => 3],
            ['name' => 'Pweto', 'province_id' => 3],
            ['name' => 'Sakania', 'province_id' => 3],

            // Haut-Lomami (province_id: 4)
            ['name' => 'Bukama', 'province_id' => 4],
            ['name' => 'Kabongo', 'province_id' => 4],
            ['name' => 'Kamina', 'province_id' => 4],
            ['name' => 'Kaniama', 'province_id' => 4],
            ['name' => 'Malemba-Nkulu', 'province_id' => 4],

            // Haut-Uele (province_id: 5)
            ['name' => 'Dungu', 'province_id' => 5],
            ['name' => 'Faradje', 'province_id' => 5],
            ['name' => 'Niangara', 'province_id' => 5],
            ['name' => 'Rungu', 'province_id' => 5],
            ['name' => 'Wamba', 'province_id' => 5],
            ['name' => 'Watsa', 'province_id' => 5],

            // Ituri (province_id: 6)
            ['name' => 'Aru', 'province_id' => 6],
            ['name' => 'Djugu', 'province_id' => 6],
            ['name' => 'Irumu', 'province_id' => 6],
            ['name' => 'Mahagi', 'province_id' => 6],
            ['name' => 'Mambasa', 'province_id' => 6],

            // Kasaï (province_id: 7)
            ['name' => 'Dekese', 'province_id' => 7],
            ['name' => 'Ilebo', 'province_id' => 7],
            ['name' => 'Kamonia', 'province_id' => 7],
            ['name' => 'Luebo', 'province_id' => 7],
            ['name' => 'Mweka', 'province_id' => 7],
            ['name' => 'Tshikapa', 'province_id' => 7],

            // Kasaï Central (province_id: 8)
            ['name' => 'Demba', 'province_id' => 8],
            ['name' => 'Dibaya', 'province_id' => 8],
            ['name' => 'Dimbelenge', 'province_id' => 8],
            ['name' => 'Kananga', 'province_id' => 8],
            ['name' => 'Kazumba', 'province_id' => 8],
            ['name' => 'Luiza', 'province_id' => 8],

            // Kasaï Oriental (province_id: 9)
            ['name' => 'Kabeya-Kamwanga', 'province_id' => 9],
            ['name' => 'Katako-Kombe', 'province_id' => 9],
            ['name' => 'Lupatapata', 'province_id' => 9],
            ['name' => 'Mbuji-Mayi', 'province_id' => 9],
            ['name' => 'Miabi', 'province_id' => 9],
            ['name' => 'Tshilenge', 'province_id' => 9],

            // Kinshasa (province_id: 10)
            ['name' => 'Bandalungwa', 'province_id' => 10],
            ['name' => 'Barumbu', 'province_id' => 10],
            ['name' => 'Bumbu', 'province_id' => 10],
            ['name' => 'Gombe', 'province_id' => 10],
            ['name' => 'Kalamu', 'province_id' => 10],
            ['name' => 'Kasa-Vubu', 'province_id' => 10],
            ['name' => 'Kimbanseke', 'province_id' => 10],
            ['name' => 'Kinshasa', 'province_id' => 10],
            ['name' => 'Kintambo', 'province_id' => 10],
            ['name' => 'Kisenso', 'province_id' => 10],
            ['name' => 'Lemba', 'province_id' => 10],
            ['name' => 'Limete', 'province_id' => 10],
            ['name' => 'Lingwala', 'province_id' => 10],
            ['name' => 'Makala', 'province_id' => 10],
            ['name' => 'Maluku', 'province_id' => 10],
            ['name' => 'Masina', 'province_id' => 10],
            ['name' => 'Matete', 'province_id' => 10],
            ['name' => 'Mont-Ngafula', 'province_id' => 10],
            ['name' => 'Ndjili', 'province_id' => 10],
            ['name' => 'Ngaba', 'province_id' => 10],
            ['name' => 'Ngaliema', 'province_id' => 10],
            ['name' => 'Ngiri-Ngiri', 'province_id' => 10],
            ['name' => 'Nsele', 'province_id' => 10],
            ['name' => 'Selembao', 'province_id' => 10],

            // Kongo Central (province_id: 11)
            ['name' => 'Boma', 'province_id' => 11],
            ['name' => 'Kasangulu', 'province_id' => 11],
            ['name' => 'Kimvula', 'province_id' => 11],
            ['name' => 'Lukula', 'province_id' => 11],
            ['name' => 'Luozi', 'province_id' => 11],
            ['name' => 'Madimba', 'province_id' => 11],
            ['name' => 'Matadi', 'province_id' => 11],
            ['name' => 'Mbanza-Ngungu', 'province_id' => 11],
            ['name' => 'Moanda', 'province_id' => 11],
            ['name' => 'Sekebanza', 'province_id' => 11],
            ['name' => 'Songololo', 'province_id' => 11],
            ['name' => 'Tshela', 'province_id' => 11],

            // Kwango (province_id: 12)
            ['name' => 'Feshi', 'province_id' => 12],
            ['name' => 'Kahemba', 'province_id' => 12],
            ['name' => 'Kasongo-Lunda', 'province_id' => 12],
            ['name' => 'Kenge', 'province_id' => 12],
            ['name' => 'Popokabaka', 'province_id' => 12],

            // Kwilu (province_id: 13)
            ['name' => 'Bagata', 'province_id' => 13],
            ['name' => 'Bandundu', 'province_id' => 13],
            ['name' => 'Bulungu', 'province_id' => 13],
            ['name' => 'Gungu', 'province_id' => 13],
            ['name' => 'Idiofa', 'province_id' => 13],
            ['name' => 'Masimanimba', 'province_id' => 13],

            // Lomami (province_id: 14)
            ['name' => 'Kabinda', 'province_id' => 14],
            ['name' => 'Kamiji', 'province_id' => 14],
            ['name' => 'Kanda-Kanda', 'province_id' => 14],
            ['name' => 'Lubao', 'province_id' => 14],
            ['name' => 'Luilu', 'province_id' => 14],
            ['name' => 'Ngandajika', 'province_id' => 14],

            // Lualaba (province_id: 15)
            ['name' => 'Dilolo', 'province_id' => 15],
            ['name' => 'Kapanga', 'province_id' => 15],
            ['name' => 'Kolwezi', 'province_id' => 15],
            ['name' => 'Lubudi', 'province_id' => 15],
            ['name' => 'Mutshatsha', 'province_id' => 15],
            ['name' => 'Sandoa', 'province_id' => 15],

            // Mai-Ndombe (province_id: 16)
            ['name' => 'Bolobo', 'province_id' => 16],
            ['name' => 'Inongo', 'province_id' => 16],
            ['name' => 'Kiri', 'province_id' => 16],
            ['name' => 'Kutu', 'province_id' => 16],
            ['name' => 'Mushie', 'province_id' => 16],
            ['name' => 'Oshwe', 'province_id' => 16],
            ['name' => 'Kwamouth', 'province_id' => 16],
            ['name' => 'Yumbi', 'province_id' => 16],

            // Maniema (province_id: 17)
            ['name' => 'Kabambare', 'province_id' => 17],
            ['name' => 'Kailo', 'province_id' => 17],
            ['name' => 'Kasongo', 'province_id' => 17],
            ['name' => 'Kibombo', 'province_id' => 17],
            ['name' => 'Kindu', 'province_id' => 17],
            ['name' => 'Lubutu', 'province_id' => 17],
            ['name' => 'Pangi', 'province_id' => 17],
            ['name' => 'Punia', 'province_id' => 17],

            // Mongala (province_id: 18)
            ['name' => 'Bongandanga', 'province_id' => 18],
            ['name' => 'Bumba', 'province_id' => 18],
            ['name' => 'Lisala', 'province_id' => 18],

            // Nord-Kivu (province_id: 19)
            ['name' => 'Beni', 'province_id' => 19],
            ['name' => 'Butembo', 'province_id' => 19],
            ['name' => 'Goma', 'province_id' => 19],
            ['name' => 'Lubero', 'province_id' => 19],
            ['name' => 'Masisi', 'province_id' => 19],
            ['name' => 'Nyiragongo', 'province_id' => 19],
            ['name' => 'Rutshuru', 'province_id' => 19],
            ['name' => 'Walikale', 'province_id' => 19],

            // Nord-Ubangi (province_id: 20)
            ['name' => 'Bosobolo', 'province_id' => 20],
            ['name' => 'Businga', 'province_id' => 20],
            ['name' => 'Gbadolite', 'province_id' => 20],
            ['name' => 'Mobayi-Mbongo', 'province_id' => 20],
            ['name' => 'Yakoma', 'province_id' => 20],

            // Sankuru (province_id: 21)
            ['name' => 'Djalo-Djeka', 'province_id' => 21],
            ['name' => 'Katako-Kombe', 'province_id' => 21],
            ['name' => 'Kole', 'province_id' => 21],
            ['name' => 'Lodja', 'province_id' => 21],
            ['name' => 'Lomela', 'province_id' => 21],
            ['name' => 'Lubefu', 'province_id' => 21],
            ['name' => 'Lusambo', 'province_id' => 21],

            // Sud-Kivu (province_id: 22)
            ['name' => 'Bukavu', 'province_id' => 22],
            ['name' => 'Fizi', 'province_id' => 22],
            ['name' => 'Idjwi', 'province_id' => 22],
            ['name' => 'Kabare', 'province_id' => 22],
            ['name' => 'Kalehe', 'province_id' => 22],
            ['name' => 'Mwenga', 'province_id' => 22],
            ['name' => 'Shabunda', 'province_id' => 22],
            ['name' => 'Uvira', 'province_id' => 22],
            ['name' => 'Walungu', 'province_id' => 22],

            // Sud-Ubangi (province_id: 23)
            ['name' => 'Budjala', 'province_id' => 23],
            ['name' => 'Gemena', 'province_id' => 23],
            ['name' => 'Kungu', 'province_id' => 23],
            ['name' => 'Libenge', 'province_id' => 23],

            // Tanganyika (province_id: 24)
            ['name' => 'Kalemie', 'province_id' => 24],
            ['name' => 'Kabalo', 'province_id' => 24],
            ['name' => 'Kongolo', 'province_id' => 24],
            ['name' => 'Manono', 'province_id' => 24],
            ['name' => 'Moba', 'province_id' => 24],
            ['name' => 'Nyunzu', 'province_id' => 24],

            // Tshopo (province_id: 25)
            ['name' => 'Bafwasende', 'province_id' => 25],
            ['name' => 'Banalia', 'province_id' => 25],
            ['name' => 'Basoko', 'province_id' => 25],
            ['name' => 'Isangi', 'province_id' => 25],
            ['name' => 'Kisangani', 'province_id' => 25],
            ['name' => 'Opala', 'province_id' => 25],
            ['name' => 'Ubundu', 'province_id' => 25],
            ['name' => 'Yahuma', 'province_id' => 25],

            // Tshuapa (province_id: 26)
            ['name' => 'Befale', 'province_id' => 26],
            ['name' => 'Boende', 'province_id' => 26],
            ['name' => 'Bokungu', 'province_id' => 26],
            ['name' => 'Djolu', 'province_id' => 26],
            ['name' => 'Ikela', 'province_id' => 26],
            ['name' => 'Monkoto', 'province_id' => 26],
        ];

        DB::table('cities')->insert($cities);
    }
}
