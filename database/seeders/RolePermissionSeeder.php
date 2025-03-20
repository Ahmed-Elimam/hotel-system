<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        // Create permissions
        $manageManagers = Permission::create(['name' => 'manage-managers']);
        $manageReceptionists = Permission::create(['name' => 'manage-receptionists']);
        $manageAllReceptionists = Permission::create(['name' => 'manage-all-receptionists']);
        $manageClients = Permission::create(['name' => 'manage-clients']);
        $manageFloors = Permission::create(['name' => 'manage-floors']);
        $manageRooms = Permission::create(['name' => 'manage-rooms']);
        $manageReservations = Permission::create(['name' => 'manage-reservations']);

        // Assign permissions to roles
        $adminRole->givePermissionTo([$manageManagers, $manageReceptionists, $manageAllReceptionists, $manageClients, $manageFloors, $manageRooms, $manageReservations]);
        $managerRole->givePermissionTo([$manageFloors, $manageRooms, $manageReceptionists]);
        $receptionistRole->givePermissionTo([$manageClients, $manageReservations]);

    }
}
