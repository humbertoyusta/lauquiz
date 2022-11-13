@props(['route'])

<form action="{{$route}}" method="POST">
    @method('DELETE')
    @csrf
    <button type="submit" class="btn btn-outline-danger">Delete</button>
</form>