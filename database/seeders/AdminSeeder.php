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
            'email' => 'admin@admin.com', 
        ]);

        if (!$admin->exists) {
            $admin->name = 'Admin';
            $admin->password = Hash::make('123456');
            $admin->save(); 
        }

        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}
