<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EvaluationSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::unprepared(file_get_contents('modules/Evaluation/Database/Migrations/eval.sql'));
        DB::unprepared(file_get_contents('modules/Evaluation/Database/Migrations/evalquestion.sql'));
    }
}
