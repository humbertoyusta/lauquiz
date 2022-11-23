<x-site-layout>
    <x-page-title title="List of Quizzes" />
    <div class="card m-auto mt-5 mb-5" style="width: 80rem;">
        <h2 class="m-3">Quizzes</h2>
        <div class="card-body">
            @if(session()->has('success_message'))
                <x-alert :message="session()->get('success_message')"></x-alert>
            @endif
            <ol class="list-group">
                <x-simple-bar>
                    <x-get-button :route="route('quizzes.create')" name="Create New Quiz"></x-get-button>
                </x-simple-bar>
                @foreach($quizzes as $quiz)
                    <x-bar :text="$quiz['title']" :extra_text="'Tags: '.$quiz->tags->pluck('name')->implode(', ')">
                        @if($quiz->is_draft)
                            <x-badge text="Draft"></x-badge>
                        @else
                            <x-badge text="Playable"></x-badge>
                        @endif
                        <x-get-button :route="route('quizzes.edit', ['quiz' => $quiz['id']])" name="Edit Quiz" />
                        <x-delete-button :route="route('quizzes.destroy', ['quiz' => $quiz['id']])" />
                    </x-bar>
                @endforeach
            </ol>
            {{$quizzes->links('pagination::bootstrap-5')}}
            <p class="mt-5">
                Draft quizzes can not be played, add at least one question and one correct answer 
                per question to the quiz to make it playable
            </p>
        </div>
    </div>
</x-site-layout>