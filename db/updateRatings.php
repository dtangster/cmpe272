<?php
    include "../connectDB.php";

    $db = openDb();
    $productName = $_POST['productName'];
    // $productName = str_replace('+', ' ', $_POST['productName']);
    $value = $_POST['value'];
    // $productName = 'Keyboard';
    // $value = 1;

    $sql = "update product_rating set rating=$value where name='$productName'";
    $result = $db->query($sql);

    // if ($db->query($sql) === TRUE) {
    //     echo "Record updated successfully";
    // } else {
    //     echo "Error updating record: " . $db->error;
    // }

    closeDb($db);
?>