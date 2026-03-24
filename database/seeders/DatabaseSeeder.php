<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
        ]);

        $superadmin = User::firstOrCreate([
            'email' => 'admin2@gmail.com',
        ], [
            'name' => 'admin2',
            'password' => bcrypt('admin1234'),
        ]);

        $superadmin->syncRoles(['superadmin']);

        $desarrollador = User::updateOrCreate([
            'email' => 'dev1@gmail.com',
        ], [
            'name' => 'dev1',
            'password' => bcrypt('dev12345'),
        ]);

        $desarrollador->syncRoles(['desarrollador']);
    }
}

