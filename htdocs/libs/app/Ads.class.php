<?php
include_once __DIR__ . "/../traits/SQLGetterSetter.trait.php";

class Ads
{
    use SQLGetterSetter;
    public $conn;
    public $id;
    public $table;


    public static function getAdById($id)
    {
        $conn = Database::getConnection();
        $sql = "SELECT `ad_code` FROM `ads` WHERE `id` = '$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['ad_code'];
        }
        return false;
    }
    public static function isAdExist($id)
    {
        $conn = Database::getConnection();
        $sql = "SELECT `ad_code` FROM `ads` WHERE `id` = '$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
    public static function add($ad_code, $description)
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM `ads` WHERE `ad_code` = '$ad_code';";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return false;
        } else {
            $query2 = "INSERT INTO `ads` (`ad_code`, `description`, `published_at`) VALUES (?, ?, now());";
            $stmt2 = $conn->prepare($query2);
            $stmt2->bind_param("ss", $ad_code, $description);
            $result2 = $stmt2->execute();
            return $result2;
        }
    }
    public static function delete($ad)
    {
        $conn = Database::getConnection();
        $query = "DELETE FROM `ads` WHERE `id` = ?;";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $ad);
        $result = $stmt->execute();
        return $result;
    }
    public static function getAll()
    {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM `ads` ORDER BY `id` DESC LIMIT 50";
        $result = $conn->query($sql);
        $rows = [];
        if ($result->num_rows > 0) {
            while ($rowAd = $result->fetch_assoc()) {
                $rows[] = $rowAd;
            }
            return $rows;
        }
        return false;
    }
    public static function addToAdsTxt($id = 2)
    {
        $ad_code = self::getAdById($id);

        $adsTxtPath = get_config('base_path') . 'ads.txt';

        if (is_file($adsTxtPath)) {

            file_put_contents($adsTxtPath, "");

            if (file_put_contents($adsTxtPath, $ad_code, FILE_APPEND | LOCK_EX)) {
                return true;
            }
        }
        return false;
    }
    public function __construct()
    {
        $this->table = 'ads';
        $this->conn = Database::getConnection();
        $this->id = null;
    }
}
