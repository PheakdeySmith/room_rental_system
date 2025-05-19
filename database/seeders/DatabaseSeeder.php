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
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('11111111'),
        ]);
        $admin->assignRole('admin');

        // Create landlord user
        $landlord = User::factory()->create([
            'name' => 'Landlord User',
            'email' => 'landlord@example.com',
            'password' => bcrypt('11111111'),
        ]);
        $landlord->assignRole('landlord');

        // Create tenant user
        $tenant = User::factory()->create([
            'name' => 'Tenant User',
            'email' => 'tenant@example.com',
            'password' => bcrypt('11111111'),
        ]);
        $tenant->assignRole('tenant');
    }
}
