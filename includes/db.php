<?php

$server = '127.0.0.1';
$sUsername = 'root';
$sPassword = 'root';
$sDsn = 'mysql:host=127.0.0.1;dbname=cms4.2.1;charset=utf8';
$aOptions = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];

/** @var TYPE_NAME $pdoObject */
$pdoObject = new PDO($sDsn, $sUsername, $sPassword, $aOptions);

