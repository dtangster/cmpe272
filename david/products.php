<?php
  require 'navigation.php';

  print_r($_SESSION["page_stack"]);
  echo "<br />";
  print_r($_SESSION["page_visits"]);
?>

<h1>Products</h1>
<ul>
  <li><a href="most_visited.php">Most Visited</a></li>
  <li><a href="motherboard.php">Motherboard</a></li>
  <li><a href="cpu.php">CPU</a></li>
  <li><a href="memory.php">Memory</a></li>
  <li><a href="storage.php">Storage</a></li>
  <li><a href="router.php">Router</a></li>
  <li><a href="monitor.php">Monitor</a></li>
  <li><a href="mouse.php">Mouse</a></li>
  <li><a href="keyboard.php">Keyboard</a></li>
  <li><a href="cable.php">Cable</a></li>
  <li><a href="software.php">Software</a></li>
</ul>
