@props(['name', 'errors'])

<div>
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="{{$name}}" name="{{$name}}" placeholder="{{$name}}">
        <label for="{{$name}}">{{ucfirst($name)}}</label>
    </div>
    <x-form-input-error :name="$name" :errors="$errors" />
<div>