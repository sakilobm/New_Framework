<?php
class FileManager
{
    public $maxFileSize = 8 * 1024 * 1024; // 8MB

    public function handleFile($file, $author, $type = 'image')
    {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileTmp = $file['tmp_name'];

            if ($fileTmp) {
                if ($type === 'image') {
                    if (!$this->isValidImage($fileTmp)) {
                        return [
                            'status' => 'error',
                            'message' => 'This is not a valid image'
                        ];
                    }
                } else if ($type === 'pdf') {
                    if (!$this->isValidPdf($fileTmp)) {
                        return [
                            'status' => 'error',
                            'message' => 'This is not a valid pdf'
                        ];
                    }
                }

                if ($file['size'] > $this->maxFileSize) {
                    return [
                        'status' => 'error',
                        'message' => ucfirst($type) . ' size should be under 8MB'
                    ];
                }

                $file_uri = $this->uploadFile($fileTmp, $author, $type);
                if (!$file_uri) {
                    return [
                        'status' => 'error',
                        'message' => 'Failed to upload the ' . $type . ' file.'
                    ];
                }

                return [
                    'status' => 'success',
                    'file_uri' => $file_uri
                ];
            }
        } else {
            $errorCode = $file['error'];
            return [
                'status' => 'error',
                'message' => "Failed to upload $type file. Error code: $errorCode"
            ];
        }
    }
    public function uploadFile($file_tmp, $author, $type = 'image')
    {
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
            error_log("Error When Try To Move File: 1.$file_tmp |||| 2.$file_path");
            return false;
        }
    }

    public function isValidImage($image_tmp)
    {
        $valid_types = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP];

        if (!is_file($image_tmp)) {
            error_log("The file does not exist or is not a regular file: $image_tmp");
            return false;
        }

        $image_type = exif_imagetype($image_tmp);
        if ($image_type === false) {
            error_log("Failed to identify image type: $image_tmp");
            return false;
        }

        if (!in_array($image_type, $valid_types)) {
            error_log("Invalid image type: $image_type");
            return false;
        }

        return true;
    }

    public function isValidPdf($pdf_tmp)
    {
        return is_file($pdf_tmp) && mime_content_type($pdf_tmp) === 'application/pdf';
    }

    public static function deleteFile($f)
    {
        $fileName = basename($f);
        if ($fileName) {
            $imagePath = get_config('upload_path') . $fileName;
            $pdfPath = get_config('upload_path_pdf') . $fileName;

            $paths = [$imagePath, $pdfPath];
            foreach ($paths as $path) {
                if (file_exists($path)) {
                    unlink($path);
                    error_log("File deleted from path: $path");
                    return true;
                }
            }
            return false;
        } else {
            return false;
            error_log("Invalid file name: $fileName");
        }
    }

    public static function deleteFileWithType($f, $t = 'image')
    {
        $fileName = basename($f);
        if ($fileName) {
            $path = null;

            if ($t == 'image') {
                $path = get_config('upload_path') . $fileName;
            } else {
                $path = get_config('upload_path_pdf') . $fileName;
            }

            if (file_exists($path)) {
                unlink($path);
                error_log("File deleted from path: $path");
                return true;
            } else {
                error_log("File Is Not Existed : $path ");
                return false;
            }
        } else {
            error_log("Invalid file name: $fileName");
        }
    }

    public static function cleanUpUploads($type = 'image')
    {

        $uploadPath = '';
        if ($type == 'image') {
            $uploadPath = get_config('upload_path');
        } else {
            $uploadPath = get_config('upload_path_pdf');
        }


        $db = Database::getConnection();
        $sql = "SELECT '$type' FROM posts";
        $result = $db->query($sql);

        $dbFilenames = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $filename = basename($row[$type]);
                $dbFilenames[] = $filename;
            }
        } else {
            echo "No posts found in the database.";
            return;
        }

        $serverFiles = glob($uploadPath . '*');

        foreach ($serverFiles as $file) {
            if (is_file($file)) {
                $serverFilename = basename($file);
                if (!in_array($serverFilename, $dbFilenames)) {
                    error_log("--> File to be deleted: $file");
                    echo "--> File to be deleted: $file";
                    // if (unlink($file)) {
                    //     echo "Deleted: $file\n";
                    // } else {
                    //     echo "Failed to delete: $file\n";
                    // }
                }
            }
        }
        echo "Cleanup completed.";
    }

    public static function getTheImage($image)
    {
        $main_path = get_config('upload_path') . basename($image);
        $file_path = str_replace("..", "", $main_path);

        if (is_file($file_path)) {
            header("Content-Type:" . mime_content_type($file_path));
            header("Content-Length:" . filesize($file_path));
            header("Cache-Control: max-age=31536050");
            header_remove("Pragma");

            echo file_get_contents($file_path);
        } else {
            echo "$file_path";
        }
        header("HTTP/1.0 404 Not Found");
        echo "Image not found";
    }

    public static function getThePdf($pdf)
    {
        $main_path = get_config('upload_path_pdf') . basename($pdf);
        $file_path = str_replace("..", "", $main_path);
        $filePath = realpath($file_path);

        if (file_exists($filePath)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Content-Length: ' . filesize($filePath));

            ob_clean();
            flush();

            readfile($filePath);
            exit();
        } else {
            error_log("File not found!");
        }
    }

    public static function compressImage($source, $destination, $quality, $maxFileSize = 32000)
    {
        $info = getimagesize($source);
        $mime = $info['mime'];
        $image = null;

        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                break;
            default:
                throw new Exception('Unknown image type.');
        }
        imagejpeg($image, $destination, $quality);
        imagedestroy($image);

        $fileSize = filesize($destination);

        while ($fileSize > $maxFileSize && $quality > 10) {
            $quality -= 10;
            imagejpeg(imagecreatefromjpeg($source), $destination, $quality);
            $fileSize = filesize($destination);
        }

        return $destination;
    }
}
