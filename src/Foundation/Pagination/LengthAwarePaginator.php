<?php

namespace Photon\Foundation\Pagination;

class LengthAwarePaginator extends \Illuminate\Pagination\LengthAwarePaginator
{
    /**
     * @param integer $total
     * @param integer $perPage
     * @param integer $currentPage
     */
    public function __construct(
        $items,
        $total,
        $perPage,
        $currentPage,
        array $options
    )
    {
        parent::__construct($items, $total, $perPage, $currentPage, $options);
    }

    public function toArray()
    {
        return [
            'pagination' => [
                'total' => $this->total(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'next_page_url' => $this->nextPageUrl(),
                'prev_page_url' => $this->previousPageUrl(),
                'from' => $this->firstItem(),
                'to' => $this->lastItem(),
            ],
            $this->data_key => $this->items->toArray(),
        ];
    }
}