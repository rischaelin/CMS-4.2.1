<?php
require_once(__DIR__ . '/includes/db.php');
require_once(__DIR__ . '/includes/functions.php');
require_once(__DIR__ . '/includes/sessions.php');
require_once(__DIR__ . '/includes/dataTime.php');
$_SESSION['TrackingURL']=$_SERVER['PHP_SELF'];
confirm_Login ();
error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);

if (isset($_POST['Submit'])) {
    $userName          = $_POST['userName'];
    $name              = $_POST['name'];
    $passWord          = $_POST['password'];
    $confirmPassword   = $_POST['confirmPassword'];
    $admin = 'Admin';
    if (empty($userName)||empty($passWord)||empty($confirmPassword)) {
        $_SESSION['ErrorMessage'] = 'All fields must be filled out';
        redirectTo('admins.php');
    } elseif (strlen($passWord) < 4) {
        $_SESSION['ErrorMessage'] = 'Password should be greater then 3 charater';
        redirectTo('admins.php');
    } elseif ($passWord !== $confirmPassword) {
        $_SESSION['ErrorMessage'] = 'Password and Confirm should be match';
        redirectTo('admins.php');
    } elseif (checkUserName($userName)) {
        $_SESSION['ErrorMessage'] = 'Username Exists. Try another one!';
        redirectTo('admins.php');
    } else {
        // Query to insert new admin in DB when everything is fine
        $passwordHash = password_hash($passWord, PASSWORD_DEFAULT);
            $statement = $pdoObject->prepare("INSERT INTO admins (datetime, username, password, aname, addedby)
            VALUES (:dateTime, :userName, :password, :aName, :adminName)");

        $statement->execute(array(
                ':dateTime'     => $dateTime,
                ':userName'     => $userName,
                ':password'     => $passwordHash,
                ':aName'        => $name,
                ':adminName'    => $admin
            ));

        if ($statement) {
            $_SESSION['SuccessMessage'] =  'New Admin with the name of '.$name.' added Successfully';
            redirectTo('admins.php');
        } else {
            $_SESSION['ErrorMessage'] = 'Something went wrong. Try again';
            redirectTo('admins.php');
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
    <title>Admin Page</title>
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
                    <a href="myProfile.php" class="nav-link"><i class="fas fa-user text-success"></i>My Profile</a>
                </li>
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="AddNewPost.php" class="nav-link">Posts</a>
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
                <h1><i class="fas fa-user" style="color: #27aae1"></i>Manage Admins</h1>
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
            <form class="" action="admins.php" method="post">
                <div class="card bg-secondary text-light mb-3">
                    <div class="card-header"><h1>Add New Admin</h1></div>
                    <div class="card-body bg-dark">
                        <div class="form-group">
                            <label for="username"><span class="FieldInfo">Username: </span></label>
                            <input class="form-control" type="text" name="userName" id="username" placeholder="Type title here" value="">
                        </div>
                        <div class="form-group">
                            <label for="name"><span class="FieldInfo">Name: </span></label>
                            <input class="form-control" type="text" name="name" id="name" value="">
                            <small class="text-muted">Optional</small>
                        </div>
                        <div class="form-group">
                            <label for="password"><span class="FieldInfo">Password: </span></label>
                            <input class="form-control" type="password" name="password" id="password" value="">
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword"><span class="FieldInfo">Confirm Password: </span></label>
                            <input class="form-control" type="password" name="confirmPassword" id="confirmPassword" value="">
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back To Dashboard</a>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <button type="submit" name="Submit" class="btn btn-success btn-block"><i class="fas fa-check"></i>Publish
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <h2>Existing Admins</h2>
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>No. </th>
                    <th>Date&Time</th>
                    <th>UserName</th>
                    <th>Admin Name</th>
                    <th>Added by</th>
                    <th>Action</th>
                </tr>
                </thead>
                <?php
                $stmt = $pdoObject->query("SELECT * FROM admins ORDER BY id desc");
                $SrNo = 0;
                while ($dataRows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $adminId = $dataRows['id'];
                    $adminDate = $dataRows['datetime'];
                    $adminUserName = $dataRows['username'];
                    $adminName = $dataRows['aname'];
                    $addedBy = $dataRows['addedby'];
                    $SrNo++;
                    //if (strlen ($commenterName)>10) { $commenterName = substr ($commenterName,0,10).'..';}
                    ?>
                    <tbody>
                    <tr>
                        <td><?php echo htmlentities ($SrNo); ?></td>
                        <td><?php echo htmlentities ($adminDate); ?></td>
                        <td><?php echo htmlentities ($adminUserName); ?></td>
                        <td><?php echo htmlentities ($adminName); ?></td>
                        <td><?php echo htmlentities ($addedBy); ?></td>
                        <td><a href="deleteAdmin.php?id=<?php echo $adminId;?>" class="btn btn-danger">Delete</a> </td>
                    </tr>
                    </tbody>
                <?php } ?>
            </table>
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


