<?php
    // $product = $_GET["product"];
    // $json = json_decode(file_get_contents("productReview.json"), true);

    // if(array_key_exists($product, $json)) 
    //     // echo json_encode($json[$product]);
    //     return $json[$product];
    // else
    //     // echo json_encode([]);
    //     return [];

    function getReviews($product) {
        // $product = $_GET["product"];
        $json = json_decode(file_get_contents("./db/productReview.json"), true);

        if(array_key_exists($product, $json)) 
            // echo json_encode($json[$product]);
            return $json[$product];
        else
            // echo json_encode([]);
            return [];
    }
?>