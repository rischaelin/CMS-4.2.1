<?php /** @noinspection ALL */
/** @noinspection ALL */
require_once(__DIR__ . '/includes/db.php');
require_once(__DIR__ . '/includes/functions.php');
require_once(__DIR__ . '/includes/sessions.php');
require_once(__DIR__ . '/includes/dataTime.php');
$_SESSION['TrackingURL']=$_SERVER['PHP_SELF'];
confirm_Login ();
error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);

if
(isset($_POST["submit"])){
    $postTitle = $_POST["postTitle"];
    $category = $_POST["category"];
    $image = $_FILES["image"]["name"];
    $target = 'uploads/'.basename($_FILES["image"]["name"]);
    $postText = $_POST["postDescription"];
    $admin = 'Richi';
    error_reporting(E_ALL | E_STRICT);
    ini_set("display_errors", 1);
if (empty($postTitle)) {
    $_SESSION['ErrorMessage'] = 'Title cant be empty';
    redirectTo('AddNewPost.php');
}
elseif (strlen($postTitle)< 5) {
    $_SESSION['ErrorMessage'] = 'Post title should be greater then 5 charater';
    redirectTo('AddNewPost.php');
}
elseif (strlen($postText) > 9999) {
    $_SESSION['ErrorMessage'] = 'Post Description should be less then 1000 charater';
    redirectTo('AddNewPost.php');
} else {
    // insert post into database

    $statement = $pdoObject->prepare("INSERT INTO `posts` (datetime, title, category, author, image, post)
    VALUES (:dateTime, :postTitle, :categoryName, :adminName, :imageName, :postDescription)");

    $statement->execute(array(
        ':dateTime' => $dateTime,
        ':postTitle' => $postTitle,
        ':categoryName' => $category,
        ':adminName' => $admin,
        ':imageName' => $image,
        ':postDescription' => $postText
    ));
    move_uploaded_file($_FILES['image']['tmp_name'],$target);

    if($statement > 0) {
        $_SESSION['SuccessMessage'] = 'Post with id : ' . $pdoObject->lastInsertId(). ' Added Successfully';
        redirectTo('AddNewPost.php');
    }else {
        $_SESSION['ErrorMessage'] = 'Something went wrong. Try again!';
        redirectTo('AddNewPost.php');
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
<body>
<!-- Navbar -->
<div style="height: 10px; background: #27aae1;"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a href="index.html" class="navbar-brand">RICHIS.COM</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarcollapseCMS">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a href="myProfile.php" class="nav-link"><i class="fas fa-user text-success"></i>My Profile</a></li>
                <li class="nav-item"><a href="dashboard.php" class="nav-link">Dashboard</a></li>
                <li class="nav-item"><a href="post.php" class="nav-link">Posts</a></li>
                <li class="nav-item"><a href="Categories.php" class="nav-link">Categories</a></li>
                <li class="nav-item"><a href="admins.php" class="nav-link">Manage Admins</a></li>
                <li class="nav-item"><a href="comments.php" class="nav-link">Comments</a></li>
                <li class="nav-item"><a href="blog.php?page1" class="nav-link">Live Blog</a></li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-danger"><i class="fas fa-user-times"></i>Logout</a>
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
                <h1><i class="fas fa-edit" style="color: #27aae1"></i>Add New Post</h1>
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
            <form class="" action="AddNewPost.php" method="post" enctype="multipart/form-data">
                <div class="card bg-secondary text-light mb-3">
                    <div class="card-body bg-dark">
                        <div class="form-group">
                            <label for="title"><span class="FieldInfo"> Post Title: </span></label>
                            <input class="form-control" type="text" name="postTitle" id="title" placeholder="Type title here" value="">
                        </div>
                        <div class="form-group">
                            <label for="CategoryTitle"><span class="FieldInfo"> Chose Category </span></label>
                            <label for="categoryTitle"></label><select class="form-control" id="categoryTitle" name="category">
                            <?php
                            // Fetching all the categories from category table
                            $stmt = $pdoObject->query("SELECT id,title FROM category");
                            while ($datensatz = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $Id = $datensatz["id"];
                                $categoryName = $datensatz["title"];
                                ?>
                                <option><?php echo $categoryName; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group mb-1">
                            <div class="custom-file">
                                <input class="custom-file-input" type="file" name="image" id="imageSelect" value="">
                                <label for="imageSelect" class="custom-file-label">Select Image</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Post"><span class="FieldInfo"> Post: </span></label>
                            <textarea class="form-control" id="Post" name="postDescription" rows="8" cols="80"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back To Dashboard</a>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <button type="submit" id="submit" name="submit" class="btn btn-success btn-block"><i class="fas fa-check"></i>Publish
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
                <p class="text-center small"><a style="color: white; text-decoration: none; cursor: pointer;" href="https://jazebakram.com">This site is only used for Study prupse jazebakram.com have all the tights. no one is allow to distribute copies other then
                        <br>&trade;jazebakram.com&trade;Udemy ;&trade;Skillshare ;&trade;StackSkills</a>
                </p>
            </div>
        </div>
    </div>
    <div style="height:22px; background: #2E2E2E;">
        <p class="text-center">Richi<i class="fab fa-apple "></i></p>
    </div>
</footer>
<div style="height: 10px; background: #27aae1;"></div>

<! -- Footer End -->
<script src="./dist/js/jquery.min.js"></script>
<script src="./dist/js/global.min.js"></script>
</body>
</html>