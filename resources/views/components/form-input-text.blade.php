@props(['name', 'errors', 'value', 'placeholder_extra'])

<div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="{{$name}}" name="{{$name}}" placeholder="{{$name}}" value="{{old($name, $value)}}">
        <label for="{{$name}}">{{ucfirst($name)}} {{$placeholder_extra}}</label>
    </div>
    <x-form-input-error :name="$name" :errors="$errors" />
<div>