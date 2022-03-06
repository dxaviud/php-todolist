<?php
require_once '../src/constants.php';
?>
<html>
<head>
    <title>Todolist app</title>
    <script src="https://code.jquery.com/jquery-3.6.0<?=true ? '.min' : ''?>.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
</head>
<body>
    <h1>Todolist app</h1>
    <?=$list?>
    <?=$form?>
    <?=$script?>
</body>
</html>

