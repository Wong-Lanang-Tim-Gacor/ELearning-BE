<?php

namespace Database\Seeders;

use App\Enums\Auth\RolesEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(User::all() as $user){
            $user->assignRole(RolesEnum::STUDENTS);
        }
    }
}
