<?php
//TODO: Implement atoload of class files
include_once 'app/Post.class.php';
include_once 'app/Category.class.php';
include_once 'includes/API.class.php';
include_once 'includes/Database.class.php';
include_once 'includes/REST.class.php';
include_once 'includes/Session.class.php';
include_once 'includes/User.class.php';
include_once 'includes/UserSession.class.php';
include_once 'includes/WebAPI.class.php';
include_once 'traits/SQLGetterSetter.trait.php';

// use LDAP\Result;

global $__site_config;
//Note: Change this path if you run this code outside lab.
// $__site_config = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/../photogramconfig.json');
// echo $__site_config_path;
use Carbon\Carbon;

$wapi = new WebAPI();
$wapi->initiateSession();

function get_config($key, $default = null)
{
    global $__site_config;
    $array = json_decode($__site_config, true);
    if (isset($array[$key])) {
        return $array[$key];
    } else {
        return $default;
    }
}

function load_template($name)
{
    include $_SERVER['DOCUMENT_ROOT'] . get_config('base_path') . "_templates/$name.php";
}
