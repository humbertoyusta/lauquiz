@props(['name', 'text', 'value'])

<div class="form-check">
  <input class="form-check-input" type="checkbox" value="1" name={{$name}} id="{{$name}}" {{ old('is_featured') ? 'checked="checked"' : '' }}>
  <label class="form-check-label" for="flexCheckDefault">
    {{$text}}
  </label>
</div>