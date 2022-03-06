<?php
// these functions assume session_start has already been called

function flash_error()
{
    $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
    unset($_SESSION['error']);
    return $error;
}

function flash_success()
{
    $success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
    unset($_SESSION['success']);
    return $success;
}
