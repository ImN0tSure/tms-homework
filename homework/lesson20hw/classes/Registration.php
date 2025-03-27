<?php

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
        $this->user_data['status'] = 'regular';
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

        if (file_exists('../users/' . $this->user_data['login'] . '.json')) {
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
            $this->user_data['password'] = password_hash($this->user_data['password'], PASSWORD_DEFAULT);
            file_put_contents('../users/' . $this->user_data['login'] . '.json', json_encode($this->user_data));

            $this->response = true;

            $_SESSION['username'] = $this->user_data['login'];
            $_SESSION['is_authorized'] = true;
            $_SESSION['status'] = 'user';

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
