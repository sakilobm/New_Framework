<?php
${basename(__FILE__, '.php')} = function () {
    if (isset($_POST['title']) and isset($_POST['content']) and isset($_POST['category'])) {
        $title = $_POST['title'];
        $sanitized_title = Post::sanitizedTitle($title);
        $subtitle = $_POST['subtitle'];
        $draft = isset($_POST['draft']);
        $content = $_POST['content'];
        $spec_content = htmlspecialchars($content);
        $category = $_POST['category'];

        $newPost = Post::registerPost($sanitized_title, $subtitle, $spec_content, $category,$draft);

        if ($newPost['status'] == 'success') {
            $this->response($this->json([
                'message' => $newPost['message']
            ]), 200);
        } else {
            $this->response($this->json([
                'message' => $newPost['message']
            ]), 500);
        }
    } else {
        $this->response($this->json([
            'message' => "Bad Request"
        ]), 400);
    }
};
