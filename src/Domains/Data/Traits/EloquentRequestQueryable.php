<?php

namespace Photon\Domains\Data\Traits;

use Exception;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Builder;
use Photon\Foundation\Http\Request;
use Photon\Foundation\Eloquent\Model;
use Photon\Foundation\Http\RequestSort;
use Photon\Foundation\Http\RequestFilter;
use Illuminate\Database\Eloquent\Relations\Relation;
use Photon\Foundation\Http\RequestRelationField;
use Photon\Foundation\Http\RequestSortCollection;
use Photon\Foundation\Http\RequestFieldCollection;
use Photon\Foundation\Http\RequestFilterCollection;
use Photon\Foundation\Http\RequestRelationFieldCollection;

trait EloquentRequestQueryable
{
    protected $model;

    private $perPage;

    private $fields;

    private $filters;

    private $sorting;

    private $relations;

    private $relationInstance = false;

    private $relationName = null;

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        if (is_string($model)) {
            $model = new $model;
        }
        $this->model = $model;
    }

    public function getRelations()
    {
        return $this->relations;
    }

    protected function setRelations(RequestRelationFieldCollection $relations)
    {
        $this->relations = $relations;
    }

    public function isRelationInstance()
    {
        return $this->relationInstance;
    }

    public function getRelationName()
    {
        return $this->relationName;
    }

    public function captureRequestQuery(Request $request)
    {

        if (!$this->getModel()) {
            throw new Exception('No model set to use for query');
        }

        $this->setFields($request->getFields());
        $this->setFilters($request->getFilters());
        $this->setRelations($request->getRelations());
        $this->setSorting($request->getSort());
        $this->setPerPage($request->getPerPage());

        return true;
    }

    /**
     * returns pagination result
     *
     * @param string $dataKey
     * @param              $results
     *
     * @return mixed
     */
    public function paginateResult($results, $dataKey = 'data')
    {
        return $results->paginate($this->getPerPage(), ['*'], $pageName = 'page', $page = null, $dataKey);
    }

    public function getPerPage()
    {
        return $this->perPage;
    }

    protected function setPerPage(int $perPage = 25)
    {
        $this->perPage = $perPage;
    }

    /**
     * @return RequestFieldCollection|null
     */
    public function getFields()
    {
        return $this->fields;
    }

    protected function setFields(RequestFieldCollection $fields)
    {
        $this->fields = $fields;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    protected function setFilters(RequestFilterCollection $filters)
    {
        $this->filters = $filters;
    }

    public function getSorting()
    {
        return $this->sorting;
    }

    protected function setSorting(RequestSortCollection $sort)
    {
        $this->sorting = $sort;
    }

    protected function buildQuery()
    {
        if ($this->getModel() instanceof Model) {
            $queryBuilder = $this->getModel()->newQuery();
        } elseif ($this->getModel() instanceof Relation) {
            $this->relationName = $this->getModel()->getRelated()->getTable();
            $this->relationInstance = true;
            $queryBuilder = $this->getModel()->getQuery();
        } elseif ($this->getModel() instanceof \Photon\Foundation\Eloquent\Builder) {
            $queryBuilder = $this->getModel();
        } else {
            throw new InvalidArgumentException('Invalid Model/Builder/Relation supplied');
        }

        $this->appendSelect($queryBuilder);
        $this->appendFilters($queryBuilder);
        $this->appendRelations($queryBuilder);
        $this->appendSort($queryBuilder);

        return $queryBuilder;
    }

    protected function appendSelect(Builder $builder)
    {
        $selectFields = [];

        if (!$this->getFields()->count() > 0) {
            $builder->select(['*']);

            return true;
        }

        foreach ($this->getFields() as $field) {
            array_push($selectFields, $field->getName());
        }

        $builder->select($selectFields);

        return true;
    }

    protected function appendFilters(Builder $builder)
    {
        if (!$this->getFilters()->count() > 0) {
            return true;
        }

        /*** @var $filter RequestFilter */
        foreach ($this->getFilters() as $filter) {
            // Handle relational filters
            if ($filter->getField()->isRelational()) {
                // Handle non-relational direct filters
                $builder->whereHas($filter->getField()->getRelationName(), function ($query) use ($filter) {
                    $this->applyClause($query, $filter);
                });
            } else {
                $this->applyClause($builder, $filter);
            }
        }

        return true;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $builder
     * @param $filter
     */
    protected function applyClause($builder, RequestFilter $filter)
    {
        $filterField = $filter->getField();
        if ($filterField->isRelational()) {
            $fieldNamePrefix = Arr::last($filterField->getRelationFragments()) . '.';
        } else {
            $fieldNamePrefix = $this->isRelationInstance() ? $this->getRelationName() . '.' : '';
        }

        $fieldName = $fieldNamePrefix . $filterField->getName();
        if (is_array($filter->getFilterValue())) {
            $not = false;
            if ($filter->getCompareSymbol() == '!=') {
                $not = true;
            }
            $builder->whereIn($fieldName, $filter->getFilterValue(), 'and', $not);
        } elseif (strtolower($filter->getFilterValue()) == 'null') {
            $not = false;
            if ($filter->getCompareSymbol() == '!=') {
                $not = true;
            }
            $builder->whereNull($fieldName, 'and', $not);
        } else {
            $builder->where($fieldName, $filter->getCompareSymbol(), $filter->getFilterValue());
        }
    }

    protected function appendSort(Builder $builder)
    {
        if (!$this->getSorting()->count() > 0) {
            return true;
        }

        /*** @var RequestSort $sort */
        foreach ($this->getSorting() as $sort) {
            // Handle relational filters
            if ($sort->getField()->isRelational()) {
                // Handle non-relational direct filters
                $builder->where($sort->getField()->getRelationName(), function ($query) use ($sort) {
                    $query->orderBy($sort->getField()->getName(), $sort->getDirection());
                });
            } else {
                $builder->orderBy($sort->getField()->getName(), $sort->getDirection());
            }
        }

        return true;
    }

    protected function appendRelations(Builder $builder)
    {
        if (!$this->getRelations()->count() > 0) {
            return true;
        }

        /** @var RequestRelationField $relation */
        foreach ($this->getRelations() as $relation) {
            if ($relation->isRelational()) {
                $relationName = $relation->getRelationName()/*.'.'.$relation->getName()*/
                ;
            } else {
                $relationName = $relation->getName();
            }

            $builder->with([
                $relationName => function ($query) use ($relation, $relationName) {
                    $referencedTableName = $query->getRelated()->getTable();
                    if ($relation->hasSubFields()) {
                        $subFields = array_map(function ($subField) use ($relationName, $referencedTableName) {
                            return $referencedTableName . '.' . $subField->getName();
                        }, iterator_to_array($relation->getSubFields()));
                        $select = array_merge($subFields);
                    } else {
                        $select = [$referencedTableName . '.*'];
                    }

                    $query->select($select);
                },
            ]);
        }

        return true;
    }
}
