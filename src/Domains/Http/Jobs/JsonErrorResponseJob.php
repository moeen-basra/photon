<?php

namespace MoeenBasra\Photon\Domains\Http\Jobs;

use MoeenBasra\Photon\Foundation\Job;
use Laravel\Lumen\Http\ResponseFactory;

class JsonErrorResponseJob extends Job
{
    protected $status;

    protected $content;

    protected $headers;

    protected $options;

    public function __construct($message = 'An error occurred', $code = 400, $status = 400, $headers = [], $options = 0)
    {
        $this->content = [
            'status' => $status,
            'error' => [
                'code' => $code,
                'message' => $message,
            ],
        ];
        $this->status = $status;
        $this->headers = $headers;
        $this->options = $options;
    }

    public function handle()
    {
        return response()->json($this->content, $this->status, $this->headers, $this->options);
    }
}
