<?php

namespace App\Models;

class UserModel
{
    public string $username;
    public string $displayName;
    public bool $admin;

    public array $sitesAvailable;
    public string $currentSite;

    function __construct($username, $displayName, $admin, $sitesAvailable, $currentSite)
    {
        $this->username = $username;
        $this->displayName = $displayName;
        $this->admin = $admin;
        $this->sitesAvailable = $sitesAvailable;
        $this->currentSite = $currentSite;
    }

    function getSiteName(): string
    {
        return getSiteProperty($this->currentSite, 'name');
    }
}