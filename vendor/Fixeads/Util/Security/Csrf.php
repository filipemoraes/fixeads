<?php

namespace Fixeads\Util\Security;

class Csrf {
    public static function create()
    {
        if (function_exists('openssl_random_pseudo_bytes'))
            $key = substr(bin2hex(openssl_random_pseudo_bytes(128)), 0, 128);
        else
            $key = sha1(mt_rand() . rand());

        $_SESSION['security']['csrf'] = $key;
        return $key;
    }

    public static function check($post)
    {
        if(!isset($post['csrf']))
            return false;

        if(!isset($_SESSION['security']['csrf']))
            return false;

        return $_SESSION['security']['csrf'] === $post['csrf'];
    }

    public static function clear()
    {
        unset($_SESSION['security']['csrf']);
    }
}
