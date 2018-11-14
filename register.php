<?php

  $server = "localhost";
  $db_name = "tracker";
  $username = "tracker";
  $password = "password";
  $user_username = $_POST["user"];
  $user_pass = $_POST["pass"];

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
    echo "User registerd<br>";
    echo 'Login <a href="login.html">here</a>';
  } else {
    echo mysqli_error($conn);
  }

  mysqli_close($conn);

 ?>
