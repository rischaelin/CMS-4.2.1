<?php
require_once(__DIR__ . '/includes/db.php');
require_once(__DIR__ . '/includes/functions.php');
require_once(__DIR__ . '/includes/sessions.php');
require_once(__DIR__ . '/includes/dataTime.php');
$_SESSION['TrackingURL']=$_SERVER['PHP_SELF'];
//echo  $_SESSION['TrackingURL'];
confirm_Login ();
?>
<!DOCTYPE html>
<html lang="de">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <link rel="stylesheet" href="./dist/css/main.css">

        <title>Posts</title>
    </head>
    <body>
    <!-- Navbar -->
    <div style="height: 10px; background: #27aae1;"></div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
               <a href="index.html"class="navbar-brand">RICHIS.COM</a>
                <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarcollapseCMS">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a href="MyProfile.php" class="nav-link"><i class="fas fa-user text-success"></i> My Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="Dashboard.php" class="nav-link">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a href="AddNewPost.php"  class="nav-link">Posts</a>
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
                        <li class="nav-item"><a href="Logout.php" class="nav-link text-danger"><i class="fas fa-user-times"></i> Logout</a></li>
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
                    <h1><i class="fas fa-blog" style="color: #27aae1"></i> Blog Posts</h1>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="AddNewPost.php" class="btn btn-primary btn-block">
                        <i class="fas fa-edit"></i> Add New Post
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Categories.php" class="btn btn-info btn-block">
                        <i class="fas fa-folder-plus"></i> Add New Category
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Admins.php" class="btn btn-primary btn-block">
                        <i class="fas fa-user-plus"></i> Add New Admin
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Comments.php" class="btn btn-success btn-block">
                        <i class="fas fa-check"></i> Approve Comments
                    </a>
                </div>
            </div>
        </div>
    </header>
    <! -- End -->

    <! -- Main Area -->
    <section class="container py-2 md-4">
        <div class="row">
            <div class="col-lg-12">
                <?php
                echo errorMessage();
                echo successMessage();
                ?>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date&Time</th>
                            <th>Author</th>
                            <th>Banner</th>
                            <th>Comments</th>
                            <th>Action</th>
                            <th>Live Preview</th>
                        </tr>
                    </thead>
                    <?php
                    // Fetching all the categories from posts table
                    $stmt = $pdoObject->query("SELECT * FROM posts");
                    $sr = 0;
                    while ($dataRows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $postId = $dataRows["id"];
                        $dateTime = $dataRows["datetime"];
                        $postTitle = $dataRows["title"];
                        $categoryName = $dataRows["category"];
                        $admin = $dataRows["author"];
                        $image = $dataRows["image"];
                        $postText = $dataRows["post"];
                        $sr++;

                    ?>
                        <tbody>
                            <tr>
                                <td><?php echo $sr ?></td>
                                <td>
                                    <?php
                                        if (strlen($postTitle)>20){$postTitle = substr($postTitle,0,12).'..';}
                                        echo $postTitle
                                    ?></td>
                                <td>
                                    <?php
                                        if (strlen($categoryName)>8){$categoryName = substr($categoryName,0,8).'..';}
                                        echo $categoryName
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if (strlen($dateTime)>11){$dateTime = substr($dateTime,0,11).'..';}
                                        echo $dateTime
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if (strlen($admin)>6){$admin = substr($admin,0,6).'..';}
                                        echo $admin
                                    ?>
                                </td>
                                <td><img src="uploads/<?php echo $image ?>" width="150px;" </td>
                                <td>Comments</td>
                                <td>
                                    <a href="editPost.php?id=<?php echo $postId; ?>"><span class="btn btn-warning">Edit</span> </a>
                                    <a href="deletePost.php?id=<?php echo $postId; ?>"><span class="btn btn-danger">Delete</span> </a>
                                </td>
                                <td><a href="fullPost.php?id=<?php echo $postId; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span> </a></td>
                            </tr>
                        </tbody>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </section>
    <! -- End Main Area -->

    <! -- Footer -->
    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center">Theme By |  RichiS | <span id="year"></span> &copy; -----All right Reserved.</p>
                    <p class="text-center small">
                        <a style="color: white; text-decoration: none; cursor: pointer;" href="https://jazebakram.com">This site is only used for Study prupse jazebakram.com have all the tights. no one is allow to distribute copies other then <br>&trade; jazebakram.com &trade; Udemy ; &trade; Skillshare ; &trade; StackSkills</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <div style="height: 10px; background: #27aae1;"></div>

    <! -- Footer End -->

        <div class="container">


            <p>Richi <i class="fab fa-apple"></i></p>

        </div>
    <script src="./dist/js/jquery.min.js"></script>
    <script src="./dist/js/global.min.js"></script>
    </body>
</html>