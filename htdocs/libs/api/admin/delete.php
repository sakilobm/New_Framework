<?php

${basename(__FILE__, '.php')} = function () {
    $requestData = json_decode(file_get_contents("php://input"), true);
    if (isset($requestData['admin_id'])) {
        $id = $requestData['admin_id'];
        $result_of_del = Session::deleteAdmin($id);
        if ($result_of_del) {
            $this->response($this->json([
                'message' => "success"
            ]), 200);
        } else {
            $this->response($this->json([
                'message' => "An error occurred while deleting the admin. Please try again. If the issue persists, please contact support for assistance."
            ]), 400);
        }
    } else {
        $this->response($this->json([
            'message' => "Bad Request"
        ]), 419);
    }
};
