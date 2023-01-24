<?php

namespace Tests\Feature\Api;

use App\Http\Resources\QuizResource;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class QuizzesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testQuizzesIndexIsProtected ()
    {
        // Act
        $response = $this->getJson(route('api.quizzes.index'));

        // Assert
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testQuizzesIndexSuccessful ()
    {
        // Arrange
        $quizzes = Quiz::factory(2)->create();

        $questions1 = Question::factory(2)->create(['quiz_id' => $quizzes[0]->id]);
        $questions2 = Question::factory(2)->create(['quiz_id' => $quizzes[1]->id]);

        // Act
        $response = $this->actingAs($this->user)->getJson(route('api.quizzes.index'));

        // Assert
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => $quizzes->map(fn($quiz) => $this->simulateResource($quiz))->toArray(),
        ]);
    }

    public function testQuizzesShow () {
        // Arrange
        $quiz = Quiz::factory()->create(['author_id' => $this->admin]);

        $questions = Question::factory(2)->create(['quiz_id' => $quiz->id]);

        // Act
        $response = $this->actingAs($this->user)->getJson(route('api.quizzes.show', ['quiz' => $quiz->id]));

        // Assert
        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson(['data' => $this->simulateResource($quiz)]);
    }

    private function simulateResource(Quiz $quiz)
    {
        return collect(
            $quiz->refresh()->only(['id', 'title', 'is_draft']),
        )->merge([
            'author' => $quiz->author->only(['id', 'name', 'email']),
        ])->merge([
            'questions' => $quiz->questions->map(fn($question) => $question->only(['id', 'content'])),
        ])->toArray();
    }
}
