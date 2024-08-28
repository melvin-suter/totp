<?php


class App
{
    public $cipher;
    public $db;

    public function __construct($pw)
    {
        $this->db = new DB();
        $this->cipher = new Cipher($pw);
    }

    public function view($view,$vars = []){
        extract($vars);
        
        ob_start();
        include(__DIR__.'/../views/partials/head.php');
        include(__DIR__.'/../views/'.$view.'.php');
        include(__DIR__.'/../views/partials/feet.php');

        $output = ob_get_clean();
        echo $output;
        exit;
    }

    public function route($url){
        header("Location: ".$url);
        exit;
    }

    public function reload(){
        header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        exit;
    }

    public function getTOTP($id){
        $totpKey = $this->db->get($id)['key'];
        $totp = OTPHP\TOTP::createFromSecret($this->cipher->decrypt($totpKey));

        $timecode = (int) floor((time() - $totp->getEpoch()) / $totp->getPeriod());
        $timecode = $totp->getPeriod() - (time() - ($timecode * $totp->getPeriod()));

        return [
            'totp' => $totp->now(),
            'time' => $timecode
        ];
    }

    public function session_get($key,$def = -1){
        return isset($_SESSION[$key]) ? $this->cipher->decrypt($_SESSION[$key]) : $def;
    }

    public function session_set($key, $value) {
        $_SESSION[$key] = $this->cipher->encrypt($value);
    }
}