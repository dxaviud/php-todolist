<?php
    $connection = pg_connect("host=localhost dbname=php-todolist user=postgres password=postgres")
        or die('Could not connect: ' . pg_last_error());

    echo "Connected to postgres database\n";
    
    $query = 'CREATE TABLE IF NOT EXISTS users(
        id SERIAL PRIMARY KEY, 
        username VARCHAR(50) UNIQUE NOT NULL, 
        email VARCHAR(75) NOT NULL, 
        password_hash VARCHAR(100) NOT NULL
    );';
    pg_query($connection, $query) or die('Query failed: ' . pg_last_error());

    echo "Created table users\n";

    $query = 'CREATE TABLE IF NOT EXISTS todos(
        id SERIAL PRIMARY KEY, 
        title VARCHAR(150) NOT NULL, 
        description TEXT, 
        user_id INTEGER REFERENCES users (id)
    );';
    pg_query($connection, $query) or die('Query failed: ' . pg_last_error());
    
    echo "Created table todos\n";

    pg_close($connection);
?>
