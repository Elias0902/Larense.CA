<?php
// utils.php

if (!function_exists('setError')) {
    function setError($message) {
        $_SESSION['message_type'] = 'danger';
        $_SESSION['message'] = $message;
    }
}

if (!function_exists('setSuccess')) {
    function setSuccess($message) {
        $_SESSION['message_type'] = 'success';
        $_SESSION['message'] = $message;
    }
}
?>
