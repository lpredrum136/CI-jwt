<?php

class App_model extends CI_Model
{
  public function __construct()
  {
    $this->load->database();
  }

  // Register App
  public function register($form_data)
  {
    $this->db->insert('apps', $form_data);
    $app_id = $this->db->insert_id();
    $this->db->select('id, appname, client_id, client_secret, scopes, redirect_uri');
    $query = $this->db->get_where('apps', ['id' => $app_id]);
    return $query->row_array();
  }


  // Get app (to check if there is an app registered)
  public function get_app($form_data)
  {
    $query = $this->db->get_where('apps', [
      'client_id' => $form_data->client_id,
      'redirect_uri' => $form_data->redirect_uri,
      'scopes' => $form_data->scopes
    ]);

    if ($query->num_rows() == 1) return $query->row_array();
    else return false;
  }

  // Update app when authorisation code has been generated
  public function update_app($client_id, $authorisation_code)
  {
    $this->db->where('client_id', $client_id);
    $this->db->update('apps', ['authorisation_code' => $authorisation_code]);
  }

  // Get app (to check if there is an app registered)
  public function get_app_for_token_generation($form_data)
  {
    $query = $this->db->get_where('apps', [
      'client_id' => $form_data->client_id,
      'client_secret' => $form_data->client_secret,
      'authorisation_code' => $form_data->authorisation_code,
      'redirect_uri' => $form_data->redirect_uri,
      'scopes' => $form_data->scopes
    ]);

    if ($query->num_rows() == 1) return $query->row_array();
    else return false;
  }
}
