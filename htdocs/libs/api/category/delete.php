<?php

${basename(__FILE__, '.php')} = function () {
    $requestData = json_decode(file_get_contents("php://input"), true);
    if (isset($requestData['id'])) {
        $id = $requestData['id'];

        $result_of_del = Category::deleteCategory($id);
        if ($result_of_del) {
            $this->response($this->json([
                'message' => "Category has been deleted successfully."
            ]), 200);
        } else {
            $this->response($this->json([
                'message' => "Something went wrong when deleting the category. Please try again."
            ]), 400);
        }
    } else {
        $this->response($this->json([
            'message' => "bad request"
        ]), 417);
    }
};
