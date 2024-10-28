<?php

include_once __DIR__ . "/../traits/SQLGetterSetter.trait.php";

use Carbon\Carbon; //including a namespace


class Category
{
    use SQLGetterSetter; //including a trait

    public $id;
    public $conn;
    public $table;

    public static function createCategry($category)
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM `category` WHERE `list_category` = '$category';";
        $result2 = $conn->query($sql);
        if ($result2->num_rows > 0) {
            return false;
        } else {
            $query2 = "INSERT INTO `category` (`list_category`) VALUES (?);";
            $stmt2 = $conn->prepare($query2);
            $stmt2->bind_param("s", $category);
            $result = $stmt2->execute();
            return $result;
        }
    }
    public static function deleteCategory($category)
    {
        $conn = Database::getConnection();
        $query = "DELETE FROM `category` WHERE `id` = ?;";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $category);
        $result = $stmt->execute();
        return $result;
    }
    public static function getAllCategory()
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM `category` ORDER BY `id` DESC";
        $result = $db->query($sql);
        return iterator_to_array($result);
    }

    public static function countAllCategory()
    {
        $db = Database::getConnection();
        $sql = "SELECT COUNT(*) as count FROM `category`";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['count'];
        }
        return 0;
    }

    public static function getCategoryById($id)
    {
        $db = Database::getConnection();
        $sql = "SELECT `list_category` FROM `category` WHERE `id` = $id";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['list_category'];
        }
        return false;
    }

    public function __construct($id)
    {
        $this->id = $id;
        $this->conn = Database::getConnection();
        $this->table = 'category';
    }
}
