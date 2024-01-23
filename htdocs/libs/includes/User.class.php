<?php
include_once __DIR__ . "/../traits/SQLGetterSetter.trait.php";

class User
{
    use SQLGetterSetter;
    private $conn;

    public $id;
    public $username;
    public $table;
    public static function signup($user, $pass, $email, $phone)
    {
        $options = [
            'cost' => 9
        ];
        $pass = password_hash($pass, PASSWORD_BCRYPT, $options);
        $conn = Database::getConnection();
        $sql = "INSERT INTO `auth` (`username`, `password`, `email`, `phone`,`active`)
        VALUES ('$user', '$pass', '$email','$phone','1' );";
        //PHP 8.1 - all MySQLi errors are throws as Exceptions
        try {
            return $conn->query($sql);
        } catch (Exception $e) {
            echo "Error: " . "<br>" . $conn->error;
            return false;
        }
        //PHP 7.4 -
        // $error = false;
        // if ($conn->query($sql) === true) {
        //     $error = false;
        // } else {
        //     $error = $conn->error;
        //     return $error;
        // }
    }
    public static function login($user, $pass)
    {
        $query = "SELECT * FROM `auth` WHERE `username` = '$user' OR `email` = '$user'";
        $conn = Database::getConnection();
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // if ($row['password'] == $pass) {
            if (password_verify($pass, $row['password'])) {
                /**
                 * 1.Generate Session Token
                 * 2.Insert Session Token
                 * 3.Build Session and Given Session To User
                 */
                return $row['username'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    //User object can be construct with both UserID and Username.
    public function __construct($username)
    {
        $this->table = 'auth';
        $this->conn = Database::getConnection();
        $this->username = $username;
        $this->id = null;
        $sql = "SELECT `id` FROM `auth` WHERE `username` = '$username' OR `id` = '$username' OR `email` = '$username' LIMIT 1";
        $result = $this->conn->query($sql);
        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            $this->id = $row['id']; //Updating this from database
        } else {
            throw new Exception("Username does't exist");
        }

        //Todo: Write the code to fetch user data from database for the  given username. If user is not present, throw Exception.
        //update this from database.
    }

    public function setUsername()
    {
        return $this->username;
    }
    public function setDob($year, $month, $day)
    {
        if (checkdate($month, $day, $year)) { //checking data is valid
            return $this->_set_data('dob', "$year.$month.$day");
        } else {
            return false;
        }
    }
}
