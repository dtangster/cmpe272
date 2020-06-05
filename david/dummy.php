<?php
    error_reporting(E_ALL);
    $products = array(
        array("productName" => "CPU",
              "description" => "Some used CPU",
              "picture" => "http://mindcrunch.com/static/resource/cpu.jpg",
	      "price" => "$299.00")
    );

    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json');
    print(json_encode($products));
?>
