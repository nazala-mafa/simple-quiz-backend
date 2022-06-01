<?php

namespace App\Models;

use CodeIgniter\Model;

class User_score_model extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'user_scores';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $protectFields    = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'user_id' => 'required',
        'quiz_id' => 'required',
        'score' => 'required',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    function getScoreByUserId($id) {
        return $this->select('user_scores.*, quiz.title')
            ->join('quiz', 'quiz.id = user_scores.quiz_id')
            ->where('user_scores.user_id', $id)->findAll();
    }
}
