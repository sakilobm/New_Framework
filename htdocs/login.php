<?php

include 'libs/load.php';

if (Session::isAuthenticated()) {
    header('location: /admin');
    exit;
}
Session::renderPageLogin();
