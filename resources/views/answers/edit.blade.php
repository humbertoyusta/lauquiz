<x-site-layout>
    <x-page-title title="Edit a Question" />
    <div class="card m-auto mt-5 mb-5" style="width: 50rem;">
        <x-form :route="route('answers.update', ['answer' => $answer->id])" method="PUT" button_name="Edit Answer">
            <x-form-input-text name="content" :errors="$errors" value="{{$answer->content}}"></x-form-input-text>
        </x-form>
    </div>
</x-site-layout>