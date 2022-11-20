<x-site-layout>
    <x-page-title title="Create a Quiz" />
    <div class="card m-auto mt-5 mb-5" style="width: 30rem;">
        <x-form route="{{route('quizzes.store')}}" method="POST" button_name="Create Quiz">
            @csrf
            <x-form-input-text name="title" :errors="$errors" value="" placeholder_extra="" />
            <x-form-input-text name="tags" placeholderl="commaseparated" :errors="$errors" value="" placeholder_extra="(comma separated)" />
        </x-form>
    </div>
</x-site-layout>