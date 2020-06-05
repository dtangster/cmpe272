<?php 

// $host = "localhost";
// $username = "root";
// $pass = "egnyteelc";

// $db= new mysqli($host,$username,$pass,"cmpe272");
// if($db->connect_error)
// {
//     echo "ERROR: (".$db->connect_errno.") ".$db->connect_error;
//     exit();
// }

function openDb() {
    $host = "localhost";
    $username = "root";
    $pass = "egnyteelc";

    $db= new mysqli($host,$username,$pass,"cmpe272");
    if($db->connect_error)
    {
        echo "ERROR: (".$db->connect_errno.") ".$db->connect_error;
        exit();
    }

    return $db;
}

function closeDb($db) {
    $db->close();
}

// function curlProducts() {
//     $products = [];
//     $tracey = "./db/getProducts.php";
// 	$david = "http://mindcrunch.com/marketplace.php";
// 	$zan = "http://zanjavednow.tech/products";
//     $marketplaces = [$tracey, $david, $zan];

//     foreach ($marketplaces as $link) {
//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_URL, $link);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//         curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
//                 'Accept: application/json',                                                                       
//             )
//         );
//         $contents = curl_exec($ch);
//         array_push(json_decode($contents), $products);
//         curl_close($ch);
//     }

//     return $products;
// }

// function addProductRatings($db, $products) {
//     foreach ($products as $name) {
//         $sql = "INSERT INTO MyGuests (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')";
//     }
// }

// print_r(curlProducts());
// mysqli_close($db);
?>
