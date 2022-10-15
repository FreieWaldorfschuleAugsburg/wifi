<?php

return [
    'create' => [
        'title' => 'Create student',
        'name' => 'First and last name',
        'print' => 'Print immediately',
        'button' => 'Create'
    ],
    'created' => 'Access created!',
    'list' => [
        'title' => 'All students',
        'username' => 'Username',
        'password' => 'Password',
        'clients' => 'Devices',
        'actions' => 'Actions',
        'delete' => "Delete",
        'print' => 'Print',
        'online' => [
            'true' => 'Online',
            'false' => 'Offline'
        ],
        'noDevices' => 'No devices'
    ],
    'error' => [
        'title' => 'Error!',
        'unknown' => 'An unknown error has occurred.',
        'deleted' => 'Your access was already deleted.',
        'disconnected' => '%s clients(s) were successfully disconnected! %s client(s) could not be disconnected.',
        'alreadyExistent' => 'This student already exists.'
    ],
    'info' => [
        'title' => 'Info!',
        'disconnected' => '%s client(s) were successfully disconnected!'
    ],
    'print' => [
        'subtitle' => 'student credentials',
        'credentials' => [
            'title' => 'Your credentials',
            'username' => 'Username',
            'password' => 'Password'
        ],
        'manual' => [
            'title' => 'Setup guide',
            'text' => '
                <p>
                <b>1st step</b>
                Go to the Wi-Fi area (e.g. 2nd floor in the Großes Haus)</br>
                <b>2nd step</b>
                Connect with the SSID "FWA-Schüler".
                <b>3rd step</b>
                Now enter the credentials printed above.                
                </p>
            '
        ],
        'terms' => [
            'title' => 'Terms of use',
            'text' => '
                <p>These credentials may only be used by the person named above. 
                The disclosure of said credentials to third parties will result in the immediate revocation of the authorization to use the service.
                A detailed list of all terms and conditions can be found in the Wi-Fi contract.</p>
            '
        ]
    ]
];