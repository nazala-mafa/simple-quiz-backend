<?php

namespace App\Models\Quiz;

use CodeIgniter\Model;

class Quiz_question_model extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'quiz_questions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['quiz_id', 'user_id', 'question'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'quiz_id'   => 'required',
        'question'      => 'required',
    ];
    protected $validationMessages   = [
        'quiz_id'  => [
            'required'  => 'Kuis Tidak Boleh Kosong!'
        ],
        'question'     => [
            'required'  => 'Pertanyaan Tidak Boleh Kosong!'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    function getUserExam($quizId, $userId, $isAdmin) {

        $res = $this->select('quiz_questions.id as question_id, quiz_questions.question, qa.id as answer_id, qa.answer, qa.is_true')
            ->join('quiz_answers as qa', 'qa.question_id=quiz_questions.id')
            ->where('quiz_questions.quiz_id', $quizId)->findAll();
        $data = [];
        foreach($res as $d){
            $id = $d['question_id']; 
            $data[ $id ]['question_id'] = $d['question_id'];
            $data[ $id ]['question'] = $d['question'];

            $data[ $id ]['user_answer_id'] = $this->getUserAnswerId($userId, $quizId, $d['question_id']);

            if( $isAdmin ) {
                $data[ $id ]['answers'][] = [
                    'answer_id' => $d['answer_id'],
                    'is_true' => $d['is_true'],
                    'answer' => $d['answer']
                ];
            } else {
                
                $data[ $id ]['answers'][] = [
                    'answer_id' => $d['answer_id'],
                    'answer' => $d['answer'],
                ];
            }
        }
        return $data;
    }

    private $userAnswers = null;
    private function getUserAnswerId($userId, $quizId, $questionId) {
        if( !$this->userAnswers ) {
            $this->userAnswers = $this->db->table('user_answers')->where([
                'user_id' => $userId,
                'quiz_id' => $quizId
            ])->get()->getResultArray() ?? [];
        }
        foreach($this->userAnswers as $answer) {
            if( $answer['question_id'] === $questionId ) return $answer['answer_id']; 
        }
        return null;
    }

}
