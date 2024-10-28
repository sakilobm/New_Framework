<?php
${basename(__FILE__, '.php')} = function () {
    if (isset($_POST['id'])) {
        $result = Post::deletePdf($_POST['id']);
        if ($result) {
            $this->response($this->json([
                'message' => "Post's Pdf Has Been Removed"
            ]), 200);
        } else {
            $this->response($this->json([
                'message' => "Please Try Again Later !"
            ]), 400);
        }
    } else {
        $this->response($this->json([
            'message' => "Bad Request"
        ]), 400);
    }
};
