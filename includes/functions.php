<?php
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
function login_Attempt($userName, $password)
{
    global $pdoObject;
    $sql = "SELECT * FROM admins WHERE username=:userName AND password=:passWord LIMIT 1";
    $stmt = $pdoObject->prepare($sql);
    $stmt->bindValue(':userName', $userName);
    $stmt->bindValue(':passWord', $password);
    $stmt->execute();
    $result = $stmt->rowcount();
    if ($result == 1) {
        return $found_Account = $stmt->fetch();
    } else {
        return null;
    }
}