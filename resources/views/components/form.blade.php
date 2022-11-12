@props(['route', 'method', 'button_name'])

<form action="{{$route}}" method="POST" class="m-4">
    @method($method)
    @csrf

    {{$slot}}

    <button type="submit" class="btn btn-outline-primary">
        {{$button_name}}
    </button>
</form>