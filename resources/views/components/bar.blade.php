@props(['text', 'extra_text'])

<div class="list-group-item m-0 p-0 border-1">
    <li class="d-flex justify-content-between align-items-start m-2">
        <div class="ms-2 w-75">
            <div class="fw-bold">{{$text}}</div>
        </div>
        {{$slot}}
    </li>
    <div class="m-2">
        {{$extra_text}}
    </div>
<div>