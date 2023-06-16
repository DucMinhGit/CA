<?php

if (is_user_logged_in()) {
    redirect_to('index.php');
}

$errors = [];
$inputs = [];

if (is_post_request()) {
    // sanitize & validate user inputs
    [$inputs, $errors] = filter($_POST, [
        'username' => 'string | required',
        'password' => 'string | required',
        'remember_me' => 'string'
    ]);

    // if validation error
    if ($errors) {
        redirect_with('login.php', [
            'inputs' => $inputs,
            'errors' => $errors
        ]);
    }

    if (!login($inputs['username'], $inputs['password'], isset($inputs['remember_me']))) {
        $errors['login'] = 'Invalid username, password or check verify email';

        redirect_with('login.php', [
            'inputs' => $inputs,
            'errors' => $errors
        ]);
    }

    // login successfully
    redirect_to('index.php');
} else if (is_get_request()) {
    [$inputs, $errors] = session_flash('inputs', 'errors');
}
