<?php
${basename(__FILE__, '.php')} = function () {
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['message'])) {

        $result = Session::sendEmail();

        if ($result) {
            $this->response($this->json([
                'message' => "Thank you for contacting us. We will get back to you soon.",
            ]), 200);
        } else {
            $this->response($this->json([
                'message' => "Failed. Please Try Again Later !"
            ]), 400);
        }
    } else {
        $this->response($this->json([
            'message' => "Bad Request"
        ]), 400);
    }
};
