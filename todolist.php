<?php
    session_start();
    if (!isset($_SESSION['username'])) { // not logged in, redirect to index
        header("Location: index.php");
        return;
    }

    $todotitle = isset($_POST['todotitle']) ? $_POST['todotitle'] : '';
    $tododescription = isset($_POST['tododescription']) ? $_POST['tododescription'] : '';

    if ($todotitle && $tododescription) {
        // attempt to add this todo

        unset($_SESSION['todotitle']);
        unset($_SESSION['tododescription']);

        require "constants.php";
        $connection = pg_connect(constant("CONNECTION_STRING")) or die('Could not connect: ' . pg_last_error());
        $query = 'SELECT * FROM todos WHERE title = $1';
        $params = array($todotitle);
        $result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());

        if (pg_num_rows($result) > 0) {

            pg_close($connection);
            $_SESSION['error'] = "That title already exists, please pick another";
            $_SESSION['todotitle'] = $todotitle;
            $_SESSION['tododescription'] = $tododescription;
            header('Location: todolist.php');
            return;

        } else {
            // signup

            // get user_id
            $query = 'SELECT id FROM users WHERE username = $1';
            $params = array($_SESSION['username']);
            $result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
            $user_id = pg_fetch_result($result, 0, 'id');

            // insert todo
            $query = 'INSERT INTO todos (title, description, user_id) VALUES ($1, $2, $3)';
            $params = array($todotitle, $tododescription, $user_id);
            $result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
            pg_close($connection);

            $_SESSION['success'] = "Todo added successfully!";
            header("Location: todolist.php");
            return;
        }
    }

    require "constants.php";
    // get user_id
    $connection = pg_connect(constant("CONNECTION_STRING")) or die('Could not connect: ' . pg_last_error());
    $query = 'SELECT id FROM users WHERE username = $1';
    $params = array($_SESSION['username']);
    $result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
    $user_id = pg_fetch_result($result, 0, 'id');

    $query = 'SELECT title FROM todos WHERE user_id = $1';
    $params = array($user_id);
    $result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
    $todos = array();
    while ($row = pg_fetch_row($result)) {
        array_push($todos, "<li><a href=''>" . htmlentities($row[0]) . "</a></li>");
    }

    $todolist = implode('', $todos);
    if (!$todolist) {
        $todolist = "<li>You don't have any todos yet. Add one below!</li>";
    }

    $success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
    unset($_SESSION['success']);
    if (strlen($success) === 0) {
        $username = htmlentities($_SESSION['username']);
        $success = "Welcome, $username!";
    }

    $list = "
    <h2 style='color: green'>$success</h2>
    <ul>
        <li><a href='logout.php'>Logout</a></li>
    </ul>
    <h3>Your todolist:</h3>
    <ul>
    $todolist
    </ul>";

    $error = isset($_SESSION['error']) ? "<p style='color: red'>" . $_SESSION['error'] . "</p>" : '';
    unset($_SESSION['error']);
    $todotitle = isset($_SESSION['todotitle']) ? htmlentities($_SESSION['todotitle']) : '';
    $tododescription = isset($_SESSION['tododescription']) ? htmlentities($_SESSION['tododescription']) : '';

    $form = $error . "
    <form method='post' id='newtodoitem'>
    <div>Add a new todo:</div>
    <div><label for='todotitle'>Title:</label></div>
    <input type='text' name='todotitle' id='todotitle' value='$todotitle' />
    <div><label for='tododescription'>Description:</label></div>
    <textarea name='tododescription' id='tododescription' form='newtodoitem' rows=6 cols=25>$tododescription</textarea>
    <input type='submit' />
    </form>";

    require 'templates/base.php';
?>
