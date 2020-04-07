<?php

namespace Photon\Foundation\Http;

use InvalidArgumentException;

/**
 * Class RequestSort
 *
 * @package Photon\Foundation\Http
 */
class RequestSort
{
    /**
     * @var string
     */
    private $rawSort;

    /**
     * @var RequestField
     */
    private $field;

    /**
     * @var string
     */
    private $direction = 'desc';

    /**
     * RequestSort constructor.
     *
     * @param $sort
     */
    public function __construct($sort)
    {
        $this->setSort($sort);
    }

    /**
     * Return the request sort field instance
     *
     * @return \Photon\Foundation\Http\RequestField
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Instantiate the field object of the sort request
     *
     * @param $fieldName
     *
     * @return bool
     */
    protected function setField($fieldName)
    {
        $this->field = new RequestField($fieldName);

        return true;
    }

    /**
     * Get the direction of the sorting (asc/desc)
     *
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Set the direction of the sorting (asc/desc)
     *
     * @param $direction
     *
     * @return bool
     */
    protected function setDirection($direction)
    {
        $this->direction = $direction;

        return true;
    }

    /**
     * Get the taw text representation of the request sort field
     *
     * @return string
     */
    public function getRawSort()
    {
        return $this->rawSort;
    }

    /**
     * Sets the sort request field
     *
     * @param $sort
     *
     * @return bool
     * @throws  \InvalidArgumentException
     */
    protected function setSort($sort)
    {
        if (!$this->validateSort($sort)) {
            throw new InvalidArgumentException("Invalid request sort field {$sort} supplied");
        }

        $this->rawSort = $sort;
        $this->parseSort();

        return true;
    }

    /**
     * Validate the syntax of the sort request field
     *
     * @param $sort
     *
     * @return bool
     */
    protected function validateSort($sort)
    {
        if (strpos($sort, '!', 0) === 0 || count(explode(':', $sort)) == 2 || preg_match('/^[a-z0-9\_\.\-]+$/',
                $sort)) {
            return true;
        }

        return false;
    }

    /**
     * Parses and prepares the request sort field
     *
     * @return bool
     */
    protected function parseSort()
    {
        $direction = 'desc';
        if (strpos($this->getRawSort(), '!', 0) === 0) {
            $fieldName = substr($this->getRawSort(), 1);
            $direction = 'asc';
        } elseif (strpos($this->getRawSort(), ':') !== false) {
            [$fieldName, $direction] = explode(':', $this->getRawSort());
        } else {
            $fieldName = $this->getRawSort();
        }

        $this->setField($fieldName);
        $this->setDirection($direction);

        return true;
    }
}
