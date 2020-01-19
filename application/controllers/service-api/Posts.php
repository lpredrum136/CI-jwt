<?php

require APPPATH .  '/controllers/service-api/utils/verify_token.php';

class Posts extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->obj_verify_token = new VerifyToken();

    // Header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With, Authorisation');
  }

  # GET ALL POSTS
  public function index()
  {
    // See if token in header
    $headers = $this->input->request_headers();
    if (!isset($headers['Authorization'])) {
      //http_response_code(401); // Unable to succeed with this line on, so we have to return an error with status code 200 :(
      echo json_encode([
        'status' => false,
        'message' => 'No token, authorisation denied'
      ]);
    } else {
      $token = str_replace('Bearer ', '', $headers['Authorization']);
      $jwt_data = $this->obj_verify_token->verify_token($token);

      // there is jwt_data and in the decoded data, there is 'read'
      if ($jwt_data && strpos($jwt_data['scopes'], 'read') !== false) {
        $data = $this->post_model->read();

        // Get row count, if there is data
        if ($data) {
          $result['data'] = $data;
          // Turn to JSON and output
          echo json_encode($result);
        } else echo json_encode(['message' => 'No Posts Found']);
      } else {
        http_response_code(401);
        echo json_encode([
          'status' => false,
          'message' => 'Invalid token. Authorisation denied'
        ]);
      }
    }
  }

  # GET ONE POST BY ID
  public function view($id = NULL)
  {
    // Header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    $data = $this->post_model->get_post($id);

    if ($data) {
      $result['data'] = $data;
      echo json_encode($result);
    } else echo json_encode(['message' => 'No Single Post Found']);
  }

  # CREATE POST
  public function create()
  {

    /* $form_data = [
      'title' => $this->input->post('title'),
      'body' => $this->input->post('body'),
      'author' => $this->input->post('author'),
      'category_id' => $this->input->post('category_id')
    ]; */
    // Above not work: https://www.toptal.com/php/10-most-common-mistakes-php-programmers-make

    // See if token in header
    $headers = $this->input->request_headers();
    if (!isset($headers['Authorization'])) {
      //http_response_code(401); // Unable to succeed with this line on, so we have to return an error with status code 200 :(
      echo json_encode([
        'status' => false,
        'message' => 'No token, authorisation denied'
      ]);
    } else {
      $token = str_replace('Bearer ', '', $headers['Authorization']);
      $jwt_data = $this->obj_verify_token->verify_token($token);

      // there is jwt_data and in the decoded data, there is 'create'
      if ($jwt_data && strpos($jwt_data['scopes'], 'create') !== false) {
        $form_data = json_decode(file_get_contents('php://input'));
        $form_data->author = $jwt_data['username'];// Add author, since we can only get the author from the decoded jwt
        
        $new_post = $this->post_model->create_post($form_data);
        echo json_encode($new_post);
      } else {
        http_response_code(401);
        echo json_encode([
          'status' => false,
          'message' => 'Invalid token. Authorisation denied'
        ]);
      }
    }
  }

  # EDIT POST
  public function edit($id)
  {
    // Header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    $form_data = json_decode(file_get_contents('php://input'));
    $this->post_model->update_post($id, $form_data);
    echo json_encode(['message' => 'Post updated']);
  }

  # DELETE POST
  public function delete($id)
  {
    // Header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    $this->post_model->delete_post($id);
    echo json_encode(['message' => 'Post deleted']);
  }
}
