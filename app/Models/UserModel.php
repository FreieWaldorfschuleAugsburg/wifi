<?php

namespace App\Models;

class UserModel
{
    public int $id;
    public string $username;
    public bool $admin;

    function __construct($id, $username, $admin)
    {
        $this->id = $id;
        $this->username = $username;
        $this->admin = $admin;
    }
}