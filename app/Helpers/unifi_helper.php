<?php

use App\Models\AuthException;
use App\Models\UniFiException;
use CodeIgniter\HTTP\RedirectResponse;
use UniFi_API\Client;
use function App\Helpers\handleAuthException;
use function App\Helpers\isLoggedIn;
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
        throw new UniFiException();
    }

    return $client;
}

function handleUniFiException(UniFi_API\Client $client): string|RedirectResponse
{
    try {
        return redirect('login')->with('error', $client->get_last_error_message());
    } catch (AuthException $e) {
        return handleAuthException($e);
    }
}

