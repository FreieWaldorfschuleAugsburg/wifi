<?php

namespace App\Helpers;

use App\Enums\UserRole;
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
    if (is_null($user))
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
        return null;
    }

    $connection = createAdminConnection();
    return createUserModel($connection, $userName);
}

/**
 * @throws AuthException
 */
function createUserModel(Connection $ldap, string $username): UserModel
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

    $data = beautifyEntries($entries);
    $topLayerGroups = beautifyGroups($data);
    $groups = getGroupsRecursive($ldap, $domain, $topLayerGroups);

    $sites = [];
    foreach (getSites() as $site) {
        $userGroup = getSiteProperty($site, 'group');
        if (in_array($userGroup, $groups)) {
            $sites[] = $site;
        }
    }

    if (empty($sites)) {
        throw new AuthException('noPermissions');
    }

    $currentSite = session('SITE');
    if (!$currentSite || !in_array($currentSite, $sites)) {
        $currentSite = array_values($sites)[0];
        session()->set('SITE', $currentSite);
    }

    $admin = in_array(getenv('ad.adminGroup'), $groups);
    return new UserModel($username, $data['displayname'][0], $admin, $sites, $currentSite);
}

/**
 * @throws AuthException
 */
function createAdminConnection(): Connection
{
    return createConnection(getenv('ad.admin.username'), getenv('ad.admin.password'));
}

/**
 * @throws AuthException
 */
function createConnection(string $username, string $password): Connection
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

function getGroupsRecursive(Connection $ldap, string $domain, array $topLayerGroups): array
{
    $groups = $topLayerGroups;
    foreach ($topLayerGroups as $group) {
        $groupResult = @ldap_search($ldap, "dc=$domain,dc=local", "(&(objectCategory=group)(cn=$group))");
        $groupEntries = @ldap_get_entries($ldap, $groupResult);
        $data = beautifyEntries($groupEntries);
        $localGroups = beautifyGroups($data);

        if (!empty($localGroups) && array_intersect($groups, $topLayerGroups) < count($topLayerGroups)) {
            $groups[] = $localGroups;
            $groups[] = getGroupsRecursive($ldap, $domain, $localGroups);
        }
    }
    return $groups;
}

function beautifyGroups(array $data): array
{
    $groups = [];
    if (array_key_exists('memberof', $data)) {
        foreach ($data['memberof'] as $entry) {
            $groups[] = substr(explode(',', $entry)[0], 3);
        }
    }
    return $groups;
}

function beautifyEntries(array $entries): array
{
    $data = [];
    foreach ($entries[0] as $key => $value) {
        if (is_numeric($key)) continue;
        if ($key === 'count') continue;

        $data[$key] = (array)$value;
        unset($data[$key]['count']);
    }
    return $data;
}

function handleAuthException(AuthException $exception): RedirectResponse
{
    return redirect('login')->with('error', $exception->getMessage());
}
