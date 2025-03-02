<?php
ini_set('MEMORY_LIMIT', '128M');
include_once '../addons/functions.php';

//Проверяем, если пользователь авторизован, то перенаправляем его в личный кабинет.
if (isset($_GET['user']) && isset($_GET['status']) && isset($_GET['confirm'])) {
    $add_get = '?user=' . $_GET['user'] . '&status=' . $_GET['status'] . '&confirm=' . $_GET['confirm'];
    header('Location: http://tms-hw.local/addons/cabinet.php' . $add_get);
}

//Создаём заголовок и кнопки для формы авторизации.
$action = 'Авторизуйтесь, или <a href="?action=registration">зарегистрируйтесь</a>';
$btn_action = 'authorisation';
$btn_desc = 'Authorise';

//Если в GET-параметре action указана регистрация, то переделываем заголовок и кнопки для формы регистрации.
if (isset($_GET['action']) && $_GET['action'] == 'registration') {
    $action = 'Придумайте логин и пароль для регистрации';
    $btn_action = 'registration';
    $btn_desc = 'Register';
    $avatar_upload_field = 'Avatar image<br><input type="file" name="avatar" accept="image/*"><br><br>';
}

?>
<p><?= $action ?></p>
<form method="post" action="../addons/form-handler.php" enctype="multipart/form-data">
    <input type="email" name="login" id="login">
    <label for="login">Login</label>
    <?php br() ?>
    <input type="password" name="pass" id="password">
    <label for="password">Password</label>
    <?php br();
    isset($avatar_upload_field) ? print_r($avatar_upload_field) : '';
    ?>
    <button type="submit" name="action" value="<?= $btn_action ?>"><?= $btn_desc ?></button>
</form>
