<x-site-layout>
    <x-page-title title="Scoreboard" />
    <div class="card m-auto mt-5 mb-5" style="width: 80rem;">
        <h2 class="m-3">Scoreboard</h2>
        <div class="card-body">
            <ol class="list-group">
                @foreach($answeredQuizzes as $answeredQuiz)
                    <x-bar :text="$answeredQuiz->user->name" extra_text="">
                        <p>
                            Solved {{$answeredQuiz->correct_answered_questions_count}} out of 
                            {{$answeredQuiz->answered_questions_count}}
                        </p>
                    </x-bar>
                @endforeach
            </ol>
            {{$answeredQuizzes->links('pagination::bootstrap-5')}}
        </div>
    </div>
</x-site-layout>