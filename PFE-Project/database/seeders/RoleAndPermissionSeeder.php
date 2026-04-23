<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'manage coach dashboard',
            'manage clients',
            'manage nutrition',
            'view client dashboard',
            'manage everything',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles and Assign Permissions
        
        // ADMIN: Can manage everything
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // CO-COACH: Can manage clients assigned to them
        $coachRole = Role::firstOrCreate(['name' => 'co-coach']);
        $coachRole->givePermissionTo([
            'manage coach dashboard',
            'manage clients',
            'manage nutrition',
        ]);

        // CLIENT: Basic access
        $clientRole = Role::firstOrCreate(['name' => 'client']);
        $clientRole->givePermissionTo(['view client dashboard']);

        // --- SEED USERS ---

        // Seed Admin
        $admin = \App\Models\User::updateOrCreate(
            ['email' => 'admin@ironcoach.com'],
            ['name' => 'Admin IronCoach', 'password' => \Illuminate\Support\Facades\Hash::make('Admin@2026')]
        );
        $admin->assignRole($adminRole);

        // Seed Coach
        $coach = \App\Models\User::updateOrCreate(
            ['email' => 'coach@ironcoach.com'],
            ['name' => 'Coach Achraf', 'password' => \Illuminate\Support\Facades\Hash::make('Coach@2026')]
        );
        $coach->assignRole($coachRole);
    }
}
