<?php
if (isset($_SERVER['RDS_HOSTNAME'])) {
    $dbhost = $_SERVER['RDS_HOSTNAME'];
    $dbport = $_SERVER['RDS_PORT'];
    $dbname = $_SERVER['RDS_DB_NAME'];
    $username = $_SERVER['RDS_USERNAME'];
    $password = $_SERVER['RDS_PASSWORD'];

    define("CONNECTION_STRING", "host=$dbhost port=$dbport dbname=$dbname user=$username password=$password");
} else {
    define("CONNECTION_STRING", "host=localhost port=5432 dbname=php-todolist user=postgres password=postgres");
}
define('PRODUCTION', $_SERVER['SERVER_NAME'] !== 'localhost');
