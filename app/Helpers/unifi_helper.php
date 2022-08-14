<?php

use App\Models\UniFiException;
use UniFi_API\Client;

/**
 * @throws UniFiException
 */
function client(): ?Client
{
    $client = new UniFi_API\Client(getenv('unifi.username'), getenv('unifi.password'), getenv('unifi.baseURL'));
    try {
        $client->login();
        return $client;
    } catch (Exception $e) {
        throw new UniFiException($e->getMessage());
    }
}