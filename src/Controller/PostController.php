<?php

$inputs = [];
$errors = [];
$districts = [];
$wards = [];

$youares = require_once __DIR__ . "/../../config/youares.php";
$careers = require_once __DIR__ . "/../../config/career.php";
$typeOfWork = require_once __DIR__ . "/../../config/typeOfWork.php";
$payments = require_once __DIR__ . "/../../config/payment.php";
$genders = require_once __DIR__ . "/../../config/gender.php";
$levelEducates = require_once __DIR__ . "/../../config/levelEducate.php";
$experiences = require_once __DIR__ . "/../../config/experience.php";

if (is_post_request()) 
{
    $fields = [
        'youare' => 'string | required | numeric_config',
        'title' => 'string | required | alphanumeric | min_str_len:2 | max_str_len:256',
        'company_name' => 'string | required | alphanumeric | min_str_len:2 | max_str_len:256',
        'min_salary' => 'int | numeric_config',
        'max_salary' => 'int | numeric_config',
        'negotiate' => 'int | numeric_config',
        'city' => 'string | required',
        'district' => 'string | required',
        'ward' => 'string | required',
        'address_detail' => 'string | required',
        'content' => 'string | required | min_str_len:20 | max_str_len: 1500',
        'payment' => 'int | required | numberic',
        'career' => 'int | required | numeric_config',
        'gender' => 'string | required | numeric_config',
        'hiring_quantity' => 'int | required | numeric_config',
        'minimal_education' => 'int | required | numeric_config',
        'minimal_age' => 'int | required | min:18 | numeric_config',
        'maximum_age' => 'int | required | max:65 | numeric_config',
        'type_of_work' => 'int | required | numeric_config',
        'experience' => 'int | required | numeric_config',
        'benefit' => 'string | max_str_len:300',
        'certificate_skill' => 'string | max_str_len:300',
    ];

    [$inputs, $errors] = filter($_POST, $fields);

    if ($errors) {
        if ($inputs['district'] !== '') {
            $districts = get_district_by_city_code($inputs['city']);
        }

        if ($inputs['ward'] !== '') {
            $wards = get_ward_by_district_code($inputs['district']);
        }

        redirect_with(
            'create.php',
            [
                'inputs' => $inputs,
                'errors' => $errors,
                'districts' => $districts,
                'wards' => $wards
            ]
        );
    }
} else if (is_get_request()) {
    [$inputs, $errors, $districts, $wards] = session_flash('inputs', 'errors', 'districts', 'wards');

    // Create token CSRF
    $_SESSION['token'] = create_token();

    $cities = get_info_city();
}
