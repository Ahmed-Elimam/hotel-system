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
        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);
        $receptionistRole = Role::create(['name' => 'receptionist']);
        $clientRole = Role::create(['name' => 'client']);
        $pendingClientRole = Role::create(['name' => 'pending-client']);

        // Create permissions
        $permissions = [
            'manage-managers',
            'manage-receptionists',
            'manage-all-receptionists',
            'manage-clients',
            'approve-clients',
            'view-my-approved-clients',
            'manage-floors',
            'manage-rooms',
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
            'manage-receptionists', 'view-all-clients', 'manage-clients','approve-clients',
            'manage-floors', 'manage-rooms'
        ]);
        
        // Assign specific permissions to Receptionist
        $receptionistRole->givePermissionTo([
            'approve-clients', 'view-my-approved-clients', 'manage-reservations'
        ]);

        // Assign specific permissions to Client
        $clientRole->givePermissionTo([
            'view-my-reservations', 'make-reservation'
        ]);
    }
}
