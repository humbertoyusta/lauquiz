@props(['name', 'text', 'value'])

<div class="form-check">
  <input class="form-check-input" type="checkbox" value="1" name={{$name}} id="{{$name}}" {{ old($name, $value) ? 'checked' : '' }}>
  <label class="form-check-label" for="flexCheckDefault">
    {{$text}}
  </label>
</div>