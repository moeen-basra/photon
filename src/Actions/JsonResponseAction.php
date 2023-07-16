<?php

namespace Photon\Actions;

use Illuminate\Http\JsonResponse;
use Photon\Action;

class JsonResponseAction extends Action
{
    public function __construct(
        readonly private mixed  $content,
        readonly private ?int   $status = 200,
        readonly private ?array $headers = [],
        readonly private int    $options = 0
    )
    {
    }

    public function handle(): JsonResponse
    {
        $response = [
            'data' => $this->content,
            'status' => $this->status,
        ];

        return response()->json($response, $this->status, $this->headers, $this->options);
    }
}
