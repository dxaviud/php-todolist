<?php
session_start();
if (!isset($_SESSION['username'])) { // not logged in, redirect to index
    header("Location: index.php");
    return;
}

$todo_id = $_GET['todo_id'];
// get user_id
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $query = 'SELECT id FROM users WHERE username = $1';
    $params = array($_SESSION['username']);
    $result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
    $user_id = pg_fetch_result($result, 0, 'id');
    $_SESSION['user_id'] = $user_id;
}

$todotitle = isset($_POST['todotitle']) ? $_POST['todotitle'] : '';
$tododescription = isset($_POST['tododescription']) ? $_POST['tododescription'] : '';

if ($todotitle && $tododescription) {
    // attempt to update this todo
    unset($_SESSION['todotitle']);
    unset($_SESSION['tododescription']);

    require "../src/constants.php";
    $connection = pg_connect(CONNECTION_STRING) or die('Could not connect: ' . pg_last_error());
    $query = 'UPDATE todos set title = $1, description = $2 WHERE id = $3 AND user_id = $4';
    $params = array($todotitle, $tododescription, $todo_id, $user_id);
    $result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
    pg_close($connection);

    $_SESSION['success'] = "Todo updated successfully!";
    unset($_SESSION['todotitle']);
    unset($_SESSION['tododescription']);
    header("Location: todo.php?todo_id=$todo_id");
    return;

} else {
    require "../src/constants.php";
    $connection = pg_connect(CONNECTION_STRING) or die('Could not connect: ' . pg_last_error());
    $query = 'SELECT title, description FROM todos WHERE id = $1 AND user_id = $2';
    $params = array($todo_id, $user_id);
    $result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
    $row = pg_fetch_row($result);
    $todotitle = htmlentities($row[0]);
    $tododescription = htmlentities($row[1]);
}

$list = "
    <ul>
        <li><a href='todolist.php'>Todolist</a></li>
    </ul>
    ";

require '../src/flash.php';

$error = flash_error();
if ($error) {
    $error = "<p style='color: red'>" . $error . "</p>";
}

$form = $error . "
    <form method='post' id='newtodo'>
    <div>Edit todo:</div>
    <div><label for='todotitle'>Title:</label></div>
    <input type='text' name='todotitle' id='todotitle' value='$todotitle' required/>
    <div><label for='tododescription'>Description:</label></div>
    <textarea name='tododescription' id='tododescription' form='newtodo' rows=6 cols=25 required>$tododescription</textarea>
    <input type='submit' />
    </form>";

$script = '';

require '../templates/base.php';
