<x-site-layout>
    <div class="card m-auto mt-5" style="width: 50rem;">
        <x-form route="{{route('quizzes.update', ['quiz' => $quiz['id']])}}" method="PUT" button_name="Edit">
            @csrf
            <x-form-input-text name="title" :errors="$errors" :value="$quiz['title']" />
        </x-form>
    </div>
</x-site-layout>