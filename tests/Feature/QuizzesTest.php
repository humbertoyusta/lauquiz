<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class QuizzesTest extends TestCase
{
    use RefreshDatabase;

    public function testQuizzesIndexRedirectsNotLoggedInUserToLogin ()
    {
        // Act
        $response = $this->get(route('quizzes.index'));

        // Assert
        $response->assertRedirectToRoute('login');
    }

    public function testQuizzesIndexShowsCorrectQuizzesAndTags ()
    {
        // Arrange
        $users = User::factory(2)->create();

        $quizzes1 = Quiz::factory(3)->create(['author_id' => $users[0]->id]);
        $quizzes2 = Quiz::factory(2)->create(['author_id' => $users[1]->id]);

        $tags = Tag::factory(10)->create();
        for ($i = 0; $i < count($quizzes1); $i ++)
            $quizzes1[$i]->tags()->sync($tags->skip(2 * $i)->take(2));

        for ($i = 0; $i < count($quizzes2); $i ++)
            $quizzes2[$i]->tags()->sync($tags->skip(6 + 2 * $i)->take(2));

        // Act
        $response = $this->actingAs($users[0])->get(route('quizzes.index'));

        // Assert
        $response->assertStatus(Response::HTTP_OK);

        foreach ($quizzes1 as $quiz) {
            $response->assertSee($quiz->title);
            $response->assertSee($quiz->tags->first()->name);
        }

        foreach ($quizzes2 as $quiz) {
            $response->assertDontSee($quiz->title);
            $response->assertDontSee($quiz->tags->first()->name);
        }
    }

    public function testCreateQuizPage ()
    {
        // Act
        $response = $this->actingAs($this->user)->get(route('quizzes.create'));

        // Assert
        $response->assertStatus(Response::HTTP_OK);

        $response->assertSee('<input type="text" class="form-control" id="title', false);

        $response->assertSee('<input type="text" class="form-control" id="tags', false);

        $response->assertSee('Create Quiz');
    }

    public function testEditQuizPage ()
    {
        // Arrange
        $quiz = Quiz::factory()->create(['author_id' => $this->user->id]);

        $questions = Question::factory(2)->create(['quiz_id' => $quiz->id]);

        $tags = Tag::factory(2)->create();

        $quiz->tags()->sync($tags->pluck('id'));

        // Act
        $response = $this->actingAs($this->user)->get(route('quizzes.edit', ['quiz' => $quiz->id]));

        // Assert
        $response->assertStatus(Response::HTTP_OK);

        $response->assertSee([
            $quiz->title,
            $questions->first()->content,
            $questions->last()->content,
            'Apply Update',
            'Add new Question',
            'Edit Question',
            'Delete',
        ]);
    }
}
