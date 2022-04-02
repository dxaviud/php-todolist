<?php
// these functions assume session_start has already been called

function flash_error()
{
    if (!isset($_SESSION['error'])) {
        return '';
    }
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
    return '<p style="color: red">' . $error . '</p>';
}

function flash_success()
{
    if (!isset($_SESSION['success'])) {
        return '';
    }
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
    return '<h2 style="color: green">' . $success . '</h2>';
}
