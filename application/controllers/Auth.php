<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Auth extends RestController
{

  public function __construct()
  {
    parent::__construct();
    header('Content-Type: application/json');
    $this->load->model('MAuth', 'auth');
  }

  public function index_get()
  {
    $this->response([
      'status' => RestController::HTTP_UNAUTHORIZED,
      'message' => 'Unauthorized'
    ], RestController::HTTP_UNAUTHORIZED);
  }


  /** Login */
  public function index_post()
  {
    $username = trim($this->post('username'));
    $password = trim($this->post('password'));

    if ($this->post() == null) {
      $this->response([
        'status' => RestController::HTTP_BAD_REQUEST,
        'message' => 'Request null'
      ], RestController::HTTP_BAD_REQUEST);
    } else {
      if ($username == null || $password == null) {
        $this->response([
          'status' => RestController::HTTP_BAD_REQUEST,
          'message' => 'Username or Password required'
        ], RestController::HTTP_BAD_REQUEST);
      } else {
        $get = $this->auth->getByLogin($username, $password);
        if (!empty($get)) {
          $this->response([
            'status' => RestController::HTTP_OK,
            'message' => 'name of request',
            'data' => $get
          ], RestController::HTTP_OK);
        } else {
          $this->response([
            'status' => RestController::HTTP_BAD_REQUEST,
            'message' => 'User not found'
          ], RestController::HTTP_BAD_REQUEST);
        }
      }
    }
  }

  public function register_post()
  {
    $password = trim($this->post('password'));
    $confirmPassword = trim($this->post('confirm_password'));


    if ($this->post() == null) {
      $this->response([
        'status' => RestController::HTTP_BAD_REQUEST,
        'message' => 'Request null'
      ], RestController::HTTP_BAD_REQUEST);
    } else {

      if ($this->post('username') == null || $this->post('password') == null) {
        $this->response([
          'status' => RestController::HTTP_BAD_REQUEST,
          'message' => 'Request required'
        ], RestController::HTTP_BAD_REQUEST);
      } else {
        if ($password !== $confirmPassword)
          $this->response([
            'status' => RestController::HTTP_BAD_REQUEST,
            'message' => 'Password not match'
          ], RestController::HTTP_BAD_REQUEST);
      }

      if($this->auth->registration($this->post())) {
        $this->response([
          'status' => RestController::HTTP_OK,
          'message' => 'Registration Succesfully',
        ], RestController::HTTP_OK);
      } else {
        $this->response([
          'status' => RestController::HTTP_BAD_REQUEST,
          'message' => 'Registration Failed',
        ], RestController::HTTP_BAD_REQUEST);
      }
      
    }
  }

  public function logout_post()
  {
  }
}
