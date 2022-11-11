<x-site-layout>
    <div class="card m-auto mt-5" style="width: 80rem;">
        <h2 class="m-3">Quizzes</h2>
        <div class="card-body">
            <ol class="list-group">
                @foreach($quizzes as $quiz)
                    <x-bar :text="$quiz['title']">
                        <x-get-button :route="route('quizzes.edit', ['quiz' => $quiz['id']])" name="Edit" />
                        <x-delete-button :route="route('quizzes.destroy', ['quiz' => $quiz['id']])" />
                    </x-bar>
                @endforeach
            </ol>
        </div>
    </div>

    @if($alertMessage)
        <div class="alert alert-success fixed-bottom m-5" role="alert">
            {{$alertMessage}}
        </div>
    @endif
</x-site-layout>