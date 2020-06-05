<?php
session_start();
include("./db/mysql_connect.inc.php");

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT email, salt, hash FROM user where email = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$email]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row != null) {
    $salt = $row["salt"];
    $hash = $row["hash"];

    if (password_verify($password . $salt, $hash)) {
        $_SESSION["email"] = $email;
        header("Location: /");
    } else {
        header("Location: ../admin.php?error=failed");
    }
} else {
    header("Location: ../admin.php?error=failed");
}
?>
