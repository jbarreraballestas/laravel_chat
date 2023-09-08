<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @foreach (\App\Models\User::all() as $user)
                    <a href="{{route('chat.show', $user->id)}}" target="_blank">{{$user->name}}</a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
