<?php

use MongoDB\Driver\Session as DriverSession;

include_once __DIR__ . "/../traits/SQLGetterSetter.trait.php";

class Session
{
    public static $isError = false;
    public static $user = null;
    public static $usersession = null;
    public static function start()
    {
        session_start();
    }

    public static function unset()
    {
        session_unset();
    }
    public static function destroy()
    {
        session_destroy();
        /*
        If UserSession is active, set it to inactive.
        */
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function delete($key)
    {
        unset($_SESSION[$key]);
    }

    public static function isset($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function get($key, $default = false)
    {
        if (Session::isset($key)) {
            return $_SESSION[$key];
        } else {
            return $default;
        }
    }

    public static function getUser()
    {
        return Session::$user;
    }

    public static function getUserSession()
    {
        return Session::$usersession;
    }

    /**
     * Takes an email as input and returns if the session user has same email
     *
     * @param string $owner
     * @return boolean
     */
    public static function isOwnerOf($owner)
    {
        $sess_user = Session::getUser();
        if ($sess_user) {
            if ($sess_user->getEmail() == $owner) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function loadTemplate($name)
    {
        $script = $_SERVER['DOCUMENT_ROOT'] . get_config('base_path') . "_templates/$name.php";
        if (is_file($script)) {
            include $script;
        } else {
            Session::loadTemplate('_error');
        }
    }
    public static function getCurrentPageIdentifier()
    {
        if (isset($_GET['current_page'])) {
            return $_GET['current_page'];
        } else {
            // Default to a sensible value, e.g., dashboard
            return 'dashboard';
        }
    }
    public static function renderPage()
    {
        Session::loadTemplate('_master');
    }

    public static function renderPageLogin()
    {
        Session::loadTemplate('login');
    }
    public static function renderPageRegister()
    {
        Session::loadTemplate('signup');
    }

    public static function renderPageOfAdmin()
    {
        Session::loadTemplate('_masterForAdmin');
    }

    public static function currentScript()
    {
        return basename($_SERVER['SCRIPT_NAME'], '.php');
    }

    public static function isAuthenticated()
    {
        //TODO: Is it a correct implementation? Change with instanceof
        if (is_object(Session::getUserSession())) {
            return Session::getUserSession()->isValid();
        }
        return false;
    }
    public static function ensureLogin()
    {
        if (!Session::isAuthenticated()) {
            Session::set('_redirect', $_SERVER['REQUEST_URI']);
            header("Location: /admin");
            die();
        }
    }
    public static function getAllAdmin()
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM `auth` LIMIT 50";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }
    public static function deleteAdmin($id)
    {
        $conn = Database::getConnection();
        $sql = "DELETE FROM `auth` WHERE `id` = '$id' LIMIT 50";
        return $conn->query($sql);
    }
    public static function countAllUser()
    {
        $db = Database::getConnection();
        $sql = "SELECT COUNT(*) as count FROM `auth`";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['count'];
        }
        return 0;
    }
}
