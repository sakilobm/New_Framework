<?php
${basename(__FILE__, '.php')} = function () {
    $result = Post::countAllPosts();
    if ($result) {
        $this->response($this->json([
            'message' => "Posts retrieved successfully",
            'counts' => $result 
        ]), 200);
    } else {
        $this->response($this->json([
            'message' => "No more posts available."
        ]), 400);
    }
};
