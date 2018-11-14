<?php
  session_start();
  if ($_SESSION["logged_in"] != "true") {
    header("Location: http://tracker.home/login.html");
  }
?>

<html>
<head>
  <title>Tracker</title>
</head>
<body>
  <h1>Working</h1>
</body>
</html>
