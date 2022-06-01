<?php

namespace App\Models\Quiz;

use CodeIgniter\Model;

class Quiz_model extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'quiz';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [ 'user_id', 'quiz_category_id', 'title', 'is_active', 'option_data' ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'title'         => 'required|is_unique[quiz.title,id,{id}]'
    ];
    protected $validationMessages   = [
        'title' => [
            'required'  => 'Judul tidak boleh kosong',
            'is_unique' => 'Judul sudah digunakan, ganti judul!'
        ]
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
