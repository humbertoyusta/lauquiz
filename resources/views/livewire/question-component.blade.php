<div class="card m-auto mt-5 mb-5" style="width: 50rem;">
    <x-form-multipart route="{{route('questions.update', ['quiz' => $question->quiz_id, 'question' => $question->id])}}" method="PUT" button_name="Upload Photo">
        @csrf
        <x-livewire-input-text name="content" :errors="$errors" />
        <x-file-upload name="image" :errors="$errors"></x-file-upload>
    </x-form-multipart>
    <img src="{{$image}}" alt="Question Image" width="300" height="300" class="rounded mx-auto d-block" />
    <ol class="list-group mt-5">
        <x-simple-bar>
            <x-get-button :route="route('answers.create', ['quiz' => $question->quiz_id, 'question' => $question->id])" name="Add new Answer" />
        </x-simple-bar>
        @foreach($question->answers as $answer)
            <livewire:answer-component :answer="$answer" />
        @endforeach
    </ol>
    <div class="mt-4">
        <x-get-button route="{{route('quizzes.edit', ['quiz' => $question->quiz_id])}}" name="Done" />
    </div>
</div>