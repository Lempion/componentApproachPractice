<?php

class Validate
{
    private $db, $errors = [], $passed = false;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function check($dataInput, $items)
    {
        foreach ($items as $field => $rules) {
            foreach ($rules as $rule => $valRule) {

                $valueInput = $dataInput[$field];

                if ($rule === 'required' && empty($valueInput)) {
                    $this->addError("Field {$field} is required");
                    break;
                } elseif (!empty($valueInput)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($valueInput) < $valRule) {
                                $this->addError("Min length {$field} is $valRule chars");
                            }
                            break;
                        case 'max':
                            if (strlen($valueInput) > $valRule) {
                                $this->addError("Max length {$field} is $valRule chars");
                            }
                            break;
                        case 'matches':
                            if ($dataInput[$valRule] !== $valueInput) {
                                $this->addError("Password  not equal password again");
                            }
                            break;
                        case 'email':
                            if (!filter_var($valueInput, FILTER_VALIDATE_EMAIL)) {
                                $this->addError("{$valueInput} is not an email");
                            }
                            break;
                        case "uniq":
                            if ($this->db->get($valRule, [$field, '=', $valueInput])->count()) {
                                $this->addError("This {$field} is exists");
                            }
                            break;
                    }
                }
            }
        }

        if (empty($this->errors)) {
            $this->passed = true;
        }
        return $this;
    }

    public function addError($text)
    {
        $this->errors[] = $text;
    }

    public function getError()
    {
        return $this->errors;
    }

    public function passed()
    {
        return $this->passed;
    }


}
