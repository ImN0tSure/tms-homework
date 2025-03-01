<?php
function hr()
{
    print_r("<br><hr style='margin: 20px 0'>");
}

function br()
{
    print_r("<br><br>");
}


function checkPHPver(): string
{
    $cur_php_ver = phpversion();
    $min_php_ver = '7.1.0';

    if ($cur_php_ver >= $min_php_ver) {
        return 'Псевдо псевдослучайное';
    }
    return 'Псевдослучайное';
}

function generateString(): string
{
    $array = [1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f'];
    $result = '';
    while (strlen($result) < 10) {
        $result .= $array[mt_rand(0, count($array) - 1)];
    }

    return $result;
}

function setUserStatus($user_name, $status): string
{
    $uni_code = generateString();
    $expire_date = time() + 60 * 20;
    $user_data = [
        'status' => $status,
        'confirm' => $uni_code,
        'expire' => $expire_date
    ];

    $current_users = file_get_contents('lesson19hw-users/waffles/sessions.json');
    $current_users = json_decode($current_users, true);
    $current_users[$user_name] = $user_data;
    file_put_contents('lesson19hw-users/waffles/sessions.json', json_encode($current_users));

    return 'status=' . $status . '&user=' . $user_name . '&confirm=' . password_hash($uni_code, PASSWORD_DEFAULT);
}

function confirmUserStatus()
{
    if (!isset($_GET['status']) || !isset($_GET['confirm']) || !isset($_GET['user'])) {
        return false;
    }
    $user = $_GET['user'];
    $status = $_GET['status'];
    $confirm_hash = $_GET['confirm'];

    $current_users = file_get_contents('lesson19hw-users/waffles/sessions.json');
    $current_users = json_decode($current_users, true);

    if (!isset($current_users[$user])) {
        return false;
    }

    $udata_status = $current_users[$user]['status'];
    $udata_confirm = $current_users[$user]['confirm'];

    if ($udata_status !== $status || !password_verify($udata_confirm, $confirm_hash)) {
        return false;
    }

    $udata_expire = $current_users[$user]['expire'];

    if ($udata_expire < time()) {
        return false;
    }

    return 'status=' . $status . '&user=' . $user . '&confirm=' . $confirm_hash;
}

function checkUserStatus()
{
    if (!$add_get = confirmUserStatus()) {
        header('Location: http://tms-hw.local/homework/lesson19hw.php?status=guest');
    }

    return $add_get;
}