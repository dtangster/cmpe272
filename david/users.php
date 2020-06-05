<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>

<?php
  require 'navigation.php';

  $expected_user = 'admin';
  $expected_password = 'password';
  $user = $_POST['user'];
  $password = $_POST['password'];

  if ($user == $expected_user && $password == $expected_password) {
    echo '<section data-role="page" data-theme="b">';
    echo '<header data-role="header">';
    echo '<h1>Users page header</h1>';
    echo '</header>';
    echo '<article data-role="content">';
    $contacts_file = "static/resource/users.txt";
    $fd = fopen($contacts_file, "r") or die("Unable to open file!");
    while (($line = fgets($fd)) !== false) {
      echo "$line<br />";
    }
    fclose($fd);
    echo '<footer data-role="footer">';
    echo "<h1>User page footer</h1>";
    echo '</footer>';
  } else {
    echo "<strong>Invalid credentials!</strong>";
  }
?>
