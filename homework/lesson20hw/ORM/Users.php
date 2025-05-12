<?php

namespace ORM;

require_once 'ORM.php';

class Users extends ORM
{
//    private static ?Users $instance = null;
//    protected static string $table;

    public function __construct()
    {
        parent::__construct();
    }

    protected static function setTable(): void {
        static::$table = 'users';
    }
    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}
