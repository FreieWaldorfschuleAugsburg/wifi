<?php

use UniFi_API\Client;

function client(): ?Client
{
    $client = new UniFi_API\Client(getenv('unifi.username'), getenv('unifi.password'), getenv('unifi.baseURL'));
    $client->login();
    return $client;
}