<?php
// Hash

namespace App\Libraries;

class Hash
{
    public static function encrypt($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}
