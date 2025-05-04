<?php

namespace classes;

class Authorization
{
    private bool $response = false;
    private array $user_data;
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

        if (!file_exists('../users/' . $this->entered_login . '.json')) {
            $this->setError();
        } else {
            $data = file_get_contents('../users/' . $this->entered_login . '.json');
            $this->user_data = json_decode($data, true);
        }

        return $this;
    }

//    Верифицируем пароль. Если пароль не совпадает с данными из "БД", генерируем ошибку.
    public function checkPassword()
    {
        if (!empty($this->error)) {
            return $this;
        }

        $verify_password = password_verify($this->entered_password, $this->user_data['password']);

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
            $_SESSION['username'] = $this->user_data['login'];
            $_SESSION['is_authorized'] = true;
            $_SESSION['status'] = $this->user_data['status'];

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
