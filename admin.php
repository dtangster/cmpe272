<!DOCTYPE html>
<html lang="zxx">

<head>
    <?php
    $title = "Admin Login";
    include("./components/head.php");
    ?>
    <link rel="stylesheet" href="css/admin.css" type="text/css">
</head>

<body>
    <?php include("./components/header.php"); ?>
    <div class="outerContainer">
        <div class="innerContainer">
            <?php
            if (isset($_GET['error'])) {
                echo '<div class="alert alert-danger" role="alert">Login Failed</div>';
            } else if (isset($_GET['email'])) {
                echo '<div class="alert alert-info" role="alert">Password reset instructions sent to '
                   . $_GET['email'] . "</div>";
            } else if (isset($_GET['reset'])) {
                echo '<div class="alert alert-success" role="alert">Password reset successful</div>';
            }
            ?>
            <div id="forgotPassword" style="display: none">
                <h3 class="formHeader">Forgot Password</h3>
                <form action="/password_recover.php" class="contact-form" method="POST">
                    <div class="row">
                        <div class="col-lg-12">
                            <input name="email" type="email" autocomplete="off" placeholder="Email">
                        </div>
                        <div class="col-lg-12 text-center">
                            <button type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

            <div id="userLogin">
                <h3 class="formHeader">Login</h3>
                <form action="/login.php" class="contact-form" method="POST">
                    <div class="row">
                        <div class="col-lg-12">
                            <input name="email" type="email" autocomplete="off" placeholder="Email">
                            <input name="password" type="password" autocomplete="off" placeholder="Password">
                        </div>
                        <div class="col-lg-12 text-center">
                            <button type="submit">Login</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="toggleLogin">
                <div class="toggleButton" id="forgotPasswordButton">Forget Password</div>
                <div class="toggleButton" id='userLoginButton'>Login</div>
            </div>
        </div>
    </div>
    <?php include("./components/scripts.html"); ?>

    <script>
        document.getElementById("forgotPasswordButton").addEventListener("click", function() {
            document.getElementById("forgotPassword").style.display = "block";
            document.getElementById("userLogin").style.display = "none";
        });
        document.getElementById("userLoginButton").addEventListener("click", function() {
            document.getElementById("forgotPassword").style.display = "none";
            document.getElementById("userLogin").style.display = "block";
        });
    </script>
</body>

</html>