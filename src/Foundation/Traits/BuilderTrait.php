<?php


namespace Photon\Foundation\Traits;


use Illuminate\Pagination\Paginator;
use Photon\Foundation\Pagination\LengthAwarePaginator;

trait BuilderTrait
{
    public function paginate(
        $perPage = null,
        $columns = ['*'],
        $pageName = 'page',
        $page = null,
        $dataKey = 'data'
    ): LengthAwarePaginator
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $perPage = $perPage ?: $this->model->getPerPage();

        $results = ($total = $this->toBase()->getCountForPagination()) ? $this->forPage($page, $perPage)->get($columns) : $this->model->newCollection();

        return new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
            'data_key' => $dataKey,
        ]);
    }
}
