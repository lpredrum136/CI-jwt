<?php
require APPPATH . '/libraries/CreatorJwt.php';

class VerifyToken {
  public function __construct()
  {
    $this->obj_jwt = new CreatorJwt();
  }

  public function verify_token($token) {
    try {
      $jwt_data = $this->obj_jwt->decode_token($token);

      return $jwt_data;
    } catch (Exception $exception) {
      return false;
    }
  }
}