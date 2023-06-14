<?php

/**
 * Sanitize and validate data
 * @param array $data
 * @param array $fields
 * @param array $messages
 * @return array
 */
function filter(array $data, array $fields, array $messages = []): array
{
    $validation_rule = [];
    $sanitization_rule = [];

    foreach ($fields as $field => $rules) {
        if (strpos($rules, '|')) {
            [$sanitization_rule[$field], $validation_rule[$field]] = explode('|', $rules, 2);
        }
    }

    $inputs = sanitize($data, $sanitization_rule);
    $errors = validate($inputs, $validation_rule, $messages);

    return [$inputs, $errors];
}
