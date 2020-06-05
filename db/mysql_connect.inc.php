<?php
$servername = "localhost";
$username = "root";
$password = "egnyteelc";
$dbname = "cmpe272";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
