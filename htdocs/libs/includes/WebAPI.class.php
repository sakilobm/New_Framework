<?php

class WebAPI
{
    public function __construct()
    {
        global $__site_config;
        $__site_config_path = __DIR__ . "/../../../project/projectconfig.json";
        $__site_config = file_get_contents($__site_config_path);
        Database::getConnection();
        // if (php_sapi_name() == "cli") {
        //     $__site_config_path = "/home/sowbharath/htdocs/web3/project/photogramconfig.json";

        //     $__site_config = file_get_contents($__site_config_path);
        // } elseif (php_sapi_name() == "apache2handler") {
        //     $__site_config_path = dirname(is_link($_SERVER['DOCUMENT_ROOT']) ? readlink($_SERVER['DOCUMENT_ROOT']) : $_SERVER['DOCUMENT_ROOT']) . '/project/photogramconfig.json';
        //     $__site_config = file_get_contents($__site_config_path);
        // }
        $cookieParams = session_get_cookie_params();
        $cookieParams['samesite'] = 'None'; // Set to 'None' to allow cross-site access
        $cookieParams['secure'] = true; // Ensure the cookie is only sent over HTTPS
        session_set_cookie_params($cookieParams['lifetime'], $cookieParams['path'], $cookieParams['domain'], $cookieParams['secure'], $cookieParams['httponly']);
    }

    public function initiateSession()
    {
        Session::start();
        if (Session::isset("session_token")) {
            try {
                Session::$usersession = UserSession::authorize(Session::get('session_token'));
                // Session::set('user_session', $session);
            } catch (Exception $e) {
                //TODO: Handle error
            }
        }
    }
}
