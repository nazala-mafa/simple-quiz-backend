<?php

namespace App\Models\Quiz;

use CodeIgniter\Model;

class Quiz_answer_model extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'quiz_answers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['question_id', 'answer', 'is_true'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'question_id'   => 'required',
        'answer'        => 'required',
        'is_true'       => 'required',
    ];
    protected $validationMessages   = [
        'answer' => [ 'required' => "Jawaban Tidak Boleh Kosong" ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
