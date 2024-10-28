<?php

${basename(__FILE__, '.php')} = function () {
    $requestData = json_decode(file_get_contents("php://input"), true);
    if (isset($requestData['admin_id'])) {
        $id = $requestData['admin_id'];
        $same_user = $requestData['same_user'];

        $result_of_del = Admin::deleteAdmin($id, $same_user);
        
        if ($result_of_del) {
            $this->response($this->json([
                'message' => "success"
            ]), 200);
        } else {
            $this->response($this->json([
                'message' => "An error occurred while deleting the admin. Please try again."
            ]), 400);
        }
    } else {
        $this->response($this->json([
            'message' => "Bad Request"
        ]), 419);
    }
};
