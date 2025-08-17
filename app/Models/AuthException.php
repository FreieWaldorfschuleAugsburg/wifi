<?php

namespace App\Models;

use Exception;

class AuthException extends Exception
{
    function __construct($message = '', $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}