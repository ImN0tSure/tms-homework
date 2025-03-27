<?php
session_start();
ini_set('MEMORY_LIMIT', '128M');
include_once '../../../addons/functions.php';
require_once '../classes/UserAdmin.php';

if ($_SESSION['status'] === 'admin') {
    $user = UserAdmin::getInstance();
    $user->changeUserStatus();
    header('Location: ../pages/success.php');
}

header('Location: ../pages/cabinet.php');

