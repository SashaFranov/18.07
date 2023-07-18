<?php

namespace app\lib;

class UserOperations
{
    const  RoleGuest = 'guest';
    const RoleAdmin = 'admin';
    const RoleUser = 'user';
    public static function getRoleUser()
    {
        $result = self::RoleGuest;
        if (isset($_SESSION['user']['id']) && isset($_SESSION['user'])) {
            $result = self::RoleAdmin;
        } elseif (isset($_SESSION['user']['id'])){
            $result = self::RoleUser;
        }
        return $result;
    }
}