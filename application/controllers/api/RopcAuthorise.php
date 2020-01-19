<?php

require APPPATH . '/libraries/CreatorJwt.php';

class RopcAuthorise extends CI_Controller {
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

  public function generate_token()
  {
    $form_data = json_decode(file_get_contents('php://input'));

    // Encrypted user password to check with db
    $enc_password = md5($form_data->password);

    // Check with db (2) to see if all info is correct
    # Get user
    $user_info = $this->user_model->login([
      'username' => $form_data->username,
      'password' => $enc_password
    ]);

    # Get app
    $app_info = $this->app_model->get_app_for_token_generation($form_data);

    // If everything is ok, generate token
    if ($user_info && $app_info) {
      // Create token
      $access_token = $this->obj_jwt->generate_token([
        'client_id' => $app_info['client_id'],
        'scopes' => $app_info['scopes'],
        'username' => $user_info['username'],
        'privilege' => $user_info['privilege']
      ]);

      $id_token = $this->obj_jwt->generate_token([
        'username' => $user_info['username']
      ]);

      $token = [
        'token_type' => 'Bearer',
        'scope' => $app_info['scopes'],
        'access_token' => $access_token,
        'id_token' => $id_token
      ];
      
      echo json_encode(['token' => $token]);
    }
    else {      
      http_response_code(400);
      echo json_encode([
        'status' => false,
        'message' => 'Unauthorised. Cannot generate token. Check your credentials.'
      ]);      
    }
  }
}