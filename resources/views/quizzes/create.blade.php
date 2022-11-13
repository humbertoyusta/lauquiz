<x-site-layout>
    <x-page-title title="Create a Quiz" />
    <div class="card m-auto mt-5" style="width: 30rem;">
        <x-form route="{{route('quizzes.store')}}" method="POST" button_name="Create">
            @csrf
            <x-form-input-text name="title" :errors="$errors" value="" />
        </x-form>
    </div>
</x-site-layout>