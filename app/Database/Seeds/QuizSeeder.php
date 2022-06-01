<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run()
    {
        //dummy quiz
        $this->db->table('quiz_category')->insertBatch([
            [ 'id' => 1, 'name' => 'Matematika' ],
            [ 'id' => 2, 'name' => 'Sejarah' ],
            [ 'id' => 3, 'name' => 'Bahasa Inggris' ],
        ]);

        $this->db->table('quiz')->insertBatch([
            [ 'id' => 1, 'user_id' => 1, 'quiz_category_id' => 1, 'title' => "ulangan harian", "is_active" => 1 ],
        ]);

        $this->db->table('quiz_questions')->insertBatch([
            [ 'id' => 1, 'quiz_id' => 1, 'user_id' => 1, 'question' => '1 + 1 =' ],
            [ 'id' => 2, 'quiz_id' => 1, 'user_id' => 1, 'question' => '2 + 2 =' ],
            [ 'id' => 3, 'quiz_id' => 1, 'user_id' => 1, 'question' => '3 + 3 =' ],
            [ 'id' => 4, 'quiz_id' => 1, 'user_id' => 1, 'question' => '4 + 4 =' ],
            [ 'id' => 5, 'quiz_id' => 1, 'user_id' => 1, 'question' => '5 + 5 =' ]
        ]);

        $this->db->table('quiz_answers')->insertBatch([
            [ 'question_id' => 1, 'answer' => '1', 'is_true' => 0 ],
            [ 'question_id' => 1, 'answer' => '2', 'is_true' => 1 ],
            [ 'question_id' => 1, 'answer' => '3', 'is_true' => 0 ],

            [ 'question_id' => 2, 'answer' => '2', 'is_true' => 0 ],
            [ 'question_id' => 2, 'answer' => '4', 'is_true' => 1 ],
            [ 'question_id' => 2, 'answer' => '6', 'is_true' => 0 ],

            [ 'question_id' => 3, 'answer' => '2', 'is_true' => 0 ],
            [ 'question_id' => 3, 'answer' => '4', 'is_true' => 0 ],
            [ 'question_id' => 3, 'answer' => '6', 'is_true' => 1 ],

            [ 'question_id' => 4, 'answer' => '4', 'is_true' => 0 ],
            [ 'question_id' => 4, 'answer' => '6', 'is_true' => 0 ],
            [ 'question_id' => 4, 'answer' => '8', 'is_true' => 1 ],

            [ 'question_id' => 5, 'answer' => '8', 'is_true' => 0 ],
            [ 'question_id' => 5, 'answer' => '10', 'is_true' => 1 ],
            [ 'question_id' => 5, 'answer' => '12', 'is_true' => 0 ]
        ]);
    }
}
