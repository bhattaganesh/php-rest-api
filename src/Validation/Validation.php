<?php

namespace Ganesh\PhpRestApi\Validation;

class Validation
{

    public static function validate($data, $rules)
    {
        if (!empty($data) || !empty($rules)) {
            $errors = [];

            foreach ($rules as $field => $rule) {
                if (!isset($data[$field])) {
                    $errors[$field] = "The $field field is missing.";
                } else {
                    $rulesArray = explode("|", $rule);

                    $value = $data[$field];

                    foreach ($rulesArray as $r) {
                        $param = false;
                        if (strpos($r, ":")) {
                            $rParam = explode(":", $r);
                            $r = $rParam[0];
                            $param = $rParam[1];
                        }

                        switch ($r) {
                            case 'required':
                                if (empty($value)) {
                                    $errors[$field] = "The $field field is required.";
                                }
                                break;
                            case 'email':
                                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                    $errors[$field] = "The $field must be a valid email address.";
                                }
                                break;
                            case 'min':
                                if (strlen($value) < $param) {
                                    $errors[$field] = "The $field field must be at least $param characters.";
                                }
                                break;
                            case 'max':
                                if (strlen($value) > $param) {
                                    $errors[$field] = "The $field field must be at most $param characters.";
                                }
                                break;
                            default:
                                $errors[$field] = "Invalid validation rule for field: $field";
                                break;
                        }
                    }
                }
            }

            if (count($errors) > 0) {
                sendResponse(422, false, 'Validation errors.', $errors);
            }
        }

        return true;
    }
}
