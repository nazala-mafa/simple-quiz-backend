<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Role implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = [])
    {
        helper('auth');
        $res = \Config\Services::response();
        if( !in_array(user()->group_name, $arguments) ) return $res->setJSON( ['message'=>lang('lang.error.message.no_auth')] )->setStatusCode( $res::HTTP_UNAUTHORIZED );
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
