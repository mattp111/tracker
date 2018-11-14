<?php

  session_start();

  $server = "localhost";
  $db_name = "tracker";
  $username = "tracker";
  $password = "password";
  $user_username = $_POST["user"];
  $user_password = $_POST["pwd"];


  $conn = mysqli_connect($server, $username, $password, $db_name);

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $sql = "SELECT username, password FROM users WHERE username='{$user_username}' AND password='{$user_password}';";

  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($row["username"] != $user_username && $row["password"] != $user_password) {
      die("Login failed");
    } else {
      $_SESSION["logged_in"] = "true";
      header("Location: http://tracker.home/index.php/");
    }
  } else {
    echo "Login failed";
  }

  mysqli_close($conn);

 ?>
