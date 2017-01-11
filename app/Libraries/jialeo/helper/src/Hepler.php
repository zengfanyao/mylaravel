<?php

if (!function_exists('load_helper')) {
    function load_helper($class_name)
    {
        require_once app_path() . '/Helper/' . $class_name . '.php';
    }
}

if (!function_exists('response_error')) {
    function response_error($error_msg, $error_id = 'ERROR', $status_code = 400)
    {
        throw new \App\Exceptions\ApiException($error_msg, $error_id, $status_code);
    }
}