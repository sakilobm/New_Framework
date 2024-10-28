<?php

include_once __DIR__ . "/../traits/SQLGetterSetter.trait.php";

use Carbon\Carbon;

class Post
{
    use SQLGetterSetter;

    public $id;
    public $conn;
    public $table;
    public $post;
    public $title;

    public static function registerPost($title, $subtitle, $content, $category, $draft)
    {
        $author = Session::getUser()->getEmail();
        $image_uri = null;
        $pdf_uri = null;
        $clean_html = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

        $fileUploader = new FileManager();
        // Handle image upload
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $result = $fileUploader->handleFile($_FILES['image'], $author, 'image');
            if ($result['status'] === 'error') {
                return $result;
            } else {
                $image_uri = $result['file_uri'];
            }
        }

        // Handle PDF upload
        if ($_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
            error_log("Pdf Is Setted");
            $result = $fileUploader->handleFile($_FILES['pdf'], $author, 'pdf');
            if ($result['status'] === 'error') {
                return $result;
            } else {
                $pdf_uri = $result['file_uri'];
            }
        }

        $sql = "INSERT INTO `posts` (`uploaded_time`, `title`, `subtitle`, `draft`, `content`, `category`, `image`, `pdf`, `owner`) VALUES (now(), ?, ?, ?, ?, ?, ?, ?, ?)";

        $conn = Database::getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->bind_param('ssisssss', $title, $subtitle, $draft, $clean_html, $category,  $image_uri, $pdf_uri, $author);

