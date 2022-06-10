<?php
namespace App\Repositories;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

abstract class AbstractValidator
{
    protected $attributes = array();
    /**
     * The input data of the current request.
     *
     * @var array
     */
    protected $inputData;

    /**
     * The validation rules to validate the input data against.
     *
     * @var array
     */
    protected $rules = array();

    /**
     * The validator instance.
     *
     * @var \Illuminate\Validation\Validator
     */
    protected $validator;

    /**
     * Array of custom validation messages.
     *
     * @var array
     */
    protected $messages = array();

    /**
     * Create a new Form instance.
     *
     */
    public function __construct()
    {
        $this->inputData = App::make('request')->all();
    }

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return $this->inputData;
    }

    /**
     * Returns whether the input data is valid.
     *
     * @param array $inputData
     *
     * @return bool
     */
    public function isValid($inputData = array())
    {
        if (!empty($inputData)) {
            $this->inputData = $inputData;
        }
        $this->validator = Validator::make(
            $this->getInputData(),
            $this->getPreparedRules(),
            $this->getMessages(),
            $this->getAttributes()
        );
        $this->validator->setAttributeNames($this->getAttributes());
        return $this->validator->passes();
    }

    /**
     * Get the validation errors off of the Validator instance.
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function getErrors()
    {
        return $this->validator->errors();
    }

    /**
     * Get the prepared validation rules.
     *
     * @return array
     */
    protected function getPreparedRules()
    {
        return $this->rules;
    }

    protected function setPreparedRules($rules = array())
    {
        $this->rules = $rules;
    }

    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    protected function getMessages()
    {
        return $this->messages;
    }

    protected function setMessages($messages = array())
    {
        $this->messages = $messages;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setAttributes($attributes = array())
    {
        $this->attributes = $attributes;
    }

    public function toHtml()
    {
        $errors = $this->getErrors()->toArray();
        $arrayError = array();
        foreach ($errors as $error) {
            foreach ($error as $e) {
                $arrayError[] = '<p>' . $e . '</p>';
            }
        }
        return implode('', $arrayError);
    }


}