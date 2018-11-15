<?php

  if ($_POST["db_host"]) {
    $server = $_POST["db_host"];
    $db_uname = $_POST["db_user"];
    $db_pass = $_POST["db_pass"];

    $conn = mysqli_connect($server, $db_uname, $db_pass);

    if (!$conn) {
      die("Error: " . mysqli_connect_error());
    }

    $create_db = "CREATE DATABASE tracker;";
    $create_user = "CREATE USER 'tracker'@'{$server}' IDENTIFIED BY '{$db_pass}';";
    $grant_privs = "GRANT ALL PRIVILEGES ON tracker . * TO 'tracker'@'{$server}';";
    $flush = "FLUSH PRIVILEGES;";
    $use_db = "USE tracker;";
    $create_user_table = "CREATE TABLE users (
    username varchar(255),
    password varchar(255)
    );";
    $create_table_shows = "CREATE TABLE shows (
    id int NOT NULL AUTO_INCREMENT,
    user varchar(255),
    show_name varchar(255),
    seasons int,
    episodes int,
    current_season int,
    current_episode int,
    PRIMARY KEY (id)
    );";

    if (!mysqli_query($conn, $create_db)) {
      die("Error. Creating database");
    }

    if (!mysqli_query($conn, $create_user)) {
      die("Error. Creating user");
    }

    if (!mysqli_query($conn, $grant_privs)) {
      die("Error. Granting privileges");
    }

    if (!mysqli_query($conn, $flush)) {
      die("Error. Flushing privileges");
    }

    if (!mysqli_query($conn, $use_db)) {
      die("Error. Select database");
    }

    if (!mysqli_query($conn, $create_user_table)) {
      die("Error. Creating users table");
    }

    if (!mysqli_query($conn, $create_table_shows)) {
      die("Error. Creating shows table");
    }

    $config_file = fopen("config.php", "w") or die("Error. Cannot open config.php for writing");
    $config_text = "
    <?php
      return array(
          'server' => '{$server}',
          'db_pass' => '${db_pass}',
        );
    ?>
    ";

    fwrite($config_file, $config_text);
    fclose($config_file);

    mysqli_close($conn);

    header("Location: index.php");

  }

 ?>

<!DOCTYPE html>
<html>
<head>
  <title>Add show</title>
  <link rel="stylesheet" type="text/css" href="styles/forms.css">
  <link rel="stylesheet" type="text/css" href="styles/menu_bar.css">
  <link rel="stylesheet" type="text/css" href="styles/nice_button.css">
  <link rel='stylesheet' type="text/css" href='https://fonts.googleapis.com/css?family=Rubik'>
</head>
<body>
  <div class="menuBar">
    <a class="left" href="index.php" style="font-size: 35px;">TRACKER</a>
  </div>

  <div class="form">
    <h1>SETUP</h1>

    <form action="setup.php" method="post">
      Database host: <input type="text" name="db_host" placeholder="localhost"><br><br>
      Root database user: <input type="text" name="db_user" placeholder="root"><br><br>
      Root database password: <input type="password" name="db_pass"><br><br>
      <button class="niceButton" type="submit">SETUP<br>DATABASE</button>
    </form>
    <br>
  </div>
</body>
</html>
