@props(['route', 'name'])

<div class="d-flex justify-content-between" style="width: 15em;">
    <a href="{{$route}}" method="GET">
        <button type="button" class="btn btn-outline-primary">{{$name}}</button>
    </a>
<div>