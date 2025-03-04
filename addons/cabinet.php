<?php
ini_set('MEMORY_LIMIT', '128M');
include_once '../addons/functions.php';

//Проверяем статус пользователя.
$add_get = checkUserStatus();

$user = $_GET['user'];
$status = $_GET['status'];
$confirm = $_GET['confirm'];

echo 'Добро пожаловать в личный кабинет, ' . $user;
br();
echo 'Ваш статус: ' . $status;
br();

$user_data = file_get_contents('./lesson19hw-users/users/' . $user . '.json');
$user_data = json_decode($user_data, true);
$user_avatar = './lesson19hw-users/avatars/' . $user_data['avatar'];
echo 'Вот ваша аватарка<br> <img style="max-width: 300px; max-height: 300px;" src ="' . $user_avatar . '"><br>';
br();
echo '<a href=http://tms-hw.local/homework/lesson19hw.php?status=guest>Выйти из кабинета</a>';
br();

//<editor-fold desc="Блок, который видит только администратор">
if ($status == 'admin') {
    $all_users = scandir('./lesson19hw-users/users/');

    $inputs = '';

    foreach ($all_users as $key => $user) {
        if ($key < 2) {
            continue;
        }

        $udata = file_get_contents('./lesson19hw-users/users/' . $user);
        $udata = json_decode($udata, true);

        $uname = $udata['login'];
        $ustatus = $udata['status'];
        $inputs .= '<br>' . $uname . '<br><input type="text" name=" ' . $uname . '" value="' . $ustatus . '"><br>';
    }

    ?>
    <form action="change-status.php?<?= $add_get ?>" method="post">
        <?= $inputs ?>
        <br>
        <button type="submit">Подтвердить</button>
    </form>
    <?php
}
//</editor-fold>
?>