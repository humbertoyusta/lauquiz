<x-site-layout>
    <x-page-title title="Edit a Question" />
    <div class="card m-auto mt-5 mb-5" style="width: 50rem;">
        <x-form route="{{route('questions.update', ['quiz' => $quiz_id, 'question' => $question->id])}}" method="PUT" button_name="Edit Question">
            @csrf
            <x-form-input-text name="content" :errors="$errors" :value="$question['content']" />
        </x-form>
        <ol class="list-group mt-5">
            @foreach($question->answers as $answer)
                <x-bar :text="$answer->content">
                        <x-get-button :route="route('answers.edit', ['quiz' => $quiz_id, 'question' => $question->id, 'answer' => $answer->id])" name="Edit Answer" />
                        <x-delete-button :route="route('answers.destroy', ['quiz' => $quiz_id, 'question' => $question->id, 'answer' => $answer->id])" />
                </x-bar>
            @endforeach
            <x-get-button :route="route('answers.create', ['quiz' => $quiz_id, 'question' => $question->id])" name="Add new Answer" />
        </ol>
        <div class="mt-4">
            <x-get-button route="{{route('quizzes.edit', ['quiz' => $quiz_id])}}" name="Done" />
        </div>
    </div>
</x-site-layout>