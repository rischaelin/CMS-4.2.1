<?php
require_once (__DIR__ . '/includes/db.php');
require_once (__DIR__ . '/includes/functions.php');
require_once (__DIR__ . '/includes/sessions.php');
require_once (__DIR__ . '/includes/dataTime.php');

error_reporting (E_ALL | E_STRICT);
ini_set ("display_errors", 1);
if (isset($_POST['Submit'])) {
    $userName = $_POST['userName'];
    $password = $_POST['password'];
    if (empty($userName) || empty($password)) {
        $_SESSION['ErrorMessage'] = 'All fields must be filled out';
        redirectTo ('login.php');
    } else {
        // code for checking username and password from Database
        $found_Account = login_Attempt($userName, $password);
        if ($found_Account) {
            $_SESSION["userId"] = $found_Account->id;
            $_SESSION["userName"] = $found_Account->username;
            $_SESSION["adminName"] = $found_Account->aname;
            $_SESSION["SuccessMessage"] = 'Welcome ' . $_SESSION['adminName'];
            redirectTo ('login.php');
        } else {
            $_SESSION['ErrorMessage'] = 'Incorrect Username/Password';
            redirectTo ('login.php');
        }
    }
}


?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible"
            content="ie=edge">
    <meta name="viewport"
            content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet"
            href="./dist/css/main.css">

    <title>
        Login</title>
</head>
<body>
<!-- Navbar -->
<div style="height: 10px; background: #27aae1;"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a href="index.html"
                class="navbar-brand">RICHIS.COM</a>
        <button class="navbar-toggler"
                data-toggle="collapse"
                data-target="#navbarcollapseCMS">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse"
                id="navbarcollapseCMS">
        </div>
    </div>
</nav>
<div style="height: 10px; background: #27aae1;"></div>
<! --
Navbar
End
-->

<! --
Haeder
-->
<header class="bg-dark text-white py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            </div>
        </div>
    </div>
</header>
<! --
Header
End
-->
<! --
Main
Area
Start
-->
<section
        class="container py-2 mb-4">
    <div class="row">
        <div class="offset-sm-3 col-sm-6"
                style="min-height: 400px;">
            <?php
            echo errorMessage ();
            echo successMessage ();
            ?>
            <div class="card badge-secondary text-light mt-5">
                <div class="card-header">
                    <h4>
                        Wellcom
                        Back
                        !</h4>
                </div>
                <div class="card-body bg-dark">
                    <form class=""
                            action="login.php"
                            method="post">
                        <div class="form-group">
                            <label for="username"><span
                                        class="FieldInfo">Username:</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-info text-white"> <i
                                                class="fas fa-user"></i> </span>
                                </div>
                                <input type="text"
                                        class="form-control"
                                        name="userName"
                                        id="username"
                                        value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password"><span
                                        class="FieldInfo">Password:</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-info text-white"> <i
                                                class="fas fa-lock"></i> </span>
                                </div>
                                <input type="password"
                                        class="form-control"
                                        name="password"
                                        id="password"
                                        value="">
                            </div>
                        </div>
                        <input type="submit"
                                name="Submit"
                                class="btn btn-info btn-block"
                                value="Login">
                    </form>
                </div>

            </div>

        </div>
    </div>

</section>
<! --
Main
Area
End
-->
<! --
Footer
-->
<footer class="bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="lead text-center mb-0">
                    Theme By | RichiS |
                    <span id="year"></span>
                    &copy;
                    -----All
                    right
                    Reserved.
                </p>
                <p class="text-center mb-0">
                    Richi
                    <i class="fab fa-apple"></i>
                </p>
                <p class="text-center small">
                    <a style="color: white; text-decoration: none; cursor: pointer;" href="https://jazebakram.com">This site is only used for Study prupse jazebakram.com have all the tights. no one is allow to distribute copies other then
                        <br>&trade;jazebakram.com&trade;Udemy;&trade;Skillshare ;&trade;StackSkills</a>
                </p>
            </div>
        </div>
    </div>
</footer>
<div style="height: 10px; background: #27aae1;"></div>

<! --
Footer
End
-->

<div class="container">


</div>
<script src="./dist/js/jquery.min.js"></script>
<script src="./dist/js/global.min.js"></script>
</body>
</html>