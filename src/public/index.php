<?php

session_start();

if(getenv('APP_DEBUG')){
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

// Including Everything
include(__DIR__.'/../vendor/autoload.php');
include(__DIR__.'/../lib/session.php');
include(__DIR__.'/../lib/app.php');
include(__DIR__.'/../lib/cipher.php');
include(__DIR__.'/../lib/db.php');

// Getting PW from session
$session = new Session();
$pw = $session->get('token');

// Starting Services
$app = new App($pw);

// Checking if PW is correct
if(!$app->cipher->check()){
    if(isset($_POST['pw'])){ // Handle login

        // Set Session key
        $session->set('token',$_POST['pw']);

        // Reload page
        $app->reload();
    } else { // Show Login
        $app->view('login');
    }
    exit;
}

$page = isset($_GET['p']) ? $_GET['p'] : 'index';

switch($page) {
    case 'get':
        echo json_encode($app->getTOTP($_GET['id']));
        break;
        
    case 'create':
        if(isset($_POST['titel']) && isset($_POST['key']) ) {
            $app->db->add($_POST['titel'], $app->cipher->encrypt($_POST['key']));
        }
        $app->route('/');
        break;

    case 'remove':
        $app->db->delete($_GET['id']);
        $app->route('/');
        break;

    case 'delete':
        $row = $app->db->get($_GET['id']);
        $app->view('delete',['row' => $row]);
        break;

    case 'new':
        $app->view('new');
        break;

    case 'logout':
        session_destroy();
        $app->route('/');
        break;

    default:
        $rows = $app->db->getAll();
        $app->view('index',['rows' => $rows]);
        break;
}
?>