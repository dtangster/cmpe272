<?php
  session_start();

  if (!isset($_SESSION["page_visits"])) {
    $_SESSION["page_visits"] = array();
  }
  if (!isset($_SESSION["page_stack"])) {
    $_SESSION["page_stack"] = array();
  }
?>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<!-- Google Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.14.1/css/mdb.min.css" rel="stylesheet">

<ul>
  <li><a href="index.php">Home</a></li>
  <li><a href="about.php">About</a></li>
  <li><a href="products.php">Products/Services</a></li>
  <li><a href="news.php">News</a></li>
  <li><a href="contacts.php">Contacts</a></li>
  <li><a href="authenticate.php">Users (hardcoded user:admin password:password)</a></li>
  <li><a href="userlist.php">Users (MySQL)</a></li>
  <li><a href="all_users.php">Combined Users (MySQL + curl -> http://zanjavednow.tech/getlistofusers)</a></li>
</ul>
