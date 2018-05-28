<?php
namespace Photon\Validation;

use Illuminate\Validation\ValidationException;

/**
 * Base Validator class, to be extended by specific validators.
 * Decorates the process of validating input. Simply declare
 * the $rules and call validate($attributes) and you have an
 * \Illuminate\Validation\Validator instance.
 */
class Validator
{
    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @var array
     */
    protected $messages = [];

    /**
     * @var array
     */
    protected $customAttributes = [];

    /**
     * @var Validation
     */
    protected $validation;

    public function __construct(Validation $validation)
    {
        $this->validation = $validation;
    }

    /**
     * Validate the given input.
     *
     * @param array $input The input to validate
     * @param array $rules Specify custom rules (will override class rules)
     * @param array $messages
     * @param array $customAttributes
     *
     * @return bool
     *
     * @throws ValidationException
     */
    public function validate($input, array $rules = [], array $messages = [], array $customAttributes = [])
    {
        $validation = $this->validation($input, $rules, $messages, $customAttributes);
        if ($validation->fails()) {
            throw new ValidationException($validation);
        }

        return true;
    }

    /**
     * Get a validation instance out of the given input and optionally rules
     * by default the $rules property will be used.
     *
     * @param $input
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validation($input, array $rules = [], array $messages = [], array $customAttributes = [])
    {
        if (empty($rules)) {
            $rules = $this->rules;
        }

        if (empty($messages)) {
            $messages = $this->messages;
        }

        if (empty($customAttributes)) {
            $customAttributes = $this->customAttributes;
        }

        return $this->validation->make($input, $rules, $messages, $customAttributes);
    }
}