<?php

namespace classes;

require_once 'absUser.php';

class User extends absUser
{
    public function getUserInfo(): array
    {
        return [
            'username' => $this->getUsername(),
            'status' => $this->getStatus(),
        ];
    }

}
