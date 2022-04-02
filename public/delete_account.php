<?php
require_once "../src/constants.php";

session_start();
// must be authenticated
if (!isset($_SESSION['username'])) {
    header('Location: .');
    return;
}

$connection = pg_connect(CONNECTION_STRING) or die('Could not connect: ' . pg_last_error());
$query = 'DELETE FROM users WHERE username = $1';
$params = array($_SESSION['username']);
pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());

header('Location: logout.php');
