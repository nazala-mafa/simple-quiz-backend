<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User_answers_model;
use App\Models\User_score_model;
use CodeIgniter\API\ResponseTrait;

class Score extends BaseController
{
  use ResponseTrait;
  protected $format = 'json';

  function answer() {
    $answerModel = model(User_answers_model::class);
    $where = $this->request->getJson(true);
    unset($where['answer_id']);
    $answer = $answerModel->where($where)->get();
    if( $answer->getNumRows() ) {
      $id = $answerModel->where($where)->first()['id'];
      $res = $answerModel->update( $id, $this->request->getJson(true) );
    } else {
      $res = $answerModel->insert( $this->request->getJson(true) );
    }
    return $this->respond( $res );
  }

  function student_score($userId = null) {
    return true;
  }

  function submit_quiz() {
    $userId = $this->request->getGet('user-id');
    $quizId = $this->request->getGet('quiz-id');    

    $score = model(User_answers_model::class)->calculateScore($userId, $quizId);
    
    $isInserted = model(User_score_model::class)->insert([
      'user_id' => $userId,
      'quiz_id' => $quizId,
      'score' => $score
    ]);

    if( $isInserted ) {
      model(User_answers_model::class)->where([
        'user_id' => $userId,
        'quiz_id' => $quizId
      ])->delete();
      return $this->respond($score);
    }
    return $this->respond(false);
  }

  function show($id = null) {
    return $this->respond( (new User_score_model())->getScoreByUserId($id) );
  }
}
