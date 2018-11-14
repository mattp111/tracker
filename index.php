<?php
  session_start();
  if ($_SESSION["logged_in"] != "true") {
    header("Location: http://tracker.home/login.html");
  }
?>

<html>
<head>
  <title>Tracker</title>
  <link rel="stylesheet" type="text/css" href="styles/main_page.css">
  <link rel='stylesheet' type="text/css" href='https://fonts.googleapis.com/css?family=Rubik'>
</head>
<body>
  <div class="menuBar">
    <a class="active logo" href="index.php">TRACKER</a>
    <a class="right" href="add_show.php">ADD SHOW</a>
    <a class="right" href="logout.php">LOGOUT</a>
  </div>

  <h1>Shows</h1>
  <?php
    session_start();
    $tracker_user = $_SESSION["username"];

    $server = "localhost";
    $db_name = "tracker";
    $username = "tracker";
    $password = "password";

    $conn = mysqli_connect($server, $username, $password, $db_name);

    if (!$conn) {
      die("Error: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM shows WHERE user='{$tracker_user}';";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) <= 0) {
      echo "<p>No shows added</p>";
    } else {
      while ($row = mysqli_fetch_assoc($result)) {
        $name = $row["show_name"];
        $seasons = $row["seasons"];
        $episodes = $row["episodes"];
        $current_season = $row["current_season"];
        $current_episode = $row["current_episode"];
        $eps_left_season = $episodes - $current_episode;
        $eps_left_show = ($seasons * $episodes) - ((($current_season - 1) * $episodes) + $current_episode);
        echo "<h3>{$name}</h3>";
        echo "<p>Seasons: {$seasons}</p>";
        echo "<p>Currently: Season {$current_season} Episode {$current_episode}</p>";
        echo "<p>{$eps_left_season} episodes left until the next season</p>";
        echo "<p>{$eps_left_show} episodes left in the show</p><br>";
      }
    }

    mysqli_close($conn);
   ?>
</body>
</html>
