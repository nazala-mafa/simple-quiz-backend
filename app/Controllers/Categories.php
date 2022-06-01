<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Categories extends ResourceController
{
    protected $modelName = "App\Models\Quiz\Quiz_category_model";
    use ResponseTrait;
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $categories = $this->model->findAll();
        return $this->respond( $categories );
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        helper('auth');
        user();
        $res = $this->model->insert([
            'name'  => $this->request->getJsonVar('name'),
            'description'  => $this->request->getJsonVar('description'),
        ]);
        if( $res ) {
            return $this->respondCreated( ['message'=>lang('lang.category.created')] );
        } else {
            return $this->failValidationErrors( $this->model->errors() );
        }
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        helper('auth');
        if( !in_group(['admin']) ) 
            return $this->failUnauthorized( lang('lang.auth.error.message.no_auth') );
        if( $this->model->update($id, $this->request->getJSON(true)) ) {
            return $this->respondCreated( ['message'=>lang('lang.category.updated')] );
        } else {
            return $this->failValidationErrors( $this->model->errors() );
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        helper('auth');
        if( !in_group(['admin']) ) 
            return $this->failUnauthorized( lang('lang.auth.error.message.no_auth') );
        if( $res = $this->model->delete($id) )
            return $this->respondDeleted( ['message' => lang('lang.category.deleted')] );
    }
}
