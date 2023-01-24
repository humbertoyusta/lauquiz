<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\AnsweredQuestion;
use App\Models\AnsweredQuiz;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use App\Services\AnsweredQuestionsService;
use App\Services\AnsweredQuizzesService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ScoreboardTest extends TestCase
{
    use RefreshDatabase;

    public function testScoreboard ()
    {
        // Arrange
        $users = User::factory(3)->create();

        $quiz = Quiz::factory()->create();

        $questions = Question::factory(2)->create(['quiz_id' => $quiz->id]);

        for ($i = 0; $i < 4; $i ++)
            $answers[] = Answer::factory()->create([
                'question_id' => $questions[intdiv($i, 2)]->id,
                'is_correct' => $i % 2,
            ]);

        $answeredQuizzes = collect([]);
        for ($i = 0; $i < 3; $i ++)
            $answeredQuizzes[] = AnsweredQuiz::factory()->create([
                'user_id' => $users[$i]->id,
                'quiz_id' => $quiz->id,
            ]);

        $which = [[1, 1], [1, 0], [0, 0]];
        $answeredQuestions = collect([]);
        for ($i = 0; $i < 3; $i ++)
            for ($j = 0; $j < 2; $j ++) {
                $answeredQuestions[] = AnsweredQuestion::factory()->create([
                    'answered_quiz_id' => $answeredQuizzes[$i]->id,
                    'question_id' => $questions[$j]->id,
                    'answer_id' => $questions[$j]->answers[$which[$i][$j]]->id,
                    'is_correct' => $questions[$j]->answers[$which[$i][$j]]->is_correct,
                ]);
            }

        // Act
        $response = $this->actingAs($this->user)->get(route('quizzes.scoreboard', ['quiz' => $quiz->id]));

        // Assert
        $response->assertStatus(Response::HTTP_OK);

        $response->assertSeeInOrder([
            $users[0]->name,
            'Solved 2',
            $users[1]->name,
            'Solved 1',
            $users[2]->name,
            'Solved 0',
        ]);
    }
}
