<x-site-layout>
    <x-page-title title="List of Quizzes" />
    <div class="card m-auto mt-5 mb-5" style="width: 80rem;">
        <h2 class="m-3">Quizzes</h2>
        <div class="card-body">
            <ol class="list-group">
                @foreach($quizzes as $quiz)
                    <x-bar :text="$quiz['title']">
                        <x-get-button :route="route('quizzes.edit', ['quiz' => $quiz['id']])" name="Edit" />
                        <x-delete-button :route="route('quizzes.destroy', ['quiz' => $quiz['id']])" />
                    </x-bar>
                @endforeach
            </ol>
        </div>
    </div>
</x-site-layout>