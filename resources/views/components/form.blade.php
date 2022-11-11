@props(['route', 'method'])

<form action="{{$route}}" method="{{$method}}" class="m-4">
    @method($method)
    @csrf

    {{$slot}}
    
    <button type="submit" class="btn btn-outline-primary">
        Create
    </button>
</form>