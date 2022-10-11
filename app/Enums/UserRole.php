<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'WifiAdmin';
    case USER = 'WifiUser';
}