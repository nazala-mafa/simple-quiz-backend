<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Question extends ResourceController
{
    protected $modelName = "App\Models\Quiz\Quiz_question_model";
    protected $format = 'json';
    use ResponseTrait;
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        helper('auth');
        if(!in_group(['admin', 'student'])) return $this->fail(['error', 'unauth']);

        if( $quiz_id = $this->request->getGet('quiz_id') ) {
            $data = $this->model->getUserExam($quiz_id, $this->request->getGet('user_id'), in_group(['admin']));
            return $this->respond( $data );
        }
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
        $input = $this->request->getJSON(true);
        $input['user_id'] = user()->id;
        if( $this->model->insert($input) ) {
            return $this->respondCreated( ['message' => lang('lang.question.created'), 'data' => ['question_id' => $this->model->insertID] ] );
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
            return $this->respondDeleted( ['message' => lang('lang.question.deleted')] );
        } else {
            return $this->respondDeleted( ['message' => lang('lang.question.error.deleted')] );
        }
    }
}
