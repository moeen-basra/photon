<?php

namespace Photon\Foundation\Eloquent;

use Photon\Foundation\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class Builder extends \Illuminate\Database\Eloquent\Builder
{
    /**
     * Paginate the given query.
     *
     * @param  int $perPage
     * @param  array $columns
     * @param  string $pageName
     * @param  int|null $page
     * @param  string $dataKey
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws \InvalidArgumentException
     */
    public function paginate(
        $perPage = null,
        $columns = ['*'],
        $pageName = 'page',
        $page = null,
        $dataKey = 'data'
    )
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $perPage = $perPage ?: $this->model->getPerPage();

        $results = ($total = $this->toBase()->getCountForPagination()) ? $this->forPage($page, $perPage)->get($columns) : $this->model->newCollection();

        return $this->paginate($results, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
            'data_key' => $dataKey,
        ]);
    }
}