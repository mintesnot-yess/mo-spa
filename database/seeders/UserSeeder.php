<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $user =  User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'phone' => '0987676545',
            'password' => Hash::make('password'), // Hash the password
        ]);
        $role = Role::findOrCreate('Super Admin', 'web');
        $user->syncRoles($role);
        // Example: Creating multiple users using Faker
        // User::factory(10)->create(); // Ensure a UserFactory exists for generating random user data
    }
}
