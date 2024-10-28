<?php
${basename(__FILE__, '.php')} = function () {
    if (isset($_POST['postId'])) {
        $post_id = $_POST['postId'];
        $p = new Post($post_id);
        $result = $p->setLikes('DECREMENT');

        if (!$result) {
            $this->response($this->json([
                'message' => "Something went Wrong ! When Post liked. Please Try Again"
            ]), 400);
        } else {
            $this->response($this->json([
                'message' => "Like Removed"
            ]), 200);
        }
    } else {
        $this->response($this->json([
            'message' => "Bad Request"
        ]), 400);
    }
};
