<?php
require_once (__DIR__ . '/includes/functions.php');
require_once(__DIR__ . '/includes/sessions.php');
require_once(__DIR__ . '/includes/dataTime.php');
$_SESSION["userId"]=null;
$_SESSION["userName"]=null;
$_SESSION["adminName"]=null;
session_destroy ();
redirectTo ('login.php');