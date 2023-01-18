@props(['name', 'text'])

<div class="form-check">
  <input wire:model.defer="{{$name}}" class="form-check-input" type="checkbox" name={{$name}} id="{{$name}}" />
  <label for="{{$name}}" class="form-check-label" for="flexCheckDefault">
    {{$text}}
  </label>
</div>
