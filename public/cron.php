<?php

include '../vendor/autoload.php';

$unifi = new UniFi_API\Client(getenv('unifi.username'), getenv('unifi.password'), getenv('unifi.baseURL'));
$unifi->login();

$clients = $unifi->list_clients();
$students = $unifi->list_radius_accounts();

echo '<pre>';
echo print_r($clients);
echo '</pre>';

foreach ($clients as $client) {
    if (property_exists($client, '1x_identity')) {
        $identity = $client->{'1x_identity'};

        foreach ($students as $student) {
            if ($student->name === $identity) {

            }
        }
    }
}