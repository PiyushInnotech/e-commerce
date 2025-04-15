<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Role::create([
            'name' => 'User',
            'description' => 'Regular user with limited access', 
        ]);

        Role::create([
            'name' => 'Seller',
            'description' => 'Seller with access to manage and sell products', 
        ]);
        //
    }
}
