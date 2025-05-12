<?php

namespace project;

use classes\User as User;
use classes\UserAdmin as UserAdmin;

session_start();
ini_set('MEMORY_LIMIT', '128M');
include_once '../../../addons/functions.php';
require_once '../classes/User.php';
require_once '../classes/UserAdmin.php';
require_once '../classes/Registration.php';
require_once '../classes/Authorization.php';

if (!$_SESSION['is_authorized']) {
    header('Location: index.php');
}

$status = $_SESSION['user_status'];
//Проверяем статус пользователя.
if ($status == 0) {
    $user = UserAdmin::getInstance();
} else {
    $user = User::getInstance();
}

print_r($user->getStatus());
print_r($_SESSION);

echo 'Добро пожаловать в личный кабинет, ' . $user->getUsername();
br();

echo 'Вот ваша аватарка<br> <img style="max-width: 300px; max-height: 300px;" src ="../avatars/' . $user->getAvatarImg(
    ) . '"><br>';
br();
echo '<form action="../addons/form-handler.php" method="POST">
        <button type="submit" value="logout" name="action">Выйти из кабинета</button>
    </form>
';
br();
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'get-user-list':
            echo $user->listAllUsers();

            break;

        case 'get-user-info':
            if (isset($_POST['user-name'])) {
                print_r($user->getUserInfo($_POST['user-name']));
            } else {
                print_r($user->getUserInfo());
            }

            break;

        default:
            break;
    }
}

switch ($status) {
    case 0:
        $inputs = '
            <button type="submit" name="action" value="get-user-list">Список всех пользователей</button>
            <br><br>
            <input type="text" placeholder="Enter Username(email)" name="user-name">
            <br>
            <button type="submit" name="action" value="get-user-info">Информация о пользователе</button>
        ';
        break;

    default:
        $inputs = '<button type="submit" name="action" value="get-user-info">Информация о пользователе</button>';
}
?>
    <form method="POST">
        <?= $inputs ?>
    </form>
