<?php


namespace MoeenBasra\Photon\Foundation\Traits;


use MoeenBasra\Photon\Foundation\Eloquent\Builder;

trait ModelTrait
{
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    protected function paginateResult($limit, $dataKey, $results)
    {
        $limit = is_null($limit) ? config('pagination.limit', 20) : $limit;

        return $results->paginate($limit, ['*'], $pageName = 'page', $page = null, $dataKey);
    }
}
