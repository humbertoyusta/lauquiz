<x-site-layout>
    <div class="card m-auto mt-5" style="width: 50rem;">
        <x-form route="{{route('quizzes.update', ['quiz' => $quiz['id']])}}" method="PUT" button_name="Edit">
            @csrf
            <x-form-input-text name="title" :errors="$errors" :value="$quiz['title']" />
        </x-form>
        <ol class="list-group mt-5">
            @foreach($quiz->questions as $question)
                <x-bar :text="$question->content">
                    <x-get-button :route="route('questions.edit', ['question' => $question['id']])" name="Edit" />
                    <x-delete-button :route="route('questions.destroy', ['question' => $question['id']])" />
                </x-bar>
            @endforeach
            <x-get-button :route="route('questions.create', ['quiz_id' => $quiz['id']])" name="Add new question" />
        </ol>
    </div>
</x-site-layout>