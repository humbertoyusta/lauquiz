<x-site-layout>
    <x-page-title title="Add new Question" />
    <div class="card m-auto mt-5 mb-5" style="width: 30rem;">
        <x-form route="{{route('questions.store', ['quiz' => $quiz_id])}}" method="POST" button_name="Add Question">
            @csrf
            <x-form-input-text name="content" :errors="$errors" value="" placeholder_extra="" />
        </x-form>
    </div>
</x-site-layout>