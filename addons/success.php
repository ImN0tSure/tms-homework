<?php
ini_set('MEMORY_LIMIT', '128M');
include_once '../addons/functions.php';

$add_get = checkUserStatus();

if (isset($_GET['user'])) {
    $user = $_GET['user'];
    $user_data = file_get_contents('./lesson19hw-users/users/' . $user . '.json');
    $user_data = json_decode($user_data, true);
    $user_avatar = './lesson19hw-users/avatars/' . $user_data['avatar'];
    echo 'У Вас получилось, ' . $user . '! Печенюшку дадим в следующий раз, а пока держите котика /ᐠ｡ꞈ｡ᐟ\ <br><br>';
    echo 'Вот ваша аватарка<br> <img style="max-width: 300px; max-height: 300px;" src ="' . $user_avatar . '"><br>';
}
br();
echo '<a href="../homework/lesson19hw.php?'. $add_get . '">В личный кабинет</a>';