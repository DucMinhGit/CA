<?php

require_once __DIR__ . '/../Repositories/LocationRepository.php';

if (is_post_request()) 
{
    $data = file_get_contents("php://input");
    $data = json_decode($data, true);

    if ($data['_token'] !== $_SESSION['token']) {
        http_response_code(422);
    }

    $output = '';

    if ($data['location_name'] === 'city') 
    {
        $output = '<option value="">---Select a district---</option>';
        $districts = get_district_by_city_code($data['location_code']);

        foreach ($districts as $district_code => $name) {
            $output .= '<option value="' . $district_code . '">' . $name . '</option>';
        }
    } 
    else if ($data['location_name'] === 'district') 
    {
        $output = '<option value="">---Select a ward---</option>';
        $wards = get_ward_by_district_code($data['location_code']);

        foreach ($wards as $ward_code => $name) {
            $output .= '<option value="' . $ward_code . '">' . $name . '</option>';
        }
    }

    echo $output;
}
