@props(['name', 'errors'])

<div class="mb-3">
    <label for="formFile" class="form-label">Upload {{$name}}</label>
    <input class="form-control" type="file" id="{{$name}}" name="{{$name}}">
    <x-form-input-error :name="$name" :errors="$errors" />
</div>