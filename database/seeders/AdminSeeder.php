<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrNew([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('123456'),
                ]);
                if (!$admin->hasRole('admin')) {
                    $admin->assignRole('admin');
                }
    }
}
