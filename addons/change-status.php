<?php
ini_set('MEMORY_LIMIT', '128M');
include_once '../addons/functions.php';

$add_get = checkUserStatus();


foreach ($_POST as $key => $value) {
    $key = str_replace('_', '.', $key);
    if (file_exists('./lesson19hw-users/users/' . $key . '.json')) {
        $udata = file_get_contents('./lesson19hw-users/users/' . $key . '.json');
        $udata = json_decode($udata, true);
        $udata['status'] = $value;

        file_put_contents('./lesson19hw-users/users/' . $key . '.json', json_encode($udata));

        $tmp_data = file_get_contents('./lesson19hw-users/waffles/sessions.json');
        $tmp_data = json_decode($tmp_data, true);
        print_r($tmp_data);
        if (isset($tmp_data[$key]) && $tmp_data[$key]['status'] !== $value) {
            $tmp_data[$key]['expire'] = 1;
            file_put_contents('./lesson19hw-users/waffles/sessions.json', json_encode($tmp_data));
        }
    }

}

header('Location: success.php?' . $add_get);