<?php
require_once (__DIR__ . '/includes/functions.php');
require_once(__DIR__ . '/includes/sessions.php');
require_once(__DIR__ . '/includes/dataTime.php');
$_SESSION["userId"] = $user->null;
$_SESSION["userName"] = $user->null;
$_SESSION["adminName"] = $user->null;
session_destroy ();
redirectTo ('login.php');