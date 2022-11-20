<x-site-layout>
    <x-page-title title="List of Quizzes" />
    <div class="card m-auto mt-5 mb-5" style="width: 80rem;">
        <h2 class="m-3">Quizzes</h2>
        <div class="card-body">
            <ol class="list-group">
                @foreach($quizzes as $quiz)
                    <x-bar :text="$quiz['title']" :extra_text="'Tags: '.$quiz->tags->pluck('name')->implode(', ')">
                        <x-get-button :route="route('play.questions.show', ['quiz' => $quiz->id, 'question' => $quiz->questions->first()->id])" name="Play Quiz" />
                    </x-bar>
                @endforeach
            </ol>
            {{$quizzes->links('pagination::bootstrap-5')}}
        </div>
    </div>
</x-site-layout>