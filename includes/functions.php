<?php /** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
require_once (__DIR__ . '/db.php');
require_once (__DIR__ . '/sessions.php');
require_once (__DIR__ . '/dataTime.php');
error_reporting (E_ALL | E_STRICT);
ini_set ("display_errors", 1);

function redirectTo($location)
{
    header ('Location: ' . $location);
    die();
}


/**
 * @param $userName
 * @return bool
 */
function checkUserName($userName)
{
    global $pdoObject;
    $sql = "SELECT username FROM admins WHERE username=:userName";
    $stmt = $pdoObject->prepare($sql);
    $stmt->bindParam(':userName', $userName);
    $stmt->execute();
    $result = $stmt->rowcount();
    if ($result == 1) {
        return true;
    } else {
        return false;
    }
}

/**
 * @param $userName
 * @param $password
 * @return null
 */
function login_Attempt($userName)
    {
        global $pdoObject;
        $sql = "SELECT * FROM admins WHERE username=:userName LIMIT 1";
        $stmt = $pdoObject->prepare($sql);
        $stmt->bindValue(':userName', $userName);
        $stmt->execute();
        $result = $stmt->rowcount();
        if ($result == 1) {
            return $user = $stmt->fetch();
        } else {
            return null;
        }
    }
    function confirm_Login(){
    if (isset($_SESSION['userId'])) {
        return true;
    } else {
        $_SESSION['ErrorMessage']='Login Required!';
        redirectTo ('login.php');
    }
    }

    function totalPosts() {
        global $pdoObject;
        $sql = "SELECT COUNT(*) FROM posts";
        $stmt = $pdoObject->query($sql);
        $totalRows = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalPosts = array_shift ($totalRows);
        echo $totalPosts;
    }

    function totalCategories() {
        global $pdoObject;
        $sql = "SELECT COUNT(*) FROM category";
        $stmt = $pdoObject->query($sql);
        $totalRows = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalCategories = array_shift ($totalRows);
        echo $totalCategories;
    }

    function totalAdmins() {
        global $pdoObject;
        $sql = "SELECT COUNT(*) FROM admins";
        $stmt = $pdoObject->query($sql);
        $totalRows = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalAdmins = array_shift ($totalRows);
        echo $totalAdmins;
    }

    function totalComments() {
        global $pdoObject;
        $sql = "SELECT COUNT(*) FROM comments";
        $stmt = $pdoObject->query($sql);
        $totalRows = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalComments = array_shift ($totalRows);
        echo $totalComments;
    }

    function approveComAccToPost($postId) {
        global $pdoObject;
        $sqlApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$postId' AND status='ON'";
        $stmtApproved =$pdoObject->query($sqlApprove);
        $rowsTotal = $stmtApproved->fetch(PDO::FETCH_ASSOC);
        $toTal = array_shift ($rowsTotal);
        return $toTal;
    }

    function disApproveComAccToPost($postId) {
        global $pdoObject;
        $sqlDisApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$postId' AND status='OFF'";
        $stmtDisApproved = $pdoObject -> query ($sqlDisApprove);
        $rowsTotal = $stmtDisApproved -> fetch (PDO::FETCH_ASSOC);
        $total = array_shift ($rowsTotal);
        return $total;
    }