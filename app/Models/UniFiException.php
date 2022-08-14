<?php

namespace App\Models;

use Exception;

class UniFiException extends Exception
{
    function __construct($message)
    {
        parent::__construct($message);
    }
}