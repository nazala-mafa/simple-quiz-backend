<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AuthSeeder extends Seeder
{
    public function run()
    {   

        $now = Date('Y-m-d H:i:s');
        $this->db->table('users')->insertBatch([
            [
                'id'            => 1,
                'username'      => 'admin',
                'email'         => 'admin@gmail.com',
                'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now
            ],
            [
                'id'            => 2,
                'username'      => 'guru',
                'email'         => 'guru@gmail.com',
                'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now
            ],
            [
                'id'            => 3,
                'username'      => 'murid',
                'email'         => 'murid@gmail.com',
                'password_hash' => password_hash('1234', PASSWORD_DEFAULT),
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now
            ],
        ]);
        $this->db->table('auth_groups')->insertBatch([
            [ 'id' => 1, 'group_name' => 'admin' ],
            [ 'id' => 2, 'group_name' => 'teacher' ],
            [ 'id' => 3, 'group_name' => 'student' ],
        ]);
        $this->db->table('auth_groups_users')->insertBatch([
            [ 'user_id' => 1, 'group_id' => 1 ],
            [ 'user_id' => 2, 'group_id' => 2 ],
            [ 'user_id' => 3, 'group_id' => 3 ],
        ]);
    }
}
