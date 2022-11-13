<x-site-layout>
    <x-page-title title="Edit a Question" />
    <div class="card m-auto mt-5 mb-5" style="width: 50rem;">
        <x-form route="{{route('questions.update', ['question' => $question['id']])}}" method="PUT" button_name="Edit">
            @csrf
            <x-form-input-text name="content" :errors="$errors" :value="$question['content']" />
        </x-form>
        <div class="mt-4">
            <x-get-button route="{{route('quizzes.edit', ['quiz' => $question['quiz_id']])}}" name="Done" />
        </div>
    </div>
</x-site-layout>