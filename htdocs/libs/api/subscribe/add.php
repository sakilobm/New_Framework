<?php
${basename(__FILE__, '.php')} = function () {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        $newSub = Subscribe::add($email);

        if ($newSub) {
            $this->response($this->json([
                'message' => "Thank you for subscribing!"
            ]), 200);
        } else {
            $this->response($this->json([
                'message' => "Failed. Please Try Again Later !"
            ]), 500);
        }
    } else {
        $this->response($this->json([
            'message' => "Bad Request"
        ]), 400);
    }
};
