<?php

if(is_post_request())
{
    flash(
        'user_register_success',
        'Your account has been created successfully. Please login here.',
        'success'
    );
}