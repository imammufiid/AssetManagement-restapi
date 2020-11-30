<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

use const chriskacerguis\RestServer\HTTP_BAD_REQUEST;
use const chriskacerguis\RestServer\HTTP_CREATED;
use const chriskacerguis\RestServer\HTTP_OK;

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
    // echo "asdfasd";die;
    successResponse(RestController::HTTP_OK, "asdfasdf123");
  }


  /** Login */
  public function index_post()
  {
    $username = trim($this->post('username'));
    $password = trim($this->post('password'));

    if ($this->post() == null) {
      successResponse(HTTP_BAD_REQUEST, "Request null");
    } else {
      if ($username == null || $password == null) {
        successResponse(HTTP_BAD_REQUEST, "Username or Password required");
      } else {
        $get = $this->auth->getByLogin($username, $password);
        if (!empty($get)) {
          successResponse(HTTP_OK, "Successfully", $get);
        } else {
          successResponse(HTTP_BAD_REQUEST, "User not found!");
        }
      }
    }
  }

  public function register_post()
  {
    $password = trim($this->post('password'));
    $confirmPassword = trim($this->post('confirm_password'));

    if ($this->post() == null) {
      successResponse(HTTP_BAD_REQUEST, "Request NULL");
    } else {

      if ($this->post('username') == null || $this->post('password') == null) {
        successResponse(HTTP_BAD_REQUEST, "Request Required");
      } else {
        if ($password !== $confirmPassword)
        successResponse(HTTP_BAD_REQUEST, "Password Not Match!");
      }

      if ($this->auth->registration($this->post())) {
        successResponse(HTTP_CREATED, "Registration Successfully");
      } else {
        successResponse(HTTP_BAD_REQUEST, "Registration Failed");
      }
    }
  }

  public function logout_post()
  {
  }

}
