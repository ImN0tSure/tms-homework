<?php

namespace classes;

require_once '../ORM/Users.php';
require_once '../ORM/UserInfo.php';

interface iUser
{
    public function getUsername(): string;

    public function getAvatarImg(): string;

    public function getStatus(): string;

    public static function getInstance();

}
