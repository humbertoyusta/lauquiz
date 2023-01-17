<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionsService extends AbstractService
{
    public function __construct()
    {
        parent::__construct(
            '\App\Models\Question',
            [
                'content' => 'required',
                'quiz_id' => 'required|integer|min:1',
            ],
        );
    }

    /**
     * Custom saving method for Questions
     * Use AbstractService->save and save image if sent
     */
    public function save(Request $request, int $id = 0)
    {
        // If it is update, check if logged in user has access to update
        if ($id && ! Question::findOrFail($id)->canBeEditedBy()) {
            abort(403);
        }

        // Actually creating or updating the Question
        $question = parent::save($request, $id);

        // Handling the image
        if ($request->has('image')) {
            $question
                ->clearMediaCollection();

            $question
                ->addMediaFromRequest('image')
                ->usingFileName($request->file('image')->hashName())
                ->toMediaCollection();
        }

        return $question;
    }

    /**
     * Get questions with answers loaded and image link
     * in $question->image
     */
    public function getQuestionWithAnswersAndImage(int $id)
    {
        $question = $this->getQuestionWithAnswers($id);

        if ($question->getMedia()->first()) {
            $question->image = $question->media->first()->getUrl('display');
        } else {
            $question->image = '/images/question-mark.png';
        }

        return $question;
    }

    /**
     * Get questions with answers loaded
     */
    public function getQuestionWithAnswers(int $id)
    {
        return Question::where('id', $id)->with('answers')->first();
    }

    /**
     * Get first question form Quiz $quizId with and ID greater than $questionId
     */
    public function getNextQuestionWithAnswers(int $quizId, int $questionId)
    {
        return Question::where('quiz_id', $quizId)->where('id', '>', $questionId)->with('answers')->orderBy('id')->first();
    }

    public function getImageFromQuestion(Question $question) 
    {
        if ($question->getMedia()->first()) {
            return $question->media->first()->getUrl('display');
        } else {
            return '/images/question-mark.png';
        }
    }
}
