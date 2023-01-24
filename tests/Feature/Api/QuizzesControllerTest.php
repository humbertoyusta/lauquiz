<?php

namespace Tests\Feature\Api;

use App\Http\Resources\QuizResource;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
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

    public function testQuizzesShowSuccessful () {
        // Arrange
        $quiz = Quiz::factory()->create(['author_id' => $this->admin]);

        $questions = Question::factory(2)->create(['quiz_id' => $quiz->id]);

        // Act
        $response = $this->actingAs($this->user)->getJson(route('api.quizzes.show', ['quiz' => $quiz->id]));

        // Assert
        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson(['data' => $this->simulateResource($quiz)]);
    }

    public function testQuizzesShowNotFound ()
    {
        // Act
        $response = $this->actingAs($this->user)->getJson(route('api.quizzes.show', ['quiz' => 235325]));

        // Assert
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testQuizzesStoreSuccessful ()
    {
        // Act
        $response = $this->actingAs($this->user)->postJson(route('api.quizzes.store'), [
            'title' => 'My brand new title 1',
        ]);

        // Arrange
        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('quizzes', [
            'title' => 'My brand new title 1',
            'author_id' => $this->user->id,
        ]);
    }

    public function testQuizzesStoreFailTitleIsRequired ()
    {
        // Act
        $response = $this->actingAs($this->user)->postJson(route('api.quizzes.store'), [
            'title' => '',
        ]);

        // Arrange
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJson(['errors' => ['title' => []]]);

        $this->assertDatabaseMissing('quizzes', [
            'title' => 'My brand new title 1',
            'author_id' => $this->user->id,
        ]);
    }

    public function testQuizzesUpdateSuccessful ()
    {
        // Arrange
        $quiz = Quiz::factory()->create(['author_id' => $this->user]);

        // Act
        $response = $this->actingAs($this->user)->putJson(
            route('api.quizzes.update', ['quiz' => $quiz->id]),
            ['title' => 'My brand new title 1'],
        );

        // Arrange
        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('quizzes', [
            'id' => $quiz->id,
            'title' => 'My brand new title 1',
            'author_id' => $this->user->id,
        ]);
    }

    public function testQuizzesUpdateForbidden ()
    {
        // Arrange
        $otherUser = User::factory()->create();

        $quiz = Quiz::factory()->create(['author_id' => $otherUser]);

        // Act
        $response = $this->actingAs($this->user)->putJson(
            route('api.quizzes.update', ['quiz' => $quiz->id]),
            ['title' => 'My brand new title 1'],
        );

        // Arrange
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertDatabaseHas('quizzes', [
            'id' => $quiz->id,
            'title' =>  $quiz->title,
            'author_id' => $otherUser->id,
        ]);
    }

    public function testQuizzesDestroySuccessful ()
    {
        // Arrange
        $quiz = Quiz::factory()->create(['author_id' => $this->user]);

        // Act
        $response = $this->actingAs($this->user)->deleteJson(route('api.quizzes.destroy', ['quiz' => $quiz->id]));

        // Assert
        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson(['data' => $this->simulateResource($quiz)]);

        $this->assertSoftDeleted($quiz);
    }

    public function testQuizzesDestroyForbidden ()
    {
        // Arrange
        $otherUser = User::factory()->create();

        $quiz = Quiz::factory()->create(['author_id' => $otherUser->id]);

        // Act
        $response = $this->actingAs($this->user)->deleteJson(route('api.quizzes.destroy', ['quiz' => $quiz->id]));

        // Assert
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $this->assertNotSoftDeleted($quiz);
    }

    public function testQuizzesDestroyNotFound ()
    {
        // Act
        $response = $this->actingAs($this->user)->deleteJson(route('api.quizzes.destroy', ['quiz' => 352345]));

        // Assert
        $response->assertStatus(Response::HTTP_NOT_FOUND);
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
