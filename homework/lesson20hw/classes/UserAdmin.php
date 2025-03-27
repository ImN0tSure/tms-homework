<?php
require_once 'absUser.php';
class UserAdmin extends absUser
{
    public function getUserInfo($username): array {
        if (!file_exists('../users/' . $username . '.json')) {
            return ['error' =>
                [
                    'code' => 1,
                    'message' => 'User does not exist'
                ]
            ];
        }

        $user_data = json_decode(file_get_contents('../users/' . $username . '.json'), true);

        return [
            'user_name' => $user_data['login'],
            'user_avatar' => $user_data['avatar_img'],
            'user_status' => $user_data['status'],
        ];
    }

    public function changeUserStatus() {
        foreach ($_POST as $key => $value) {
            $key = str_replace('_', '.', $key);
            if (file_exists('../users/' . $key . '.json')) {
                $data = file_get_contents('../users/' . $key . '.json');
                $data = json_decode($data, true);
                $data['status'] = $value;

                file_put_contents('../users/' . $key . '.json', json_encode($data));
            }
        }
    }

    public function listAllUsers() {
        $all_users = scandir('../users/');

        $inputs = '';
        $form = '
            <form action="../addons/change-status.php" method="post">
                **$inputs**
                <br>
                <button type="submit">Подтвердить</button>
            </form>
        ';

        foreach ($all_users as $key => $user) {
            if ($key < 2) {
                continue;
            }

            $data = file_get_contents('../users/' . $user);
            $data = json_decode($data, true);

            $username = $data['login'];
            $user_status = $data['status'];
            $inputs .= '<br>' . $username . '<br><input type="text" name=" ' . $username . '" value="' . $user_status . '"><br>';
        }

        return str_replace('**$inputs**', $inputs, $form);
    }

}