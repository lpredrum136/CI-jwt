<?php

require APPPATH . '/libraries/JWT.php';

class CreatorJwt
{
  private $key = '123456789abcdefghijklmnopqrstuvwxyz';

  // GENERATE TOKEN PRIVATE KEY
  public function generate_token($data)
  {
    $jwt = JWT::encode($data, $this->key);
    return $jwt;
  }

  // DECODE TOKEN TO EXTRACT DATA
  public function decode_token($token)
  {
    $decoded = JWT::decode($token, $this->key, array('HS256'));
    $decoded_data = (array) $decoded;
    return $decoded_data;
  }
}
