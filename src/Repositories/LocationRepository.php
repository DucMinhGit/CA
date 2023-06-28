<?php

/**
 * Get list city
 * @return array
 */
function get_info_city(): array
{
    $sql = "SELECT city_code, name
            FROM cities
            ORDER BY city_code ASC";

    $statement = db()->query($sql);

    return $statement->fetchAll(PDO::FETCH_KEY_PAIR);
}

/**
 * Get list district by city code
 * @param string $city_code
 * @return array
 */
function get_district_by_city_code(string $city_code): array
{
    $sql = "SELECT district_code, name
            FROM districts
            WHERE city_code=:city_code
            ORDER BY district_code ASC";

    $statement = db()->prepare($sql);
    $statement->bindValue(":city_code", $city_code);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_KEY_PAIR);
}

/**
 * Get list ward by district code
 * @param string $district_code
 * @return array
 */
function get_ward_by_district_code(string $district_code): array
{
    $sql = "SELECT ward_code, name
            FROM wards
            WHERE district_code=:district_code
            ORDER BY ward_code ASC";

    $statement = db()->prepare($sql);
    $statement->bindValue(":district_code", $district_code);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_KEY_PAIR);
}

/**
 * Get name city by city_code
 * @param string int $city_code
 * @return string
 */
function get_name_city_by_city_code(string $city_code)
{
    $sql = "SELECT name
            FROM cities
            WHERE city_code=:city_code";

    $statement = db()->prepare($sql);
    $statement->bindValue(':city_code', $city_code);

    $statement->execute();

    return $statement->fetch(PDO::FETCH_COLUMN);
}

/**
 * Get name district by district_code
 * @param string int $district_code
 * @return string
 */
function get_name_district_by_district_code(string $district_code)
{
    $sql = "SELECT name
            FROM districts
            WHERE district_code=:district_code";

    $statement = db()->prepare($sql);
    $statement->bindValue(':district_code', $district_code);

    $statement->execute();

    return $statement->fetch(PDO::FETCH_COLUMN);
}

/**
 * Get name ward by ward_code
 * @param string int $ward_code
 * @return string
 */
function get_name_district_by_ward_code(string $ward_code)
{
    $sql = "SELECT name
            FROM wards
            WHERE ward_code=:ward_code";

    $statement = db()->prepare($sql);
    $statement->bindValue(':ward_code', $ward_code);

    $statement->execute();

    return $statement->fetch(PDO::FETCH_COLUMN);
}
