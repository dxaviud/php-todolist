<ul>
  <li><a href='todolist.php'>Todolist</a></li>
  <li><a href='edit_todo.php?todo_id=<?=$todo_id?>'>Edit todo</a></li>
</ul>
<?=$success?>
<form id='newtodo'>
  <div><label for='todotitle'>Title:</label></div>
  <input type='text' name='todotitle' id='todotitle' value='<?=$todotitle?>' disabled/>
  <div><label for='tododescription'>Description:</label></div>
  <textarea name='tododescription' id='tododescription' form='newtodo' rows=6 cols=25 disabled><?=$tododescription?></textarea>
  <a href='delete_todo.php?todo_id=<?=$todo_id?>'><input type='button' value='Delete' style='color: red;'/></a>
</form>
