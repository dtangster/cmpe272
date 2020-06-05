<?php
    include("mysql_connect.inc.php");

    $referer = $_SERVER["HTTP_REFERER"];
    $query = "SELECT date, rating, comment FROM review where url = ?";
    $statement = $conn->prepare($query);
    $statement->execute([$referer]);
    $result = $statement->fetchAll();

    header('Content-Type: application/json');
    echo json_encode($result);
?>