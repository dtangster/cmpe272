
<?php
session_start();
include("mysql_connect.inc.php");

$em = $_POST['email'];
$pw = $_POST['password'];
$pw2 = $_POST['password2'];
$fn = $_POST['firstname'];
$ln = $_POST['lastname'];
$add = $_POST['address'];
$hp = $_POST['homePhone'];
$cp = $_POST['cellPhone'];

if ($em != null && $pw != null && $pw2 != null && $pw == $pw2 && $fn != null && $ln != null) {
    $sql = "SELECT email FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$em]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row['email'] == $em) {
        header("Location: /register.php?exists=$em");
    } else {
        $salt = bin2hex(random_bytes(16));
        $hash = password_hash($pw . $salt, PASSWORD_BCRYPT);
        $sql = "INSERT INTO user VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$em, $salt, $hash, $fn, $ln, $add, $hp, $cp]);
        $_SESSION["email"] = $em;
        echo 'Account Created!';
        echo '<meta http-equiv=REFRESH CONTENT=2;url=/index.php>';
    }
} else {
    echo 'No right to visit this page!';
    echo '<meta http-equiv=REFRESH CONTENT=2;url=/index.php>';
}
?>