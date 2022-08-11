<?php

namespace App\Helpers;

use App\Models\UserModel;

function isLoggedIn(): bool
{
    return !is_null(user());
}

function isAdmin(): bool
{
    $user = user();
    if (is_null($user))
        return false;

    return $user->admin;
}

function userById(int $id): ?UserModel
{
    $db = db_connect('default');
    $userRow = $db->table('wifi_users')->where(['id' => $id])->select()->get()->getRow();

    return createUserModel($userRow);
}

function users(): array
{
    $db = db_connect('default');
    $result = $db->table('wifi_users')->select()->get()->getResult();

    $data = [];
    foreach ($result as $row) {
        $data[] = createUserModel($row);
    }
    return $data;
}

function user(): ?UserModel
{
    $userId = session('USER_ID');
    if (is_null($userId)) {
        return NULL;
    }

    // TODO add login expiration?

    $db = db_connect('default');
    $userRow = $db->table('wifi_users')->where(['id' => $userId])->select()->get()->getRow();
    return createUserModel($userRow);
}

function createUserModel($row): ?UserModel
{
    if (!isset($row)) {
        return NULL;
    }

    return new UserModel($row->id, $row->username, $row->admin);
}