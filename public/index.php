<?php
require_once "../src/initialize_database.php";
require_once '../src/logger.php';

session_start();
// must not be authenticated
if (isset($_SESSION['username'])) {
    header('Location: todolist.php');
    return;
}

log_debug('testing logging');

$body_template = 'index.php';
require_once '../templates/base_better.php';
