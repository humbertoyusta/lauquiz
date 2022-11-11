@props(['name', 'errors'])

@error($name)
    <div class="alert alert-danger" role="alert">
        @foreach($errors->get($name) as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@enderror