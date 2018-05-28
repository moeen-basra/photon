<?php

namespace Photon\Foundation\Exceptions\Handler;

use Exception;
use Photon\Domains\Http\Jobs\JsonErrorResponseJob;
use Photon\Foundation\Traits\JobDispatcherTrait;
use Photon\Foundation\Traits\MarshalTrait;
use Laravel\Lumen\Exceptions\Handler;

class JsonExceptionsHandler extends Handler
{
    use MarshalTrait;
    use JobDispatcherTrait;

    /**
     * @param Exception $e
     * @throws Exception
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    public function render($request, Exception $e)
    {
        $message = $e->getMessage();
        $class = get_class($e);
        $code = $e->getCode();
        $trace = collect($e->getTrace());

        if ($request->has('filter')) {
            switch ($request->get('filter')) {
                case 'custom':
                    $trace = $trace->filter(function ($flow) {
                        return !str_contains($flow['file'], 'vendor');
                    });
                    break;
                case 'vendor':
                    $trace = $trace->filter(function ($flow) {
                        return str_contains($flow['file'], 'vendor');
                    });
                    break;
            }
        }

        if ($request->has('xdebug')) {
            dd($code, $message, $class, $trace);
        }

        return $this->run(JsonErrorResponseJob::class, [
            'message' => $message,
            'code' => $class,
            'status' => ($code < 100 || $code >= 600) ? 400 : $code,
        ]);
    }
}