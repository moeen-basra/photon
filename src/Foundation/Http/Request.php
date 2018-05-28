<?php

namespace Photon\Foundation\Http;

class Request extends \Illuminate\Http\Request
{
    protected $comparisonSymbols = [':', '=', '<', '>', '<=', '>=', '!='];

    /**
     * Intersect an array of items with the input data (EMPTY VALUES INCLUDED).
     *
     * @param  array|mixed $keys
     *
     * @return array
     */
    public function expect($keys)
    {
        $all  = $this->request->all();
        $only = $this->only(is_array($keys) ? $keys : func_get_args());

        $results = [];

        foreach ($only as $k => $v) {
            if (array_key_exists($k, $all)) {
                $results[$k] = $v;
            }
        }

        return $results;
    }

    /**
     * Get Request Fields
     *
     * @return \Awok\Foundation\Http\RequestFieldCollection|null
     */
    public function getFields()
    {

        $requestFieldsCollection = new RequestFieldCollection();

        if (! $this->has('fields')) {
            return $requestFieldsCollection;
        }
        $fields = $this->get('fields');

        foreach (array_filter(explode(',', $fields)) as $field) {
            $requestFieldsCollection->attach(new RequestField($field));
        }

        return $requestFieldsCollection;
    }

    /**
     * Get Request Filters
     *
     * @return \Awok\Foundation\Http\RequestFilterCollection
     */
    public function getFilters()
    {
        $requestFilterCollection = new RequestFilterCollection();

        if (! $this->has('q')) {
            return $requestFilterCollection;
        }

        $filters = array_filter(explode(',', $this->get('q')));

        foreach ($filters as $filter) {
            $requestFilterCollection->attach(new RequestFilter($filter));
        }

        return $requestFilterCollection;
    }

    /**
     *  Get Request sort fields
     *
     * @return \Awok\Foundation\Http\RequestSortCollection
     */
    public function getSort()
    {
        $requestSortCollection = new RequestSortCollection();

        if (! $this->has('sort')) {
            return $requestSortCollection;
        }

        $sorts = array_filter(explode(',', $this->get('sort')));

        foreach ($sorts as $sort) {
            $requestSortCollection->attach(new RequestSort($sort));
        }

        return $requestSortCollection;
    }

    /**
     * Get Request Relations
     *
     * @return \Awok\Foundation\Http\RequestRelationFieldCollection
     */
    public function getRelations()
    {
        $requestRelationFieldCollection = new RequestRelationFieldCollection();

        if (! $this->has('with')) {
            return $requestRelationFieldCollection;
        }

        $relations = array_filter(explode(',', $this->get('with')));

        foreach ($relations as $relation) {
            $requestRelationFieldCollection->attach(new RequestRelationField($relation));
        }

        return $requestRelationFieldCollection;
    }

    /**
     * Returns the pagination limit
     *
     * @return int|null
     */
    public function getPerPage()
    {
        if ($this->has('limit')) {
            return $this->get('limit');
        }

        if ($this->has('per_page')) {
            return $this->get('per_page');
        }

        return config('pagination.limit', 20);
    }
}