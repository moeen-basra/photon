<?php

declare(strict_types=1);

namespace MoeenBasra\Photon\Actions;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;

class JsonErrorResponseAction extends Action
{
    /**
     * @param string $message
     * @param array<string, string|array<string>>|null $errors
     * @param int $status
     * @param array<string, string>|null $headers
     * @param int|null $options
     */
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

    /**
     * parse the errors before returning
     *
     * @return array<string, string|array<string>>
     */
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
