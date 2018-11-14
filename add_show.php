<?php

  session_start();
  if ($_SESSION["logged_in"] != "true") {
    die("Not logged in");
  }

  if ($_POST["name"]) {
    $show_name = $_POST["name"];
    $seasons = $_POST["seasons"];
    $episodes = $_POST["episodes"];
    $tracker_user = $_SESSION["username"];

    $server = "localhost";
    $db_name = "tracker";
    $username = "tracker";
    $password = "password";

    $conn = mysqli_connect($server, $username, $password, $db_name);

    if (!$conn) {
      die("Error: " . mysqli_connect_error());
    }

    $query = "INSERT INTO shows (user, show_name, seasons, episodes, current_season, current_episode) VALUE ('{$tracker_user}', '{$show_name}', {$seasons}, ${episodes}, 1, 1);";
    echo $query;
    $exists_check = "SELECT show_name FROM shows WHERE user='{$tracker_user}' AND show_name='{$show_name}';";

    $result_check = mysqli_query($conn, $exists_check);

    if (mysqli_num_rows($result_check) > 0) {
      die("There is already a show with the same name");
    }

    if (mysqli_query($conn, $query)) {
      header("Location: http://tracker.home/index.php");
      die();
    }

    mysqli_close($conn);
  }

 ?>

<!DOCTYPE html>
<html>
<head>
  <title>Add show</title>
  <link rel="stylesheet" type="text/css" href="styles/forms.css">
  <link rel='stylesheet' type="text/css" href='https://fonts.googleapis.com/css?family=Rubik'>
</head>
<body>
  <div class="menuBar">
    <h1 style="text-align: left;"><a id="homeLink" href="index.php">TRACKER</a></h1>
  </div>

  <div class="form">
    <h1>ADD A SHOW</h1>

    <form action="add_show.php" method="post">
      <input type="text" name="name" placeholder="Show name"><br><br>
      <input type="number" name="seasons" placeholder="Number of seasons"><br><br>
      <input type="number" name="episodes" placeholder="Episodes per season"><br><br>
      <button type="submit">ADD SHOW</button>
    </form>
    <br>
  </div>
</body>
</html>
