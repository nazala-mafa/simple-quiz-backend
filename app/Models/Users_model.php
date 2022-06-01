<?php

namespace App\Models;

use CodeIgniter\Model;

class Users_model extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [ 'username', 'email', 'password_hash', 'is_active', 'status' ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'username'  => 'required|is_unique[users.username,id,{id},deleted_at]',
        'email'     => 'required|valid_email|is_unique[users.email,id,{id},deleted_at]',
        'password_hash' => 'required',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = ['getGroups'];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    function addUser(Array $req) {
        //validate user input
        $this->validation->setRule('role', 'role', 'required');
        $validate = $this->validate($req);
        if( !$validate ) return $this->errors();
        //add user
        $user_id = $this->insert([
            'username'      => $req['username'],
            'password_hash' => $req['password_hash'],
            'email'         => $req['email'], 
            'is_active'     => true,
            'status'        => ''
        ], true);
        if( !$user_id ) return $this->errors();

        //add group
        switch ( $req['role'] ) {
            case 'teacher':
                model('App\Models\Groups_users_model')->insert([
                    'user_id'   => $user_id,
                    'group_id'  => 2
                ]);
                break;
            case 'student':
                model('App\Models\Groups_users_model')->insert([
                    'user_id'   => $user_id,
                    'group_id'  => 3
                ]);
                break;
            default:
                $this->where('id', $user_id)->delete();
                return [ 'role' => 'peran tidak ditemukan' ];
        }
        return [
            'status'    => true,
            'message'   => 'user berhasil ditambahkan'
        ];
    }

    function getGroups() {
        $this->builder()
            ->select('users.*, auth_groups.group_name')
            ->join('auth_groups_users', 'users.id = auth_groups_users.user_id')
            ->join('auth_groups', 'auth_groups_users.group_id = auth_groups.id');
    }
}
