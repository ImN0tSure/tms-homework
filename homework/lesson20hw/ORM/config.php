<?php

$connect = "mysql:host=localhost;dbname=tms-hw";
$user = 'root';
$password = '';

try {
    $db = new PDO($connect, $user, $password);
} catch (PDOException $e) {
    die('404');
}
return $db;
