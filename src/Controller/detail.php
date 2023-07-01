<?php

require_login();

if (!isset($_GET['id'])) {
    redirect_to('404.php');
}

$youares = require_once __DIR__ . "/../../config/youares.php";
$careers = require_once __DIR__ . "/../../config/career.php";
$typeOfWork = require_once __DIR__ . "/../../config/typeOfWork.php";
$payments = require_once __DIR__ . "/../../config/payment.php";
$genders = require_once __DIR__ . "/../../config/gender.php";
$levelEducates = require_once __DIR__ . "/../../config/levelEducate.php";
$experiences = require_once __DIR__ . "/../../config/experience.php";

$fields = ['id' => 'int | config_numeric'];

[$inputs, $errors] = filter($_GET, $fields);

$title = get_title_post_by_id($pdo, $inputs['id']);

$images = get_image_by_post_id($pdo, $inputs['id']);

$post = get_post_by_id($pdo, $inputs['id']);

[$detail_ad, $ward, $distinct, $city] = explode(', ', $post['address']);

$address = $detail_ad . ', ' . 
            get_name_district_by_ward_code($ward) . ', ' . 
            get_name_district_by_district_code($distinct) . ', ' . 
            get_name_city_by_city_code($city);

