<?php

use LdapRecord\Connection;
use LdapRecord\Container;
use LdapRecord\Models\ActiveDirectory\Group;
use LdapRecord\Models\ActiveDirectory\User;

function getAllStudents(): array
{
    createConnection();
    $users = User::query()->setBaseDn(getenv('ad.studentDN'))->get()->toArray();

    usort($users, function ($a, $b) {
        return strcmp($a['cn'][0], $b['cn'][0]);
    });

    return $users;
}

function getActiveStudents(): array
{
    createConnection();
    $group = Group::find(getenv('ad.studentGroup'));
    return $group->members()->get()->toArray();
}

function addStudent(string $username): void
{
    createConnection();
    $user = User::where('samaccountname', $username)->first();
    $group = Group::find(getenv('ad.studentGroup'));

    $group->members()->attach($user);
}

function removeStudent(string $username): void
{
    createConnection();
    $user = User::where('samaccountname', $username)->first();
    $group = Group::find(getenv('ad.studentGroup'));

    $group->members()->detach($user);
}

function createConnection(): Connection
{
    $connection = new Connection([
        'hosts' => [getenv('ad.host')],
        'base_dn' => getenv('ad.baseDN'),
        'username' => getenv('ad.username'),
        'password' => getenv('ad.password'),
    ]);

    Container::addConnection($connection);
    return $connection;
}