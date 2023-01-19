<li class="list-group-item m-0 p-0 border-1">
    <div class="d-flex justify-content-between align-items-start m-2">
        <div class="ms-2 w-75">
            <x-livewire-input-text name="content" :errors="$errors" />
            <x-livewire-input-boolean name="is_correct" text="Is Correct" :errors="$errors" />
        </div>
        <x-livewire-button name="Apply Update" method="update" />
        <x-livewire-delete-button name="Delete" method="delete" />
    </div>
</li>
