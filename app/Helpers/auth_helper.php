<?php

function user(): mixed {
  $req = \Config\Services::request();
  //cek
  if( !$req->header('Authorization') ) {
    echo json_encode([
      'code'  =>  401,
      'status' => 'HTTP_UNAUTHORIZED',
      'message' => 'Unauthorized Access'
    ]);
    die;
  }
  //get token
  $token = $req->header('Authorization')->getValue();
  $token = substr( $token , 8, strlen($token)-9 );
  //get token value
  $value = \Firebase\JWT\JWT::decode( $token, new \Firebase\JWT\Key( env('jwt_key'), 'HS256') );
  $value->valid_login  = true;
  return $value;
}

function in_group(array $group): bool {
  return in_array(user()->group_name, $group);
}