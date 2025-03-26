<?php

interface iUser
{
    public function getUsername(): string;

    public function getAvatarImg(): string;

    public function getStatus(): string;

    public static function getInstance();

}