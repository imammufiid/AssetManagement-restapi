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
    myResponse(RestController::HTTP_OK, "asdfasdf123");
  }


  /** Login */
  public function index_post()
  {
    $postData = $this->security->xss_clean($this->post());
    $username = trim($postData['username']);
    $password = trim($postData['password']);


    if ($postData == null) {
      myResponse(HTTP_BAD_REQUEST, "Request null");
    } else {
      if ($username == null || $password == null) {
        myResponse(HTTP_BAD_REQUEST, "Username or Password required");
      } else {
        $get = $this->auth->getByLogin($username, $password);
        
        if ($get['status']) {
          myResponse(HTTP_OK, "Successfully", $get);
        } else {
          myResponse(HTTP_BAD_REQUEST, $get['message']);
        }
      }
    }
  }

  /**
   * Registration
   *
   * @return void
   */
  public function register_post()
  {
    $postData = $this->security->xss_clean($this->post());

    $this->form_validation->set_rules(
      'username',
      'Username',
      'trim|required|is_unique[t_users.username]',
      [
        'required' => 'Username harus diisi',
        'is_unique' => 'Username sudah digunakan'
      ]
    );
    $this->form_validation->set_rules(
      'email',
      'Email',
      'trim|required|is_unique[t_users.email]',
      [
        'required'      => 'Email harus diisi',
        'is_unique'     => 'Email sudah digunakan'
      ]
    );
    $this->form_validation->set_rules(
      'password',
      'Password',
      'trim|required',
      ['required' => 'Password harus diisi']
    );
    $this->form_validation->set_rules(
      'confirm_password',
      'Password Confirmation',
      'trim|required|matches[password]',
      [
        'required'      => 'Password Konfirmasi harus diisi',
        'matches'     => 'Password anda tidak sama'
      ]
    );

    if ($this->form_validation->run() == FALSE) {
      $error = $this->form_validation->error_array();
      myResponse(HTTP_BAD_REQUEST, "Request Validation Error", $error);
    } else {
      if ($this->auth->registration($postData)) {
        myResponse(HTTP_CREATED, "Registration Successfully");
      } else {
        myResponse(HTTP_BAD_REQUEST, "Registration Failed");
      }
    }
  }

  public function logout_post()
  {
  }
}
