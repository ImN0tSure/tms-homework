<?php

namespace ORM;

require_once 'ORM.php';

class UserInfo extends ORM
{
//    private static ?UserInfo $instance = null;
//    protected static string $table;

    public function __construct()
    {
        parent::__construct();
    }

    protected static function setTable(): void {
        static::$table = 'user_info';
    }
    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

}
