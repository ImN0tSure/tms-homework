<?php

class User
{
    private string $username;
    private string $user_status = '';
    private string $avatar_img;

//    Проверяем, если пользователь не авторизован, ставим ему статус guest, иначе загружаем его данные из "БД".
    public function __construct() {
        if (!isset($_SESSION['is_authorized']) || $_SESSION['is_authorized'] !== true) {
            $this->user_status = 'guest';
        } else {
            $user_data = file_get_contents('../users/' . $_SESSION['username'] . '.json');
            $user_data = json_decode($user_data, true);

            $this->username = $user_data['login'];
            $this->avatar_img = '../avatars/' . $user_data['avatar_img'];
            $this->user_status = $user_data['status'];
        }
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getAvatarImg(): string {
        return $this->avatar_img;
    }

    public function getStatus(): string {
        return $this->user_status;
    }
}
