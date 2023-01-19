@props(['name', 'method'])

<button type="button" class="btn btn-outline-primary" wire:click="{{$method}}">{{$name}}</button>
