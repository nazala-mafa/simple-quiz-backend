<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class All extends Seeder {
  function run() {
    $seeder = \Config\Database::seeder();
    $seeder->call('AuthSeeder');
    $seeder->call('QuizSeeder');
  }
}