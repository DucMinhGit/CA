<?php

const APP_URL = 'http://localhost/tb/ca';
const SENDER_EMAIL_ADDRESS = 'no-reply@email.com';

/**
 * Generate active code
 * @return string
 */
function generate_activation_code(): string
{
    return bin2hex(random_bytes(16));
}

/**
 * Send active email
 * @param string $email
 * @param string $activation_code
 * @return void
 */
function send_activation_email(string $email, string $activation_code): void
{
    // create the activation link
    $activation_link = APP_URL . "/activation.php?email=$email&activation_code=$activation_code";

    // set subject email & body
    $subject = 'Please activate your account';

    $message = <<<MESSAGE
            Hi,
            Please click the following link to activate your account:
            $activation_link
            MESSAGE;
    $header = 'From to:' . SENDER_EMAIL_ADDRESS;

    mail($email, $subject, nl2br($message), $header);
}
