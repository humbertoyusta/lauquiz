@props(['name', 'method'])

<button type="button" class="btn btn-outline-danger" wire:click="{{$method}}">{{$name}}</button>
