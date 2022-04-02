<?php
require_once '../src/flash.php';
require_once "../src/constants.php";

session_start();
// must be authenticated
if (!isset($_SESSION['username'])) {
    header('Location: .');
    return;
}

$connection = pg_connect(CONNECTION_STRING) or die('Could not connect: ' . pg_last_error());
// get user_id
$query = 'SELECT id FROM users WHERE username = $1';
$params = array($_SESSION['username']);
$result = pg_query_params($connection, $query, $params) or die('Query failed: ' . pg_last_error());
$user_id = pg_fetch_result($result, 0, 'id');

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

$success = flash_success();
if (strlen($success) === 0) {
    $username = htmlentities($_SESSION['username']);
    $success = '<h2 style="color: green">Welcome, ' . $username . '!</h2>';
}

$body_template = 'todolist.php';
require_once '../templates/base_better.php';