        if ($stmt->execute()) {
            $stmt->close();
            return [
                'status' => 'success',
                'message' => "New post published successfully"
            ];
        } else {
            error_log("MySQL Error: " . mysqli_error($conn));
            $stmt->close();
            return false;
        }
    }

    public static function updatePost($post_id, $title, $content, $category, $subtitle, $draft)
    {
        $author = Session::getUser()->getEmail();
        $image_uri = null;
        $pdf_uri = null;

        $fileUploader = new FileManager();

        // Handle image upload
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $result = $fileUploader->handleFile($_FILES['image'], $author, 'image');
            if ($result['status'] === 'error') {
                return $result;
            } else {
                $image_uri = $result['file_uri'];
            }
        }

        // Handle PDF upload
        if ($_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
            $result = $fileUploader->handleFile($_FILES['pdf'], $author, 'pdf');
            if ($result['status'] === 'error') {
                return $result;
            } else {
                $pdf_uri = $result['file_uri'];
            }
        }

        $p = new Post($post_id);

        $existingTitle = $p->getTitle();
        $existingCategory = $p->getCategory();
        $existingContent = $p->getContent();
        $existingSubtitle = $p->getSubtitle();
        $existingDraft = $p->getDraft();

        $existing_image = $p->getImage();
        $existing_pdf = $p->getPdf();

        if ($title == $existingTitle) {
            $title = '';
        }
        if ($category == $existingCategory) {
            $category = '';
        }
        if ($content == $existingContent) {
            $content = '';
        }
        if ($subtitle == $existingSubtitle) {
            $subtitle = '';
        }
        if ($draft == $existingDraft) {
            $draft = '';
        }

        if ($image_uri === null && $existing_image !== null) {
            $image_uri = $existing_image;
        }

        if ($pdf_uri === null && $existing_pdf !== null) {
            $pdf_uri = $existing_pdf;
        }
        $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

        $conn = Database::getConnection();
        // Prepare SQL query with COALESCE to only update non-empty values
        $sql = "UPDATE `posts` SET `title` = COALESCE(NULLIF(?, ''), `title`), `subtitle` = COALESCE(NULLIF(?, ''), `subtitle`), `draft` = COALESCE(NULLIF(?, ''), `draft`), `content` = COALESCE(NULLIF(?, ''), `content`), `category` = COALESCE(NULLIF(?, ''), `category`), `image` = COALESCE(?, `image`), `pdf` = COALESCE(?, `pdf`) WHERE `id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssissssi", $title, $subtitle, $draft, $content, $category, $image_uri, $pdf_uri, $post_id);
        if ($stmt->execute()) {
            $stmt->close();
            return [
                'status' => 'success',
                'message' => "New post published successfully"
            ];
            return true;
        } else {
            error_log("MySQL Error: " . mysqli_error($conn));
            $stmt->close();
            return false;
        }
    }
    public static function toggleDraft($id)
    {
        $post = new Post($id);
        $draft = $post->getDraft();
        error_log("DRAFT : $draft");
        if ($draft) {
            $post->setDraft(0);
            return true;
        } else {
            $post->setDraft(1);
            return true;
        }
        return false;
    }

    public static function sendPdf($post_id, $pdf_tmp)
    {
        $author = Session::getUser()->getEmail();
        $pdf_uri = null;

        $fileUploader = new FileManager(); // Create an instance of FileManager

        if ($pdf_tmp) {
            $pdfFileTmp = $_FILES['pdf']['tmp_name'];

            if (!$fileUploader->isValidPdf($pdfFileTmp)) {
                return [
                    'status' => 'error',
                    'message' => 'This is a not valid pdf'
                ];
            }
            error_log("This is a valid pdf");
            if ($_FILES['pdf']['size'] > $fileUploader->maxFileSize) {
                return [
                    'status' => 'error',
                    'message' => 'PDF size should be under 8MB'
                ];
            }
            error_log("Pdf size is now under 8MB");
            $pdf_uri = $fileUploader->uploadFile($pdfFileTmp, $author, 'pdf');
            if (!$pdf_uri) {
                return [
                    'status' => 'error',
                    'message' => 'Failed to upload the PDF file.'
                ];
            }
            error_log("Success to upload the image file.");
        }

        $p = new Post($post_id);
        $existing_pdf = $p->getPdf();

        if ($pdf_uri === null && $existing_pdf !== null) {
            $pdf_uri = $existing_pdf;
        }

        $conn = Database::getConnection();
        $sql = "UPDATE `posts` SET `pdf`=? WHERE `id`=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $pdf_uri, $post_id);
        return $stmt->execute();
    }

    public static function deletePdf($id)
    {
        $p = new Post($id);
        $pdf = $p->getPdf();

        if ($pdf) {
            FileManager::deleteFile($pdf);
        }
        return $p->setPdf(null);
    }
    private static function isValidImage($image_tmp)
    {
        $valid_types = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP];
        return is_file($image_tmp) && in_array(exif_imagetype($image_tmp), $valid_types);
    }

    private static function isValidPdf($pdf_tmp)
    {
        return is_file($pdf_tmp) && mime_content_type($pdf_tmp) === 'application/pdf';
    }

    /**
     * Handle File Upload
     *
     * @param [string $file_tmp] Temp File Location
     * @param [string $author] Author Name
     * @param [string $type] Image Or Pdf
     * @return string|false Returns the URI of the uploaded file on success, or null on failure.
     */
    private static function moveFile($file_tmp, $author, $type = 'image')
    {
        if (self::isValidImage($file_tmp)) {
            $upload_path = ($type === 'image') ? get_config('upload_path') : get_config('upload_path_pdf');

            if ($type === 'image') {
                $file_extension = image_type_to_extension(exif_imagetype($file_tmp));
            } else {
                $file_extension = '.pdf';
            }

            $file_name = md5($author . time()) . $file_extension;
            $file_path = $upload_path . $file_name;

            if (!file_exists($upload_path)) {
                mkdir($upload_path, 0750, true);
                chmod($upload_path, 0750);
            }

            if (move_uploaded_file($file_tmp, $file_path)) {
                return "/files/$file_name";
            } else {
                return false;
            }
        }
        return false;
    }

    public static function deletePost($id)
    {
        $p = new Post($id);
        $image = $p->getImage();
        $pdf = $p->getPdf();

        if ($image) {
            FileManager::deleteFile($image);
        }
        if ($pdf) {
            FileManager::deleteFile($pdf);
        }

        if ($p->delete()) {
            return true;
        }
        return false;
    }

    public static function getAllPosts($filter = 'DESC')
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM `posts` WHERE `draft` = 0 ORDER BY `uploaded_time` $filter";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            return iterator_to_array($result);
        }
        return false;
    }
    public static function getOneLatestPost()
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM `posts` ORDER BY `uploaded_time` DESC LIMIT 1";
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
    public static function getPostType()
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM `posts` ORDER BY `uploaded_time` DESC";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            return iterator_to_array($result);
        }
        return false;
    }
    public static function getAllTypePosts()
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM `posts` ORDER BY `uploaded_time` DESC";
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
    /**
     * Get Posts With Offset
     *
     * @param int $offset Starting point for the posts (default is 0).
     * @param int $limit How many posts to retrieve (default is 4).
     * @return array|false Returns an associative array of posts on success, or false on failure.
     */
    public static function getPostsWithOffset($offset = 0, $limit = 4)
    {
        $db = Database::getConnection();
        // Using both order and filter dynamically
        $sql = "SELECT * FROM `posts` LIMIT $limit OFFSET $offset";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        return false;
    }

    // Get Title
    public static function getTitleById($id)
    {
        $db = Database::getConnection();
        $sql = "SELECT `title` FROM `posts` WHERE `id` = '$id'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return  $row['title'];
        }
        return false;
    }
    public static function getTitleByTitle($title)
    {
        $t = str_replace('-', ' ', $title);
        $db = Database::getConnection();
        $sql = "SELECT `title` FROM `posts` WHERE `title` = '$t'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return  $row['title'];
        }
        return false;
    }
    public static function getTitleByCategory($title)
    {
        $t = str_replace('-', ' ', $title);
        $db = Database::getConnection();
        $sql = "SELECT `title` FROM `posts` WHERE `category` = '$t'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return  $row['title'];
        }
        return false;
    }
    public static function getTitleByToken($token)
    {
        $db = Database::getConnection();
        $sql = "SELECT `title` FROM `posts` WHERE `token` = '$token'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return  $row['title'];
        }
        return false;
    }
    public static function getTitleByAlias($alias)
    {
        $db = Database::getConnection();
        $sql = "SELECT `title` FROM `posts` WHERE `alias` = '$alias'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return  $row['title'];
        }
        return false;
    }
    // Get Title End

    public static function getPostByToken($token)
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM `posts` WHERE `token` = '$token'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            return iterator_to_array($result);
        }
        return false;
    }
    public static function getPostByAlias($alias)
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM `posts` WHERE `alias` = '$alias'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            return iterator_to_array($result);
        }
        return false;
    }
    public static function getSinglePost($s)
    {
        $db = Database::getConnection();
        $sql = "SELECT * FROM `posts` WHERE `title` = '$s' OR `id` = '$s'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            return iterator_to_array($result);
        }
        return false;
    }
    public static function hyphenedTitle($t)
    {
        $s = str_replace(' ', '-', $t);
        return $s;
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

    public static function sanitizedTitle($t)
    {
        $sanitized_title = str_replace('-', ' ', $t);
        return preg_replace('/\s+/', ' ', $sanitized_title);
    }

    function generateSlug($title)
    {
        // Remove special characters
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $title);
        return strtolower($slug);
    }

    public function __construct($title)
    {
        $this->conn = Database::getConnection();
        $this->table = 'posts';

        $title = urldecode($title);
        $decoded_title = html_entity_decode($title, ENT_QUOTES, 'UTF-8');

        $this->title = str_replace('-', ' ', $decoded_title);
        // error_log("Title :: $this->title");

        $this->id = null;

        $sql = "SELECT `id` FROM `$this->table` WHERE `id` = '$this->title' OR `title` = '$this->title' OR `category` = '$this->title' LIMIT 1";
        $result = $this->conn->query($sql);
        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            $this->id = $row['id']; //Updating this from database
        } else {
            error_log("Error :: Title does't exist :: $title");
            throw new Exception(__CLASS__ . "::-> $title ->" . "Title does't exist");
        }
    }
}
