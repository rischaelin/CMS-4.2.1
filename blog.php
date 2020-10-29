<?php
require_once(__DIR__ . '/includes/db.php');
require_once(__DIR__ . '/includes/functions.php');
require_once(__DIR__ . '/includes/sessions.php');
require_once(__DIR__ . '/includes/dataTime.php');
?>

<!DOCTYPE html>
<html lang="de">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <link rel="stylesheet" href="./dist/css/main.css">
        <title>Blog Page</title>
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
                            <a href="blog.php" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="#"  class="nav-link">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a href="blog.php" class="nav-link">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Features</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <form class="form-inline d-none d-sm-block" action="blog.php">
                            <div class="form-group">
                                <input class="form-control mr-2" type="text" name="search" placeholder="Search here" value="">
                                <button class="btn btn-primary" name="searchButton">Go</button>
                            </div>
                        </form>
                    </ul>
                </div>
            </div>
        </nav>
    <div style="height: 10px; background: #27aae1;"></div>
    <! -- Navbar End -->

    <! -- Haeder -->
   <div class="container">
       <div class="row mt-4">

           <! -- Main Area Start -->
           <div class="col-sm-8">
               <h1>The complete Responsive CMS Blog</h1>
               <h1 class="lead">The complete blog be using PHP by Richi</h1>
               <?php
               echo errorMessage();
               echo successMessage();
               ?>
               <?php
               // SQL guery when Search button is active
               if(isset($_GET["searchButton"])){
                   $search = $_GET["search"];
                   $stmt = $pdoObject->prepare("SELECT * FROM posts 
                   WHERE datetime LIKE :search
                   OR title LIKE  :search
                   OR category LIKE :search
                   OR post LIKE :search");
                   $stmt->bindValue(':search','%'.$search.'%');
                   $stmt->execute();
               }
               // Fetching all the categories from posts table
               else{
                   $stmt = $pdoObject->query("SELECT * FROM posts ORDER BY id desc");
               }
               while ($dataRows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                   $postId = $dataRows["id"];
                   $dateTime = $dataRows["datetime"];
                   $postTitle = $dataRows["title"];
                   $categoryName = $dataRows["category"];
                   $admin = $dataRows["author"];
                   $image = $dataRows["image"];
                   $postText = $dataRows["post"];
               ?>
               <div class="card">
                   <img src="uploads/<?php echo htmlentities($image); ?>"  class="img-fluid card-img-top"/>
                   <div class="card-body">
                       <h4 class="card-title"> <?php echo htmlentities($postTitle); ?></h4>
                       <small class="text-muted">Written by <?php echo htmlentities($admin); ?> on <?php echo htmlentities($dateTime); ?></small>
                       <span style="float: right;" class="badge badge-dark text-light">Comments 20</span>
                       <hr>
                       <p class="card-text">
                           <?php
                           if (strlen($postText)>150) {
                               $postText = substr($postText,0,150)."...";}
                           echo htmlentities($postText);
                            ?>
                       </p>
                       <a href="fullPost.php?id=<?php echo $postId; ?>" style="float: right;">
                           <span class="btn btn-info">Read more >> </span>
                       </a>
                   </div>
               </div>
               <?php  } ?>
           </div>
           <! -- Main Area End -->

           <! -- Side Area Start -->
            <div class="col-sm-4" style="min-height: 40px; background: green;">
            </div>

           <! -- Side Area End -->
       </div>
   </div>
    <! --  Header End -->
    <br>

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