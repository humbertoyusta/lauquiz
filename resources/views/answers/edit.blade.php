<x-site-layout>
    <x-page-title title="Edit an Answer" />
    <div class="card m-auto mt-5 mb-5" style="width: 50rem;">
        <x-form :route="route('answers.update', ['answer' => $answer->id])" method="PUT" button_name="Edit Answer">
            <input type="hidden" name="question_id" value="{{$answer->question_id}}" />
            <x-form-input-text name="content" :errors="$errors" value="{{$answer->content}}"></x-form-input-text>
        </x-form>
    </div>
</x-site-layout>