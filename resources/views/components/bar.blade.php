@props(['text'])

<li class="list-group-item d-flex justify-content-between align-items-start">
    <div class="ms-2">
        <div class="fw-bold">{{$text}}</div>
    </div>
    {{$slot}}
</li>