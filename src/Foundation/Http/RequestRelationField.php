<?php

namespace MoeenBasra\Photon\Foundation\Http;

/**
 * Class RequestSort
 *
 * @package MoeenBasra\Photon\Foundation\Http
 */
class RequestRelationField extends RequestField
{
    /**
     * @var RequestFieldCollection
     */
    protected $subFields;

    protected $subFieldsSeparator = '|';

    public function __construct($fieldName)
    {
        $this->subFields = new RequestFieldCollection();
        parent::__construct($fieldName);
    }

    /**
     *  Check whether we have sub-fields
     *
     * @return bool
     */
    public function hasSubFields()
    {
        return ($this->getSubFields()->count() > 0);
    }

    /**
     * Returns collection of sub-field objects
     *
     * @return \MoeenBasra\Photon\Foundation\Http\RequestFieldCollection
     */
    public function getSubFields()
    {
        return $this->subFields;
    }

    /**
     * Set the relation field sub-fields
     *
     * @param $subFields
     *
     * @return bool
     */
    protected function setSubFields($subFields)
    {
        if (!is_array($subFields) && is_string($subFields)) {
            $subFields = explode($this->subFieldsSeparator, $subFields);
        }

        foreach ($subFields as $field) {
            $this->subFields->attach(new RequestField($field));
        }

        return true;
    }

    /**
     * Validates field
     *
     * @param $fieldName
     *
     * @return bool
     */
    protected function validateFieldName($fieldName)
    {
        if (!preg_match('/^([a-zA-Z\.\-\_]+)(\((.+)\))?$/', $fieldName)) {
            return false;
        }

        return true;
    }

    /**
     * Parsing the field and sets appropriate members accordingly
     *
     * @return bool
     */
    protected function parseField()
    {

        $fieldSegments = [];
        preg_match('/^([a-zA-Z\.\-\_]+)(\((.+)\))?$/', $this->fieldName, $fieldSegments);

        if (count($fieldSegments) == 4) {
            $this->fieldName = $fieldSegments[1];
            $this->setSubFields($fieldSegments[3]);
        }

        $relationFragments = explode('.', $this->fieldName);

        if (count($relationFragments) > 1) {
            $this->isRelational = true;
            $this->setRelationFragments($relationFragments);
            $this->setFieldName(end($relationFragments));
        }

        return true;
    }
}
