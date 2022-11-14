@props(['name', 'text', 'value'])

<div class="form-check">
  <input class="form-check-input" type="radio" name="{{$name}}" id="{{$name}}" value={{$value}}>
  <label class="form-check-label" for="{{$name}}">
    {{$text}}
  </label>
</div>