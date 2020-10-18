<?php
require_once(__DIR__ . '/includes/db.php');
require_once(__DIR__ . '/includes/functions.php');
require_once(__DIR__ . '/includes/sessions.php');
require_once(__DIR__ . '/includes/dataTime.php');
confirm_Login ();
?>

<?php
if (isset($_POST['Submit'])) {
    $categorys = $_POST['CategoryTitle'];
    $admin = 'Richi';
    if (empty($categorys)) {
        $_SESSION['ErrorMessage'] = 'All fields must be filled out';
        redirectTo('Categories.php');
    } elseif (strlen($categorys) < 2) {
        $_SESSION['ErrorMessage'] = 'Category title should be greater then 2 charater';
        redirectTo('Categories.php');
    } elseif (strlen($categorys) > 49) {
        $_SESSION['ErrorMessage'] = 'Category title should be less then 50 charater';
        redirectTo('Categories.php');
    } else {
        $statement = $sql -> prepare("INSERT INTO category (title, author, datetime) VALUES (:categoryName, :adminName, :dateTime)");

        $num = $statement->execute(array(
            ':categoryName' => $categorys,
            ':adminName' => $admin,
            ':dateTime' => $dateTime
        ));



        if ($num > 0) {
            $_SESSION['SuccessMessage'] = 'Category with id: ' . $sql->lastInsertId() . ' Added Successfully';
            redirectTo('Categories.php');
        } else {
            $_SESSION['ErrorMessage'] = 'Something went wrong. Try again';
            redirectTo('Categories.php');
        }
    }
}
?>

<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="./dist/css/main.css">

    <title>Categories</title>
</head>
<body><script id="__bs_script__">//<![CDATA[
    document.write("<script async src='/browser-sync/browser-sync-client.js?v=2.26.5'><\/script>".replace("HOST", location.hostname));
    //]]></script>

<!-- Navbar -->
<div style="height: 10px; background: #27aae1;"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a href="index.html" class="navbar-brand">RICHIS.COM</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collaps navbar-collapse" id="navbarcollapseCMS">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="MyProfile.php" class="nav-link"><i class="fas fa-user text-success"></i>My Profile</a>
                </li>
                <li class="nav-item">
                    <a href="Dashboard.php" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="AddNewPost.php" class="nav-link">Posts</a>
                </li>
                <li class="nav-item">
                    <a href="Categories.php" class="nav-link">Categories</a>
                </li>
                <li class="nav-item">
                    <a href="Admins.php" class="nav-link">Manage Admins</a>
                </li>
                <li class="nav-item">
                    <a href="Comments.php" class="nav-link">Comments</a>
                </li>
                <li class="nav-item">
                    <a href="Blog.php?page1" class="nav-link">Live Blog</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="Logout.php" class="nav-link text-danger"><i class="fas fa-user-times"></i>Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div style="height: 10px; background: #27aae1;"></div>
<! -- Navbar End -->

<! -- Haeder -->
<header class="bg-dark text-white py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fas fa-edit" style="color: #27aae1"></i>Manage Categories</h1>
            </div>
        </div>
    </div>
</header>
<! -- End -->

<!-- Main Area -->
<section class="container py-2 mb-4">
    <div class="row">
        <div class="offset-lg-1 col-lg-10" style="min-height: 400px;">
            <?php
            echo errorMessage();
            echo successMessage();
            ?>
            <form class="" action="Categories.php" method="post">
                <div class="card bg-secondary text-light mb-3">
                    <div class="card-header"><h1>Add New Category</h1></div>
                    <div class="card-body bg-dark">
                        <div class="form-group">
                            <label for="title"><span class="FieldInfo">Category Title: </span></label>
                            <input class="form-control" type="text" name="CategoryTitle" id="title" placeholder="Type title here" value="">
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back To Dashboard</a>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <button type="submit" name="Submit" class="btn btn-success btn-block"><i class="fas fa-check"></i>Publish
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</section>

<! -- Footer -->
<footer class="bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="lead text-center">Theme By | RichiS |<span id="year"></span>&copy;-----All right Reserved.</p>
                <p class="text-center small"><a style="color: white; text-decoration: none; cursor: pointer;" href="https://jazebakram.com">This site is only used for Study prupse jazebakram.com have all the tights. no one is allow to distribute copies other then<br>&trade;jazebakram.com&trade;Udemy ;&trade;Skillshare ;&trade;Stack Skills</a></p>
            </div>
        </div>
    </div>
    <div style="height:22px; background: #2E2E2E;"><p class="text-center">Richi<i class="fab fa-apple "></i></p>
    </div>
</footer>
<div style="height: 10px; background: #27aae1;"></div>

<! -- Footer End -->
<script src="./dist/js/jquery.min.js"></script>
<script src="./dist/js/global.min.js"></script>
</body>
</html>



