<?php
include("db/mysql_connect.inc.php");

if (isset($_GET["key"])) {
    $email = $_GET["email"];
    $key = $_GET["key"];
    $sql = "SELECT recovery_key FROM recovery WHERE email = ? "
        . "AND recovery_key = ? AND date >= DATE_SUB(NOW(), INTERVAL 1 HOUR)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email, $key]);
    $rows = $stmt->fetchAll();

    foreach ($rows as $r) {
        if ($key == $r["recovery_key"]) {
            echo '<html lang="zxx"><head>';
            $title = "Password Reset";
            include("./components/head.php");

            echo '<link rel="stylesheet" href="css/admin.css" '
                . 'type="text/css"></head><body>';

            include("./components/header.php");

echo <<< EOT
    <div class="outerContainer">
        <div class="innerContainer">
            <div id="userLogin" style="display: block">
                <h3 class="formHeader">Password Reset</h3>
                <form action="reset_password.php" onsu class="contact-form" method="POST">
                    <div class="row">
                        <div class="col-lg-12">
                            <input id="password" name="password" type="password" placeholder="New password" required>
                            <input id="confirm_password" name="confirm_password" type="password" placeholder="Confirm password" required>
                        </div>
                        <div class="col-lg-12 text-center">
                            <button type="submit">Confirm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var password = document.getElementById("password");
        var confirm_password = document.getElementById("confirm_password");

        function validatePassword() {
            if (password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Passwords Don't Match");
            } else {
                confirm_password.setCustomValidity('');
            }
        }

        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;
    </script>
EOT;

            include("./components/scripts.html");
            echo '</body>/html>';
            return;
        }
    }
    echo "Invalid link";
    echo '<meta http-equiv=REFRESH CONTENT=2;url=/index.php>';
    return;
}

$email = $_POST["email"];
$sql = "SELECT email FROM user WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$email]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row["email"] == $email) {
    $key = bin2hex(random_bytes(16));
    $sql = "INSERT INTO recovery (email, recovery_key) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email, $key]);
    $msg = 'Please use this link to reset your password: '
         . 'http://mindcrunch.com/password_recover.php?'
         . "email=$email&key=$key";
    mail($email, "Password Reset", $msg);
}

// Redirect to login page and report that an email was sent. We don't want to leak
// which email address accounts actually exist.
header("Location: /admin.php?email=$email");
?>
