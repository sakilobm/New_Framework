<?php
include_once __DIR__ . "/../traits/SQLGetterSetter.trait.php";

class Subscribe
{
    use SQLGetterSetter;
    public $conn;
    public $id;
    public $table;

    public static function add($email)
    {
        $conn = Database::getConnection();
        $query = "INSERT INTO `subscribers` (`email`) VALUES (?);";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $result = $stmt->execute();
        return $result;
    }
    public function __construct()
    {
        $this->table = 'subscribers';
        $this->conn = Database::getConnection();
        $this->id = null;
    }
}
