<x-site-layout :usesLivewire="true">
    <x-page-title title="Edit a Question" />
    <div class="card m-auto mt-5 mb-5" style="width: 50rem;">
        <x-form-multipart route="{{route('questions.update', ['quiz' => $quiz_id, 'question' => $question->id])}}" method="PUT" button_name="Edit Question">
            @csrf
            <x-form-input-text name="content" :errors="$errors" :value="$question['content']" placeholder_extra="" />
            <x-file-upload name="image" :errors="$errors"></x-file-upload>
        </x-form-multipart>
        <img src="{{$question->image}}" alt="Question Image" width="300" height="300" class="rounded mx-auto d-block" />
        <ol class="list-group mt-5">
            <x-simple-bar>
                <x-get-button :route="route('answers.create', ['quiz' => $quiz_id, 'question' => $question->id])" name="Add new Answer" />
            </x-simple-bar>
            @foreach($question->answers as $answer)
                <livewire:answer-component :answer="$answer" />
            @endforeach
        </ol>
        <div class="mt-4">
            <x-get-button route="{{route('quizzes.edit', ['quiz' => $quiz_id])}}" name="Done" />
        </div>
    </div>
</x-site-layout>