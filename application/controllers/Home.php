<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Home extends RestController {

    public function index_get()
    {
        $this->response([
            'status' => RestController::HTTP_OK,
            'message' => 'OKE gaes'
        ], RestController::HTTP_OK);
    }

}