<?php

namespace classes;

use ORM\Users as TableUsers;
use ORM\UserInfo as TableUserInfo;

require_once '../ORM/Users.php';
require_once '../ORM/UserInfo.php';

class Registration
{
    private bool $response = false;
    private array $error = [];
    private array $user_data = [];
    private array $avatar_data;

//    Записываем полученные вводные в свойства класса
    public function __construct($login, $password, $avatar_data)
    {
        $this->user_data['login'] = htmlspecialchars($login);
        $this->user_data['password'] = $password;
        $this->user_data['status'] = 1;
        $this->avatar_data = $avatar_data;

        return $this;
    }

//    Проверяем логин на соответствие формату e-mail при помощи регулярного выражения, а также свободен данный логин, или нет.
    public function checkLogin()
    {
        if (strlen($this->user_data['login']) > 15) {
            $this->error[] =
                [
                    'code' => '1.0',
                    'text' => 'login must be 15 characters long'
                ];
        }

        if (!preg_match('#^[a-z0-9._-]+@[a-z0-9-]+\.[a-z]{1,4}$#', $this->user_data['login'])) {
            $this->error[] =
                [
                    'code' => '1.1',
                    'text' => 'set correct login'
                ];
        }

        if (TableUsers::getInstance()->selectWhere(['login' => $this->user_data['login']])) {
            $this->error[] =
                [
                    'code' => '1.2',
                    'text' => 'user already exists'
                ];
        }

        return $this;
    }

//    Проверяем длину пароля.
    public function checkPassword()
    {
        $password = $this->user_data['password'];

        if (strlen($password) < 6) {
            $this->error[] =
                [
                    'code' => '2',
                    'text' => 'password must be at least 6 characters'
                ];
        }

        return $this;
    }

//    Проверяем параметры предлагаемой пользователем аватарки. Если аватарка пустая, помечаем, что нужно установить стандартную.
    public function checkAvatar()
    {
        if (empty($this->avatar_data['avatar']['name'])) {
            $this->avatar_data['avatar'] = 'default_avatar';

            return $this;
        }

        $avatar_name = basename($this->avatar_data['avatar']['name']);
        $avatar_size = &$this->avatar_data['avatar']['size'];

        if (!preg_match("#^.+\.(jpg|jpeg|png)$#", $avatar_name)) {
            $this->error[] = [
                'code' => '3',
                'text' => 'avatar must be jpg, jpeg or png format'
            ];
        }

        if ($avatar_size > 10 * 1024 * 1024) {
            $this->error[] = [
                'code' => '4',
                'text' => 'avatar size must be less than 10 MB'
            ];
        }

        return $this;
    }

//    Регистрируем пользователя.
    public function registerNewUser()
    {
        $this->checkLogin()->checkPassword()->checkAvatar();

        if (empty($this->error)) {
            $this->saveAvatar();

            $user = [
                'login' => $this->user_data['login'],
                'password_hash' => password_hash($this->user_data['password'], PASSWORD_DEFAULT),
            ];

            $new_user_id = TableUsers::getInstance()->insert($user);

            $user_info = [
                'user_id' => $new_user_id,
                'email' => $this->user_data['login'],
                'avatar_img' => $this->user_data['avatar_img'],
                'status' => $this->user_data['status'],
            ];

            TableUserInfo::getInstance()->insert($user_info);

            $_SESSION['user_id'] = $new_user_id;
            $_SESSION['is_authorized'] = true;
            $_SESSION['user_status'] = 1;

            $this->response = true;
        }

        $response_data['response'] = $this->response;
        $response_data['error'] = $this->error;

        return $response_data;
    }

//    Сохраняем аватарку и указываем путь до неё.
    private function saveAvatar()
    {
        if ($this->avatar_data['avatar'] == 'default_avatar') {
            $this->user_data['avatar_img'] = '../avatars/someone.jpg';
        } else {
            $avatar_tmp_name = $this->avatar_data['avatar']['tmp_name'];
            $avatar_name = $this->avatar_data['avatar']['name'];
            $login = $this->user_data['login'];
            $save_as = '../avatars/' . $login . '-' . $avatar_name;

            move_uploaded_file($avatar_tmp_name, $save_as);
            $this->user_data['avatar_img'] = $login . '-' . $avatar_name;
        }
    }
}
