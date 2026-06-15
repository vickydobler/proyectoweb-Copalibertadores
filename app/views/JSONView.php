<?php

class JSONView {

    public function response($data, $status = 200) {
        header("Content-Type: application/json");
        http_response_code($status);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}