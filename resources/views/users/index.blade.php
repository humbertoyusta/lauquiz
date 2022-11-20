<x-site-layout>
    <x-page-title title="List of Users (Only for admin)" />
    <div class="card m-auto mt-5 mb-5" style="width: 80rem;">
        <h2 class="m-3">Users</h2>
        <div class="card-body">
            <ol class="list-group">
                @foreach($users as $user)
                    <x-bar :text="$user->name.' '.$user->email" extra_text="">
                        <x-delete-button :route="route('users.destroy', ['user' => $user->id])"></x-delete-button>
                    </x-bar>
                @endforeach
            </ol>
        </div>
    </div>
</x-site-layout>