<?php

namespace App\Models;

use Exception;

class UniFiException extends Exception
{
    function __construct($message = '', $code = 0, Exception $previous = null)
    {
        parent::__construct($message);
    }


}