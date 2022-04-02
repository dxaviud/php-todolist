<ul>
  <li><a href='todolist.php'>Todolist</a></li>
</ul>
<?=$error?>
<form method='post' id='newtodo'>
  <div><label for='todotitle'>Title:</label></div>
  <input type='text' name='todotitle' id='todotitle' value='<?=$todotitle?>' required/>
  <div><label for='tododescription'>Description:</label></div>
  <textarea name='tododescription' id='tododescription' form='newtodo' required><?=$tododescription?></textarea>
  <input type='submit' value='Update' />
</form>
