<?php

namespace App\Models;

class UserModel
{
    public string $username;
    public string $displayName;
    public bool $admin;

    function __construct($username, $displayName, $admin)
    {
        $this->username = $username;
        $this->displayName = $displayName;
        $this->admin = $admin;
    }
}