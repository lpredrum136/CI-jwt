<?php

class AppRegister extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    // Header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
  }

  public function register()
  {
    $form_data = json_decode(file_get_contents('php://input'));

    // Create app
    $form_data_to_send = [
      'appname' => $form_data->appname,
      'client_id' => random_string('unique'),
      'client_secret' => random_string('unique'),
      'scopes' => $form_data->scopes,
      'redirect_uri' => $form_data->redirect_uri
    ];

    // Get back app just registered
    $app_info = $this->app_model->register($form_data_to_send);

    // Return app info
    echo json_encode($app_info);
  }
}
