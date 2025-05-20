<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $landlordRole = Role::firstOrCreate(['name' => 'landlord']);
        $tenantRole = Role::firstOrCreate(['name' => 'tenant']);

        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('11111111'),
        ]);
        $admin->assignRole($adminRole);

        // Create landlord user
        $landlord = User::factory()->create([
            'name' => 'Landlord User',
            'email' => 'landlord@gmail.com',
            'password' => bcrypt('11111111'),
        ]);
        $landlord->assignRole($landlordRole);

        // Create tenant user
        $tenant = User::factory()->create([
            'name' => 'Tenant User',
            'email' => 'tenant@gmail.com',
            'password' => bcrypt('11111111'),
        ]);
        $tenant->assignRole($tenantRole);
    }
}
