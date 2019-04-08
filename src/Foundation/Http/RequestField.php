<?php

namespace Photon\Foundation\Http;

/**
 * Class RequestField
 *
 * @package Photon\Foundation\Http
 */
class RequestField
{
    /**
     * @var string
     */
    protected $fieldName;

    /**
     * @var string
     */
    private $rawFieldName;

    /**
     * @var bool
     */
    protected $isRelational = false;

    /**
     * @var array
     */
    private $relationFragments = [];

    /**
     * RequestField constructor.
     *
     * @param string $fieldName
     */
    public function __construct(string $fieldName)
    {
        $this->rawFieldName = $fieldName;
        $this->setFieldName($fieldName);
    }

    /**
     * Sets the current field name
     *
     * @param string $fieldName
     *
     * @throws  \InvalidArgumentException
     * @return bool
     */
    protected function setFieldName(string $fieldName)
    {
        if (! $this->validateFieldName($fieldName)) {
            throw new \InvalidArgumentException("Invalid request field name {$fieldName} supplied");
        }

        $this->fieldName = $fieldName;

        $this->parseField();

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
        if (! preg_match('/^[a-z0-9\_\.\-]+$/', $fieldName)) {
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
        $relationFragments = explode('.', $this->fieldName);

        if (count($relationFragments) > 1) {
            $this->isRelational = true;
            $this->setFieldName(array_pop($relationFragments));
            $this->setRelationFragments($relationFragments);
        }

        return true;
    }

    /**
     * Get field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->fieldName;
    }

    public function getRawName()
    {
        return $this->rawFieldName;
    }

    /**
     * Tells whether field is representing A relational/nested query
     *
     * @return bool
     */
    public function isRelational()
    {
        return $this->isRelational;
    }

    /**
     * Returns the relation or nested field fragments as ordered array
     *
     * @return array
     */
    public function getRelationFragments()
    {
        return $this->relationFragments;
    }

    /**
     * Return the relation name as string imploded by (dots)
     *
     * @return string
     */
    public function getRelationName()
    {
        return implode('.', $this->getRelationFragments());
    }

    /**
     * Setting the relation fragments
     *
     * @param array $relationFragments
     *
     * @return bool
     */
    protected function setRelationFragments(array $relationFragments)
    {
        $this->relationFragments = $relationFragments;

        return true;
    }
}