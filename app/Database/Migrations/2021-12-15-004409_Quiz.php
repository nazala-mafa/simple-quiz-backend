<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Quiz extends Migration
{
    public function up()
    {
        /**
         * Quiz Category
         */
        $this->forge->addField([
            'id'    => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'name'  => [ 'type' => 'VARCHAR', 'constraint' => 255 ],
            'description'   => [ 'type' => 'TEXT', 'null' => true ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('quiz_category', true);

        /**
         * Quiz Data
         */
        $this->forge->addField([
            'id'            => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'user_id'       => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'quiz_category_id'       => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'title'         => [ 'type' => 'VARCHAR', 'constraint' => 255 ],
            'is_active'        => [ 'type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true ],
            'option_data'   => [ 'type' => 'TEXT', 'null' => true ],
            'created_at'    => [ 'type' => 'DATETIME' ],
            'updated_at'    => [ 'type' => 'DATETIME' ],
            'deleted_at'    => [ 'type' => 'DATETIME' ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('quiz_category_id', 'quiz_category', 'id', '', 'CASCADE');
        $this->forge->createTable('quiz', true);

        /**
         * Quiz Question
         */
        $this->forge->addField([
            'id'            => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'quiz_id'       => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'user_id'       => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'question'      => [ 'type' => 'TEXT' ],
            'created_at'    => [ 'type' => 'DATETIME' ],
            'updated_at'    => [ 'type' => 'DATETIME' ],
            'deleted_at'    => [ 'type' => 'DATETIME' ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('quiz_id', 'quiz', 'id', 'NO_ACTION', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'NO_ACTION', 'CASCADE');
        $this->forge->createTable('quiz_questions', true);

        /**
         * Quiz Answer
         */
        $this->forge->addField([
            'id'            => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'question_id'   => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'answer'        => [ 'type' => 'TEXT' ],
            'is_true'       => [ 'type' => 'BOOLEAN' ],
            'created_at'    => [ 'type' => 'DATETIME' ],
            'updated_at'    => [ 'type' => 'DATETIME' ],
            'deleted_at'    => [ 'type' => 'DATETIME' ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('question_id', 'quiz_questions', 'id', 'NO_ACTION', 'CASCADE' );
        $this->forge->createTable('quiz_answers', true);
    }

    public function down()
    {
        $this->forge->dropTable('quiz_answers', true);
        $this->forge->dropTable('quiz_questions', true);
        $this->forge->dropTable('quiz', true);
        $this->forge->dropTable('quiz_category', true);
    }
}
