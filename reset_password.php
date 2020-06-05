<?php
session_start();
include("./db/mysql_connect.inc.php");

$referer = $_SERVER["HTTP_REFERER"];
$query_string = parse_url($referer, PHP_URL_QUERY);
$params = array();
parse_str($query_string, $params);
$email = $params["email"];
$key = $params["key"];
$password = $_POST["password"];

# Ensure the recovery key is still valid
$sql = "SELECT * FROM recovery WHERE email = ? AND recovery_key = ? "
     . "AND date >= DATE_SUB(NOW(), INTERVAL 1 HOUR) LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute([$email, $key]);
$rows = $stmt->fetch(PDO::FETCH_NUM);

if (count($rows) == 0) {
    header("Location: /");
    return;
}

// Update password hash so that the user can login with the new password
$salt = bin2hex(random_bytes(16));
$hash = password_hash($password . $salt, PASSWORD_BCRYPT);
$sql = "UPDATE user SET salt = ?, hash = ? WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$salt, $hash, $email]);

// Delete the remaining recovery keys
$sql = "DELETE FROM recovery WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$email]);

// Redirect them back to the login page
header("Location: /admin.php?reset=true");