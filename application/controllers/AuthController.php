<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class AuthController extends RestController
{

  public function __construct()
  {
    parent::__construct();
  }

  public function index_get()
  {
    $this->response([
      'status' => RestController::HTTP_UNAUTHORIZED,
      'message' => 'Unauthorized'
    ], RestController::HTTP_UNAUTHORIZED);
  }

  public function index_post()
  {
    $username = $this->post('username');
    $password = $this->post('password');
  }
}
