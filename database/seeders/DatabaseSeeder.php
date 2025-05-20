<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\CitySeeder;
use Database\Seeders\ProvinceSeeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(
            ProvinceSeeder::class,
        );
        $this->call(
            CitySeeder::class,
        );
        $this->call(GenderSeeder::class);
        $this->call(IdentityTypeSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UserSeeder::class);

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
    }
}
