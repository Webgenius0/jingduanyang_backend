<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizzeQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            [
                'quizze_category_id' => 1,
                'question' => 'What is the chemical symbol for water?',
                'option1' => 'H3O',
                'option2' => 'O2',
                'option3' => 'CO2',
                'answer' => 'H2O',
                'status' => 'active',
            ],
            [
                'quizze_category_id' => 1,
                'question' => 'Which planet is known as the Red Planet?',
                'option1' => 'Earth',
                'option2' => 'Venus',
                'option3' => 'Jupiter',
                'answer' => 'Mars',
                'status' => 'active',
            ],
            [
                'quizze_category_id' => 2,
                'question' => 'Who was the first president of the United States?',
                'option1' => 'Abraham Lincoln',
                'option2' => 'George Ashington',
                'option3' => 'Thomas Jefferson',
                'answer' => 'George Washington',
                'status' => 'active',
            ],
            [
                'quizze_category_id' => 2,
                'question' => 'In which year did World War II end?',
                'option1' => '1940',
                'option2' => '1946',
                'option3' => '1950',
                'answer' => '1945',
                'status' => 'active',
            ],
            [
                'quizze_category_id' => 3,
                'question' => 'Which continent is the largest by area?',
                'option1' => 'Africa',
                'option2' => 'Berlin',
                'option3' => 'Europe',
                'answer' => 'Asia',
                'status' => 'active',
            ],
            [
                'quizze_category_id' => 4,
                'question' => 'Which country won the FIFA World Cup in 2018?',
                'option1' => 'Germany',
                'option2' => 'Italy',
                'option3' => 'Brazil',
                'answer' => 'France',
                'status' => 'active',
            ],
            [
                'quizze_category_id' => 5,
                'question' => 'Who is known as the father of modern computing?',
                'option1' => 'Bill Gates',
                'option2' => 'Turing',
                'option3' => 'Steve Jobs',
                'answer' => 'Alan Turing',
                'status' => 'active',
            ],
            [
                'quizze_category_id' => 6,
                'question' => 'Which movie won the Oscar for Best Picture in 2020?',
                'option1' => '1912',
                'option2' => '1917',
                'option3' => 'Joker',
                'answer' => 'Parasite',
                'status' => 'active',
            ],
        ];

        DB::table('quizze_questions')->insert($questions);
    }
}
