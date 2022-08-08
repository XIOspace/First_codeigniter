<?php
// Hash

namespace App\Libraries;

class Hash
{
  // Encrypt user password
    public static function encrypt($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    // Check user password with db password
    public static function check($password, $hash)
    {
        if(password_verify($password, $hash)) {
          return true;
        }else { 
          return false; 
        }
    }
}
