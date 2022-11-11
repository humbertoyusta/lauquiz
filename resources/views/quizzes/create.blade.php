<x-site-layout>
    <div class="card m-auto mt-5" style="width: 30rem;">
        <form action="{{ route('quizzes.store') }}" method="POST" class="m-4">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="title" name="title" placeholder="title">
                <label for="title">Title</label>
            </div>
            @error('title')
                <div class="alert alert-danger" role="alert">
                    @foreach($errors->get('title') as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @enderror
            <button type="submit" class="btn btn-outline-primary">
                Create
            </button>
        </form>
    </div>
</x-site-layout>