<?php

namespace classes;

use ORM\Users as TableUsers;
use ORM\UserInfo as TableUserInfo;

require_once '../ORM/Users.php';
require_once '../ORM/UserInfo.php';

class Authorization
{
    private bool $response = false;
    private array $user_data = [];
    private array $error;
    private string $entered_login;
    private string $entered_password;

    public function __construct(string $login, string $password)
    {
        $this->entered_login = htmlspecialchars($login);
        $this->entered_password = $password;
    }

//    Проверяем логин на соответствие формату e-mail при помощи регулярного выражения, а также существует данный логин, или нет.
    public function checkLogin()
    {
        if (!preg_match('#^[a-z0-9._-]+@[a-z0-9-]+\.[a-z]{1,4}$#', $this->entered_login)) {
            $this->setError();
        }

        $this->user_data = TableUsers::getInstance()->selectWhere(['login' => $this->entered_login]);

        if (!$this->user_data) {
            $this->setError();
        }

        return $this;
    }

//    Верифицируем пароль. Если пароль не совпадает с данными из "БД", генерируем ошибку.
    public function checkPassword()
    {
        if (!empty($this->error)) {
            return $this;
        }

        $verify_password = password_verify($this->entered_password, $this->user_data[0]['password_hash']);

        if (!$verify_password) {
            $this->setError();
        }

        return $this;
    }

//    Авторизуем пользователя, записывая в сессию его логин и авторизацию.
    public function authorizeUser()
    {
        $this->checkLogin()->checkPassword();

        if (!empty($this->error)) {
            $response_data['response'] = $this->response;
            $response_data['error'] = $this->error;
        } else {
            $_SESSION['user_id'] = $this->user_data[0]['id'];
            $_SESSION['is_authorized'] = true;
            $_SESSION['user_status'] = TableUserInfo::getInstance()
                ->selectWhere(['user_id' => $this->user_data[0]['id']])[0]['status'];

            $response_data['response'] = true;
        }

        return $response_data;
    }

//    Стандартная ошибка при неверном вводе логина и пароля.
    private function setError()
    {
        $this->error =
            [
                'code' => '1',
                'text' => 'wrong login or password'
            ];
    }

}
