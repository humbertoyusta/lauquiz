<?php

namespace App\Services;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizzesService extends AbstractService
{
    public function __construct(
        public TagsService $tagsService,
    ) {
        parent::__construct(
            '\App\Models\Quiz',
            [
                'title' => 'required|max:255',
                'author_id' => 'required|integer|min:1',
            ],
        );
    }

    /**
     * Custom saving method for Quizzes.
     * Add current logged in user as author.
     * Use AbstractService->save.
     * Create or update each Tag from the form.
     */
    public function save(Request $request, int $id = 0)
    {
        // Add author_id of logged in user and is_draft to true (is_draft will be changed later by an event)
        $request->request->add(['author_id' => Auth::user()->id, 'is_draft' => true]);

        // Actually create or update
        $quiz = parent::save($request, $id);

        // Validate tags
        $tagNamesCommaSeparated = $request->validate([
            'tags' => 'string|nullable',
        ]);

        // Sync tags
        if ($tagNamesCommaSeparated['tags']) {
            $this->syncTags($quiz, $tagNamesCommaSeparated['tags']);
        }

        return $quiz;
    }

    /**
     * Syncs Tags to Quiz
     */
    private function syncTags(Quiz $quiz, string $tagNamesCommaSeparated): void
    {
        $tagNames = collect(explode(',', $tagNamesCommaSeparated))->map(fn ($k) => ucfirst(strtolower(trim($k))));

        foreach ($tagNames as $tagName) {
            $tagIds[] = $this->tagsService->firstOrCreate([
                'name' => $tagName,
            ])->id;
        }

        $quiz->tags()->sync($tagIds);
    }

    public function currentUserQuizzesWithTags(int $perPage)
    {
        return Quiz::where('author_id', Auth::user()->id)->with('tags')->paginate($perPage);
    }

    public function getQuizwithQuestionsAndAnswers(int $id): Quiz
    {
        return Quiz::where('id', $id)->with(['questions' => ['answers']])->first();
    }

    public function getQuizwithQuestions(int $id): Quiz
    {
        return Quiz::where('id', $id)->with(['questions'])->first();
    }

    public function getQuizzesWithQuestions(int $perPage)
    {
        return Quiz::with(['questions'])->paginate($perPage);
    }

    public function getNonDraftQuizzesWithQuestionsAndTags()
    {
        return Quiz::with(['questions', 'tags'])->where('is_draft', false)->get();
    }
}
