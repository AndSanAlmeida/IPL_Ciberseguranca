<?php

use Illuminate\Database\Seeder;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_questions')->insert([
        	'question' => 'Como é que a cibersegurança está a afetar os escritórios de advogados?', 
        	'user_id' => 1,
        	'isAnswered' => 0,
        	'isFAQ' => 0
        	]);
    }
}
