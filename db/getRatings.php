<?php
    // include "../connectDB.php";
    include "./connectDB.php";

    // $db = openDb();
    // $productName = $_GET['productName'];
    // $sql = "select * from product_rating where name='$productName'";
    // // $sql = "select * from product_rating where name='Keyboard'";
    // $result = $db->query($sql);
    // if ($result->num_rows > 0) {
    //     // // output data of each row
    //     // while($row = $result->fetch_assoc()) {
    //     //     echo "id: " . $row["id"]. " - Name: " . $row["name"]. " " . $row["rating"]. "<br>";
    //     // }
    //     echo json_encode($result->fetch_assoc());
    // } else {
    //     echo json_encode([]);
    // }

    // // $sql = "select * from product_rating";
    // // $result = $db->query($sql);
    // // $products = array();
    // // if ($result->num_rows > 0) {
    // //     $json = mysqli_fetch_all ($result, MYSQLI_ASSOC);
    // //     echo json_encode($json);
    // // } else {
    // //     echo json_encode([]);
    // // }
    // closeDb($db);

    function getRatings($productName) {
        $db = openDb();
        // $productName = $_GET['productName'];
        $sql = "select * from product_rating where name='$productName'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return [];
        }

        closeDb($db);
    }
?>