<?php

namespace App\Models;

use Exception;

class AuthException extends Exception
{
    function __construct($message = '')
    {
        parent::__construct($message);
    }
}