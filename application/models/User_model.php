<?php

class User_model extends CI_Model
{
  public function __construct()
  {
    $this->load->database();
  }

  // Register
  public function register($form_data)
  {
    $this->db->insert('users', $form_data);
    $user_id = $this->db->insert_id();
    $this->db->select('id, username, privilege');
    $query = $this->db->get_where('users', ['id' => $user_id]);
    return $query->row_array();
  }

  // Login
  public function login($form_data)
  {
    $this->db->select('id, username, privilege');
    $query = $this->db->get_where('users', $form_data);
    if ($query->num_rows() == 1) return $query->row_array();
    else return false;
  }

  // Find user by id
  public function find_user_by_id($id)
  {
    $this->db->select('id, username, privilege');
    $query = $this->db->get_where('users', ['id' => $id]);
    if ($query->num_rows() == 1) return $query->row_array();
    else return false;
  }
}
