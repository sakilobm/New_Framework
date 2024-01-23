<?php
${basename(__FILE__, '.php')} = function () {
    if (isset($_POST['id']) and isset($_POST['title']) and isset($_POST['content']) and isset($_POST['category'])) {
        $post_id = $_POST['id'];
        $title = $_POST['title'];
        $category = $_POST['category'];
        $content = $_POST['content'];

        if (isset($_FILES['image']) and $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $maxFileSize = 8 * 1024 * 1024; // 8MB
            if ($_FILES['image']['size'] <= $maxFileSize) {
                $img_tmp_folder = $_FILES['image']['tmp_name'];
                $img_folder = 'uploaded_img';
                if (!file_exists($img_folder)) {
                    mkdir($img_folder, 0750, true);
                    chmod($img_folder, 0750);
                } else {
                    error_log("No file uploaded.");
                    $this->response($this->json([
                        'message' => "Image Upload Failed"
                    ]), 424);
                }
            } else {
                $this->response($this->json([
                    'message' => "Image size exceeds the maximum allowed (8MB)."
                ]), 400);
            }
        }
        $error = Post::updatePost($post_id, $title, $content, $category, $img_tmp_folder);
        if (isset($error['success']) && $error['success']) {
            $this->response($this->json(['message' => 'Post Has Been Updated']), 200);
        } else {
            $this->response($this->json(['message' => $error['message']]), 500);
        }
    } else {
        $this->response($this->json([
            'message' => "Bad Request"
        ]), 400);
    }
};
