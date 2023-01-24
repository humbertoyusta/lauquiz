<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PlayQuizTest extends TestCase
{
    use RefreshDatabase;

    public function testPlayQuizIndex ()
    {
        // Arrange
        $quizzes1 = collect([]);
        $quizzes1[] = Quiz::factory()->createQuietly(['is_draft' => false, 'owner_id' => $this->user]);
        $quizzes1[] = Quiz::factory()->createQuietly(['is_draft' => false]);

        Question::factory()->createQuietly(['quiz_id' => $quizzes1[0]->id]);
        Question::factory()->createQuietly(['quiz_id' => $quizzes1[1]->id]);

        $quiz2 = Quiz::factory()->createQuietly(['is_draft' => true]);

        // Act
        $response = $this->actingAs($this->user)->get(route('play.index'));

        // Assert
        $response->assertStatus(Response::HTTP_OK);

        $response->assertSee([
            'Owned by '.$this->user->name,
            'Buy for',
            $quizzes1[0]->title,
            $quizzes1[1]->title,
            'Play',
            'Scoreboard',
        ]);

        $response->assertDontSee($quiz2->title);
    }

    public function testPlayQuestionShow ()
    {
        // Arrange
        $question = Question::factory()->create();

        $answers = collect([]);
        $answers[] = Answer::factory()->create(['is_correct' => true, 'question_id' => $question->id]);
        $answers[] = Answer::factory()->create(['is_correct' => false, 'question_id' => $question->id]);

        $question->quiz->updateQuietly(['is_draft' => false]);

        // Act
        $response = $this
            ->actingAs($this->user)
            ->get(route('play.questions.show', [
                'quiz' => $question->quiz->id,
                'question' => $question->id,
            ]));

        // Assert
        $response->assertStatus(Response::HTTP_OK);

        $response->assertSee([
            $question->content,
            $answers->first()->content,
            $answers->last()->content,
            '<input class="form-check-input" type="radio" name="answer_id" id="answer_id"',
            'Next',
        ], false);

    }
}
