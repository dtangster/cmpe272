<?php

include("mysql_connect.inc.php");

$em = $_POST['email'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM user_list where Email = '$em'"); 
    $stmt->execute();
    echo '<br>';
    $email = array();
    $firstname = array();
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
        echo '<li class="list-group-item list-group-item-info">'.$row['FirstName']. " " .$row['LastName']. ", Email: " .$row["Email"]. '</li>';
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>