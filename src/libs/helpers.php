<?php

/**
 * Display a view
 * @param string $filename
 * @param string $data
 * @return void
 */
function view(string $filename, array $data = [])
{
    foreach ($data as $key => $value) {
        $$key = $value;
    }

    require_once __DIR__ . '/../inc/' . $filename . '.php';
}

/**
 * Return true if the request method is POST
 * 
 * @return boolean
 */
function is_post_request(): bool
{
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
}

/**
 * Return true if the request method is GET
 * 
 * @return bool
 */
function is_get_request(): bool
{
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'GET';
}

/**
 * Redirect to another URL
 * 
 * @param string $url
 * @return void
 */
function redirect_to(string $url): void
{
    header('Location:' . $url);
    exit;
}

/**
 * Redirect to a URL with data stored in the items array
 * @param string $url
 * @param array $items
 * @return void
 */
function redirect_with(string $url, array $items): void
{
    foreach ($items as $key => $value) {
        $_SESSION[$key] = $value;
    }

    redirect_to($url);
}

/**
 * Redirect to a URL with a flash message
 * @param string $url
 * @param string $message
 * @param string $type
 */
function redirect_with_message(string $url, string $message, string $type = FLASH_SUCCESS)
{
    flash('flash_' . uniqid(), $message, $type);
    redirect_to($url);
}

/**
 * Return the error class if error is found in the array $errors
 * 
 * @param array $errors
 * @param string $field
 * @return string
 */
function error_class(array $errors, string $field): string
{
    return isset($errors[$field]) ? 'error' : '';
}

/**
 * Flash data specified by $key from the $_SESSION
 * @param ...$key
 * @return array
 */
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

/**
 * Create new a token
 * @return string
 */
function create_token(): string
{
    return bin2hex(random_bytes(35));
}

/**
 * Recursively trim strings in an array
 * @param array $items
 * @return void
 */
function display_error_message_image(array $errors_mesasages): void
{
    foreach ($errors_mesasages as $key => $value) {
        if (is_string($value)) {
            echo '<small class="error">' . $value . '</small> <br>';
        } else if (is_array($value)) {
            display_error_message_image($value);
        }
    }
}

/**
 * Check number than more
 * @param int $min
 * @param int $max
 * @return bool
 */
function check_max(int $min, int $max)
{
    return $max >= $min;
}
