<?php
session_start();
ini_set('MEMORY_LIMIT', '128M');
include_once '../../../addons/functions.php';


foreach ($_POST as $key => $value) {
    $key = str_replace('_', '.', $key);
    if (file_exists('../users/' . $key . '.json')) {
        $data = file_get_contents('../users/' . $key . '.json');
        $data = json_decode($data, true);
        $data['status'] = $value;

        file_put_contents('../users/' . $key . '.json', json_encode($data));
    }
}

header('Location: ../pages/success.php');
