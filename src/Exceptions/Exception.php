<?php

namespace Photon\Exceptions;

use Throwable;

class Exception extends \Exception
{
    public function __construct($message = "", ?int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
