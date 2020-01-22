<?php


namespace MoeenBasra\Photon\Foundation\Traits;


use Illuminate\Pagination\Paginator;
use MoeenBasra\Photon\Foundation\Pagination\LengthAwarePaginator;

/**
 * Trait BuilderTrait
 *
 * @package MoeenBasra\Photon\Foundation\Traits
 *
 * @property \MoeenBasra\Photon\Foundation\Eloquent\Model $model
 */
trait BuilderTrait
{
    public function paginate(
        $perPage = null,
        $columns = ['*'],
        $pageName = 'page',
        $page = null,
        $dataKey = 'data'
    ): LengthAwarePaginator {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $total = $this->getCountForPagination($columns);

        $results = $total ? $this->forPage($page, $perPage)->get($columns) : collect();

        return new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
            'data_key' => $dataKey,
        ]);
    }
}
