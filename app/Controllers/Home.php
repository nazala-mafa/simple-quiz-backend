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
        print "Simple Quiz";
    }
}
