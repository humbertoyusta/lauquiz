<div class="card m-auto mt-5 mb-5" style="width: 50rem;">
    <div class="m-4">
            <x-livewire-input-text name="content" :errors="$errors" />
            <input type="file" wire:model="image" />
            <x-livewire-button method="update" name="Apply Update" />
    </div>
    <img src="{{$question->getImage()}}" alt="Question Image" width="300" height="300" class="rounded mt-5 mx-auto d-block" />
    <ol class="list-group mt-5">
        <x-simple-bar>
            <x-get-button :route="route('answers.create', ['quiz' => $question->quiz_id, 'question' => $question->id])" name="Add new Answer" />
        </x-simple-bar>
        @foreach($question->answers as $answer)
            <livewire:answer-child-component :answer="$answer" wire:key="{{$answer->id}}" />
        @endforeach
    </ol>
    <div class="mt-4">
        <x-get-button route="{{route('quizzes.edit', ['quiz' => $question->quiz_id])}}" name="Done" />
    </div>
</div>
