<x-site-layout>
    <x-page-title title="Finished" />
    <div class="card m-auto mt-5 mb-5" style="width: 30rem;">
        <h2 class="m-3">You have completed quiz {{$quiz->title}}</h2>
        <p class="m-3">
            You have answered correctly {{$answeredQuiz->correct_answered_questions_count}} 
            out of {{$answeredQuiz->answered_questions_count}} questions
        </p>
        <div class="m-2">
            <x-get-button :route="route('quizzes.scoreboard', ['quiz' => $quiz->id])" name="See scoreboard"></x-get-button>
        </div>
    </div>
</x-site-layout>