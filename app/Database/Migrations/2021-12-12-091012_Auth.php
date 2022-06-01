<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Auth extends Migration
{
    public function up()
    {
        /**
         * Users
         */
        $this->forge->addField([
            'id'            => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'username'      => [ 'type' => 'VARCHAR', 'constraint' => 255 ],
            'email'         => [ 'type' => 'VARCHAR', 'constraint' => 255 ],
            'password_hash' => [ 'type' => 'VARCHAR', 'constraint' => 255 ],
            'is_active'     => [ 'type' => 'BOOLEAN', 'default' => false ],
            'status'        => [ 'type' => 'VARCHAR', 'constraint' => 50 ],
            'created_at'    => [ 'type' => 'timestamp', 'null' => true],
            'updated_at'    => [ 'type' => 'timestamp', 'null' => true],
            'deleted_at'    => [ 'type' => 'timestamp', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users', true);

        /** 
         * Groups
         */
        $this->forge->addField([
            'id'            => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'group_name'    => [ 'type' => 'VARCHAR', 'constraint' => 255 ],
            'description'   => [ 'type' => 'TEXT', 'null' => true ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_groups', true);

        /**
         * User Groups
         */
        $this->forge->addField([
            'user_id'       => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'group_id'      => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
        ]);
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');        
        $this->forge->addForeignKey('group_id', 'auth_groups', 'id', '', 'CASCADE');
        $this->forge->createTable('auth_groups_users', true);

        /**
         * Users Logins
         */
        $this->forge->addField([
            'id'            => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'ip_address'    => [ 'type' => 'VARCHAR', 'constraint' => 30 ],
            'email'         => [ 'type' => 'VARCHAR', 'constraint' => 255 ],
            'user_id'       => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'date'          => [ 'type' => 'timestamp' ],
            'success'       => [ 'type' => 'BOOLEAN' ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('auth_logins', true);
    }

    public function down()
    {
        $this->forge->dropTable('users', true);
        $this->forge->dropTable('auth_groups', true);
        $this->forge->dropTable('auth_groups_users', true);
        $this->forge->dropTable('auth_logins', true);
    }
}
