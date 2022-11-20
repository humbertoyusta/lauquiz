<x-site-layout>
    <x-page-title title="Add new Answer" />
    <div class="card m-auto mt-5 mb-5" style="width: 50rem;">
        <x-form :route="route('answers.store', ['quiz' => $quiz_id, 'question' => $question_id])" method="POST" button_name="Add Answer">
            @csrf
            <x-form-input-text name="content" :errors="$errors" value="" placeholder_extra=""></x-form-input-text>
            <x-form-input-boolean name="is_correct" value="" text="Is Correct"></x-form-input-boolean>
        </x-form>
    </div>
</x-site-layout>