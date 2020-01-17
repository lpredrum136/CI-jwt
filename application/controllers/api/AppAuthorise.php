<?php

require APPPATH . '/libraries/CreatorJwt.php';

class AppAuthorise extends CI_Controller
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

  public function authorise()
  {
    $form_data = json_decode(file_get_contents('php://input'));

    // Check db for client_id and redirect_uri
    $app_info = $this->app_model->get_app($form_data);

    if ($app_info) echo json_encode($app_info);
    else {
      http_response_code(400);
      echo json_encode([
        'status' => false,
        'message' => 'Unauthorised application'
      ]);
    }
  }

  public function generate_authorisation_code()
  {
    $form_data = json_decode(file_get_contents('php://input'));

    $app_info = $this->app_model->get_app($form_data);

    // If the app exists, fill in the table of "authorisation" under the form "auth code - username - client id".
    // This is not a good practice but just for testing.
    // Which should be done is auth code should be tied to user and client. So that you don't have to look up db when receiving back
    // the auth code, you can just decode.
    if ($app_info) {
      $authorisation_code = random_string('unique');

      // If already have the authorisation between user and client, update it. Otherwise, create a new record
      $authorisation = $this->authorisation_model->get_authorisation($form_data->client_id, $form_data->username, false);
      if ($authorisation) {
        $this->authorisation_model->update_authorisation(
          $form_data->client_id, 
          $form_data->username, 
          $authorisation_code
        );
      } else {
        $this->authorisation_model->create_authorisation([
          'client_id' => $form_data->client_id,
          'username' => $form_data->username,
          'authorisation_code' => $authorisation_code
        ]);
      }
      
      $this->app_model->update_app($form_data->client_id, $authorisation_code);
      echo json_encode(['authorisation_code' => $authorisation_code]);

    } else {      
      http_response_code(400);
      echo json_encode([
        'status' => false,
        'message' => 'Unauthorised application'
      ]);      
    } 
  }

  public function generate_token()
  {
    $form_data = json_decode(file_get_contents('php://input'));

    // Check with db (2) to see if there is an app
    $app_info = $this->app_model->get_app_for_token_generation($form_data);
    $authorisation_info = $this->authorisation_model->get_authorisation($form_data->client_id, false, $form_data->authorisation_code);

    if ($app_info && $authorisation_info) {
      // Create token
      $access_token = $this->obj_jwt->generate_token([
        'client_id' => $app_info['client_id'],
        'scopes' => $app_info['scopes'],
        'username' => $authorisation_info['username']
      ]);

      $id_token = $this->obj_jwt->generate_token([
        'username' => $authorisation_info['username']
      ]);

      $token = [
        'token_type' => 'Bearer',
        'scope' => $app_info['scopes'],
        'access_token' => $access_token,
        'id_token' => $id_token
      ];
      
      echo json_encode(['token' => $token]);
    } else {      
      http_response_code(400);
      echo json_encode([
        'status' => false,
        'message' => 'Unauthorised. Cannot generate token'
      ]);      
    }
  }
}
