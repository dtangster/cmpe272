<?php
  require 'navigation.php';

  print_r($_SESSION["page_stack"]);
  print_r($_SESSION["page_visits"]);
  echo "<br /><h2>Top 5 Visited Product Links</h2><ul>";

  $max = 5;
  foreach($_SESSION["page_visits"] as $site => $count) {
    if ($max <= 0) {
      break;
    }
    echo "<li><a href=\"{$site}\">{$site}</a> Visited: {$count}</li>";
    $max--;
  }
  echo "</ul><br />";

  echo "<h2>5 Previously Visited Product Links</h2><ul>";

  $max = 5;
  foreach($_SESSION["page_stack"] as $site) {
    if ($max <= 0) {
      break;
    }
    echo "<li><a href=\"{$site}\">{$site}</a></li>";
    $max--;
  }

  echo "</ul>";
?>
