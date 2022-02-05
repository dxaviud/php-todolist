<?php
    $username = htmlentities("<username>");
    $todoitems = array(
        "<li><a href=''>Learn PHP</a></li>",
        "<li><a href=''>Learn Laravel</a></li>",
        "<li><a href=''>Learn Python</a></li>",
        "<li><a href=''>Learn Django</a></li>"
    );
    $todolist = implode('', $todoitems);
    $list = "
    <h2>Welcome $username!</h2>
    <ul>
        <li><a href='.'>Logout</a></li>
    </ul>
    <h3>Your todolist:</h3>
    <ul>
    $todolist
    </ul>";

    require 'util.php';
    $todotitle = sanitize_POST('todotitle');
    $tododescription = sanitize_POST('tododescription');
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
