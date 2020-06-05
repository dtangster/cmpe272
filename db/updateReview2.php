<?php
    include("mysql_connect.inc.php");
    session_start();

    $referer = $_SERVER["HTTP_REFERER"];
    if (!isset($_SESSION["email"])) {
        header("Location: $referer");
        return;
    }

    $query_string = parse_url($referer, PHP_URL_QUERY);
    $params = array();
    parse_str($query_string, $params);
    $source = $params["source"];

    $email = $_SESSION["email"];
    $product_name = $_POST["product_name"];
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];
    $query = "INSERT INTO review (product_name, source, url, email, rating, comment) VALUES (?, ?, ?, ?, ?, ?)";
    $statement = $conn->prepare($query);
    $statement->execute([$product_name, $source, $referer, $email, $rating, $comment]);
    header("Location: $referer");
?>
