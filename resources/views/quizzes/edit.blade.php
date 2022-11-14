<x-site-layout>
    <x-page-title title="Edit a Quiz" />
    <div class="card m-auto mt-5 mb-5" style="width: 50rem;">
        <x-form route="{{route('quizzes.update', ['quiz' => $quiz->id])}}" method="PUT" button_name="Edit Quiz">
            @csrf
            <x-form-input-text name="title" :errors="$errors" :value="$quiz['title']" />
        </x-form>
        <ol class="list-group mt-5">
            @foreach($quiz->questions as $question)
                <x-bar :text="$question->content">
                    <x-get-button :route="route('questions.edit', ['quiz' => $quiz->id, 'question' => $question->id])" name="Edit Question" />
                    <x-delete-button :route="route('questions.destroy', ['quiz' => $quiz->id, 'question' => $question->id])" />
                </x-bar>
            @endforeach
            <x-get-button :route="route('questions.create', ['quiz' => $quiz->id])" name="Add new Question" />
        </ol>
        <div class="mt-4">
            <x-get-button route="{{route('quizzes.index')}}" name="Done" />
        </div>
    </div>
</x-site-layout>