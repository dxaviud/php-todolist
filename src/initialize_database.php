<?php
require_once "../src/logger.php";
require_once "constants.php";

$connection = pg_connect(CONNECTION_STRING)
or die('Could not connect: ' . pg_last_error());

log_info("Connected to postgres database");

$query = 'CREATE TABLE IF NOT EXISTS users(
        id SERIAL PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(75) NOT NULL,
        password_hash VARCHAR(100) NOT NULL
    );';
pg_query($connection, $query) or die('Query failed: ' . pg_last_error());

log_info("Created table users");

$query = 'CREATE TABLE IF NOT EXISTS todos(
        id SERIAL PRIMARY KEY,
        title VARCHAR(150) NOT NULL,
        description TEXT,
        user_id INTEGER REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
    );';
pg_query($connection, $query) or die('Query failed: ' . pg_last_error());

log_info("Created table todos");

pg_close($connection);
