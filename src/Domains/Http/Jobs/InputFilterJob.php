<?php

namespace MoeenBasra\Photon\Domains\Http\Jobs;

use MoeenBasra\Photon\Foundation\Job;
use MoeenBasra\Photon\Foundation\Exceptions\Exception;

class InputFilterJob extends Job
{
    protected $expectedKeys = [];

    protected $input = [];

    public function __construct(array $expectedKeys = [], array $input = [])
    {
        $this->input = $input;

        // since user can override the expected keys in child class
        // so if it is done already we don't need to update with empty here..
        if (!empty($expectedKeys)) {
            $this->expectedKeys = $expectedKeys;
        }
    }

    public function handle()
    {
        if (empty($this->input)) {
            return [];
        }

        if (empty($this->expectedKeys)) {
            throw new Exception(trans("Expected keys cannot be empty array."));
        }

        return array_only($this->input, $this->expectedKeys);
    }
}
