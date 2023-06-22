<?php

use App\Models\AuthException;
use App\Models\UniFiException;
use CodeIgniter\HTTP\RedirectResponse;
use UniFi_API\Client;
use function App\Helpers\handleAuthException;
use function App\Helpers\logout;
use function App\Helpers\user;

/**
 * @throws AuthException
 */
function client(): Client
{
    $user = user();
    return new UniFi_API\Client(getenv('unifi.username'), getenv('unifi.password'), getenv('unifi.baseURL'), $user->currentSite);
}

/**
 * @throws UniFiException
 */
function connect(UniFi_API\Client $client): Client
{
    $response = $client->login();
    if (!$response) {
        throw new UniFiException('login error: ' . $response);
    }

    session()->set('unificookie', $client->get_cookie());
    return $client;
}

function handleUniFiException(UniFi_API\Client $client, UniFiException $exception): string|RedirectResponse
{
    logout();
    return redirect('login')->with('error', $exception->getMessage() . ' (' . $client->get_last_error_message() . ')');
}

