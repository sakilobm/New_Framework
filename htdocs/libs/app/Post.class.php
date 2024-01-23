<?php

include_once __DIR__ . "/../traits/SQLGetterSetter.trait.php";

use Carbon\Carbon; //including a namespace

class Post
{
    use SQLGetterSetter; //including a trait

    public $id;
    public $conn;
    public $table;

    public static function registerPost($title, $post_type, $content, $category, $image_tmp)
    {
        if (is_file($image_tmp) && exif_imagetype($image_tmp) !== false) {
            $author = Session::getUser()->getEmail();
            $image_name = md5($author . time()) . image_type_to_extension(exif_imagetype($image_tmp));
            $image_path = get_config('upload_path') . $image_name;
            $image_folder = get_config('upload_path');
            if (!file_exists($image_folder)) {
                mkdir($image_folder, 0750, true);
                chmod($image_folder, 0750);
            }
            if (move_uploaded_file($image_tmp, $image_path)) {
                $image_uri = "/files/$image_name";

                $insert_command = "INSERT INTO `posts` (`title`, `post_type`, `content`, `uploaded_time`, `category`, `image`, `owner`) VALUES (?, ?, ?, now(), ?, ?, ?)";

                $db = Database::getConnection();
                $stmt = $db->prepare($insert_command);

                // Bind parameters
                $stmt->bind_param('ssssss', $title, $post_type, $content, $category, $image_uri, $author);

                if ($stmt->execute()) {
                    $id = $stmt->insert_id;
                    $stmt->close();
                    return new Post($id);
                } else {
                    $stmt->close();
                    return false;
                }
            }
        } else {
            throw new Exception("Image not uploaded");
        }
    }

    public static function updatePost($post_id, $title, $content, $category, $image_tmp = NULL)
    {
        $conn = Database::getConnection();

        // Check if a new image is provided and is a valid image file
        $author = Session::getUser()->getEmail();
        // TODO: Check User if Created User Is The Update User
        if ($author === null) {
            return ['message' => 'Please Login Before Updating Post'];
        }
        if ($image_tmp !== NULL && is_file($image_tmp) && exif_imagetype($image_tmp) !== false) {
            $image_name = md5($author . time()) . image_type_to_extension(exif_imagetype($image_tmp));
            $image_path = get_config('upload_path') . $image_name;
            $image_folder = get_config('upload_path');
            if (!file_exists($image_folder)) {
                mkdir($image_folder, 0750, true);
                chmod($image_folder, 0750);
            }
            if (move_uploaded_file($image_tmp, $image_path)) {
                $image_uri = "/files/$image_name";
            } else {
                return ['message' => 'Upload Failed: Filename is not valid'];
            }
        } else {
            // No new image provided, keep the existing image in the database
            $image_uri = null;
        }

        // Check if the post already has an image in the database
        $p = new Post($post_id);
        $existing_image = $p->getImage();

        // If no new image is provided, use the existing image URI
        if ($image_uri === null && $existing_image !== null) {
            $image_uri = $existing_image;
        }

        $sql = "UPDATE `posts` SET `title`=?, `content`=?, `category`=?, `image`=? WHERE `id`=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $title, $content, $category, $image_uri, $post_id);
        $result = $stmt->execute();
        if (!$result) {
            return ['message' => 'Error in SQL statement execution: ' . $stmt->error];
        }
        return ['success' => true, 'message' => 'Post updated successfully'];
    }
    public static function deletePostWithImage($id)
    {
        $p = new Post($id);
        $image = $p->getImage();
        $imageName = basename($image);
        if ($imageName) {
            $imagePath = get_config('upload_path') . $imageName;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        if ($p->delete()) {
            return true;
        }
        return false;
    }

    public static function getAllPosts()
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM `posts` ORDER BY `uploaded_time` DESC";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            return iterator_to_array($result);
        }
        return false;
    }
    public static function getAllPostsByCategory($category)
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM `posts` WHERE `category` = '$category' ORDER BY `uploaded_time` DESC";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            return iterator_to_array($result);
        }
        return false;
    }
    public static function getPostType($post_type)
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM `posts` WHERE `post_type` = '$post_type' ORDER BY `uploaded_time` DESC";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            return iterator_to_array($result);
        }
        return false;
    }
    public static function getAllType1Posts()
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM `posts` WHERE `post_type` = 'Type 1' ORDER BY `uploaded_time` DESC";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            return iterator_to_array($result);
        }
        return false;
    }
    public static function getAllType2Posts()
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM `posts` WHERE `post_type` = 'Type 2' ORDER BY `uploaded_time` DESC";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            return iterator_to_array($result);
        }
        return false;
    }
    public static function getAllType3Posts()
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM `posts` WHERE `post_type` = 'Type 3' ORDER BY `uploaded_time` DESC";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            return iterator_to_array($result);
        }
        return false;
    }
    public static function getAllImages()
    {
        $db = Database::getConnection();
        $sql = "SELECT `image` FROM `posts` ORDER BY `uploaded_time` DESC";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            return iterator_to_array($result);
        }
        return false;
    }
    public static function getPostById($id)
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM `posts` WHERE `id` = $id";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            return iterator_to_array($result);
        }
        return false;
    }

    public static function countAllPosts()
    {
        $db = Database::getConnection();
        $sql = "SELECT COUNT(*) as count FROM `posts`";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['count'];
        }
        return 0;
    }
    public static function deletePostsByCategory($category)
    {
        $db = Database::getConnection();
        $sql = "DELETE FROM `posts` WHERE ((`category` = '$category'));";
        if ($db->query($sql)) {
            return true;
        }
        return false;
    }


    public function __construct($id)
    {
        $this->id = $id;
        $this->conn = Database::getConnection();
        $this->table = 'posts';
    }
}
