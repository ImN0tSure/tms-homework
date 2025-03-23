<?php
session_start();
ini_set('MEMORY_LIMIT', '128M');
include_once '../../../addons/functions.php';
require_once '../classes/UserAdmin.php';

$user = new UserAdmin();
if ($user->getStatus() === 'admin') {
    $user->changeUserStatus();
    header('Location: ../pages/success.php');
}

header('Location: ../pages/cabinet.php');

