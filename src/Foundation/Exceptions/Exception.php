<?php

namespace Photon\Foundation\Exceptions;

use Illuminate\Validation\Validator;

class Exception extends \Exception
{
    public function __construct(?$message = "", ?int $code = 400, ?\Throwable $previous = null)
    {
        if ($message instanceof Validator) {
            $message = \json_encode(\array_merge($message->messages()->toArray(), ['PhotonInputException' => true]));
        }

        parent::__construct($message, $code, $previous);
    }
}