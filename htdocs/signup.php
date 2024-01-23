<?php

include 'libs/load.php';

if (Session::isAuthenticated()) {
    Session::renderPageRegister();
}
header('location: /');
exit;
