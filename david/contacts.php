<?php
  require 'navigation.php';

  $contacts_file = "static/resource/contacts.txt";
  $fd = fopen($contacts_file, "r") or die("Unable to open file!");
  echo fread($fd, filesize($contacts_file));
  fclose($fd);
?>
