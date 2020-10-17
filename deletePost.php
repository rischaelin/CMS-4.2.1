<?php
require_once(__DIR__ . '/includes/db.php');
require_once(__DIR__ . '/includes/functions.php');
require_once(__DIR__ . '/includes/sessions.php');
require_once(__DIR__ . '/includes/dataTime.php');


$searchQueryParameter = $_GET['id'];
$stmt = $pdoObject->query("SELECT * FROM posts WHERE id='$searchQueryParameter'");

while ($dataRows = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $titleToBeDeleted       = $dataRows['title'];
    $categoryToBeDeleted    = $dataRows['category'];
    $imageToBeDeleted       = $dataRows['image'];
    $postToBeDeleted        = $dataRows['post'];
}
var_dump($imageToBeDeleted);
if (isset($_POST["submit"])){
        // Query to Delete Post in DB when everything is fine
        $execute = $pdoObject->query("DELETE FROM posts WHERE id='$searchQueryParameter'");
        if($execute) {
            unlink('uploads/'. $imageToBeDeleted);
            $_SESSION['SuccessMessage'] = ' Added DELETED Successfully';
            redirectTo('post.php');
        }else {
            $_SESSION['ErrorMessage'] = 'Something went wrong. Try again!';
            redirectTo('post.php');

    }
}
?>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="./dist/css/main.css">
    <title>Delete Post</title>
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
                <li class="nav-item"><a href="MyProfile.php" class="nav-link"><i class="fas fa-user text-success"></i>My Profile</a></li>
                <li class="nav-item"><a href="Dashboard.php" class="nav-link">Dashboard</a></li>
                <li class="nav-item"><a href="post.php" class="nav-link">Posts</a></li>
                <li class="nav-item"><a href="Categories.php" class="nav-link">Categories</a></li>
                <li class="nav-item"><a href="Admins.php" class="nav-link">Manage Admins</a></li>
                <li class="nav-item"><a href="Comments.php" class="nav-link">Comments</a></li>
                <li class="nav-item"><a href="Blog.php?page1" class="nav-link">Live Blog</a></li>
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
                <h1><i class="fas fa-edit" style="color: #27aae1"></i>Delete Post</h1>
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
            <form class="" action="deletePost.php?id=<?php echo $searchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                <div class="card bg-secondary text-light mb-3">
                    <div class="card-body bg-dark">
                        <div class="form-group">
                            <label for="title"><span class="FieldInfo"> Post Title: </span></label>
                            <input disabled class="form-control" type="text" name="postTitle" id="title" placeholder="Type title here" value="<?php echo $titleToBeDeleted; ?>">
                        </div>
                        <div class="form-group">
                            <span class="FieldInfo">Existing Category: </span>
                            <?php echo $categoryToBeDeleted;?>
                            <br>
                        </div>
                        <div class="form-group">
                            <span class="FieldInfo">Existing Image: </span>
                            <img class="mb-3" src="uploads/<?php echo $imageToBeDeleted;?>" width="130px"; height="90px"; >
                        </div>
                        <div class="form-group">
                            <label for="Post"><span class="FieldInfo"> Post: </span></label>
                            <textarea disabled class="form-control" id="Post" name="postDescription" rows="8" cols="80">
                            <?php echo $postToBeDeleted; ?>
                            </textarea>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back To Dashboard</a>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <button type="submit" id="submit" name="submit" class="btn btn-danger btn-block"><i class="fas fa-trash"></i>Delete
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</section>


<! --
Footer
-->
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

<! --
Footer
End
-->
<script src="./dist/js/jquery.min.js"></script>
<script src="./dist/js/global.min.js"></script>
</body>
</html>