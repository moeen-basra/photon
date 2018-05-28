<?php

namespace Photon\Foundation\Http;

/**
 * Class RequestFilter
 *
 * @package Awok\Foundation\Http
 */
class RequestFilter
{
    /**
     * @var string
     */
    protected $rawFilter = null;

    /**
     * @var RequestField
     */
    protected $field = null;

    /**
     * @var string
     */
    protected $compareSymbol = null;

    /**
     * @var string|array
     */
    protected $filterValue = null;

    /**
     * @var array
     */
    private $comparisonSymbols = ['=', '<', '>', '<=', '>=', '!='];

    /**
     * RequestFilter constructor.
     *
     * @param string $filter
     * @param array  $comparisonSymbols
     */
    public function __construct(string $filter, $comparisonSymbols = [])
    {
        $this->setFilter($filter);

        if (! empty($comparisonSymbols)) {
            $this->setFilterSymbols($comparisonSymbols);
        }
    }

    /**
     * Initialize Filter
     *
     * @param $filter
     *
     * @throws \InvalidArgumentException
     * @return bool
     */
    protected function setFilter($filter)
    {
        if (! $this->isValidFilter($filter)) {
            throw new \InvalidArgumentException("Invalid request filter {$filter} supplied");
        }

        $this->rawFilter = $filter;

        $this->parseFilter();

        return true;
    }

    /**
     * Initial Filter Validation
     *
     * @param $filter
     *
     * @return bool
     */
    protected function isValidFilter($filter)
    {
        if (! str_contains($filter, $this->getComparisonSymbols())) {
            return false;
        }

        return true;
    }

    /**
     * Getter for filter comparison symbol
     *
     * @return array
     */
    public function getComparisonSymbols()
    {
        return $this->comparisonSymbols;
    }

    /**
     * Parses the raw filter
     *
     * @throws \InvalidArgumentException
     * @return bool
     */
    protected function parseFilter()
    {
        $filterFragments = [];
        preg_match('/^([a-zA-Z0-9\-\_\.]+)('.implode('|', $this->getComparisonSymbols()).'{1})(([a-zA-Z0-9\-\_\:\% ]+)|\(([a-zA-Z0-9\-\_\:\% \|]+)\))$/', $this->getRawFilter(), $filterFragments);

        if (count($filterFragments) < 5) {
            throw new \InvalidArgumentException('Malformed filter '.$this->getRawFilter().' was provided');
        }

        $this->setField($filterFragments[1]);
        $this->setCompareSymbol($filterFragments[2]);

        if (count($filterFragments) == 6) {
            $this->setFilterValue($filterFragments[5]);
        } else {
            $this->setFilterValue($filterFragments[3]);
        }

        return true;
    }

    /**
     * Return raw filter string
     *
     * @return string
     */
    public function getRawFilter()
    {
        return $this->rawFilter;
    }

    /**
     * Set and override default defined filtering symbols
     *
     * @param array $filterSymbols
     */
    public function setFilterSymbols(array $filterSymbols)
    {
        $this->comparisonSymbols = $filterSymbols;
    }

    /**
     * Return filter field object
     *
     * @return \Awok\Foundation\Http\RequestField
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Sets field object using field name
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
     * Return the current filter comparison symbol
     *
     * @return string
     */
    public function getCompareSymbol()
    {
        return $this->compareSymbol;
    }

    /**
     * Sets current filter comparison symbol
     *
     * @param $symbol
     *
     * @return bool
     */
    protected function setCompareSymbol($symbol)
    {
        $this->compareSymbol = $symbol;

        return true;
    }

    /**
     * Get the currents filter comparison value
     *
     * @return string
     */
    public function getFilterValue()
    {
        return $this->filterValue;
    }

    /**
     * Sets current filter comparison value
     *
     * @param $filterValue
     *
     * @return bool
     */
    protected function setFilterValue($filterValue)
    {
        if (count($arrayFilterValue = explode('|', $filterValue)) > 1) {
            $this->filterValue = $arrayFilterValue;
        } else {
            $this->filterValue = $filterValue;
        }

        return true;
    }
}