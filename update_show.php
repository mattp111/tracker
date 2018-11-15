<?php

  $show_id = $_POST["id"];

  if ($show_id == "") {
    die("An error ocurred: No show id provided");
  }

  $server = "localhost";
  $db_name = "tracker";
  $username = "tracker";
  $password = "password";

  $conn = mysqli_connect($server, $username, $password, $db_name);

  if (!$conn) {
    die("Error: " . mysqli_connect_error());
  }

  $get_current = "SELECT current_episode,current_season,seasons,episodes FROM shows WHERE id={$show_id}";
  $result = mysqli_query($conn, $get_current);

  if (mysqli_num_rows($result) <= 0) {
    die("Error. No shows with that id found");
  }

  $row = mysqli_fetch_assoc($result);

  $current_episode = $row["current_episode"];
  $current_season = $row["current_season"];
  $seasons = $row["seasons"];
  $episodes = $row["episodes"];

  $updated_episode = $current_episode + 1;
  $updated_season = $current_season;
  if ($updated_episode > $episodes) {
    $updated_episode = 1;
    $updated_season += 1;
  }

  $query = "UPDATE shows SET current_episode={$updated_episode}, current_season={$updated_season} WHERE id={$show_id}";

  if(mysqli_query($conn, $query)) {
    header("Location: http://tracker.home/index.php");
  } else {
    echo "Error. ";
  }

  mysqli_close($conn);

 ?>
