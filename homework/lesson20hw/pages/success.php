<?php
session_start();
ini_set('MEMORY_LIMIT', '128M');
include_once '../../../addons/functions.php';
require_once '../classes/User.php';

//Проверяем статус пользователя.
$user = User::getInstance();

if ($user->getStatus() === 'guest') {
    header ("Location: ../index.php");
}


echo 'У Вас получилось, ' . $user->getUsername() . '! Держите печенюшку И котика /ᐠ｡ꞈ｡ᐟ\ <br><br>';
echo 'Вот ваша аватарка<br> <img style="max-width: 300px; max-height: 300px;" src ="' . $user->getAvatarImg() . '"><br>';

br();
echo '<form action="../addons/form-handler.php" method="POST">
        <input type="submit" value="logout" name="action">    
    </form>
';
br();

echo '<a href="./cabinet.php">Перейти в личный кабинет</a>';
