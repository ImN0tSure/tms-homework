<?php
session_start();
ini_set('MEMORY_LIMIT', '128M');
include_once '../../../addons/functions.php';
require_once '../classes/User.php';
require_once '../classes/UserAdmin.php';
require_once '../classes/Registration.php';
require_once '../classes/Authorisation.php';

if (!$_SESSION['is_authorized']) {
    header('Location: index.php');
}

//Проверяем статус пользователя.
$user = new User();
$status = $user->getStatus();
if ($status === 'admin') {
    $user = new UserAdmin();
}

echo 'Добро пожаловать в личный кабинет, ' . $user->getUsername();
br();

echo 'Вот ваша аватарка<br> <img style="max-width: 300px; max-height: 300px;" src ="' . $user->getAvatarImg() . '"><br>';
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
            print_r($user->getUserInfo($_POST['user-name']));
            break;

        default:
            break;
    }
}

switch ($status) {
    case 'admin':
        $inputs = '
            <button type="submit" name="action" value="get-user-list">Список всех пользователей</button>
            <br><br>
            <input type="text" name="user-name">
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
<?php
