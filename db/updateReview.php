<?php
    // $fh = fopen("/var/www/html/db/productReview.json", "a");
    // $fh = fopen("productReview.json", "a");

    // print_r($_POST);
    // print_r($_GET);

    $product = $_POST['product'];
    // $product = str_replace('+', ' ', $_POST['product']);
    $review = $_POST['review'];
    $source = $_POST['source'];
    $price = $_POST['price'];
    $picture = $_POST['picture'];
    // $json = json_decode(file_get_contents("productReview.json"), true);
    $json = json_decode(file_get_contents("productReview.json"), true);
    // print_r($json);
    if(!array_key_exists($product, $json)) {
        $json[$product] = [];
    }

    if($review) {
        array_push($json[$product], "[".date("Y-m-d:H-i-s")."]Anonymous: ".$review);

        $fh = fopen("productReview.json", "w");
        fwrite($fh, json_encode($json));
        fclose($fh);
    }

    // print_r($json);

    // header("Location: http://mindcrunch.com/product-page.php?source=mindcrunch.com&productName=CPU&price=$299.00&picture=http://mindcrunch.com/david/static/resource/cpu.jpg");
    header("Location: http://mindcrunch.com/product_detail.php?source=$source&productName=$product&price=$price&picture=$picture");
?>
