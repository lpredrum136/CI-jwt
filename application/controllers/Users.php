<?php

require APPPATH . '/libraries/CreatorJwt.php';

class Users extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->obj_jwt = new CreatorJwt();

    // Header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
  }

  // REGISTER USER
  public function register()
  {
    $form_data = json_decode(file_get_contents('php://input'));

    // Encrypt password
    $enc_password = md5($form_data->password);

    // Create user
    $form_data_to_send = [
      'username' => $form_data->username,
      'password' => $enc_password,
      'privilege' => $form_data->privilege
    ];

    // Get back user just created
    $user_info = $this->user_model->register($form_data_to_send);

    // Create JWT token
    $user_token = $this->obj_jwt->generate_token(['user_id' => $user_info['id']]);

    echo json_encode(['token' => $user_token]);
  }
}
