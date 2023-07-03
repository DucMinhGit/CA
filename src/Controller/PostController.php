<?php

require_login();

$inputs = [];
$errors = [];
$districts = [];
$wards = [];
$pathImages = [];

$pdo = require_once __DIR__ . "/../../config/connect.php";
$youares = require_once __DIR__ . "/../../config/youares.php";
$careers = require_once __DIR__ . "/../../config/career.php";
$typeOfWork = require_once __DIR__ . "/../../config/typeOfWork.php";
$payments = require_once __DIR__ . "/../../config/payment.php";
$genders = require_once __DIR__ . "/../../config/gender.php";
$levelEducates = require_once __DIR__ . "/../../config/levelEducate.php";
$experiences = require_once __DIR__ . "/../../config/experience.php";
$upload_dir = dirname(__DIR__, 2) . '/public/uploads';

if (is_post_request()) {
    $fields = [
        'youare' => 'string | required',
        'title' => 'string | required | min_str_len:2 | max_str_len:256',
        'company_name' => 'string | required | min_str_len:2 | max_str_len:256',
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
        'gender' => 'string | required',
        'hiring_quantity' => 'int | required | numeric_config',
        'minimal_education' => 'int | required | numeric_config',
        'minimal_age' => 'int | required | min:18 | numeric_config',
        'maximum_age' => 'int | required | max:65 | numeric_config',
        'type_of_work' => 'int | required | numeric_config',
        'experience' => 'int | required | numeric_config',
        'benefit' => 'string | max_str_len:300',
        'certificate_skill' => 'string | max_str_len:300',
    ];

    // Check token form
    if($_POST['_token'] !== $_SESSION['token']) {
        redirect_with_message('create.php', MESSAGES['warning_form'], FLASH_WARNING);
    }

    [$inputs, $errors] = filter($_POST, $fields);

    // Check the $_FILE variable is sent from request post or not, otherwise, it will give an error message
    if (!isset($_FILES['files'])) {
        $errors['files']['note _exist'] = MESSAGES['file_not_exist'];
    }
    // assign to $files
    $files = $_FILES['files'];

    // if the file is upload with an error, it will not be saved
    // if the file variable is exists, but status upload image is an error, it will return false and not be saved
    // if the file is upload with no error and return a array empty, it will be saved
    if (validation_image($files) !== [] && validation_image($files) !== false) {
        $errors['files']['error'] = validation_image($files);
    } else if (validation_image($files) === []) {
        if (move_file_image($files, $upload_dir)) {
            if (isset($_SESSION['pathImage'])) {
                $pathImages = $_SESSION['pathImage'];
                unset($_SESSION['pathImage']);
            }
        } else {
            $errors['files']['file_type'] = MESSAGES['move_file'];
        }
    }

    // Check min_salary < max_salary
    if (!check_max((int)$inputs['min_salary'], (int)$inputs['max_salary'])) {
        $errors['min_salary'] = MESSAGES['err_salary'];
    }

    // Check minimal_age < max_salary
    if (!check_max((int)$inputs['minimal_age'], (int)$inputs['maximum_age'])) {
        $errors['minimal_age'] = MESSAGES['err_age'];
    }

    if ($errors) 
    {
        if ($inputs['district'] !== '') {
            $districts = get_district_by_city_code($inputs['city']);
        }

        if ($inputs['ward'] !== '') {
            $wards = get_ward_by_district_code($inputs['district']);
        }

        if ($pathImages !== []) {
            foreach ($pathImages as $pathImage) {
                unlink($pathImage);
            }
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

    // Check value to get value
    $negotiate = 0;
    if ($inputs['min_salary'] === '0' && $inputs['max_salary'] === '0') {
        $negotiate = 1;
    }

    if (empty($inputs['benefit'])) {
        $inputs['benefit'] = NULL;
    }

    if (empty($inputs['certificate_skill'])) {
        $inputs['certificate_skill'] = NULL;
    }

    $address =  $inputs['address_detail'] . ', ' . $inputs['ward'] . ', ' . $inputs['district']  . ', ' . $inputs['city'];

    try {
        $pdo->beginTransaction();

        $post_id = insert_post(
            $pdo,
            $inputs['youare'],
            $inputs['company_name'],
            $inputs['title'],
            $address,
            $inputs['content'],
            $inputs['payment'],
            $inputs['career'],
            $inputs['gender'],
            $inputs['hiring_quantity'],
            $inputs['minimal_education'],
            $inputs['minimal_age'],
            $inputs['maximum_age'],
            $inputs['type_of_work'],
            user_id(),
            $inputs['experience'],
            $inputs['benefit'],
            $inputs['certificate_skill'],
            $inputs['min_salary'],
            $inputs['max_salary'],
            $negotiate
        );

        foreach ($pathImages as $image) {
            insert_image($pdo, $image, $post_id);
        }

        $pdo->commit();
        
        redirect_with_message('create.php', 'Created post successfully');
    } catch (\Exception $e) {
        // Rollback the transaction
        $pdo->rollBack();

        // Show the error message
        redirect_with_message('create.php', MESSAGES['create_error'], FLASH_ERROR);
    }

} else if (is_get_request()) {
    [$inputs, $errors, $districts, $wards] = session_flash('inputs', 'errors', 'districts', 'wards');

    // Create token CSRF
    $_SESSION['token'] = create_token();

    $cities = get_info_city();
}
