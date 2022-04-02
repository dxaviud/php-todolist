<?=$success?>
<ul>
  <li><a href='logout.php'>Logout</a></li>
</ul>
<h3>Your todolist:</h3>
<ul style='width: max-content'>
<?=$todolist?>
</ul>

<div style='margin-top: 50px'></div>
<a href='create_todo.php'><button id='create-todo'>Create a new todo</button></a>
<div style='margin-top: 100px'></div>
<a href='delete_account.php'><button style='color: red; width: 200px'>Delete account</button></a>
