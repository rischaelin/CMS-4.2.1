<?php
require_once (__DIR__ . '/includes/db.php');
require_once (__DIR__ . '/includes/functions.php');
require_once (__DIR__ . '/includes/sessions.php');
require_once (__DIR__ . '/includes/dataTime.php');
if
(isset($_GET['id'])){
    $searchQueryParameter = $_GET['id'];
    $stmt = $pdoObject->query ("DELETE FROM comments WHERE ID='$searchQueryParameter'");
    if ($stmt) {
        $_SESSION['SuccessMessage']='Comment DELETED Successfully! ';
        redirectTo ('comments.php');
    }else {
        $_SESSION['ErrorMessage']='Somthing went wrong. Try again! ';
        redirectTo ('comments.php');
    }
}

?>