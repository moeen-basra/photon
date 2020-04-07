<?php

namespace Photon\Foundation\Pagination;

class LengthAwarePaginator extends \Illuminate\Pagination\LengthAwarePaginator
{
    public function __construct(
        $items,
        $total,
        $perPage,
        $currentPage,
        array $options
    ) {
        parent::__construct($items, $total, $perPage, $currentPage, $options);
    }

    public function toArray()
    {
        return [
            'pagination' => [
                'current_page' => $this->currentPage(),
                'first_page_url' => $this->url(1),
                'from' => $this->firstItem(),
                'last_page' => $this->lastPage(),
                'last_page_url' => $this->url($this->lastPage()),
                'next_page_url' => $this->nextPageUrl(),
                'path' => $this->path,
                'per_page' => $this->perPage(),
                'prev_page_url' => $this->previousPageUrl(),
                'to' => $this->lastItem(),
                'total' => $this->total(),
            ],
            $this->data_key => $this->items->toArray(),
        ];
    }
}
