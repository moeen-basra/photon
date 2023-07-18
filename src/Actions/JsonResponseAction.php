<?php

namespace MoeenBasra\Photon\Actions;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;

class JsonResponseAction extends Action
{
    /**
     * @param mixed $content
     * @param int|null $status
     * @param array<string, string>|null $headers
     * @param int|null $options
     */
    public function __construct(
        readonly private mixed  $content,
        readonly private ?int   $status = Response::HTTP_OK,
        readonly private ?array $headers = [],
        readonly private ?int   $options = 0,
    )
    {
    }

    public function handle(ResponseFactory $factory): JsonResponse
    {
        $response = [
            'data' => $this->content,
            'status' => $this->status,
        ];

        return $factory->json($response, $this->status, $this->headers, $this->options);
    }

}
