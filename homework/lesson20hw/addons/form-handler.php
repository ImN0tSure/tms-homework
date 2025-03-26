<?php
session_start();
require_once '../classes/Authorisation.php';
require_once '../classes/Registration.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: ../index.php');
}

$login = isset($_POST['login']) ? $_POST['login'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$avatar_data = !empty($_FILES['avatar']['name']) ? $_FILES : [];


switch ($_POST['action']) {
    case 'registration':
        $registration = (new Registration($login, $password, $avatar_data))
            ->registerNewUser();

        if ($registration['response']) {
            header('Location: ../pages/success.php');
        } else
        {
            print_r($registration);
        }
        break;

    case 'authorization':

        $authorization = (new Authorization($login, $password))
            ->authorizeUser();

        var_dump($authorization);
        print_r($_SESSION);

        if ($authorization['response']) {
            header('Location: ../pages/success.php');
        }

        break;

    case 'logout':
        unset($_SESSION['username']);
        unset($_SESSION['is_authorized']);
        unset($_SESSION['status']);

        header('Location: ../pages/success.php');

        break;
    default:
        header('Location: ../index.php');
}
