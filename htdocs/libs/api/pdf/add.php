<?php
${basename(__FILE__, '.php')} = function () {
    if (isset($_POST['id'])) {
        $post_id = $_POST['id'];
        $pdf_tmp_folder = null;
        $filename = $_FILES['file']['name'];

        if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
            error_log(".....PDF Is Existed...." . $_FILES['pdf']['error']);
            $pdf_tmp_folder = $_FILES['pdf']['tmp_name'];
        }else {
            $errorCode = $_FILES['file']['error'];
            $this->response($this->json([
                'message' => "Failed to upload file: $filename. Error code: $errorCode"
            ]), 400);
        }
        error_log(".....PDF Is Not Existed...." . $_FILES['pdf']['error']);

        $error = Post::sendPdf($post_id, $pdf_tmp_folder);
        if ($error) {
            $this->response($this->json([
                'message' => "Post Has Been Updated"
            ]), 200);
        } else {
            $this->response($this->json([
                'message' => "Error When Try To Update Post. Please Try Again!"
            ]), 400);
        }
    } else {
        $this->response($this->json([
            'message' => "Bad Request"
        ]), 400);
    }
};
