<?php
${basename(__FILE__, '.php')} = function () {
    if (isset($_POST['title']) and isset($_POST['content']) and isset($_POST['category'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $category = $_POST['category'];
        $post_type = $_POST['post_type'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $img_tmp_folder = $_FILES['image']['tmp_name'];
            $maxFileSize = 8 * 1024 * 1024; // 8MB
            if ($_FILES['image']['size'] <= $maxFileSize) {
            } else {
                $this->response($this->json([
                    'message' => "Image Size Should Be Under 8MB"
                ]), 500);
            }
        }
        // Use the Post class to register the new post
        $newPost = Post::registerPost($title, $post_type, $content, $category, $img_tmp_folder);
        if ($newPost) {
            // Post was created successfully
            $this->response($this->json([
                'message' => "New Post Added"
            ]), 200);
        } else {
            // Failed to create a new post
            $this->response($this->json([
                'message' => "Something went wrong when creating the post. Please try again."
            ]), 500);
        }
    } else {
        $this->response($this->json([
            'message' => "Bad Request"
        ]), 400);
    }
};
