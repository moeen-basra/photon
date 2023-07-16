<?php

namespace Photon\Actions;

use Illuminate\Http\JsonResponse;
use Photon\Action;

class JsonErrorResponseAction extends Action
{
    public function __construct(
        readonly private string $message = 'Oops, something went wrong!',
        readonly private ?array $errors = null,
        readonly private int    $status = 400,
        readonly private array  $headers = [],
        readonly private int    $options = 0
    )
    {
    }

    public function handle(): JsonResponse
    {
        $data = [
            'error' => $this->prepareError(),
            'status' => $this->status,
        ];
        return response()->json($data, $this->status, $this->headers, $this->options);
    }

    private function prepareError(): array
    {
        $error = [
            'message' => $this->message
        ];

        if ($this->errors) {
            $error['errors'] = $this->errors;
        }

        return $error;
    }
}
