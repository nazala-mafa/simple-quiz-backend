<?php

namespace App\Models\Quiz;

use CodeIgniter\Model;

class Quiz_category_model extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'quiz_category';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'description'];

    // Validation
    protected $validationRules      = [
        'name'  => 'required|is_unique[quiz_category.name,id,{id}]'
    ];
    protected $validationMessages   = [
        'name'  => [
            'required' => 'Nama Tidak Boleh Kosong',
            'is_unique' => 'Nama Sudah Digunakana, Ganti Nama!'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = false;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
