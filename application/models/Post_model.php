<?php

class Post_model extends CI_Model
{
  public function __construct()
  {
    $this->load->database();
  }

  // Get all posts
  public function read()
  {
    $this->db->order_by('posts.id', 'DESC');
    $this->db->select('posts.id, category_id, title, body, author, posts.created_at, name');
    $this->db->join('categories', 'categories.id = posts.category_id');
    $query = $this->db->get('posts');
    return $query->result_array();
  }

  // Get one post by id
  public function get_post($id)
  {
    $this->db->select('posts.id, category_id, title, body, author, posts.created_at, categories.id AS base_category_id, name');
    $this->db->join('categories', 'categories.id = posts.category_id');
    $query = $this->db->get_where('posts', ['posts.id' => $id]);
    return $query->row_array();
  }

  // Create post
  public function create_post($form_data)
  {
    $this->db->insert('posts', $form_data);
    $post_id = $this->db->insert_id();
    $query = $this->db->get_where('posts', ['id' => $post_id]);
    return $query->row_array();
  }

  // Update post
  public function update_post($id, $form_data)
  {
    $this->db->where('id', $id);
    return $this->db->update('posts', $form_data);
  }

  // Delete post
  public function delete_post($id)
  {
    $this->db->where('id', $id);
    return $this->db->delete('posts');
  }
}
