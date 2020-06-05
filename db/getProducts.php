<?php
try {
    include("mysql_connect.inc.php");
    $stmt = $conn->prepare("SELECT * FROM product_list"); 
    $stmt->execute();
    $res = array();
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
        $res[] = array('productName' => $row['productName'],
                       'price' => $row['price'],
		       'id' => $row['id'],
                       'picture' => $row['picture']);
    }
    header('Content-Type: application/json');
    echo json_encode($res);
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
