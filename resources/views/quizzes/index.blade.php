<x-site-layout>
    <div class="card m-auto mt-5" style="width: 80rem;">
        <h2 class="m-3">Quizzes</h2>
        <div class="card-body">
            <ol class="list-group">
                @foreach($quizzes as $quiz)
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2">
                            <div class="fw-bold">{{ $quiz['title'] }}</div>
                        </div>
                        <div class="d-flex justify-content-between" style="width: 10em;">
                            <a href="{{ route('quizzes.show', ['quiz' => $quiz['id']]) }}" method="GET">
                                <button type="button" class="btn btn-outline-primary">Edit</button>
                            </a>
                            <div>
                                <form action="{{ route('quizzes.destroy', ['quiz' => $quiz['id']]) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                                </form>
                            </div>
                        <div>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</x-site-layout>