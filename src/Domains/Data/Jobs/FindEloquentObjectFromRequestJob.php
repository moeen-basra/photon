<?php

namespace Photon\Domains\Data\Jobs;

use Photon\Foundation\Job;
use Photon\Foundation\Http\Request;
use Photon\Foundation\Http\RequestFilterCollection;
use Photon\Domains\Data\Traits\EloquentRequestQueryable;

class FindEloquentObjectFromRequestJob extends Job
{
    use EloquentRequestQueryable;

    protected $model;

    protected $primaryKey;

    protected $objectId;

    public function __construct($model, $objectId, $primaryKey = 'id')
    {
        $this->model = $model;
        $this->primaryKey = $primaryKey;
        $this->objectId = $objectId;
    }

    public function handle(Request $request)
    {
        $this->setModel($this->model);
        $this->captureRequestQuery($request);
        // Filtering is not allowed in case of single object queries
        $this->setFilters(new RequestFilterCollection());
        $result = $this->buildQuery()->where($this->primaryKey, '=', $this->objectId);

        return $result->firstOrFail();
    }
}
