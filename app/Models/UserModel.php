<?php

namespace App\Models;

use App\Enums\UserRole;

class UserModel
{
    public string $username;
    public string $displayName;
    public UserRole $role;

    function __construct($username, $displayName, $role)
    {
        $this->username = $username;
        $this->displayName = $displayName;
        $this->role = $role;
    }

    function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }
}