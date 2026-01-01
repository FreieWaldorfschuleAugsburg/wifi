<?php

use App\Models\OAuthException;
use App\Models\UniFiException;
use CodeIgniter\HTTP\RedirectResponse;
use UniFi_API\Client;
use UniFi_API\Exceptions\CurlExtensionNotLoadedException;
use UniFi_API\Exceptions\CurlGeneralErrorException;
use UniFi_API\Exceptions\CurlTimeoutException;
use UniFi_API\Exceptions\InvalidBaseUrlException;
use UniFi_API\Exceptions\InvalidSiteNameException;
use UniFi_API\Exceptions\LoginFailedException;
use function App\Helpers\user;

/**
 * @throws OAuthException
 * @throws UniFiException
 */
function client(): Client
{
    $user = user();
    try {
        return new UniFi_API\Client(getenv('unifi.username'), getenv('unifi.password'), getenv('unifi.baseURL'), $user->currentSite);
    } catch (CurlExtensionNotLoadedException|InvalidBaseUrlException|InvalidSiteNameException $e) {
        throw new UniFiException($e->getMessage(), $e->getCode(), $e);
    }
}

/**
 * @throws UniFiException
 */
function connect(UniFi_API\Client $client): Client
{
    try {
        $client->login();
    } catch (CurlGeneralErrorException|CurlTimeoutException|LoginFailedException $e) {
        throw new UniFiException($e->getMessage(), $e->getCode(), $e);
    }

    session()->set('unificookie', $client->get_cookie());
    return $client;
}

