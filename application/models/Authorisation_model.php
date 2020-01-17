<?php

class Authorisation_model extends CI_Model
{
  public function __construct()
  {
    $this->load->database();
  }

  public function get_authorisation($client_id, $username, $authorisation_code)
  {
    // If this is called by the controller during token generation, the controller has the client_id and authorisation_code only
    if ($authorisation_code) {
      $query = $this->db->get_where('authorisation', [
        'client_id' => $client_id,
        'authorisation_code' => $authorisation_code
      ]);
    } else { // This is called by controller during creating or updating authorisation, it has client_id and username
      $query = $this->db->get_where('authorisation', [
        'client_id' => $client_id,
        'username' => $username
      ]);
    }

    if ($query->num_rows() == 1) return $query->row_array();
    else return false;
  }

  public function update_authorisation($client_id, $username, $authorisation_code)
  {
    $this->db->where([
      'client_id' => $client_id,
      'username' => $username
    ]);

    $this->db->update('authorisation', ['authorisation_code' => $authorisation_code]);
  }

  public function create_authorisation($form_data)
  {
    $this->db->insert('authorisation', $form_data);
  }
}
