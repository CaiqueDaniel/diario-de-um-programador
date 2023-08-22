<?php

namespace App\Enums;

enum Roles: string
{
    case SUPER_ADMIN = 'Super Administrator';
    case ADMIN = 'Administrator';
    case VIEWER = 'Viewer';
}
