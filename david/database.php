<?php
  require 'navigation.php';

  $db = new mysqli("localhost", "root", "egnyteelc", "cmpe272");
  if ($db->connect_errno) {
    echo "Failed to connect to MySQL: " . $db->connect_error;
  } else {
    echo "<table class=\"table\">";

    if ($result = $db->query("SHOW COLUMNS FROM user")) {
      echo "<thead><tr>";

      while($row = $result->fetch_array(MYSQLI_NUM)) {
        echo "<th>$row[0]</th>";
      }

      echo "</thead></tr>";
    }

    echo "<table/>";
  }
?>
