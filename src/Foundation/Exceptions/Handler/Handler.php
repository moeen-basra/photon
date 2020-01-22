<?php

namespace MoeenBasra\Photon\Foundation\Exceptions\Handler;

use Exception;
use MoeenBasra\Photon\Foundation\Traits\MarshalTrait;
use MoeenBasra\Photon\Foundation\Traits\JobDispatcherTrait;
use MoeenBasra\Photon\Domains\Http\Jobs\JsonErrorResponseJob;

class Handler extends \Illuminate\Foundation\Exceptions\Handler
{
    use MarshalTrait;
    use JobDispatcherTrait;

    /**
     * @param Exception $e
     *
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
