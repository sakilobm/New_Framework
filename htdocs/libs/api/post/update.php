<?php
${basename(__FILE__, '.php')} = function () {
    if (isset($_POST['id']) and isset($_POST['title']) and isset($_POST['content']) and isset($_POST['category'])) {
        $post_id = $_POST['id'];
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];
        $draft = isset($_POST['draft']);
        $category = $_POST['category'];
        $content = $_POST['content'];

        $updatePost = Post::updatePost($post_id, $title, $content, $category, $subtitle,$draft);

        if ($updatePost['status'] == 'success') {
            $this->response($this->json([
                'message' => $updatePost['message']
            ]), 200);
        } else {
            $this->response($this->json([
                'message' => $updatePost['message']
            ]), 500);
        }
    } else {
        $this->response($this->json([
            'message' => "Bad Request"
        ]), 400);
    }
};
