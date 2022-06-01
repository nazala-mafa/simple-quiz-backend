<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Score extends Migration
{
    public function up()
    {
        // Jawaban User
        $this->forge->addField([
            'id'            => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'user_id'       => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'quiz_id'       => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'question_id'   => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'answer_id'     => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'NO_ACTION', 'CASCADE' );
        $this->forge->addForeignKey('quiz_id', 'quiz', 'id', 'NO_ACTION', 'CASCADE' );
        $this->forge->addForeignKey('question_id', 'quiz_questions', 'id', 'NO_ACTION', 'CASCADE' );
        $this->forge->addForeignKey('answer_id', 'quiz_answers', 'id', 'NO_ACTION', 'CASCADE' );
        $this->forge->createTable('user_answers', true);

        // Skor / Nilai User
        $this->forge->addField([
            'id'            => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'user_id'       => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'quiz_id'       => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'score'         => [ 'type' => 'INT', 'constraint' => 3, 'unsigned' => true ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'NO_ACTION', 'CASCADE' );
        $this->forge->addForeignKey('quiz_id', 'quiz', 'id', 'NO_ACTION', 'CASCADE' );
        $this->forge->createTable('user_scores', true);
    }

    public function down()
    {
        $this->forge->dropTable('user_answers', true);
        $this->forge->dropTable('user_scores', true);
    }
}
