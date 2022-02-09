<?php
    session_start();
    if (!isset($_SESSION['username'])) { // not logged in, redirect to index
        header("Location: index.php");
        return;
    }

    $todoitems = array(
        "<li><a href=''>Learn PHP</a></li>",
        "<li><a href=''>Learn Laravel</a></li>",
        "<li><a href=''>Learn Python</a></li>",
        "<li><a href=''>Learn Django</a></li>"
    );
    $todolist = implode('', $todoitems);

    $success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
    unset($_SESSION['success']);
    if (strlen($success) === 0) {
        $username = htmlentities($_SESSION['username']);
        $success = "Welcome, $username!";
    }

    $list = "
    <h2 style='color: green'>$success</h2>
    <util>
        <li><a href='logout.php'>Logout</a></li>
    </util>
    <h3>Your todolist:</h3>
    <ul>
    $todolist
    </ul>";

    $todotitle = isset($_POST['todotitle']) ? htmlentities($_POST['todotitle']) : '';
    $tododescription = isset($_POST['tododescription']) ? htmlentities($_POST['todotitle']) : '';
    $form = "
    <form method='post' id='newtodoitem'>
    <div>Add a new todo item:</div>
    <div><label for='todotitle'>Title:</label></div>
    <input type='text' name='todotitle' id='todotitle' value='$todotitle' />
    <div><label for='tododescription'>Description:</label></div>
    <textarea name='tododescription' id='tododescription' form='newtodoitem' rows=6 cols=25>$tododescription</textarea>
    <input type='submit' />
    </form>";

    require 'templates/base.php';
?>
