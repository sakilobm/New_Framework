<?php
include_once __DIR__ . "/../traits/SQLGetterSetter.trait.php";

class Admin
{
    use SQLGetterSetter;
    public $table;
    private $conn;

    public static function isAdmin()
    {
        $conn = Database::getConnection();
        $username = Session::getUser()->getUsername();
        //TODO: Alternative : Use GetSetter function
        $sql = "SELECT `role` FROM `auth` WHERE `username` = '$username' OR `email` = '$username' LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            $role = $row['role'];
            $pwr = get_config('pwr');
            if ($role === $pwr) {
                return true;
            }
            // throw new Exception("Your Are Not Admin");
        } else {
            return false;
            // throw new Exception("Username does't exist");
        }
    }
    public static function addAdmin($email)
    {
        $conn = Database::getConnection();
        $sql = "UPDATE `auth` SET `role` = 'admin', `access` = 'granted' WHERE `email` = '$email';";
        $result = $conn->query($sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public static function removeAdmin($email)
    {
        $conn = Database::getConnection();
        $sql = "UPDATE `auth` SET `role` = 'user', `access` = 'denied' WHERE `email` = '$email';";
        if ($conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    public static function getAllAdmin()
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM `auth` LIMIT 50";
        $result = $conn->query($sql);
        return iterator_to_array($result);
    }

    public static function deleteAdmin($id, $sameUser)
    {
        $conn = Database::getConnection();
        $token = Session::$usersession;
        $user = new UserSession($token->token);
        if ($sameUser) {
            if ($user->removeSession()) {
                Session::delete('session_token');
            }
        }
        $sql = "DELETE FROM `auth` WHERE `id` = '$id' LIMIT 50";
        return $conn->query($sql);
    }

    public function __construct($username)
    {
        $this->table = 'auth';
        $this->conn = Database::getConnection();
    }
}
