<?php

function view(string $filename, array $data = [])
{
    foreach($data as $key => $value)
    {
        $$key = $value;
    }

    require_once __DIR__ . '/../inc/' . $filename . '.php';
}

function is_post_request():bool
{
    return strtoupper($_SERVER['REQUEST_METHOD'] === 'POST');
}

function is_get_request():bool
{
    return strtoupper($_SERVER['REQUEST_METHOD'] === 'GET');
}

function error_class(array $errors, string $field): string
{
    return isset($errors[$field]) ? 'error' : '';
}

function session_flash(...$keys): array
{
    $data = [];
    foreach ($keys as $key) {
        if (isset($_SESSION[$key])) {
            $data[] = $_SESSION[$key];
            unset($_SESSION[$key]);
        } else {
            $data[] = [];
        }
    }
    return $data;
}