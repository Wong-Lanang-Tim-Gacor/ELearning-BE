<?php

namespace App\Enums\Auth;

enum RolesEnum: string
{
    case STUDENTS = 'students';
    case TEACHER = 'teacher';
    case ADMIN = 'admin';
}
