<?php
include 'libs/load.php';
try {
    if (isset($_GET['name'])) {
        $fname = $_GET['name'];
        $upload_path = get_config('upload_path');
        $image_path = $upload_path . $fname;
        $image_path = str_replace("..", "", $image_path);
        //TODO: Lot of security things to think about here
        if (is_file($image_path)) {
            header("Content-Type:" . mime_content_type($image_path));
            header("Content-Length:" . filesize($image_path));
            header("Cache-Control: max-age=31536050");
            header_remove("Pragma");
            echo file_get_contents($image_path);
        } else {
            echo "$image_path";
        }
    }
} catch (Exception $e) {
    throw new Exception("Trying To Show IMAGE " . $e);
}
