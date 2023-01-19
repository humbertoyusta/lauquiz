@props(['name', 'errors', 'placeholder_extra' => ''])

<div>
    <div class="form-floating mb-3">
        <input wire:model.defer="{{$name}}" type="text" class="form-control" id="{{$name}}" name="{{$name}}" placeholder="{{$name}}">
        <label for="{{$name}}">{{ucfirst($name)}} {{$placeholder_extra}}</label>
    </div>
    <x-form-input-error :name="$name" :errors="$errors" />
<div>
