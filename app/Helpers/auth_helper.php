<?php

namespace App\Helpers;

use App\Controllers\BaseController;
use App\Models\AuthException;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use Exception;
use Jumbojett\OpenIDConnectClient;
use Jumbojett\OpenIDConnectClientException;

/**
 * @throws AuthException
 */
function isLoggedIn(): bool
{
    return !is_null(user());
}

/**
 * @throws AuthException
 */
function isAdmin(): bool
{
    $user = user();
    if (is_null($user))
        return false;

    return $user->admin;
}

/**
 * @throws AuthException
 */
function login(): RedirectResponse
{
    $oidc = createOIDC();

    try {
        $oidc->authenticate();

        $username = $oidc->requestUserInfo('preferred_username');
        $name = $oidc->requestUserInfo('name');
        $claims = $oidc->getVerifiedClaims();
        $groups = property_exists($claims, "groups") ? $oidc->getVerifiedClaims()->groups : [];

        $userModel = createUserModel($username, $name, $oidc->getIdToken(), $oidc->getRefreshToken(), $groups);
        session()->set('USER', $userModel);

        return redirect('/');
    } catch (OpenIDConnectClientException $e) {
        throw new AuthException("oidc_login_error", $e);
    }
}

/**
 * @throws AuthException
 */
function logout(): RedirectResponse
{
    $oidc = createOIDC();

    try {
        $user = user();
        session()->remove('USER');

        $oidc->signOut($user->idToken, null);
    } catch (OpenIDConnectClientException $e) {
        throw new AuthException("oidc_logout_error", $e);
    }

    return redirect('/');
}

/**
 * @throws AuthException
 */
function user(): ?UserModel
{
    $oidc = createOIDC();
    $user = session('USER');
    if (!$user) {
        return null;
    }

    $refreshToken = $user->refreshToken;

    try {
        $response = $oidc->introspectToken($refreshToken, 'refresh_token', $oidc->getClientID(), $oidc->getClientSecret());
        if (!$response->active)
            return null;

        // TODO update user

        return $user;
    } catch (Exception $e) {
        throw new AuthException("oidc_refresh_error", $e);
    }
}

/**
 * @throws AuthException
 */
function createUserModel(string $username, string $displayName, string $idToken, string $refreshToken, array $groups): UserModel
{
    $admin = in_array(getenv('ad.adminGroup'), $groups);

    $sites = [];
    if ($admin) {
        $sites = getSites();
    } else {
        foreach (getSites() as $site) {
            $userGroup = getSiteProperty($site, 'group');
            if (in_array($userGroup, $groups)) {
                $sites[] = $site;
            }
        }
    }

    if (empty($sites)) {
        throw new AuthException('noPermissions');
    }

    $currentSite = array_values($sites)[0];
    return new UserModel($username, $displayName, $idToken, $refreshToken, $admin, $sites, $currentSite);
}

function createOIDC(): OpenIDConnectClient
{
    return new OpenIDConnectClient(
        getenv('oidc.endpoint'),
        getenv('oidc.clientId'),
        getenv('oidc.clientSecret')
    );
}

function handleAuthException(BaseController $controller, AuthException $exception): string
{
    $error = lang('loginError.' . $exception->getMessage());

    if ($exception->getPrevious()) {
        $error = $error . ' (' . $exception->getPrevious()->getMessage() . ')';
    }

    // Exception can be ignored
    return $controller->render('LoginErrorView', ['error' => $error], false);
}
