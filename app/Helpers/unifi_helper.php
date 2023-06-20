<?php

use App\Models\AuthException;
use App\Models\UniFiException;
use UniFi_API\Client;
use function App\Helpers\user;

/**
 * @throws AuthException|UniFiException
 */
function client(): ?Client
{
    $user = user();
    $client = new UniFi_API\Client(getenv('unifi.username'), getenv('unifi.password'), getenv('unifi.baseURL'), $user->currentSite);
    try {
        $client->login();
        return $client;
    } catch (Exception $e) {
        throw new UniFiException($e->getMessage());
    }
}

