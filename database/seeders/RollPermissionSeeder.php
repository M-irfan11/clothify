<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RollPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // cache পরিষ্কার (গুরুত্বপূর্ণ)
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        $permissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Roles
        $admin  = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $editor = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        $user   = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Role-এ permission দেওয়া
        $admin->syncPermissions(Permission::all());
        $editor->syncPermissions(['view posts', 'create posts', 'edit posts']);
        $user->syncPermissions(['view posts']);

        // প্রথম Admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
            ]
        );
        $adminUser->assignRole('admin');
    }
}