<?php
  // If the `Accept: application/json`, then provide a JSON structure
  // so that my teammate can consume my users. If the header is not set,
  // render  my own page that will also include my partner's users.
  $accept = getallheaders()["accept"];

  if ($accept == "application/json") {
    $db = new mysqli("localhost", "root", "egnyteelc", "cmpe272");
    if ($db->connect_errno) {
      echo "Failed to connect to MySQL: $db->connect_error";
    } else {

      if ($result = $db->query("select * from user")) {
        $data = json_encode($result->fetch_all(MYSQLI_ASSOC));
        echo $data;
      }

      $db->close();
    }
  } else {
    $db = new mysqli("localhost", "root", "egnyteelc", "cmpe272");
    if ($db->connect_errno) {
      echo "Failed to connect to MySQL: $db->connect_error";
      return;
    } else {
      echo '<table class="table">';
      if ($result = $db->query("SHOW COLUMNS FROM user")) {
        echo "<thead><tr><th>Source</th>";
        while($row = $result->fetch_array(MYSQLI_NUM)) {
          echo "<th>$row[0]</th>";
        }

        echo "</thead></tr>";
      }

      if ($result = $db->query("select * from user")) {
        while($row = $result->fetch_array(MYSQLI_NUM)) {
          echo "<tr>";
          echo "<td>mindcrunch.com</td>";
          echo "<td>$row[0]</td>";
          echo "<td>$row[1]</td>";
          echo "<td>$row[2]</td>";
          echo "<td>$row[3]</td>";
          echo "<td>$row[4]</td>";
          echo "<td>$row[5]</td>";
          echo "</tr>";
        }
      }

      $db->close();
    }

    $ch = curl_init("http://zanjavednow.tech/getlistofusers");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $body = json_decode(curl_exec($ch));
    curl_close ($ch);

    foreach ($body as $_key => $users) {
      foreach ($users as $user) {
          echo "<tr>";
          echo "<td>zanjavednow.tech</td>";
          // These are the only 3 fields provided in my partner's JSON structure
          echo "<td>" . $user->{'email'} . "</td>";
          echo "<td>" . $user->{'firstName'} . "</td>";
          echo "<td>" . $user->{'lastName'} . "</td>";
          echo "</tr>";
      }
    }

    echo "</table>";
  }

?>
