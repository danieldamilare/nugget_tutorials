<?php
function validate_email($value,
    $key = '',
    &$error_arr = array(),
    $msg = "Invalid email"){
    $email = filter_var($value, FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){

        if ($key)
            $error_arr[$key] = $msg;

        return null;
    }
    return $email;
}

function check_required($value,
    $key = '',
    &$error_arr = array()       ,
    $msg = "Value is required"){
    if (empty($value)){
        if ($key)
            $error_arr[$key] = $msg;

        return null;
    }
    return $value;
}
?>
