<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Answer extends ResourceController
{
    protected $modelName = "App\Models\Quiz\Quiz_answer_model";
    use ResponseTrait;
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        return $this->respond( $this->model->where('question_id', $this->request->getVar('question_id'))->findAll() );
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
        if( $this->model->insertBatch( $this->request->getJSON(1) ) ) {
            return $this->respondCreated( [ 'message' => lang('lang.answer.created'), 'data' => ['answers_id'=>$this->model->insertID] ] );
        } else {
            return $this->fail( $this->model->errors() );
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
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        if( $this->model->delete($id) ) {
            return $this->respondDeleted( ['message' => lang('lang.answer.deleted')] );
        } else {
            return $this->respondDeleted( ['message' => lang('lang.answer.error.deleted')] );
        }
    }
}
