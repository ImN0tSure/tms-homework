<?php
ini_set('MEMORY_LIMIT', '128M');
include_once '../addons/functions.php';

$action = 'Авторизуйтесь, или <a href="?action=registration">зарегистрируйтесь</a>';
$btn_action = 'authorisation';
$btn_desc = 'Authorise';


if (isset($_GET['action'])) {
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
    <?php br()?>
    <input type="password" name="pass" id="password">
    <label for="password">Password</label>
    <?php br();
    isset($avatar_upload_field) ? print_r($avatar_upload_field) : '';
    ?>
    <button type="submit" name="action" value="<?= $btn_action ?>"><?= $btn_desc ?></button>
</form>
