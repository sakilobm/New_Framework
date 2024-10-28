<?php
${basename(__FILE__, '.php')} = function () {
    // api/get/card.php
    if (isset($_POST['offset'])) {
        $offset = (int) $_POST['offset'];
        $result = Post::getPostsWithOffset($offset);
        if ($result) {
            $this->response($this->json([
                'message' => "Posts retrieved successfully",
                'posts' => $result
            ]), 200);
        } else {
            $this->response($this->json([
                'message' => "No more posts available."
            ]), 400);
        }
    } else {
        $this->response($this->json([
            'message' => "Bad Request"
        ]), 400);
    }
};
