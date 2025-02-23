<?php
if (isset($_GET['user'])) {
    $user_name = $_GET['user'];
    $user_data = file_get_contents('./lesson19hw-users/' . $user_name . '.json');
    $user_data = json_decode($user_data, true);
    $user_avatar = './lesson19hw-users/avatars/' . $user_data['avatar'];
    echo 'У Вас получилось, ' . $user_name . '! Печенюшку дадим в следующий раз, а пока держите котика /ᐠ｡ꞈ｡ᐟ\ <br><br>';
    echo 'Вот ваша аватарка<br> <img style="max-width: 300px; max-height: 300px;" src ="' . $user_avatar . '"><br>';
}
echo '<a href="../homework/lesson19hw.php">Вернуться</a>';