<?php

class Posts extends CI_Controller
{

  # GET ALL POSTS
  public function index()
  {
    // Header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    $data = $this->post_model->read();

    // Get row count, if there is data
    if ($data) {
      $result['data'] = $data;
      // Turn to JSON and output
      echo json_encode($result);
    } else echo json_encode(['message' => 'No Posts Found']);
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
    // Header
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    /* $form_data = [
      'title' => $this->input->post('title'),
      'body' => $this->input->post('body'),
      'author' => $this->input->post('author'),
      'category_id' => $this->input->post('category_id')
    ]; */
    // Above not work: https://www.toptal.com/php/10-most-common-mistakes-php-programmers-make

    $form_data = json_decode(file_get_contents('php://input'));
    $new_post = $this->post_model->create_post($form_data);
    echo json_encode($new_post);
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
