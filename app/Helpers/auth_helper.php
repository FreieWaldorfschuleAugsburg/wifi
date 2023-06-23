<?php

namespace App\Helpers;

use App\Models\AuthException;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use LdapRecord\Connection;
use LdapRecord\Container;
use LdapRecord\Models\ActiveDirectory\User;
use LdapRecord\Query\ObjectNotFoundException;

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
function login(string $username, string $password): void
{
    $connection = createConnection();

    try {
        $ldapUser = User::query()->where('samaccountname', '=', $username)->firstOrFail();
    } catch (ObjectNotFoundException) {
        throw new AuthException('invalidCredentials');
    }

    if (!$connection->auth()->attempt($ldapUser->getDn(), $password)) {
        throw new AuthException('invalidCredentials');
    }

    $user = createUserModel($ldapUser);
    session()->set('USER', $user->username);
    session()->set('SITE', $user->currentSite);
}

function logout(): void
{
    session()->remove('USER');
    session()->remove('SITE');
}

/**
 * @throws AuthException
 */
function user(): ?UserModel
{
    $username = session('USER');
    if (!$username) {
        return null;
    }

    createConnection();
    try {
        $ldapUser = User::query()->where('samaccountname', '=', $username)->firstOrFail();
    } catch (ObjectNotFoundException) {
        throw new AuthException('invalidCredentials');
    }

    return createUserModel($ldapUser);
}

/**
 * @throws AuthException
 */
function createUserModel(User $ldapUser): UserModel
{
    $groups = getGroups($ldapUser);
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

    $currentSite = session('SITE');
    if (!$currentSite || !in_array($currentSite, $sites)) {
        $currentSite = array_values($sites)[0];
    }

    return new UserModel($ldapUser->getAttribute('samaccountname')[0], $ldapUser->getName(), $admin, $sites, $currentSite);
}

/**
 * @throws AuthException
 */
function createConnection(): Connection
{
    $connection = new Connection([
        'hosts' => [getenv('ad.host')],
        'base_dn' => getenv('ad.baseDN'),
        'username' => getenv('ad.username'),
        'password' => getenv('ad.password')
    ]);

    Container::addConnection($connection);
    return $connection;
}

function getGroups(User $ldapUser): array
{
    $names = [];
    $groups = $ldapUser->groups()->recursive()->get();
    foreach ($groups as $group) {
        $names[] = $group->getName();
    }
    return $names;
}

function handleAuthException(AuthException $exception): RedirectResponse
{
    return redirect('login')->with('error', lang('login.error.' . $exception->getMessage()));
}
