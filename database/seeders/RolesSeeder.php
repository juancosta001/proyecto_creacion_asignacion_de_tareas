<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'product_manager']);
        Role::create(['name' => 'developer']);
        Role::create(['name' => 'designer']);
        Role::create(['name' => 'qa']);
        
    }
}
