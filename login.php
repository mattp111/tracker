<?php

  session_start();

  $config = include('config.php');
  $server = $config["server"];
  $db_name = "tracker";
  $username = "tracker";
  $password = $config["db_pass"];
  $user_username = $_POST["user"];
  $user_password = $_POST["pwd"];


  $conn = mysqli_connect($server, $username, $password, $db_name);

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $sql = "SELECT username, password FROM users WHERE username='{$user_username}';";

  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($user_password, $row["password"])) {
      session_start();
      $_SESSION["logged_in"] = "true";
      $_SESSION["username"] = $user_username;
      header("Location: index.php");
    }
  } else {
    echo "
    <html>
    <head>
    <title>Login</title>
    <link rel='stylesheet' type=\"text/css\" href='https://fonts.googleapis.com/css?family=Rubik'>
    <link rel='stylesheet' type=\"text/css\" href='styles/status_page.css'>
    </head>
    <body>
      <h1>Username or password incorrect</h1>
      <h3>Try again <a href=\"login.html\">here</a></h3>
    </body>
    </html>
    ";
  }

  mysqli_close($conn);

 ?>
