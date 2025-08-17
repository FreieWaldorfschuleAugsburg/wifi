<?php

namespace App\Models;

class UserModel
{
    public string $username;
    public string $displayName;
    public string $idToken;
    public string $refreshToken;
    public bool $admin;

    public array $sitesAvailable;
    public string $currentSite;

    function __construct($username, $displayName, $idToken, $refreshToken, $admin, $sitesAvailable, $currentSite)
    {
        $this->username = $username;
        $this->displayName = $displayName;
        $this->idToken = $idToken;
        $this->refreshToken = $refreshToken;
        $this->admin = $admin;
        $this->sitesAvailable = $sitesAvailable;
        $this->currentSite = $currentSite;
    }

    function getSiteName(): string
    {
        return getSiteProperty($this->currentSite, 'name');
    }
}