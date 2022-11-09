<li class="list-group-item d-flex justify-content-between align-items-start">
    <div class="ms-2">
        <div class="fw-bold">{{ $quiz['title'] }}</div>
    </div>
    <div class="d-flex justify-content-between" style="width: 10em;">
        <a href="{{ route('quizzes-show', ['id' => $quiz['id']]) }}" method="GET">
            <button type="button" class="btn btn-primary">Edit</button>
        </a>
        <div>
            <form action="{{ route('quizzes-delete', ['id' => $quiz['id']]) }}" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    <div>
</li>