<?php

function isStudentEnabled(string $site): bool
{
    return getSiteProperty($site, 'students');
}

function isVoucherEnabled(string $site): bool
{
    return getSiteProperty($site, 'voucher');
}

function getSiteProperty(string $site, string $property): bool|array|string
{
    return getenv('unifi.site.' . $site . '.' . $property);
}

function getSites(): array
{
    return explode(",", getenv('unifi.sites'));
}