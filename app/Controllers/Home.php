<?php

namespace App\Controllers;

use App\Models\User_answers_model;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Home extends ResourceController
{
    use ResponseTrait;
    protected $format    = 'json';

    public function index()
    {
        // $answerModel = new User_answers_model();
        // dd( $answerModel->calculateScore(3, 1) );
    }

    function coba2()
    {
        $key = env('jwt_key');
        $payload = [
            'aku'   => "nazala"
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');
        echo $jwt;
        echo "<br>";
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        print_r($decoded);
    }
}
