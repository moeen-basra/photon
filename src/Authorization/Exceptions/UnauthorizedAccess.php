<?php

namespace Photon\Authorization\Exceptions;

use Exception;

class UnauthorizedAccess extends Exception
{
    public function __construct(
        $message = 'You don\'t have enough permission to access this resource',
        $code = 401,
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
