<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Quiz extends ResourceController
{
    use ResponseTrait;
    protected $modelName = 'App\Models\Quiz\Quiz_model';
    public function __construct() {
        helper('auth');
    }
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        if( $cat = $this->request->getGet('cat') ) 
            return $this->respond( $this->model->where('quiz_category_id', $cat)->findAll() );
        if( $id = $this->request->getGet('id') ) 
            return $this->respond( $this->model->find($id) );
            
        return $this->respond( $this->model->findAll() );
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $quiz = $this->model->find($id);
        $questions = model('App\Models\Quiz\Quiz_question_model')->where('quiz_id', $id)->get()->getResult();
        return $this->respond([
            'quiz' => $quiz,
            'questions' => $questions
        ]);
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
        $user = user();
        $input = $this->request->getJSON(true);
        $input['user_id'] = $user->id;
        $res = $this->model->insert( $input );
        if( $res ) {
            return $this->respondCreated( ['message' => lang('lang.quiz.created')] );
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
        $json = $this->request->getJSON();
        $res = $this->model->save([
            'id' => $json->id,
            'quiz_category_id' => $json->quiz_category_id,
            'title' => $json->title,
            'is_active' => $json->is_active,
            'option_data' => $json->option_data
        ]);
        if( $res ) {
            return $this->respondCreated( ['message' => lang('lang.quiz.updated')] );
        } else {
            return $this->fail( $this->model->errors() );
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
