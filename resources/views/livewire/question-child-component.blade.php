@props(['question'])

<li class="list-group-item m-0 p-0 border-1">
    <div class="d-flex justify-content-between align-items-start m-2">
        <div class="ms-2 w-75">
            <p>{{$question->content}}</p>
        </div>
        <x-get-button :route="route('questions.edit', ['quiz' => $question->quiz_id, 'question' => $question->id])" name="Edit Question" />
        <x-livewire-delete-button name="Delete" method="delete" />
    </div>
</li>
