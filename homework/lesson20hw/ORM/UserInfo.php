<?php

namespace ORM;

require_once 'ORM.php';

class UserInfo extends ORM
{
    private static ?UserInfo $instance = null;
    protected static string $table;

    private function __construct()
    {
        parent::__construct();
        self::setTable('user_info');
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public static function getInstance(): ?UserInfo
    {
        if (is_null(self::$instance)) {
            self::$instance = new UserInfo();
        }
        return self::$instance;
    }
}