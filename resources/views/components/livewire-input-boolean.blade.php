@props(['name', 'text'])

<div class="form-check">
  <input wire:model="{{$name}}" class="form-check-input" type="checkbox" name={{$name}} id="{{$name}}">
  <label class="form-check-label" for="flexCheckDefault">
    {{$text}}
  </label>
</div>