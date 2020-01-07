<?php

require APPPATH . '/libraries/CreatorJwt.php';

class Users extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->obj_jwt = new CreatorJwt();
    header('Content-Type: application/json');
  }

  # GENERATE TOKEN
  public function create_token()
  {
    $token_data = [
      'id' => '5',
      'name' => 'Henry',
      'privilege' => 'admin'
    ];

    $jwt_token = $this->obj_jwt->generate_token($token_data);

    echo json_encode(['token' => $jwt_token]);
  }

  # GET DATA FROM TOKEN
  public function check_token()
  {
    $received_token = $this->input->request_headers();
    try {
      $jwt_data = $this->obj_jwt->decode_token($received_token['Authorization']);
      echo json_encode($jwt_data);
    } catch (Exception $exception) {
      http_response_code('401');
      echo json_encode([
        'status' => false,
        'message' => $exception->getMessage()
      ]);
      exit;
    }
  }
}
