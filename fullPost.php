<?php
require_once(__DIR__ . '/includes/db.php');
require_once(__DIR__ . '/includes/functions.php');
require_once(__DIR__ . '/includes/sessions.php');
require_once(__DIR__ . '/includes/dataTime.php');
error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);
$searchQueryParameter = $_GET['id'];

if (isset($_POST['Submit'])) {
    $name       = $_POST['commenterName'];
    $email      = $_POST['commenterEmail'];
    $comment    = $_POST['commenterThoughts'];

    if (empty($name)||empty($email)||empty($comment)) {
        $_SESSION['ErrorMessage'] = 'All fields must be filled out';
        redirectTo('fullPost.php?id={$searchQueryParameter}');
    } elseif (strlen($comment) > 500) {
        $_SESSION['ErrorMessage'] = 'Comment length should be less than 500 characters';
        redirectTo('fullPost.php?id={$searchQueryParameter}');
    } else {
        // Query to insert comment in DB When every is fine
            $statement = $pdoObject->prepare("INSERT INTO comments (datetime, name, email, comment, approvedby, status, post_id) 
            VALUES (:dateTime, :commenterName, :commenterEmail, :commenterThoughts, 'Pending', 'OFF', :postIdFromUrl)");

            $statement->execute([':dateTime' => $dateTime, ':commenterName' => $name, ':commenterEmail' => $email, ':commenterThoughts' => $comment, ':postIdFromUrl' => $searchQueryParameter]);



        if ($statement) {
            $_SESSION['SuccessMessage'] = 'Comment Submitted Successfully';
            redirectTo('fullPost.php?id={$searchQueryParameter}');
        } else {
            $_SESSION['ErrorMessage'] = 'Something went wrong. Try again';
            redirectTo('fullPost.php?id={$searchQueryParameter}');
        }
    }
}
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
               <a href="index.html" class="navbar-brand">RICHIS.COM</a>
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
               // SQL query when Search button is active
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
                   $postIdFromURL = $_GET["id"];
                   if (!isset($postIdFromURL)) {
                       $_SESSION["ErrorMessage"] = "Bad Request !";
                       redirectTo("blog.php?page=1");
                   }
                   $stmt = $pdoObject->query("SELECT * FROM posts WHERE id= '$postIdFromURL'");
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
                       <small class="text-muted">Category: <span class="text-dark" ><?php echo htmlentities ($categoryName); ?> </span> & Written by <span class="text-dark"> <?php echo htmlentities($admin); ?> </span> on <span class="text-dark"> <?php echo htmlentities($dateTime); ?></span></small>
                       <hr>
                       <p class="card-text">
                           <?php echo htmlentities($postText); ?>
                       </p>
                   </div>
               </div>
               <?php  } ?>
               <!-- Comment Part Start -->
               <!-- Fetching existing comment START -->
               <span class="FieldInfo">Comments</span>
               <br><br>
               <?php
               $stmt = $pdoObject->query("SELECT * FROM comments WHERE post_id= '$searchQueryParameter' AND status='ON'");

               while ($dataRows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                   $commentDate = $dataRows['datetime'];
                   $commentName = $dataRows['name'];
                   $commentEmail = $dataRows['email'];
                   $commentContent = $dataRows['comment'];
               ?>
               <div>
                   <div class="media bg-light">
                       <img class="d-block img-fluid align-self-start" src="./assets/images/index.png" height="100" width="100" alt="">
                       <div class="media-body ml-2">
                           <h6 class="lead"><?php echo $commentName?></h6>
                           <p class="small"><?php echo $commentDate?></p>
                           <p><?php echo $commentContent?></p>
                       </div>
                   </div>
                   <hr>
               </div>
               <?php }?>
               <!-- Fetching existing comment END -->
               <div class="">
                   <form class="" action="fullPost.php?id=<?php echo $searchQueryParameter ?>" method="post">
                       <div class="card mb-3">
                           <div class="card-header">
                               <h5 class="fieldInfo">Share your thoughts about this post</h5>
                           </div>
                           <div class="card-body">
                               <div class="form-group">
                                   <div class="input-group">
                                       <div class="input-group-prepend">
                                           <span class="input-group-text"><i class="fas fa-user"></i></span>
                                       </div>
                                       <input class="form-control" type="text" name="commenterName" placeholder="Name" value="">
                                   </div>
                               </div>
                               <div class="form-group">
                                   <div class="input-group">
                                       <div class="input-group-prepend">
                                           <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                       </div>
                                       <input class="form-control" type="text" name="commenterEmail" placeholder="Email" value="">
                                   </div>
                               </div>
                               <div class="form-group">
                                   <textarea name="commenterThoughts" class="form-control" rows="6" cols="80"></textarea>
                               </div>
                               <div class="">
                                   <button type="submit" name="Submit" class="btn btn-primary">Submit</button>
                               </div>
                           </div>
                       </div>
                   </form>
               </div>
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
                        <a style="color: white; text-decoration: none; cursor: pointer;" href="https://jazebakram.com">This site is only used for Study purpose jazebakram.com have all the tights. no one is allow to distribute copies other then <br>&trade; jazebakram.com &trade; Udemy ; &trade; Skillshare ; &trade; StackSkills</a>
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