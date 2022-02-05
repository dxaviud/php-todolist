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

    $query = 'CREATE TABLE IF NOT EXISTS todoitems(
        id SERIAL PRIMARY KEY, 
        title VARCHAR(150) NOT NULL, 
        description TEXT, 
        user_id INTEGER REFERENCES users (id)
    );';
    pg_query($connection, $query) or die('Query failed: ' . pg_last_error());
    
    echo "Created table todoitems\n";

    // // Performing SQL query
    // $query = 'SELECT * FROM authors';
    // $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    // // Printing results in HTML
    // echo "<table>\n";
    // while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    //     echo "\t<tr>\n";
    //     foreach ($line as $col_value) {
    //         echo "\t\t<td>$col_value</td>\n";
    //     }
    //     echo "\t</tr>\n";
    // }
    // echo "</table>\n";

    // // Free resultset
    // pg_free_result($result);

    // Closing connection
    pg_close($connection);
?>
