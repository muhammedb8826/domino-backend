<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminExists = User::where('email', 'admin@domino.com')->exists();

        if (!$adminExists) {
            $admin = User::create([
                'first_name' => 'Admin',
                'middle_name' => 'Middle',
                'last_name' => 'User',
                'email' => 'admin@domino.com',
                'phone' => '1234567890',
                'joined_date' => now()->subDays(10),
                'address' => '123 Main St, City',
                'photo' => 'admin_photo.jpg',
                'is_active' => true,
                'password' => Hash::make('password'),
            ]);

            $adminRole = Role::where('name', 'admin')->first();
            if ($adminRole) {
                $admin->assignRole($adminRole);
            } else {
                $adminRole = Role::create(['name' => 'admin']);
                $admin->assignRole($adminRole);
            }
        }
    }
}
