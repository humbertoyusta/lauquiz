<x-site-layout>
    <x-page-title title="Create a Question" />
    <div class="card m-auto mt-5" style="width: 30rem;">
        <x-form route="{{route('questions.store', ['quiz_id' => $quiz_id])}}" method="POST" button_name="Create">
            @csrf
            <form-input type="hidden" name="quiz_id" value="{{$quiz_id}}" />
            <x-form-input-text name="content" :errors="$errors" value="" />
        </x-form>
    </div>
</x-site-layout>