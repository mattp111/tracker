<?php

  $config = include('config.php');
  $server = $config["server"];
  $db_name = "tracker";
  $username = "tracker";
  $password = $config["db_pass"];
  $user_username = $_POST["user"];
  $user_pass = $_POST["pass"];

  $user_pass = password_hash($user_pass, PASSWORD_DEFAULT);

  $conn = mysqli_connect($server, $username, $password, $db_name);

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $query = "INSERT INTO users (username, password) VALUES ('{$user_username}', '{$user_pass}');";
  $user_check = "SELECT username FROM users WHERE username='{$user_username}';";

  $check_result = mysqli_query($conn, $user_check);

  if (mysqli_num_rows($check_result) > 0) {
    mysqli_close($conn);
    die("A user already exists with that name");
  }

  if (mysqli_query($conn, $query)) {
    echo "
    <html>
    <head>
    <title>Register</title>
    <link rel='stylesheet' type=\"text/css\" href='https://fonts.googleapis.com/css?family=Rubik'>
    <link rel='stylesheet' type=\"text/css\" href='styles/status_page.css'>
    <body>
      <h1>User registered</h1>
      <h3>Login <a href=\"login.html\">here</a></h3>
    </body>
    </html>
    ";
  } else {
    echo mysqli_error($conn);
  }

  mysqli_close($conn);

 ?>
