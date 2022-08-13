<?php

namespace App\Helpers;

use App\Models\AuthException;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use LDAP\Connection;

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
    if (!$user)
        return false;

    return $user->admin;
}

/**
 * @throws AuthException
 */
function login(string $username, string $password): void
{
    $connection = createConnection($username, $password);
    createUserModel($connection, $username);
    session()->set('USER', $username);
}

function logout(): void
{
    session()->remove('USER');
}

/**
 * @throws AuthException
 */
function user(): ?UserModel
{
    $userName = session('USER');
    if (!$userName) {
        throw new AuthException();
    }

    $connection = createAdminConnection();
    return createUserModel($connection, $userName);
}

/**
 * @throws AuthException
 */
function createUserModel(Connection $ldap, string $username): ?UserModel
{
    $domain = getenv('ad.domain');
    $result = @ldap_search($ldap, "dc=$domain,dc=local", "(sAMAccountName=$username)");
    if (!$result)
        throw new AuthException('userGone');

    $entries = @ldap_get_entries($ldap, $result);
    if (!$entries)
        throw new AuthException('userGone');

    // Assuming that the user was disabled or deleted since last login
    if (!isset($entries['count']) || $entries['count'] !== 1)
        throw new AuthException('userGone');

    // Beautify data
    $data = [];
    foreach ($entries[0] as $key => $value) {
        if (is_numeric($key)) continue;
        if ($key === 'count') continue;

        $data[$key] = (array)$value;
        unset($data[$key]['count']);
    }

    // Check groups memberships
    $adminGroup = getenv('ad.adminGroup');
    $userGroup = getenv('ad.userGroup');
    $admin = false;
    $user = false;
    foreach ($data['memberof'] as $value) {
        if (str_contains($value, "CN=$adminGroup")) {
            $admin = true;
        } else if (str_contains($value, "CN=$userGroup")) {
            $user = true;
        }
    }

    // Cancel if user is neither member of the admin nor the user group
    if (!$admin && !$user) {
        throw new AuthException('noPermissions');
    }

    return new UserModel($username, $data['displayname'][0], $admin);
}

/**
 * @throws AuthException
 */
function createAdminConnection(): ?Connection
{
    return createConnection(getenv('ad.admin.username'), getenv('ad.admin.password'));
}

/**
 * @throws AuthException
 */
function createConnection(string $username, string $password): ?Connection
{
    $ldap = @ldap_connect(getenv('ad.ldap'));
    if (!$ldap)
        throw new AuthException('noConnection');

    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

    // Log in as domain user
    $domain = getenv('ad.domain');
    $bind = @ldap_bind($ldap, "$domain\\$username", $password);
    if (!$bind)
        throw new AuthException('invalidCredentials');

    return $ldap;
}

function handleAuthException(AuthException $exception): RedirectResponse
{
    return redirect('login')->with('error', $exception->getMessage());
}
