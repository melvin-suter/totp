<?php


session_start();
include(__DIR__.'/../vendor/autoload.php');
include(__DIR__.'/../lib/cipher.php');

if(!isset($argv[1])){
    echo "PASSWORD NOT PASSED";
    exit;
}
$cipher = new Cipher($argv[1]);

if(!is_file(__DIR__.'/../data/key.txt')){
    file_put_contents(__DIR__.'/../data/key.txt',$cipher->encrypt(getenv('APP_KEY')));
    echo "KEY HAS BEEN SET";
} else {
    echo "KEY ALREADY SET";
}