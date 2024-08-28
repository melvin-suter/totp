<?php


class Session
{
    private $cipher;

    public function __construct()
    {
        $this->cipher = new Cipher(getenv('APP_SESSION_KEY'));
    }

    public function get($key,$def = -1){
        return isset($_SESSION[$key]) ? $this->cipher->decrypt($_SESSION[$key]) : $def;
    }

    public function set($key, $value) {
        $_SESSION[$key] = $this->cipher->encrypt($value);
    }
}