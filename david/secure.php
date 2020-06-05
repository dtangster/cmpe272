<?php
  require 'navigation.php';

  $expected_user = 'admin';
  $expected_password = 'password';
  $user = $_POST['user'];
  $password = $_POST['password'];

  if ($user == $expected_user && $password == $expected_password) {
    echo "<strong>Users</strong><br /><br />";
    $contacts_file = "static/resource/users.txt";
    $fd = fopen($contacts_file, "r") or die("Unable to open file!");
    while (($line = fgets($fd)) !== false) {
      echo "$line<br />";
    }
    fclose($fd);
  } else {
    echo "<strong>Invalid credentials!</strong>";
  }
?>
