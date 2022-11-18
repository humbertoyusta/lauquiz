@props(['route', 'method', 'button_name'])

<div>
    <form action="{{$route}}" method="POST" class="m-4" enctype="multipart/form-data">
        @method($method)
        @csrf

        {{$slot}}

        <button type="submit" class="btn btn-outline-primary">
            {{$button_name}}
        </button>
    </form>
</div>