<?php
${basename(__FILE__, '.php')} = function () {
    if (isset($_POST['id'])) {
        $post_id = $_POST['id'];

        $updatePost = Post::toggleDraft($post_id);

        if ($updatePost) {
            $this->response($this->json([
                'message' => "Post Has Been Published"
            ]), 200);
        } else {
            $this->response($this->json([
                'message' => "Failed. Please Try Again Later"
            ]), 500);
        }
    } else {
        $this->response($this->json([
            'message' => "Bad Request"
        ]), 400);
    }
};
