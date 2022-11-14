<x-site-layout>
    <x-page-title title="Edit an Answer" />
    <div class="card m-auto mt-5 mb-5" style="width: 50rem;">
        <x-form :route="route('answers.update', ['quiz' => $quiz_id, 'question' => $question_id, 'answer' => $answer->id])" method="PUT" button_name="Edit Answer">
            <x-form-input-text name="content" :errors="$errors" value="{{$answer->content}}"></x-form-input-text>
            <x-form-input-boolean name="is_correct" value="{{$answer->is_correct}}" text="Is Correct" />
        </x-form>
    </div>
</x-site-layout>