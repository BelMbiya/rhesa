<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IdentityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Carte d’identité',
            'Passeport',
            'Permis de conduire',
            'Carte d’électeur',
            'Carte de résident',
        ];

        foreach ($types as $type) {
            DB::table('identities')->insert([
                'name' => $type,
            ]);
        }
    }
}
