<?php

namespace MoeenBasra\Photon\Actions;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;

class JsonErrorResponseAction extends Action
{
    public function __construct(
        readonly private string $message = 'Oops, something went wrong!',
        readonly private ?array $errors = [],
        readonly private int    $status = Response::HTTP_BAD_REQUEST,
        readonly private ?array $headers = [],
        readonly private ?int   $options = 0,
    )
    {
    }

    public function handle(ResponseFactory $factory): JsonResponse
    {
        $response = [
            'error' => $this->prepareError(),
            'status' => $this->status,
        ];

        return $factory->json($response, $this->status, $this->headers, $this->options);
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
