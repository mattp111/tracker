<?php
  session_start();
  if ($_SESSION["logged_in"] != "true") {
    header("Location: login.html");
  }
?>

<html>
<head>
  <title>Tracker</title>
  <link rel="stylesheet" type="text/css" href="styles/main_page.css">
  <link rel="stylesheet" type="text/css" href="styles/menu_bar.css">
  <link rel="stylesheet" type="text/css" href="styles/border.css">
  <link rel='stylesheet' type="text/css" href='https://fonts.googleapis.com/css?family=Rubik'>
</head>
<body>
  <script type="text/javascript">
  // https://stackoverflow.com/questions/133925/javascript-post-request-like-a-form-submit
  function post(path, params, method) {
      method = method || "post"; // Set method to post by default if not specified.

      // The rest of this code assumes you are not using a library.
      // It can be made less wordy if you use one.
      var form = document.createElement("form");
      form.setAttribute("method", method);
      form.setAttribute("action", path);

      for(var key in params) {
          if(params.hasOwnProperty(key)) {
              var hiddenField = document.createElement("input");
              hiddenField.setAttribute("type", "hidden");
              hiddenField.setAttribute("name", key);
              hiddenField.setAttribute("value", params[key]);

              form.appendChild(hiddenField);
          }
      }

      document.body.appendChild(form);
      form.submit();
  }

    function watchEpisode(button) {
      var show_id = button.id;

      post("update_show.php", {id: show_id});
    }
  </script>

  <div class="menuBar">
    <a class="active logo left" href="index.php">TRACKER</a>
    <a class="right" href="logout.php">LOGOUT</a>
    <a class="right" href="add_show.php">ADD SHOW</a>
  </div>

  <h1>Shows</h1>
  <div id="shows" style="text-align: center;">
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
        $id = $row["id"];
        $name = $row["show_name"];
        $seasons = $row["seasons"];
        $episodes = $row["episodes"];
        $current_season = $row["current_season"];
        $current_episode = $row["current_episode"];
        $eps_left_season = $episodes - $current_episode;
        $eps_left_show = ($seasons * $episodes) - ((($current_season - 1) * $episodes) + $current_episode);
        if ($current_season > $seasons) {
          echo "
          <div class=\"border\">
            <h3>{$name}</h3>
            <h1 class=\"centered\">Show finished!</h1>
            <br><br><br>
            <button id=\"{$id}\" onclick=\"deleteShow(this)\" class=\"niceButton\">DELETE<br>SHOW</button><br><br>
          </div>";
        } else {
          echo "
          <div class=\"border\">
            <h3>{$name}</h3>
            <p>Seasons: {$seasons}</p>
            <p>Currently: Season {$current_season} Episode {$current_episode}</p>
            <p>{$eps_left_season} episodes left until the next season</p>
            <p>{$eps_left_show} episodes left in the show</p><br>
            <button id=\"{$id}\" onclick=\"watchEpisode(this)\" class=\"niceButton\">I WATCHED AN<br>EPISODE</button><br><br>
            </div>
            ";
        }
      }
    }

    mysqli_close($conn);
   ?>
 </div>
</body>
</html>
