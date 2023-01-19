<div class="card m-auto mt-5 mb-5" style="width: 50rem;">
    <div class="m-4">
        <x-livewire-input-text name="title" :errors="$errors" />
        <x-livewire-input-text name="tags" placeholder_extra="(Comma separated)" :errors="$errors" />
        <x-livewire-button method="update" name="Apply Update" />
    </div>
    <ol class="list-group mt-5">
        <x-simple-bar>
            <x-get-button :route="route('questions.create', ['quiz' => $quiz->id])" name="Add new Question" />
        </x-simple-bar>
        @foreach($quiz->questions as $question)
            <livewire:question-child-component :question="$question" :wire:key="$question->id"></livewire:question-child-component>
        @endforeach
    </ol>
    <div class="mt-4">
        <x-get-button route="{{route('quizzes.index')}}" name="Done" />
    </div>
</div>
