<?php

if (is_user_logged()) {
    redirect_to('index.php');
}

$errors = [];
$inputs = [];

if (is_post_request()) {
    // sanitize & validate user inputs
    [$inputs, $errors] = filter($_POST, [
        'username' => 'string | required',
        'password' => 'string | required'
    ]);

    // if validation error
    if ($errors) {
        redirect_with('login.php', [
            'inputs' => $inputs,
            'errors' => $errors
        ]);
    }

    if (!login($inputs['username'], $inputs['password'])) {
        $errors['login'] = 'Invalid username or password';

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
