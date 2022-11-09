<x-site-layout>
    <div class="card m-auto mt-5" style="width: 80rem;">
        <div class="card-body">
            <ol class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <a class="btn btn-outline-success">Add new Quiz</a>
                    </div>
                </li>
                @foreach($quizzes as $quiz)
                    <x-quiz :quiz="$quiz"></x-quiz>
                @endforeach
            </ol>
        </div>
    </div>
</x-site-layout>