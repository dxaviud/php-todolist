<html>
<head>
  <title>Todolist app</title>
  <style>
    :root {
      --dark-color: #333;
      --light-color: #eee;
      --link-color: #539bf5;
    }

    * {
      font-family: Consolas, monaco, monospace;
    }

    body {
      background-color: var(--dark-color);
      color: var(--light-color);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 80%;
    }

    a, a:visited {
      color: var(--link-color);
    }

    form {
      width: min(90%, 500px);
      height: min(80%, 600px);
    }

    form.auth {
      width: min(90%, 340px);
      height: fit-content;
    }

    input, textarea {
      padding: 0.5em;
      width: 100%;
      margin-top: 1em;
      margin-bottom: 1em;
    }

    button, input, input:disabled, textarea, textarea:disabled {
      color: var(--light-color);
      background-color: var(--dark-color);
    }

    textarea {
      height: 60%;
      resize: vertical;
    }

    button {
      padding: 0.5em;
      width: min(90vw, 500px);
    }

    ul {
      transform: translateX(-1em);
    }

  </style>
</head>
<body>
  <h1>Todolist app</h1>
  <?php require_once __DIR__ . "/$body_template";?>
</body>
</html>
