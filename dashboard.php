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
                            <a href="myProfile.php" class="nav-link"><i class="fas fa-user text-success"></i> My Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="dashboard.php" class="nav-link">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a href="Post.php"  class="nav-link">Posts</a>
                        </li>
                        <li class="nav-item">
                            <a href="Categories.php" class="nav-link">Categories</a>
                        </li>
                        <li class="nav-item">
                            <a href="admins.php" class="nav-link">Manage Admins</a>
                        </li>
                        <li class="nav-item">
                            <a href="comments.php" class="nav-link">Comments</a>
                        </li>
                        <li class="nav-item">
                            <a href="blog.php?page1" class="nav-link">Live Blog</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a href="logout.php" class="nav-link text-danger"><i class="fas fa-user-times"></i> Logout</a></li>
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
                    <h1><i class="fas fa-blog" style="color: #27aae1"></i> Dashboard</h1>
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
                    <a href="admins.php" class="btn btn-primary btn-block">
                        <i class="fas fa-user-plus"></i> Add New Admin
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="comments.php" class="btn btn-success btn-block">
                        <i class="fas fa-check"></i> Approve Comments
                    </a>
                </div>
            </div>
        </div>
    </header>
    <! -- End -->
    <section class="container py-2 md-4">
        <div class="row">
            <?php
            echo errorMessage();
            echo successMessage();
            ?>
            <! -- left Side Area Start -->
            <div class="col-lg-2 d-none d-md-block">
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Post</h1>
                        <h4 class="display-5">
                            <i class="fab fa-readme"></i>
                            <?php
                            totalPosts ();
                            ?>
                        </h4>
                    </div>
                </div>
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Categories</h1>
                        <h4 class="display-5">
                            <i class="fas fa-folder"></i>
                            <?php
                            totalCategories();
                            ?>
                        </h4>
                    </div>
                </div>
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Admins</h1>
                        <h4 class="display-5">
                            <i class="fas fa-users"></i>
                            <?php
                            totalAdmins();
                            ?>
                        </h4>
                    </div>
                </div>
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Comments</h1>
                        <h4 class="display-5">
                            <i class="fas fa-comments"></i>
                            <?php
                            totalComments();
                            ?>
                        </h4>
                    </div>
                </div>
            </div>
            <! -- left Side Area End -->
            <! -- right Side Area Start -->
            <div class="col-lg-10">
                <h1>Top Posts</h1>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Date&Time</th>
                            <th>Author</th>
                            <th>Comments</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <?php
                    $srNo = 0;
                    $stmt = $pdoObject->query("SELECT * FROM posts ORDER BY id desc LIMIT 0,5");
                    while ($dataRows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $postId = $dataRows['id'];
                        $dateTime = $dataRows['datetime'];
                        $author = $dataRows['author'];
                        $title = $dataRows['title'];
                        $srNo++;
                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo $srNo; ?></td>
                            <td><?php echo $title; ?></td>
                            <td><?php echo $dateTime; ?></td>
                            <td><?php echo $author; ?></td>
                            <td>
                                    <?php $toTal = approveComAccToPost($postId);
                                    if ($toTal>0) {
                                    ?>
                                    <span class="badge badge-success">
                                        <?php
                                        echo $toTal; ?>
                                        </span>
                                       <?php }
                                    ?>
                                    <?php $total = disApproveComAccToPost($postId);
                                    if ($total>0) {
                                        ?>
                                        <span class="badge badge-danger">
                                        <?php
                                        echo $total; ?>
                                        </span>
                                    <?php }
                                ?>
                            </td>
                            <td>
                                <a target="_blank" href="fullPost.php?id=<?php echo $postId; ?>">
                                    <span class="btn btn-info">Preview</span>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>
    </section>
    <! -- right Side Area End -->
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