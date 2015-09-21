<?php

include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
sec_session_start();
if (login_check($mysqli) == true) {
    header('Location: /'.AMBIENTE.'/modulos/Admin/home.phtml');
} else { 
      header('Location: /'.AMBIENTE.'/modulos/Admin/login.phtml');
}
