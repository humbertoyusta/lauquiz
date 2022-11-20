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

    public function save (Request $request, int $id = 0)
    {
        $request->request->add(['author_id' => Auth::user()->id, 'is_draft' => true]);

        $quiz = parent::save($request, $id);

        $tagNamesCommaSeparated = $request->validate([
            'tags' => 'string|nullable',
        ]);

        $this->syncTags($quiz, $tagNamesCommaSeparated['tags']);

        return $quiz;
    }

    private function syncTags(Quiz $quiz, string $tagNamesCommaSeparated): void
    {
        $tagNames = collect(explode(',', $tagNamesCommaSeparated))->map(fn($k) => ucfirst(strtolower(trim($k))));

        foreach($tagNames as $tagName)
        {
            $tagIds[] = $this->tagsService->firstOrCreate([
                'name' => $tagName,
            ])->id;
        }

        $quiz->tags()->sync($tagIds);
    }

    public function currentUserQuizzes (int $perPage)
    {
        return Quiz::where('author_id', Auth::user()->id)->paginate($perPage);
    }

    public function getQuizwithQuestionsAndAnswers(int $id): Quiz
    {
        return Quiz::where('id', $id)->with(['questions' => ['answers']])->first();
    }

    public function getQuizwithQuestions(int $id): Quiz
    {
        return Quiz::where('id', $id)->with(['questions'])->first();
    }

    public function getQuizzesWithQuestions (int $perPage)
    {
        return Quiz::with(['questions'])->paginate($perPage);
    }

    public function getNonDraftQuizzesWithQuestions (int $perPage)
    {
        return Quiz::with(['questions'])->where('is_draft', false)->paginate($perPage);
    }
}
