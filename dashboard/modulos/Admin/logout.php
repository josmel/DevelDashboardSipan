<?php
    session_start();
    session_destroy();
 header('Location: /'.AMBIENTE.'/modulos/Admin/login.phtml');