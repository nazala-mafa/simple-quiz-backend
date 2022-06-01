<?php

namespace App\Controllers;

use App\Models\Users_model;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;

class Users extends ResourceController
{
    use ResponseTrait;
    protected $modelName = 'App\Models\Users_model';
    protected $format = 'json';

    public function index()
    {
        $select = 'users.*, auth_groups.group_name';
        return $this->respond( $this->model->select($select)->where('group_name !=', 'admin')->findAll() );
    }

    public function new()
    {
        $req = $this->request->getJSON();
        if(!$this->validate([
            'username' => 'required|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[4]',
        ])) return $this->fail(['errors'=>$this->validator->getErrors()]);

        $req->password_hash = password_hash($req->password, PASSWORD_DEFAULT);
        unset($req->password);

        db_connect()->transStart();
        $userId = model(Users_model::class)->insert($req, true);
        $res = db_connect()->table('auth_groups_users')->insert([
            'user_id' => $userId,
            'group_id' => 3 //id group user murid
        ]);
        db_connect()->transComplete();
        
        if($res) return $this->respond(['message' => 'selamat user baru berhasil ditambahkan']);
        else return $this->fail(['message' => 'gagal menambah user terjadi kesalahan']);
    }

    public function signup()
    {
        $req = $this->request->getJSON(true);
        // $req = $this->request->getGet();
        $password_hash = password_hash($req['password'], PASSWORD_DEFAULT);
        $req['password_hash'] = $password_hash;
        $req['role'] = 'student';
        $res = $this->model->addUser($req);
        if( isset($res['status']) ) {
            return $this->respondCreated([ 'message' => 'user baru telah ditambahkan' ]);
        } else {
            return $this->fail( $res );
        }
    }

    public function signin()
    {
        $req = $this->request->getJSON(true);
        $validation = \Config\Services::validation();
        $validation->setRule('password', 'Password', 'required');
        $user = $this->model
            ->select('users.*, ag.group_name')
            ->join('auth_groups_users as agu', 'agu.user_id = users.id')
            ->join('auth_groups as ag', 'ag.id = agu.group_id');
        //username ada?
        if( isset($req['email']) ) {
            $validation->setRule('email', 'Email', 'required');
            $user = $user->where('email', $req['email'])->find();
        } else {
            $validation->setRule('username', 'Username', 'required');
            $user = $user->where('username', $req['username'])->find();
        }
        if( !$validation->run($req) ) return $this->fail( $validation->getErrors() );
        if( !$user ) return $this->fail( lang('lang.auth.error.message.user_not_found') );
        //password valid?
        $isValidPass = password_verify( $req['password'], $user[0]['password_hash'] );
        if( !$isValidPass ) return $this->fail( lang('lang.auth.error.message.wrong_password') );
        //user aktif?
        if( !$user[0]['is_active'] ) return $this->fail( lang('lang.auth.error.message.unactived_user') );

        //tambah log user
        model('Auth_login_model')->insert([
            'ip_address'    => $this->request->getIPAddress(),
            'email'         => $user[0]['email'],
            'user_id'       => $user[0]['id'],
            'success'       => 1
        ]);
        
        //persiapan token respond jwt
        $payload = $user[0];
        unset( $payload['updated_at'], $payload['deleted_at'], $payload['password_hash'], $payload['created_at'] );
        //exired dalam (7hari)
        $payload['expired'] = date('Y-m-d H:i:s', time()+(7*24*60*60)); 
        $jwt_res = JWT::encode($payload, env('jwt_key'), 'HS256');
        
        //respond jwt
        return $this->respond([
            'message'   => lang('lang.auth.success.message', [ $payload['username'] ]),
            'data'      => [
                'id'        =>  $user[0]['id'],
                'username'  =>  $user[0]['username'],
                'email'     =>  $user[0]['email'],
                'group'     => $user[0]['group_name'],
                'token'     =>  $jwt_res
            ]
        ], 200);
    }

    public function get_session_by_token() {
        $req = $this->request->getJSON(true);
        $token_data = \Firebase\JWT\JWT::decode( $req['token'], new \Firebase\JWT\Key( env('jwt_key'), 'HS256') );

        $user = $this->model
            ->select('users.id, users.username, users.email, ag.group_name as group')
            ->join('auth_groups_users as agu', 'agu.user_id = users.id')
            ->join('auth_groups as ag', 'ag.id = agu.group_id')
            ->where('users.id', $token_data->id)->get()->getRowArray();

        return $this->respond([
            'message' => lang('lang.auth.success.message', [ $user['username'] ]),
            'data'    =>  $user
        ], 200);
    }

    public function delete($id = null)
    {
        $username = model(Users_model::class)->find($id)['username'];
        model(Users_model::class)->delete($id);
        return $this->respond(['message' => "user $username berhasil dihapus"]);
    }

    public function activation() {
        $req = $this->request->getJSON();
        $username = model(Users_model::class)->find($req->id)['username'];
        $activate = $req->is_active ? 'aktifkan' : 'nonaktifkan';
        model(Users_model::class)->update($req->id, ['is_active' => $req->is_active]);
        return $this->respond(['message' => "user $username berhasil di$activate"]);
    }
}
