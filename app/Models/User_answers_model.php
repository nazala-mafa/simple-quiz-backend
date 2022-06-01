<?php

namespace App\Models;

use CodeIgniter\Model;

class User_answers_model extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'user_answers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    function calculateScore($user_id, $quiz_id){ 
      //get answers
      $answers =  $this->db->table($this->table)
        ->select('answer_id, is_true')
        ->join('quiz_answers', "quiz_answers.id = $this->table.answer_id")
        ->where([
          'user_id' => $user_id,
          'quiz_id' => $quiz_id
        ])->get()->getResultArray();
      
      //calculate answers
      return $this->countTrueAnswer($answers) / count($answers);
    }

    private function countTrueAnswer($answers) {
      $num = 0;
      foreach($answers as $answer) {
        if( $answer['is_true'] == 1 ) { $num++; }
      }
      return $num;
    }

}
