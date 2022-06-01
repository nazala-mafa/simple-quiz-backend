<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

class Auth implements FilterInterface
{
    use ResponseTrait;
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('auth');
        $res = \Config\Services::response();
        // if( $request->getHeader('locale') ) $request->setLocale( $request->getHeader('locale')->getValue() );
        if( !user()->valid_login ) return $res->setJSON( ['message'=>lang('lang.error.message.no_auth')] )->setStatusCode( $res::HTTP_UNAUTHORIZED );
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}

