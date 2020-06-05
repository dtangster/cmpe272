<?php
  require 'navigation.php';

  if (isset($_GET['search_value'])) {
    $search_field = $_GET['search_field'];
    $search_value = $_GET['search_value'];

    $db = new mysqli("localhost", "root", "egnyteelc", "cmpe272");
    if ($db->connect_errno) {
      echo "Failed to connect to MySQL: $db->connect_error";
    } else {
      echo '<table class="table">';
      if ($result = $db->query("SHOW COLUMNS FROM user")) {
        echo "<thead><tr>";

        while($row = $result->fetch_array(MYSQLI_NUM)) {
          echo "<th>$row[0]</th>";
        }

        echo "</thead></tr>";
      }

      if ($result = $db->query("select * from user where $search_field = '$search_value'")) {
        while($row = $result->fetch_array(MYSQLI_NUM)) {
          echo "<tr>";
          echo "<td>$row[0]</td>";
          echo "<td>$row[1]</td>";
          echo "<td>$row[2]</td>";
          echo "<td>$row[3]</td>";
          echo "<td>$row[4]</td>";
          echo "<td>$row[5]</td>";
          echo "</tr>";
        }
      }
      echo "<table/>";

      $db->close();
    }
  } else if (isset($_POST['first_name'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $home_phone = $_POST['home_phone'];
    $cell_phone = $_POST['cell_phone'];

    $db = new mysqli("localhost", "root", "egnyteelc", "cmpe272");
    if ($db->connect_errno) {
      echo "Failed to connect to MySQL: $db->connect_error";
    } else {
      $statement = $db->prepare("INSERT INTO user VALUES (?, ?, ?, ? ,? ,?)");
      $statement->bind_param("ssssss", $email, $first_name, $last_name,
	                               $address, $home_phone, $cell_phone);

      if ($statement->execute()) {
        echo "User created!";
      }
      else {
        echo "Failed to create user!";
      }

      $statement->close();
      $db->close();
    }
  }
?>

<div>
  <strong>Search User</strong><br />
  <form action="userlist.php" method="get">
    <label for="search_field">Search by</label>
    <select id="search_field" name="search_field">
      <option value="first_name">First name</option>
      <option value="last_name">Last name</option>
      <option value="email">Email</option>
      <option value="home_phone">Home phone</option>
      <option value="cell_phoone">Cell phone</option>
    </select><br />
    <input name="search_value" required />
    <button type="submit">Search</button>
  </form>
</div>
<div>
  <strong>Create User</strong><br />
  <form action="userlist.php" method="post">
    First name:<input name="first_name" required /><br />
    Last name:<input name="last_name" required /><br />
    Email:<input name="email" required /><br />
    Address:<input name="address" required /><br />
    Home phone:<input name="home_phone" required /><br />
    Cell phone:<input name="cell_phone" required /><br />
    <button type="submit">Submit</button>
  </form>
</div>
