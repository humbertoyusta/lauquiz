<x-site-layout>
    <x-page-title title="List of Quizzes" />
    <div class="card m-auto mt-5 mb-5" style="width: 80rem;">
        <h2 class="m-3">Quizzes</h2>
        <div class="card-body">
            <ol class="list-group">
                @foreach($quizzes as $quiz)
                    @if (count($quiz->questions))
                        <x-bar :text="$quiz['title']">
                            <x-get-button :route="route('play.questions.show', ['quiz' => $quiz->id, 'question' => $quiz->questions->first()->id])" name="Play Quiz" />
                        </x-bar>
                    @endif
                @endforeach
            </ol>
            {{$quizzes->links('pagination::bootstrap-5')}}
        </div>
    </div>
</x-site-layout>