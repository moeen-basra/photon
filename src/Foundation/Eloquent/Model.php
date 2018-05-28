<?php

namespace Photon\Foundation\Eloquent;

class Model extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \Photon\Foundation\Eloquent\Builder
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    /**
     * @param integer|null $limit
     * @param string $dataKey
     * @param $results
     *
     * @return mixed
     */
    protected function paginateResult(?int $limit, string $dataKey, Builder $results)
    {
        // Paginate
        $limit = is_null($limit) ? config('pagination.limit', 20) : $limit;

        return $results->paginate($limit, ['*'], $pageName = 'page', $page = null, $dataKey);
    }
}