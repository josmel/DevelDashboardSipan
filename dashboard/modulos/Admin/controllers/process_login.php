<?php

include_once '../../../includes/db_connect.php';
include_once '../../../includes/functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['email'], $_POST['password'])) {
//    var_dump($_POST);exit;
    $email = $_POST['email'];
    $password = $_POST['password']; // The hashed password.

    if (login($email, $password, $mysqli) == true) {
        // Login success 
        header('Location: /'.AMBIENTE.'/');
    } else {
        // Login failed 
        header('Location: /'.AMBIENTE.'/modulos/Admin/login.phtml?error=1');
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}