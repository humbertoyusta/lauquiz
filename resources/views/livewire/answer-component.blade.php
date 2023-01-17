<div class="list-group-item m-0 p-0 border-1">
    <li class="d-flex justify-content-between align-items-start m-2">
        <div class="ms-2 w-75">
            <x-livewire-input-text name="content" :errors="$errors" />
            <x-livewire-input-boolean name="is_correct" text="Is Correct" :errors="$errors" />
        </div>
        <button wire:click="deleteAnswer" type="button" class="btn btn-outline-danger">Delete</button>
    </li>
<div>