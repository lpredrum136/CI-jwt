<?php

require APPPATH . '/libraries/CreatorJwt.php';

class Auth extends CI_Controller
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

  public function login()
  {
    $form_data = json_decode(file_get_contents('php://input'));

    // Encrypted password to check with db
    $enc_password = md5($form_data->password);

    // Get user
    $user_info = $this->user_model->login([
      'username' => $form_data->username,
      'password' => $enc_password
    ]);

    if ($user_info) {
      // Create JWT token
      $user_token = $this->obj_jwt->generate_token(['user_id' => $user_info['id']]);
      echo json_encode(['token' => $user_token]);
    } else {
      http_response_code(400);
      echo json_encode([
        'status' => false,
        'message' => 'User not found'
      ]);
    }
  }

  public function authenticate()
  {
    $headers = $this->input->request_headers();

    // If there is no token attached to headers
    if (!isset($headers['x-auth-token'])) {
      http_response_code('401');
      echo json_encode([
        'status' => false,
        'message' => 'No token, authorisation denied'
      ]);
    } else {
      try {
        $jwt_data = $this->obj_jwt->decode_token($headers['x-auth-token']);

        $user_info = $this->user_model->find_user_by_id($jwt_data['user_id']);
        echo json_encode($user_info);
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
}
