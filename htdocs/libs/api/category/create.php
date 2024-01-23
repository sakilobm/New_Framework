<?php
${basename(__FILE__, '.php')} = function () {
    if (isset($_POST['category'])) {
        $text = $_POST['category'];
        $result = Category::createCategry(strtolower($text));
        if (!$result) {
            $this->response($this->json([
                'message' => "Something went Wrong ! When Create Category. Please Try Again"
            ]), 400);
        } else {
            $this->response($this->json([
                'message' => "New Category Added"
            ]), 200);
        }
    } else {
        $this->response($this->json([
            'message' => "Bad Request"
        ]), 419);
    }
};
