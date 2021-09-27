<?php

namespace Photon\Exceptions;

use Throwable;
use Photon\Bus\MarshalTrait;
use Photon\Bus\UnitDispatcherTrait;
use Photon\Domains\Http\Jobs\JsonErrorResponseJob;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use MarshalTrait;
    use UnitDispatcherTrait;

    public function render($request, Throwable $e)
    {
        $message = $e->getMessage();
        $class = get_class($e);
        $code = $e->getCode();

        if ($request->expectsJson()) {
            return $this->run(JsonErrorResponseJob::class, [
                'message' => $message,
                'code' => $class,
                'status' => ($code < 100 || $code >= 600) ? 400 : $code,
            ]);
        }

        parent::render($request, $e);
    }
}
