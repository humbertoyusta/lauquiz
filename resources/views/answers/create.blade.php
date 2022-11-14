<x-site-layout>
    <x-page-title title="Add new Answer" />
    <div class="card m-auto mt-5 mb-5" style="width: 50rem;">
        <x-form :route="route('answers.store', ['quiz' => $quiz_id, 'question' => $question_id])" method="POST" button_name="Add Answer">
            @csrf
            <x-form-input-text name="content" :errors="$errors" value=""></x-form-input-text>
        </x-form>
    </div>
</x-site-layout>