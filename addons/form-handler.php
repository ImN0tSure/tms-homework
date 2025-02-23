<?php
ini_set('MEMORY_LIMIT', '128M');
include_once '../addons/functions.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    die();
}

$login_empty_cond = (!isset($_POST['login']) || empty($_POST['login']));
$pass_empty_cond = (!isset($_POST['pass']) || empty($_POST['pass']));

$result = false;
$error = [];

switch ($_POST['action']) {

    case 'registration':

        if ($login_empty_cond || $pass_empty_cond) {
            $error[] =
                [
                    'code' => '0',
                    'text' => 'fulfill login and password'
                ];
            echo json_encode([
                'response' => $result,
                $error
            ]);
            die();
        }

        $login = htmlspecialchars($_POST['login']);
        $password = htmlspecialchars($_POST['pass']);

        if (file_exists('./lesson19hw-users/' . $login . '.json')) {
            $error[] =
                [
                    'code' => '1',
                    'text' => 'user with this login already exists'
                ];
            echo json_encode([
                'response' => $result,
                $error
            ]);
            die();
        }

        if (!preg_match('#^[a-z0-9._-]+@[a-z0-9-]+\.[a-z]{1,4}$#', $login)) {
            $error[] =
                [
                    'code' => '2',
                    'text' => 'set correct login'
                ];
        }

        if (strlen($password) < 6) {
            $error[] =
                [
                    'code' => '3',
                    'text' => 'password length must be at least 6 characters'
                ];
        }

        if (!empty($_FILES['avatar']['name'])) {
            print_r('ITS WORK');
            $avatar_name = basename($_FILES['avatar']['name']);
            if (!preg_match("#^.+\.(jpg|jpeg|png)$#", $avatar_name)) {
                $error[] = [
                    'code' => '4',
                    'text' => 'avatar must be jpg, jpeg or png format'
                ];
            }

            $avatar_size = $_FILES['avatar']['size'];
            if ($avatar_size > 10*1024*1024) {
                $error[] = [
                    'code' => '5',
                    'text' => 'avatar size must be less than 10 MB'
                ];
            }
        }

        if (empty($error)) {
            //create user
            $user_avatar = 'someone.jpg';

            if (!empty($_FILES['avatar']['name'])) {
                $avatar_tmp_name = $_FILES['avatar']['tmp_name'];
                $save_as = './lesson19hw-users/avatars/' . $login . '-' . $avatar_name;
                move_uploaded_file($avatar_tmp_name, $save_as);
                $user_avatar = $login . '-' . $avatar_name;
            }

            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $user_data = [
                'login' => $login,
                'password' => $password_hash,
                'avatar' => $user_avatar
            ];

            file_put_contents('./lesson19hw-users/' . $login . '.json', json_encode($user_data));

            $result = true;
        }


        print_r($error);

        break;

    case 'authorisation':

        if ($login_empty_cond || $pass_empty_cond) {
            $error[] =
                [
                    'code' => '0',
                    'text' => 'fulfill login and password'
                ];
            echo json_encode([
                'response' => $result,
                $error
            ]);
            die();
        }

        $login = htmlspecialchars($_POST['login']);
        $password = htmlspecialchars($_POST['pass']);

        if (file_exists('./lesson19hw-users/' . $login . '.json')) {

            $user_data = file_get_contents('./lesson19hw-users/' . $login . '.json');
            $user_data = json_decode($user_data, true);

            if (password_verify($password, $user_data['password'])) {
                $result = true;
            }

        }

        if (!$result) {
            $error[] =
                [
                    'code' => '10',
                    'text' => 'incorrect login or password'
                ];

            echo json_encode($error);
            die();
        }

        break;

    default:
        die();
}

if ($result) {
    header('Location: success.php?user=' . $login);
}