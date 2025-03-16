<?php
session_start();
ini_set('MEMORY_LIMIT', '128M');
include_once '../../../addons/functions.php';
require_once '../classes/User.php';
require_once '../classes/Registration.php';
require_once '../classes/Authorisation.php';

//Проверяем статус пользователя.
$user = new User();
$status = $user->getStatus();

echo 'Добро пожаловать в личный кабинет, ' . $user->getUsername();
br();
echo 'Ваш статус: ' . $status;
br();

echo 'Вот ваша аватарка<br> <img style="max-width: 300px; max-height: 300px;" src ="' . $user->getAvatarImg() . '"><br>';
br();
echo '<form action="../addons/form-handler.php" method="POST">
        <button type="submit" value="logout" name="action">Выйти из кабинета</button>
    </form>
';
br();

//<editor-fold desc="Блок, который видит только администратор">
if ($status == 'admin') {
    $all_users = scandir('../users/');

    $inputs = '';

    foreach ($all_users as $key => $user) {
        if ($key < 2) {
            continue;
        }

        $data = file_get_contents('../users/' . $user);
        $data = json_decode($data, true);

        $username = $data['login'];
        $user_status = $data['status'];
        $inputs .= '<br>' . $username . '<br><input type="text" name=" ' . $username . '" value="' . $user_status . '"><br>';
    }

    ?>
    <form action="../addons/change-status.php" method="post">
        <?= $inputs ?>
        <br>
        <button type="submit">Подтвердить</button>
    </form>
    <?php
}
//</editor-fold>
?>