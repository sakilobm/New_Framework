<?php

${basename(__FILE__, '.php')} = function () {
    if ($this->paramsExists(['email', 'password'])) {
        $user = $this->_request['email'];
        $password = $this->_request['password'];
        $fp = isset($_COOKIE['fingerprint']) ? $_COOKIE['fingerprint'] : null;
        $token = UserSession::authenticate($user, $password, $fp);
        if ($token) {
            $this->response($this->json([
                'message' => 'Authenticated',
                'token' => $token
            ]), 200);
        } else {
            $this->response($this->json([
                'message' => 'Unauthorized',
                'token' => $token
            ]), 401);
        }
    } else {
        $this->response($this->json([
            'message' => "bad request"
        ]), 400);
    }
};
