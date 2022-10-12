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
        'connectedClients' => 'davon verbunden',
        'actions' => 'Aktionen',
        'delete' => "Löschen",
        'print' => 'Drucken',
        'online' => [
            'true' => 'Online',
            'false' => 'Offline'
        ],
    ],
    'confirm' => 'Möchten Sie diesen Zugang wirklich löschen?',
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
            'title' => 'Ihre Zugangsdaten',
            'username' => 'Benutzername',
            'password' => 'Passwort'
        ],
        'manual' => [
            'title' => 'Bedienungsanleitung',
            'text' => '
                <h4>1. Schritt</h4>
                <p>Begeben Sie sich in den WLAN-Bereich im zweiten Obergeschoss des großen Hauses.</p>
                <h4>2. Schritt</h4>
                <p>Verbinde Sie sich mit dem Netzwerk <b>FWA-Schüler</b>.</p>
                <h4>3. Schritt</h4>
                <p>Geben Sie nun die oben abgedruckten Zugangsdaten ein.</p>
                
                <h4>Fertig!</h4>
            '
        ],
        'terms' => [
            'title' => 'Nutzungsbedingungen',
            'text' => '
                <p>Diese Zugangsdaten dürfen nur von der oben genannten Person verwendet werden. 
                Die Weitergabe dieser Zugangsdaten an Dritte führt zum sofortigen Entzug der Nutzungsberechtigung.</p>
            '
        ]
    ]
];