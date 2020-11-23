<?php
require_once(__DIR__ . '/includes/db.php');
require_once(__DIR__ . '/includes/functions.php');
require_once(__DIR__ . '/includes/sessions.php');
require_once(__DIR__ . '/includes/dataTime.php');
$_SESSION['TrackingURL']=$_SERVER['PHP_SELF'];
confirm_Login ();
?>
<!DOCTYPE html>
<html lang="de">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <link rel="stylesheet" href="./dist/css/main.css">

        <title>Comments</title>
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
                            <a href="post.php"  class="nav-link">Posts</a>
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
                            <a href="blog.php?page1" class="nav-link">Live Blog</a>
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
                    <h1><i class="fas fa-comments" style="color: #27aae1"></i> Manage Comments</h1>
                </div>
            </div>
        </div>
    </header>
    <! -- Header End -->
    <! -- Main Area Start -- >
    <section class="container py-2 mb-4">
        <div class="row" style="min-height: 30px;">
            <div class="col-lg-12" style="min-height: 400px;">
                <?php
                echo SuccessMessage();
                echo ErrorMessage();
                ?>
                <h2>Un-Approved Comments</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No. </th>
                            <th>Date&Time</th>
                            <th>Name</th>
                            <th>Comment</th>
                            <th>Approve</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <?php
                        $stmt = $pdoObject->query("SELECT * FROM comments WHERE status='OFF' ORDER BY id desc");
                        $SrNo = 0;
                        while ($dataRows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $commentId = $dataRows['id'];
                            $dateTimeOffComment = $dataRows['datetime'];
                            $commenterName = $dataRows['name'];
                            $commentContent = $dataRows['comment'];
                            $commentPostId = $dataRows['post_id'];
                            $SrNo++;
                            //if (strlen ($commenterName)>10) { $commenterName = substr ($commenterName,0,10).'..';}
                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo htmlentities ($SrNo); ?></td>
                            <td><?php echo htmlentities ($dateTimeOffComment); ?></td>
                            <td><?php echo htmlentities ($commenterName); ?></td>
                            <td><?php echo htmlentities ($commentContent); ?></td>
                            <td style="min-width: 150px"><a href="approveComments.php?id=<?php echo $commentId;?>" class="btn btn-success">Approve</a> </td>
                            <td><a href="deleteComments.php?id=<?php echo $commentId;?>" class="btn btn-danger">Delete</a> </td>
                            <td style="min-width: 150px"> <a class="btn btn-primary" href="fullPost.php?id=<?php echo $commentPostId; ?>" target="_blank">Live Preview</a> </td>
                        </tr>
                    </tbody>
                    <?php } ?>
                </table>
                <h2>Approved Comments</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th>No. </th>
                        <th>Date&Time</th>
                        <th>Name</th>
                        <th>Comment</th>
                        <th>Revert</th>
                        <th>Action</th>
                        <th>Details</th>
                    </tr>
                    </thead>
                    <?php
                    $stmt = $pdoObject->query("SELECT * FROM comments WHERE status='ON' ORDER BY id desc");
                    $SrNo = 0;
                    while ($dataRows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $commentId = $dataRows['id'];
                        $dateTimeOffComment = $dataRows['datetime'];
                        $commenterName = $dataRows['name'];
                        $commentContent = $dataRows['comment'];
                        $commentPostId = $dataRows['post_id'];
                        $SrNo++;
                        //if (strlen ($commenterName)>10) { $commenterName = substr ($commenterName,0,10).'..';}
                        ?>
                        <tbody>
                        <tr>
                            <td><?php echo htmlentities ($SrNo); ?></td>
                            <td><?php echo htmlentities ($dateTimeOffComment); ?></td>
                            <td><?php echo htmlentities ($commenterName); ?></td>
                            <td><?php echo htmlentities ($commentContent); ?></td>
                            <td style="min-width: 150px;"><a href="disApproveComments.php?id=<?php echo $commentId;?>" class="btn btn-warning">Dis-Approve</a> </td>
                            <td><a href="deleteComments.php?id=<?php echo $commentId;?>" class="btn btn-danger">Delete</a> </td>
                            <td style="min-width: 150px"> <a class="btn btn-primary" href="fullPost.php?id=<?php echo $commentPostId; ?>" target="_blank">Live Preview</a> </td>
                        </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>

    </section>
    <! -- Main Area End -- >
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