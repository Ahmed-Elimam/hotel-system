<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $receptionistRole = Role::firstOrCreate(['name' => 'receptionist']);
        $clientRole = Role::firstOrCreate(['name' => 'client']);
        $pendingClientRole = Role::firstOrCreate(['name' => 'pending-client']);

        // Create permissions
        $permissions = [
            'manage-managers',
            'manage-receptionists',
            'manage-all-receptionists',
            'manage-clients',
            'approve-clients',
            'view-my-approved-clients',
            'manage-floors',
            'manage-all-floors',
            'manage-rooms',
            'manage-all-rooms',
            'manage-reservations',
            'view-my-reservations',
            'make-reservation',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign all permissions to Admin
        $adminRole->givePermissionTo(Permission::all());

        // Assign specific permissions to Manager
        $managerRole->givePermissionTo([
            'manage-receptionists', 'manage-clients','approve-clients',
            'manage-floors', 'manage-rooms' ,'manage-reservations','view-my-approved-clients'
        ]);

        // Assign specific permissions to Receptionist
        $receptionistRole->givePermissionTo([
            'approve-clients', 'view-my-approved-clients', 'manage-reservations'
        ]);

        // Assign specific permissions to Client
        $clientRole->givePermissionTo([
            'view-my-reservations', 'make-reservation',
        ]);
    }
}

