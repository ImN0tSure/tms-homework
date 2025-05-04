<?php

namespace ORM;

require_once 'ORM.php';

class Users extends ORM
{
    private static ?Users $instance = null;
    protected static string $table;

    private function __construct()
    {
        parent::__construct();
        self::setTable('users');
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public static function getInstance(): ?Users
    {
        if (is_null(self::$instance)) {
            self::$instance = new Users();
        }
        return self::$instance;
    }
}
