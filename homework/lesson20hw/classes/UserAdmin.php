<?php

namespace classes;

use ORM\Users as TableUsers;
use ORM\UserInfo as TableUserInfo;

require_once 'absUser.php';

class UserAdmin extends absUser
{
    private array $current_statuses = [];

    public function getUserInfo($username): array
    {
        $search_user = TableUsers::getInstance()->selectWhere(['login' => $username]);

        if (!$search_user) {
            return [
                'error' =>
                    [
                        'code' => 1,
                        'message' => 'User does not exist'
                    ]
            ];
        }

        $search_user_info = TableUserInfo::getInstance()->selectWhere(['user_id' => $search_user[0]['id']]);

        return [
            'login' => $search_user[0]['login'],
            'email' => $search_user_info[0]['email'],
            'avatar_img' => $search_user_info[0]['avatar_img'],
            'status' => $search_user_info[0]['status'],
        ];
    }

    public function changeUserStatus()
    {
        foreach ($_POST as $id => $new_status) {
            if($this->current_statuses[$id] != $new_status) {
                TableUserInfo::getInstance()->update(['status' => $new_status], ['user_id' => $id]);
            }
        }
    }

    public function listAllUsers()
    {
        $all_users = TableUsers::getInstance()->all();
        $all_user_info = TableUserInfo::getInstance()->all();

        $inputs = '';
        $form = '
            <p>
                0 - Администратор<br>
                1 - Пользователь<br>
                2 - Покемон<br>
                3 - *Здесь может быть ваш статус<br>
            </p>
            <form action="../addons/change-status.php" method="post">
                **$inputs**
                <br>
                <button type="submit">Подтвердить</button>
            </form>
        ';

        foreach ($all_users as $key => $user_data) {
            $username = $user_data['login'];
            $user_id = $user_data['id'];
            $user_status = $all_user_info[$key]['status'];
            $inputs .= '<br>' . $username . '<br>
                <input 
                    type="text"
                    name=" ' . $user_id . '"
                    value="' . $user_status . '"
                ><br>';

            $this->current_statuses[$user_id] = $user_status;
        }

        return str_replace('**$inputs**', $inputs, $form);
    }

}
