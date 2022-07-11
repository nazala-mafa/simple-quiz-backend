<?php

namespace CodeIgniter;

use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use \CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\URI;

class TestQuestion extends CIUnitTestCase
{
    use ControllerTestTrait, DatabaseTestTrait;

    public function testIndex() 
    {
        $result = $this->withURI( site_url('/quiz/question') )
                       ->controller(\App\Controllers\Question::class)
                       ->execute('index');

        $this->assertTrue($result->isOK());
    }

    public function testCreate()
    {
        $req = new IncomingRequest(new \Config\App(), new URI('http://localhost/quiz/question'));
        $body = json_encode([
            "category_id" => "1",
            "question" => "1+1=?",
            "true_answer" => 2,
            "false_answer" => [1,3,4]
        ]);
        $res = $this->withRequest($req)
                    ->withBody($body)
                    ->controller(\App\Controllers\Question::class)
                    ->execute('create');
        $this->assertTrue($res->isOK());
    }
}