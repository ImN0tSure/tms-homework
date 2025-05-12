<?php

namespace classes;

use ORM\Users as TableUsers;
use ORM\UserInfo as TableUserInfo;

require_once 'iUser.php';
session_start();

abstract class absUser implements iUser
{
    private string $username;
    private string $user_status = '';
    private string $avatar_img;

    private static $instance = null;

//    Проверяем, если пользователь не авторизован, ставим ему статус guest, иначе загружаем его данные из "БД".
    private function __construct()
    {
        if (!isset($_SESSION['is_authorized']) || $_SESSION['is_authorized'] !== true) {
            $this->user_status = 'guest';
        } else {
            $this->username = TableUsers::getInstance()->selectById($_SESSION['user_id'])[0]['login'];

            $user_info = TableUserInfo::getInstance()->selectWhere(['user_id' => $_SESSION['user_id']])[0];

            $this->user_status = $user_info['status'];
            $this->avatar_img = $user_info['avatar_img'];
        }
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getAvatarImg(): string
    {
        return $this->avatar_img;
    }

    public function getStatus(): string
    {
        return $this->user_status;
    }

    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }

}
