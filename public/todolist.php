<?php
session_start();
if (!isset($_SESSION['username'])) { // not logged in, redirect to index
    header("Location: index.php");
    return;
}

require "../src/constants.php";
$connection = pg_connect(CONNECTION_STRING) or die('Could not connect: ' . pg_last_error());
// get user_id
$user_id;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $query = 'SELECT id FROM users WHERE username = $1';
    $params = array($_SESSION['username']);
    $result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
    $user_id = pg_fetch_result($result, 0, 'id');
    $_SESSION['user_id'] = $user_id;
}

$query = 'SELECT id, title, description FROM todos WHERE user_id = $1';
$params = array($user_id);
$result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
$todos = array();
while ($row = pg_fetch_row($result)) {
    $titleSnippet = substr($row[1], 0, 40);
    $titleEllipsis = strlen($row[1]) > 40;
    $descriptionSnippet = substr($row[2], 0, 30);
    $descriptionEllipsis = strlen($row[2]) > 30;
    array_push($todos,
        "<li><a href='todo.php?todo_id=$row[0]'>" .
        htmlentities($titleSnippet) .
        ($titleEllipsis ? "..." : "") .
        "</a><span style='margin-left: 20px; float: right; color: gray'>($descriptionSnippet" .
        ($descriptionEllipsis ? "..." : "") .
        ")</span></li>");
}

$todolist = implode('', $todos);
if (!$todolist) {
    $todolist = "<li>You don't have any todos yet. Add one below!</li>";
}

require '../src/flash.php';
$success = flash_success();
if (strlen($success) === 0) {
    $username = htmlentities($_SESSION['username']);
    $success = "Welcome, $username!";
}

$list = "
    <h2 style='color: green'>$success</h2>
    <ul>
        <li><a href='logout.php'>Logout</a></li>
        <li><a href='delete_account.php' style='color: red'>Delete account</a></li>
    </ul>
    <h3>Your todolist:</h3>
    <ul style='width: max-content'>
    $todolist
    </ul>";

$form = "
    <a href='create_todo.php'><button id='create-todo'>Create a new todo</button></a>
";

$script = '';

require '../templates/base.php';
