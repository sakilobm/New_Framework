<?php
include_once 'libs/load.php';

if (isset($_GET['logout'])) {
    if (Session::isset("session_token")) {
        $Session = new UserSession(Session::get("session_token"));
        if ($Session->removeSession()) {
            echo "<h3> Previous session is removing from db </h3> ";
        } else {
            echo "<h3> Previous session not removing from db </h3> ";
        }
    }
    Session::unset();
    Session::destroy();
    header("Location: /");
    die();
}

if (Session::isAuthenticated()) {
    Session::renderPageOfAdmin();
} else {
    header("Location: /login");
    die();
}
