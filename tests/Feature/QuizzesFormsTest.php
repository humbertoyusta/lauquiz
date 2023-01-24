<?php

namespace Tests\Feature;

use App\Models\Quiz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class QuizzesFormsTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreQuizSuccessful ()
    {
        // Act
        $response = $this->actingAs($this->user)->post(route('quizzes.store'), [
            'title' => "New Quiz Hoogh",
            'tags' => 'new, Brand, state-less',
        ]);

        // Assert
        $response->assertRedirect(route('quizzes.edit', ['quiz' => Quiz::all()->last()->id]));

        $this->assertDatabaseHas('quizzes', [
            'title' => "New Quiz Hoogh",
            'author_id' => $this->user->id,
        ]);

        $this->assertCount(3, $this->user->quizzes->last()->tags);
    }

    public function testCreateQuizFailTitleIsRequired ()
    {
        // Act
        $response = $this->actingAs($this->user)->post(route('quizzes.store'), [
            'title' => "New Quiz Hoogh",
            'tags' => 'new, Brand, state-less',
        ]);

        // Assert
        $response->assertRedirect(route('quizzes.edit', ['quiz' => Quiz::all()->last()->id]));

        $this->assertDatabaseHas('quizzes', [
            'title' => "New Quiz Hoogh",
            'author_id' => $this->user->id,
        ]);

        $this->assertCount(3, $this->user->quizzes->last()->tags);
    }

    public function testUpdateQuizSuccessful ()
    {
        // Arrange
        $quiz = Quiz::factory()->create(['author_id' => $this->user->id]);

        // Act
        $response = $this->actingAs($this->user)->put(route('quizzes.update', ['quiz' => $quiz->id]), [
            'title' => "New Quiz Hoogh",
            'tags' => 'new, Brand, state-less',
        ]);

        // Assert
        $response->assertRedirect(route('quizzes.edit', ['quiz' => $quiz->id]));

        $this->assertDatabaseHas('quizzes', [
            'title' => "New Quiz Hoogh",
            'author_id' => $this->user->id,
            'id' => $quiz->id,
        ]);
    }
}
