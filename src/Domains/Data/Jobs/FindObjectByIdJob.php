<?php

namespace Photon\Domains\Data\Jobs;

use Photon\Foundation\Job;

class FindObjectByIdJob extends Job
{
    protected $model;

    protected $primaryKey;

    protected $objectId;

    public function __construct($model, int $objectId, $primaryKey = 'id')
    {
        if (is_string($model)) {
            $model = new $model;
        }

        $this->model = $model;
        $this->primaryKey = $primaryKey;
        $this->objectId = $objectId;
    }

    public function handle()
    {
        return $this->model->findOrFail($this->objectId);
    }
}
