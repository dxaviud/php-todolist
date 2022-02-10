<?php 
    session_start();
    if (!isset($_SESSION['username'])) { // not logged in, redirect to index
        header("Location: index.php");
        return;
    }

    require "constants.php";
    $connection = pg_connect(constant("CONNECTION_STRING")) or die('Could not connect: ' . pg_last_error());
    $query = 'DELETE FROM users WHERE username = $1';
    $params = array($_SESSION['username']);
    pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());

    header('Location: logout.php');
?>
