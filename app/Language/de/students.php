<?php

return [
    'create' => [
        'title' => 'Schüler*in anlegen',
        'name' => 'Vor- und Nachname',
        'print' => 'Sofort drucken',
        'button' => 'Anlegen'
    ],
    'created' => 'Zugang angelegt!',
    'list' => [
        'title' => 'Alle Schüler*innen',
        'username' => 'Benutzername',
        'password' => 'Passwort',
        'clients' => 'Geräte',
        'actions' => 'Aktionen',
        'delete' => "Löschen",
        'print' => 'Drucken',
        'online' => [
            'true' => 'Online',
            'false' => 'Offline'
        ],
        'noDevices' => 'Keine Geräte'
    ],
    'error' => [
        'title' => 'Fehler!',
        'unknown' => 'Ein unbekannter Fehler ist aufgetreten.',
        'deleted' => 'Der Zugang wurde bereits gelöscht.',
        'disconnected' => '%s Client(s) wurden erfolgreich getrennt! %s Client(s) konnten jedoch nicht getrennt werden.',
        'alreadyExistent' => 'Diese/r Schüler/in existiert bereits.'
    ],
    'info' => [
        'title' => 'Info!',
        'disconnected' => '%s Client(s) wurden erfolgreich getrennt!'
    ],
    'print' => [
        'subtitle' => 'Schülerzugangsdaten',
        'credentials' => [
            'title' => 'Deine Zugangsdaten',
            'username' => 'Benutzername',
            'password' => 'Passwort'
        ],
        'manual' => [
            'title' => 'Einrichtungsanleitung',
            'text' => '
                <p>
                <b>1. Schritt</b>
                Begib dich in einen WLAN-Bereich (z.B. 2. OG im Großen Haus).</br>
                <b>2. Schritt</b>
                Verbinde dich mit der SSID "FWA-Schüler".
                <b>3. Schritt</b>
                Gib nun die oben abgedruckten Zugangsdaten ein.
                </p>
            '
        ],
        'terms' => [
            'title' => 'Nutzungsbedingungen',
            'text' => '
                <p>Diese Zugangsdaten dürfen nur von der oben genannten Person verwendet werden. 
                Die Weitergabe dieser Zugangsdaten an Dritte führt zum sofortigen Entzug der Nutzungsberechtigung.
                Eine genaue Auflistung aller Bestimmungen findest du im WLAN-Vertrag.</p>
            '
        ]
    ]
];