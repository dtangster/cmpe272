<?php
  require 'navigation.php';
o
  $page_stack = $_SESSION["page_stack"];
  array_unshift($page_stack, __FILE__);
  if (count($page_stack) > 5) {
    array_pop($page_stack);
  }
  $_SESSION["page_stack"] = $page_stack;
  print_r($page_stack);
  echo "<br />";

  $page_visits = $_SESSION["page_visits"];
  if (isset($page_visits[__FILE__])) {
    $page_visits[__FILE__]++;
  } else {
    $page_visits[__FILE__] = 1;
  }

  arsort($page_visits);
  $_SESSION["page_visits"] = $page_visits;
  print_r($page_visits);
?>

<br />
<img src="static/resource/cable.jpg">
<p>Our cables are out of stock. Please check back later.</>

