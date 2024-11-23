<?php

namespace Database\Seeders;

use App\Enums\Auth\RolesEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Role::create(['name' => RolesEnum::STUDENTS->value]);
        Role::create(['name' => RolesEnum::TEACHER->value]);
        Role::create(['name' => RolesEnum::ADMIN->value]);
    }
}
